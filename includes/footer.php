<?php
/** Large premium footer + floating actions + mobile bottom bar + scripts. */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/components.php';

/*
 * Footer social row. WhatsApp always appears (the number is configured and is
 * our main enquiry channel); the rest render only when a URL is set in
 * config/site.php, so an unconfigured profile never shows a dead icon.
 *
 * These are brand glyphs, so they are filled paths rather than stroked icons.
 */
$social = ['WhatsApp' => wa()] + array_filter([
    'Facebook'  => $CFG['SOCIAL_FACEBOOK'],
    'Instagram' => $CFG['SOCIAL_INSTAGRAM'],
    'YouTube'   => $CFG['SOCIAL_YOUTUBE'],
    'LinkedIn'  => $CFG['SOCIAL_LINKEDIN'],
]);
$icons = [
    'WhatsApp'  => 'M12.04 2A9.9 9.9 0 0 0 2.15 11.9a9.8 9.8 0 0 0 1.32 4.94L2 22l5.3-1.39a9.9 9.9 0 0 0 4.74 1.21h.01a9.9 9.9 0 0 0 9.9-9.9A9.9 9.9 0 0 0 12.04 2m5.8 14.06c-.24.69-1.42 1.32-1.96 1.4-.5.08-1.14.11-1.83-.11-.42-.14-.97-.32-1.66-.62-2.93-1.26-4.84-4.2-4.99-4.4-.14-.2-1.19-1.58-1.19-3.02s.76-2.14 1.03-2.44c.27-.29.58-.37.78-.37h.56c.18 0 .42-.07.66.5.24.59.83 2.02.9 2.17.08.14.13.31.03.5-.1.2-.15.32-.29.49l-.44.51c-.15.14-.3.3-.13.6.17.29.76 1.25 1.63 2.03 1.12 1 2.06 1.3 2.36 1.45.29.15.46.12.63-.07.17-.2.73-.85.92-1.14.2-.29.39-.24.66-.15.27.1 1.7.8 1.99.95.29.14.48.22.55.34.07.12.07.7-.17 1.38',
    'Facebook'  => 'M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.52 1.49-3.91 3.77-3.91 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.78-1.63 1.57v1.89h2.78l-.45 2.91h-2.33V22c4.78-.76 8.44-4.92 8.44-9.94',
    'Instagram' => 'M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41-.56-.22-.96-.48-1.38-.9-.42-.42-.68-.82-.9-1.38-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.3-1.46.72-2.13 1.38A5.9 5.9 0 0 0 .63 4.14c-.3.76-.5 1.64-.56 2.91C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.3.79.72 1.46 1.38 2.13a5.9 5.9 0 0 0 2.13 1.38c.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.9 5.9 0 0 0 2.13-1.38 5.9 5.9 0 0 0 1.38-2.13c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.9 5.9 0 0 0-1.38-2.13A5.9 5.9 0 0 0 19.86.63c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0m0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32m0 10.16a4 4 0 1 1 0-8 4 4 0 0 1 0 8m7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0',
    'YouTube'   => 'M23.5 6.5a3 3 0 0 0-2.1-2.1C19.5 3.9 12 3.9 12 3.9s-7.5 0-9.4.5A3 3 0 0 0 .5 6.5C0 8.4 0 12 0 12s0 3.6.5 5.5a3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1c.5-1.9.5-5.5.5-5.5s0-3.6-.5-5.5M9.6 15.6V8.4l6.2 3.6z',
    'LinkedIn'  => 'M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05a3.74 3.74 0 0 1 3.37-1.85c3.6 0 4.27 2.37 4.27 5.46zM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13M7.12 20.45H3.56V9h3.56zM22.22 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.72V1.72C24 .77 23.2 0 22.22 0',
];
?>
</main>

