<?php
/**
 * Shared listing template for the catalogue, family, subcategory and segment
 * pages. The first page of results is rendered server-side so the page is
 * indexable and useful without JavaScript; catalog.js then takes over for
 * filtering, sorting and paging.
 *
 * The including page sets $LIST = [
 *   'h1','intro','eyebrow','canonical','title','description',
 *   'scope'   => ['family'=>..,'sub'=>..,'segment'=>..]   (any subset)
 *   'crumbs'  => [...]
 *   'nav'     => nav key
 *   'tiles'   => optional [[href,num,name,count,sampleSub], ...]
 *   'body'    => optional HTML shown above the grid
 *   'faqs'    => optional [['q'=>..,'a'=>..]]
 *   'related' => optional [[href,label], ...] internal links
 * ];
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/components.php';

$scope = $LIST['scope'] ?? [];
$items = products_where($scope);
$items = rank_products($items);
$total = count($items);
$first = array_slice($items, 0, 24);

$PAGE = [
    'title'       => $LIST['title'],
    'description' => $LIST['description'],
    'canonical'   => $LIST['canonical'],
    'nav'         => $LIST['nav'] ?? 'products',
    'crumbs'      => $LIST['crumbs'] ?? [],
    'catalog_js'  => true,
    'schema'      => [],
];

/* CollectionPage + ItemList for the products actually shown */
$elements = [];
foreach ($first as $i => $p) {
    $elements[] = [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'url'      => url('product/' . $p['slug'] . '/'),
        'name'     => $p['product_name'],
    ];
}
$PAGE['schema'][] = [
    '@type'       => 'CollectionPage',
    '@id'         => url($LIST['canonical']) . '#collection',
    'name'        => $LIST['h1'],
    'description' => $LIST['description'],
    'url'         => url($LIST['canonical']),
    'isPartOf'    => ['@id' => url('#website')],
    'mainEntity'  => [
        '@type'           => 'ItemList',
        'numberOfItems'   => $total,
        'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
        'itemListElement' => $elements,
    ],
];
if (!empty($LIST['faqs'])) {
    $PAGE['schema'][] = faq_schema($LIST['faqs']);
}

require __DIR__ . '/header.php';
if (!empty($LIST['crumbs'])) {
    crumbs($LIST['crumbs']);
}
page_head($LIST['h1'], $LIST['intro'] ?? '', $LIST['eyebrow'] ?? '');
?>

<?php if (!empty($LIST['tiles'])): ?>
<section class="section section--tight">
  <div class="wrap-wide">
    <div class="grid g-4 tiles-grid" data-stagger>
      <?php foreach ($LIST['tiles'] as [$href, $num, $name, $count, $sampleSub]):
          $sample = tile_sample($sampleSub);
          category_tile($href, $num, $name, $count, $sample);
      endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section section--tight" data-catalog
         data-family="<?= e($scope['family'] ?? '') ?>"
         data-sub="<?= e($scope['sub'] ?? '') ?>"
         data-segment="<?= e($scope['segment'] ?? '') ?>">
  <div class="wrap-wide">

    <div class="toolbar">
      <div class="field field--grow">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#777" stroke-width="2.2" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <label class="sr-only" for="cat-q">Search within these products</label>
        <input id="cat-q" type="search" data-catalog-q placeholder="Search by name or model number…" autocomplete="off">
      </div>
      <?php if (empty($scope['sub'])): ?>
      <div class="field">
        <label class="sr-only" for="cat-sub">Equipment type</label>
        <select id="cat-sub" data-catalog-sub><option value="">All equipment types</option></select>
      </div>
      <?php endif; ?>
      <div class="field">
        <label class="sr-only" for="cat-sort">Sort by</label>
        <select id="cat-sort" data-catalog-sort>
          <option value="featured">Sort: Featured</option>
          <option value="name">Sort: Name (A–Z)</option>
          <option value="model">Sort: Model number</option>
          <option value="spec">Sort: Most documented</option>
        </select>
      </div>
      <button class="btn btn--ghost btn--sm" type="button" data-catalog-clear>Clear filters</button>
    </div>

    <?php if (empty($scope['segment'])): ?>
    <div class="filters" role="group" aria-label="Filter by space">
      <button class="fchip" type="button" data-filter="segment" data-value="commercial" aria-pressed="false">Commercial</button>
      <button class="fchip" type="button" data-filter="segment" data-value="home" aria-pressed="false">Home</button>
      <button class="fchip" type="button" data-filter="segment" data-value="outdoor" aria-pressed="false">Outdoor</button>
      <?php if (empty($scope['family'])): ?>
        <button class="fchip" type="button" data-filter="family" data-value="cardio" aria-pressed="false">Cardio</button>
        <button class="fchip" type="button" data-filter="family" data-value="strength" aria-pressed="false">Strength</button>
        <button class="fchip" type="button" data-filter="family" data-value="accessories" aria-pressed="false">Accessories</button>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <p class="result-count" data-catalog-count style="margin-bottom:1.2rem">
      Showing <b>1&ndash;<?= count($first) ?></b> of <b><?= $total ?></b> products
    </p>

    <h2 class="sr-only">Products in this category</h2>
    <div class="grid g-4" data-catalog-grid data-stagger>
      <?php foreach ($first as $p) { product_card($p); } ?>
    </div>

    <div class="pager" data-catalog-pager>
      <?php if ($total > 24): ?>
        <noscript><p class="form__note">Showing the first 24 of <?= $total ?> products. Enable JavaScript to page through the full range, or <a href="/contact/">ask us for the catalogue</a>.</p></noscript>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php if (!empty($LIST['body'])): ?>
<section class="section section--alt">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><?= $LIST['body'] ?></div>
    <?php if (!empty($LIST['related'])): ?>
      <div class="rule" style="margin:2.4rem 0 1.6rem"></div>
      <p class="eyebrow">Explore further</p>
      <div class="filters">
        <?php foreach ($LIST['related'] as [$href, $label]): ?>
          <a class="fchip" href="<?= e($href) ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<?php if (!empty($LIST['faqs'])): ?>
<section class="section">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('', 'Questions', 'What buyers<br><span class="thin">usually ask.</span>'); ?>
    <?php faq_block($LIST['faqs'], 'cat-faq'); ?>
  </div>
</section>
<?php endif; ?>

<?php cta_band(); ?>
<?php require __DIR__ . '/footer.php'; ?>
