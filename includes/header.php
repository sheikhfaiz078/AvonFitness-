<?php
/**
 * Document head + sticky header + mega menu + mobile navigation + search.
 *
 * Pages set these before including this file:
 *   $PAGE = [
 *     'title','description','canonical','h1',
 *     'og_image'   (optional, defaults to the brand card)
 *     'schema'     (optional array of JSON-LD graphs)
 *     'crumbs'     (optional [['name'=>..,'url'=>..], ...])
 *     'noindex'    (optional bool)
 *     'body_attr'  (optional extra body attributes)
 *     'nav'        (optional active nav key)
 *   ];
 */
require_once __DIR__ . '/config.php';

$PAGE       = $PAGE ?? [];
$title      = seo_title($PAGE['title'] ?? ($CFG['SITE_NAME'] . ' | ' . $CFG['SITE_TAGLINE']));
$desc       = seo_desc($PAGE['description'] ?? $CFG['SITE_TAGLINE']);
$canonical  = url($PAGE['canonical'] ?? '');
$ogImage    = url($PAGE['og_image'] ?? 'assets/images/brand/og-image.jpg');
$navActive  = $PAGE['nav'] ?? '';
$cats       = categories();

/* ---------------- Organisation + WebSite graph (every page) ------------- */
$orgId  = url('#organisation');
$siteId = url('#website');

$graph = [
    [
        '@type'       => 'Organization',
        '@id'         => $orgId,
        'name'        => $CFG['SITE_NAME'],
        'alternateName' => 'Avon Fitness',
        'url'         => url(),
        'logo'        => [
            '@type' => 'ImageObject',
            'url'   => url('assets/images/brand/avon-fitness-logo.png'),
        ],
        'image'       => $ogImage,
        'description' => 'Supplier and installer of Avon Fitness commercial and home gym '
                       . 'equipment across Maharashtra — cardio, strength, outdoor and accessories.',
        'telephone'   => $CFG['CONTACT_PHONE_RAW'],
        'email'       => $CFG['CONTACT_EMAIL'],
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $CFG['ADDRESS_LINE2'],
            'addressLocality' => $CFG['ADDRESS_CITY'],
            'addressRegion'   => $CFG['ADDRESS_STATE'],
            'postalCode'      => $CFG['ADDRESS_PIN'],
            'addressCountry'  => 'IN',
        ],
        'areaServed'  => [
            ['@type' => 'State', 'name' => 'Maharashtra'],
            ['@type' => 'Country', 'name' => 'India'],
        ],
        'contactPoint' => [[
            '@type'             => 'ContactPoint',
            'contactType'       => 'sales',
            'telephone'         => $CFG['CONTACT_PHONE_RAW'],
            'email'             => $CFG['CONTACT_EMAIL'],
            'areaServed'        => 'IN',
            'availableLanguage' => ['en', 'hi', 'mr'],
        ]],
        /* Verified official profiles only — an empty value is dropped. */
        'sameAs' => array_values(array_filter([
            $CFG['SOCIAL_FACEBOOK'], $CFG['SOCIAL_INSTAGRAM'],
            $CFG['SOCIAL_YOUTUBE'], $CFG['SOCIAL_LINKEDIN'],
        ])),
    ],
    [
        '@type'           => 'WebSite',
        '@id'             => $siteId,
        'url'             => url(),
        'name'            => $CFG['SITE_NAME'],
        'publisher'       => ['@id' => $orgId],
        'inLanguage'      => 'en-IN',
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => ['@type' => 'EntryPoint',
                              'urlTemplate' => url('search/') . '?q={search_term_string}'],
            'query-input' => 'required name=search_term_string',
        ],
    ],
];

if (!empty($PAGE['crumbs'])) {
    $items = [];
    foreach ($PAGE['crumbs'] as $i => $c) {
        $items[] = array_filter([
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $c['name'],
            'item'     => isset($c['url']) ? url($c['url']) : null,
        ]);
    }
    $graph[] = ['@type' => 'BreadcrumbList',
                '@id'   => $canonical . '#breadcrumbs',
                'itemListElement' => $items];
}

foreach ($PAGE['schema'] ?? [] as $extra) {
    $graph[] = $extra;
}

$jsonld = json_encode(
    ['@context' => 'https://schema.org', '@graph' => $graph],
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
);

