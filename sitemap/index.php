<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Sitemap']];
$PAGE = [
    'title'       => 'Sitemap | Avon Fitness Maharashtra',
    'description' => 'Every section of avonfitnessmaharashtra.in — product categories, equipment types, solutions, guides and company pages.',
    'canonical'   => 'sitemap/',
    'nav'         => '',
    'crumbs'      => $crumbItems,
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Sitemap', 'Every section of the site in one place. The machine-readable version is at <a href="/sitemap.xml" style="color:#fff;text-decoration:underline">/sitemap.xml</a>.', 'Index');
$cats = categories();
?>
<section class="section">
  <div class="wrap-wide">
    <div class="grid g-3" data-stagger>

      <div class="fcard">
        <h3>Main pages</h3>
        <?php foreach ([
            ['/', 'Home'], ['/products/', 'All Products'], ['/commercial-gym/', 'Commercial Gym Equipment'],
            ['/home-gym/', 'Home Gym Equipment'], ['/outdoor-gym/', 'Outdoor Gym Equipment'],
            ['/accessories/', 'Accessories'], ['/commercial-gym-solutions/', 'Commercial Gym Solutions'],
            ['/gym-equipment-maharashtra/', 'Gym Equipment in Maharashtra'],
            ['/compare/', 'Compare Equipment'], ['/search/', 'Search'],
        ] as [$h, $t]): ?>
          <p style="margin:.3rem 0"><a class="ulink" href="<?= e($h) ?>"><?= e($t) ?></a></p>
        <?php endforeach; ?>
      </div>

      <div class="fcard">
        <h3>Company</h3>
        <?php foreach ([
            ['/about/', 'About'], ['/contact/', 'Contact'], ['/catalogue/', 'Product Catalogue'],
            ['/installation/', 'Installation'], ['/warranty/', 'Warranty'],
            ['/support/', 'Service & Support'], ['/faqs/', 'FAQs'], ['/blog/', 'Blog'],
            ['/privacy-policy/', 'Privacy Policy'], ['/terms/', 'Terms & Conditions'],
        ] as [$h, $t]): ?>
          <p style="margin:.3rem 0"><a class="ulink" href="<?= e($h) ?>"><?= e($t) ?></a></p>
        <?php endforeach; ?>
      </div>

      <div class="fcard">
        <h3>Guides</h3>
        <?php foreach (articles() as $a): ?>
          <p style="margin:.3rem 0"><a class="ulink" href="/blog/<?= e($a['slug']) ?>/"><?= e($a['title']) ?></a></p>
        <?php endforeach; ?>
      </div>
    </div>

    <?php foreach ($cats['families'] as $f):
        $base = $f['slug'] === 'outdoor' ? 'outdoor-gym' : $f['slug']; ?>
      <div style="margin-top:2.4rem">
        <h2 class="sec-title" style="font-size:var(--t-h3);margin-bottom:1rem">
          <a href="/<?= e($base) ?>/"><?= e($f['name']) ?></a>
          <span class="thin" style="font-family:var(--f-mono);font-size:.8rem">(<?= $f['count'] ?>)</span>
        </h2>
        <?php if (in_array($f['slug'], ['cardio', 'strength'], true)): ?>
          <div class="filters">
            <?php foreach ($f['subcategories'] as $s): ?>
              <a class="fchip" href="/<?= e($base) ?>/<?= e($s['slug']) ?>/"><?= e($s['name']) ?> (<?= $s['count'] ?>)</a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>

    <div class="note" style="margin-top:2.4rem">
      <strong><?= count(products()) ?> product pages</strong> are listed in
      <a href="/sitemap.xml">sitemap.xml</a>. Browse them from
      <a href="/products/">the full catalogue</a> or use <a href="/search/">search</a>.
    </div>
  </div>
</section>
<?php cta_band(); ?>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
