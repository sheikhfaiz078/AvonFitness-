<?php
$LIST = [
    'h1'           => 'Recumbent Bikes',
    'intro'        => 'Recumbent exercise bikes — back-supported, step-through cardio for accessibility, comfort and rehabilitation.',
    'eyebrow'      => 'Cardio Equipment',
    'canonical'    => 'cardio/recumbent-bikes/',
    'title'        => 'Recumbent Bikes — 17 Models | Avon Fitness Maharashtra',
    'description'  => 'Recumbent exercise bikes — back-supported, step-through cardio for accessibility, comfort and rehabilitation. Supplied and installed across Mumbai, Pune, Nagpur and Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['sub' => 'recumbent-bikes'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Cardio Equipment', 'url' => '/cardio/'], ['name' => 'Recumbent Bikes']],
    'body'         => '<h2>An underrated category</h2><p>Recumbent bikes are what make a gym floor usable by older members, larger members and anyone working through a rehabilitation programme. The back support and step-through frame remove the two barriers that stop people using cardio equipment at all.</p><p>For society gyms, corporate fitness rooms and hotels serving a broad age range, at least one recumbent bike is worth more than an extra treadmill.</p>',
    'faqs'         => [['q' => 'Are recumbent bikes good for knee problems?', 'a' => 'They are commonly chosen for low-impact training because the seated, supported position reduces joint loading compared with running. For a specific medical condition, take advice from a physiotherapist or doctor on what is appropriate for you.']],
    'related'      => [['/cardio/treadmills/', 'Treadmills'], ['/cardio/cross-trainers/', 'Cross Trainers'], ['/cardio/upright-bikes/', 'Upright Bikes'], ['/cardio/spin-bikes/', 'Spin Bikes'], ['/cardio/air-bikes/', 'Air Bikes'], ['/cardio/massagers/', 'Massagers'], ['/cardio/', 'All cardio equipment']],
];
require dirname(__DIR__, 2) . '/includes/tpl-listing.php';
