<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$faqs = [
    ['q' => 'What is included in a commercial gym solution?',
     'a' => 'Space and layout planning from your drawings, equipment selection and specification, supply, delivery, installation, commissioning and after-sales support — quoted as one project rather than as separate line items you have to co-ordinate yourself.'],
    ['q' => 'Do I need a floor plan before contacting you?',
     'a' => 'It helps enormously, but it is not essential. Dimensioned drawings are ideal; a sketch with measurements, or even photographs plus room dimensions, is enough for us to start. What we do need is ceiling height and the access route — those two constrain the equipment list more than anything else.'],
    ['q' => 'How long does a commercial gym fit-out take?',
     'a' => 'The equipment side is usually a matter of days once the site is ready. The timeline is almost always driven by site readiness — flooring laid and cured, electrical work complete, and clear access for delivery.'],
    ['q' => 'Can you phase a project across budgets?',
     'a' => 'Yes, and for new operators it is often the sensible route: equip the core floor first, then add stations as membership grows. We will plan the layout for the final state so the phased additions drop into space already allowed for.'],
    ['q' => 'Do you handle institutional and government tenders?',
     'a' => 'Yes. Send us the tender documents and specification schedule and we will respond against them.'],
    ['q' => 'What happens after installation?',
     'a' => 'You get service and spares support, backed by the manufacturer&rsquo;s technical desk. We recommend an annual maintenance routine from day one — our <a href="/blog/gym-equipment-maintenance-guide/">maintenance guide</a> sets out a realistic schedule.'],
];

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Commercial Gym Solutions']];

