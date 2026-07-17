<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimony;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{    
    /**
     * Display listing
     */
    public function index()
    {
        $testimonies = Testimony::latest()->get();
        return view('admin.testimonies.index', compact('testimonies'));
    }

    /**
     * Store new testimony
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;

        // ✅ 2. Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {

            $destinationPath = public_path('uploads/testimonies');

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Generate unique filename
            $file = $request->file('image');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Move file
            $file->move($destinationPath, $filename);

            // Save path to database
            $imagePath = 'testimonies/' . $filename;
        }

        Testimony::create([
            'name' => $request->name,
            'occupation' => $request->occupation,
            'message' => $request->message,
            'image' => $imagePath,
            'status' => true,
        ]);

        return redirect()->back()->with('success', 'Testimony created successfully.');
    }

    /**
     * Show testimony by id
     */
    public function show(Testimony $testimony)
    {
        return view('admin.testimonies.show', compact('testimony'));
    }

    /**
     * Update testimony
     */
    public function update(Request $request, Testimony $testimony)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $testimony->image;

        // Handle Image Upload
        if ($request->hasFile('image')) {

            // Delete old image
            if ($testimony->image) {
                $oldPath = public_path('uploads/' . $testimony->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Upload new image (shared hosting)
            $destinationPath = public_path('uploads/testimonies');

            $file = $request->file('image');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $filename);

            $imagePath = 'testimonies/' . $filename;
        }

        $testimony->update([
            'name' => $request->name,
            'occupation' => $request->occupation,
            'message' => $request->message,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Testimony updated successfully.');
    }

    /**
     * Delete testimony
     */
    public function destroy(Testimony $testimony)
    {
        // delete image if exists
        if ($testimony->image) {
            $imagePath = public_path('uploads/'.$testimony->image);

            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $testimony->delete();

        return redirect()->route('admin.testimony.index')->with('success', 'Testimony deleted successfully.');
    }

    /**
     * Toggle status (AJAX-friendly)
     */
    public function toggleStatus(Testimony $testimony)
    {
        $testimony->update([
            'status' => !$testimony->status,
        ]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
