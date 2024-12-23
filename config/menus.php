<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DEFINE MENU
    |--------------------------------------------------------------------------
    */

    'items' => [
        [
            'title' => 'Dashboard',
            'route' => 'dashboard'
        ],
        [
            'title' => 'Masterfile',
            'submenus' => [
                [
                    'title' => 'Users',
                    'route' => 'users.index'
                ],
                [
                    'title' => 'Speed',
                    'route' => 'speed.index'
                ],
                [
                    'title' => 'Product Types',
                    'route' => 'product_types.index'
                ],
                [
                    'title' => 'Product',
                    'route' => 'products.index'
                ],
                [
                    'title' => 'Product Group',
                    'route' => 'product_groups.index'
                ],
            ]

        ],
        [
            'title' => 'Line Item Manager',
            'route' => 'lineitem_managers.index'
        ],
    ]
];
