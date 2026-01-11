<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SystemInfo;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        // ===== COURSES AS SERVICES =====
        $courses = Course::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        // ===== SYSTEM INFO FROM DB =====
        $systemInfo = SystemInfo::first();

        return view('frontend.index', compact(
            'courses',
            'systemInfo'
        ));
    }

    public function about() {
        // ===== SYSTEM INFO FROM DB =====
        $systemInfo = SystemInfo::first();
        return view('frontend.about', compact('systemInfo'));
    }

    public function contact() {
        return view('frontend.contact');
    }

    public function services() {
        // ===== COURSES AS SERVICES =====
        $courses = Course::where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.services', compact('courses'));
    }

    public function serviceDetail($slug)
    {
        // Get the service by slug
        $service = Course::where('slug', $slug)->firstOrFail();

        // Get all services for sidebar
        $allServices = Course::where('status', 'published')
            ->get();

        return view('frontend.services_detail', compact('service', 'allServices'));
    }
    
}
