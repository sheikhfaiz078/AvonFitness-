<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Installation']];

$faqs = [['q' => 'Is installation included in the price?', 'a' => 'On commercial projects, installation and commissioning are quoted together with the equipment as one order. On domestic orders it is available — confirm it when you enquire.'], ['q' => 'How long does installation take?', 'a' => 'For a typical commercial floor it is a matter of days once the site is ready. Site readiness — flooring, electrical work and access — drives the timeline more than the equipment does.'], ['q' => 'Do you install equipment bought elsewhere?', 'a' => 'Get in touch with the details. We will tell you honestly whether we can help.'], ['q' => 'What if a machine will not fit up the stairs?', 'a' => 'This is why we check access before ordering. Where a route is tight, we can often specify a model that can be carried in sections, or propose an alternative that fits.']];

$PAGE = [
    'title'       => 'Gym Equipment Installation in Maharashtra | Avon Fitness',
    'description' => 'Delivery, assembly, positioning and commissioning of gym equipment across Maharashtra — what we need from your site, how the day runs, and what is handed over.',
    'canonical'   => 'installation/',
    'nav'         => 'solutions',
    'crumbs'      => $crumbItems,
    'schema'      => [faq_schema($faqs)],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Installation & Commissioning', 'The floor handed over working — not boxed in a corner.', 'Service');
?>
<section class="section">
  <div class="wrap-wide">
    <?php sec_head('', 'What we do', 'On the<br><span class="thin">installation day.</span>', 'Installation is quoted with the equipment on commercial projects and available on domestic orders.'); ?>
    <div class="grid g-3" data-stagger>
      <div class="fcard"><span class="fcard__ico" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m5 13 4 4L19 7"/></svg></span><h3>Delivery</h3><p>Scheduled against site readiness, with the access route checked in advance so nothing arrives that cannot get in.</p></div>
      <div class="fcard"><span class="fcard__ico" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m5 13 4 4L19 7"/></svg></span><h3>Assembly</h3><p>Machines built on site by a team that has built them before, to the manufacturer&rsquo;s sequence.</p></div>
      <div class="fcard"><span class="fcard__ico" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m5 13 4 4L19 7"/></svg></span><h3>Positioning</h3><p>Placed to the agreed layout, with clearances and circulation as drawn, not as they end up.</p></div>
      <div class="fcard"><span class="fcard__ico" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m5 13 4 4L19 7"/></svg></span><h3>Levelling</h3><p>Every machine levelled on the actual floor. Skipping this is the main cause of early wear and noise complaints.</p></div>
      <div class="fcard"><span class="fcard__ico" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m5 13 4 4L19 7"/></svg></span><h3>Commissioning</h3><p>Powered up, function-tested and run under load before handover.</p></div>
      <div class="fcard"><span class="fcard__ico" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m5 13 4 4L19 7"/></svg></span><h3>Handover</h3><p>A walk-through of controls, safety features and the maintenance routine with whoever will run the floor.</p></div>
    </div>
  </div>
</section><section class="section">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><h2>What we need from your site</h2><ul><li><strong>Flooring complete.</strong> Laid and cured. Equipment should not be moved onto a floor that is still curing.</li><li><strong>Electrical work complete.</strong> Sockets in the agreed positions and the supply sized for the cardio bank.</li><li><strong>Clear access.</strong> Lift booked where relevant, corridors clear, and someone on site who can authorise final positions.</li><li><strong>Somewhere to unpack.</strong> Packaging from a full commercial order is substantial and needs a staging area and a disposal plan.</li></ul><h2>Access is the thing that delays deliveries</h2><p>Commercial treadmills can exceed 2200 mm assembled and 250 kg gross. Selectorised stations with a full stack can exceed 250 kg in a single footprint. We check assembled dimensions and gross weights against your lift, staircase and doorway before the order is placed — but we need those measurements from you.</p><p>Every product page publishes the footprint and net and gross weight where the manufacturer lists them, so you can check in advance.</p><h2>Outdoor installations</h2><p>Outdoor gym units need concrete foundations, sized for each unit and cured before use. We supply the foundation components with the equipment; the site provides level, drained ground and access. See <a href="/outdoor-gym/">outdoor gym equipment</a>.</p></div>
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
