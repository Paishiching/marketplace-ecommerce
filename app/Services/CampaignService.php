<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;

class CampaignService
{
    public function all(): Collection
    {
        return Campaign::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Campaign::latest()->paginate($perPage);
    }

    public function find(int $id): Campaign
    {
        return Campaign::findOrFail($id);
    }

    public function create(array $data): Campaign
    {
        return Campaign::create($data);
    }

    public function update(int $id, array $data): Campaign
    {
        $record = Campaign::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Campaign::findOrFail($id);

        return (bool) $record->delete();
    }
}
