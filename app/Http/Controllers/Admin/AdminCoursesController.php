<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Assignment;
use App\Models\CourseOutcome;
use Illuminate\Support\Facades\DB;
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
        $course = Course::with([
                'instructor',
                'modules' => function ($query) {
                    $query->withCount('assignments'); // counts assignments per module
                },
                'outcomes',
                'recentEnrollments.student'
            ])
            ->withCount([
                'enrollments as students_count' => function ($q) {
                    $q->where('status', 'active');
                },
                'modules'
            ])
            ->findOrFail($id);

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
        $request->merge([
            'features' => collect($request->features)
                ->filter(fn ($f) => !empty($f['title']) || !empty($f['description']))
                ->values()
                ->toArray(),

            'outcomes' => collect($request->outcomes)
                ->filter(fn ($o) => !empty($o['content']))
                ->values()
                ->toArray(),
        ]);
        
        $validated = $request->validate([
            'title'         => 'required|string|max:255|unique:courses,title',
            'subtitle'      => 'nullable|string|max:255',
            'price'         => 'required|numeric|min:0',
            'duration'      => 'required|string|max:255',
            'instructor_id' => 'required|exists:users,id',
            'description'   => 'required|string',
            'thumbnail'     => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'icon'          => 'nullable|string|max:255',
            'category'      => 'required|string|max:255',
            'level'         => 'required|string|max:255',

            // Outcomes validation
            'outcomes'                  => 'required|array',
            'outcomes.*.content'        => 'required|string|max:255',
        ]);
        

        DB::transaction(function () use ($request, $validated) {

            // Upload thumbnail
            $destinationPath = public_path('uploads/courses');
            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            // Generate unique filename
            $filename = uniqid().'_'.time().'.'.$request->thumbnail->extension();
            $request->thumbnail->move($destinationPath, $filename);

            // Save path to database
            $path = 'courses/' . $filename;

            // Create Course (Slug auto-generated in Model)
            $course = Course::create([
                'title'         => $validated['title'],
                'subtitle'      => $validated['subtitle'] ?? null,
                'price'         => $validated['price'],
                'duration'      => $validated['duration'],
                'instructor_id' => $validated['instructor_id'],
                'description'   => $validated['description'],
                'thumbnail'     => $path,
                'icon'          => $validated['icon'] ?? null,
                'category'      => $validated['category'],
                'level'         => $validated['level'],
            ]);
            
            $outcomes = collect($request->outcomes)
                ->filter(function ($outcome) {
                    return !empty($outcome['content']);
                });

            // Save Outcomes
            if (!empty($validated['outcomes'])) {
                foreach ($validated['outcomes'] as $index => $outcome) {
                    $course->outcomes()->create([
                        'content'  => $outcome['content'],
                        'position' => $index,
                    ]);
                }
            }

        });

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully');
    }

    public function toggleStatus(Course $course)
    {
        // Toggle the status
        $course->status = $course->status === 'draft' ? 'published' : 'draft';
        $course->save();

        return redirect()->back()->with('success', "Course status updated to {$course->status}");
    }

    public function edit($id)
    {
        $course = Course::with([
                'outcomes',
                'instructor'
            ])
            ->withCount([
                'enrollments as students_count' => function ($q) {
                    $q->where('status', 'active');
                }
            ])
            ->findOrFail($id);

        $instructors = User::where('role', 'instructor')
            ->where('status', 'active')
            ->get();

        return view('admin.courses.edit', compact('course', 'instructors'));
    }   

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'instructor_id' => 'nullable|exists:users,id',
            'description'   => 'nullable|string',
            'price'         => 'nullable|numeric|min:0',
            'duration'      => 'required|string|max:255',
            'status'        => 'required|in:draft,published',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon'          => 'nullable|string|max:255',
            'category'      => 'required|string|max:255',
            'level'         => 'required|string|max:255',

            'outcomes'                  => 'nullable|array',
            'outcomes.*.id'             => 'nullable|exists:course_outcomes,id',
            'outcomes.*.content'        => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $course, $validated) {

            // ================= Thumbnail =================
            if ($request->hasFile('thumbnail')) {

                // Delete old file if exists
                if ($course->thumbnail) {

                    $oldPath = public_path('uploads/' . $course->thumbnail);

                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Destination path
                $destinationPath = public_path('uploads/courses');

                // Create folder if it doesn't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Generate unique filename
                $filename = uniqid() . '_' . time() . '.' . $request->thumbnail->extension();

                // Move file
                $request->thumbnail->move($destinationPath, $filename);

                // Save relative path in database
                $validated['thumbnail'] = 'courses/' . $filename;
            }

            // Update course (slug handled automatically in model)
            $course->update($validated);

            /*
            |--------------------------------------------------------------------------
            | OUTCOMES SYNC
            |--------------------------------------------------------------------------
            */

            $existingOutcomeIds = [];

            if ($request->outcomes) {

                foreach ($request->outcomes as $index => $outcome) {

                    if (empty($outcome['content'])) {
                        continue;
                    }

                    $courseOutcome = $course->outcomes()->updateOrCreate(
                        ['id' => $outcome['id'] ?? null],
                        [
                            'content'  => $outcome['content'],
                            'position' => $index,
                        ]
                    );

                    $existingOutcomeIds[] = $courseOutcome->id;
                }
            }

            // Delete removed outcomes
           if ($request->has('outcomes')) {
                $submittedIds = collect($request->outcomes)
                    ->pluck('id')
                    ->filter()
                    ->toArray();

                $course->outcomes()
                    ->whereNotIn('id', $submittedIds)
                    ->delete();
            }

        });

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