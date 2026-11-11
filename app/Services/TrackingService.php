<?php

namespace App\Services;

use App\Models\TrackingEvent;
use Illuminate\Database\Eloquent\Collection;

class TrackingService
{
    public function all(): Collection
    {
        return TrackingEvent::all();
    }

    public function paginate(int $perPage = 20)
    {
        return TrackingEvent::latest()->paginate($perPage);
    }

    public function find(int $id): TrackingEvent
    {
        return TrackingEvent::findOrFail($id);
    }

    public function create(array $data): TrackingEvent
    {
        return TrackingEvent::create($data);
    }

    public function update(int $id, array $data): TrackingEvent
    {
        $record = TrackingEvent::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = TrackingEvent::findOrFail($id);

        return (bool) $record->delete();
    }
}
