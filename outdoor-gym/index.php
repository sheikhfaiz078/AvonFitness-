<?php
$LIST = [
    'h1'           => 'Outdoor Gym Equipment',
    'intro'        => 'Open-air fitness units for parks, housing societies, campuses and community fitness zones, supplied with the foundation components needed to fix them down properly.',
    'eyebrow'      => 'Category',
    'canonical'    => 'outdoor-gym/',
    'title'        => 'Outdoor Gym Equipment — 22 Products | Avon Fitness Maharashtra',
    'description'  => 'Open-air fitness units for parks, housing societies, campuses and community fitness zones, supplied with the foundation components needed to fix them down properly. Supplied, installed and serviced across Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['family' => 'outdoor'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Outdoor Gym Equipment']],
    'tiles'        => [['/outdoor-gym/', '01', 'Outdoor Gym Equipment', 22, 'outdoor-gym']],
    'related'      => [['/products/', 'Full catalogue'], ['/commercial-gym/', 'Commercial range'], ['/home-gym/', 'Home range'], ['/commercial-gym-solutions/', 'Gym planning']],
];
require dirname(__DIR__, 1) . '/includes/tpl-listing.php';
