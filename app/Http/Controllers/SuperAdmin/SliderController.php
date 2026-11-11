<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    private const UPLOAD_DIR = 'uploads/sliders';

    public function index(Request $request)
    {
        $query = Slider::orderBy('sort_order')->latest();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $sliders = $query->paginate(20)->withQueryString();

        $stats = [
            'total'    => Slider::count(),
            'active'   => Slider::where('status', true)->count(),
            'inactive' => Slider::where('status', false)->count(),
        ];

        return view('superadmin.sliders.index', compact('sliders', 'stats'));
    }

    public function create()
    {
        $slider = new Slider(['sort_order' => (int) Slider::max('sort_order') + 1]);

        return view('superadmin.sliders.create', compact('slider'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:150',
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'link'       => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status'     => 'boolean',
        ]);

        $validated['image']      = $this->uploadImage($request->file('image'));
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['status']     = $request->boolean('status');

        Slider::create($validated);

        return redirect()->route('superadmin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('superadmin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:150',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'link'       => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status'     => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($slider->image);
            $validated['image'] = $this->uploadImage($request->file('image'));
        } else {
            unset($validated['image']);
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['status']     = $request->boolean('status');

        $slider->update($validated);

        return redirect()->route('superadmin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteImage($slider->image);
        $slider->delete();

        return redirect()->route('superadmin.sliders.index')->with('success', 'Slider deleted successfully.');
    }

    private function uploadImage(UploadedFile $file): string
    {
        $name = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path(self::UPLOAD_DIR), $name);

        return $name;
    }

    private function deleteImage(?string $name): void
    {
        if ($name) {
            File::delete(public_path(self::UPLOAD_DIR . '/' . $name));
        }
    }
}
