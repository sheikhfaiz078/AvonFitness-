<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$arts = articles();
$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Blog']];

$elements = [];
foreach ($arts as $i => $a) {
    $elements[] = ['@type' => 'ListItem', 'position' => $i + 1,
                   'url' => url('blog/' . $a['slug'] . '/'), 'name' => $a['title']];
}

$PAGE = [
    'title'       => 'Gym Equipment Guides & Buying Advice | Avon Fitness Maharashtra',
    'description' => 'Practical guides on choosing, planning, installing and maintaining gym equipment — commercial gym setup, treadmill buying, home gym planning, maintenance schedules and cost drivers.',
    'canonical'   => 'blog/',
    'nav'         => 'blog',
    'crumbs'      => $crumbItems,
    'schema'      => [[
        '@type'      => 'CollectionPage',
        '@id'        => url('blog/') . '#collection',
        'name'       => 'Avon Fitness Maharashtra — Guides',
        'url'        => url('blog/'),
        'isPartOf'   => ['@id' => url('#website')],
        'mainEntity' => ['@type' => 'ItemList', 'numberOfItems' => count($arts),
                         'itemListElement' => $elements],
    ]],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head(
    'Guides & Insight',
    'Practical advice on specifying, planning and maintaining gym equipment — written for people actually placing the order.',
    'Blog'
);

$byCat = [];
foreach ($arts as $a) {
    $byCat[$a['category']][] = $a;
}
?>

<section class="section">
  <div class="wrap-wide">
    <div class="filters" style="margin-bottom:2rem">
      <?php foreach (array_keys($byCat) as $c): ?>
        <a class="fchip" href="#cat-<?= e(strtolower(str_replace(' ', '-', $c))) ?>"><?= e($c) ?> (<?= count($byCat[$c]) ?>)</a>
      <?php endforeach; ?>
    </div>

    <div class="grid g-3" data-stagger>
      <?php foreach ($arts as $a): ?>
        <a class="blog-card" href="/blog/<?= e($a['slug']) ?>/">
          <span class="blog-card__top"><?= e($a['category']) ?> &middot; <?= e($a['read']) ?></span>
          <span class="blog-card__body">
            <h2 style="font-size:1.1rem;text-transform:uppercase;line-height:1.22;margin-bottom:.6rem"><?= e($a['title']) ?></h2>
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

<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('', 'By topic', 'Browse by<br><span class="thin">subject.</span>'); ?>
    <?php foreach ($byCat as $c => $list): ?>
      <div id="cat-<?= e(strtolower(str_replace(' ', '-', $c))) ?>" style="scroll-margin-top:110px;margin-bottom:2rem">
        <h3 style="font-family:var(--f-mono);font-size:.74rem;letter-spacing:.16em;text-transform:uppercase;color:var(--red);margin-bottom:.9rem"><?= e($c) ?></h3>
        <ul class="prose" style="max-width:none">
          <?php foreach ($list as $a): ?>
            <li style="padding-left:1.5rem;position:relative">
              <a class="ulink" href="/blog/<?= e($a['slug']) ?>/"><?= e($a['title']) ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php cta_band(); ?>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
