<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        // Get enrolled course IDs
        $courseIds = Enrollment::where('student_id', Auth::id())
            ->pluck('course_id');

        // Load assignments + user submission
        $assignments = Assignment::with(['course', 'submissions' => function ($q) {
                $q->where('student_id', auth()->id());
            }])
            ->whereIn('course_id', $courseIds)
            ->orderBy('deadline')
            ->get();

        return view('user.assignment.index', compact('assignments'));
    }

    // public function show() {
    //     return view('user.assignment.show');
    // }
    public function show(Assignment $assignment)
    {
        $userId = Auth::id();

        // Ensure the student is enrolled in the course
        $isEnrolled = \App\Models\Enrollment::where('student_id', $userId)
            ->where('course_id', $assignment->course_id)
            ->exists();

        abort_unless($isEnrolled, 403, 'You are not enrolled in this course.');

        // Load user's submission (if any)
        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $userId)
            ->first();

        return view('user.assignment.show', [
            'assignment' => $assignment->load('course'),
            'submission' => $submission,
        ]);
    }

    public function grade() {
        return view('user.assignment.grade');
    }

    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file' => 'required|file|max:10240',
            'notes' => 'nullable|string|max:1000',
        ]);

        $path = $request->file('file')->store('assignments', 'public');

        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $request->assignment_id,
                'student_id' => auth()->id(),
            ],
            [
                'file_path' => $path,
                'submitted_at' => now(),
            ]
        );

        return back()->with('success', 'Assignment submitted successfully.');
    }

}
