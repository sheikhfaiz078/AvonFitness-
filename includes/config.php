<?php
/**
 * Bootstrap: loads /config/site.php, exposes it as $CFG and defines the
 * small helper set every page uses. Included once at the top of each page.
 */
declare(strict_types=1);

if (defined('AVON_BOOTED')) {
    return;
}
define('AVON_BOOTED', true);

define('AVON_ROOT', dirname(__DIR__));

$CFG = require AVON_ROOT . '/config/site.php';

/* ---------------------------------------------------------------- helpers */

/** Escape for HTML output. */
function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Clamp a <title> to what search engines actually display (~60 chars).
 * Tries a shorter brand suffix first, then drops the suffix, and only
 * truncates as a last resort.
 */
function seo_title(string $t, int $max = 62): string
{
    $t = trim($t);
    if (mb_strlen($t) <= $max) {
        return $t;
    }
    $short = str_replace('| Avon Fitness Maharashtra', '| Avon Fitness', $t);
    if (mb_strlen($short) <= $max) {
        return $short;
    }
    $bare = preg_replace('/\s*\|\s*Avon Fitness(\s+Maharashtra)?\s*$/u', '', $t) ?? $t;
    if (mb_strlen($bare) <= $max) {
        return $bare;
    }
    $cut = mb_substr($bare, 0, $max - 1);
    $sp  = mb_strrpos($cut, ' ');
    return rtrim($sp > 30 ? mb_substr($cut, 0, $sp) : $cut, " ,.–-") . '…';
}

/**
 * Clamp a meta description to ~158 characters, cutting at a sentence end
 * where possible so the snippet still reads as a complete thought.
 */
function seo_desc(string $d, int $max = 158): string
{
    $d = trim(preg_replace('/\s+/u', ' ', $d) ?? $d);
    if (mb_strlen($d) <= $max) {
        return $d;
    }
    $cut = mb_substr($d, 0, $max);
    foreach (['. ', '? ', '! ', '— ', ' — '] as $stop) {
        $at = mb_strrpos($cut, $stop);
        if ($at !== false && $at > $max * 0.55) {
            return rtrim(mb_substr($cut, 0, $at + 1));
        }
    }
    $sp = mb_strrpos($cut, ' ');
    return rtrim($sp > $max * 0.5 ? mb_substr($cut, 0, $sp) : $cut, " ,;:–-") . '…';
}

/** Absolute site URL for a root-relative path. */
function url(string $path = ''): string
{
    global $CFG;
    return rtrim($CFG['SITE_URL'], '/') . '/' . ltrim($path, '/');
}

/** A pre-filled WhatsApp link. */
function wa(string $text = ''): string
{
    global $CFG;
    $text = $text !== '' ? $text
        : 'Hello Avon Fitness, I would like a quote for gym equipment in Maharashtra.';
    return 'https://wa.me/' . $CFG['WHATSAPP_NUMBER'] . '?text=' . rawurlencode($text);
}

/** The full catalogue, decoded once per request. */
function products(): array
{
    static $all = null;
    if ($all === null) {
        $raw = @file_get_contents(AVON_ROOT . '/data/products.json');
        $all = $raw ? (json_decode($raw, true) ?: []) : [];
    }
    return $all;
}

/** One product by slug, or null. */
function product(string $slug): ?array
{
    foreach (products() as $p) {
        if ($p['slug'] === $slug) {
            return $p;
        }
    }
    return null;
}

/** Products filtered by family / subcategory / segment. */
function products_where(array $f, int $limit = 0): array
{
    $out = [];
    foreach (products() as $p) {
        if (isset($f['family']) && $p['family'] !== $f['family']) {
            continue;
        }
        if (isset($f['sub'])
            && $p['subcategory_slug'] !== $f['sub']
            && !in_array($f['sub'], $p['all_subcategories'] ?? [], true)) {
            continue;
        }
        if (isset($f['segment'])
            && $p['segment'] !== $f['segment'] && $p['segment'] !== 'both') {
            continue;
        }
        if (isset($f['has_specs']) && $f['has_specs'] && empty($p['specifications'])) {
            continue;
        }
        $out[] = $p;
        if ($limit && count($out) >= $limit) {
            break;
        }
    }
    return $out;
}

/** Documented models first — used for "featured" rails. */
function rank_products(array $list): array
{
    usort($list, static function (array $a, array $b): int {
        $sa = count($a['specifications'] ?? []);
        $sb = count($b['specifications'] ?? []);
        if ($sa !== $sb) {
            return $sb <=> $sa;
        }
        return strcmp($a['product_name'], $b['product_name']);
    });
    return $list;
}

/** The taxonomy tree. */
function categories(): array
{
    static $c = null;
    if ($c === null) {
        $raw = @file_get_contents(AVON_ROOT . '/data/categories.json');
        $c = $raw ? (json_decode($raw, true) ?: []) : [];
    }
    return $c;
}

/** Count products in a subcategory (including secondary membership). */
function sub_count(string $slug): int
{
    static $cache = [];
    if (!isset($cache[$slug])) {
        $n = 0;
        foreach (products() as $p) {
            if ($p['subcategory_slug'] === $slug
                || in_array($slug, $p['all_subcategories'] ?? [], true)) {
                $n++;
            }
        }
        $cache[$slug] = $n;
    }
    return $cache[$slug];
}

