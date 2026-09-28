<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/components.php';

$all        = products();
$cats       = categories();
$totalProds = count($all);
$totalSubs  = array_sum(array_map(static fn($f) => count($f['subcategories']), $cats['families']));
/* "690+" style figure for banners — always rounded DOWN so it stays true. */
$prodsPlus  = (int) (floor($totalProds / 10) * 10);

/** Root-relative image path for a product slug, or '' if the product is gone. */
function home_img(string $slug): string
{
    $p = product($slug);
    return $p ? '/' . $p['image'] : '';
}

/**
 * Transparent, tightly-trimmed cut-out of a product photo for banner use
 * (generated into assets/images/home/cut/). Falls back to the catalogue photo.
 */
function home_cut(string $slug): string
{
    $rel = 'assets/images/home/cut/' . $slug . '.webp';
    return is_file(AVON_ROOT . '/' . $rel) ? '/' . $rel : home_img($slug);
}

/**
 * Uploaded banner artwork overrides the built-in banner design.
 *
 * Drop <key>.webp (or .jpg / .png) into assets/images/home/ and it is used
 * automatically; add <key>-mobile.webp for a separate phone crop. With no file
 * the banner is drawn in HTML/CSS from the product photography.
 */
function home_banner(string $key): ?array
{
    $found = ['src' => null, 'mobile' => null];
    foreach (['' => 'src', '-mobile' => 'mobile'] as $suffix => $slot) {
        foreach (['webp', 'jpg', 'jpeg', 'png'] as $ext) {
            $rel = 'assets/images/home/' . $key . $suffix . '.' . $ext;
            if (is_file(AVON_ROOT . '/' . $rel)) {
                $found[$slot] = '/' . $rel;
                break;
            }
        }
    }
    return $found['src'] ? $found : null;
}

/** Render an uploaded banner as a responsive <picture>. */
function banner_picture(array $b, string $alt, bool $eager = false): void
{
    ?>
    <picture class="bnr-photo">
      <?php if ($b['mobile']): ?><source media="(max-width: 700px)" srcset="<?= e($b['mobile']) ?>"><?php endif; ?>
      <img src="<?= e($b['src']) ?>" alt="<?= e($alt) ?>" <?= $eager ? 'fetchpriority="high"' : 'loading="lazy"' ?> decoding="async">
    </picture>
    <?php
}

/* ------------------------------------------------------------ hero slides */
$slides = [
    [
        'key'   => 'slide-1',
        'theme' => 'molten',
        'href'  => '/strength/molten-series/',
        'badge' => 'New Launch',
        'title' => ['Molten Series', 'Strength Unlimited'],
        'sub'   => 'Explore the complete strength series',
        'alt'   => 'Avon Fitness Molten Series selectorised strength machines',
        'imgs'  => ['ml-142-seated-leg-press', 'ml-164-glute-builder', 'ml-109-assisted-dip-chin'],
    ],
    [
        'key'   => 'slide-2',
        'theme' => 'cardio',
        'href'  => '/cardio/treadmills/',
        'badge' => 'Commercial Cardio',
        'title' => ['Treadmills', 'Built to Run'],
        'sub'   => 'AC-drive treadmills for busy gym floors',
        'alt'   => 'Avon Fitness commercial treadmills',
        'imgs'  => ['tm-491-commercial-treadmill', 'tm-499-hi-pro-commercial-treadmill', 'tm-1000-commercial-treadmill'],
    ],
    [
        'key'   => 'slide-3',
        'theme' => 'home',
        'href'  => '/home-gym/',
        'badge' => 'Home Fitness',
        'title' => ['Home Gym', 'Collection'],
        'sub'   => 'Treadmills, cross trainers, spin bikes & home gyms',
        'alt'   => 'Avon Fitness home gym, cross trainer and spin bike',
        'imgs'  => ['hg-1265-home-gym', 'ct-594-new-home-cross-trainer', 'sp-2207-home-spin-bike'],
    ],
];

/* ------------------------------------------------ category cards (4-up) */
$catCards = [
    ['Treadmills',     '/cardio/treadmills/',            'tm-147-home-treadmill'],
    ['Home Gyms',      '/strength/home-gym-stations/',   'hg-1212-home-gym'],
    ['Cross Trainers', '/cardio/cross-trainers/',        'ct-594-new-home-cross-trainer'],
    ['Spin Bikes',     '/cardio/spin-bikes/',            'sp-2207-home-spin-bike'],
];

