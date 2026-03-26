<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Enrollment;
use App\Models\CourseModule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Get all enrolled course IDs
        $courseIds = Enrollment::where('student_id', $userId)
            ->pluck('course_id');

        // Get all course module IDs in those courses
        $courseModuleIds = CourseModule::whereIn('course_id', $courseIds)
            ->pluck('id');

        // Load assignments + user's submission
        $assignments = Assignment::with(['module.course', 'submissions' => function ($q) use ($userId) {
            $q->where('student_id', $userId);
        }])
        ->whereIn('module_id', $courseModuleIds)
        ->orderBy('deadline')
        ->get();

        return view('user.assignment.index', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $userId = auth()->id();

        // Ensure the student is enrolled in the course via course module
        $isEnrolled = Enrollment::where('student_id', $userId)
            ->where('course_id', $assignment->module->course->id)
            ->exists();

        abort_unless($isEnrolled, 403, 'You are not enrolled in this course.');

        // Load user's submission (if any)
        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $userId)
            ->first();

        return view('user.assignment.show', [
            'assignment' => $assignment->load('module.course'),
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
            'file' => 'required|file|mimes:pdf,doc,docx,zip,txt|max:50120', // max 5MB
            'notes' => 'nullable|string|max:1000',
        ]);

        $assignment = Assignment::findOrFail($request->assignment_id);
        $studentId = auth()->id();
        $studentName = auth()->user()?->name ?? 'Guest';

        // Check if previous submission exists
        $submission = AssignmentSubmission::where([
            'assignment_id' => $assignment->id,
            'student_id' => $studentId,
        ])->first();

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Delete old file if exists
            if ($submission && $submission->file_path && file_exists(public_path('uploads/' . $submission->file_path))) {
                unlink(public_path('uploads/' . $submission->file_path));
            }

            // Ensure the uploads/assignments folder exists
            $uploadPath = public_path('uploads/assignments');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true); // recursive = true
            }

            // Generate unique filename
            $filename = $studentName .'_'. $assignment->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Move file to the folder
            $file->move($uploadPath, $filename);

            $filePath = 'assignments/' . $filename;
        }

        // Save or update submission
        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id' => $studentId,
            ],
            [
                'file_path' => $filePath ?? $submission->file_path ?? null,
                'submitted_at' => now(),
                'notes' => $request->notes,
            ]
        );

        // Optional: log activity
        activity_log(
            'assignment_submitted',
            'assignments',
            [
                'assignment_id' => $assignment->id,
                'course_id' => $assignment->courseModule->course->id ?? null,
                'status' => 'success',
                'description' => 'You have submitted/updated assignment submission'
            ]
        );

        return back()->with('success', 'Assignment submitted successfully.');
    }

}
