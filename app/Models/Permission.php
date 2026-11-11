<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function getActionLabelAttribute(): string
    {
        $last = Str::afterLast($this->name, '.');

        return match ($last) {
            'index'   => 'View list',
            'create'  => 'Create',
            'edit'    => 'Edit',
            'show'    => 'View details',
            'destroy' => 'Delete',
            default   => Str::headline($last),
        };
    }
}