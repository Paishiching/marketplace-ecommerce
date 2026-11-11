<?php

namespace App\Repositories;

use App\Models\Shipment;

class ShipmentRepository extends BaseRepository
{
    public function __construct(Shipment $shipment)
    {
        parent::__construct($shipment);
    }
}
