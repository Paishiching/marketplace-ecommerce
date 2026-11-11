<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Rfq;
use App\Models\Supplier;
use Illuminate\Http\Request;

class RfqController extends Controller
{
    private function supplier(): Supplier
    {
        return Supplier::where('user_id', auth()->id())->where('status', 'approved')->firstOrFail();
    }

    public function index()
    {
        $rfqs = Rfq::where('status', 'open')->withCount('quotes')->latest()->paginate(20);
        return view('supplier.rfqs.index', compact('rfqs'));
    }

    public function show(Rfq $rfq)
    {
        abort_unless($rfq->status === 'open', 404);
        $supplier = $this->supplier();
        $quote = $rfq->quotes()->where('supplier_id', $supplier->id)->first();
        return view('supplier.rfqs.show', compact('rfq', 'quote'));
    }

    public function quote(Request $request, Rfq $rfq)
    {
        abort_unless($rfq->status === 'open', 404);
        $supplier = $this->supplier();
        $data = $request->validate([
            'unit_price' => ['required', 'numeric', 'min:0.01', 'max:9999999999'],
            'lead_time_days' => ['nullable', 'integer', 'min:1', 'max:3650'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);
        $rfq->quotes()->updateOrCreate(['supplier_id' => $supplier->id], $data);
        return back()->with('success', 'Your quote has been sent to the buyer.');
    }
}
