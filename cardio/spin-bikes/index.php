<?php
$LIST = [
    'h1'           => 'Spin Bikes',
    'intro'        => 'Spin bikes for studio classes and home training — flywheel-driven indoor cycles with adjustable saddle and handlebar positions.',
    'eyebrow'      => 'Cardio Equipment',
    'canonical'    => 'cardio/spin-bikes/',
    'title'        => 'Spin Bikes — 14 Models | Avon Fitness Maharashtra',
    'description'  => 'Spin bikes for studio classes and home training — flywheel-driven indoor cycles with adjustable saddle and handlebar positions. Supplied and installed across Mumbai, Pune, Nagpur and Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['sub' => 'spin-bikes'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Cardio Equipment', 'url' => '/cardio/'], ['name' => 'Spin Bikes']],
    'body'         => '<h2>What to look at on a spin bike</h2><p>Flywheel mass and the brake system determine how the ride feels under load. Adjustability matters more than most buyers expect: one studio bike has to fit riders of very different heights, so check the range of saddle and handlebar movement in both directions.</p><h2>Studio use</h2><p>If you are running classes, the bike is a business decision — a studio of bikes supports a timetable and a revenue line, so specify for continuous class use and easy servicing rather than on unit price alone.</p>',
    'faqs'         => [['q' => 'How many spin bikes do I need for a studio?', 'a' => 'Work backwards from class size and room area, allowing clear space around each bike for mounting and for an instructor to move. Tell us the room dimensions and we will lay it out.'], ['q' => 'Are these bikes suitable for home use?', 'a' => 'Yes — the range covers both home and commercial specifications. Ask us which model suits your expected hours of use.']],
    'related'      => [['/cardio/treadmills/', 'Treadmills'], ['/cardio/cross-trainers/', 'Cross Trainers'], ['/cardio/upright-bikes/', 'Upright Bikes'], ['/cardio/recumbent-bikes/', 'Recumbent Bikes'], ['/cardio/air-bikes/', 'Air Bikes'], ['/cardio/massagers/', 'Massagers'], ['/cardio/', 'All cardio equipment']],
];
require dirname(__DIR__, 2) . '/includes/tpl-listing.php';
