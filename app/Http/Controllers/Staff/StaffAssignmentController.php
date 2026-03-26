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
        $query = Assignment::with(['module', 'module.course'])
            ->where('instructor_id', auth()->id());

        // 🔎 Search by assignment title, module title, or course title
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%") // assignment title
                ->orWhereHas('module', function($m) use ($request) {
                    $m->where('title', 'like', "%{$request->search}%") // module title
                        ->orWhereHas('course', function($c) use ($request) {
                            $c->where('title', 'like', "%{$request->search}%"); // course title
                        });
                });
            });
        }

        // 🎯 Filter by course through module
        if ($request->course_id) {
            $query->whereHas('module.course', function($c) use ($request) {
                $c->where('id', $request->course_id);
            });
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

        // Courses for the instructor
        $courses = Course::where('instructor_id', auth()->id())->get();

        return view('staff.assignment.index', compact('assignments', 'courses'));
    }

    // public function edit() {
    //     return view('staff.assignment.edit');
    // }

    public function store(Request $request)
    {
        $course = Course::findOrFail($request->input('course_id'));

        // 2. Ensure the authenticated user owns the course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Validate the request
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'module_id'   => 'required|exists:course_modules,id', // <-- validate selected module
            'deadline'    => 'required|date|after:today',
            'max_score'   => 'required|integer|min:1',
        ]);

        // Ensure the module belongs to this course
        $module = $course->modules()->findOrFail($request->module_id);

        // Create the assignment
        Assignment::create([
            'module_id'     => $module->id,           // use the selected module
            'instructor_id' => auth()->id(),
            'title'         => $request->title,
            'instructions'  => $request->description,
            'deadline'      => $request->deadline,
            'max_score'     => $request->max_score,
            'status'        => '',                     // or 'pending'
        ]);

        activity_log(
            'update_lesson',
            'lessons',
            [
                'course_id' => $module->course_id,
                'status' => 'success',
                'description' => 'Instructor created an Assignment'
            ]
        );

        return back()->with('success', 'Assignment created successfully');
    }
    
    public function show(Assignment $assignment)
    {
        // Ensure instructor owns the assignment via its course module → course
        abort_if($assignment->Module->course->instructor_id !== auth()->id(), 403);

        // Load relations
        $assignment->load(['module.course', 'submissions.student']);

        $submitted = 0;
        $late = 0;

        foreach ($assignment->submissions as $submission) {
            if ($submission->submitted_at) {
                if ($submission->submitted_at > $assignment->deadline) {
                    $late++;
                } else {
                    $submitted++;
                }
            }
        }

        // Pending = students without submission
        $totalStudents = $assignment->module->course->students->count();
        $pending = $totalStudents - ($submitted + $late);

        return view('staff.assignment.show', [
            'assignment' => $assignment,
            'module' => $assignment->module,
            'course' => $assignment->module->course,
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

        activity_log(
            'grade_assignment',
            'assignments',
            [
                'assignment_id' => $assignment->id,
                'student_id' => $submission->student_id,
                'status' => 'success',
                'description' => 'Instructor graded assignment'
            ]
        );

        return redirect()->route('staff.assignment.show', $assignment->id)
            ->with('success', 'Grade submitted successfully.');
    }

}
