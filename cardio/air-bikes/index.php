<?php
$LIST = [
    'h1'           => 'Air Bikes',
    'intro'        => 'Fan-resistance air bikes — resistance that scales with effort, built for interval and conditioning work.',
    'eyebrow'      => 'Cardio Equipment',
    'canonical'    => 'cardio/air-bikes/',
    'title'        => 'Air Bikes — 9 Models | Avon Fitness Maharashtra',
    'description'  => 'Fan-resistance air bikes — resistance that scales with effort, built for interval and conditioning work. Supplied and installed across Mumbai, Pune, Nagpur and Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['sub' => 'air-bikes'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Cardio Equipment', 'url' => '/cardio/'], ['name' => 'Air Bikes']],
    'body'         => '<h2>How air resistance works</h2><p>A fan bike gets harder the harder you push, so it self-scales to the rider rather than needing a resistance setting. That makes it excellent for interval and conditioning training. They are loud in use, so place them away from quiet zones.</p>',
    'related'      => [['/cardio/treadmills/', 'Treadmills'], ['/cardio/cross-trainers/', 'Cross Trainers'], ['/cardio/upright-bikes/', 'Upright Bikes'], ['/cardio/recumbent-bikes/', 'Recumbent Bikes'], ['/cardio/spin-bikes/', 'Spin Bikes'], ['/cardio/massagers/', 'Massagers'], ['/cardio/', 'All cardio equipment']],
];
require dirname(__DIR__, 2) . '/includes/tpl-listing.php';
