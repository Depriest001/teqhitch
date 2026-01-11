<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StaffAnnouncementController extends Controller
{

    public function index()
    {
        // Only published announcements for staff
        $announcements = Announcement::where('audience', 'instructors')
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        return view('staff.announcement.index', compact('announcements'));
    }

    public function show($id)
    {
        $announcement = Announcement::where('posted_by_id', auth()->id())
            ->where('posted_by_type', get_class(auth()->user()))
            ->where('status', '!=', 'deleted')
            ->findOrFail($id);

        return view('staff.announcement.show', compact('announcement'));
    }

    public function view()
    {
        $user = Auth::user();
        // Get announcements posted by the logged-in instructor
        $announcements = Announcement::where('posted_by_id', auth()->id())
            ->where('posted_by_type', get_class(auth()->user()))
            ->where('status', '!=', 'deleted')
            ->orderByDesc('published_at')
            ->get();

        // Get only published courses assigned to this instructor
        $courses = $user->instructorCourses()
            ->where('status', 'published')
            ->latest();

        return view('staff.announcement.view', compact('announcements','courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'course_id' => 'required|exists:courses,id', // must select one of their courses
            'status'  => 'nullable|in:draft,published', // optional; default to published
        ]);

        // ensure instructor owns this course
        $allowedCourses = auth()->user()->instructorCourses()->pluck('id')->toArray();

        if (! in_array($request->course_id, $allowedCourses)) {
            abort(403, 'Unauthorized course selection');
        }

        $announcement = Announcement::create([
            'title'        => $request->title,
            'message'      => $request->message,
            'type'         => 'course',             // now it's course-specific
            'audience'     => 'students',           // only students enrolled in the course
            'course_id'    => $request->course_id,          // assign to instructor's course
            'status'       => $request->status ?? 'published',
            'published_at' => ($request->status ?? 'published') === 'published' ? now() : null,
            'posted_by_id' => auth()->id(),
            'posted_by_type'=> 'App\Models\User',
        ]);

        return redirect()
            ->route('staff.announcement.view')
            ->with('success', 'Announcement created successfully!');
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        // ensure instructor owns it (if needed)
        if ($announcement->posted_by_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'status'  => 'required|in:draft,published',
        ]);

        $announcement->update([
            'title'   => $request->title,
            'message' => $request->message,
            'status'  => $request->status,
            'published_at' => $request->status == 'published'
                ? ($announcement->published_at ?? now())
                : null,
        ]);

        return back()->with('success', 'Announcement updated successfully!');
    }

    public function destroy($id)
    {
        $announcement = Announcement::where('posted_by_id', auth()->id())
            ->where('posted_by_type', get_class(auth()->user()))
            ->where('id', $id)
            ->firstOrFail();

        $announcement->status = 'deleted';
        $announcement->save();

        return redirect()->route('staff.announcement.view')
            ->with('success', 'Announcement deleted successfully');
    }


}
