<?php

return [

    // key = DB enum e thaka status value
    'statuses' => [
        'pending'    => ['label' => 'Pending',    'color' => 'warning'],
        'processing' => ['label' => 'Processing', 'color' => 'info'],
        'shipped'    => ['label' => 'Shipped',    'color' => 'primary'],
        'delivered'  => ['label' => 'Delivered',  'color' => 'success'],
        'completed'  => ['label' => 'Completed',  'color' => 'success'],
        'cancelled'  => ['label' => 'Cancelled',  'color' => 'danger'],
        'returned'   => ['label' => 'Returned',   'color' => 'secondary'],
    ],

    // "shipped" shudhu Send to Courier diye hoy.
    'transitions' => [
        'pending'    => ['processing', 'cancelled', 'delivered'],
        'processing' => ['cancelled'],
        'shipped'    => ['delivered', 'returned'],
        'delivered'  => ['completed', 'returned'],
        'completed'  => [],
        'cancelled'  => [],
        'returned'   => [],
    ],

    // Ei status er order delete kora jabe
    'deletable' => ['cancelled'],

    // Manual order create e je status diye shuru kora jabe
    'initial_statuses' => ['pending', 'processing'],

    // Order kothay theke eseche
    'sources' => [
        'website'  => ['label' => 'Website',  'color' => 'success'],
        'facebook' => ['label' => 'Facebook', 'color' => 'primary'],
        'whatsapp' => ['label' => 'WhatsApp', 'color' => 'success'],
        'phone'    => ['label' => 'Phone',    'color' => 'info'],
        'walk_in'  => ['label' => 'Walk-in',  'color' => 'secondary'],
    ],

    // Enum e confirm: unpaid, paid, partially_refunded, refunded
    'payment_statuses' => [
        'unpaid'             => ['label' => 'Unpaid',             'color' => 'warning'],
        'paid'               => ['label' => 'Paid',               'color' => 'success'],
        'partially_refunded' => ['label' => 'Partially Refunded', 'color' => 'info'],
        'refunded'           => ['label' => 'Refunded',           'color' => 'secondary'],
    ],
];