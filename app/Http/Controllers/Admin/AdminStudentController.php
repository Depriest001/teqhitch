<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminStudentController extends Controller
{
    // List all students
    public function index()
    {
        $students = User::where('role', 'student')
            ->where('status', '!=', 'deleted')
            ->latest()
            ->get();

        return view('admin.student.index', [
            'students' => $students,
            'total' => $students->count(),
            'active' => $students->where('status', 'active')->count(),
            'suspended' => $students->where('status', 'suspended')->count(),
        ]);
    }

    // Show a single student
    public function show($id)
    {
        $student = User::where('role', 'student')
            ->where('status', '!=', 'deleted')
            ->with('StudentProfile')
            ->findOrFail($id);

        return view('admin.student.show', compact('student'));
    }

    // Show edit form
    public function edit($id)
    {
        $student = User::where('role', 'student')
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        return view('admin.student.edit', compact('student'));
    }

    // Update student
    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'phone' => 'required|string|max:255',
            'status' => 'required|in:active,suspended',
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.student.index')->with('success', 'Student updated successfully.');
    }

    // Store new student
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
                'role'   => 'student',
                'status' => 'active',
                'password' => Hash::make('123456'),
            ]);

            // Create Instructor Profile
            StudentProfile::create([
                'user_id' => $user->id,
            ]);

        });

        return back()->with('success', 'Student created successfully');
    }

    // suspend student
    public function suspend(User $student)
    {

        // 2️⃣ Prevent re-suspending already suspended users (idempotency)
        if ($student->status === 'suspended') {
            return back()->with('info', 'Student is already suspended.');
        }

        // 3️⃣ Update using update() not save()
        $student->update([
            'status' => 'Suspended'
        ]);

        // 4️⃣ Optional: fire event / notification

        return back()->with('success', 'Student suspended successfully!');
    }

    // Delete student}
    public function destroy($id)
    {
        $instructor = User::where('role', 'student')
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        $instructor->update([
            'status' => 'deleted'
        ]);

        return back()->with('success', 'Student has been deleted successfully.');
    }
}
