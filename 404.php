<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/components.php';

if (!headers_sent()) {
    http_response_code(404);
}

$picks = array_slice(rank_products(products_where(['segment' => 'commercial'])), 0, 4);

$PAGE = [
    'title'       => 'Page Not Found | Avon Fitness Maharashtra',
    'description' => 'That page could not be found. Browse gym equipment, search by model number, or contact Avon Fitness Maharashtra.',
    'canonical'   => '404',
    'nav'         => '',
    'noindex'     => true,
];
require __DIR__ . '/includes/header.php';
?>

<section class="hero" style="padding-block:clamp(3rem,7vw,6rem)">
  <div class="hero__bg" aria-hidden="true">
    <span class="hero__grid"></span>
    <span class="hero__glow"></span>
  </div>
  <div class="wrap-wide" style="position:relative;text-align:center">
    <span class="eyebrow is-in" style="justify-content:center">Error 404</span>
    <h1 class="hero__title" style="font-size:clamp(2.4rem,6vw,5rem);margin-inline:auto;max-width:16ch">
      <span class="ln"><span>Looks like this rep</span></span>
      <span class="ln"><span class="accent">went off track.</span></span>
    </h1>
    <p class="hero__copy" style="margin-inline:auto">
      The page you were after has moved, been renamed, or never existed. The equipment is all still
      here — try one of these instead.
    </p>
    <div class="hero__cta" style="justify-content:center">
      <a class="btn" href="/products/">Back to Equipment
        <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </a>
      <a class="btn btn--light" href="/contact/">Contact Us</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap-wide">
    <?php sec_head('', 'Try these', 'Where you<br><span class="thin">probably wanted to go.</span>'); ?>
    <div class="grid g-4" data-stagger>
      <?php foreach ([
          ['/products/', 'Full Catalogue', 'All ' . count(products()) . ' products with specifications'],
          ['/commercial-gym/', 'Commercial Gym', 'Equipment for paying gym floors'],
          ['/home-gym/', 'Home Gym', 'Cardio and strength for a domestic space'],
          ['/commercial-gym-solutions/', 'Gym Solutions', 'Planning, supply and installation'],
      ] as [$h, $t, $d]): ?>
        <a class="fcard" href="<?= e($h) ?>">
          <span class="fcard__ico" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
          </span>
          <h3><?= $t ?></h3>
          <p><?= $d ?></p>
        </a>
      <?php endforeach; ?>
    </div>

    <div style="margin-top:2.4rem">
      <p class="eyebrow">Or search the catalogue</p>
      <form role="search" action="/search/" method="get" class="toolbar" style="margin-top:.8rem">
        <div class="field field--grow">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2.2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
          <label class="sr-only" for="nf-q">Search equipment</label>
          <input id="nf-q" name="q" type="search" placeholder="Try TM-1000 or treadmill…">
        </div>
        <button class="btn btn--sm" type="submit">Search</button>
      </form>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('', 'Popular equipment', 'Start<br><span class="thin">here.</span>', '', '/products/', 'View all'); ?>
    <?php product_grid($picks, 'g-4'); ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
