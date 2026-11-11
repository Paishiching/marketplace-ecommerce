<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    public function all(): Collection
    {
        return Notification::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Notification::latest()->paginate($perPage);
    }

    public function find(int $id): Notification
    {
        return Notification::findOrFail($id);
    }

    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    public function update(int $id, array $data): Notification
    {
        $record = Notification::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Notification::findOrFail($id);

        return (bool) $record->delete();
    }
}
