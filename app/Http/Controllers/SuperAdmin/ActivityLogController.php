<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::latest()->paginate(20);

        return view('super-admin.index', compact('activityLogs'));
    }

    public function create()
    {
        return view('super-admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ActivityLog
        ]);

        $activityLog = ActivityLog::create($validated);

        return redirect()->route('super-admin.index')->with('success', 'ActivityLog created successfully.');
    }

    public function show(ActivityLog $activityLog)
    {
        return view('super-admin.show', compact('activityLog'));
    }

    public function edit(ActivityLog $activityLog)
    {
        return view('super-admin.edit', compact('activityLog'));
    }

    public function update(Request $request, ActivityLog $activityLog)
    {
        $validated = $request->validate([
            // TODO: add validation rules for ActivityLog
        ]);

        $activityLog->update($validated);

        return redirect()->route('super-admin.index')->with('success', 'ActivityLog updated successfully.');
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()->route('super-admin.index')->with('success', 'ActivityLog deleted successfully.');
    }
}
