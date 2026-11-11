<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;

class MediaService
{
    public function all(): Collection
    {
        return Media::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Media::latest()->paginate($perPage);
    }

    public function find(int $id): Media
    {
        return Media::findOrFail($id);
    }

    public function create(array $data): Media
    {
        return Media::create($data);
    }

    public function update(int $id, array $data): Media
    {
        $record = Media::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Media::findOrFail($id);

        return (bool) $record->delete();
    }
}
