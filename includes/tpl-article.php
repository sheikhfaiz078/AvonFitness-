<?php
/** Shared blog article template. Each /blog/<slug>/index.php sets $ASLUG. */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/components.php';

$a = article($ASLUG ?? '');
if (!$a) {
    http_response_code(404);
    require AVON_ROOT . '/404.php';
    exit;
}

$all = articles();
$more = array_values(array_filter($all, static fn($x) => $x['slug'] !== $a['slug']));
$idx = array_search($a['slug'], array_column($all, 'slug'), true);
$more = array_slice(array_merge(array_slice($more, (int) $idx), $more), 0, 3);

$crumbItems = [
    ['name' => 'Home', 'url' => '/'],
    ['name' => 'Blog', 'url' => '/blog/'],
    ['name' => $a['title']],
];

$schema = [
    '@type'            => 'Article',
    '@id'              => url('blog/' . $a['slug'] . '/') . '#article',
    'headline'         => $a['title'],
    'description'      => $a['excerpt'],
    'datePublished'    => $a['date'],
    'dateModified'     => $a['date'],
    'inLanguage'       => 'en-IN',
    'articleSection'   => $a['category'],
    'keywords'         => $a['keywords'],
    'image'            => url('assets/images/brand/og-image.jpg'),
    'author'           => ['@id' => url('#organisation')],
    'publisher'        => ['@id' => url('#organisation')],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url('blog/' . $a['slug'] . '/')],
];

$PAGE = [
    'title'       => $a['title'] . ' | Avon Fitness Maharashtra',
    'description' => $a['excerpt'],
    'canonical'   => 'blog/' . $a['slug'] . '/',
    'og_type'     => 'article',
    'nav'         => 'blog',
    'crumbs'      => $crumbItems,
    'schema'      => array_filter([$schema, $a['faqs'] ? faq_schema($a['faqs']) : null]),
];
require __DIR__ . '/header.php';
crumbs($crumbItems);
?>

<section class="phead">
  <div class="wrap phead__inner">
    <span class="eyebrow is-in"><?= e($a['category']) ?> &middot; <?= e($a['read']) ?></span>
    <h1><?= e($a['title']) ?></h1>
    <p><?= e($a['excerpt']) ?></p>
    <p style="margin-top:1rem;font-family:var(--f-mono);font-size:.74rem;letter-spacing:.1em;color:#8A8A8A">
      Published <time datetime="<?= e($a['date']) ?>"><?= e(date('j F Y', strtotime($a['date']))) ?></time>
    </p>
  </div>
</section>

<section class="section">
  <div class="wrap-wide">
    <div class="split split--side">

      <article class="prose" data-reveal>
        <?php foreach ($a['body'] as $b):
            if ($b['t'] === 'h2'): ?>
              <h2><?= e($b['v']) ?></h2>
            <?php elseif ($b['t'] === 'p'): ?>
              <p><?= $b['v'] ?></p>
            <?php elseif ($b['t'] === 'ul'): ?>
              <ul><?php foreach ($b['v'] as $li): ?><li><?= $li ?></li><?php endforeach; ?></ul>
            <?php elseif ($b['t'] === 'note'): ?>
              <div class="note"><?= $b['v'] ?></div>
            <?php endif;
        endforeach; ?>

        <?php if (!empty($a['faqs'])): ?>
          <h2>Frequently asked questions</h2>
          <?php faq_block($a['faqs'], 'art-faq'); ?>
        <?php endif; ?>
      </article>

      <aside data-reveal="right">
        <div class="fcard">
          <h3>Get a quote</h3>
          <p>Tell us the space and what you need. We will come back with an equipment list and a
             quotation for Maharashtra delivery and installation.</p>
          <div style="display:grid;gap:.6rem;margin-top:1rem">
            <a class="btn btn--sm btn--block" href="/contact/">Get a Quote</a>
            <a class="btn btn--wa btn--sm btn--block" href="<?= e(wa()) ?>" rel="noopener nofollow" target="_blank">WhatsApp</a>
          </div>
        </div>

        <div class="fcard" style="margin-top:1rem">
          <h3>Browse equipment</h3>
          <div class="filters" style="margin:0">
            <a class="fchip" href="/cardio/treadmills/">Treadmills</a>
            <a class="fchip" href="/cardio/">Cardio</a>
            <a class="fchip" href="/strength/">Strength</a>
            <a class="fchip" href="/strength/multi-stations/">Multi stations</a>
            <a class="fchip" href="/commercial-gym/">Commercial</a>
            <a class="fchip" href="/home-gym/">Home gym</a>
            <a class="fchip" href="/outdoor-gym/">Outdoor</a>
          </div>
        </div>

        <div class="fcard" style="margin-top:1rem">
          <h3>More guides</h3>
          <?php foreach ($more as $m): ?>
            <p style="margin-bottom:.7rem">
              <a class="ulink" href="/blog/<?= e($m['slug']) ?>/"><?= e($m['title']) ?></a>
            </p>
          <?php endforeach; ?>
          <p style="margin:0"><a class="ulink" href="/blog/">All articles &rarr;</a></p>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('', 'Keep reading', 'More<br><span class="thin">guides.</span>', '', '/blog/', 'All articles'); ?>
    <div class="grid g-3" data-stagger>
      <?php foreach ($more as $m): ?>
        <a class="blog-card" href="/blog/<?= e($m['slug']) ?>/">
          <span class="blog-card__top"><?= e($m['category']) ?> &middot; <?= e($m['read']) ?></span>
          <span class="blog-card__body">
            <h3><?= e($m['title']) ?></h3>
            <p><?= e($m['excerpt']) ?></p>
            <span class="card__go">Read guide
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php cta_band(); ?>
<?php require __DIR__ . '/footer.php'; ?>
