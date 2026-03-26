<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with([
                'course',
                'moduleProgress',
                'certificate' // may be null
            ])
            ->where('student_id', auth()->id())
            ->latest()
            ->get();

        return view('user.certificate.index', compact('enrollments'));
    }

    // public function show() {
    //     return view('user.certificate.show');
    // }
    public function show(Certificate $certificate)
    {
        // ensure user owns this certificate
        if ($certificate->enrollment->student_id !== auth()->id()) {
            abort(403);
        }

        $certificate->load(['enrollment.course', 'enrollment.student']);

        return view('user.certificate.show', compact('certificate'));
    }

    public function download(Certificate $certificate)
    {
        // Security: ensure user owns this certificate
        if ($certificate->enrollment->student_id !== auth()->id()) {
            abort(403);
        }

        // If you already generated a PDF file
        if ($certificate->file_path && file_exists(public_path('uploads/' . $certificate->file_path))) {
            return response()->download(
                public_path('uploads/' . $certificate->file_path),
                'certificate-' . $certificate->certificate_code . '.pdf'
            );
        }

        // Fallback: generate PDF on the fly (optional)
        return back()->with('error', 'Certificate file not found.');
    }
}
