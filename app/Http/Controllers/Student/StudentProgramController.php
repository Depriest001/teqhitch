<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class StudentProgramController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $student->load(['siwesApplication.track', 'enrollmentApplication.course']);

        $enrolledCourseId = $student->enrollmentApplication?->course_id;

        $availableCourses = Course::when($enrolledCourseId, fn ($q) => $q->where('id', '!=', $enrolledCourseId))
            ->orderBy('title')
            ->get();

        return view('student.programs.index', [
            'student'          => $student,
            'programName'      => $student->program_name,
            'availableCourses' => $availableCourses,
        ]);
    }
}