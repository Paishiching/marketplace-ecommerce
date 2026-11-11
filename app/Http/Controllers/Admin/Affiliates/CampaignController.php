<?php

namespace App\Http\Controllers\Admin\Affiliates;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(20);

        return view('admin.affiliates.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.affiliates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Campaign
        ]);

        $campaign = Campaign::create($validated);

        return redirect()->route('admin.affiliates.index')->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign)
    {
        return view('admin.affiliates.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.affiliates.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Campaign
        ]);

        $campaign->update($validated);

        return redirect()->route('admin.affiliates.index')->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('admin.affiliates.index')->with('success', 'Campaign deleted successfully.');
    }
}
