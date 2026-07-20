<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Gallery::latest()->get();

        return view('admin.gallery.index', compact('gallery'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        
        $destinationPath = public_path('uploads/gallery');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $filename = Str::slug($validated['title'] ?? 'gallery') . '-' . time() . '.' . $request->image->extension();
        $request->image->move($destinationPath, $filename);

        $validated['image'] = 'gallery/' . $filename;
        Gallery::create($validated);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Image added to gallery.');
    }

    public function destroy($id)
    {
        $item = Gallery::findOrFail($id);

        if ($item->image && file_exists(public_path('uploads/' . $item->image))) {
            unlink(public_path('uploads/' . $item->image));
        }

        $item->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Image deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $item = Gallery::findOrFail($id);
        $item->status = ! $item->status;
        $item->save();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Image status updated.');
    }
}