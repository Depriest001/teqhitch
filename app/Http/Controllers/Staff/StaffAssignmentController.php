<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class StaffAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Assignment::with('course')
            ->where('instructor_id', auth()->id());

        // 🔎 Search by title or course name
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                ->orWhereHas('course', function($c) use ($request) {
                    $c->where('title', 'like', "%{$request->search}%");
                });
            });
        }

        // 🎯 Filter by course
        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        // 🏷 Filter by status
        if ($request->status) {

            if ($request->status === 'pending') {
                $query->whereDoesntHave('submissions');
            }

            if ($request->status === 'submitted') {
                $query->whereHas('submissions');
            }

            if ($request->status === 'graded') {
                $query->whereHas('submissions', function($q) {
                    $q->whereNotNull('score');
                });
            }

            if ($request->status === 'late') {
                $query->where('deadline', '<', now())
                    ->whereDoesntHave('submissions');
            }
        }

        $assignments = $query->latest()->get();

        $courses = Course::where('instructor_id', auth()->id())->get();

        return view('staff.assignment.index', compact('assignments', 'courses'));
    }

    public function edit() {
        return view('staff.assignment.edit');
    }

    public function storeAssignment(Request $request, Course $course)
    {
        abort_if($course->instructor_id !== auth()->id(), 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'deadline'    => 'required|date|after:today',
            'max_score'   => 'required|integer|min:1',
        ]);

        Assignment::create([
            'course_id'     => $course->id,
            'instructor_id' => auth()->id(),
            'title'         => $request->title,
            'instructions'  => $request->description,
            'deadline'      => $request->deadline,
            'max_score'     => $request->max_score,
            'status'        => '',
        ]);

        return back()->with('success','Assignment created successfully');
    }
    
    public function show(Assignment $assignment)
    {
        abort_if($assignment->instructor_id !== auth()->id(), 403);

        $assignment->load(['course.students', 'submissions.student']);

        $submitted = 0;
        $late = 0;

        foreach ($assignment->submissions as $submission) {
            if ($submission->submitted_at) {

                // If submitted after deadline → late
                if ($submission->submitted_at > $assignment->deadline) {
                    $late++;
                } else {
                    $submitted++;
                }
            }
        }

        // Pending = Students without submission
        $totalStudents = $assignment->course->students->count();
        $pending = $totalStudents - ($submitted + $late);

        return view('staff.assignment.show', [
            'assignment' => $assignment,
            'course' => $assignment->course,
            'submissions' => $assignment->submissions,
            'stats' => [
                'submitted' => $submitted,
                'pending' => $pending,
                'late' => $late
            ]
        ]);
    }

    public function destroy($id)
    {
        $assignment = Assignment::where('id', $id)
            ->where('instructor_id', auth()->id())
            ->firstOrFail();

        // OPTIONAL: delete submissions if needed

        $assignment->delete();

        return back()->with('success', 'Assignment deleted successfully');
    }

    public function grade(Assignment $assignment, AssignmentSubmission $submission)
    {
        abort_if($assignment->instructor_id !== auth()->id(), 403);

        abort_if($submission->assignment_id !== $assignment->id, 404);

        $submission->load('student');

        return view('staff.assignment.grading', [
            'assignment' => $assignment,
            'submission' => $submission,
            'student' => $submission->student,
        ]);
    }

    public function storeGrade(
        Request $request,
        Assignment $assignment,
        AssignmentSubmission $submission
    ) {
        abort_if($assignment->instructor_id !== auth()->id(), 403);
        abort_if($submission->assignment_id !== $assignment->id, 404);

        $request->validate([
            'score' => 'required|integer|min:0|max:' . $assignment->max_score,
            'feedback' => 'nullable|string|max:2000',
        ]);

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Grade submitted successfully.');
    }


}
