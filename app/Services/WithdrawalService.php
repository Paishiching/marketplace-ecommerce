<?php

namespace App\Services;

use App\Repositories\WithdrawalRepository;
use App\Models\Withdrawal;

class WithdrawalService
{
    protected WithdrawalRepository $withdrawalRepository;

    public function __construct(WithdrawalRepository $withdrawalRepository)
    {
        $this->withdrawalRepository = $withdrawalRepository;
    }

    public function all()
    {
        return $this->withdrawalRepository->all();
    }

    public function paginate(int $perPage = 20)
    {
        return $this->withdrawalRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->withdrawalRepository->findOrFail($id);
    }

    public function create(array $data): Withdrawal
    {
        return $this->withdrawalRepository->create($data);
    }

    public function update(int $id, array $data): Withdrawal
    {
        return $this->withdrawalRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->withdrawalRepository->delete($id);
    }
}
