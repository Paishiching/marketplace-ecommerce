<?php

namespace App\Services;

use App\Repositories\SupplierOrderRepository;
use App\Models\SupplierOrder;

class SupplierOrderService
{
    protected SupplierOrderRepository $supplierOrderRepository;

    public function __construct(SupplierOrderRepository $supplierOrderRepository)
    {
        $this->supplierOrderRepository = $supplierOrderRepository;
    }

    public function all()
    {
        return $this->supplierOrderRepository->all();
    }

    public function paginate(int $perPage = 20)
    {
        return $this->supplierOrderRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->supplierOrderRepository->findOrFail($id);
    }

    public function create(array $data): SupplierOrder
    {
        return $this->supplierOrderRepository->create($data);
    }

    public function update(int $id, array $data): SupplierOrder
    {
        return $this->supplierOrderRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->supplierOrderRepository->delete($id);
    }
}
