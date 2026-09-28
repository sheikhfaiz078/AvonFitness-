<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Compare Equipment']];

$PAGE = [
    'title'       => 'Compare Gym Equipment Specifications | Avon Fitness Maharashtra',
    'description' => 'Compare up to four Avon Fitness products side by side — model, dimensions, weight, motor rating, weight stack, frame and finish — before you request a quotation.',
    'canonical'   => 'compare/',
    'nav'         => 'products',
    'noindex'     => true,
    'crumbs'      => $crumbItems,
    'catalog_js'  => true,
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head(
    'Compare Equipment',
    'Line up to four products side by side. Every published specification is shown in one table, so you can see exactly where two models differ.',
    'Comparison'
);
?>

<section class="section section--tight" data-catalog>
  <div class="wrap-wide">
    <div data-compare-table>
      <div class="empty"><h3>Loading comparison…</h3></div>
    </div>

    <div style="margin-top:2rem;display:flex;flex-wrap:wrap;gap:.7rem">
      <a class="btn btn--ghost btn--sm" href="/products/">Add more products</a>
      <button class="btn btn--ghost btn--sm" type="button" data-cmp-clear>Clear comparison</button>
      <a class="btn btn--sm" href="/contact/">Get a quote on these</a>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('', 'How to compare', 'Reading the<br><span class="thin">specification table.</span>'); ?>
    <div class="grid g-3" data-stagger>
      <?php foreach ([
          ['Add up to four', 'Tick &ldquo;Compare&rdquo; on any product card. Your selection is remembered as you browse and appears in the bar at the bottom of the screen.'],
          ['Rows are specifications', 'Only specifications published by the manufacturer appear. A dash means that field is not published for that model — ask us and we will get it.'],
          ['Compare like with like', 'Comparing a domestic and a commercial machine on motor rating alone will mislead you. Check the rated user weight and running area together.'],
      ] as [$t, $d]): ?>
        <div class="fcard">
          <span class="fcard__ico" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 6h7M4 12h7M4 18h7M15 6h5M15 12h5M15 18h5"/></svg>
          </span>
          <h3><?= $t ?></h3>
          <p><?= $d ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php cta_band(); ?>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