/** Maharashtra cities used for internal linking and local copy. */
function cities(): array
{
    return [
        'Mumbai', 'Thane', 'Navi Mumbai', 'Pune', 'Nashik', 'Nagpur',
        'Chhatrapati Sambhajinagar', 'Kolhapur', 'Solapur', 'Amravati',
        'Sangli', 'Satara', 'Akola', 'Nanded', 'Jalgaon', 'Ahilyanagar',
        'Latur', 'Ratnagiri',
    ];
}

/**
 * The single headline specification worth putting on a hero slide, chosen in
 * order of what a buyer actually judges a machine by.
 */
function headline_spec(array $p): string
{
    $order = ['AC Motor', 'DC Motor', 'BLDC Motor', 'Weight Stack', 'Running Area',
              'Max User Weight', 'Speed Range', 'Resistance', 'Frame Tube',
              'Dimensions (L x W x H)'];
    foreach ($order as $k) {
        if (!empty($p['specifications'][$k])) {
            return $k . ' · ' . $p['specifications'][$k];
        }
    }
    $first = array_slice($p['specifications'] ?? [], 0, 1, true);
    foreach ($first as $k => $v) {
        return $k . ' · ' . $v;
    }
    return $p['subcategory'];
}

/**
 * Hero carousel slides.
 *
 * Each entry names a preferred model with a subcategory fallback, so the hero
 * keeps working if a product is renamed or removed. Only cut-out photography is
 * used — a white-matte JPEG would show as a white box on the charcoal hero.
 */
function hero_slides(): array
{
    /*
     * Each slide carries its own headline so the hero text changes with the
     * machine. Headlines lead with the equipment noun, which keeps them
     * keyword-bearing as well as specific. Lines are [css class, text]; the
     * empty class is plain white, 'accent' is red, 'outline' is stroked.
     */
    $wanted = [
        ['slug' => 'tm-1000-commercial-treadmill', 'sub' => 'treadmills',
         'label' => 'Commercial Cardio',
         'h1'    => [['', 'Commercial treadmills'], ['accent', 'built to run'],
                     ['outline', 'all day, every day.']],
         'copy'  => 'Continuous-duty treadmills built for a paying gym floor — '
                  . 'AC drives, full-size running decks and user ratings up to 240 kg.'],
        ['slug' => 'rhino-840-max-cable-crossover', 'sub' => 'multi-stations',
         'label' => 'Functional Training',
         'h1'    => [['', 'Functional trainers.'], ['accent', 'Every movement'],
                     ['outline', 'in a single frame.']],
         'copy'  => 'Multi stations and functional trainers that cover every movement '
                  . 'pattern in a single footprint.'],
        ['slug' => 'ff-106-pro-shoulder-press', 'sub' => 'fit-fighter-pro-series',
         'label' => 'Selectorised Strength',
         'h1'    => [['', 'Strength stations'], ['accent', 'that take the load'],
                     ['outline', 'shift after shift.']],
         'copy'  => 'High-tensile steel frames, powder-coated finishes and selectorised '
                  . 'stacks — specified for continuous commercial use.'],
        ['slug' => 'mg-1145-5-station-multi-gym', 'sub' => 'multi-gyms',
         'label' => 'Multi Gyms',
         'h1'    => [['', 'Multi gyms.'], ['accent', 'Five stations,'],
                     ['outline', 'one footprint.']],
         'copy'  => 'Multi-station gyms that keep a busy floor moving, with no loose '
                  . 'plates to handle or store.'],
        ['slug' => 'sp-2296-commercial-spin-bike', 'sub' => 'spin-bikes',
         'label' => 'Studio Cycling',
         'h1'    => [['', 'Spin bikes built'], ['accent', 'for a full'],
                     ['outline', 'class timetable.']],
         'copy'  => 'Spin bikes for class timetables and home training, adjustable '
                  . 'enough to fit riders of every height.'],
        ['slug' => 'hg-1265-home-gym', 'sub' => 'home-gym-stations',
         'label' => 'Home Training',
         'h1'    => [['', 'A full home gym'], ['accent', 'in a spare room.'],
                     ['outline', 'No compromise.']],
         'copy'  => 'Home gym stations sized for a spare room — full strength coverage '
                  . 'without a commercial footprint.'],
    ];

    $slides = [];
    $used   = [];
    foreach ($wanted as $w) {
        $p = product($w['slug']);
        if (!$p || empty($p['image_cutout'])) {
            $p = null;
            foreach (rank_products(products_where(['sub' => $w['sub']])) as $c) {
                if (!empty($c['image_cutout']) && !in_array($c['slug'], $used, true)) {
                    $p = $c;
                    break;
                }
            }
        }
        if (!$p || in_array($p['slug'], $used, true)) {
            continue;
        }
        $used[] = $p['slug'];
        $slides[] = [
            'label'   => $w['label'],
            'copy'    => $w['copy'],
            'h1'      => $w['h1'],
            'product' => $p,
            'spec'    => headline_spec($p),
        ];
    }
    return $slides;
}

/** Blog index — the single source for article metadata. */
function articles(): array
{
    static $a = null;
    if ($a === null) {
        $raw = @file_get_contents(AVON_ROOT . '/data/articles.json');
        $a = $raw ? (json_decode($raw, true) ?: []) : [];
    }
    return $a;
}

function article(string $slug): ?array
{
    foreach (articles() as $a) {
        if ($a['slug'] === $slug) {
            return $a;
        }
    }
    return null;
}
