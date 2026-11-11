<?php

namespace App\Services\Couriers;

use App\Models\Courier;
use InvalidArgumentException;

class CourierManager
{
    public function driver(Courier $courier): CourierDriver
    {
        return match ($courier->driver) {
            'steadfast' => new SteadfastDriver($courier->credentials ?? []),
            'manual'    => new ManualDriver(),
            default     => throw new InvalidArgumentException("Unknown courier driver: {$courier->driver}"),
        };
    }
}