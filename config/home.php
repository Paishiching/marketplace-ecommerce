<?php

/*
|--------------------------------------------------------------------------
| Home page settings
|--------------------------------------------------------------------------
| features : hero er niche 5ta info card (icon: truck | badge | emi | van | card)
|            route => card click korle kon policy page e jabe
|                     (policy.shipping | policy.returns | policy.support | policy.payment | policy.faq)
|            'route' na dile icon onujayi default page e jabe.
| sections : home page er category wise product row.
|            title    => section er heading (na dile category er naam)
|            category => category / sub category er SLUG. Ekta string ba array dite paren.
|                       Array hole prothom ta (apnar slug) age khujbe, na pele porer naam gulo (naam diye) try korbe.
|            limit    => koyta product anbe (default 10)
|            order    => 'latest' (default) | 'discount' (beshi discount age) | 'best_selling' (beshi sold age)
|            Slug na mille ba product na thakle oi section dekhabe na.
|            Keno skip holo seta storage/logs/laravel.log e likha thakbe.
|            'sections' khali [] rakhle auto: product beshi thaka top category gulo dekhabe.
*/

return [

    'features' => [
        ['icon' => 'truck', 'title' => '4 Hours Delivery',  'text' => 'Inside Dhaka City Only',        'route' => 'policy.shipping'],
        ['icon' => 'badge', 'title' => 'Official Warranty', 'text' => '100% Original Product',         'route' => 'policy.faq'],
        ['icon' => 'emi',   'title' => 'EMI Facility',      'text' => 'Upto 36 Months EMI Facility',   'route' => 'policy.payment'],
        ['icon' => 'van',   'title' => 'Faster Delivery',   'text' => 'Rapid delivery At Your Doorstep', 'route' => 'policy.shipping'],
        ['icon' => 'card',  'title' => 'Flexible Payment',  'text' => 'Easy & Secured Payment',        'route' => 'policy.payment'],
    ],

    'sections' => [
        ['title' => 'Beat the Heat!',          'category' => ['air-conditioner',  'Air Conditioner', 'Air Conditioners', 'AC'],         'limit' => 10, 'order' => 'discount'],
        ['title' => 'Best Selling Television', 'category' => ['television',       'Television', 'Televisions', 'TV'],                   'limit' => 10, 'order' => 'best_selling'],
        ['title' => 'Refrigerator',            'category' => ['refrigerator',     'Refrigerator', 'Refrigerators', 'Fridge'],           'limit' => 10, 'order' => 'latest'],
        ['title' => 'Washing Machine',         'category' => ['washing-machine',  'Washing Machine', 'Washing Machines'],               'limit' => 10, 'order' => 'latest'],
        ['title' => 'Microwave Oven',          'category' => ['microwave-oven',   'Microwave Oven', 'Microwave Ovens', 'Microwave'],    'limit' => 10, 'order' => 'latest'],
        ['title' => 'Small Appliances',        'category' => ['small-appliances', 'Small Appliances', 'Small Appliance'],               'limit' => 10, 'order' => 'latest'],
    ],

];