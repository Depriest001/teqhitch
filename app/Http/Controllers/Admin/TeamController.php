<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $members = TeamMember::latest()->get();
        return view('admin.teams.index', compact('members'));
    }

    public function store(Request $request)
    {
        // ✅ 1. Validate
        $request->validate([
            'fullname' => 'required|string|max:255',
            'bio' => 'required|string',
            'position' => 'required|string|unique:team_members,position|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        // ✅ 2. Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {

            $destinationPath = public_path('uploads/team');

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
            $imagePath = 'team/' . $filename;
        }

        // ✅ 3. Save to DB
        TeamMember::create([
            'fullname' => $request->fullname,
            'bio' => $request->bio,
            'position' => $request->position,
            'image' => $imagePath,

            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
        ]);

        // ✅ 4. Redirect
        return redirect()->back()->with('success', 'Team member added successfully!');
    }

    public function toggleStatus(TeamMember $teamMember)
    {
        $teamMember->status = !$teamMember->status;
        $teamMember->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function show(TeamMember $team)
    {
        $teamMember = $team;
        return view('admin.teams.show', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'bio' => 'required|string',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        // Handle Image Upload
        if ($request->hasFile('image')) {

            // Delete old image
            if ($team->image) {
                $oldPath = public_path('uploads/' . $team->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Upload new image (shared hosting)
            $destinationPath = public_path('uploads/team');

            $file = $request->file('image');
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $filename);

            $team->image = 'team/' . $filename;
        }

        // Update other fields
        $team->update([
            'fullname' => $request->fullname,
            'bio' => $request->bio,
            'position' => $request->position,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
        ]);

        return back()->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $team)
    {
        if ($team->image) {
            $imagePath = public_path('uploads/'.$team->image);

            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete record
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }
}
