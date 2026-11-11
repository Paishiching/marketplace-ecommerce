<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use App\Models\Payment;

class PaymentService
{
    protected PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function all()
    {
        return $this->paymentRepository->all();
    }

    public function paginate(int $perPage = 20)
    {
        return $this->paymentRepository->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->paymentRepository->findOrFail($id);
    }

    public function create(array $data): Payment
    {
        return $this->paymentRepository->create($data);
    }

    public function update(int $id, array $data): Payment
    {
        return $this->paymentRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->paymentRepository->delete($id);
    }
}
