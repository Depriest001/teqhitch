<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Models\Subscriber;
use App\Models\NewsletterLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\NewsletterMailable;

class NewslettersController extends Controller
{
    /**
     * Display a listing of newsletters.
     */
    public function index()
    {
        $newsletters = Newsletter::latest()->paginate(10);
        return view('admin.newsletter.index', compact('newsletters'));
    }

    /**
     * Show the form for creating a new newsletter.
     */
    public function create()
    {
        return view('admin.newsletter.create');
    }

    /**
     * Store a newly created newsletter in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject'   => 'required|string|max:255',
            'url'       => 'nullable|string|max:255',
            'url_text'  => 'nullable|string|max:255',
            'content'   => 'required|string',
            'status'    => 'required|in:draft,scheduled',
            'send_at'   => 'required_if:status,scheduled|nullable|date|after:now',
        ]);

        $newsletter = Newsletter::create([
            'subject'  => $request->subject,
            'url'      => $request->url,
            'url_text' => $request->url_text,
            'content'  => $request->content,
            'status'   => $request->status,
            'send_at'  => $request->send_at,
        ]);

        // Optionally, you can queue logs now or when sending
        return redirect()->route('admin.newsletter.index')
                         ->with('success', 'Newsletter created successfully.');
    }

    /**
     * Display the specified newsletter.
     */
    public function show(Newsletter $newsletter)
    {
        return view('admin.newsletter.show', compact('newsletter'));
    }

    /**
     * Show the form for editing the newsletter.
     */
    public function edit(Newsletter $newsletter)
    {
        return view('admin.newsletter.edit', compact('newsletter'));
    }

    /**
     * Update the newsletter in storage.
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'url'       => 'nullable|string|max:255',
            'url_text'  => 'nullable|string|max:255',
            'content' => 'required|string',
            'status'    => 'required|in:draft,scheduled,sending,completed',
            'send_at'   => 'required_if:status,scheduled|nullable|date|after:now',
        ]);

        $newsletter->update([
            'subject'  => $request->subject,
            'url'      => $request->url,
            'url_text' => $request->url_text,
            'content'  => $request->content,
            'status'   => $request->status,
            'send_at'  => $request->send_at,
        ]);

        return redirect()->route('admin.newsletter.index')
                         ->with('success', 'Newsletter updated successfully.');
    }

    /**
     * Remove the newsletter from storage.
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return redirect()->route('admin.newsletter.index')
                         ->with('success', 'Newsletter deleted successfully.');
    }

    /**
     * Trigger sending newsletter (optional manual trigger).
     */
    public function send(Newsletter $newsletter)
    {
        if ($newsletter->status !== 'draft') {
            return redirect()->back()->with('error', 'Newsletter already sent or in progress.');
        }

        // Fetch all active subscribers
        $subscribers = Subscriber::where('is_active', true)->get();
        if ($subscribers === 0) {
            return redirect()->back()->with('error', 'No active subscribers to send the newsletter to');
        }
        $failedCount = 0;
        $chunkSize = 50;
        $delaySeconds = 5;

        foreach ($subscribers->chunk($chunkSize) as $chunk) {
            foreach ($chunk as $subscriber) {
                // Avoid duplicate log entries
                $log = NewsletterLog::firstOrCreate(
                    [
                        'subscriber_id' => $subscriber->id,
                    ],
                    [
                        'newsletter_id' => $newsletter->id,
                        'status' => 'pending',
                    ]
                );

                try {
                    $unsubscribeUrl = URL::temporarySignedRoute(
                        'subscriber.unsubscribe',
                        now()->addDays(7),
                        ['email' => $subscriber->email]
                    );
                    // Send the email
                    Mail::to($subscriber->email)->send(new NewsletterMailable($newsletter, $unsubscribeUrl));

                    // Update log status
                    $log->update([
                        'status' => 'sent',
                        'sent_at' => now()
                    ]);
                } catch (\Exception $e) {
                    $failedCount++;
                    // Update log status if sending fails
                    $log->update([
                        'status' => 'failed',
                        'error' => $e->getMessage(),
                    ]);
                    \Log::error("Failed sending to {$subscriber->email}: " . $e->getMessage());
                    $this->error("Failed to send to: {$subscriber->email} ({$e->getMessage()})");
                }
            }
            sleep($delaySeconds); // prevent server overload
        }

        // Final status
        $newsletter->update([
            'status' => $failedCount === 0 ? 'completed' : 'sending'
        ]);

        return redirect()->route('admin.newsletter.index')
                         ->with('success', 'Newsletter queued for sending.');
    }
}