<!-- ---------------- final CTA is rendered by pages, footer starts here --- -->
<footer class="ftr">
  <div class="wrap-wide">
    <div class="ftr__grid">

      <div class="ftr__brand">
        <img src="/assets/images/brand/avon-fitness-logo-footer.webp" width="300" height="142"
             alt="Avon Fitness" loading="lazy">
        <p>We supply, install and support Avon Fitness commercial and home gym equipment across
           Maharashtra — cardio machines, selectorised and plate-loaded strength, multi stations,
           outdoor fitness units and the accessories that keep a floor running.</p>
        <p style="margin-top:.9rem"><a class="ulink" href="/about/">More about Avon Fitness</a></p>
        <?php if ($social): ?>
        <div class="ftr__social">
          <?php foreach ($social as $name => $href): ?>
            <a class="ftr__social-<?= e(strtolower($name)) ?>" href="<?= e($href) ?>"
               rel="noopener nofollow" target="_blank"
               aria-label="<?= $name === 'WhatsApp' ? 'Message Avon Fitness Maharashtra on WhatsApp' : 'Avon Fitness Maharashtra on ' . e($name) ?>">
              <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                   focusable="false"><path d="<?= e($icons[$name]) ?>"/></svg>
            </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="ftr__col">
        <h3>Products</h3>
        <a href="/cardio/treadmills/">Treadmills</a>
        <a href="/cardio/spin-bikes/">Spin Bikes</a>
        <a href="/cardio/cross-trainers/">Cross Trainers</a>
        <a href="/cardio/upright-bikes/">Upright Bikes</a>
        <a href="/strength/home-gym-stations/">Home Gyms</a>
        <a href="/strength/multi-stations/">Multi Stations</a>
        <a href="/strength/multi-gyms/">Multi Gyms</a>
        <a href="/strength/dumbbells/">Dumbbells</a>
        <a href="/strength/plates/">Weight Plates</a>
        <a href="/outdoor-gym/">Outdoor Gym</a>
        <a href="/accessories/">Accessories</a>
      </div>

      <div class="ftr__col">
        <h3>Solutions</h3>
        <a href="/commercial-gym/">Commercial Gyms</a>
        <a href="/home-gym/">Home Gyms</a>
        <a href="/commercial-gym-solutions/#institutional">Institutional Gyms</a>
        <a href="/commercial-gym-solutions/#hospitality">Hotel Gyms</a>
        <a href="/commercial-gym-solutions/#corporate">Corporate Fitness</a>
        <a href="/outdoor-gym/">Outdoor Fitness</a>
        <a href="/commercial-gym-solutions/">Gym Planning &amp; Setup</a>
        <a href="/compare/">Compare Equipment</a>
      </div>

      <div class="ftr__col">
        <h3>Company</h3>
        <a href="/about/">About Avon Fitness</a>
        <a href="/contact/">Contact</a>
        <a href="/catalogue/">Product Catalogue</a>
        <a href="/warranty/">Warranty</a>
        <a href="/installation/">Installation</a>
        <a href="/support/">Service &amp; Support</a>
        <a href="/blog/">Blog</a>
        <a href="/faqs/">FAQs</a>
      </div>

      <div class="ftr__col ftr__contact">
        <h3>Contact</h3>
        <ul>
          <li><a href="tel:<?= e($CFG['CONTACT_PHONE_RAW']) ?>"><?= e($CFG['CONTACT_PHONE']) ?></a></li>
          <li><a href="<?= e(wa()) ?>" rel="noopener nofollow" target="_blank">WhatsApp enquiry</a></li>
          <li><a href="mailto:<?= e($CFG['CONTACT_EMAIL']) ?>"><?= e($CFG['CONTACT_EMAIL']) ?></a></li>
        </ul>
        <h3 style="margin-top:1.5rem">Registered Office</h3>
        <address style="font-style:normal;font-size:.85rem;line-height:1.75">
          <?= e($CFG['ADDRESS_LINE1']) ?><br>
          <?= e($CFG['ADDRESS_LINE2']) ?><br>
          <?= e($CFG['ADDRESS_CITY']) ?>, <?= e($CFG['ADDRESS_STATE']) ?> <?= e($CFG['ADDRESS_PIN']) ?><br>
          <?= e($CFG['ADDRESS_COUNTRY']) ?>
        </address>
      </div>
    </div>

    <div class="ftr__grid" style="grid-template-columns:1fr;padding-bottom:2rem">
      <div>
        <h3>Serving Maharashtra</h3>
        <p class="ftr__locs">
          We take enquiries and deliver across
          <?php $c = cities(); $n = count($c); foreach ($c as $i => $city): ?>
            <a class="ulink" href="/gym-equipment-maharashtra/#<?= e(strtolower(str_replace(' ', '-', $city))) ?>"><?= e($city) ?></a><?= $i < $n - 2 ? ', ' : ($i === $n - 2 ? ' and ' : '') ?>
          <?php endforeach; ?>,
          plus pan-India supply on project orders.
          <a class="ulink" href="/gym-equipment-maharashtra/">Gym equipment in Maharashtra &rarr;</a>
        </p>
      </div>
    </div>

    <div class="ftr__bottom">
      <p style="margin:0">&copy; <span data-year>2026</span> <?= e($CFG['SITE_NAME']) ?>. Avon Fitness equipment manufactured by <?= e($CFG['ADDRESS_LINE1']) ?></p>
      <nav aria-label="Legal">
        <a href="/privacy-policy/">Privacy Policy</a>
        <a href="/terms/">Terms &amp; Conditions</a>
        <a href="/sitemap/">Sitemap</a>
      </nav>
    </div>
  </div>
