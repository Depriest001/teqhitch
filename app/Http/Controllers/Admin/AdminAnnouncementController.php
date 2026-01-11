<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('status', '!=', 'deleted')->latest()->get();
        $courses = Course::select('id','title')->where('status', 'published')->get();

        return view('admin.announcement.index', compact('announcements','courses'));
    }

    public function show($id)
    {
        // Get the announcement with its related course (if type = 'course')
        $announcement = Announcement::with('course')
                        ->where('id', $id)
                        ->where('status', '!=', 'deleted') // optional, skip deleted announcements
                        ->firstOrFail();

        return view('admin.announcement.show', compact('announcement'));
    }
    
    public function edit(Announcement $announcement)
    {
        return view('admin.announcement.edit', compact('announcement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'type'      => 'required|in:general,course',
            'audience'  => 'required|in:everyone,students,instructors',
            'message'   => 'required|string',

            // only required if type == course
            'course_id' => 'nullable|exists:courses,id', 

            'status'    => 'required|in:draft,published',
        ]);

        $announcement = Announcement::create([
            'title'       => $request->title,
            'message'     => $request->message,
            'type'        => $request->type,
            'audience'    => $request->audience ?? 'everyone',
            'course_id'   => $request->type === 'course' ? $request->course_id : null,

            'status'      => $request->status,
            'published_at'=> $request->status === 'published' ? now() : null,

            'posted_by_id'=> auth()->id(),
            'posted_by_type'=> auth()->user() instanceof \App\Models\Admin ? 'App\Models\Admin' : 'App\Models\User',
        ]);

        return redirect()
            ->route('admin.announcement.index')
            ->with('success', 'Announcement created successfully!');
    }
    
    public function update(Request $request, Announcement $announcement)
    {
        // 1. Validate the incoming request
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'type'      => 'required|in:general,course,system',
            'audience'  => 'required|in:students,instructors,admin',
            'message'   => 'required|string',
            'status'    => 'required|in:published,draft,archived',
            'course_id' => 'nullable|exists:courses,id', // only required if type = course
        ]);

        // 2. Conditionally set course_id
        if ($validated['type'] !== 'course') {
            $validated['course_id'] = null;
        }

        // 3. Update the published_at field if status is published
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        // 4. Update the announcement
        $announcement->update($validated);

        // 5. Return redirect with success message
        return redirect()
            ->route('admin.announcement.index')
            ->with('success', 'Announcement updated successfully!');
    }

    // ================= SOFT DELETE =================
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        $announcement->update([
            'status' => 'deleted'
        ]);

        return redirect()
            ->route('admin.announcement.index')
            ->with('success', 'Announcement deleted successfully');
    }
}