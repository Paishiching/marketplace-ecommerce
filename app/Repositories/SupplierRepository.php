<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Models\SupplierBalance;
use App\Models\SupplierProduct;
use App\Models\SupplierTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SupplierRepository
{
    public function __construct(protected Supplier $model)
    {
    }

    public function find(int $id): ?Supplier
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Supplier
    {
        return $this->model->findOrFail($id);
    }

    public function findByUserId(int $userId): ?Supplier
    {
        return $this->model->where('user_id', $userId)->first();
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['verified'])) {
            $query->where('is_verified', $filters['verified']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('company_name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): Supplier
    {
        return $this->model->create($data);
    }

    public function update(Supplier $supplier, array $data): Supplier
    {
        $supplier->update($data);
        return $supplier->fresh();
    }

    public function delete(Supplier $supplier): bool
    {
        return $supplier->delete();
    }

    public function getVerified(): Collection
    {
        return $this->model->where('is_verified', true)
            ->where('status', 'active')
            ->get();
    }

    public function markVerified(Supplier $supplier): Supplier
    {
        $supplier->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        return $supplier->fresh();
    }

    public function getProducts(int $supplierId, int $perPage = 15): LengthAwarePaginator
    {
        return SupplierProduct::where('supplier_id', $supplierId)
            ->latest()
            ->paginate($perPage);
    }

    public function getBalance(int $supplierId): ?SupplierBalance
    {
        return SupplierBalance::where('supplier_id', $supplierId)->first();
    }

    public function incrementBalance(int $supplierId, float $amount): void
    {
        DB::transaction(function () use ($supplierId, $amount) {
            $balance = SupplierBalance::firstOrCreate(
                ['supplier_id' => $supplierId],
                ['available_balance' => 0, 'pending_balance' => 0, 'total_earned' => 0]
            );

            $balance->increment('available_balance', $amount);
            $balance->increment('total_earned', $amount);
        });
    }

    public function decrementBalance(int $supplierId, float $amount): bool
    {
        $balance = SupplierBalance::where('supplier_id', $supplierId)->first();

        if (!$balance || $balance->available_balance < $amount) {
            return false;
        }

        $balance->decrement('available_balance', $amount);
        return true;
    }

    public function recordTransaction(int $supplierId, array $data): SupplierTransaction
    {
        return SupplierTransaction::create(array_merge(['supplier_id' => $supplierId], $data));
    }

    public function getLowStockProducts(int $supplierId, int $threshold = 10): Collection
    {
        return SupplierProduct::where('supplier_id', $supplierId)
            ->whereHas('inventory', function ($q) use ($threshold) {
                $q->where('quantity', '<=', $threshold);
            })
            ->get();
    }
}
