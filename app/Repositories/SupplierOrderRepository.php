<?php

namespace App\Repositories;

use App\Models\SupplierOrder;

class SupplierOrderRepository extends BaseRepository
{
    public function __construct(SupplierOrder $supplierOrder)
    {
        parent::__construct($supplierOrder);
    }
}
