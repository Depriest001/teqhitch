<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\EnrollmentApplication;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EnrollmentApplicationController extends Controller
{
    public function index(Request $request)
    {
        $enrollments = $this->filteredQuery($request)->paginate(15)->withQueryString();
        $courses = Course::all();

        return view('admin.enrollments.index', compact('enrollments', 'courses'));
    }

    public function show(EnrollmentApplication $enrollment)
    {
        return view('admin.enrollments.show', compact('enrollment'));
    }

    public function destroy(EnrollmentApplication $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('admin.enrollments.index')->with('success', 'Application deleted.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'action' => 'required|in:approve,reject,delete',
        ]);

        $query = EnrollmentApplication::whereIn('id', $request->ids);

        match ($request->action) {
            'approve' => $query->update(['status' => 'approved']),
            'reject'  => $query->update(['status' => 'rejected']),
            'delete'  => $query->delete(),
        };

        $message = match ($request->action) {
            'approve' => 'Selected applications approved.',
            'reject'  => 'Selected applications rejected.',
            'delete'  => 'Selected applications deleted.',
        };

        return redirect()->route('admin.enrollments.index')->with('success', $message);
    }

    public function exportAll(): StreamedResponse
    {
        return $this->streamCsv(EnrollmentApplication::with('course')->latest()->get(), 'enrollments-all.csv');
    }

    public function exportFiltered(Request $request): StreamedResponse
    {
        $enrollments = $this->filteredQuery($request)->get();

        return $this->streamCsv($enrollments, 'enrollments-filtered.csv');
    }

    protected function streamCsv($enrollments, string $filename): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($enrollments) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['S/N', 'First Name', 'Last Name', 'Email', 'Phone', 'Program', 'Status', 'Applied On']);

            foreach ($enrollments as $index => $item) {
                $index++;
                fputcsv($file, [
                    $index,
                    $item->first_name,
                    $item->last_name,
                    $item->email,
                    $item->phone,
                    $item->course->title ?? '—',
                    ucfirst($item->status ?? 'pending'),
                    $item->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Shared filter logic for both the index listing and filtered export.
     */
    protected function filteredQuery(Request $request)
    {
        $query = EnrollmentApplication::with('course')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }
}