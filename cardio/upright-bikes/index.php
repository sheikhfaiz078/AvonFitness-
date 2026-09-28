<?php
$LIST = [
    'h1'           => 'Upright Bikes',
    'intro'        => 'Upright exercise bikes — the most compact cardio footprint in the range, for home rooms and gym floors alike.',
    'eyebrow'      => 'Cardio Equipment',
    'canonical'    => 'cardio/upright-bikes/',
    'title'        => 'Upright Bikes — 20 Models | Avon Fitness Maharashtra',
    'description'  => 'Upright exercise bikes — the most compact cardio footprint in the range, for home rooms and gym floors alike. Supplied and installed across Mumbai, Pune, Nagpur and Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['sub' => 'upright-bikes'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Cardio Equipment', 'url' => '/cardio/'], ['name' => 'Upright Bikes']],
    'body'         => '<h2>Where upright bikes fit</h2><p>Upright bikes have the smallest footprint of any cardio machine, which makes them the practical answer for tight rooms, hotel fitness rooms and corporate gyms. Magnetic resistance systems run quietly, which matters when the room shares a wall with something else.</p>',
    'faqs'         => [['q' => 'What is the difference between an upright and a recumbent bike?', 'a' => 'An upright bike puts you in a conventional cycling position and takes less floor space. A recumbent bike has a seat with back support and a step-through frame, which is easier to get on and off and more comfortable for longer sessions or rehabilitation use.']],
    'related'      => [['/cardio/treadmills/', 'Treadmills'], ['/cardio/cross-trainers/', 'Cross Trainers'], ['/cardio/recumbent-bikes/', 'Recumbent Bikes'], ['/cardio/spin-bikes/', 'Spin Bikes'], ['/cardio/air-bikes/', 'Air Bikes'], ['/cardio/massagers/', 'Massagers'], ['/cardio/', 'All cardio equipment']],
];
require dirname(__DIR__, 2) . '/includes/tpl-listing.php';
