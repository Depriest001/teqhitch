<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiwesTrack;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiwesTrackController extends Controller
{
    public function index(Request $request)
    {
        $tracks = SiwesTrack::withCount('applications')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.siwes.tracks.index', [
            'tracks' => $tracks,
        ]);
    }

    public function create()
    {
        return view('admin.siwes.tracks.create', [
            'track' => new SiwesTrack(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTrack($request);

        $track = SiwesTrack::create($validated);

        return redirect()
            ->route('admin.siwes.tracks.edit', $track)
            ->with('status', 'Track created successfully.');
    }

    public function edit(SiwesTrack $track)
    {
        return view('admin.siwes.tracks.edit', [
            'track' => $track,
        ]);
    }

    public function update(Request $request, SiwesTrack $track): RedirectResponse
    {
        $validated = $this->validateTrack($request, $track);

        $track->update($validated);

        return redirect()
            ->route('admin.siwes.tracks.edit', $track)
            ->with('status', 'Track updated successfully.');
    }

    public function destroy(SiwesTrack $track): RedirectResponse
    {
        if ($track->applications()->exists()) {
            return redirect()
                ->route('admin.siwes.tracks.index')
                ->with('error', 'Cannot delete a track that has applications attached to it.');
        }

        $track->delete();

        return redirect()
            ->route('admin.siwes.tracks.index')
            ->with('status', 'Track deleted successfully.');
    }

    protected function validateTrack(Request $request, ?SiwesTrack $track = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('siwes_tracks', 'name')->ignore($track?->id),
            ],
            'price' => [
                'required',
                'numeric',
                'min:' . SiwesTrack::MINIMUM_PRICE,
            ],
        ]);
    }
}