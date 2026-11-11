<?php

namespace App\Services;

use App\Models\Dispute;
use Illuminate\Database\Eloquent\Collection;

class DisputeService
{
    public function all(): Collection
    {
        return Dispute::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Dispute::latest()->paginate($perPage);
    }

    public function find(int $id): Dispute
    {
        return Dispute::findOrFail($id);
    }

    public function create(array $data): Dispute
    {
        return Dispute::create($data);
    }

    public function update(int $id, array $data): Dispute
    {
        $record = Dispute::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Dispute::findOrFail($id);

        return (bool) $record->delete();
    }
}
