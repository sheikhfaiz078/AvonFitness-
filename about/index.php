<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$total = count(products());
$subs  = array_sum(array_map(static fn($f) => count($f['subcategories']), categories()['families']));

$faqs = [
    ['q' => 'Who manufactures Avon Fitness equipment?',
     'a' => 'Avon Fitness equipment is manufactured by ' . $CFG['ADDRESS_LINE1'] . ', based in Ludhiana, Punjab. Avon Fitness Maharashtra supplies, installs and services that equipment across Maharashtra.'],
    ['q' => 'How long has the Avon name been manufacturing in India?',
     'a' => 'The manufacturer states that Avon has been a trusted name in India for over 75 years. The group began in bicycle component manufacturing and grew into one of the country&rsquo;s established bicycle brands before extending into fitness equipment.'],
    ['q' => 'Is Avon Fitness equipment made in India?',
     'a' => 'Yes. Equipment is designed and produced in India, which is what keeps spares availability, service response and lead times predictable for customers here.'],
    ['q' => 'What does Avon Fitness Maharashtra actually do?',
     'a' => 'We supply Avon Fitness equipment across Maharashtra and handle the parts that make a gym work: planning the layout, specifying the equipment mix, delivering, installing and commissioning it, and supporting it afterwards.'],
    ['q' => 'Do you supply outside Maharashtra?',
     'a' => 'Maharashtra is our primary service area. We handle pan-India supply on project and bulk orders.'],
];

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'About']];

