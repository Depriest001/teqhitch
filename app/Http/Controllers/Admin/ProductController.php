<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        // Not used directly — create form is an offcanvas on the index page
        return redirect()->route('admin.product.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:software,website',
            'link'        => 'nullable|url|max:255',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {

            $destinationPath = public_path('uploads/products');

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Generate unique filename
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move($destinationPath, $filename);

            $validated['thumbnail'] = 'products/' . $filename;
        }

        Product::create($validated);

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product added successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:software,website',
            'link'        => 'nullable|url|max:255',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($product->thumbnail && file_exists(public_path('uploads/' . $product->thumbnail))) {
                unlink(public_path('uploads/' . $product->thumbnail));
            }

            $destinationPath = public_path('uploads/products');

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Generate unique filename
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $request->thumbnail->extension();
            $request->thumbnail->move($destinationPath, $filename);

            $validated['thumbnail'] = 'products/' . $filename;
        }

        $product->update($validated);

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->thumbnail && file_exists(public_path('uploads/' . $product->thumbnail))) {
            unlink(public_path('uploads/' . $product->thumbnail));
        }

        $product->delete();

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = ! $product->status;
        $product->save();

        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Product status updated.');
    }
}