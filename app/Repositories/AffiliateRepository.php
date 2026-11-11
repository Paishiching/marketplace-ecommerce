<?php

namespace App\Repositories;

use App\Models\Affiliate;

class AffiliateRepository extends BaseRepository
{
    public function __construct(Affiliate $affiliate)
    {
        parent::__construct($affiliate);
    }
}
