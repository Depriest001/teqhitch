<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiwesApplication;
use App\Models\SiwesTrack;
use Illuminate\Http\Request;

class AdminSiwesApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = SiwesApplication::with('track')->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('payment_status', $status);
        }

        if ($trackId = $request->query('track')) {
            $query->where('track_id', $trackId);
        }

        $applications = $query->paginate(15)->withQueryString();

        return view('admin.siwes.index', [
            'applications' => $applications,
            'tracks'       => SiwesTrack::orderBy('name')->pluck('name', 'id'),
            'filters'      => $request->only(['search', 'status', 'track']),
        ]);
    }

    public function show(SiwesApplication $application)
    {
        $application->load('track');

        return view('admin.siwes.show', compact('application'));
    }
}