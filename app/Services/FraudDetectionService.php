<?php

namespace App\Services;

use App\Models\FraudReport;
use Illuminate\Database\Eloquent\Collection;

class FraudDetectionService
{
    public function all(): Collection
    {
        return FraudReport::all();
    }

    public function paginate(int $perPage = 20)
    {
        return FraudReport::latest()->paginate($perPage);
    }

    public function find(int $id): FraudReport
    {
        return FraudReport::findOrFail($id);
    }

    public function create(array $data): FraudReport
    {
        return FraudReport::create($data);
    }

    public function update(int $id, array $data): FraudReport
    {
        $record = FraudReport::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = FraudReport::findOrFail($id);

        return (bool) $record->delete();
    }
}
