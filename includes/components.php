<?php
/** Reusable render helpers shared by every page. */
require_once __DIR__ . '/config.php';

/** Breadcrumb trail (matching BreadcrumbList schema is emitted by header.php). */
function crumbs(array $items): void
{
    echo '<nav class="crumbs" aria-label="Breadcrumb"><div class="wrap"><ol>';
    $last = count($items) - 1;
    foreach ($items as $i => $c) {
        echo '<li>';
        if ($i === $last || empty($c['url'])) {
            echo '<span aria-current="page">' . e($c['name']) . '</span>';
        } else {
            echo '<a href="' . e($c['url']) . '">' . e($c['name']) . '</a>';
        }
        echo '</li>';
    }
    echo '</ol></div></nav>';
}

/** Dark page masthead. */
function page_head(string $h1, string $intro = '', string $eyebrow = ''): void
{
    echo '<section class="phead"><div class="wrap phead__inner">';
    if ($eyebrow !== '') {
        echo '<span class="eyebrow is-in">' . e($eyebrow) . '</span>';
    }
    echo '<h1>' . e($h1) . '</h1>';
    if ($intro !== '') {
        echo '<p>' . $intro . '</p>';
    }
    echo '</div></section>';
}

/** Section heading block. */
function sec_head(string $num, string $eyebrow, string $title, string $lead = '', ?string $linkHref = null, string $linkText = ''): void
{
    echo '<div class="sec-head' . ($linkHref ? ' sec-head--split' : '') . '" data-reveal>';
    echo '<div class="sec-head__max">';
    if ($num !== '') {
        echo '<span class="sec-num">' . e($num) . '</span>';
    }
    echo '<span class="eyebrow">' . e($eyebrow) . '</span>';
    echo '<h2 class="sec-title">' . $title . '</h2>';
    if ($lead !== '') {
        echo '<p class="lead" style="margin-top:1rem">' . $lead . '</p>';
    }
    echo '</div>';
    if ($linkHref) {
        echo '<a class="btn btn--ghost btn--sm" href="' . e($linkHref) . '">' . e($linkText) . '</a>';
    }
    echo '</div>';
}

/** A single product card. */
function product_card(array $p, bool $compare = true): void
{
    $tag = match ($p['segment']) {
        'commercial' => 'Commercial',
        'home'       => 'Home',
        'outdoor'    => 'Outdoor',
        default      => 'Commercial & Home',
    };
    ?>
    <article class="card">
      <div class="card__media">
        <img src="/<?= e($p['image']) ?>" alt="<?= e($p['image_alt']) ?>"
             loading="lazy" decoding="async" width="400" height="400">
        <span class="card__tag<?= $p['segment'] === 'commercial' ? ' card__tag--red' : '' ?>"><?= e($tag) ?></span>
        <?php if ($compare): ?>
        <span class="card__cmp"><label class="cmp-box">
          <input type="checkbox" value="<?= e($p['slug']) ?>" aria-label="Compare <?= e($p['product_name']) ?>">Compare
        </label></span>
        <?php endif; ?>
      </div>
      <div class="card__body">
        <?php if ($p['model_number']): ?><span class="card__model"><?= e($p['model_number']) ?></span><?php endif; ?>
        <h3 class="card__name"><?= e($p['product_name']) ?></h3>
        <p class="card__desc"><?= e($p['short_description']) ?></p>
        <div class="card__foot">
          <span class="card__cat"><?= e($p['subcategory']) ?></span>
          <span class="card__go">View
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
          </span>
        </div>
      </div>
      <a class="card__link" href="/product/<?= e($p['slug']) ?>/"><span class="sr-only"><?= e($p['product_name']) ?></span></a>
    </article>
    <?php
}

/** Grid of product cards. */
function product_grid(array $list, string $cls = 'g-4'): void
{
    echo '<div class="grid ' . e($cls) . '" data-stagger>';
    foreach ($list as $p) {
        product_card($p);
    }
    echo '</div>';
}

