<?php

namespace App\Http\Controllers\Admin\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(20);

        return view('admin.marketing.index', compact('advertisements'));
    }

    public function create()
    {
        return view('admin.marketing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Advertisement
        ]);

        $advertisement = Advertisement::create($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'Advertisement created successfully.');
    }

    public function show(Advertisement $advertisement)
    {
        return view('admin.marketing.show', compact('advertisement'));
    }

    public function edit(Advertisement $advertisement)
    {
        return view('admin.marketing.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Advertisement
        ]);

        $advertisement->update($validated);

        return redirect()->route('admin.marketing.index')->with('success', 'Advertisement updated successfully.');
    }

    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        return redirect()->route('admin.marketing.index')->with('success', 'Advertisement deleted successfully.');
    }
}
