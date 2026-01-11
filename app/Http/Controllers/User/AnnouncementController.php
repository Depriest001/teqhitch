<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AnnouncementRead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $studentId = Auth::id();

        $query = Announcement::where('status', 'published')
            ->where(function ($q) {
                $q->where('audience', 'all')
                  ->orWhere('audience', 'students');
            })
            ->with(['course'])
            ->latest('published_at');

        // Filter
        if ($request->filter === 'course') {
            $query->where('type', 'course');
        }

        $announcements = $query->get()->map(function ($announcement) use ($studentId) {
            $announcement->is_read = $announcement->reads()
                ->where('student_id', $studentId)
                ->exists();
            return $announcement;
        });

        return view('user.announcement', compact('announcements'));
    }

    public function markAsRead(Announcement $announcement)
    {
        AnnouncementRead::firstOrCreate(
            [
                'announcement_id' => $announcement->id,
                'student_id' => Auth::id(),
            ],
            [
                'read_at' => now(),
            ]
        );

        return response()->json(['status' => 'ok']);
    }

    public function show() {
        return view('user.announcement.grade');
    }

}
