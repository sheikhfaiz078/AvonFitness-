<?php
/**
 * Shared product detail template.
 * Each /product/<slug>/index.php sets $SLUG and includes this file.
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/components.php';

$p = product($SLUG ?? '');
if (!$p) {
    http_response_code(404);
    require AVON_ROOT . '/404.php';
    exit;
}

$familyPath = match ($p['family']) {
    'cardio'   => '/cardio/',
    'strength' => '/strength/',
    'outdoor'  => '/outdoor-gym/',
    default    => '/accessories/',
};
$subPath = in_array($p['family'], ['cardio', 'strength'], true)
    ? $familyPath . $p['subcategory_slug'] . '/'
    : $familyPath;

$related = [];
foreach ($p['related_products'] as $slug) {
    if ($r = product($slug)) {
        $related[] = $r;
    }
}

$segmentLabel = match ($p['segment']) {
    'commercial' => 'Commercial use',
    'home'       => 'Home use',
    'outdoor'    => 'Outdoor installation',
    default      => 'Commercial &amp; home use',
};

$crumbItems = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Products', 'url' => '/products/'],
    ['name' => $p['category'], 'url' => $familyPath],
    ['name' => $p['subcategory'], 'url' => $subPath],
    ['name' => $p['product_name']],
];

/* ---- Product schema. No price/availability/rating: none is published. ---- */
$productSchema = [
    '@type'       => 'Product',
    '@id'         => url('product/' . $p['slug'] . '/#product'),
    'name'        => $p['product_name'],
    'description' => $p['short_description'],
    'image'       => url($p['image']),
    'category'    => $p['category'] . ' > ' . $p['subcategory'],
    'brand'       => ['@type' => 'Brand', 'name' => 'Avon Fitness'],
    'manufacturer' => ['@type' => 'Organization', 'name' => $CFG['ADDRESS_LINE1']],
    'url'         => url('product/' . $p['slug'] . '/'),
];
if ($p['model_number']) {
    $productSchema['model'] = $p['model_number'];
    $productSchema['sku']   = $p['model_number'];
}
if (!empty($p['specifications'])) {
    $props = [];
    foreach ($p['specifications'] as $k => $v) {
        $props[] = ['@type' => 'PropertyValue', 'name' => $k, 'value' => $v];
    }
    $productSchema['additionalProperty'] = $props;
}
if (!empty($p['weight'])) {
    $productSchema['weight'] = ['@type' => 'QuantitativeValue', 'name' => $p['weight']];
}

$PAGE = [
    'title'       => $p['seo_title'],
    'description' => $p['seo_description'],
    'canonical'   => 'product/' . $p['slug'] . '/',
    'og_type'     => 'product',
    'og_image'    => $p['image'],
    'nav'         => 'products',
    'crumbs'      => $crumbItems,
    'body_attr'   => 'data-product="' . e($p['model_number'] ?: $p['product_name']) . '"',
    'schema'      => [$productSchema, faq_schema($p['faqs'])],
];
require __DIR__ . '/header.php';
crumbs($crumbItems);

$waText = 'Hello Avon Fitness, I would like a quote for the '
        . $p['product_name'] . ($p['model_number'] ? ' (' . $p['model_number'] . ')' : '')
        . '. My city is: ';
?>

<!-- ============ PRODUCT HERO ============ -->
<section class="section section--tight">
  <div class="wrap-wide pdp">

    <div data-reveal="left">
      <div class="gallery__main">
        <img src="/<?= e($p['image']) ?>" alt="<?= e($p['image_alt']) ?>"
             width="700" height="700" fetchpriority="high" decoding="async">
      </div>
      <p class="form__note" style="margin-top:.6rem">Click the image to zoom. Product photography is
         representative — finishes and console details may vary by production batch.</p>
    </div>

    <div data-reveal="right">
      <?php if ($p['model_number']): ?>
        <p class="pdp__model">Model <?= e($p['model_number']) ?></p>
      <?php endif; ?>
      <h1><?= e($p['product_name']) ?></h1>

      <div class="pdp__chips">
        <span class="chip chip--red"><?= e($p['subcategory']) ?></span>
        <span class="chip"><?= e($p['category']) ?></span>
        <span class="chip"><?= $segmentLabel ?></span>
        <?php if (!empty($p['specifications'])): ?>
          <span class="chip"><?= count($p['specifications']) ?> published specifications</span>
        <?php endif; ?>
      </div>

      <p class="lead"><?= e($p['short_description']) ?></p>

      <div class="pdp__cta">
        <a class="btn" href="/contact/?product=<?= rawurlencode($p['model_number'] ?: $p['product_name']) ?>">
          Request a Quote
          <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </a>
        <a class="btn btn--wa" href="<?= e(wa($waText)) ?>" rel="noopener nofollow" target="_blank">Enquire on WhatsApp</a>
        <a class="btn btn--ghost" href="/catalogue/">Download Catalogue</a>
      </div>

      <ul class="pdp__assure">
        <?php foreach ([
            'Delivery, installation and commissioning across Maharashtra',
            'Pan-India supply on project and bulk orders',
            'Service and spares backed by the manufacturer&rsquo;s technical desk',
            'Quotation within one business day on most enquiries',
        ] as $a): ?>
          <li>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="m5 13 4 4L19 7"/></svg>
            <span><?= $a ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============ OVERVIEW + SPECS ============ -->
