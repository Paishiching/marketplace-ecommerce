<?php

namespace App\Services;

use App\Models\Supplier;
use App\Repositories\SupplierRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SupplierService
{
    public function __construct(protected SupplierRepository $supplierRepository)
    {
    }

    public function list(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->supplierRepository->paginate($perPage, $filters);
    }

    public function find(int $id): Supplier
    {
        return $this->supplierRepository->findOrFail($id);
    }

    public function register(array $data): Supplier
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = 'pending';
            $data['is_verified'] = false;

            $supplier = $this->supplierRepository->create($data);
            $this->supplierRepository->incrementBalance($supplier->id, 0);

            return $supplier;
        });
    }

    public function update(int $id, array $data): Supplier
    {
        $supplier = $this->supplierRepository->findOrFail($id);
        return $this->supplierRepository->update($supplier, $data);
    }

    public function verify(int $id): Supplier
    {
        $supplier = $this->supplierRepository->findOrFail($id);
        return $this->supplierRepository->markVerified($supplier);
    }

    public function suspend(int $id, ?string $reason = null): Supplier
    {
        $supplier = $this->supplierRepository->findOrFail($id);
        return $this->supplierRepository->update($supplier, [
            'status' => 'suspended',
            'suspension_reason' => $reason,
        ]);
    }

    public function delete(int $id): bool
    {
        $supplier = $this->supplierRepository->findOrFail($id);
        return $this->supplierRepository->delete($supplier);
    }

    public function getProducts(int $supplierId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->supplierRepository->getProducts($supplierId, $perPage);
    }

    public function getDashboardStats(int $supplierId): array
    {
        $balance = $this->supplierRepository->getBalance($supplierId);
        $lowStock = $this->supplierRepository->getLowStockProducts($supplierId);

        return [
            'total_products' => $this->supplierRepository->getProducts($supplierId, 1)->total(),
            'low_stock_count' => $lowStock->count(),
            'available_balance' => $balance?->available_balance ?? 0,
            'pending_balance' => $balance?->pending_balance ?? 0,
            'total_earned' => $balance?->total_earned ?? 0,
        ];
    }

    public function creditEarning(int $supplierId, float $amount, string $note = 'Order fulfillment earning'): void
    {
        $this->supplierRepository->incrementBalance($supplierId, $amount);
        $this->supplierRepository->recordTransaction($supplierId, [
            'type' => 'credit',
            'amount' => $amount,
            'note' => $note,
        ]);
    }

    public function requestWithdrawal(int $supplierId, float $amount): bool
    {
        $success = $this->supplierRepository->decrementBalance($supplierId, $amount);

        if ($success) {
            $this->supplierRepository->recordTransaction($supplierId, [
                'type' => 'debit',
                'amount' => $amount,
                'note' => 'Withdrawal request',
            ]);
        }

        return $success;
    }

    public function lowStockAlert(int $supplierId, int $threshold = 10)
    {
        return $this->supplierRepository->getLowStockProducts($supplierId, $threshold);
    }
}
