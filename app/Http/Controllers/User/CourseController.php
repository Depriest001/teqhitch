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
        $userId = auth()->id();

        $enrollments = Enrollment::with([
            'course.modules.assignments',   // eager load assignments via modules
            'moduleProgress.module'
        ])
        ->where('student_id', $userId)
        ->get()
        ->map(function ($enrollment) use ($userId) {

            $courseModules = $enrollment->course->modules;

            // Total modules in the course
            $totalModules = $courseModules->count();

            // Completed modules for this enrollment
            $completedModules = $enrollment->moduleProgress->where('status', 'completed')->count();

            $allModulesCompleted = $totalModules > 0 ? $completedModules === $totalModules : false;

            // Assignments via modules
            $assignments = $courseModules->flatMap(fn($module) => $module->assignments);

            $allAssignmentsGraded = $assignments->count() > 0
                ? $assignments->every(function ($assignment) use ($userId) {
                    return $assignment->submissions
                        ->where('student_id', $userId)
                        ->whereNotNull('graded_at')
                        ->isNotEmpty();
                })
                : false; // ✅ if no assignments → NOT complete

            // Only mark complete if there’s at least one module or assignment
            // $enrollment->isComplete = ($totalModules > 0 || $assignments->count() > 0)
            //     && $allModulesCompleted
            //     && $allAssignmentsGraded;
            // $enrollment->isComplete =
            //     $totalModules > 0 &&
            //     $assignments->count() > 0 &&
            //     $allModulesCompleted &&
            //     $allAssignmentsGraded;

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

        return view('user.course.buy_course', compact('course', 'student'));
    }

    public function initialize(Request $request, Course $course)
    {
        $user = auth()->user();

        // Calculate fee
        $flutterwaveFee = ($course->price * 0.014) + 50;
        $totalAmount = round($course->price + $flutterwaveFee, 2);

        // Generate unique reference
        do {
            $tx_ref = "Tx" . Str::uuid()->toHex();
        } while (Payment::where('reference', $tx_ref)->exists());

        // Create or update payment
        Payment::updateOrCreate(
            [
                'student_id' => $user->id,
                'course_id'  => $course->id,
            ],
            [
                'amount'     => $course->price,
                'currency'   => 'NGN',
                'reference'  => $tx_ref,
                'status'     => 'pending',
            ]
        );

        return response()->json([
            'tx_ref' => $tx_ref,
            'amount' => $totalAmount,
        ]);
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

             activity_log(
                'course_enrolled',
                'courses',
                [
                    'course_id' => $payment->course_id,
                    'status' => 'success',
                    'description' => 'User enrolled in course successfully'
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

    public function show(Request $request, Course $course)
    {
        $user = auth()->user();

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

        $currentModule = $this->resolveCurrentModule($request, $modules, $enrollment);

        return view('user.course.show', compact(
            'course',
            'modules',
            'enrollment',
            'currentModule'
        ));
    }

    protected function resolveCurrentModule(Request $request, $modules, $enrollment)
    {
        // Example: return the first incomplete module
        foreach ($modules as $module) {
            $progress = $enrollment->moduleProgress
                ->where('module_id', $module->id)
                ->first();

            if (!$progress || $progress->status !== 'completed') {
                return $module;
            }
        }

        // If all completed, return last module
        return $modules->last();
    }

    public function completeCourse($enrollmentId)
    {
        $userId = auth()->id();

        // Get enrollment (secure: must belong to logged-in user)
        $enrollment = Enrollment::with([
            'course.modules.assignments.submissions',
            'moduleProgress'
        ])
        ->where('id', $enrollmentId)
        ->where('student_id', $userId)
        ->firstOrFail();

        $modules = $enrollment->course->modules;

        // ===== MODULES =====
        $totalModules = $modules->count();
        $completedModules = $enrollment->moduleProgress
            ->where('status', 'completed')
            ->count();

        $allModulesCompleted = $totalModules > 0 && $completedModules === $totalModules;

        // ===== ASSIGNMENTS =====
        $assignments = $modules->flatMap(fn($module) => $module->assignments);
        $totalAssignments = $assignments->count();

        $allAssignmentsGraded = $totalAssignments > 0 && $assignments->every(function ($assignment) use ($userId) {
            return $assignment->submissions
                ->where('student_id', $userId)
                ->whereNotNull('graded_at')
                ->isNotEmpty();
        });

        // ===== VALIDATION =====
        if (!$allModulesCompleted || !$allAssignmentsGraded) {
            return back()->with('error', 'You must complete all modules and have all assignments graded first.');
        }

        // Prevent double completion
        if (!is_null($enrollment->completed_at)) {
            return back()->with('info', 'Course already completed.');
        }

        // ===== MARK COMPLETE =====
        $enrollment->completed_at = now();
        $enrollment->save();

        activity_log(
            'course_completed',
            'courses',
            [
                'course_id' => $enrollment->course_id,
                'status' => 'success',
                'description' => 'User completed the course successfully'
            ]
        );

        return back()->with('success', '🎉 Course marked as completed successfully!');
    }
}

