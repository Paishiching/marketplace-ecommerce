<?php

namespace App\Services;

use App\Models\ReturnRequest;
use Illuminate\Database\Eloquent\Collection;

class ReturnService
{
    public function all(): Collection
    {
        return ReturnRequest::all();
    }

    public function paginate(int $perPage = 20)
    {
        return ReturnRequest::latest()->paginate($perPage);
    }

    public function find(int $id): ReturnRequest
    {
        return ReturnRequest::findOrFail($id);
    }

    public function create(array $data): ReturnRequest
    {
        return ReturnRequest::create($data);
    }

    public function update(int $id, array $data): ReturnRequest
    {
        $record = ReturnRequest::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = ReturnRequest::findOrFail($id);

        return (bool) $record->delete();
    }
}
