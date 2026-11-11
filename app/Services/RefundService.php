<?php

namespace App\Services;

use App\Models\Refund;
use Illuminate\Database\Eloquent\Collection;

class RefundService
{
    public function all(): Collection
    {
        return Refund::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Refund::latest()->paginate($perPage);
    }

    public function find(int $id): Refund
    {
        return Refund::findOrFail($id);
    }

    public function create(array $data): Refund
    {
        return Refund::create($data);
    }

    public function update(int $id, array $data): Refund
    {
        $record = Refund::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Refund::findOrFail($id);

        return (bool) $record->delete();
    }
}
