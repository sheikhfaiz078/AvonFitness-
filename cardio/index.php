<?php
$LIST = [
    'h1'           => 'Cardio Equipment',
    'intro'        => 'Treadmills, cross trainers, spin bikes, upright and recumbent bikes, orbitracs and air bikes — commercial and domestic cardio from the Avon Fitness range.',
    'eyebrow'      => 'Category',
    'canonical'    => 'cardio/',
    'title'        => 'Cardio Equipment — 157 Products | Avon Fitness Maharashtra',
    'description'  => 'Treadmills, cross trainers, spin bikes, upright and recumbent bikes, orbitracs and air bikes — commercial and domestic cardio from the Avon Fitness range. Supplied, installed and serviced across Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['family' => 'cardio'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Cardio Equipment']],
    'tiles'        => [['/cardio/treadmills/', '01', 'Treadmills', 64, 'treadmills'], ['/cardio/cross-trainers/', '02', 'Cross Trainers', 20, 'cross-trainers'], ['/cardio/upright-bikes/', '03', 'Upright Bikes', 20, 'upright-bikes'], ['/cardio/recumbent-bikes/', '04', 'Recumbent Bikes', 17, 'recumbent-bikes'], ['/cardio/spin-bikes/', '05', 'Spin Bikes', 14, 'spin-bikes'], ['/cardio/air-bikes/', '06', 'Air Bikes', 9, 'air-bikes'], ['/cardio/massagers/', '07', 'Massagers', 6, 'massagers'], ['/cardio/orbitracs/', '08', 'Orbitracs', 6, 'orbitracs'], ['/cardio/magnetic-x-bikes/', '09', 'Magnetic X-Bikes', 1, 'magnetic-x-bikes']],
    'body'         => '<h2>Reading a cardio specification</h2><p>For treadmills, the four figures that matter are continuous motor rating, running area, rated maximum user weight and incline range. For bikes and cross trainers, look at the resistance system, flywheel behaviour and the range of saddle and handlebar adjustment. Where these are published in the Avon catalogue, they are listed on each product page.</p><h2>Balancing the mix</h2><p>A general fitness floor is commonly around half treadmills, a quarter cross trainers, and the rest split across upright, recumbent and spin bikes. Adjust for your members: a hotel needs compact bikes more than a bank of treadmills, and any floor serving older members should include at least one recumbent bike. <a href="/blog/best-cardio-equipment-commercial-gyms/">More on choosing cardio</a>.</p><h2>Placement and power</h2><p>Put cardio near ventilation, leave service access behind treadmills, and size the electrical supply against the actual machine list. Socket positions belong on the layout drawing, not in a conversation on installation day.</p>',
    'related'      => [['/products/', 'Full catalogue'], ['/commercial-gym/', 'Commercial range'], ['/home-gym/', 'Home range'], ['/commercial-gym-solutions/', 'Gym planning']],
];
require dirname(__DIR__, 1) . '/includes/tpl-listing.php';