/** Accordion FAQ. FAQPage schema is passed separately via $PAGE['schema']. */
function faq_block(array $faqs, string $idPrefix = 'faq'): void
{
    echo '<div class="faq">';
    foreach ($faqs as $i => $f) {
        $id = $idPrefix . '-' . $i;
        echo '<div class="faq__item">'
           . '<h3 style="margin:0"><button class="faq__q" type="button" aria-expanded="false" aria-controls="' . $id . '">'
           . '<span>' . e($f['q']) . '</span><span class="faq__ico" aria-hidden="true"></span></button></h3>'
           . '<div class="faq__a" id="' . $id . '"><div><p>' . $f['a'] . '</p></div></div>'
           . '</div>';
    }
    echo '</div>';
}

/** Build the FAQPage JSON-LD for a set of FAQs. */
function faq_schema(array $faqs): array
{
    $items = [];
    foreach ($faqs as $f) {
        $items[] = [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => trim(strip_tags($f['a'])),
            ],
        ];
    }
    return ['@type' => 'FAQPage', 'mainEntity' => $items];
}

/** The closing call-to-action band. */
function cta_band(
    string $title = 'Build your fitness space.',
    string $copy = 'Send us a floor plan, a budget or just a list of what you need. We will come back with an equipment list, a layout and one clear quotation.',
    string $btn = 'Get a Quote',
    string $href = '/contact/'
): void {
    global $CFG;
    ?>
    <section class="section cta-band">
      <div class="wrap cta-band__inner">
        <div data-reveal="left">
          <span class="eyebrow">Next step</span>
          <h2><?= e($title) ?></h2>
          <p><?= e($copy) ?></p>
        </div>
        <div data-reveal="right" style="display:flex;flex-wrap:wrap;gap:.8rem">
          <a class="btn" href="<?= e($href) ?>"><?= e($btn) ?>
            <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
          </a>
          <a class="btn btn--light" href="tel:<?= e($CFG['CONTACT_PHONE_RAW']) ?>">Call <?= e($CFG['CONTACT_PHONE']) ?></a>
        </div>
      </div>
    </section>
    <?php
}

