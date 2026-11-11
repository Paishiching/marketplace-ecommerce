<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

class ReviewService
{
    public function all(): Collection
    {
        return Review::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Review::latest()->paginate($perPage);
    }

    public function find(int $id): Review
    {
        return Review::findOrFail($id);
    }

    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(int $id, array $data): Review
    {
        $record = Review::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Review::findOrFail($id);

        return (bool) $record->delete();
    }
}
