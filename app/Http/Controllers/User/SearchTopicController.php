<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\UserTopic;
use App\Models\TopicGeneration;
use App\Models\TopicPaymentSetting;
use App\Models\TopicPayment;
use App\Models\Paper;
use App\Models\TopicDowload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchTopicController extends Controller
{
    /**
     * Show generator page with previous results
     */
    public function index()
    {
        $user = Auth::user();

        $userTopics = UserTopic::with('topic')
            ->where('user_id', $user->id)
            ->where('status', 'generated')
            ->latest()
            ->get();

        $submittedTopics = UserTopic::with('topic')
            ->where('user_id', $user->id)
            ->whereIn('status', ['submitted', 'approved'])
            ->latest()
            ->get();

        return view('user.searchTopics.index', compact('userTopics','submittedTopics'));
    }

    public function show($id)
    {
        $topic = UserTopic::with(['topic.paper'])
                    ->where('user_id', auth()->id())
                    ->findOrFail($id);

        // Get correct payment setting based on paper type
        $paymentSetting = TopicPaymentSetting::where('slug', 
            $topic->topic->paper_type . '_writing_fee'
        )->first();

        return view('user.searchTopics.show', compact('topic', 'paymentSetting'));
    }

    public function create()
    {
        $generationCount = TopicGeneration::where('user_id', Auth::id())->count();
        $remaining = max(0, 3 - $generationCount);

        return view('user.searchTopics.create', compact('generationCount', 'remaining'));
    }

    /**
     * Generate new topics based on user selection
     */
    public function generate(Request $request)
    {
        $request->validate([
            'department' => 'required|string',
            'type' => 'required|in:seminar,project',
            'level' => 'required|in:BSc,MSc,PhD',
            'keyword' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Count generation attempts
        $generationCount = TopicGeneration::where('user_id', $user->id)->count();

        // If more than 3 attempts → Redirect to payment
        if ($generationCount >= 3) {
            return redirect()->route('user.payment.show', [
                'slug' => 'topic_generation_fee'
            ]);
        }

        // Fetch 3 random topics
        $topics = Topic::where('status', 'active')
            ->where('paper_type', $request->type)
            ->where('academic_level', $request->level)
            ->where('department', 'like', '%' . $request->department . '%')
            ->when($request->keyword, function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%');
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

        if ($topics->isEmpty()) {
            return back()->with('error', 'No topics found.');
        }

        // Record this generation attempt
        TopicGeneration::create([
            'user_id' => $user->id,
            'generated_at' => now(),
        ]);

        return back()
            ->with('success', 'Topics generated successfully.')
            ->with('generatedTopics', $topics);
    }

    public function topicShow(Request $request, $slug, $user_topic_id = null)
    {
        $paymentSetting = TopicPaymentSetting::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        return view('user.searchTopics.pay', [
            'paymentSetting' => $paymentSetting,
            'userTopicId' => $user_topic_id
        ]);
    }

    public function initialize(Request $request, $slug)
    {
        $request->validate([
            'user_topic_id' => 'nullable|exists:user_topics,id'
        ]);
        
        $user = auth()->user();

        $paymentSetting = TopicPaymentSetting::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        // Generate unique tx_ref
        do {
            $tx_ref = "Tx" . Str::uuid()->getHex();
        } while (TopicPayment::where('reference', $tx_ref)->exists());
        
        // Calculate fee on server
        $flutterwaveFee = ($paymentSetting->amount * 0.014) + 50;
        $totalAmount = round($paymentSetting->amount + $flutterwaveFee, 2);

        TopicPayment::create([
            'user_id' => $user->id,
            'payment_type' => $paymentSetting->slug,
            'amount' => $paymentSetting->amount,
            'reference' => $tx_ref,
            'status' => 'pending',
            'user_topic_id' => $request->user_topic_id,
        ]);

        return response()->json([
            'tx_ref' => $tx_ref,
            'amount' => $totalAmount,
        ]);
    }

    public function useTopic(Request $request)
    {
        $request->validate([
            'topics' => 'required|array',
            'topics.*' => 'exists:topics,id'
        ]);

        // Create a batch ID
        $batchId = Str::uuid();

        foreach ($request->topics as $topicId) {
            UserTopic::firstOrCreate([
                'user_id' => Auth::id(),
                'topic_id' => $topicId,
                'generation_batch_id' => $batchId,
            ]);
        }

        return redirect()->route('user.searchTopics.index')
                        ->with('success', 'Topics saved successfully.');
    }

    /**
     * Approve one selected topic
     */
    public function submitTopic(Request $request)
    {
        $request->validate([
            'approved_topic' => 'required|exists:user_topics,id',
        ]);

        $user = Auth::user();

        // Get selected topic
        $userTopic = UserTopic::where('id', $request->approved_topic)
                        ->where('user_id', $user->id)
                        ->firstOrFail();

        $batchId = $userTopic->generation_batch_id;

        // Reject others in same batch
        UserTopic::where('user_id', $user->id)
            ->where('generation_batch_id', $batchId)
            ->where('id', '!=', $userTopic->id)
            ->update(['status' => 'rejected']);

        // Approve selected topic
        $userTopic->status = 'submitted';
        $userTopic->submitted_at = now();
        $userTopic->save();

        return back()->with('success', 'Topic approved successfully.');
    }

    public function webhook(Request $request)
    {
        $secretHash = config('services.flutterwave.webhook_secret');
        // \Log::info('WEBHOOK RECEIVED', $request->all());

        if ($request->header('verif-hash') !== $secretHash) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $payload = $request->all();

        if (($payload['event'] ?? null) !== 'charge.completed') {
            return response()->json(['message' => 'Event ignored']);
        }

        $data = $payload['data'] ?? null;

        if (!$data || $data['status'] !== 'successful') {
            return response()->json(['message' => 'Payment not successful']);
        }

        $tx_ref = $data['tx_ref'];

        DB::transaction(function () use ($tx_ref, $data) {

            $payment = TopicPayment::where('reference', $tx_ref)
                ->lockForUpdate()
                ->first();

            if (!$payment) {
                return;
            }

            // Idempotency check
            if ($payment->status === 'successful') {
                return;
            }

            $payment->update([
                'status' => 'success',
                'meta'   => $data
            ]);

            $user = $payment->user;

            if (!$user) {
                return;
            }

            if ($payment->payment_type === 'topic_generation_fee') {
                // Reset topic generation
                TopicGeneration::where('user_id', $user->id)->delete();

            } else {
                if ($payment->user_topic_id) {
                    $paper = Paper::where('topic_id', $payment->user_topic_id)
                        ->first();

                    UserTopic::where('id', $payment->user_topic_id)
                        ->where('user_id', $user->id)
                        ->update([
                            'status' => 'approved',
                            'payment_status' => 1,
                            'approved_at' => now()
                        ]);
                    TopicDowload::create([
                        'user_id' => $user->id,
                        'paper_id' => $paper->id,
                        'downloaded_at' => now()
                    ]);
                }
            }
        });

        return response()->json(['message' => 'Webhook processed']);
    }

    public function check()
    {
        $payment = TopicPayment::where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$payment) {
            return response()->json(['status' => 'pending']);
        }

        return response()->json([
            'status' => match ($payment->status) {
                'success' => 'success',
                'failed'  => 'failed',
                default   => 'pending',
            }
        ]);
    }
    
}
