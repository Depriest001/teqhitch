<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Assignment;
use App\Models\CourseFeature;
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
                'modules',
                'assignments',
                'features',
                'outcomes',
                'enrollments.student'
            ])
            ->withCount([
                'enrollments as students_count' => function ($q) {
                    $q->where('status', 'active');
                },
                'modules',
                'assignments'
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
            'overview'      => 'nullable|string',
            'thumbnail'     => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'icon'      => 'nullable|string|max:255',

            // Features validation
            'features'                  => 'nullable|array',
            'features.*.title'          => 'required|string|max:255',
            'features.*.description'    => 'required|string|max:500',
            'features.*.icon'           => 'nullable|string|max:255',

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

            // Save path to database (optional)
            $path = 'courses/' . $filename;

            // Create Course (Slug auto-generated in Model)
            $course = Course::create([
                'title'         => $validated['title'],
                'subtitle'      => $validated['subtitle'] ?? null,
                'price'         => $validated['price'],
                'duration'      => $validated['duration'],
                'instructor_id' => $validated['instructor_id'],
                'description'   => $validated['description'],
                'overview'      => $validated['overview'] ?? null,
                'thumbnail'     => $path,
                'icon'      => $validated['icon'] ?? null,
            ]);
            $features = collect($request->features)
                ->filter(function ($feature) {
                    return !empty($feature['title']) && !empty($feature['description']);
                });

            $outcomes = collect($request->outcomes)
                ->filter(function ($outcome) {
                    return !empty($outcome['content']);
                });

            // Save Features
            if (!empty($validated['features'])) {
                foreach ($validated['features'] as $index => $feature) {
                    $course->features()->create([
                        'title'       => $feature['title'],
                        'description' => $feature['description'],
                        'icon'        => $feature['icon'] ?? null,
                        'position'    => $index,
                        'status'      => true,
                    ]);
                }
            }

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
                'features',
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
            'overview'      => 'nullable|string',
            'price'         => 'nullable|numeric|min:0',
            'duration'      => 'required|string|max:255',
            'status'        => 'required|in:draft,published',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'icon'          => 'nullable|string|max:255',

            'features'                  => 'nullable|array',
            'features.*.id'             => 'nullable|exists:course_features,id',
            'features.*.title'          => 'nullable|string|max:255',
            'features.*.description'    => 'nullable|string|max:500',
            'features.*.icon'           => 'nullable|string|max:255',

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

            // Remove features/outcomes from main update array
            unset($validated['features'], $validated['outcomes']);

            // Update course (slug handled automatically in model)
            $course->update($validated);

            /*
            |--------------------------------------------------------------------------
            | FEATURES SYNC
            |--------------------------------------------------------------------------
            */

            $existingFeatureIds = [];

            if ($request->features) {

                foreach ($request->features as $index => $feature) {

                    // Skip completely empty rows
                    if (empty($feature['title']) || empty($feature['description'])) {
                        continue;
                    }

                    $courseFeature = $course->features()->updateOrCreate(
                        ['id' => $feature['id'] ?? null],
                        [
                            'title'       => $feature['title'],
                            'description' => $feature['description'],
                            'icon'        => $feature['icon'] ?? null,
                            'position'    => $index,
                            'status'      => 1,
                        ]
                    );

                    $existingFeatureIds[] = $courseFeature->id;
                }
            }

            // Delete removed features
           if ($request->has('features')) {
                $submittedIds = collect($request->features)
                    ->pluck('id')
                    ->filter()
                    ->toArray();

                $course->features()
                    ->whereNotIn('id', $submittedIds)
                    ->delete();
            }

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