/** The enquiry form. Used on /contact/ and inside product pages. */
function enquiry_form(string $preset = '', string $id = 'enquiry'): void
{
    global $CFG;
    $types = ['Home Gym', 'Commercial Gym', 'Institutional Gym', 'Hotel Gym', 'Outdoor Gym',
              'Equipment Purchase', 'Bulk Order', 'Gym Setup', 'Service / Spares', 'Other'];
    ?>
    <form class="form" id="<?= e($id) ?>" action="/api/contact.php" method="post" data-enquiry novalidate>
      <div class="form__msg" role="status" aria-live="polite"></div>

      <div class="hp-field" aria-hidden="true">
        <label for="<?= e($id) ?>-cw">Company website</label>
        <input id="<?= e($id) ?>-cw" type="text" name="company_website" tabindex="-1" autocomplete="off">
      </div>
      <input type="hidden" name="form_started" value="" data-started>
      <input type="hidden" name="page_url" value="" data-pageurl>

      <div class="form__row">
        <div data-field>
          <label for="<?= e($id) ?>-name">Name <span class="req">*</span></label>
          <input id="<?= e($id) ?>-name" name="name" type="text" required autocomplete="name" placeholder="Your full name">
          <span class="err">Please tell us your name.</span>
        </div>
        <div data-field>
          <label for="<?= e($id) ?>-phone">Phone <span class="req">*</span></label>
          <input id="<?= e($id) ?>-phone" name="phone" type="tel" required autocomplete="tel" inputmode="tel" placeholder="10-digit mobile number">
          <span class="err">Please enter a valid phone number.</span>
        </div>
      </div>

      <div class="form__row">
        <div data-field>
          <label for="<?= e($id) ?>-email">Email</label>
          <input id="<?= e($id) ?>-email" name="email" type="email" autocomplete="email" placeholder="you@company.com">
          <span class="err">That email address does not look right.</span>
        </div>
        <div data-field>
          <label for="<?= e($id) ?>-city">City <span class="req">*</span></label>
          <input id="<?= e($id) ?>-city" name="city" type="text" required autocomplete="address-level2" placeholder="Mumbai, Pune, Nagpur…">
          <span class="err">Please tell us your city.</span>
        </div>
      </div>

      <div class="form__row">
        <div data-field>
          <label for="<?= e($id) ?>-req">Requirement type</label>
          <select id="<?= e($id) ?>-req" name="requirement">
            <option value="">Select one</option>
            <?php foreach ($types as $t): ?>
              <option value="<?= e($t) ?>"><?= e($t) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div data-field>
          <label for="<?= e($id) ?>-budget">Indicative budget</label>
          <select id="<?= e($id) ?>-budget" name="budget">
            <option value="">Prefer not to say</option>
            <option>Under ₹1 lakh</option>
            <option>₹1 – 5 lakh</option>
            <option>₹5 – 15 lakh</option>
            <option>₹15 – 50 lakh</option>
            <option>Above ₹50 lakh</option>
          </select>
        </div>
      </div>

      <div data-field>
        <label for="<?= e($id) ?>-product">Product / equipment of interest</label>
        <input id="<?= e($id) ?>-product" name="product" type="text" data-prefill
               value="<?= e($preset) ?>" placeholder="Model number or equipment type">
      </div>

      <div data-field>
        <label for="<?= e($id) ?>-msg">Message</label>
        <textarea id="<?= e($id) ?>-msg" name="message" rows="5"
                  placeholder="Tell us about the space, the number of users and your timeline."></textarea>
      </div>

      <div style="display:flex;flex-wrap:wrap;gap:.8rem;align-items:center">
        <button class="btn" type="submit">Send Enquiry
          <svg class="ico" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </button>
        <a class="btn btn--wa" href="<?= e(wa()) ?>" rel="noopener nofollow" target="_blank">WhatsApp Instead</a>
      </div>
      <p class="form__note">We use your details only to answer this enquiry. See our
        <a class="ulink" href="/privacy-policy/">privacy policy</a>.</p>
    </form>
    <script>(function(){var f=document.getElementById(<?= json_encode($id) ?>);if(!f)return;
      var s=f.querySelector('[data-started]');if(s)s.value=Date.now();
      var u=f.querySelector('[data-pageurl]');if(u)u.value=location.href;})();</script>
    <?php
}

/** Stat tiles. Only verified figures are ever passed in. */
function stats_row(array $stats, bool $dark = false): void
{
    echo '<div class="stats" data-reveal>';
    foreach ($stats as $s) {
        echo '<div class="stat"><b>';
        if (isset($s['count'])) {
            echo '<span data-count="' . e((string) $s['count']) . '" data-suffix="' . e($s['suffix'] ?? '') . '">0</span>';
        } else {
            echo '<span class="u">' . e($s['value']) . '</span>';
        }
        echo '</b><span>' . e($s['label']) . '</span></div>';
    }
    echo '</div>';
}

/**
 * Pick the best product photo to sit on a dark tile: a cut-out if the
 * subcategory has one, otherwise the highest-ranked product.
 */
function tile_sample(string $sub): ?array
{
    $list = rank_products(products_where(['sub' => $sub]));
    foreach ($list as $p) {
        if (!empty($p['image_cutout'])) {
            return $p;
        }
    }
    return $list[0] ?? null;
}

/** Category tile. */
function category_tile(string $href, string $num, string $name, int $count, ?array $sample = null): void
{
    ?>
    <a class="tile" href="<?= e($href) ?>">
      <?php if ($sample): ?>
      <span class="tile__img"><img src="/<?= e($sample['image']) ?>" alt="" loading="lazy" width="400" height="400"></span>
      <?php endif; ?>
      <span class="tile__num"><?= e($num) ?></span>
      <span class="tile__name"><?= e($name) ?></span>
      <span class="tile__count"><?= $count ?> product<?= $count === 1 ? '' : 's' ?></span>
      <span class="tile__bar"></span>
    </a>
    <?php
}
