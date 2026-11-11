<?php

namespace App\Repositories;

use App\Models\Reseller;

class ResellerRepository extends BaseRepository
{
    public function __construct(Reseller $reseller)
    {
        parent::__construct($reseller);
    }
}
