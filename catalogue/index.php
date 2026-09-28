<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Catalogue']];

$faqs = [['q' => 'Is the online catalogue the complete range?', 'a' => 'It covers the products published on the manufacturer&rsquo;s current category listings. If you are looking for a model you have seen elsewhere and cannot find it here, send us the model number and we will confirm availability.'], ['q' => 'Are specifications on the site the official ones?', 'a' => 'Yes. Published specifications are taken from the official Avon Fitness catalogues. Where a field is not shown for a model, it was not published for that model — ask and we will get it.'], ['q' => 'Do the catalogues include prices?', 'a' => 'We quote per project rather than from a list price, because cost depends on configuration, quantity, site and installation scope.']];

$PAGE = [
    'title'       => 'Avon Fitness Product Catalogue | Commercial & Domestic Ranges',
    'description' => 'Request the official Avon Fitness commercial and domestic equipment catalogues, or browse the full range online with published specifications for every model.',
    'canonical'   => 'catalogue/',
    'nav'         => 'products',
    'crumbs'      => $crumbItems,
    'schema'      => [faq_schema($faqs)],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Product Catalogue', 'Browse the full range online, or ask us for the official commercial and domestic catalogues.', 'Catalogue');
?>
<section class="section">
  <div class="wrap-wide">
    <div class="grid g-2" data-stagger>
      <div class="fcard">
        <h3>Commercial Catalogue</h3>
        <p>The full commercial range — cardio, selectorised and plate-loaded strength series, multi stations, dumbbells, plates and other equipment, with published specifications.</p>
        <div style="display:grid;gap:.6rem;margin-top:1.1rem">
          <a class="btn btn--sm btn--block" href="/contact/?product=Commercial%20Catalogue">Request the Commercial Catalogue</a>
          <a class="btn btn--ghost btn--sm btn--block" href="/commercial-gym/">Browse commercial range online</a>
        </div>
      </div>
      <div class="fcard">
        <h3>Domestic Catalogue</h3>
        <p>The home range — folding treadmills, cross trainers, upright and recumbent bikes, orbitracs, air bikes, massagers, home gym stations, benches and stands.</p>
        <div style="display:grid;gap:.6rem;margin-top:1.1rem">
          <a class="btn btn--sm btn--block" href="/contact/?product=Domestic%20Catalogue">Request the Domestic Catalogue</a>
          <a class="btn btn--ghost btn--sm btn--block" href="/home-gym/">Browse home range online</a>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><h2>Everything is already online</h2><p>The whole catalogue is published on this site with the manufacturer&rsquo;s specifications attached to each model: motor ratings, running areas, incline ranges, weight stacks, frame tube specification, finishes, footprints and net and gross weights.</p><p>Start with <a href="/products/">the full catalogue</a>, or go straight to <a href="/cardio/">cardio</a>, <a href="/strength/">strength</a>, <a href="/outdoor-gym/">outdoor</a> or <a href="/accessories/">accessories</a>. You can also <a href="/compare/">compare up to four models side by side</a>.</p><h2>Need a printed or PDF copy?</h2><p>Ask and we will send the current commercial or domestic catalogue directly. For a project, we would usually send a tailored equipment schedule instead — it is more useful than a full catalogue when you already know the space.</p></div>
  </div>
</section>
<section class="section section--alt">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('', 'Questions', 'Common<br><span class="thin">questions.</span>'); ?>
    <?php faq_block($faqs, 'pg-faq'); ?>
  </div>
</section>
<?php cta_band(); ?>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