/* ------------------------------------------------- accessory promo cards */
$promos = [
    ['Gym flooring & protection', 'Gym Flooring & Protection', '/search/?q=flooring',
        ['gym-tuff-flooring', 'boxing-gloves', 'gg-106-gym-gloves']],
    ['Strength & Conditioning', 'Strength & Conditioning', '/search/?q=battle+rope',
        ['pp-battle-rope', 'mb-116-medicine-ball', 'st-063-suspension-training-system-with-bag']],
    ['Weightlifting equipment', 'Weightlifting Equipment', '/search/?q=belt',
        ['olympic-bar-with-bearing', 'power-weight-lifting-belt', 'weight-lifting-leather-belt']],
];

/* ---------------------------------------- partner logos (drop-in folder) */
$partners = [];
foreach (glob(AVON_ROOT . '/assets/images/partners/*.{webp,png,jpg,jpeg,svg}', GLOB_BRACE) ?: [] as $f) {
    $base = pathinfo($f, PATHINFO_FILENAME);
    $partners[] = [
        'src' => '/assets/images/partners/' . basename($f),
        'alt' => ucwords(trim(preg_replace('/[-_]+/', ' ', preg_replace('/^\d+[-_]*/', '', $base)))),
    ];
}

/* --------------------------------------------- product tabs (filterable) */
$tabs = [
    ['treadmills',     'Treadmills',     products_where(['sub' => 'treadmills']),        '/cardio/treadmills/'],
    ['cross-trainers', 'Cross Trainers', products_where(['sub' => 'cross-trainers']),    '/cardio/cross-trainers/'],
    ['spin-bikes',     'Spin Bikes',     products_where(['sub' => 'spin-bikes']),        '/cardio/spin-bikes/'],
    ['home-gyms',      'Home Gyms',      products_where(['sub' => 'home-gym-stations']), '/strength/home-gym-stations/'],
    ['strength',       'Strength',       products_where(['family' => 'strength', 'segment' => 'commercial']), '/strength/'],
    ['accessories',    'Accessories',    products_where(['family' => 'accessories']),    '/accessories/'],
];

$homeFaqs = [
    ['q' => 'What gym equipment do I need to start a commercial gym?',
     'a' => 'A workable commercial floor starts with three blocks: cardio (treadmills, cross trainers, spin and upright bikes), selectorised strength for the main movement patterns (chest press, lat pull down, leg press, shoulder press, row), and a free-weight area with benches, racks, dumbbells and plates. From there you scale by membership size and floor area. Send us your floor plan and we will build the list against your actual space — see our <a href="/commercial-gym-solutions/">commercial gym solutions</a>.'],
    ['q' => 'How much does it cost to set up a gym in Maharashtra?',
     'a' => 'Cost depends on three things: the floor area, whether you are equipping for domestic or commercial duty, and the split between selectorised and plate-loaded strength. Because every project differs on all three, we quote per project rather than publishing a price list — that way you are not paying for equipment that does not suit your space. Tell us your area and expected footfall and we will come back with a costed equipment list.'],
    ['q' => 'What is the difference between commercial and home gym equipment?',
     'a' => 'Commercial equipment is specified for continuous duty — heavier frames, higher-rated motors, larger running surfaces and components chosen for repeated daily use by mixed user weights. Home equipment is sized for a domestic footprint and lighter usage patterns. Both sit in the Avon range; the right one depends on how many hours a day the machine will actually run. Compare our <a href="/commercial-gym/">commercial range</a> against the <a href="/home-gym/">home gym range</a>.'],
    ['q' => 'Do you deliver and install gym equipment across Maharashtra?',
     'a' => 'Yes. We supply, deliver, install and commission across Maharashtra — Mumbai, Thane, Navi Mumbai, Pune, Nashik, Nagpur, Chhatrapati Sambhajinagar, Kolhapur, Solapur and the rest of the state — and handle pan-India supply on project orders. <a href="/installation/">More on installation</a>.'],
    ['q' => 'Which treadmill is suitable for a commercial gym?',
     'a' => 'For a paying gym floor, look at the motor rating, the running area and the rated maximum user weight together. Avon commercial treadmills run from around 4 HP up to 5.5 HP continuous with running areas from roughly 1540 x 600 mm upwards and user ratings up to 240 kg on the larger models. Browse the full <a href="/cardio/treadmills/">treadmill range</a> and compare specifications side by side.'],
    ['q' => 'Can I get a full gym package rather than buying machine by machine?',
     'a' => 'Yes — that is how most commercial projects are handled. We work from your floor plan, propose a layout and equipment mix, and quote the package as one order covering supply, delivery, installation and commissioning.'],
    ['q' => 'Do you supply outdoor and open-gym equipment?',
     'a' => 'Yes. The <a href="/outdoor-gym/">outdoor range</a> covers units built for permanent open-air installation in parks, housing societies, campuses and municipal fitness zones, including the foundation components needed to fix them down properly.'],
];

