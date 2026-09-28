<?php
$LIST = [
    'h1'           => 'Massagers',
    'intro'        => 'Massagers and massage equipment from the Avon domestic range, for recovery and wellness areas.',
    'eyebrow'      => 'Cardio Equipment',
    'canonical'    => 'cardio/massagers/',
    'title'        => 'Massagers — 6 Models | Avon Fitness Maharashtra',
    'description'  => 'Massagers and massage equipment from the Avon domestic range, for recovery and wellness areas. Supplied and installed across Mumbai, Pune, Nagpur and Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['sub' => 'massagers'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Cardio Equipment', 'url' => '/cardio/'], ['name' => 'Massagers']],
    'related'      => [['/cardio/treadmills/', 'Treadmills'], ['/cardio/cross-trainers/', 'Cross Trainers'], ['/cardio/upright-bikes/', 'Upright Bikes'], ['/cardio/recumbent-bikes/', 'Recumbent Bikes'], ['/cardio/spin-bikes/', 'Spin Bikes'], ['/cardio/air-bikes/', 'Air Bikes'], ['/cardio/', 'All cardio equipment']],
];
require dirname(__DIR__, 2) . '/includes/tpl-listing.php';
