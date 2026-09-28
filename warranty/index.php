<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Warranty']];

$faqs = [['q' => 'What is the warranty period on Avon gym equipment?', 'a' => 'It varies by product line and by the terms agreed on your order, so we confirm it in writing on your quotation rather than publishing one figure. Ask us for the terms on any model before ordering.'], ['q' => 'Who do I contact for a warranty claim?', 'a' => 'Contact us with the model and serial number and a description of the fault. Technical support and spare parts for Avon equipment are also handled directly by the manufacturer&rsquo;s service desk.'], ['q' => 'Does a maintenance log matter for warranty?', 'a' => 'Yes. Routine maintenance is normally a condition of warranty on gym equipment, and a log turns a disputed claim into a straightforward parts order.']];

$PAGE = [
    'title'       => 'Gym Equipment Warranty | Avon Fitness Maharashtra',
    'description' => 'How warranty works on Avon Fitness gym equipment — what to keep, how to raise a claim, and the manufacturer service desk for technical support and spare parts.',
    'canonical'   => 'warranty/',
    'nav'         => 'about',
    'crumbs'      => $crumbItems,
    'schema'      => [faq_schema($faqs)],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Warranty', 'What to keep, who to contact, and how a warranty claim is handled.', 'Support');
?>
<section class="section">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><h2>Warranty terms are confirmed on your order</h2><p>Warranty period and coverage vary by product line and by the terms agreed on your specific order, so we confirm them in writing on your quotation and invoice rather than publishing a single blanket figure that would be wrong for some models.</p><p>Ask us for the warranty terms on any model before you order, and we will put them in writing with the quotation.</p><h2>What to keep</h2><ul><li>Your invoice and the delivery note</li><li>The model number and serial number of each machine</li><li>The installation and commissioning record</li><li>Your maintenance log — a warranty claim on a machine that has never been serviced is a much harder conversation</li></ul><h2>Raising a claim</h2><p>Contact us with the model number, the serial number, the date of installation and a description of the fault. Photographs or a short video of the fault usually speed things up considerably, because they let the technical desk identify the part before anyone travels.</p><h2>What warranty typically does not cover</h2><p>As with any equipment warranty, damage from misuse, unauthorised modification, failure to carry out routine maintenance, or use outside the machine&rsquo;s rated specification is generally excluded. Consumable and wear items — cables, upholstery, belts — are treated separately from structural components. Exact terms are as stated on your order.</p><h2>Keeping equipment in warranty</h2><p>Follow a routine maintenance schedule and keep a log. Our <a href="/blog/gym-equipment-maintenance-guide/">maintenance guide</a> sets out a realistic daily, weekly, monthly and annual routine, and most preventable faults are on that list.</p></div>
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