</footer>

<!-- ---------------- floating actions ---------------- -->
<div class="fab">
  <button class="to-top" type="button" aria-label="Back to top">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
  </button>
  <a class="fab__wa" href="<?= e(wa()) ?>" rel="noopener nofollow" target="_blank" aria-label="Chat with Avon Fitness Maharashtra on WhatsApp">
    <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="<?= e($icons['WhatsApp']) ?>"/></svg>
  </a>
</div>

<!-- ---------------- side "Enquiry Now" tab + popup form ---------------- -->
<button class="side-enq" type="button" data-enq-open aria-haspopup="dialog" aria-controls="enq-modal">Enquiry Now</button>

<div class="enq-modal" id="enq-modal" role="dialog" aria-modal="true" aria-labelledby="enq-modal-title" hidden>
  <div class="enq-modal__scrim" data-enq-close></div>
  <div class="enq-modal__box">
    <button class="enq-modal__x" type="button" data-enq-close aria-label="Close enquiry form">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>
    <h2 id="enq-modal-title">Enquiry Now</h2>
    <p>Tell us what you need. Our team replies with an equipment list and one clear quotation.</p>
    <?php enquiry_form('', 'enquiry-popup'); ?>
  </div>
</div>

<!-- ---------------- comparison drawer ---------------- -->
<div class="cmp-bar" role="region" aria-label="Product comparison">
  <div class="cmp-bar__inner">
    <strong style="font-family:var(--f-display);text-transform:uppercase;font-size:.85rem;letter-spacing:.06em">
      Compare (<span data-cmp-count>0</span>/4)
    </strong>
    <div class="cmp-bar__items"></div>
    <a class="btn btn--sm" data-cmp-go href="/compare/">Compare now</a>
    <button class="btn btn--sm btn--light" type="button" data-cmp-clear>Clear</button>
  </div>
</div>

<!-- ---------------- mobile bottom bar ---------------- -->
<nav class="mbar" aria-label="Quick actions">
  <a href="tel:<?= e($CFG['CONTACT_PHONE_RAW']) ?>">
    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a1 1 0 0 1-1 1A16 16 0 0 1 4 5a1 1 0 0 1 1-1"/></svg>
    Call
  </a>
  <a href="<?= e(wa()) ?>" rel="noopener nofollow" target="_blank">
    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.6 8.6 0 0 1-3.9-.9L3 20l1.3-4a8.3 8.3 0 0 1-1-4 8.4 8.4 0 0 1 8.5-8.4 8.4 8.4 0 0 1 9.2 7.9z"/></svg>
    WhatsApp
  </a>
  <a class="is-primary" href="/contact/">
    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 6h16v12H4zM4 7l8 6 8-6"/></svg>
    Get Quote
  </a>
</nav>

<script src="/assets/js/main.js?v=4" defer></script>
<?php if (!empty($PAGE['catalog_js'])): ?>
<script src="/assets/js/catalog.js?v=3" defer></script>
<?php endif; ?>
</body>
</html>
