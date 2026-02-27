<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paper;
use App\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PapersController extends Controller
{
    /**
     * Store or update paper & software for a topic
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|exists:topics,id',
            'title' => 'required|string|max:255',
            'paper_file' => 'nullable|mimes:pdf,doc,docx|max:10240', // max 10MB
            'software_file' => 'nullable|mimes:zip,rar|max:51200'     // max 50MB
        ]);

        // Get topic
        $topic = Topic::findOrFail($request->topic_id);

        // Retrieve existing paper or create new
        $paper = Paper::firstOrNew(['topic_id' => $topic->id]);

        $paper->title = $request->title;

        // -------- Upload Paper --------
        if ($request->hasFile('paper_file')) {

            // Delete old file if exists
            if ($paper->paper_path && Storage::disk('public')->exists($paper->paper_path)) {
                Storage::disk('public')->delete($paper->paper_path);
            }

            $file = $request->file('paper_file');

            // Clean title for filename
            $cleanTitle = Str::slug($topic->title);

            // Generate filename
            $fileName = $cleanTitle . '-paper-' . now()->format('Ymd-His') . '.' . $file->getClientOriginalExtension();

            // Store file
            $paper->paper_path = $file->storeAs('topics/papers', $fileName, 'public');
        }

        // -------- Upload Software (only if project) --------
        if ($topic->paper_type === 'project' && $request->hasFile('software_file')) {

            // Delete old software if exists
            if ($paper->software_path && Storage::disk('public')->exists($paper->software_path)) {
                Storage::disk('public')->delete($paper->software_path);
            }

            $file = $request->file('software_file');

            $cleanTitle = Str::slug($topic->title);

            $fileName = $cleanTitle . '-software-' . now()->format('Ymd-His') . '.' . $file->getClientOriginalExtension();

            $paper->software_path = $file->storeAs('topics/software', $fileName, 'public');
        }

        $paper->save();

        return back()->with('success', 'Files uploaded successfully.');
    }

    /**
     * Download paper
     */
    public function download($id)
    {
        $paper = Paper::findOrFail($id);

        if (!$paper->paper_path || !Storage::disk('public')->exists($paper->paper_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($paper->paper_path);
    }

    /**
     * Download software
     */
    public function downloadSoftware($id)
    {
        $paper = Paper::findOrFail($id);

        if (!$paper->software_path || !Storage::disk('public')->exists($paper->software_path)) {
            abort(404, 'Software file not found.');
        }

        return Storage::disk('public')->download($paper->software_path);
    }
}
