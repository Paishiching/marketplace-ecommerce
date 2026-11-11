<?php

namespace App\Services;

use App\Models\Vendor;
use App\Repositories\VendorRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VendorService
{
    public function __construct(protected VendorRepository $vendorRepository)
    {
    }

    public function list(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->vendorRepository->paginate($perPage, $filters);
    }

    public function find(int $id): Vendor
    {
        return $this->vendorRepository->findOrFail($id);
    }

    public function register(array $data): Vendor
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = 'pending';

            $vendor = $this->vendorRepository->create($data);

            // Init balance row so downstream services never hit null
            $this->vendorRepository->incrementBalance($vendor->id, 0);

            return $vendor;
        });
    }

    public function update(int $id, array $data): Vendor
    {
        $vendor = $this->vendorRepository->findOrFail($id);
        return $this->vendorRepository->update($vendor, $data);
    }

    public function approve(int $id): Vendor
    {
        $vendor = $this->vendorRepository->findOrFail($id);
        return $this->vendorRepository->update($vendor, [
            'status' => 'active',
            'approved_at' => now(),
        ]);
    }

    public function suspend(int $id, ?string $reason = null): Vendor
    {
        $vendor = $this->vendorRepository->findOrFail($id);
        return $this->vendorRepository->update($vendor, [
            'status' => 'suspended',
            'suspension_reason' => $reason,
        ]);
    }

    public function delete(int $id): bool
    {
        $vendor = $this->vendorRepository->findOrFail($id);
        return $this->vendorRepository->delete($vendor);
    }

    public function getDashboardStats(int $vendorId): array
    {
        $vendor = $this->vendorRepository->findOrFail($vendorId);
        $balance = $this->vendorRepository->getBalance($vendorId);

        return [
            'total_products' => $vendor->products()->count(),
            'total_orders' => $vendor->orders()->count(),
            'pending_orders' => $vendor->orders()->where('status', 'pending')->count(),
            'available_balance' => $balance?->available_balance ?? 0,
            'pending_balance' => $balance?->pending_balance ?? 0,
            'total_earned' => $balance?->total_earned ?? 0,
        ];
    }

    public function creditEarning(int $vendorId, float $amount, string $note = 'Order earning'): void
    {
        $this->vendorRepository->incrementBalance($vendorId, $amount);
        $this->vendorRepository->recordTransaction($vendorId, [
            'type' => 'credit',
            'amount' => $amount,
            'note' => $note,
        ]);
    }

    public function requestWithdrawal(int $vendorId, float $amount): bool
    {
        $success = $this->vendorRepository->decrementBalance($vendorId, $amount);

        if ($success) {
            $this->vendorRepository->recordTransaction($vendorId, [
                'type' => 'debit',
                'amount' => $amount,
                'note' => 'Withdrawal request',
            ]);
        }

        return $success;
    }

    public function topVendors(int $limit = 10)
    {
        return $this->vendorRepository->getTopVendorsBySales($limit);
    }
}
