<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

abstract class PartnerController extends Controller
{
    abstract protected function cfg(): array;

    public function index(Request $request)
    {
        $cfg   = $this->cfg();
        $model = $cfg['model'];

        $items = $model::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $users = User::whereIn('id', $items->pluck('user_id'))->get()->keyBy('id');

        return view('superadmin.partners.index', compact('items', 'users', 'cfg'));
    }

    // Add/edit form ekhon nei, tai list e pathai
    public function create() { return redirect()->route($this->cfg()['prefix'] . '.index'); }
    public function store(Request $request) { return $this->create(); }
    public function show($id) { return $this->create(); }
    public function edit($id) { return $this->create(); }
    public function update(Request $request, $id) { return $this->create(); }

    public function approve(Request $request, $id)
    {
        $cfg  = $this->cfg();
        $item = $cfg['model']::findOrFail($id);

        $update = ['status' => 'approved'];

        if ($cfg['rate']) {
            $data = $request->validate(['rate' => ['required', 'numeric', 'min:0', 'max:100']]);
            $update[$cfg['rate']] = $data['rate'];
        }
        if ($cfg['verify']) {
            $update['is_verified'] = true;
        }

        $item->forceFill($update)->save();
        User::find($item->user_id)?->assignRole($cfg['role']);

        return back()->with('success', 'Approved hoyeche.');
    }

    public function suspend($id)
    {
        $cfg  = $this->cfg();
        $item = $cfg['model']::findOrFail($id);

        $item->forceFill(['status' => 'suspended'])->save();
        User::find($item->user_id)?->removeRole($cfg['role']);

        return back()->with('success', 'Suspend kora hoyeche.');
    }

    public function reject($id)
    {
        $cfg  = $this->cfg();
        $item = $cfg['model']::findOrFail($id);

        $item->forceFill(['status' => 'rejected'])->save();
        User::find($item->user_id)?->removeRole($cfg['role']);

        return back()->with('success', 'Application rejected.');
    }

    public function destroy($id)
    {
        $cfg  = $this->cfg();
        $item = $cfg['model']::findOrFail($id);

        User::find($item->user_id)?->removeRole($cfg['role']);
        $item->delete();

        return back()->with('success', 'Delete kora hoyeche.');
    }
}
