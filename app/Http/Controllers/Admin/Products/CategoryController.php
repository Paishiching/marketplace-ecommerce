<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->withCount('products')->latest()->paginate(20);

        return view('admin.products.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->where('status', 1)->orderBy('name')->get(['id', 'name']);

        return view('admin.products.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'slug' => ['nullable', 'string', 'max:191', Rule::unique('categories', 'slug')],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['slug'] = $this->uniqueSlug($validated['slug'] ?: $validated['name']);
        $validated['status'] = $request->boolean('status') ? 1 : 0;
        $validated['parent_id'] = $validated['parent_id'] ?: null;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        try {
            Category::create($validated);
        } catch (\Throwable $exception) {
            if (! empty($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            throw $exception;
        }

        return redirect()->route('admin.products.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.products.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.products.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Category
        ]);

        $category->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.products.index')->with('success', 'Category deleted successfully.');
    }

    private function uniqueSlug(string $value): string
    {
        $base = Str::slug($value) ?: 'category';
        $slug = $base;
        $suffix = 2;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $suffix++;
        }

        return $slug;
    }
}
