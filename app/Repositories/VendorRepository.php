<?php

namespace App\Repositories;

use App\Models\Vendor;
use App\Models\VendorBalance;
use App\Models\VendorTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VendorRepository
{
    public function __construct(protected Vendor $model)
    {
    }

    public function find(int $id): ?Vendor
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Vendor
    {
        return $this->model->findOrFail($id);
    }

    public function findByUserId(int $userId): ?Vendor
    {
        return $this->model->where('user_id', $userId)->first();
    }

    public function paginate(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('shop_name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%");
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): Vendor
    {
        return $this->model->create($data);
    }

    public function update(Vendor $vendor, array $data): Vendor
    {
        $vendor->update($data);
        return $vendor->fresh();
    }

    public function delete(Vendor $vendor): bool
    {
        return $vendor->delete();
    }

    public function getActive(): Collection
    {
        return $this->model->where('status', 'active')->get();
    }

    public function getBalance(int $vendorId): ?VendorBalance
    {
        return VendorBalance::where('vendor_id', $vendorId)->first();
    }

    public function incrementBalance(int $vendorId, float $amount): void
    {
        DB::transaction(function () use ($vendorId, $amount) {
            $balance = VendorBalance::firstOrCreate(
                ['vendor_id' => $vendorId],
                ['available_balance' => 0, 'pending_balance' => 0, 'total_earned' => 0]
            );

            $balance->increment('available_balance', $amount);
            $balance->increment('total_earned', $amount);
        });
    }

    public function decrementBalance(int $vendorId, float $amount): bool
    {
        $balance = VendorBalance::where('vendor_id', $vendorId)->first();

        if (!$balance || $balance->available_balance < $amount) {
            return false;
        }

        $balance->decrement('available_balance', $amount);
        return true;
    }

    public function recordTransaction(int $vendorId, array $data): VendorTransaction
    {
        return VendorTransaction::create(array_merge(['vendor_id' => $vendorId], $data));
    }

    public function getTransactions(int $vendorId, int $perPage = 15): LengthAwarePaginator
    {
        return VendorTransaction::where('vendor_id', $vendorId)
            ->latest()
            ->paginate($perPage);
    }

    public function getTopVendorsBySales(int $limit = 10): Collection
    {
        return $this->model
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->orderByDesc('orders_sum_total_amount')
            ->limit($limit)
            ->get();
    }
}
