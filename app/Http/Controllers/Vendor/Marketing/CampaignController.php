<?php

namespace App\Http\Controllers\Vendor\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(20);

        return view('vendor.marketing.index', compact('campaigns'));
    }

    public function create()
    {
        return view('vendor.marketing.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Campaign
        ]);

        $campaign = Campaign::create($validated);

        return redirect()->route('vendor.marketing.index')->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign)
    {
        return view('vendor.marketing.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        return view('vendor.marketing.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Campaign
        ]);

        $campaign->update($validated);

        return redirect()->route('vendor.marketing.index')->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('vendor.marketing.index')->with('success', 'Campaign deleted successfully.');
    }
}
