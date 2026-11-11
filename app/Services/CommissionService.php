<?php

namespace App\Services;

use App\Repositories\CommissionRepository;
use App\Models\Commission;

class CommissionService
{
    protected CommissionRepository $commissionRepository;

    public function __construct(CommissionRepository $commissionRepository)
    {
        $this->commissionRepository = $commissionRepository;
    }

    public function all()
    {
        return $this->commissionRepository->all();
    }

    public function paginate(int $perPage = 20)
    {
        return $this->commissionRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->commissionRepository->findOrFail($id);
    }

    public function create(array $data): Commission
    {
        return $this->commissionRepository->create($data);
    }

    public function update(int $id, array $data): Commission
    {
        return $this->commissionRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->commissionRepository->delete($id);
    }
}
