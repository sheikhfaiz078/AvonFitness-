<?php
require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/components.php';

$preset = isset($_GET['product']) ? substr(strip_tags((string) $_GET['product']), 0, 160) : '';

$faqs = [
    ['q' => 'How quickly will I get a reply?',
     'a' => 'We aim to respond to enquiries within one business day. If you need something faster, call or send a WhatsApp message — those reach us directly.'],
    ['q' => 'What should I include in my enquiry?',
     'a' => 'Your city, the type of space (home, commercial, hotel, institutional, outdoor), the approximate floor area, and either a product list or a rough budget. With those four things we can usually come back with a costed equipment list rather than a follow-up question.'],
    ['q' => 'Do you visit the site before quoting?',
     'a' => 'For commercial projects, yes — either in person or by working from your drawings and photographs. Layout, access and power all affect the equipment list, so we would rather look before we quote.'],
    ['q' => 'Can I visit a showroom?',
     'a' => 'Get in touch and we will tell you what is currently viewable and where. Availability varies, so it is worth confirming before you travel.'],
    ['q' => 'Do you handle service and spares for existing Avon equipment?',
     'a' => 'Yes. Send us the model number and a description of the fault. Technical support and spare parts for Avon equipment are also handled directly by the manufacturer at ' . $CFG['FACTORY_SERVICE_EMAIL'] . '.'],
];

$crumbItems = [['name' => 'Home', 'url' => '/'], ['name' => 'Contact']];

$PAGE = [
    'title'       => 'Contact Avon Fitness Maharashtra | Gym Equipment Enquiry',
    'description' => 'Talk to Avon Fitness about gym equipment in Maharashtra. Call ' . $CFG['CONTACT_PHONE'] . ', message on WhatsApp, or send an enquiry for a quotation on commercial, home or outdoor gym equipment.',
    'canonical'   => 'contact/',
    'nav'         => 'contact',
    'crumbs'      => $crumbItems,
    'schema'      => [
        faq_schema($faqs),
        [
            '@type'       => 'ContactPage',
            '@id'         => url('contact/') . '#contactpage',
            'name'        => 'Contact Avon Fitness Maharashtra',
            'url'         => url('contact/'),
            'isPartOf'    => ['@id' => url('#website')],
            'about'       => ['@id' => url('#organisation')],
        ],
    ],
];
require dirname(__DIR__) . '/includes/header.php';
crumbs($crumbItems);
page_head(
    'Talk to Avon Fitness',
    'Tell us what you are building — a home setup, a commercial floor, a hotel gym or an outdoor fitness zone — and we will come back with an equipment list and a quotation.',
    'Contact'
);
?>

<section class="section section--tight">
  <div class="wrap-wide">
    <div class="grid g-3" data-stagger>
      <a class="fcard" href="tel:<?= e($CFG['CONTACT_PHONE_RAW']) ?>">
        <span class="fcard__ico" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a1 1 0 0 1-1 1A16 16 0 0 1 4 5a1 1 0 0 1 1-1"/></svg>
        </span>
        <h3>Call us</h3>
        <p style="font-size:1.05rem;font-weight:700;color:var(--ink)"><?= e($CFG['CONTACT_PHONE']) ?></p>
        <p><?= e($CFG['HOURS_WEEKDAY']) ?> Mon&ndash;Fri &middot; <?= e($CFG['HOURS_SATURDAY']) ?> Sat</p>
      </a>

      <a class="fcard" href="<?= e(wa()) ?>" rel="noopener nofollow" target="_blank">
        <span class="fcard__ico" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.6 8.6 0 0 1-3.9-.9L3 20l1.3-4a8.3 8.3 0 0 1-1-4 8.4 8.4 0 0 1 8.5-8.4 8.4 8.4 0 0 1 9.2 7.9z"/></svg>
        </span>
        <h3>WhatsApp</h3>
        <p style="font-size:1.05rem;font-weight:700;color:var(--ink)"><?= e($CFG['CONTACT_PHONE']) ?></p>
        <p>Fastest route for a quick question or to send photographs of your space.</p>
      </a>

      <a class="fcard" href="mailto:<?= e($CFG['CONTACT_EMAIL']) ?>">
        <span class="fcard__ico" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18v12H3zM3 7l9 6 9-6"/></svg>
        </span>
        <h3>Email</h3>
        <p style="font-size:1.02rem;font-weight:700;color:var(--ink);word-break:break-word"><?= e($CFG['CONTACT_EMAIL']) ?></p>
        <p>Best for drawings, tender documents and detailed equipment schedules.</p>
      </a>
    </div>
  </div>
