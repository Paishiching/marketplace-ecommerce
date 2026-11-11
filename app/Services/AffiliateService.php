<?php

namespace App\Services;

use App\Repositories\AffiliateRepository;
use App\Models\Affiliate;

class AffiliateService
{
    protected AffiliateRepository $affiliateRepository;

    public function __construct(AffiliateRepository $affiliateRepository)
    {
        $this->affiliateRepository = $affiliateRepository;
    }

    public function all()
    {
        return $this->affiliateRepository->all();
    }

    public function paginate(int $perPage = 20)
    {
        return $this->affiliateRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->affiliateRepository->findOrFail($id);
    }

    public function create(array $data): Affiliate
    {
        return $this->affiliateRepository->create($data);
    }

    public function update(int $id, array $data): Affiliate
    {
        return $this->affiliateRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->affiliateRepository->delete($id);
    }
}