$PAGE = [
    'title'       => 'About Avon Fitness Maharashtra | Gym Equipment Supplier',
    'description' => 'Avon Fitness Maharashtra supplies, installs and services Avon gym equipment across the state. Avon Fitness equipment is manufactured in India by Avon Fitness Machines Pvt. Ltd., part of a group with over 75 years of Indian manufacturing.',
    'canonical'   => 'about/',
    'nav'         => 'about',
    'crumbs'      => $crumbItems,
    'schema'      => [
        faq_schema($faqs),
        ['@type' => 'AboutPage', '@id' => url('about/') . '#aboutpage',
         'name' => 'About Avon Fitness Maharashtra', 'url' => url('about/'),
         'isPartOf' => ['@id' => url('#website')], 'about' => ['@id' => url('#organisation')]],
    ],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head(
    'Built on the factory floor',
    'Avon Fitness Maharashtra supplies, installs and supports Avon gym equipment across the state — from a single home treadmill to a complete commercial fit-out.',
    'About'
);
?>

<section class="section">
  <div class="wrap-wide">
    <div class="split">
      <div data-reveal="left">
        <?php sec_head('01', 'The brand', 'A manufacturing<br><span class="thin">name, not a reseller badge.</span>'); ?>
        <div class="prose">
          <p>Avon Fitness equipment is manufactured by <strong><?= e($CFG['ADDRESS_LINE1']) ?></strong>
             in Ludhiana, Punjab. The manufacturer describes Avon as a name that has been trusted in India
             for over 75 years — a business that began in bicycle component manufacturing, grew into one of
             the country&rsquo;s established bicycle brands, and later extended that manufacturing capability
             into fitness equipment.</p>
          <p>That history matters for a practical reason rather than a sentimental one. Equipment designed
             and built in India means the spares chain is short, the service response is local, and lead
             times do not depend on a shipping schedule. When a machine on your floor stops working, that is
             the difference between a week and a quarter.</p>
          <p>Our role is the Maharashtra end of that: specifying the right equipment for your space,
             getting it delivered and installed properly, and supporting it afterwards.</p>
        </div>
      </div>

      <div data-reveal="right">
        <?php sec_head('02', 'What we do', 'Equipment is a<br><span class="thin">long relationship.</span>'); ?>
        <div class="prose">
          <p>Most of what goes wrong with a gym fit-out is not the equipment. It is a machine that will not
             fit up the stairs, a layout that leaves no room to load a plate, an electrical supply sized for
             half the cardio bank, or a station that nobody can service because it was pushed into a corner.</p>
          <p>So we work from your drawings before we quote. You get one equipment schedule, one layout and
             one quotation covering supply, delivery, installation and commissioning — rather than a price
             list you have to turn into a project yourself.</p>
          <p>If the brief and the budget do not meet, we would rather say so at drawing stage and propose a
             phased build than deliver a floor that is thin in every category.</p>
          <p><a href="/commercial-gym-solutions/">See how a commercial project runs &rarr;</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section--dark">
  <div class="wrap-wide">
    <?php sec_head('03', 'The range', 'One supplier,<br><span class="thin">every part of the floor.</span>',
        'Cardio, strength, outdoor and accessories from a single manufacturer — which means one order, one delivery and one service relationship instead of four.'); ?>
    <?php stats_row([
        ['count' => 75, 'suffix' => '+', 'label' => 'Years of the Avon name'],
        ['count' => $total, 'suffix' => '+', 'label' => 'Products in the catalogue'],
        ['count' => $subs, 'label' => 'Equipment categories'],
        ['value' => 'MH', 'label' => 'Delivery &amp; installation'],
    ]); ?>
    <p class="form__note" style="margin-top:1rem;color:#8A8A8A">
      Figures reflect the Avon Fitness product catalogue published by the manufacturer and the categories
      listed on this site. We do not publish installation counts or customer numbers we cannot evidence.
    </p>
  </div>
</section>

<section class="section">
  <div class="wrap-wide">
    <?php sec_head('04', 'How we work', 'Four things we<br><span class="thin">hold ourselves to.</span>'); ?>
    <div class="grid g-4" data-stagger>
      <?php foreach ([
          ['Specify honestly', 'If a domestic machine will do the job, we will say so. Selling commercial duty into a home is as much a mistake as the reverse.'],
          ['Plan before quoting', 'We work from floor plans, access measurements and expected usage — not from a wish list of machine names.'],
          ['Install properly', 'Delivery, assembly, positioning and commissioning, with the floor handed over ready to use rather than boxed in a corner.'],
          ['Answer afterwards', 'Service, spares and maintenance after handover, backed by the manufacturer&rsquo;s technical desk.'],
      ] as $i => [$t, $d]): ?>
        <div class="step">
          <span class="step__n"><?= sprintf('%02d', $i + 1) ?></span>
          <h3><?= $t ?></h3>
          <p><?= $d ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('05', 'Product philosophy', 'What &ldquo;commercial&rdquo;<br><span class="thin">actually means here.</span>'); ?>
    <div class="grid g-3" data-stagger>
      <?php foreach ([
          ['Frame and materials', 'Commercial strength stations use high-tensile steel tube with a two-round powder-coated finish — specifications published per model on each product page.'],
          ['Drive systems', 'Domestic cardio uses DC and BLDC drives for quiet, compact operation. Commercial cardio uses AC drives rated for continuous duty.'],
          ['Rated loading', 'Maximum user weight is the most honest single indicator of build. Commercial models in the range run from 180 kg to 240 kg depending on model.'],
          ['Serviceable parts', 'Cables, upholstery and guards are replaceable items. Equipment is built to be maintained rather than replaced.'],
          ['Documented dimensions', 'Published footprints and net and gross weights, so a floor can be planned and an access route checked before an order is placed.'],
          ['Range coverage', 'Selectorised, plate-loaded, free weight, cardio, outdoor and accessories — so one supplier covers the whole floor.'],
      ] as [$t, $d]): ?>
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

<section class="section">
  <div class="wrap-wide">
    <?php sec_head('06', 'Who we supply', 'The spaces this<br><span class="thin">equipment is built for.</span>',
        'The manufacturer supplies fitness clubs, sports teams, colleges, military and workplace fitness facilities, as well as hotels, spas and home gyms. We serve those segments across Maharashtra.'); ?>
    <div class="grid g-3" data-stagger>
      <?php foreach ([
          ['Commercial gyms &amp; fitness clubs', '/commercial-gym/'],
          ['Hotels &amp; resorts', '/commercial-gym-solutions/#hospitality'],
          ['Corporate fitness centres', '/commercial-gym-solutions/#corporate'],
          ['Universities &amp; institutions', '/commercial-gym-solutions/#institutional'],
          ['Housing societies &amp; communities', '/outdoor-gym/'],
          ['Home gyms', '/home-gym/'],
      ] as [$t, $h]): ?>
        <a class="fcard" href="<?= e($h) ?>"><h3 style="margin:0"><?= $t ?></h3></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('07', 'Questions', 'About Avon<br><span class="thin">Fitness.</span>'); ?>
    <?php faq_block($faqs, 'about-faq'); ?>
  </div>
</section>

<?php cta_band(); ?>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