</section>

<section class="section section--tight section--alt">
  <div class="wrap-wide">
    <div class="split split--b">

      <div data-reveal="left">
        <?php sec_head('', 'Enquiry form', 'Tell us what<br><span class="thin">you&rsquo;re building.</span>',
            'Share a few details and our team will come back with pricing and a recommended equipment list. Fields marked <span class="req" style="color:var(--red)">*</span> are required.'); ?>
        <?php enquiry_form($preset, 'contact-form'); ?>
      </div>

      <div data-reveal="right">
        <div class="fcard">
          <h3>Registered office</h3>
          <address style="font-style:normal;line-height:1.85;color:var(--ink-2);font-size:.95rem">
            <strong style="color:var(--ink)"><?= e($CFG['ADDRESS_LINE1']) ?></strong><br>
            <?= e($CFG['ADDRESS_LINE2']) ?><br>
            <?= e($CFG['ADDRESS_CITY']) ?>, <?= e($CFG['ADDRESS_STATE']) ?> <?= e($CFG['ADDRESS_PIN']) ?><br>
            <?= e($CFG['ADDRESS_COUNTRY']) ?>
          </address>
          <p style="margin-top:1rem;font-size:.9rem;color:var(--ink-2)">
            This is the Avon Fitness Machines manufacturing address. Sales, delivery and installation
            for Maharashtra are handled through the contact details above.
          </p>
        </div>

        <div class="fcard" style="margin-top:1rem">
          <h3>Where we deliver</h3>
          <p><?= e($CFG['SERVICE_AREA']) ?>.</p>
          <p style="margin-top:.6rem"><a class="ulink" href="/gym-equipment-maharashtra/">Gym equipment in Maharashtra &rarr;</a></p>
        </div>

        <div class="fcard" style="margin-top:1rem">
          <h3>Business hours</h3>
          <table class="spec-table" style="border:0">
            <tbody>
              <tr><th scope="row">Monday &ndash; Friday</th><td><?= e($CFG['HOURS_WEEKDAY']) ?></td></tr>
              <tr><th scope="row">Saturday</th><td><?= e($CFG['HOURS_SATURDAY']) ?></td></tr>
              <tr><th scope="row">Sunday</th><td><?= e($CFG['HOURS_SUNDAY']) ?></td></tr>
            </tbody>
          </table>
        </div>

        <div class="fcard" style="margin-top:1rem">
          <h3>Technical support &amp; spares</h3>
          <p>For service and spare-part queries on existing Avon equipment, the manufacturer's desks are:</p>
          <p style="margin-top:.5rem">
            <a class="ulink" href="mailto:<?= e($CFG['FACTORY_SERVICE_EMAIL']) ?>"><?= e($CFG['FACTORY_SERVICE_EMAIL']) ?></a><br>
            <a class="ulink" href="mailto:<?= e($CFG['FACTORY_ENQUIRY_EMAIL']) ?>"><?= e($CFG['FACTORY_ENQUIRY_EMAIL']) ?></a><br>
            <a class="ulink" href="tel:<?= e(str_replace(' ', '', $CFG['FACTORY_ENQUIRY_PHONE'])) ?>"><?= e($CFG['FACTORY_ENQUIRY_PHONE']) ?></a>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap-wide" style="max-width:940px">
    <?php sec_head('', 'Questions', 'Before you<br><span class="thin">get in touch.</span>'); ?>
    <?php faq_block($faqs, 'contact-faq'); ?>
  </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
