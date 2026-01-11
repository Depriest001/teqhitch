<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\ModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Safety check
        if ($user->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        // Enrollments with needed relations
        $enrollments = Enrollment::with([
                'course.modules',
                'moduleProgress'
            ])
            ->where('student_id', $user->id)
            ->get()
            ->map(function ($enrollment) {

                $totalModules = $enrollment->course->modules->count();

                $completedModules = $enrollment->moduleProgress
                    ->where('status', 'completed')
                    ->count();

                $progress = $totalModules > 0
                    ? round(($completedModules / $totalModules) * 100)
                    : 0;

                // Attach progress dynamically
                $enrollment->progress = $progress;

                return $enrollment;
            });

        $totalCourses = $enrollments->count();

        $completedCourses = $enrollments
            ->where('status', 'completed')
            ->count();

        // Overall progress = average of course progress
        $overallProgress = $totalCourses > 0
            ? round($enrollments->avg('progress'))
            : 0;

        // Ongoing enrollments
        $ongoingEnrollments = $enrollments->where('status', '!=', 'completed');

        // Upcoming assignments
        $upcomingAssignments = Assignment::whereIn(
                'course_id',
                $enrollments->pluck('course_id')
            )
            ->whereDate('deadline', '>=', now())
            ->orderBy('deadline')
            ->take(5)
            ->get();

        return view('user.index', compact(
            'totalCourses',
            'completedCourses',
            'overallProgress',
            'ongoingEnrollments',
            'upcomingAssignments'
        ));
    }

    public function profile() {
        return view('user.profile');
    }

    public function activities() {
        return view('user.activities');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'student') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
        ]);

        // Update user table
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update or create student profile
        $user->studentProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'address'     => $request->address,
                'institution' => $request->institution,
            ]
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
