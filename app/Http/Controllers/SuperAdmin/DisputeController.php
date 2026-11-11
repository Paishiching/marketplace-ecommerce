<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;

class DisputeController extends Controller
{
    public function index()
    {
        $disputes = Dispute::latest()->paginate(20);

        return view('super-admin.index', compact('disputes'));
    }

    public function create()
    {
        return view('super-admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Dispute
        ]);

        $dispute = Dispute::create($validated);

        return redirect()->route('super-admin.index')->with('success', 'Dispute created successfully.');
    }

    public function show(Dispute $dispute)
    {
        return view('super-admin.show', compact('dispute'));
    }

    public function edit(Dispute $dispute)
    {
        return view('super-admin.edit', compact('dispute'));
    }

    public function update(Request $request, Dispute $dispute)
    {
        $validated = $request->validate([
            // TODO: add validation rules for Dispute
        ]);

        $dispute->update($validated);

        return redirect()->route('super-admin.index')->with('success', 'Dispute updated successfully.');
    }

    public function destroy(Dispute $dispute)
    {
        $dispute->delete();

        return redirect()->route('super-admin.index')->with('success', 'Dispute deleted successfully.');
    }
}
