<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;

class StaffStudentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('student', 'course')
            ->whereHas('course', function ($query) {
                $query->where('instructor_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('staff.student.index', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = $enrollment = Enrollment::with('student','course')
            ->where('id',$id)
            ->whereHas('course', fn($q)=>$q->where('instructor_id',auth()->id()))
            ->firstOrFail();

        return view('staff.student.show', compact('enrollment'));
    }
}

