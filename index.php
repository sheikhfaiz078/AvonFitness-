<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/components.php';

$all        = products();
$cats       = categories();
$totalProds = count($all);
$totalSubs  = array_sum(array_map(static fn($f) => count($f['subcategories']), $cats['families']));

$featured = array_slice(rank_products(products_where(['family' => 'cardio'])), 0, 4);
$featured = array_merge($featured, array_slice(rank_products(products_where(['family' => 'strength'])), 0, 4));

/* Hero carousel. Slides use cut-out photography only — a white-matte JPEG
   would show as a white box on the charcoal hero. */
$heroSlides = hero_slides();
if (!$heroSlides) {
    $fallback = tile_sample('treadmills') ?? $all[0];
    $heroSlides = [['label' => $fallback['subcategory'],
                    'copy'  => $fallback['short_description'],
                    'h1'    => [['', 'Gym equipment'], ['accent', 'engineered'],
                                ['outline', 'for every space.']],
                    'product' => $fallback,
                    'spec'  => headline_spec($fallback)]];
}

/** Render one headline as the three animated lines. */
function hero_h1_lines(array $lines): string
{
    $out = '';
    foreach ($lines as [$cls, $text]) {
        $out .= '<span class="ln"><span' . ($cls ? ' class="' . e($cls) . '"' : '') . '>'
              . e($text) . '</span></span>';
    }
    return $out;
}

$showcase = array_slice(rank_products(products_where(['segment' => 'commercial'])), 0, 10);

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
    'schema'      => [faq_schema($homeFaqs)],
];
require __DIR__ . '/includes/header.php';
?>

<!-- ============ 01 HERO ============ -->
<section class="hero">
  <div class="hero__bg" aria-hidden="true">
    <span class="hero__grid"></span>
    <span class="hero__glow"></span>
    <span class="hero__slash"></span>
  </div>

  <div class="wrap-wide hero__inner hero-carousel"
       data-hero-carousel data-interval="3000"
       role="region" aria-roledescription="carousel"
       aria-label="Featured Avon Fitness equipment">

    <div class="hero__lead">
      <span class="eyebrow is-in">Maharashtra &middot; Commercial &amp; Home &middot; Pan-India Supply</span>

      <!--
        Exactly one top-level heading. Its contents are swapped per slide by
        main.js rather than rendering six headings, so the page keeps a single,
        unambiguous heading for search engines. The alternate headlines travel
        in the data-h1 attribute on each slide.
      -->
      <h1 class="hero__title" data-hero-h1><?= hero_h1_lines($heroSlides[0]['h1']) ?></h1>

      <!-- rotating supporting copy; the H1 above stays fixed for SEO -->
      <div class="hero__copywrap">
        <?php foreach ($heroSlides as $i => $s): ?>
          <p class="hero__copy hero-slide-copy<?= $i === 0 ? ' is-active' : '' ?>"
             data-hero-copy="<?= $i ?>"<?= $i ? ' aria-hidden="true"' : '' ?>><?= e($s['copy']) ?></p>
        <?php endforeach; ?>
      </div>

      <div class="hero__cta">
        <a class="btn" href="/products/">Explore Equipment
          <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
        <a class="btn btn--light" href="/commercial-gym-solutions/">Plan Your Gym</a>
      </div>

      <!-- slide controls -->
      <div class="hero__controls">
        <button class="hero__arrow" type="button" data-hero-prev aria-label="Previous equipment">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M19 12H5M11 19l-7-7 7-7"/></svg>
        </button>
        <div class="hero__dots" role="tablist" aria-label="Choose equipment to feature">
          <?php foreach ($heroSlides as $i => $s): ?>
            <button class="hero__dot<?= $i === 0 ? ' is-active' : '' ?>" type="button"
                    role="tab" data-hero-dot="<?= $i ?>"
                    aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                    aria-label="<?= e($s['label']) ?> — <?= e($s['product']['product_name']) ?>">
              <span class="hero__dot-fill"></span>
            </button>
          <?php endforeach; ?>
        </div>
        <button class="hero__arrow" type="button" data-hero-next aria-label="Next equipment">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </button>
        <button class="hero__pause" type="button" data-hero-pause
                aria-label="Pause the equipment carousel" aria-pressed="false">
          <svg class="ico-pause" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
          <svg class="ico-play" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
        </button>
      </div>
    </div>

    <div class="hero__stage">
      <?php foreach ($heroSlides as $i => $s): $p = $s['product']; ?>
        <figure class="hero-slide<?= $i === 0 ? ' is-active' : '' ?>"
                data-hero-slide="<?= $i ?>"
                data-h1="<?= e(json_encode($s['h1'], JSON_UNESCAPED_UNICODE)) ?>"
                role="group" aria-roledescription="slide"
                aria-label="<?= $i + 1 ?> of <?= count($heroSlides) ?>: <?= e($p['product_name']) ?>"
                <?= $i ? 'aria-hidden="true"' : '' ?>>
          <a class="hero-slide__link" href="/product/<?= e($p['slug']) ?>/"
             tabindex="<?= $i ? '-1' : '0' ?>">
            <img src="/<?= e($p['image']) ?>" alt="<?= e($p['image_alt']) ?>"
                 width="620" height="620"
                 <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> decoding="async">
          </a>
          <figcaption class="hero-slide__cap">
            <span class="hero-slide__label"><?= e($s['label']) ?></span>
            <span class="hero-slide__name"><?= e($p['product_name']) ?></span>
            <span class="hero-slide__spec"><?= e($s['spec']) ?></span>
            <a class="hero-slide__cta" href="/product/<?= e($p['slug']) ?>/" tabindex="<?= $i ? '-1' : '0' ?>">
              View specifications
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </a>
          </figcaption>
        </figure>
      <?php endforeach; ?>
      <p class="sr-only" aria-live="polite" data-hero-live></p>
    </div>
  </div>

  <div class="wrap-wide">
    <div class="hero__strip">
      <div class="hero__stat">
        <b><span data-count="75" data-suffix="+">0</span></b>
        <span>Years of the Avon name</span>
      </div>
      <div class="hero__stat">
        <b><span data-count="<?= $totalProds ?>" data-suffix="+">0</span></b>
        <span>Products in the catalogue</span>
      </div>
      <div class="hero__stat">
        <b><span data-count="<?= $totalSubs ?>">0</span></b>
        <span>Equipment categories</span>
      </div>
      <div class="hero__stat">
        <b><span class="u">MH</span></b>
        <span>Delivery &amp; installation</span>
      </div>
    </div>
  </div>

  <span class="scroll-cue" aria-hidden="true">Scroll to explore <i></i></span>
