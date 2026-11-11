<?php

return [

    // key = driver name. fields = UI te ja ja credential lagbe
    'drivers' => [
        'manual' => [
            'label'  => 'Manual (Sundarban, SA Paribahan, others)',
            'fields' => [],
        ],
        'steadfast' => [
            'label'  => 'Steadfast (API)',
            'fields' => [
                'api_key'    => 'API Key',
                'secret_key' => 'Secret Key',
            ],
        ],
    ],

    'steadfast_base_url' => env('STEADFAST_BASE_URL', 'https://portal.packzy.com/api/v1'),
];