$PAGE = [
    'title'       => 'Gym Equipment in Maharashtra | Commercial & Home | Avon Fitness',
    'description' => 'Avon Fitness supplies, installs and services commercial and home gym equipment across Maharashtra — treadmills, spin bikes, cross trainers, multi stations, strength series, outdoor gym equipment and accessories. ' . $totalProds . ' products. Get a quote.',
    'canonical'   => '',
    'nav'         => 'home',
    'catalog_js'  => false,
    'body_attr'   => 'data-page="home"',
    'schema'      => [faq_schema($homeFaqs)],
];
require __DIR__ . '/includes/header.php';
?>

<h1 class="sr-only">Avon Fitness Maharashtra — commercial and home gym equipment supplied and installed across Maharashtra</h1>

<!-- ============ 01 HERO BANNER SLIDER ============ -->
<section class="hs" data-banner-slider data-interval="5000"
         aria-roledescription="carousel" aria-label="Featured Avon Fitness ranges">
  <div class="hs__track">
    <?php foreach ($slides as $i => $s): $photo = home_banner($s['key']); ?>
      <div class="hs__slide<?= $i === 0 ? ' is-active' : '' ?>" data-slide="<?= $i ?>"
           role="group" aria-roledescription="slide"
           aria-label="<?= $i + 1 ?> of <?= count($slides) ?>: <?= e($s['title'][0]) ?>"
           <?= $i ? 'aria-hidden="true"' : '' ?>>
        <a class="hs__link" href="<?= e($s['href']) ?>" <?= $i ? 'tabindex="-1"' : '' ?>>
          <?php if ($photo): banner_picture($photo, $s['alt'], $i === 0); else: ?>
          <div class="bnr bnr--<?= e($s['theme']) ?>">
            <span class="bnr__fx" aria-hidden="true"><i></i><i></i><i></i></span>
            <div class="bnr__text">
              <span class="bnr__badge"><?= e($s['badge']) ?></span>
              <h2 class="bnr__title">
                <span><?= e($s['title'][0]) ?></span>
                <span><?= e($s['title'][1]) ?></span>
              </h2>
              <p class="bnr__sub"><?= e($s['sub']) ?></p>
            </div>
            <?php foreach ($s['imgs'] as $n => $slug): $src = home_cut($slug); if (!$src) continue; ?>
              <img class="bnr__img bnr__img--<?= $n + 1 ?>" src="<?= e($src) ?>"
                   alt="<?= $n === 0 ? e($s['alt']) : '' ?>" width="700" height="700"
                   <?= ($i === 0 && $n === 0) ? 'fetchpriority="high"' : 'loading="lazy"' ?> decoding="async">
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

  <button class="hs__arrow hs__arrow--prev" type="button" data-bs-prev aria-label="Previous banner">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
  </button>
  <button class="hs__arrow hs__arrow--next" type="button" data-bs-next aria-label="Next banner">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
  </button>
  <div class="hs__dots" role="tablist" aria-label="Choose banner">
    <?php foreach ($slides as $i => $s): ?>
      <button class="hs__dot<?= $i === 0 ? ' is-active' : '' ?>" type="button" role="tab"
              data-bs-dot="<?= $i ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
              aria-label="<?= e($s['title'][0]) ?>"></button>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ 02 CATEGORY CARDS + TREADMILL BANNER ============ -->
<section class="hcat">
  <div class="hwrap">
    <div class="hcat__grid">
      <?php foreach ($catCards as [$name, $href, $slug]): ?>
        <a class="hcat__card" href="<?= e($href) ?>">
          <span class="hcat__name"><?= e($name) ?></span>
          <?php if ($src = home_cut($slug)): ?>
            <img src="<?= e($src) ?>" alt="Avon Fitness <?= e(strtolower($name)) ?>" width="700" height="700" loading="lazy" decoding="async">
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </div>

    <?php $photo = home_banner('banner-run'); ?>
    <a class="hrun" href="/cardio/treadmills/" aria-label="Shop treadmills">
      <?php if ($photo): banner_picture($photo, 'Avon Fitness treadmills'); else: ?>
      <span class="hrun__room" aria-hidden="true"></span>
      <span class="hrun__panel" aria-hidden="true"></span>
      <span class="hrun__text">
        <span class="hrun__l1">Run.</span>
        <span class="hrun__l1">Push.</span>
        <span class="hrun__l2">Repeat.</span>
      </span>
      <img class="hrun__tm hrun__tm--1" src="<?= e(home_cut('tm-493-new-commercial-treadmill')) ?>" alt="" width="700" height="700" loading="lazy" decoding="async">
      <img class="hrun__tm hrun__tm--2" src="<?= e(home_cut('tm-491-commercial-treadmill')) ?>" alt="" width="700" height="700" loading="lazy" decoding="async">
      <img class="hrun__tm hrun__tm--3" src="<?= e(home_cut('tm-477-commercial-treadmill')) ?>" alt="" width="700" height="700" loading="lazy" decoding="async">
      <span class="hrun__cta">Shop Treadmills
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </span>
      <?php endif; ?>
    </a>
  </div>