</section>

<!-- ============ 02 MARQUEE / TRUST ============ -->
<section class="section--dark" style="background:var(--charcoal)">
  <div class="marquee" aria-hidden="true">
    <div class="marquee__track">
      <?php for ($i = 0; $i < 2; $i++): ?>
        <span>Commercial Gyms</span><span>Hotels &amp; Resorts</span><span>Corporate Fitness</span>
        <span>Universities</span><span>Sports Facilities</span><span>Housing Societies</span>
        <span>Home Gyms</span><span>Outdoor Fitness Zones</span>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- ============ 03 SHOP BY CATEGORY ============ -->
<section class="section">
  <div class="wrap-wide">
    <?php sec_head('01', 'Shop by category',
        'Every rack,<br><span class="thin">every machine.</span>',
        'The full Avon range, grouped the way a gym floor is actually laid out.',
        '/products/', 'View all products'); ?>

    <div class="grid g-3 tiles-grid" data-stagger>
      <?php
      $tiles = [
          ['/cardio/', '01', 'Cardio Equipment', count(products_where(['family' => 'cardio'])), 'treadmills'],
          ['/strength/', '02', 'Strength Equipment', count(products_where(['family' => 'strength'])), 'multi-stations'],
          ['/home-gym/', '03', 'Home Gym', count(products_where(['segment' => 'home'])), 'home-gym-stations'],
          ['/commercial-gym/', '04', 'Commercial Gym', count(products_where(['segment' => 'commercial'])), 'fit-fighter-pro-series'],
          ['/outdoor-gym/', '05', 'Outdoor Gym', count(products_where(['family' => 'outdoor'])), 'outdoor-gym'],
          ['/accessories/', '06', 'Accessories', count(products_where(['family' => 'accessories'])), 'accessories'],
      ];
      foreach ($tiles as [$href, $num, $name, $count, $sampleSub]) {
          $sample = tile_sample($sampleSub);
          category_tile($href, $num, $name, $count, $sample);
      }
      ?>
    </div>
  </div>
</section>

<!-- ============ 04 FEATURED EQUIPMENT ============ -->
<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('02', 'Featured equipment',
        'Built for the<br><span class="thin">long run.</span>',
        'A cross-section of the range — full specifications on every product page.',
        '/products/', 'Full catalogue'); ?>
    <?php product_grid($featured, 'g-4'); ?>
  </div>
</section>

<!-- ============ 05 BUILT FOR EVERY SPACE ============ -->
<section class="section">
  <div class="wrap-wide">
    <?php sec_head('03', 'Built for every space',
        'One range,<br><span class="thin">six kinds of floor.</span>',
        'The specification changes with the duty cycle. We match equipment to how hard the floor will actually be worked.'); ?>

    <div class="grid g-3" data-stagger>
      <?php
      $spaces = [
          ['Home Gyms', 'Space-efficient cardio, benches and home gym stations sized for a room rather than a hall.', '/home-gym/'],
          ['Commercial Gyms', 'Heavy-gauge frames, higher-rated motors and selectorised stacks specified for continuous use.', '/commercial-gym/'],
          ['Corporate Fitness', 'Compact, low-maintenance mixes for office wellness rooms and campus facilities.', '/commercial-gym-solutions/#corporate'],
          ['Hotels &amp; Resorts', 'Guest-facing layouts where footprint, finish and quiet operation all matter.', '/commercial-gym-solutions/#hospitality'],
          ['Institutions', 'Universities, academies, defence and government facilities with high user turnover.', '/commercial-gym-solutions/#institutional'],
          ['Outdoor Fitness', 'Open-air units for parks, societies and campuses, fixed down on proper foundations.', '/outdoor-gym/'],
      ];
      foreach ($spaces as [$t, $d, $h]): ?>
        <a class="fcard" href="<?= e($h) ?>">
          <span class="fcard__ico" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5 12 4l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/></svg>
          </span>
          <h3><?= $t ?></h3>
          <p><?= $d ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 06 COMMERCIAL GYM SOLUTIONS ============ -->
