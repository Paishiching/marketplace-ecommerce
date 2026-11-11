<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $query = Courier::withCount('shipments')->latest();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $couriers = $query->paginate(20)->withQueryString();

        $stats = [
            'total'    => Courier::count(),
            'active'   => Courier::where('status', true)->count(),
            'inactive' => Courier::where('status', false)->count(),
        ];

        return view('superadmin.couriers.index', compact('couriers', 'stats'));
    }

    public function create()
    {
        $courier = new Courier(['driver' => 'manual']);

        return view('superadmin.couriers.create', compact('courier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $credentials = $this->credentials($request, $validated['driver']);

        if (is_string($credentials)) {
            return back()->withInput()->withErrors(['credentials' => $credentials]);
        }

        Courier::create([
            'name'         => $validated['name'],
            'driver'       => $validated['driver'],
            'tracking_url' => $validated['tracking_url'] ?? null,
            'credentials'  => $credentials,
            'status'       => $request->boolean('status'),
        ]);

        return redirect()->route('superadmin.couriers.index')->with('success', 'Courier created successfully.');
    }

    public function show(Courier $courier)
    {
        $courier->loadCount('shipments');

        return view('superadmin.couriers.show', compact('courier'));
    }

    public function edit(Courier $courier)
    {
        return view('superadmin.couriers.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate($this->rules($courier));

        $credentials = $this->credentials($request, $validated['driver'], $courier);

        if (is_string($credentials)) {
            return back()->withInput()->withErrors(['credentials' => $credentials]);
        }

        $courier->update([
            'name'         => $validated['name'],
            'driver'       => $validated['driver'],
            'tracking_url' => $validated['tracking_url'] ?? null,
            'credentials'  => $credentials,
            'status'       => $request->boolean('status'),
        ]);

        return redirect()->route('superadmin.couriers.index')->with('success', 'Courier updated successfully.');
    }

    public function destroy(Courier $courier)
    {
        if ($courier->shipments()->exists()) {
            return redirect()->route('superadmin.couriers.index')
                ->with('error', 'This courier has shipments attached and cannot be deleted.');
        }

        $courier->delete();

        return redirect()->route('superadmin.couriers.index')->with('success', 'Courier deleted successfully.');
    }

    protected function rules(?Courier $courier = null): array
    {
        return [
            'name'         => ['required', 'string', 'max:100', Rule::unique('couriers', 'name')->ignore($courier?->id)],
            'driver'       => ['required', Rule::in(array_keys(config('couriers.drivers')))],
            'tracking_url' => ['nullable', 'url', 'max:255'],
            'status'       => ['nullable', 'boolean'],
        ];
    }

    /**
     * Credential array return kore. Missing hole error message (string) return kore.
     * Blank field dile purono saved value rekhe dey.
     */
    protected function credentials(Request $request, string $driver, ?Courier $courier = null): array|string|null
    {
        $fields = config("couriers.drivers.{$driver}.fields", []);

        if (! $fields) {
            return null;
        }

        $old = ($courier && $courier->driver === $driver) ? ($courier->credentials ?? []) : [];
        $new = [];

        foreach ($fields as $key => $label) {
            $value = trim((string) $request->input("credentials.{$key}"));

            $new[$key] = $value !== '' ? $value : ($old[$key] ?? null);

            if (blank($new[$key])) {
                return "{$label} is required for this courier.";
            }
        }

        return $new;
    }
}