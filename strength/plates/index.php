<?php
$LIST = [
    'h1'           => 'Weight Plates',
    'intro'        => 'Weight plates for plate-loaded stations, barbells and free-weight areas.',
    'eyebrow'      => 'Strength Equipment',
    'canonical'    => 'strength/plates/',
    'title'        => 'Weight Plates — 5 Models | Avon Fitness Maharashtra',
    'description'  => 'Weight plates for plate-loaded stations, barbells and free-weight areas. Supplied and installed across Mumbai, Pune, Nagpur and Maharashtra.',
    'nav'          => 'products',
    'scope'        => ['sub' => 'plates'],
    'crumbs'       => [['name' => 'Home', 'url' => '/'], ['name' => 'Products', 'url' => '/products/'], ['name' => 'Strength Equipment', 'url' => '/strength/'], ['name' => 'Weight Plates']],
    'body'         => '<h2>Plates are part of the equipment budget</h2><p>If you specify plate-loaded stations, the plates are not an accessory — they are the resistance. Budget for enough plates to load every station in use at peak time, plus storage trees so they are not left on the floor.</p>',
    'related'      => [['/strength/multi-stations/', 'Multi Stations'], ['/strength/fit-fighter-pro-series/', 'Fit Fighter Pro Series'], ['/strength/pl-series/', 'PL Series'], ['/strength/rhino-max-series/', 'Rhino Max Series'], ['/strength/mynd-series/', 'Mynd Series'], ['/strength/rafale-series/', 'Rafale Series'], ['/strength/', 'All strength equipment']],
];
require dirname(__DIR__, 2) . '/includes/tpl-listing.php';