<section class="section section--dark">
  <div class="wrap-wide">
    <?php sec_head('04', 'Commercial gym solutions',
        'From floor plan<br><span class="thin">to first session.</span>',
        'Planning, supply, installation and after-sales handled as one project rather than four separate problems.',
        '/commercial-gym-solutions/', 'Gym solutions'); ?>

    <div class="grid g-4" data-stagger>
      <?php
      $steps = [
          ['01', 'Planning', 'We work from your drawings — floor area, ceiling height, access, power — and propose a layout and equipment mix.'],
          ['02', 'Supply', 'One quotation, one order. Equipment drawn from the Avon commercial and domestic ranges to suit the brief.'],
          ['03', 'Installation', 'Delivery, assembly, positioning and commissioning on site, with the floor handed over ready to use.'],
          ['04', 'Support', 'Service, spares and maintenance after handover, backed by the manufacturer&rsquo;s technical desk.'],
      ];
      foreach ($steps as [$n, $t, $d]): ?>
        <div class="step">
          <span class="step__n"><?= $n ?></span>
          <h3><?= $t ?></h3>
          <p><?= $d ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="rule" style="margin:3rem 0 2.4rem"></div>

    <div class="grid g-3" data-stagger>
      <?php
      $segs = [
          'Corporate Gyms', 'Hotels &amp; Resorts', 'Universities &amp; Colleges',
          'Sports &amp; Training Facilities', 'Fitness Clubs &amp; Studios', 'Institutional &amp; Community Gyms',
      ];
      foreach ($segs as $s): ?>
        <div class="fcard"><h3 style="margin:0"><?= $s ?></h3></div>
      <?php endforeach; ?>
    </div>
    <p class="lead" style="margin-top:1.6rem">
      Avon equipment is built for the market segments the manufacturer supplies — fitness clubs,
      sports teams, colleges, military and workplace fitness facilities, as well as hotels, spas
      and home gyms.
    </p>
  </div>
</section>

<!-- ============ 07 WHY AVON ============ -->
<section class="section">
  <div class="wrap-wide">
    <?php sec_head('05', 'Why Avon Fitness',
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
      foreach ($why as $i => [$t, $d]): ?>
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

<!-- ============ 08 PRODUCT SHOWCASE (horizontal) ============ -->
<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('06', 'On the floor',
        'Commercial<br><span class="thin">showcase.</span>',
        'Scroll through a slice of the commercial range.',
        '/commercial-gym/', 'Commercial range'); ?>
    <div class="hscroll">
      <?php foreach ($showcase as $p) { product_card($p, false); } ?>
    </div>
  </div>
</section>

<!-- ============ 09 MAHARASHTRA COVERAGE ============ -->
<section class="section section--dark">
  <div class="wrap-wide">
    <?php sec_head('07', 'Maharashtra coverage',
        'Serving gyms<br><span class="thin">across the state.</span>',
        'We take enquiries, deliver and install across Maharashtra. Pick your city to see how we handle projects there.',
        '/gym-equipment-maharashtra/', 'Maharashtra guide'); ?>

    <div class="map-grid" data-reveal>
      <?php foreach (cities() as $city): ?>
        <a class="map-cell" href="/gym-equipment-maharashtra/#<?= e(strtolower(str_replace(' ', '-', $city))) ?>">
          <b><?= e($city) ?></b>
          <span>Supply &amp; installation</span>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="lead" style="margin-top:1.6rem">
      Coverage means delivery, installation and service — not a branch office in every city.
      Pan-India supply is available on project and bulk orders.
    </p>
  </div>
</section>

<!-- ============ 10 BLOG ============ -->
<section class="section">
  <div class="wrap-wide">
    <?php sec_head('08', 'Guides &amp; insight',
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

<!-- ============ 11 FAQ ============ -->
<section class="section section--alt">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('09', 'Questions',
        'Straight answers<br><span class="thin">before you buy.</span>'); ?>
    <?php faq_block($homeFaqs, 'home-faq'); ?>
    <p style="margin-top:1.6rem"><a class="ulink" href="/faqs/">See all frequently asked questions &rarr;</a></p>
  </div>
</section>

<!-- ============ 12 FINAL CTA ============ -->
<?php cta_band(); ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
