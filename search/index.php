<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$q = isset($_GET['q']) ? substr(strip_tags((string) $_GET['q']), 0, 90) : '';
$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Search']];

/* Server-rendered results so the page works without JavaScript and so a
   crawler landing on a search URL sees real content. */
$hits = [];
if ($q !== '') {
    $needle = mb_strtolower($q);
    foreach (products() as $p) {
        $hay = mb_strtolower($p['product_name'] . ' ' . $p['model_number'] . ' '
            . $p['subcategory'] . ' ' . $p['category'] . ' ' . $p['short_description']);
        if (str_contains($hay, $needle)) {
            $hits[] = $p;
        }
    }
    $hits = rank_products($hits);
}

$PAGE = [
    'title'       => ($q !== '' ? 'Search: ' . $q . ' — ' : '') . 'Search Gym Equipment | Avon Fitness Maharashtra',
    'description' => 'Search the Avon Fitness catalogue by product name, model number or equipment type — treadmills, spin bikes, cross trainers, multi stations, strength series, outdoor units and accessories.',
    'canonical'   => 'search/',
    'nav'         => 'products',
    'noindex'     => true,
    'crumbs'      => $crumbItems,
    'catalog_js'  => true,
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head(
    'Search Equipment',
    'Search ' . count(products()) . ' products by name, model number or equipment type.',
    'Search'
);
?>

<section class="section section--tight" data-catalog>
  <div class="wrap-wide">
    <div class="toolbar">
      <div class="field field--grow">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2.2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <label class="sr-only" for="cat-q">Search equipment</label>
        <input id="cat-q" type="search" data-catalog-q value="<?= e($q) ?>"
               placeholder="Try TM-1000, treadmill, lat pull down…" autocomplete="off" autofocus>
      </div>
      <div class="field">
        <label class="sr-only" for="cat-sub">Equipment type</label>
        <select id="cat-sub" data-catalog-sub><option value="">All equipment types</option></select>
      </div>
      <div class="field">
        <label class="sr-only" for="cat-sort">Sort by</label>
        <select id="cat-sort" data-catalog-sort>
          <option value="featured">Sort: Relevance</option>
          <option value="name">Sort: Name (A–Z)</option>
          <option value="model">Sort: Model number</option>
          <option value="spec">Sort: Most documented</option>
        </select>
      </div>
      <button class="btn btn--ghost btn--sm" type="button" data-catalog-clear>Clear</button>
    </div>

    <div class="filters" role="group" aria-label="Filter">
      <button class="fchip" type="button" data-filter="segment" data-value="commercial" aria-pressed="false">Commercial</button>
      <button class="fchip" type="button" data-filter="segment" data-value="home" aria-pressed="false">Home</button>
      <button class="fchip" type="button" data-filter="segment" data-value="outdoor" aria-pressed="false">Outdoor</button>
      <button class="fchip" type="button" data-filter="family" data-value="cardio" aria-pressed="false">Cardio</button>
      <button class="fchip" type="button" data-filter="family" data-value="strength" aria-pressed="false">Strength</button>
      <button class="fchip" type="button" data-filter="family" data-value="accessories" aria-pressed="false">Accessories</button>
    </div>

    <p class="result-count" data-catalog-count style="margin-bottom:1.2rem">
      <?php if ($q === ''): ?>
        Enter a search term to begin
      <?php else: ?>
        Showing <b><?= min(24, count($hits)) ?></b> of <b><?= count($hits) ?></b> results for &ldquo;<?= e($q) ?>&rdquo;
      <?php endif; ?>
    </p>

    <h2 class="sr-only">Search results</h2>
    <div class="grid g-4" data-catalog-grid data-stagger>
      <?php if ($q !== '' && $hits): ?>
        <?php foreach (array_slice($hits, 0, 24) as $p) { product_card($p); } ?>
      <?php elseif ($q !== ''): ?>
        <div class="empty">
          <h3>Nothing matched &ldquo;<?= e($q) ?>&rdquo;</h3>
          <p>Try a model number such as TM-1000, or an equipment type such as treadmill, spin bike or lat pull down.</p>
          <p><a class="btn btn--ghost btn--sm" href="/products/">Browse the full catalogue</a></p>
        </div>
      <?php else: ?>
        <div class="empty">
          <h3>Search the catalogue</h3>
          <p>Search across <?= count(products()) ?> products by name, model number or equipment type.</p>
        </div>
      <?php endif; ?>
    </div>

    <div class="pager" data-catalog-pager></div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('', 'Popular searches', 'Common<br><span class="thin">starting points.</span>'); ?>
    <div class="filters">
      <?php foreach (['Treadmill', 'Spin Bike', 'Cross Trainer', 'Multi Gym', 'Lat Pull Down',
                      'Chest Press', 'Leg Press', 'Dumbbell', 'Bench', 'Outdoor'] as $t): ?>
        <a class="fchip" href="/search/?q=<?= rawurlencode($t) ?>"><?= e($t) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
