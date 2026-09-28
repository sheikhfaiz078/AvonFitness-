<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Terms & Conditions']];

$PAGE = [
    'title'       => 'Terms & Conditions | Avon Fitness Maharashtra',
    'description' => 'Terms of use for avonfitnessmaharashtra.in, covering website content, product information, quotations, orders and intellectual property.',
    'canonical'   => 'terms/',
    'nav'         => '',
    'crumbs'      => $crumbItems,
    'schema'      => [],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head('Terms & Conditions', 'The terms on which this website and the information on it are provided.', 'Legal');
?>
<section class="section">
  <div class="wrap-wide">
    <div class="prose" style="max-width:74ch"><p><strong>Last updated:</strong> September 2026</p><h2>1. About these terms</h2><p>By using avonfitnessmaharashtra.in you accept these terms. If you do not accept them, please do not use the site.</p><h2>2. Product information</h2><p>Specifications published on this site are taken from the official Avon Fitness product catalogues. Manufacturers improve products, and specifications, dimensions, weights, finishes and console features may change without notice. Photographs are representative; finishes and detailing may vary by production batch.</p><p><strong>Confirm any critical dimension with us in writing before you rely on it</strong> — particularly when planning a floor layout or checking an access route.</p><h2>3. Availability</h2><p>Listing a product on this site is not a guarantee that it is currently available. Availability is confirmed at the time of quotation.</p><h2>4. Prices and quotations</h2><p>We do not publish prices on this site. Prices are given by written quotation and depend on configuration, quantity, site and installation scope. A quotation is valid for the period stated on it, and an order is accepted when we confirm it in writing.</p><h2>5. Warranty</h2><p>Warranty terms vary by product line and are confirmed in writing on your quotation and invoice. See our <a href="/warranty/">warranty page</a>.</p><h2>6. Guides and advice</h2><p>The guidance in our <a href="/blog/">articles</a> and on category pages is general information to help you specify equipment. It is not a substitute for professional advice on structural loading, electrical installation, fire safety or medical fitness. Take professional advice where the decision calls for it.</p><h2>7. Intellectual property</h2><p>The Avon Fitness name and logo belong to their owner. Website design, layout, written content and code on this site are the property of the site operator. You may not copy or reproduce them without permission.</p><h2>8. Acceptable use</h2><p>Do not use this site or its enquiry form for unlawful purposes, to send automated or bulk submissions, or to attempt to gain unauthorised access to the server.</p><h2>9. Liability</h2><p>We take care to keep this site accurate, but we do not warrant that it is error-free or continuously available. To the extent permitted by law, we are not liable for indirect or consequential loss arising from use of the site. Nothing here limits liability that cannot be limited by law.</p><h2>10. Governing law</h2><p>These terms are governed by the laws of India, and the courts of Maharashtra have jurisdiction over any dispute arising from them.</p><h2>11. Contact</h2><p>Questions about these terms: see our <a href="/contact/">contact page</a>.</p></div>
  </div>
</section>
<?php cta_band(); ?>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
