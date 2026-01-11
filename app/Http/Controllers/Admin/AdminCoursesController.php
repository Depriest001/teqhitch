<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Assignment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminCoursesController extends Controller
{
    public function index()
    {
        // Stats
        $totalCourses = Course::where('status', '!=', 'deleted')->count();
        $publishedCourses = Course::where('status', 'published')->count();
        $draftCourses = Course::where('status', 'draft')->count();

        // Courses with instructor + student count
        $courses = Course::with('instructor')
            ->withCount(['enrollments as students_count' => function($q) {
                $q->where('status', 'active');
            }])
            ->where('status', '!=', 'deleted')
            ->latest()
            ->paginate(10);

        return view('admin.courses.index', compact(
            'totalCourses',
            'publishedCourses',
            'draftCourses',
            'courses'
        ));
    }

    public function show($id)
    {
        // Retrieve the course by ID, including its related data
        $course = Course::with(['modules', 'assignments', 'enrollments'])->findOrFail($id);

        // Pass data to the view
        return view('admin.courses.show', compact('course'));
    }

    public function create()
    {
        $instructors = User::where('role', 'instructor')
            ->where('status', 'active')
            ->get();

        return view('admin.courses.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255|unique:courses,title',
            'price'         => 'required|numeric|min:0',
            'duration'         => 'required|string|max:255',
            'instructor_id' => 'required|exists:users,id',
            'description'   => 'required|string',
            'thumbnail'     => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        // Upload Image
        $path = $request->file('thumbnail')->store('courses', 'public');

        $course = Course::create([
            'title'         => $request->title,
            'slug'          => Str::slug($request->title),
            'price'         => $request->price,
            'instructor_id' => $request->instructor_id,
            'duration'      => $request->duration,
            'description'   => $request->description,
            'thumbnail'     => $path,
            'status'        => 'draft',   // default
        ]);

       return redirect()
        ->route('admin.courses.show', $course->id)
        ->with('success', 'Course created successfully');
    }

    public function toggleStatus(Course $course)
    {
        // Toggle the status
        $course->status = $course->status === 'draft' ? 'published' : 'draft';
        $course->save();

        return redirect()->back()->with('success', "Course status updated to {$course->status}");
    }

    public function edit($id) {
        $course = Course::withCount(['enrollments as students' => function($q) {
                $q->where('status', 'active');
            }])->findOrFail($id);

        $instructors = User::where('role', 'instructor')
            ->where('status', 'active')
            ->get();

        return view('admin.courses.edit', compact('course','instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'instructor_id' => 'nullable|exists:users,id',
            'description'   => 'nullable|string',
            'price'         => 'nullable|numeric|min:0',
            'duration'      => 'required|string|max:255',
            'status'        => 'required|in:draft,published,archived',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title'         => $request->title,
            'slug'          => \Str::slug($request->title), // optional: regenerate slug
            'instructor_id' => $request->instructor_id,
            'description'   => $request->description,
            'price'         => $request->price,
            'duration'      => $request->duration,
            'status'        => $request->status,
        ];

        // ================= Thumbnail (Optional) =================
        if ($request->hasFile('thumbnail')) {

            // delete old file if exists
            if ($course->thumbnail && \Storage::exists(str_replace('storage/', '', $course->thumbnail))) {
                \Storage::delete(str_replace('storage/', '', $course->thumbnail));
            }
            
            $path = $request->file('thumbnail')->store('courses', 'public');

            $data['thumbnail'] = $path;
        }

        $course->update($data);

        return redirect()
            ->route('admin.courses.show', $course->id)
            ->with('success', 'Course updated successfully!');
    }

    // ================= SOFT DELETE =================
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $course->update([
            'status' => 'deleted'
        ]);

        return back()->with('success', 'Course deleted successfully');
    }

}
