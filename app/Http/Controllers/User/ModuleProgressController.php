<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CourseModule;
use App\Models\Enrollment;
use App\Models\ModuleProgress;
use Illuminate\Support\Facades\Auth;

class ModuleProgressController extends Controller
{
    public function complete(CourseModule $module)
    {
        // Ensure user is enrolled in the course
        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $module->course_id)
            ->firstOrFail();

        // Mark module as completed
        ModuleProgress::updateOrCreate(
            [
                'enrollment_id' => $enrollment->id,
                'module_id' => $module->id,
            ],
            [
                'status' => 'completed',
                'completed_at' => now(),
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Module marked as completed.');
    }
}

