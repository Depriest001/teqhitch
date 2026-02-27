<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\ModuleProgress;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['course', 'moduleProgress.module'])
            ->where('student_id', Auth::id())
            ->get()
            ->map(function ($enrollment) {

                $totalModules = $enrollment->course->modules->count();

                $completedModules = ModuleProgress::where('enrollment_id', $enrollment->id)
                    ->where('status', 'completed')
                    ->count();

                $progress = $totalModules > 0
                    ? round(($completedModules / $totalModules) * 100)
                    : 0;

                $enrollment->progress = $progress;

                return $enrollment;
            });

        return view('user.course.index', compact('enrollments'));
    }

    public function view()
    {
        // Get all active courses (assuming status 'active')
        $courses = Course::where('status', 'published')->get();

        return view('user.course.view', compact('courses'));
    }

    public function buyCourse(Course $course)
    {
        $student = auth()->user();

        // Check if already enrolled
        if ($course->students()->where('users.id', $student->id)->exists()) {
            return redirect()->back()->with('info', 'You are already enrolled in this course.');
        }

        do {
            $tx_ref = "Tx" . Str::uuid()->getHex();
        } while (Payment::where('reference', $tx_ref)->exists());

        // Retry-safe payment creation
        $payment = Payment::updateOrCreate(
            [
                'student_id' => $student->id,
                'course_id'  => $course->id,
            ],
            [
                'amount'     => $course->price,
                'currency'   => 'NGN',
                'reference'  => $tx_ref,
                'status'     => 'pending',
            ]
        );

        return view('user.course.buy_course', compact('course', 'student', 'tx_ref'));
    }
    
    public function callback(Request $request)
    {
        $transaction_id = $request->query('transaction_id');
        $tx_ref = $request->query('tx_ref');

        if (!$transaction_id || !$tx_ref) {
            return redirect()->route('user.payment.failed')
                ->with('error', 'Missing transaction details.');
        }

        $payment = Payment::where('reference', $tx_ref)->first();

        // Verify with Flutterwave API
        $response = Http::withToken(config('services.flutterwave.secret_key'))
            ->get("https://api.flutterwave.com/v3/transactions/{$transaction_id}/verify");

        $data = $response->json();

        if (!isset($data['data']['status'])) {
            $payment->update(['status' => 'failed']);
            return redirect()->route('user.payment.failed')
                ->with('error', 'Payment verification failed.');
        }

        $flutterwaveStatus = $data['data']['status']; // 'successful', 'pending', 'failed'

        if ($flutterwaveStatus === 'successful') {
            // Payment succeeded immediately
            $payment->update([
                'status'  => 'success',
                'meta'    => $data['data'],
                'paid_at' => now(),
            ]);

            Enrollment::updateOrCreate(
                [
                    'student_id' => $payment->student_id,
                    'course_id'  => $payment->course_id,
                ],
                [
                    'status'      => 'active',
                    'enrolled_at' => now(),
                ]
            );

            return redirect()->route('user.courses.index')
                ->with('success', 'Payment successful! You are now enrolled.');
        } elseif ($flutterwaveStatus === 'pending') {
            // Bank transfer / USSD pending
            $payment->update([
                'status' => 'pending',
                'meta'   => $data['data'],
            ]);

            return redirect()->route('user.courses.index')
                ->with('success', 'Payment is pending. Please complete the transfer and wait for confirmation.');
        } else {
            // Payment failed
            $payment->update(['status' => 'failed']);
            return redirect()->route('user.payment.failed')
                ->with('error', 'Payment verification failed.');
        }
    }

    public function paymentWebhook(Request $request)
    {
        $data = $request->all(); // all JSON data sent by Flutterwave

        $tx_ref = $data['tx_ref'] ?? null; // your reference
        if (!$tx_ref) {
            return response()->json(['status' => 'error', 'message' => 'Missing tx_ref'], 400);
        }

        // Find the payment in your database
        $payment = Payment::where('reference', $tx_ref)->first();
        if (!$payment) {
            return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
        }

        // Check payment status sent by Flutterwave
        $status = $data['status'] ?? null;

        if ($status === 'successful') {
            // 1️⃣ Update payment
            $payment->update([
                'status'  => 'successful',
                'meta'    => $data, // save full Flutterwave response
                'paid_at' => now(),
            ]);

            // 2️⃣ Enroll student
            Enrollment::updateOrCreate(
                [
                    'student_id' => $payment->student_id,
                    'course_id'  => $payment->course_id,
                ],
                [
                    'status'      => 'active',
                    'enrolled_at' => now(),
                ]
            );
        } elseif ($status === 'failed') {
            $payment->update(['status' => 'failed']);
        } elseif ($status === 'pending') {
            $payment->update(['status' => 'pending']);
        }

        return response()->json(['status' => 'success']);
    }

    public function failed()
    {
        return view('user.paymentfailed');
    }

    // public function show(Request $request, $courseId)
    // {
    //     $enrollment = Enrollment::where('student_id', auth()->id())
    //         ->where('course_id', $courseId)
    //         ->with(['course.modules', 'moduleProgress'])
    //         ->firstOrFail();

    //     $course = $enrollment->course;
    //     $modules = $course->modules;

    //     // Progress
    //     $totalModules = $modules->count();
    //     $completedModules = $enrollment->moduleProgress
    //         ->where('status', 'completed')
    //         ->count();

    //     $progress = $totalModules > 0
    //         ? round(($completedModules / $totalModules) * 100)
    //         : 0;

    //     // 🔥 Module selection logic
    //     $moduleId = $request->query('module');

    //     if ($moduleId && $modules->contains('id', $moduleId)) {
    //         $currentModule = $modules->firstWhere('id', $moduleId);
    //     } else {
    //         // Resume in-progress module OR first module
    //         $currentModule =
    //             $modules->firstWhere('id',
    //                 optional(
    //                     $enrollment->moduleProgress
    //                         ->where('status', 'in_progress')
    //                         ->first()
    //                 )->module_id
    //             )
    //             ?? $modules->first();
    //     }

    //     // ✅ Add this safety check
    //     if (!$currentModule) {
    //         return back()->with('error', 'This course has no modules yet.');
    //     }
    //     return view('user.course.show', compact(
    //         'course',
    //         'modules',
    //         'enrollment',
    //         'progress',
    //         'currentModule'
    //     ));
    // }
    public function show(Request $request, Course $course)
    {
        $user = auth()->user();

        // Ensure user is enrolled
        $enrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->with([
                'moduleProgress',
                'course.modules' => fn ($q) => $q->orderBy('position')
            ])
            ->first();

        if (!$enrollment) {
            return redirect()
                ->route('user.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }

        $modules = $course->modules;

        if ($modules->isEmpty()) {
            return back()->with('error', 'This course has no modules yet.');
        }

        // Progress calculation
        $total = $modules->count();
        $completed = $enrollment->moduleProgress
            ->where('status', 'completed')
            ->count();

        $progress = round(($completed / $total) * 100);

        $currentModule = $this->resolveCurrentModule($request, $modules, $enrollment);

        return view('user.course.show', compact(
            'course',
            'modules',
            'enrollment',
            'progress',
            'currentModule'
        ));
    }
}

