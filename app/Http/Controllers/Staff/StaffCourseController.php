<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\CourseModule;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffCourseController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->instructorCourses()
            ->where('status', 'published')
            ->withCount('students');   // student count available for sorting & display

        // 🔎 Search
        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // 🗂 Sorting
        if ($request->sort) {

            if ($request->sort === 'newest') {
                $query->latest();
            }

            if ($request->sort === 'oldest') {
                $query->oldest();
            }

            if ($request->sort === 'most_students') {
                $query->orderBy('students_count', 'desc');
            }
        } else {
            // default
            $query->latest();
        }

        $courses = $query->paginate(12)->appends($request->query());

        return view('staff.course.index', compact('courses'));
    }

    public function show(Course $course)
    {
        // Ensure instructor owns the course
        abort_if($course->instructor_id !== auth()->id(), 403, 'Unauthorized');

        // Ensure course is published
        abort_if($course->status !== 'published', 404, 'Course not found');

        // Eager load relationships
        $course->load(['modules', 'assignments', 'students']);

        // Compute stats
        $stats = [
            'students'    => $course->students()->count(),
            'assignments' => $course->assignments()->count(),
            'materials'   => $course->modules()->count(),
        ];

        return view('staff.course.show', compact('course', 'stats'));
    }

     /**
     * Show the edit form for a module.
     */
    public function editmodule(Course $course, CourseModule $module)
    {
        // Ensure instructor owns the course
        abort_if($course->instructor_id !== auth()->id(), 403, 'This course is not assigned to you!');

        // Ensure module belongs to course
        abort_if($module->course_id !== $course->id, 404, 'Module not found for this course');

        return view('staff.course.edit', compact('course', 'module'));
    }

    public function storemodule(Request $request, Course $course)
    {
        // abort_if($course->instructor_id !== auth()->id(), 403);
        abort_if($course->instructor_id !== auth()->id(), 403, 'This Course is not assign to you!');

        $request->validate([
            'module_title' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'material'     => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,txt|max:20480'
        ]);

        $path = $request->file('material')->store('course_materials','public');

        CourseModule::create([
            'course_id' => $course->id,
            'title'     => $request->module_title,
            'file_path' => $path,
            'file_type' => $request->file('material')->getClientOriginalExtension(),
            'description'    => $request->description,
            'position'  => $course->modules()->count() + 1,
            'status'    => 'active'
        ]);

        return back()->with('success','Module added successfully');
    }

    public function student() {
        return view('staff.course.student');
    }


    public function analytics() {
        return view('staff.course.analytics');
    }

    /**
     * Update the module.
     */
    public function updatemodule(Request $request, Course $course, CourseModule $module)
    {
        // Ensure instructor owns the course
        abort_if($course->instructor_id !== auth()->id(), 403, 'This course is not assigned to you!');

        // Ensure module belongs to course
        abort_if($module->course_id !== $course->id, 404, 'Module not found for this course');

        // Validation
        $request->validate([
            'module_title' => 'required|string|max:255',
            'description'  => 'nullable|string',            
            'status' => 'required|string',
            'material'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,txt|max:20480',
        ]);

        // Update module fields
        $module->title = $request->module_title;
        $module->description = $request->description;
        $module->status = $request->status;

        // Handle file replacement
        if ($request->hasFile('material')) {
            // Delete old file if exists
            if ($module->file_path && Storage::disk('public')->exists($module->file_path)) {
                Storage::disk('public')->delete($module->file_path);
            }

            $path = $request->file('material')->store('course_materials', 'public');
            $module->file_path = $path;
            $module->file_type = $request->file('material')->getClientOriginalExtension();
        }

        $module->save();

        return redirect()
            ->route('staff.courses.show', $course->id)
            ->with('success', 'Module updated successfully!');
    }

    public function destroymodule(Course $course, CourseModule $module)
    {
        // Check ownership
        abort_if($course->instructor_id !== auth()->id(), 405, 'This course is not assigned to you!');
        abort_if($module->course_id !== $course->id, 404, 'Module not found for this course');

        // Delete file from storage
        if ($module->file_path && Storage::disk('public')->exists($module->file_path)) {
            Storage::disk('public')->delete($module->file_path);
        }

        $module->delete();

        return redirect()
            ->route('staff.courses.show', $course->id)
            ->with('success', 'Module deleted successfully!');
    }


}
