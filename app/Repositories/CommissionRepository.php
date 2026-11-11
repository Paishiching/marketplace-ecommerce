<?php

namespace App\Repositories;

use App\Models\Commission;

class CommissionRepository extends BaseRepository
{
    public function __construct(Commission $commission)
    {
        parent::__construct($commission);
    }
}
