<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Privacy Policy']];

$PAGE = [
    'title'       => 'Privacy Policy | Avon Fitness Maharashtra',
    'description' => 'How Avon Fitness Maharashtra collects, uses and protects the information you submit through this website.',
    'canonical'   => 'privacy-policy/',
    'nav'         => '',
    'crumbs'      => $crumbItems,
    'schema'      => [],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Privacy Policy', 'What we collect, why we collect it, and what we do not do with it.', 'Legal');
?>
<section class="section">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><p><strong>Last updated:</strong> September 2026</p><h2>Who we are</h2><p>This website, avonfitnessmaharashtra.in, supplies and installs Avon Fitness gym equipment across Maharashtra. Contact details are on our <a href="/contact/">contact page</a>.</p><h2>What we collect</h2><p>We collect only what you choose to send us through the enquiry form: your name, phone number, email address, city, requirement type, product of interest, indicative budget and your message. Our server also records the page the enquiry came from, the time it was sent and the submitting IP address, which we use to prevent automated spam.</p><h2>Why we collect it</h2><p>To answer your enquiry, prepare a quotation, and arrange delivery, installation or service. That is the only purpose.</p><h2>What we do not do</h2><ul><li>We do not sell or rent your details to anyone</li><li>We do not add you to a marketing list without you asking</li><li>We do not use advertising or tracking cookies on this site</li><li>We do not collect payment card details through this website</li></ul><h2>Cookies and storage</h2><p>This site sets a standard PHP session cookie when you submit the enquiry form, used only to rate-limit repeat submissions. If you use the product comparison feature, your selection is stored in your own browser (local storage) and is never sent to us.</p><h2>Sharing</h2><p>Where answering your enquiry requires it — for example a technical question or a spare part — we may pass relevant details to the manufacturer, Avon Fitness Machines Pvt. Ltd. Enquiry emails are handled by our web hosting provider&rsquo;s mail service.</p><h2>Retention</h2><p>Enquiries are kept for as long as needed to serve the customer relationship and to meet our record-keeping obligations. Ask us and we will delete your enquiry.</p><h2>Your choices</h2><p>You can ask us what we hold about you, ask for it to be corrected, or ask for it to be deleted. Email us using the address on the <a href="/contact/">contact page</a>.</p><h2>External links</h2><p>Some pages link to WhatsApp and to the manufacturer&rsquo;s website. Those services have their own privacy policies, which we do not control.</p><h2>Changes</h2><p>If this policy changes we will update the date at the top of this page.</p></div>
  </div>
</section>
<?php cta_band(); ?>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
