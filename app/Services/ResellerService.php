<?php

namespace App\Services;

use App\Repositories\ResellerRepository;
use App\Models\Reseller;

class ResellerService
{
    protected ResellerRepository $resellerRepository;

    public function __construct(ResellerRepository $resellerRepository)
    {
        $this->resellerRepository = $resellerRepository;
    }

    public function all()
    {
        return $this->resellerRepository->all();
    }

    public function paginate(int $perPage = 20)
    {
        return $this->resellerRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->resellerRepository->findOrFail($id);
    }

    public function create(array $data): Reseller
    {
        return $this->resellerRepository->create($data);
    }

    public function update(int $id, array $data): Reseller
    {
        return $this->resellerRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->resellerRepository->delete($id);
    }
}