<section class="section section--alt section--tight">
  <div class="wrap-wide">
    <div class="split split--a">

      <div data-reveal>
        <h2 class="sec-title" style="font-size:var(--t-h3);margin-bottom:1.2rem">Overview</h2>
        <div class="prose">
          <?php foreach ($p['full_description'] as $para): ?>
            <p><?= $para ?></p>
          <?php endforeach; ?>
        </div>

        <h2 class="sec-title" style="font-size:var(--t-h3);margin:2.4rem 0 1.2rem">Key Features</h2>
        <div class="grid g-2 g-2--keep" data-stagger>
          <?php foreach ($p['features'] as $f): ?>
            <div class="fcard">
              <span class="fcard__ico" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="m5 13 4 4L19 7"/></svg>
              </span>
              <h3><?= e($f['title']) ?></h3>
              <p><?= e($f['text']) ?></p>
            </div>
          <?php endforeach; ?>
        </div>

        <h2 class="sec-title" style="font-size:var(--t-h3);margin:2.4rem 0 1.2rem">Where This Equipment Is Used</h2>
        <div class="prose">
          <ul>
            <?php foreach ($p['applications'] as $a): ?><li><?= e($a) ?></li><?php endforeach; ?>
          </ul>
          <p>Not sure whether this is the right specification for your space?
             <a href="/contact/">Tell us the floor area and expected usage</a> and we will confirm
             whether this model or another in the <a href="<?= e($subPath) ?>"><?= e(strtolower($p['subcategory'])) ?></a>
             range is the better fit.</p>
        </div>
      </div>

      <div data-reveal="right">
        <h2 class="sec-title" style="font-size:var(--t-h3);margin-bottom:1.2rem">Technical Specifications</h2>
        <?php if (!empty($p['specifications'])): ?>
          <table class="spec-table">
            <caption class="sr-only">Technical specifications for <?= e($p['product_name']) ?></caption>
            <tbody>
              <?php if ($p['model_number']): ?>
                <tr><th scope="row">Model</th><td><?= e($p['model_number']) ?></td></tr>
              <?php endif; ?>
              <tr><th scope="row">Category</th><td><?= e($p['subcategory']) ?></td></tr>
              <?php foreach ($p['specifications'] as $k => $v): ?>
                <tr><th scope="row"><?= e($k) ?></th><td><?= e($v) ?></td></tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <p class="form__note" style="margin-top:.8rem">Specifications as published in the official
             Avon Fitness product catalogue. Confirm critical dimensions with us before finalising
             a floor layout.</p>
        <?php else: ?>
          <table class="spec-table">
            <tbody>
              <?php if ($p['model_number']): ?>
                <tr><th scope="row">Model</th><td><?= e($p['model_number']) ?></td></tr>
              <?php endif; ?>
              <tr><th scope="row">Category</th><td><?= e($p['subcategory']) ?></td></tr>
              <tr><th scope="row">Range</th><td><?= e($p['category']) ?></td></tr>
              <tr><th scope="row">Built for</th><td><?= $segmentLabel ?></td></tr>
            </tbody>
          </table>
          <div class="note" style="margin-top:1rem">
            <strong>Detailed specifications on request.</strong> Dimensions, weights and material
            details for this item are not published in the current catalogue extract. Send us an
            enquiry and we will share the full specification sheet from the manufacturer.
          </div>
        <?php endif; ?>

        <div style="margin-top:1.4rem">
          <a class="btn btn--block" href="/contact/?product=<?= rawurlencode($p['model_number'] ?: $p['product_name']) ?>">Get Full Specifications</a>
        </div>

        <div class="note" style="margin-top:1.2rem">
          <strong>Planning a gym?</strong> Talk to our equipment specialist about the whole floor
          rather than one machine — <a href="/commercial-gym-solutions/">see how our gym projects work</a>.
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ RELATED ============ -->
<?php if ($related): ?>
<section class="section">
  <div class="wrap-wide">
    <?php sec_head('', 'Related equipment',
        'Others in<br><span class="thin">' . e(strtolower($p['subcategory'])) . '.</span>',
        '', $subPath, 'View all ' . strtolower($p['subcategory'])); ?>
    <?php product_grid(array_slice($related, 0, 4), 'g-4'); ?>
  </div>
</section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section section--alt">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('', 'Questions', 'About the<br><span class="thin">' . e($p['model_number'] ?: $p['product_name']) . '.</span>'); ?>
    <?php faq_block($p['faqs'], 'pdp-faq'); ?>
  </div>
</section>

<!-- ============ CTA ============ -->
<?php cta_band(
    'Planning a gym?',
    'Talk to our equipment specialist. Send a floor plan or a requirement list and we will come back with a layout, an equipment schedule and one quotation.',
    'Get a Quote'
); ?>

<?php require __DIR__ . '/footer.php'; ?>
