<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SystemInfo;
use App\Models\TeamMember;
use App\Models\Testimony;
use App\Models\News;
use App\Models\EnrollmentApplication;
use App\Models\Product;
use App\Models\Gallery;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index()
    {
        // ===== COURSES AS SERVICES =====
        $courses = Course::where('status', 'published')
            ->take(6)
            ->get();

        $team = TeamMember::active()
            ->take(4)
            ->get();

        $testimonies = Testimony::active()
            ->latest()
            ->take(6)
            ->get();

        $news = News::published()
            ->latest()
            ->take(6)
            ->get();
        
        $products = Product::active()
            ->latest()
            ->take(3)
            ->get();

        $gallerys = Gallery::active()
            ->latest()
            ->take(6)
            ->get();

        // ===== SYSTEM INFO FROM DB =====
        $systemInfo = SystemInfo::first();

        return view('frontend.index', compact(
            'courses',
            'team',
            'testimonies',
            'news',
            'products',
            'gallerys',
            'systemInfo'
        ));
    }

    public function about() {
        // ===== SYSTEM INFO FROM DB =====
        $systemInfo = SystemInfo::first();
        $team = TeamMember::active()
            ->latest()
            ->take(4)
            ->get();
        return view('frontend.about', compact('systemInfo','team'));
    }

    public function contact() {
        $systemInfo = SystemInfo::first();
        return view('frontend.contact', compact('systemInfo'));
    }

    public function services() {
        // ===== COURSES AS SERVICES =====
        $courses = Course::where('status', 'published')
            ->take(6)
            ->get();

        return view('frontend.services', compact('courses'));
    }

    public function news() {
        $news = News::published()->latest()->take(9)->get();
        return view('frontend.news', compact('news'));
    }

    public function products() {
        $products = Product::active()->latest()->get();
        return view('frontend.products', compact('products'));
    }

    public function newsdetail(News $news) {
        // News is resolved via slug (getRouteKeyName)
        $keywords = collect(explode(' ', $news->title))
            ->map(fn($word) => trim(preg_replace('/[^A-Za-z0-9]/', '', $word))) // remove punctuation
            ->filter(fn($word) => strlen($word) > 3) 
            ->toArray();

        $relateds = News::published()
            ->where('id', '!=', $news->id) // Exclude current article
            ->where(function ($query) use ($keywords) {
                // Loop through each keyword and find matches in the title column
                foreach ($keywords as $keyword) {
                    $query->orWhere('title', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->latest()
            ->take(3)
            ->get();

        // Fallback: If no keyword matches are found, grab the latest 3 posts instead
        if ($relateds->isEmpty()) {
            $relateds = News::published()
                ->where('id', '!=', $news->id)
                ->latest()
                ->take(3)
                ->get();
        }

        $relateds = News::published()
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        $recents = News::published()
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.news-details', compact('news', 'relateds', 'recents'));
    }

    public function enroll() {
        $courses = Course::where('status', 'published')
            ->get();
        return view('frontend.enroll', compact('courses'));
    }

    public function storeEnroll(Request $request)
    {
        // Validate structural inputs
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'mode'       => 'required|string|in:onsite,online',
            'course_id'  => 'required|exists:courses,id',
            'email'      => [
                'required',
                'email',
                'max:255',
                // Laravel check: Fails validation if this exact email + course_id pair already exists
                Rule::unique('enrollment_applications')->where(function ($query) use ($request) {
                    return $query->where('course_id', $request->course_id);
                })
            ],
        ], [
            'email.unique' => 'You have already submitted an application for this specific course program.'
        ]);

        // If safe, save the record
        EnrollmentApplication::create($validated);

        return redirect()->back()->with('success', 'Your application has been received successfully!');
    }
}
