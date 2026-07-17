<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $filename = null;

        if ($request->hasFile('image')) {
            $destinationPath = public_path('uploads/news');

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Generate unique filename
            $filename = uniqid() . '_' . time() . '.' . $request->image->extension();
            $request->image->move($destinationPath, $filename);
        }

        $body = $this->sanitizeAndClassify($request->input('body'));

        News::create([
            'title' => $request->title,
            'category' => $request->category,
            'icon' => $request->icon,
            'read_minutes' => $request->read_minutes,
            'excerpt' => $request->excerpt,
            'image' => $filename,
            'body' => $body,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News post created.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'body' => 'required|string',
            'image' => 'nullable|image|max:4096',
        ]);

        $data = $request->except('image');
        $data['body'] = $this->sanitizeAndClassify($request->input('body'));
        $data['is_published'] = (bool) $request->is_published;

        if ($request->hasFile('image')) {
            $destinationPath = public_path('uploads/news');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Delete old image if it exists
            if ($news->image && file_exists($destinationPath . '/' . $news->image)) {
                unlink($destinationPath . '/' . $news->image);
            }

            $filename = uniqid() . '_' . time() . '.' . $request->image->extension();
            $request->image->move($destinationPath, $filename);

            $data['image'] = $filename;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News post updated.');
    }

    public function destroy(News $news)
    {
        // Delete the image file too
        if ($news->image) {
            $imagePath = public_path('uploads/news/' . $news->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News post deleted.');
    }

    /**
     * Sanitize HTML from CKEditor without a purifier package.
     * Strips disallowed tags and dangerous attributes, then
     * auto-injects your brand classes onto lists/quotes.
     */
    protected function sanitizeAndClassify(string $html): string
    {
        $allowedTags = '<p><h3><h4><ul><ol><li><strong><em><b><i><a><blockquote><img><br><table><thead><tbody><tr><td><th>';
        $clean = strip_tags($html, $allowedTags);

        $clean = preg_replace('/\s(on\w+|style)\s*=\s*"[^"]*"/i', '', $clean);
        $clean = preg_replace("/\s(on\w+|style)\s*=\s*'[^']*'/i", '', $clean);
        $clean = preg_replace('/javascript\s*:/i', '', $clean);

        $clean = preg_replace_callback('/<(a|img)\b[^>]*>/i', function ($m) {
            $tag = strtolower($m[1]);
            preg_match('/\shref\s*=\s*(["\'])(.*?)\1/i', $m[0], $href);
            preg_match('/\ssrc\s*=\s*(["\'])(.*?)\1/i', $m[0], $src);
            preg_match('/\salt\s*=\s*(["\'])(.*?)\1/i', $m[0], $alt);
            preg_match('/\sclass\s*=\s*(["\'])(.*?)\1/i', $m[0], $class);

            if ($tag === 'a') {
                $hrefVal = $href[2] ?? '#';
                $classAttr = isset($class[2]) ? " class=\"{$class[2]}\"" : '';
                return "<a href=\"{$hrefVal}\" target=\"_blank\" rel=\"noopener noreferrer\"{$classAttr}>";
            }

            if ($tag === 'img') {
                $srcVal = $src[2] ?? '';
                $altVal = $alt[2] ?? '';
                $classAttr = isset($class[2]) ? " class=\"{$class[2]}\"" : '';
                return "<img src=\"{$srcVal}\" alt=\"{$altVal}\"{$classAttr}>";
            }

            return $m[0];
        }, $clean);

        $clean = preg_replace_callback('/<(p|ul|blockquote)\s+class="([^"]*)"/i', function ($m) {
            $tag = $m[1];
            $classes = $m[2];
            $allowed = ['lead-paragraph', 'news-detail-list', 'news-detail-quote'];
            $kept = array_intersect(explode(' ', $classes), $allowed);
            return $kept ? "<{$tag} class=\"" . implode(' ', $kept) . "\"" : "<{$tag}";
        }, $clean);

        $clean = preg_replace('/<ul(?![^>]*class=)/i', '<ul class="news-detail-list"', $clean);
        $clean = preg_replace('/<blockquote(?![^>]*class=)/i', '<blockquote class="news-detail-quote"', $clean);
        $clean = preg_replace('/<p(?![^>]*class=)/i', '<p class="lead-paragraph"', $clean, 1);

        return $clean;
    }
}