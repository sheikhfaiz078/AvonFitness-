<?php
$LIST = [
    'h1'           => 'Gym Accessories',
    'intro'        => 'Bars, collars, ropes, mats, belts, supports and training accessories for commercial and home floors.',
    'eyebrow'      => 'Category',
    'canonical'    => 'accessories/',
    'title'        => 'Gym Accessories — 84 Products | Avon Fitness Maharashtra',
    'description'  => 'Bars, collars, ropes, mats, belts, supports and training accessories for commercial and home floors. Supplied, installed and serviced across Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['family' => 'accessories'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Gym Accessories']],
    'tiles'        => [['/accessories/', '01', 'Gym Accessories', 65, 'accessories'], ['/accessories/', '02', 'Other Fitness Equipment', 19, 'other-equipment']],
    'body'         => '<h2>Order accessories with the machines</h2><p>Accessories are individually small and collectively significant. They are also what a new gym floor discovers it is missing in the first week of opening. Put them in the same order as the equipment and you will not be sourcing collars and mats in a hurry.</p><h2>Bulk supply</h2><p>For gym fit-outs, institutional orders and society projects we supply accessories in quantity alongside the main equipment schedule.</p>',
    'related'      => [['/products/', 'Full catalogue'], ['/commercial-gym/', 'Commercial range'], ['/home-gym/', 'Home range'], ['/commercial-gym-solutions/', 'Gym planning']],
];
require dirname(__DIR__, 1) . '/includes/tpl-listing.php';
