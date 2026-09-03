<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\Payment;
use App\Models\SiwesTrack;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{

    public function index()
    {
        $student = Auth::user();

        $student->load(['siwesApplication.track', 'enrollmentApplication.course']);

        $payment = Payment::where('student_id', $student->id)
            ->latest('paid_at')
            ->first();

        $fee    = $student->program_fee ?? 0;
        $isPaid = $payment && $payment->status === 'success';

        // Courses the student isn't already enrolled in
        $enrolledCourseId = $student->enrollmentApplication?->course_id;

        $availableCourses = Course::when($enrolledCourseId, fn ($q) => $q->where('id', '!=', $enrolledCourseId))
            ->orderBy('title')
            ->get();

        return view('student.index', [
            'student'            => $student,
            'programName'        => $student->program_name,
            'payment'            => $payment,
            'isPaid'             => $isPaid,
            'fee'                => $fee,
            'outstandingBalance' => $isPaid ? 0 : $fee,
            'availableCourses'   => $availableCourses,
        ]);
    }

    public function edit()
    {
        $student = Auth::user();

        return view('student.settings', [
            'student' => $student,
        ]);
    }

    public function update(Request $request)
    {
        $student = Auth::user();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', Rule::unique('students', 'email')->ignore($student->id)],
            'phone'     => ['nullable', 'string', 'max:20'],
            'gender'    => ['nullable', 'in:male,female'],
            'address'   => ['nullable', 'string', 'max:500'],
        ]);

        $student->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $student = Auth::user();

        $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'confirmed', Password::defaults()],
        ]);

        if (! Hash::check($request->current_password, $student->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $student->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function certificate(){
        return view('student.certificate');
    }

}