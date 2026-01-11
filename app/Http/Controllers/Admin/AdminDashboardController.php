<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Enrollment;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{

    public function index()
    {
        // ======== STAT CARDS ========
        $totalStudents    = User::where('role', 'student')->where('status','!=','deleted')->count();
        $totalInstructors = User::where('role', 'instructor')->where('status','!=','deleted')->count();
        $totalCourses     = Course::where('status','!=','deleted')->count();
        $totalEarnings    = Payment::where('status','success')->sum('amount');

        // ======== RECENT ENROLLMENTS ========
        $recentEnrollments = Enrollment::with(['student','course'])
            ->latest()
            ->take(5)
            ->get();

        // ======== RECENT ACTIVITIES ========
        $activities = ActivityLog::with('user')
            ->latest()
            ->take(6)
            ->get();

        // ===== CURRENT YEAR =====
        $year = now()->year;

        // ===== MONTHS JAN - DEC =====
        $months = collect(range(1, 12))
            ->map(fn ($m) => Carbon::create()->month($m)->format('M'));

        // ===== EARNINGS (JAN - DEC) =====
        $monthlyEarnings = Payment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'success')
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        $earningsData = collect(range(1, 12))
            ->map(fn ($m) => $monthlyEarnings[$m] ?? 0);

        // ===== ENROLLMENTS (JAN - DEC) =====
        $monthlyEnrollments = Enrollment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        $enrollmentData = collect(range(1, 12))
            ->map(fn ($m) => $monthlyEnrollments[$m] ?? 0);

        // ===== SYSTEM STATS =====
        $cpu = rand(30, 80);
        $ram = rand(40, 90);
        $serverUptime = now()->diffForHumans(now()->subDays(12));

        return view('admin.index', compact(
            'totalStudents',
            'totalInstructors',
            'totalCourses',
            'totalEarnings',
            'recentEnrollments',
            'activities',
            'months',
            'earningsData',
            'enrollmentData',
            'cpu',
            'ram',
            'serverUptime'
        ));
    }

    public function profile()
    {
        $user = Auth::guard('admin')->user();   // logged-in admin
        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Old password is incorrect.');
        }

        // Prevent using same password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->with('error', 'New password cannot be the same as old password.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
