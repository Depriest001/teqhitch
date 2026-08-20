<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class ViewTopicController extends Controller
{
    /**
     * Render the initial portal page with initial Blade data.
     */
    public function index(Request $request)
    {
        $departments = Topic::where('status', 'active')
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department');

        $paperTypes = Topic::where('status', 'active')
            ->whereNotNull('paper_type')
            ->distinct()
            ->pluck('paper_type');

        $topics = $this->getFilteredQuery($request)->get();

        return view('topics.index', compact('topics', 'departments', 'paperTypes'));
    }

    /**
     * AJAX endpoint returning server-rendered Blade HTML partials.
     */
    public function filter(Request $request)
    {
        $topics = $this->getFilteredQuery($request)->get();

        return response()->json([
            'html'  => view('topics.partials.cards', compact('topics'))->render(),
            'count' => $topics->count(),
        ]);
    }

    /**
     * Shared filter logic.
     */
    private function getFilteredQuery(Request $request)
    {
        $query = Topic::where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department') && $request->department !== 'All') {
            $query->where('department', $request->department);
        }

        if ($request->filled('paper_type') && $request->paper_type !== 'All') {
            $query->where('paper_type', $request->paper_type);
        }

        return $query->latest();
    }
}
