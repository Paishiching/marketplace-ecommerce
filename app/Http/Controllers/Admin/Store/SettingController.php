<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::latest()->paginate(20);

        return view('admin.store.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.store.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Setting
        ]);

        $setting = Setting::create($validated);

        return redirect()->route('admin.store.index')->with('success', 'Setting created successfully.');
    }

    public function show(Setting $setting)
    {
        return view('admin.store.show', compact('setting'));
    }

    public function edit(Setting $setting)
    {
        return view('admin.store.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Setting
        ]);

        $setting->update($validated);

        return redirect()->route('admin.store.index')->with('success', 'Setting updated successfully.');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('admin.store.index')->with('success', 'Setting deleted successfully.');
    }
}