</section>

<!-- ============ 03 ACCESSORY PROMO CARDS ============ -->
<section class="hpromo">
  <div class="hwrap">
    <div class="hpromo__grid">
      <?php foreach ($promos as [$title, $mark, $href, $imgs]): ?>
        <div class="hpromo__card">
          <span class="hpromo__mark" aria-hidden="true"><?= e($mark) ?></span>
          <h2 class="hpromo__title"><?= e($title) ?></h2>
          <a class="hpromo__btn" href="<?= e($href) ?>">Buy Now<span class="sr-only"> — <?= e($title) ?></span></a>
          <?php foreach ($imgs as $n => $slug): if (!$src = home_cut($slug)) continue; ?>
            <img class="hpromo__img hpromo__img--<?= $n + 1 ?>" src="<?= e($src) ?>" alt="" width="700" height="700" loading="lazy" decoding="async">
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 04 PARTNERS ============ -->
<section class="hpart">
  <div class="hwrap">
    <?php if ($partners): ?>
      <h2 class="hsec-title">Our Fitness Partners</h2>
      <div class="hpart__row">
        <?php foreach ($partners as $pt): ?>
          <span class="hpart__logo"><img src="<?= e($pt['src']) ?>" alt="<?= e($pt['alt']) ?>" loading="lazy" decoding="async"></span>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <h2 class="hsec-title">Trusted Across Every Kind of Gym</h2>
      <div class="hpart__row">
        <?php
        $sectors = [
            ['Commercial Gyms', 'M6 7v10M18 7v10M3 10v4M21 10v4M6 12h12'],
            ['Hotels &amp; Resorts', 'M3 21V8l9-5 9 5v13M9 21v-6h6v6'],
            ['Corporate Fitness', 'M4 21V5a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v16M15 9h4a1 1 0 0 1 1 1v11M8 8h3M8 12h3M8 16h3'],
            ['Colleges &amp; Universities', 'M2 9l10-5 10 5-10 5zM6 11v5c0 1.5 3 3 6 3s6-1.5 6-3v-5'],
            ['Defence &amp; Government', 'M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z'],
            ['Housing Societies', 'M3 21h18M5 21V10l7-5 7 5v11M10 21v-5h4v5'],
            ['Sports Academies', 'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18M3.5 9h17M3.5 15h17M12 3c2.5 2.5 3.5 5.5 3.5 9s-1 6.5-3.5 9c-2.5-2.5-3.5-5.5-3.5-9s1-6.5 3.5-9'],
            ['Home Gyms', 'M3 11 12 4l9 7M5 10v10h14V10M10 20v-5h4v5'],
        ];
        foreach ($sectors as [$label, $path]): ?>
          <span class="hpart__logo hpart__logo--sector">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="<?= $path ?>"/></svg>
            <span><?= $label ?></span>
          </span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ============ 05 "PRODUCTS TO CHOOSE FROM" BANNER ============ -->
<?php $photo = home_banner('banner-products'); ?>
<a class="hprod" href="/products/">
  <?php if ($photo): banner_picture($photo, 'Over ' . $prodsPlus . ' Avon Fitness products'); else: ?>
  <span class="hprod__room" aria-hidden="true"><i class="hprod__floor"></i></span>
  <span class="hprod__gear" aria-hidden="true">
    <?php
    $gear = ['ff-149-pro-power-cage', 'elite-864-squat-rack', 'multi-bench', 'weight-plate-rack',
             'rhino-839-max-power-cage-with-smith-machine', 'v-squat-rack', 'ff-165-multi-adjustable-bench', 'rs-2086-olympic-rod-stand'];
    foreach ($gear as $n => $slug): if (!$src = home_cut($slug)) continue; ?>
      <img class="hprod__g hprod__g--<?= $n + 1 ?>" src="<?= e($src) ?>" alt="" width="700" height="700" loading="lazy" decoding="async">
    <?php endforeach; ?>
  </span>
  <span class="hprod__strip">Over <?= $prodsPlus ?>+ products to choose from</span>
  <span class="hprod__cta">Explore the full catalogue
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
  </span>
  <?php endif; ?>
