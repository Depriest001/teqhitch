<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\InstructorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminInstructorController extends Controller
{
    public function index()
    {
        $instructors = User::where('role', 'instructor')
            ->where('status', '!=', 'deleted')
            ->latest()
            ->get();

        return view('admin.instructor.index', [
            'instructors' => $instructors,
            'total' => $instructors->count(),
            'active' => $instructors->where('status', 'active')->count(),
            'suspended' => $instructors->where('status', 'suspended')->count(),
        ]);
    }


    // ================= SHOW =================
    public function show($id)
    {
        $instructor = User::where('role', 'instructor')
            ->where('status', '!=', 'deleted')
            ->with('instructorProfile')
            ->findOrFail($id);

        return view('admin.instructor.show', compact('instructor'));
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $instructor = User::where('role', 'instructor')
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        return view('admin.instructor.edit', compact('instructor'));
    }


    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $instructor = User::where('role', 'instructor')
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'phone' => 'required|string|max:255',
            'status' => 'required|in:active,suspended',
        ]);

        $instructor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.instructor.index')
            ->with('success', 'Instructor updated successfully');
    }


    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            // Create User
            $user = User::create([
                'name'   => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
                'role'   => 'instructor',
                'status' => 'active',
                'password' => Hash::make('123456'),
            ]);

            // Create Instructor Profile
            InstructorProfile::create([
                'user_id' => $user->id,
            ]);

        });

        return back()->with('success', 'Instructor created successfully');
    }

    // suspend Instructor
    public function suspend(User $instructor)
    {
        // 1️⃣ Ensure only instructors
        if ($instructor->role !== 'instructor') {
            abort(404);
        }

        // 2️⃣ Prevent re-suspending already suspended users (idempotency)
        if ($instructor->status === 'suspended') {
            return back()->with('info', 'Instructor is already suspended.');
        }

        // 3️⃣ Update using update() not save()
        $instructor->update([
            'status' => 'Suspended'
        ]);

        // 4️⃣ Optional: fire event / notification

        return back()->with('success', 'Instructor suspended successfully!');
    }

    // ================= SOFT DELETE =================
    public function destroy($id)
    {
        $instructor = User::where('role', 'instructor')
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        $instructor->update([
            'status' => 'deleted'
        ]);

        return back()->with('success', 'Instructor deleted successfully');
    }
}