/* ---------------- mega-menu data ---------------------------------------- */
$megaCardio   = array_slice($cats['families'][0]['subcategories'] ?? [], 0, 9);
$strengthSubs = $cats['families'][1]['subcategories'] ?? [];
$megaCore     = array_values(array_filter($strengthSubs, static fn($s) => !str_ends_with($s['slug'], '-series')));
$megaSeries   = array_values(array_filter($strengthSubs, static fn($s) => str_ends_with($s['slug'], '-series')));
?>
<!doctype html>
<html lang="en-IN" data-base="/">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($desc) ?>">
<link rel="canonical" href="<?= e($canonical) ?>">
<?php if (!empty($PAGE['noindex'])): ?>
<meta name="robots" content="noindex, follow">
<?php else: ?>
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<?php endif; ?>
<meta name="theme-color" content="#FFFFFF" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#111111" media="(prefers-color-scheme: dark)">
<meta name="format-detection" content="telephone=yes">
<meta name="author" content="<?= e($CFG['SITE_NAME']) ?>">
<meta name="geo.region" content="IN-MH">
<meta name="geo.placename" content="Maharashtra">

<meta property="og:type" content="<?= e($PAGE['og_type'] ?? 'website') ?>">
<meta property="og:site_name" content="<?= e($CFG['SITE_NAME']) ?>">
<meta property="og:locale" content="en_IN">
<meta property="og:title" content="<?= e($PAGE['og_title'] ?? $title) ?>">
<meta property="og:description" content="<?= e($PAGE['og_description'] ?? $desc) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:image:alt" content="<?= e($CFG['SITE_NAME']) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($PAGE['og_title'] ?? $title) ?>">
<meta name="twitter:description" content="<?= e($PAGE['og_description'] ?? $desc) ?>">
<meta name="twitter:image" content="<?= e($ogImage) ?>">

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/brand/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/brand/favicon-16.png">
<link rel="apple-touch-icon" href="/assets/images/brand/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Archivo:wght@600;700;800&family=Roboto:wght@400;500;700;900&family=Poppins:ital,wght@0,600;0,700;0,800;1,700;1,800&family=Montserrat:ital,wght@0,400;0,700;1,800&family=IBM+Plex+Mono:wght@400;500&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@600;700;800&family=Roboto:wght@400;500;700;900&family=Poppins:ital,wght@0,600;0,700;0,800;1,700;1,800&family=Montserrat:ital,wght@0,400;0,700;1,800&family=IBM+Plex+Mono:wght@400;500&display=swap" media="print" onload="this.media='all'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@600;700;800&family=Roboto:wght@400;500;700;900&family=Poppins:ital,wght@0,600;0,700;0,800;1,700;1,800&family=Montserrat:ital,wght@0,400;0,700;1,800&family=IBM+Plex+Mono:wght@400;500&display=swap"></noscript>
<link rel="stylesheet" href="/assets/css/main.css?v=4">

<script type="application/ld+json"><?= $jsonld ?></script>
<script>window.AVON_CONFIG={phone:<?= json_encode($CFG['CONTACT_PHONE']) ?>,phone_raw:<?= json_encode($CFG['CONTACT_PHONE_RAW']) ?>,whatsapp:<?= json_encode($CFG['WHATSAPP_NUMBER']) ?>,email:<?= json_encode($CFG['CONTACT_EMAIL']) ?>};</script>
</head>
<body class="has-mbar"<?= isset($PAGE['body_attr']) ? ' ' . $PAGE['body_attr'] : '' ?>>
<div class="progress" aria-hidden="true"></div>
<a class="skip-link" href="#main">Skip to main content</a>

