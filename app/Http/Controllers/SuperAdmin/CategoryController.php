<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // নতুন category সবার আগে, পুরনোগুলো নিচে (DataTable নিজে pagination করবে)
        $categories = Category::with('parent')->latest('id')->get();

        return view('superadmin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->get(['id', 'name']);

        return view('superadmin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'slug'      => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'image'     => ['nullable', 'image', 'max:2048'],
            'status'    => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');
        $validated['parent_id'] = $validated['parent_id'] ?: null;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('superadmin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load('parent', 'children');

        return view('superadmin.categories.show', compact('category'));
    }

    public function edit(Request $request, Category $category)
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->where('id', '!=', $category->id)
            ->get(['id', 'name']);

        $returnPage = (int) $request->query('page', 1);

        return view('superadmin.categories.edit', compact('category', 'parentCategories', 'returnPage'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'slug'      => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'image'     => ['nullable', 'image', 'max:2048'],
            'status'    => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? $category->slug;
        $validated['status'] = $request->boolean('status');
        $validated['parent_id'] = $validated['parent_id'] ?: null;

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        // index-এ ফিরে ওই category-র row-তে যাবে (anchor)
        return redirect(route('superadmin.categories.index') . '#category-' . $category->id)
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('superadmin.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function subCategories($categoryId)
    {
        $subCategories = Category::where('parent_id', $categoryId)->get(['id', 'name']);

        return response()->json($subCategories);
    }
}
