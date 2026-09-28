<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'FAQs']];

$faqs = [['q' => 'What equipment do I need to start a gym?', 'a' => 'A workable commercial floor needs three blocks: cardio, selectorised strength covering the main movement patterns, and a free-weight area with benches, racks, dumbbells and plates. Quantities follow from floor area and expected peak users. Our <a href="/blog/gym-equipment-checklist-new-gym-owners/">equipment checklist</a> lists it out.'], ['q' => 'What is the difference between commercial and home gym equipment?', 'a' => 'Commercial equipment is specified for continuous duty — heavier frames, higher-rated continuous motors, larger running surfaces and higher rated user weights. Home equipment is sized for a domestic footprint and lighter use. If a machine runs more than about four hours a day, or is used unsupervised by many people, specify commercial.'], ['q' => 'How much does gym equipment cost?', 'a' => 'It depends on floor area, duty cycle and the split between selectorised, plate-loaded and free-weight equipment. Because all three vary on every project, we quote per project rather than publishing a price list. Send your city, area and expected footfall for a costed list.'], ['q' => 'Do you deliver across Maharashtra?', 'a' => 'Yes — Mumbai, Thane, Navi Mumbai, Pune, Nashik, Nagpur, Chhatrapati Sambhajinagar, Kolhapur, Solapur and the rest of the state, with pan-India supply on project and bulk orders.'], ['q' => 'Is installation included?', 'a' => 'Delivery, assembly, positioning and commissioning are quoted with the equipment on commercial projects, and available on domestic orders. See our <a href="/installation/">installation page</a>.'], ['q' => 'Which treadmill is right for a commercial gym?', 'a' => 'Read the continuous motor rating (not peak), the running area and the rated maximum user weight together. Avon commercial treadmills run from around 4 HP to 5.5 HP continuous, with running areas from about 1540 x 600 mm and ratings up to 240 kg on larger models.'], ['q' => 'How do I plan a gym floor?', 'a' => 'Zone the floor, plan circulation first, then place equipment with proper clearances. As a planning figure, total area usually runs 40&ndash;50% above the sum of equipment footprints. Send us drawings and we will mark up a layout.'], ['q' => 'What gym equipment suits a hotel?', 'a' => 'Compact footprint, quiet operation, guided equipment and good finish quality. A small set of well-chosen machines beats a crowded room. See <a href="/blog/gym-equipment-hotels-resorts/">hotel gym equipment</a>.'], ['q' => 'What equipment suits an institution or university?', 'a' => 'High user turnover and a wide range of abilities mean durability and serviceability dominate. Selectorised stations with clear instruction are safer for inexperienced users.'], ['q' => 'Do you supply outdoor gym equipment?', 'a' => 'Yes, for parks, housing societies, campuses and municipal fitness zones — including the foundation components needed to fix units down properly. See the <a href="/outdoor-gym/">outdoor range</a>.'], ['q' => 'Can I see full specifications before ordering?', 'a' => 'Each product page lists the specifications published in the official Avon catalogue. Where a field is not published, send an enquiry and we will get the specification sheet from the manufacturer.'], ['q' => 'Do you handle bulk and tender orders?', 'a' => 'Yes. Send the tender documents or the requirement schedule and we will respond against it.']];

$PAGE = [
    'title'       => 'Gym Equipment FAQs | Avon Fitness Maharashtra',
    'description' => 'Answers on choosing, costing, installing and maintaining gym equipment in Maharashtra — commercial vs home specification, gym setup, delivery, installation, warranty and service.',
    'canonical'   => 'faqs/',
    'nav'         => 'faqs',
    'crumbs'      => $crumbItems,
    'schema'      => [faq_schema($faqs)],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Frequently Asked Questions', 'Straight answers on specifying, buying, installing and running gym equipment.', 'Answers');
?>
<section class="section">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><h2>Can&rsquo;t find your answer?</h2><p>Call us, send a WhatsApp message or <a href="/contact/">start an enquiry</a>. For questions about a specific machine, the product pages carry model-specific answers alongside the published specifications.</p><p>Working through a bigger decision? Our <a href="/blog/">guides</a> go deeper on choosing equipment, planning a floor and maintaining what you install.</p></div>
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