<header class="hdr">
  <div class="hdr__inner">
    <a class="hdr__logo" href="/" aria-label="<?= e($CFG['SITE_NAME']) ?> — home">
      <img src="/assets/images/brand/avon-fitness-logo.webp" width="420" height="199"
           alt="Avon Fitness logo" fetchpriority="high">
    </a>

    <nav class="nav" aria-label="Main navigation">
      <ul class="nav__list">
        <li><a class="nav__link<?= $navActive === 'home' ? ' is-active' : '' ?>" href="/">Home</a></li>
        <li>
          <button class="nav__link<?= in_array($navActive, ['products','cardio','strength','accessories'], true) ? ' is-active' : '' ?>"
                  type="button" data-mega="mega-products" aria-expanded="false" aria-controls="mega-products">
            Products
            <svg class="nav__caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
          </button>
        </li>
        <li><a class="nav__link<?= $navActive === 'commercial' ? ' is-active' : '' ?>" href="/commercial-gym/">Commercial</a></li>
        <li><a class="nav__link<?= $navActive === 'home-gym' ? ' is-active' : '' ?>" href="/home-gym/">Home Gym</a></li>
        <li><a class="nav__link<?= $navActive === 'outdoor' ? ' is-active' : '' ?>" href="/outdoor-gym/">Outdoor</a></li>
        <li><a class="nav__link<?= $navActive === 'solutions' ? ' is-active' : '' ?>" href="/commercial-gym-solutions/">Gym Solutions</a></li>
        <li><a class="nav__link<?= $navActive === 'maharashtra' ? ' is-active' : '' ?>" href="/gym-equipment-maharashtra/">Maharashtra</a></li>
        <li><a class="nav__link<?= $navActive === 'about' ? ' is-active' : '' ?>" href="/about/">About</a></li>
        <li><a class="nav__link<?= $navActive === 'contact' ? ' is-active' : '' ?>" href="/contact/">Contact</a></li>
      </ul>
    </nav>

    <div class="hdr__tools">
      <button class="hbtn hbtn--circle" type="button" data-search-open aria-label="Search equipment">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </button>
      <a class="hbtn hbtn--pill" href="/catalogue/">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M12 3v12M7 10l5 5 5-5M5 21h14"/></svg>
        Catalogue
      </a>
      <a class="hbtn hbtn--circle hbtn--call" href="tel:<?= e($CFG['CONTACT_PHONE_RAW']) ?>" aria-label="Call <?= e($CFG['CONTACT_PHONE']) ?>">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a1 1 0 0 1-1 1A16 16 0 0 1 4 5a1 1 0 0 1 1-1"/></svg>
      </a>
      <button class="burger" type="button" aria-expanded="false" aria-label="Open menu" aria-controls="mobile-nav">
        <i></i><i></i><i></i>
      </button>
    </div>
  </div>

  <!-- ---------------- mega menu ---------------- -->
  <div class="mega" id="mega-products" role="region" aria-label="Product categories">
    <div class="mega__inner">
      <div class="mega__col">
        <h3>Cardio</h3>
        <?php foreach ($megaCardio as $s): ?>
          <a href="/cardio/<?= e($s['slug']) ?>/"><?= e($s['name']) ?><span><?= sub_count($s['slug']) ?></span></a>
        <?php endforeach; ?>
        <a href="/cardio/"><strong>All cardio equipment</strong></a>
      </div>
      <div class="mega__col">
        <h3>Strength</h3>
        <?php foreach (array_slice($megaCore, 0, 9) as $s): ?>
          <a href="/strength/<?= e($s['slug']) ?>/"><?= e($s['name']) ?><span><?= sub_count($s['slug']) ?></span></a>
        <?php endforeach; ?>
        <a href="/strength/"><strong>All strength equipment</strong></a>
      </div>
      <div class="mega__col">
        <h3>Strength Series</h3>
        <?php foreach (array_slice($megaSeries, 0, 10) as $s): ?>
          <a href="/strength/<?= e($s['slug']) ?>/"><?= e($s['name']) ?><span><?= sub_count($s['slug']) ?></span></a>
        <?php endforeach; ?>
      </div>
      <div class="mega__col">
        <h3>By Space</h3>
        <a href="/commercial-gym/">Commercial Gym<span><?= count(products_where(['segment' => 'commercial'])) ?></span></a>
        <a href="/home-gym/">Home Gym<span><?= count(products_where(['segment' => 'home'])) ?></span></a>
        <a href="/outdoor-gym/">Outdoor Gym<span><?= count(products_where(['family' => 'outdoor'])) ?></span></a>
        <a href="/accessories/">Accessories<span><?= count(products_where(['family' => 'accessories'])) ?></span></a>
        <a href="/products/"><strong>Full catalogue</strong><span><?= count(products()) ?></span></a>
        <a href="/compare/">Compare equipment</a>
        <a href="/catalogue/">Download catalogues</a>
      </div>
      <div class="mega__promo">
        <div>
          <strong>Planning a full gym?</strong>
          <p>Send us the floor plan. We come back with a layout, an equipment list and a single quotation.</p>
        </div>
        <a class="btn btn--sm" href="/commercial-gym-solutions/">Plan Your Gym</a>
      </div>
    </div>
  </div>
