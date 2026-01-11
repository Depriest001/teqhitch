<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Show list of admins
    public function index() {
        // All admins for stats
        $allAdmins = Admin::where('status', '!=', 'deleted');
        $total = $allAdmins->count();
        $superAdmins = $allAdmins->where('role', 'superadmin')->count();
        $active = $allAdmins->where('status', 'active')->count();
        $suspended = $allAdmins->where('status', 'suspended')->count();

        // Only non-Super Admins for table
        $admins = Admin::where('role', '!=', 'superadmin')
            ->where('status', '!=', 'deleted')
            ->get();

        return view('admin.admins.index', compact('admins', 'total', 'superAdmins', 'active', 'suspended'));
    }

    // Show admin details
    public function show(Admin $admin) {
        return view('admin.admins.show', compact('admin'));
    }

    // Show edit form
    public function edit(Admin $admin) {
        return view('admin.admins.edit', compact('admin'));
    }

    // Store new admin
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|string|max:255',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Admin created successfully!');
    }

    // Update existing admin
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:admins,email,' . $admin->id,
            'phone'  => 'nullable|string|max:255',
            'role'   => 'required|string',
            'status' => 'required|string',
            'password' => 'nullable|min:6'
        ]);

        // Update normal fields
        $admin->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'role'   => $request->role,
            'status' => $request->status,
        ]);

        // Update password only if provided
        if($request->filled('password')){
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Administrator updated successfully!');
    }

    // suspend admin
    public function suspend(Admin $admin)
    {
        // Prevent suspending Super Admin
        if ($admin->role === 'superadmin') {
            return back()->with('error', 'You cannot suspend a Super Admin!');
        }

        $admin->update([
            'status' => 'Suspended'
        ]);

        return back()->with('success', 'Admin suspended successfully!');
    }

    // Delete admin
    // public function destroy(Admin $admin) {
    //     $admin->delete();
    //     return redirect()->route('admin.admins.index')->with('success', 'Admin deleted successfully!');
    // }
    public function destroy($id)
    {
        $instructor = Admin::where('role', 'instructor')
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        $instructor->update([
            'status' => 'deleted'
        ]);

        return back()->with('success', 'Instructor deleted successfully');
    }
}
