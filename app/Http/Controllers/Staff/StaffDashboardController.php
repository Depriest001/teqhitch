<?php

namespace App\Http\Controllers\Staff;

use App\Models\InstructorProfile;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $instructorId = auth()->id();

        // Active Courses
        $courses = Course::where('instructor_id', $instructorId)
            ->where('status', 'published')
            ->withCount('students')
            ->latest()
            ->get();

        $activeCoursesCount = $courses->count();

        // Total Students Enrolled (sum of enrollments across courses)
        $totalStudents = Enrollment::whereIn(
            'course_id',
            $courses->pluck('id')
        )->count();

        // Assignments created by instructor
        $assignments = Assignment::where('instructor_id', $instructorId)->get();

        // Pending Submissions (submitted but not graded)
        $pendingGrading = AssignmentSubmission::whereIn(
            'assignment_id',
            $assignments->pluck('id')
        )->whereNull('score')
        ->count();

        // Recent pending assignment list
        $pendingAssignmentsList = Assignment::where('instructor_id', $instructorId)
            ->withCount([
                'submissions as pending_submissions_count' => function ($q) {
                    $q->whereNull('score');
                }
            ])
            ->having('pending_submissions_count', '>', 0)
            ->latest()
            ->take(5)
            ->get();

        return view('staff.index', compact(
            'courses',
            'activeCoursesCount',
            'totalStudents',
            'pendingGrading',
            'pendingAssignmentsList'
        ));
    }

    public function profile()
    {
        $user = auth()->user()->load('instructorProfile');

        // Ensure instructor profile exists
        if (!$user->instructorProfile) {
            $user->instructorProfile()->create([
                'bio'            => null,
                'qualification'  => null,
                'specialization' => null,
                'rating'         => null,
            ]);
            
            $user->load('instructorProfile'); // reload
        }

        return view('staff.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',

            'qualification' => 'nullable|string|max:255',
            'specialization'=> 'nullable|string|max:255',
            'bio'           => 'nullable|string|max:2000',
        ]);

        // Update Users Table
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update or Create Instructor Profile
        InstructorProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'qualification' => $request->qualification,
                'specialization'=> $request->specialization,
                'bio'           => $request->bio,
            ]
        );

        return back()->with('success', 'Profile updated successfully!');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect!');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

}
