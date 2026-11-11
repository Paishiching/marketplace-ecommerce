<?php

return [
    'guard' => 'web',

    // Ei role shob route e bypass pay
    'super_admin_role' => 'superadmin',

    // Je panel gulo permission diye control hobe (route name er prothom segment)
    'panels' => ['superadmin', 'admin'],

    // Login kora panel user shobai dekhte pabe (permission lagbe na)
    'always_allowed' => [
        'superadmin.dashboards',
        'superadmin.profile.*',
        'admin.dashboards',
    ],

    // Permission list theke bad dite chaile route name pattern
    'ignore' => [],

    // store -> create, update -> edit (jodi oi sibling route thake)
    'aliases' => [
        'store'  => 'create',
        'update' => 'edit',
    ],
];
