<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Service & Support']];

$faqs = [['q' => 'How do I order spare parts?', 'a' => 'Send us the model number, serial number and a description or photograph of the part. Spare parts for Avon equipment are also handled by the manufacturer&rsquo;s spare-parts desk, listed on our contact page.'], ['q' => 'Do you offer annual maintenance contracts?', 'a' => 'Talk to us about your floor and usage. For commercial sites we would generally recommend a scheduled routine rather than reactive call-outs, because downtime costs more than servicing.'], ['q' => 'My treadmill is noisy — what should I check first?', 'a' => 'Belt tension and tracking, deck lubrication, and dust in the motor compartment. Those three account for most treadmill noise complaints. If it persists, send us a short video.'], ['q' => 'Can you service equipment you did not supply?', 'a' => 'Get in touch with the model details and we will tell you what we can do.']];

$PAGE = [
    'title'       => 'Gym Equipment Service & Spare Parts | Avon Fitness Maharashtra',
    'description' => 'Service, maintenance and spare parts for Avon Fitness gym equipment in Maharashtra, backed by the manufacturer&rsquo;s technical and spare-parts desk.',
    'canonical'   => 'support/',
    'nav'         => 'about',
    'crumbs'      => $crumbItems,
    'schema'      => [faq_schema($faqs)],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Service & Support', 'Equipment downtime costs memberships. Here is how to get a machine back on the floor.', 'After-sales');
?>
<section class="section">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><h2>Raising a service request</h2><p>Send us four things and we can usually identify the part before anyone travels:</p><ul><li>The <strong>model number</strong> (on the frame, and on your invoice)</li><li>The <strong>serial number</strong></li><li>A clear <strong>description of the fault</strong> — what happens, and when</li><li>A <strong>photograph or short video</strong> of the fault</li></ul><p>WhatsApp is the fastest route for photographs and video.</p><h2>Manufacturer support desks</h2><p>Technical support and spare parts for Avon Fitness equipment are also handled directly by the manufacturer. Those desks are published on our <a href="/contact/">contact page</a> alongside our own details.</p><h2>Preventive maintenance</h2><p>Most emergency call-outs are preventable. The three faults worth designing out are treadmill deck wear from running a dry deck, cable failure on selectorised stations, and dust in motor compartments. All three are caught by a routine that takes minutes.</p><p>Our <a href="/blog/gym-equipment-maintenance-guide/">maintenance guide</a> sets out a daily, weekly, monthly and annual schedule you can hand straight to floor staff.</p><h2>Keep a spares float</h2><p>For a commercial floor, hold a small stock of the things that stop a machine being usable but take minutes to replace: treadmill safety keys, weight-stack pins, collars and a spare set of cables for your highest-use stations.</p></div>
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
