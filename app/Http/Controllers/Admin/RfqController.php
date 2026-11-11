<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rfq;

class RfqController extends Controller
{
    public function index()
    {
        $rfqs = Rfq::with('user')->withCount('quotes')->latest()->paginate(20);
        return view('admin.rfqs.index', compact('rfqs'));
    }

    public function show(Rfq $rfq)
    {
        $rfq->load(['user', 'quotes.supplier']);
        return view('admin.rfqs.show', compact('rfq'));
    }
}
