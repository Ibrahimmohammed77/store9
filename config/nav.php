<?php



return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard.home',
        'title' => 'Dashboard',
        'active' => 'dashboard.home',

    ],
    [
        'icon' => 'nav-icon fas fa-tags nav-icon',
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'active' => 'dashboard.categories.*',
        'badge' => '5',
        'ability' => 'categories.view'
    ],  [
        'icon' => 'nav-icon fas fa-box nav-icon',
        'route' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*',
        'ability' => 'products.view'
    ], [
        'icon' => 'nav-icon fas fa-receipt nav-icon',
        'route' => 'dashboard.products.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*',
        'ability' => 'orders.view'
    ],
     [
        'icon' => 'nav-icon fas fa-shield nav-icon',
        'route' => 'dashboard.roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view'
     ], 
    [
        'icon' => 'nav-icon fas fa-users nav-icon',
        'route' => 'dashboard.admin.index',
        'title' => 'Admins',
        'active' => 'dashboard.admin.*',
        'ability' => 'admins.view'
    ], 
    [
        'icon' => 'nav-icon fas fa-users nav-icon',
        'route' => 'dashboard.users.index',
        'title' => 'Users',
        'active' => 'dashboard.users.*',
        'ability' => 'users.view'
    ]
];
