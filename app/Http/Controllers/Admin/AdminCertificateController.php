<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminCertificateController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status'); // filter

        $enrollments = Enrollment::with(['student', 'course', 'certificate'])
            ->when($status === 'issued', function ($query) {
                $query->whereHas('certificate');
            })
            ->when($status === 'pending', function ($query) {
                $query->whereDoesntHave('certificate');
            })
            ->latest()
            ->get();

        return view('admin.certificate.index', compact('enrollments'));
    }

    public function generateCode()
    {
        do {
            $code = 'CERT-' . strtoupper(Str::random(9));
        } while (Certificate::where('certificate_code', $code)->exists());

        return response()->json(['code' => $code]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id|unique:certificates,enrollment_id',
            'certificate_code' => 'required|unique:certificates,certificate_code',
            'thumbnail'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file_path'      => 'required|mimes:pdf|max:2048',
        ]);

        // -------- Handle Thumbnail Upload (Optional) --------
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $destinationPath = public_path('uploads/certificates/thumbnails');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $thumbnailName = $request->certificate_code . '_' . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move($destinationPath, $thumbnailName);

            // Relative path to store in DB
            $thumbnailPath = 'certificates/thumbnails/' . $thumbnailName;
        }

        // -------- Handle PDF Upload --------
        $pdfDestination = public_path('uploads/certificates/pdfs');
        if (!file_exists($pdfDestination)) {
            mkdir($pdfDestination, 0777, true);
        }

        $pdfName = $request->certificate_code . '_' . time() . '.' . $request->file_path->extension();
        $request->file_path->move($pdfDestination, $pdfName);

        $pdfPath = 'certificates/pdfs/' . $pdfName;

        // -------- Create Certificate --------
        $certificate = Certificate::create([
            'enrollment_id'    => $request->enrollment_id,
            'certificate_code' => $request->certificate_code,
            'thumbnail'        => $thumbnailPath,
            'file_path'        => $pdfPath,
            'issued_at'        => now(),
        ]);

        return redirect()->route('admin.certificates.show', $certificate->id)
            ->with('success', 'Certificate uploaded successfully!');
    }

    public function show($id)
    {
        // Fetch certificate with its enrollment, student, and course
        $certificate = Certificate::with([
            'enrollment.student',       // Student info
            'enrollment.course'      // Course info
        ])->findOrFail($id);

        // Optional: You could also eager load module/assignment progress if you track them
        // $certificate->load('enrollment.modules', 'enrollment.assignments');

        return view('admin.certificate.show', compact('certificate'));
    }
    
    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'file_path' => 'nullable|mimes:pdf|max:2048',
        ]);

        // -------- Handle Thumbnail Update --------
        if ($request->hasFile('thumbnail')) {
            if ($certificate->thumbnail && File::exists(public_path('uploads/' . $certificate->thumbnail))) {
                File::delete(public_path('uploads/' . $certificate->thumbnail));
            }

            $destinationPath = public_path('uploads/certificates/thumbnails');
            if (!file_exists($destinationPath)) mkdir($destinationPath, 0777, true);

            $thumbnailName = $certificate->certificate_code . '_' . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move($destinationPath, $thumbnailName);

            $certificate->thumbnail = 'certificates/thumbnails/' . $thumbnailName;
        }

        // -------- Handle PDF Update --------
        if ($request->hasFile('file_path')) {
            if ($certificate->file_path && File::exists(public_path('uploads/' . $certificate->file_path))) {
                File::delete(public_path('uploads/' . $certificate->file_path));
            }

            $pdfDestination = public_path('uploads/certificates/pdfs');
            if (!file_exists($pdfDestination)) mkdir($pdfDestination, 0777, true);

            $pdfName = $certificate->certificate_code . '_' . time() . '.' . $request->file_path->extension();
            $request->file_path->move($pdfDestination, $pdfName);

            $certificate->file_path = 'certificates/pdfs/' . $pdfName;
        }

        $certificate->issued_at = now();
        $certificate->save();

        return redirect()->back()->with('success', 'Certificate updated successfully!');
    }

    public function destroy(Certificate $certificate)
    {
        // Delete associated files if exist
        if ($certificate->thumbnail && File::exists(public_path('uploads/' . $certificate->thumbnail))) {
            File::delete(public_path('uploads/' . $certificate->thumbnail));
        }

        if ($certificate->file_path && File::exists(public_path('uploads/' . $certificate->file_path))) {
            File::delete(public_path('uploads/' . $certificate->file_path));
        }

        // Delete the database record
        $certificate->delete();

        return redirect()->back()->with('success', 'Certificate deleted successfully!');
    }
}
