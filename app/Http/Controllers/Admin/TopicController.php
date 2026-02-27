<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the topics.
     */
    public function index(Request $request)
    {
        $topics = Topic::query()
            ->with('paper')
            // Filter by academic level
            ->when($request->academic_level, function ($query) use ($request) {
                $query->where('academic_level', $request->academic_level);
            })

            // Filter by paper type
            ->when($request->paper_type, function ($query) use ($request) {
                $query->where('paper_type', $request->paper_type);
            })

            // Search by department
            ->when($request->search, function ($query) use ($request) {
                $query->where('department', 'like', '%' . $request->search . '%');
            })

            ->where('status', '!=', 'deleted')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.topic.index', compact('topics'));
    }

    /**
     * Show the form for creating a new topic.
     */
    public function create()
    {
        return view('admin.topic.create');
    }

    /**
     * Store a newly created topic.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'academic_level'  => 'required|in:BSc,MSc,PhD',
            'paper_type'      => 'required|in:seminar,project',
            'department'      => 'required|string|max:255',
        ]);

        Topic::create($validated);

        return redirect()
            ->route('admin.topics.index')
            ->with('success', 'Topic created successfully.');
    }

    /**
     * Display the specified topic.
     */
    public function show(Topic $topic)
    {
        $topic->load('paper'); // ensures paper is loaded

        return view('admin.topic.show', compact('topic'));
    }

    /**
     * Show the form for editing the specified topic.
     */
    public function edit(Topic $topic)
    {
        return view('admin.topic.edit', compact('topic'));
    }

    /**
     * Update the specified topic.
     */
    public function update(Request $request, Topic $topic)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'academic_level'  => 'required|in:BSc,MSc,PhD',
            'paper_type'      => 'required|in:seminar,project',
            'department'      => 'required|string|max:255',
            'status'          => 'required|in:active,inactive',
        ]);

        $topic->update($validated);

        return redirect()
            ->route('admin.topics.index')
            ->with('success', 'Topic updated successfully.');
    }

    /**
     * Soft-delete the specified topic
     */
   public function destroy(Topic $topic)
    {
        $topic->status = 'deleted';
        $topic->save();

        return redirect()
            ->route('admin.topics.index')
            ->with('success', 'Topic deleted successfully.');
    }
}
