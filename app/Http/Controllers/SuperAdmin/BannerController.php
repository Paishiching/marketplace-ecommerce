<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BannerController extends Controller
{
    private const UPLOAD_DIR = 'uploads/banners';

    private const IMAGE_RULE_REQUIRED = 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096';
    private const IMAGE_RULE_OPTIONAL = 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096';

    public function index(Request $request)
    {
        $query = Banner::query()->orderBy('position')->orderBy('sort_order')->latest('id');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        if ($request->filled('position')) {
            $query->where('position', $request->input('position'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $banners   = $query->paginate(20)->withQueryString();
        $positions = Banner::POSITIONS;
        $groups    = Banner::positionGroups();

        // Position wise active banner count (overview card er jonno)
        $activeCounts = Banner::where('status', true)
            ->selectRaw('position, COUNT(*) as total')
            ->groupBy('position')
            ->pluck('total', 'position');

        $stats = [
            'total'    => Banner::count(),
            'active'   => Banner::where('status', true)->count(),
            'inactive' => Banner::where('status', false)->count(),
        ];

        return view('superadmin.banners.index', compact('banners', 'stats', 'positions', 'groups', 'activeCounts'));
    }

    public function create(Request $request)
    {
        $banner    = new Banner();
        $positions = Banner::POSITIONS;

        return view('superadmin.banners.create', compact('banner', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:150',
            'image'      => self::IMAGE_RULE_REQUIRED,
            'link'       => 'nullable|url|max:255',
            'position'   => ['required', Rule::in(array_keys(Banner::POSITIONS))],
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'status'     => 'boolean',
        ]);

        $validated['image']      = $this->uploadImage($request->file('image'));
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['status']     = $request->boolean('status');

        Banner::create($validated);

        return redirect()->route('superadmin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        $positions = Banner::POSITIONS;

        return view('superadmin.banners.edit', compact('banner', 'positions'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:150',
            'image'      => self::IMAGE_RULE_OPTIONAL,
            'link'       => 'nullable|url|max:255',
            'position'   => ['required', Rule::in(array_keys(Banner::POSITIONS))],
            'sort_order' => 'nullable|integer|min:0|max:9999',
            'status'     => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($banner->image);
            $validated['image'] = $this->uploadImage($request->file('image'));
        } else {
            unset($validated['image']);
        }

        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['status']     = $request->boolean('status');

        $banner->update($validated);

        return redirect()->route('superadmin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $this->deleteImage($banner->image);
        $banner->delete();

        return redirect()->route('superadmin.banners.index')->with('success', 'Banner deleted successfully.');
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