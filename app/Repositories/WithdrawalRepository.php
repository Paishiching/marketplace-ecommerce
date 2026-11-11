<?php

namespace App\Repositories;

use App\Models\Withdrawal;

class WithdrawalRepository extends BaseRepository
{
    public function __construct(Withdrawal $withdrawal)
    {
        parent::__construct($withdrawal);
    }
}
