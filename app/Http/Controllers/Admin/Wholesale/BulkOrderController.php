<?php

namespace App\Http\Controllers\Admin\Wholesale;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
    public function index()
    {
        $bulkOrders = BulkOrder::latest()->paginate(20);

        return view('admin.wholesale.index', compact('bulkOrders'));
    }

    public function create()
    {
        return view('admin.wholesale.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // TODO: add validation rules for BulkOrder
        ]);

        $bulkOrder = BulkOrder::create($validated);

        return redirect()->route('admin.wholesale.index')->with('success', 'BulkOrder created successfully.');
    }

    public function show(BulkOrder $bulkOrder)
    {
        return view('admin.wholesale.show', compact('bulkOrder'));
    }

    public function edit(BulkOrder $bulkOrder)
    {
        return view('admin.wholesale.edit', compact('bulkOrder'));
    }

    public function update(Request $request, BulkOrder $bulkOrder)
    {
        $validated = $request->validate([
            // TODO: add validation rules for BulkOrder
        ]);

        $bulkOrder->update($validated);

        return redirect()->route('admin.wholesale.index')->with('success', 'BulkOrder updated successfully.');
    }

    public function destroy(BulkOrder $bulkOrder)
    {
        $bulkOrder->delete();

        return redirect()->route('admin.wholesale.index')->with('success', 'BulkOrder deleted successfully.');
    }
}