$PAGE = [
    'title'       => 'Commercial Gym Solutions & Setup in Maharashtra | Avon Fitness',
    'description' => 'Turnkey commercial gym solutions across Maharashtra — gym planning, space and layout design, equipment selection, supply, delivery, installation, commissioning and after-sales support for clubs, hotels, corporates and institutions.',
    'canonical'   => 'commercial-gym-solutions/',
    'nav'         => 'solutions',
    'crumbs'      => $crumbItems,
    'schema'      => [
        faq_schema($faqs),
        ['@type' => 'Service', '@id' => url('commercial-gym-solutions/') . '#service',
         'name' => 'Commercial Gym Setup and Equipment Supply',
         'serviceType' => 'Gym planning, equipment supply and installation',
         'provider' => ['@id' => url('#organisation')],
         'areaServed' => [['@type' => 'State', 'name' => 'Maharashtra'],
                          ['@type' => 'Country', 'name' => 'India']],
         'description' => 'Gym planning, space and layout planning, equipment selection and supply, '
                        . 'delivery, installation, commissioning and after-sales support.',
         'url' => url('commercial-gym-solutions/')],
    ],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head(
    'Commercial Gym Solutions',
    'Turnkey fit-outs for spaces that cannot afford downtime. From layout planning to commissioning, handled as one project.',
    'Gym planning &amp; setup'
);
?>

<section class="section">
  <div class="wrap-wide">
    <?php sec_head('01', 'How it works', 'Nine steps<br><span class="thin">from drawing to handover.</span>',
        'Most gym projects go wrong in the gaps between suppliers. We close the gaps by owning the whole sequence.'); ?>

    <div class="grid g-3" data-stagger>
      <?php foreach ([
          ['Gym planning', 'We start from what you are trying to run — member numbers, opening hours, training style — and turn that into an equipment brief.'],
          ['Space planning', 'Floor area, ceiling height, columns, ventilation and the access route. These constrain the list more than the budget does.'],
          ['Equipment selection', 'The right duty cycle for each machine, and the right split between selectorised, plate-loaded and free weights.'],
          ['Layout planning', 'Zoning, circulation, clearances and sightlines, marked up on your drawing before anything is ordered.'],
          ['Equipment supply', 'One schedule, one order, drawn from the Avon commercial and domestic ranges.'],
          ['Delivery', 'Scheduled against site readiness, with access checked in advance so nothing arrives that cannot get in.'],
          ['Installation', 'Assembly and positioning on site by a team that has done it before.'],
          ['Commissioning', 'Every machine tested, levelled and handed over working — not boxed in a corner.'],
          ['After-sales support', 'Service, spares and maintenance, backed by the manufacturer&rsquo;s technical desk.'],
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

<section class="section section--dark">
  <div class="wrap-wide">
    <?php sec_head('02', 'Sectors', 'Different floors,<br><span class="thin">different specifications.</span>',
        'A hotel fitness room and a 24-hour club are not the same brief. These are the constraints that actually change the equipment list.'); ?>

    <div class="grid g-2" data-stagger>
      <?php foreach ([
          ['corporate', 'Corporate Gyms',
           'Almost nothing for most of the day, then everything at once before work, at lunch and after work. Specify for peak throughput and near-zero maintenance overhead, because there is rarely dedicated gym staff. Selectorised stations win here — changing weight takes two seconds, not two minutes.'],
          ['hospitality', 'Hotels &amp; Resorts',
           'Unsupervised, used by guests of unknown training background, usually above or below a guest room. Footprint, finish quality and quiet operation outrank raw capability. Guided equipment and working emergency stops matter more than variety.'],
          ['institutional', 'Universities &amp; Institutions',
           'High user turnover, wide range of abilities and long opening hours. Durability and serviceability dominate; equipment needs to survive heavy use by people still learning to train.'],
          ['defence', 'Defence &amp; Government',
           'Specification-driven procurement against a published schedule. We respond to tender documents directly and quote against the stated requirement.'],
          ['clubs', 'Fitness Clubs &amp; Studios',
           'The commercial case. Equipment must carry a paying membership through peak hours with minimal downtime, because downtime costs renewals.'],
          ['sports', 'Sports &amp; Training Facilities',
           'Strength-led floors with heavier loading and more plate-loaded and free-weight provision than a general fitness gym needs.'],
      ] as [$id, $t, $d]): ?>
        <div class="fcard" id="<?= $id ?>" style="scroll-margin-top:110px">
          <span class="fcard__ico" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
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
    <div class="split">
      <div data-reveal="left">
        <?php sec_head('03', 'Planning', 'What we need<br><span class="thin">from you.</span>'); ?>
        <div class="prose">
          <ul>
            <li>A dimensioned floor plan, or room dimensions plus photographs</li>
            <li>Ceiling height — this decides whether functional trainers and lat towers fit</li>
            <li>The access route: door width, staircase turn, lift dimensions and capacity</li>
            <li>Expected peak concurrent users, and your opening hours</li>
            <li>Whether the floor is supervised, and by whom</li>
            <li>An indicative budget range, and whether you want it phased</li>
          </ul>
          <p>With those six things we can produce a layout and a costed equipment schedule without a
             round of follow-up questions.</p>
          <p><a href="/blog/how-to-plan-commercial-gym-floor/">How we plan a commercial gym floor &rarr;</a></p>
        </div>
      </div>

      <div data-reveal="right">
        <?php sec_head('04', 'Specification', 'What you get<br><span class="thin">back.</span>'); ?>
        <div class="prose">
          <ul>
            <li>A marked-up layout showing zoning, circulation and clearances</li>
            <li>An equipment schedule with model numbers and published specifications</li>
            <li>Footprints and net and gross weights for access and floor-loading checks</li>
            <li>A single quotation covering supply, delivery, installation and commissioning</li>
            <li>Electrical requirements for the cardio bank, marked on the drawing</li>
            <li>A phasing proposal where the budget calls for one</li>
          </ul>
          <p><a href="/contact/">Send us your drawings &rarr;</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section section--alt">
  <div class="wrap-wide">
    <?php sec_head('05', 'The range', 'What goes<br><span class="thin">on the floor.</span>', '',
        '/products/', 'Full catalogue'); ?>
    <div class="grid g-4 tiles-grid" data-stagger>
      <?php
      foreach ([['/cardio/', '01', 'Cardio Equipment', 'treadmills'],
                ['/strength/multi-stations/', '02', 'Multi Stations', 'multi-stations'],
                ['/strength/', '03', 'Strength Equipment', 'fit-fighter-pro-series'],
                ['/accessories/', '04', 'Accessories', 'accessories']] as [$h, $n, $nm, $s]) {
          $sample = tile_sample($s);
          category_tile($h, $n, $nm, count(products_where(['sub' => $s])), $sample);
      }
      ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('06', 'Questions', 'About gym<br><span class="thin">projects.</span>'); ?>
    <?php faq_block($faqs, 'sol-faq'); ?>
  </div>
</section>

<?php cta_band(
    'Talk to our projects team.',
    'Send a floor plan, a tender schedule or a rough brief. We will come back with a layout, an equipment list and one quotation.',
    'Start a Project'
); ?>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
