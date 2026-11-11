<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::latest()->paginate(20);

        return view('admin.marketing.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.marketing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Banner
        ]);

        $banner = Banner::create($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'Banner created successfully.');
    }

    public function show(Banner $banner)
    {
        return view('admin.marketing.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.marketing.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Banner
        ]);

        $banner->update($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.marketing.index')->with('success', 'Banner deleted successfully.');
    }
}