</a>

<!-- ============ 06 OUR PRODUCTS (filter tabs) ============ -->
<section class="hprods">
  <div class="hwrap">
    <h2 class="hsec-title">Our Products</h2>
    <p class="hsec-lead"><?= $totalProds ?> products across <?= $totalSubs ?> categories — pick a range to filter.</p>

    <div class="htabs" role="tablist" aria-label="Filter products by range" data-htabs>
      <?php foreach ($tabs as $i => [$key, $label]): ?>
        <button class="htabs__btn<?= $i === 0 ? ' is-active' : '' ?>" type="button" role="tab"
                id="htab-<?= e($key) ?>" aria-controls="hpanel-<?= e($key) ?>"
                aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" <?= $i ? 'tabindex="-1"' : '' ?>
                data-htab="<?= e($key) ?>"><?= e($label) ?></button>
      <?php endforeach; ?>
    </div>

    <?php foreach ($tabs as $i => [$key, $label, $list, $href]): ?>
      <div class="htabs__panel" id="hpanel-<?= e($key) ?>" role="tabpanel"
           aria-labelledby="htab-<?= e($key) ?>" <?= $i ? 'hidden' : '' ?>>
        <div class="grid g-4">
          <?php foreach (array_slice(rank_products($list), 0, 8) as $p) { product_card($p); } ?>
        </div>
        <p class="htabs__more"><a class="hpromo__btn" href="<?= e($href) ?>">View all <?= e(strtolower($label)) ?> (<?= count($list) ?>)</a></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ 07 WHY AVON ============ -->
<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('', 'Why Avon Fitness',
        'Manufactured here.<br><span class="thin">Serviced here.</span>',
        'Avon Fitness is part of the Avon group of Ludhiana, a name that has been manufacturing in India for over 75 years. That matters in practice, not just in a brochure.'); ?>

    <div class="grid g-3" data-stagger>
      <?php
      $why = [
          ['Made in India', 'Designed and built domestically, which keeps spares, service response and lead times predictable.'],
          ['Commercial Duty', 'Heavy-gauge frames, high-tensile steel tube and components specified for continuous gym-floor use.'],
          ['One Range, Every Space', $totalProds . ' products across ' . $totalSubs . ' categories — cardio, strength, outdoor and accessories under one supplier.'],
          ['Documented Specifications', 'Published dimensions, weights, stacks and motor ratings so you can plan a floor properly before ordering.'],
          ['Installation Included', 'Delivery, assembly and commissioning handled on site across Maharashtra — not left to the customer.'],
          ['After-Sales Support', 'Service and spares backed by the manufacturer&rsquo;s technical and spare-parts desk.'],
      ];
      foreach ($why as [$t, $d]): ?>
        <div class="fcard">
          <span class="fcard__ico" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m5 13 4 4L19 7"/></svg>
          </span>
          <h3><?= $t ?></h3>
          <p><?= $d ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 08 BLOG ============ -->
<section class="section">
  <div class="wrap-wide">
    <?php sec_head('', 'Guides &amp; insight',
        'Before you<br><span class="thin">place the order.</span>',
        'Practical guides on choosing, planning and maintaining gym equipment.',
        '/blog/', 'All articles'); ?>
    <div class="grid g-3" data-stagger>
      <?php foreach (array_slice(articles(), 0, 3) as $a): ?>
        <a class="blog-card" href="/blog/<?= e($a['slug']) ?>/">
          <span class="blog-card__top"><?= e($a['category']) ?> &middot; <?= e($a['read']) ?></span>
          <span class="blog-card__body">
            <h3><?= e($a['title']) ?></h3>
            <p><?= e($a['excerpt']) ?></p>
            <span class="card__go">Read guide
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 09 FAQ ============ -->
<section class="section section--alt">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('', 'Questions',
        'Straight answers<br><span class="thin">before you buy.</span>'); ?>
    <?php faq_block($homeFaqs, 'home-faq'); ?>
    <p style="margin-top:1.6rem"><a class="ulink" href="/faqs/">See all frequently asked questions &rarr;</a></p>
  </div>
</section>

<!-- ============ 10 FINAL CTA ============ -->
<?php cta_band(); ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
