<?php

namespace App\Services;

use App\Models\ProductImport;
use Illuminate\Database\Eloquent\Collection;

class ProductImportService
{
    public function all(): Collection
    {
        return ProductImport::all();
    }

    public function paginate(int $perPage = 20)
    {
        return ProductImport::latest()->paginate($perPage);
    }

    public function find(int $id): ProductImport
    {
        return ProductImport::findOrFail($id);
    }

    public function create(array $data): ProductImport
    {
        return ProductImport::create($data);
    }

    public function update(int $id, array $data): ProductImport
    {
        $record = ProductImport::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = ProductImport::findOrFail($id);

        return (bool) $record->delete();
    }
}