</header>

<!-- ---------------- mobile navigation ---------------- -->
<nav class="mnav" id="mobile-nav" aria-label="Mobile navigation">
  <div class="mnav__top">
    <img src="/assets/images/brand/avon-fitness-logo-white.webp" width="420" height="199" alt="Avon Fitness" loading="lazy">
    <button class="mnav__close" type="button" data-close-nav aria-label="Close menu">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
  </div>
  <ul class="mnav__list">
    <li><a class="mnav__link" href="/">Home</a></li>
    <li>
      <button class="mnav__link" type="button" data-mtoggle="msub-cardio" aria-expanded="false">Cardio
        <svg class="mnav__chev" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="mnav__sub" id="msub-cardio"><div>
        <?php foreach ($megaCardio as $s): ?><a href="/cardio/<?= e($s['slug']) ?>/"><?= e($s['name']) ?> (<?= sub_count($s['slug']) ?>)</a><?php endforeach; ?>
        <a href="/cardio/">All cardio equipment</a>
      </div></div>
    </li>
    <li>
      <button class="mnav__link" type="button" data-mtoggle="msub-strength" aria-expanded="false">Strength
        <svg class="mnav__chev" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
      </button>
      <div class="mnav__sub" id="msub-strength"><div>
        <?php foreach (array_slice($megaCore, 0, 8) as $s): ?><a href="/strength/<?= e($s['slug']) ?>/"><?= e($s['name']) ?> (<?= sub_count($s['slug']) ?>)</a><?php endforeach; ?>
        <?php foreach (array_slice($megaSeries, 0, 8) as $s): ?><a href="/strength/<?= e($s['slug']) ?>/"><?= e($s['name']) ?> (<?= sub_count($s['slug']) ?>)</a><?php endforeach; ?>
        <a href="/strength/">All strength equipment</a>
      </div></div>
    </li>
    <li><a class="mnav__link" href="/commercial-gym/">Commercial Gym</a></li>
    <li><a class="mnav__link" href="/home-gym/">Home Gym</a></li>
    <li><a class="mnav__link" href="/outdoor-gym/">Outdoor Gym</a></li>
    <li><a class="mnav__link" href="/accessories/">Accessories</a></li>
    <li><a class="mnav__link" href="/commercial-gym-solutions/">Gym Solutions</a></li>
    <li><a class="mnav__link" href="/gym-equipment-maharashtra/">Maharashtra</a></li>
    <li><a class="mnav__link" href="/blog/">Blog</a></li>
    <li><a class="mnav__link" href="/about/">About</a></li>
    <li><a class="mnav__link" href="/contact/">Contact</a></li>
  </ul>
  <div class="mnav__cta">
    <a class="btn btn--block" href="/contact/">Get a Quote</a>
    <a class="btn btn--wa btn--block" href="<?= e(wa()) ?>" rel="noopener nofollow" target="_blank">Chat on WhatsApp</a>
  </div>
  <div class="mnav__meta">
    <p>Call <a href="tel:<?= e($CFG['CONTACT_PHONE_RAW']) ?>"><?= e($CFG['CONTACT_PHONE']) ?></a><br>
    <a href="mailto:<?= e($CFG['CONTACT_EMAIL']) ?>"><?= e($CFG['CONTACT_EMAIL']) ?></a></p>
  </div>
</nav>

<!-- ---------------- search overlay ---------------- -->
<div class="searchbox" role="dialog" aria-modal="true" aria-label="Search equipment">
  <div class="searchbox__inner">
    <form role="search" action="/search/" method="get">
      <div class="searchbox__field">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ED1C24" stroke-width="2.2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <label class="sr-only" for="site-search">Search equipment, model numbers and categories</label>
        <input id="site-search" name="q" type="search" placeholder="Search equipment or model…" autocomplete="off">
        <button class="icon-btn" type="button" data-search-close aria-label="Close search">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
      </div>
      <p class="searchbox__hint">Try “treadmill”, “TM-1000”, “lat pull down” or “spin bike” — press Enter for all results.</p>
    </form>
    <div id="search-results" class="searchbox__results"></div>
  </div>
</div>

<main id="main">
