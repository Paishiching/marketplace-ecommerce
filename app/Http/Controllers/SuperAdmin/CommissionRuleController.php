<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CommissionRule;
use App\Models\Vendor;
use Illuminate\Http\Request;

class CommissionRuleController extends Controller
{
    public function index()
    {
        $rules = CommissionRule::with(['category', 'vendor'])->latest()->paginate(20);

        return view('superadmin.commissions.rules.index', [
            'rules'      => $rules,
            'categories' => Category::orderBy('name')->get(['id', 'name']),
            'vendors'    => Vendor::orderBy('shop_name')->get(['id', 'shop_name', 'name']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'        => 'nullable|exists:categories,id',
            'vendor_id'          => 'nullable|exists:vendors,id',
            'commission_percent' => 'required|numeric|min:0|max:100',
        ]);

        // Same category + vendor combo thakle update hobe, duplicate hobe na
        CommissionRule::updateOrCreate(
            [
                'category_id' => $data['category_id'] ?? null,
                'vendor_id'   => $data['vendor_id'] ?? null,
            ],
            ['commission_percent' => $data['commission_percent']]
        );

        return back()->with('success', 'Commission rule saved.');
    }

    public function update(Request $request, CommissionRule $commissionRule)
    {
        $data = $request->validate([
            'commission_percent' => 'required|numeric|min:0|max:100',
        ]);

        $commissionRule->update($data);

        return back()->with('success', 'Commission rule updated.');
    }

    public function destroy(CommissionRule $commissionRule)
    {
        $commissionRule->delete();

        return back()->with('success', 'Commission rule deleted.');
    }
}
