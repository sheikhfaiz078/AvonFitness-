<?php
/**
 * =============================================================================
 *  AVON FITNESS MAHARASHTRA — ENQUIRY HANDLER
 * =============================================================================
 *  Receives the enquiry form, validates and sanitises everything server-side,
 *  then emails it to the address set in /config/site.php.
 *
 *  Runs on stock Hostinger shared hosting: plain PHP, mail(), no Composer,
 *  no external services, no credentials stored anywhere.
 * =============================================================================
 */

declare(strict_types=1);

/* Enquiry timestamps are reported in IST regardless of server locale. */
@date_default_timezone_set('Asia/Kolkata');

session_start();

$cfg = require __DIR__ . '/../config/site.php';

/* --------------------------------------------------------------------------
 |  Respond as JSON (the front-end posts with fetch)
 * ------------------------------------------------------------------------ */
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

function out(bool $ok, string $message, int $code = 200): void
{
    http_response_code($code);
    echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    out(false, 'Method not allowed.', 405);
}

/* --------------------------------------------------------------------------
 |  Same-origin check — blocks the simplest cross-site form abuse
 * ------------------------------------------------------------------------ */
$host = $_SERVER['HTTP_HOST'] ?? '';
foreach (['HTTP_ORIGIN' => true, 'HTTP_REFERER' => false] as $key => $strict) {
    if (!empty($_SERVER[$key])) {
        $h = parse_url($_SERVER[$key], PHP_URL_HOST);
        if ($h && $host && stripos($h, (string) preg_replace('/:\d+$/', '', $host)) === false) {
            out(false, 'This form can only be submitted from our website.', 403);
        }
        if ($strict) {
            break;
        }
    }
}

/* --------------------------------------------------------------------------
 |  Spam controls: honeypot, time-trap, rate limit
 * ------------------------------------------------------------------------ */
if (trim((string) ($_POST['company_website'] ?? '')) !== '') {
    out(true, 'Thank you — your enquiry has been received.');   // silent drop
}

$started = (int) ($_POST['form_started'] ?? 0);
$minFill = (int) ($cfg['MIN_FILL_SECONDS'] ?? 3);
if ($started > 0 && (time() - intdiv($started, 1000)) < $minFill) {
    out(false, 'That was submitted a little too quickly. Please try once more.', 429);
}

$gap  = (int) ($cfg['RATE_LIMIT_SECONDS'] ?? 45);
$last = (int) ($_SESSION['avon_last_enquiry'] ?? 0);
if ($last && (time() - $last) < $gap) {
    out(false, 'We have already received your enquiry. Please wait a moment before sending another.', 429);
}

/* --------------------------------------------------------------------------
 |  Collect + sanitise
 * ------------------------------------------------------------------------ */
function field(string $key, int $max = 500): string
{
    $v = (string) ($_POST[$key] ?? '');
    $v = str_replace(["\r", "\0"], '', $v);
    $v = trim(strip_tags($v));
    return mb_substr($v, 0, $max);
}

/** Strip anything that could be used to inject an extra mail header. */
function headerSafe(string $v): string
{
    return trim(preg_replace('/[\r\n\t]+|%0[ad]/i', ' ', $v) ?? '');
}

$name        = headerSafe(field('name', 120));
$phone       = headerSafe(field('phone', 30));
$email       = headerSafe(field('email', 160));
$city        = headerSafe(field('city', 90));
$requirement = headerSafe(field('requirement', 90));
$product     = headerSafe(field('product', 160));
$budget      = headerSafe(field('budget', 60));
$message     = field('message', 3000);
$pageUrl     = headerSafe(field('page_url', 300));

/* --------------------------------------------------------------------------
 |  Validate
 * ------------------------------------------------------------------------ */
$errors = [];

if (mb_strlen($name) < 2) {
    $errors[] = 'a name';
}

$digits = preg_replace('/\D/', '', $phone) ?? '';
if (strlen($digits) < 10 || strlen($digits) > 15) {
    $errors[] = 'a valid phone number';
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'a valid email address';
}

if (mb_strlen($city) < 2) {
    $errors[] = 'your city';
}

if ($errors) {
    out(false, 'Please add ' . implode(', ', $errors) . ' and submit again.', 422);
}

/* Reject obvious link-spam in the message body. */
if (preg_match_all('~https?://~i', $message) > 2) {
    out(false, 'Your message could not be sent. Please remove the links and try again.', 422);
}

/* --------------------------------------------------------------------------
 |  Compose
 * ------------------------------------------------------------------------ */
$siteName = (string) $cfg['SITE_NAME'];
$to       = (string) $cfg['CONTACT_EMAIL'];
$fromAddr = (string) $cfg['EMAIL_FROM'];
$fromName = (string) $cfg['EMAIL_FROM_NAME'];

$subjectBits = array_filter([$requirement ?: 'Website enquiry', $city]);
$subject     = 'Enquiry: ' . implode(' — ', $subjectBits) . ' (' . $name . ')';
$subject     = headerSafe($subject);

$rows = [
    'Name'            => $name,
    'Phone'           => $phone,
    'Email'           => $email ?: '—',
    'City'            => $city,
    'Requirement'     => $requirement ?: '—',
    'Product / Model' => $product ?: '—',
    'Budget'          => $budget ?: '—',
    'Enquiry page'    => $pageUrl ?: '—',
    'Received'        => date('d M Y, H:i') . ' IST',
    'Visitor IP'      => (string) ($_SERVER['REMOTE_ADDR'] ?? '—'),
];

$plain = "New enquiry from " . $siteName . "\n"
       . str_repeat('=', 52) . "\n\n";
foreach ($rows as $k => $v) {
    $plain .= str_pad($k, 18) . ': ' . $v . "\n";
}
$plain .= "\nMessage:\n" . ($message !== '' ? $message : '—') . "\n";

$e = static fn(string $s): string => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');

$html = '<!doctype html><html><body style="margin:0;background:#f4f4f4;padding:24px;'
      . 'font-family:Arial,Helvetica,sans-serif;color:#141414">'
      . '<table role="presentation" width="100%" style="max-width:620px;margin:auto;'
      . 'background:#fff;border-radius:8px;overflow:hidden">'
      . '<tr><td style="background:#111;padding:20px 24px">'
      . '<span style="color:#ED1C24;font-size:12px;letter-spacing:2px">NEW ENQUIRY</span><br>'
      . '<span style="color:#fff;font-size:20px;font-weight:bold">' . $e($siteName) . '</span>'
      . '</td></tr><tr><td style="padding:8px 24px 20px"><table role="presentation" width="100%" '
      . 'style="border-collapse:collapse;font-size:14px">';
foreach ($rows as $k => $v) {
    $html .= '<tr><td style="padding:9px 0;border-bottom:1px solid #eee;color:#777;width:38%">'
           . $e($k) . '</td><td style="padding:9px 0;border-bottom:1px solid #eee;font-weight:bold">'
           . $e($v) . '</td></tr>';
}
$html .= '</table><p style="margin:18px 0 6px;color:#777;font-size:13px">Message</p>'
       . '<div style="background:#f8f8f8;border-left:3px solid #ED1C24;padding:12px 14px;'
       . 'font-size:14px;white-space:pre-wrap">' . $e($message !== '' ? $message : '—') . '</div>'
       . '</td></tr></table></body></html>';

$boundary = 'avon' . bin2hex(random_bytes(10));

$headers   = [];
$headers[] = 'From: ' . mb_encode_mimeheader($fromName) . ' <' . $fromAddr . '>';
$headers[] = 'Reply-To: ' . ($email !== ''
    ? mb_encode_mimeheader($name) . ' <' . $email . '>'
    : $fromAddr);
if (!empty($cfg['CONTACT_EMAIL_CC'])) {
    $headers[] = 'Cc: ' . $cfg['CONTACT_EMAIL_CC'];
}
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: multipart/alternative; boundary="' . $boundary . '"';
$headers[] = 'X-Mailer: Avon Fitness Maharashtra';

$body = "--$boundary\r\n"
      . "Content-Type: text/plain; charset=UTF-8\r\n"
      . "Content-Transfer-Encoding: 8bit\r\n\r\n" . $plain . "\r\n\r\n"
      . "--$boundary\r\n"
      . "Content-Type: text/html; charset=UTF-8\r\n"
      . "Content-Transfer-Encoding: 8bit\r\n\r\n" . $html . "\r\n\r\n"
      . "--$boundary--";

/* --------------------------------------------------------------------------
 |  Backup log (so nothing is lost if mail() is throttled)
 * ------------------------------------------------------------------------ */
if (!empty($cfg['LOG_ENQUIRIES'])) {
    $line = json_encode(
        $rows + ['Message' => $message],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    @file_put_contents(__DIR__ . '/enquiries.log', $line . PHP_EOL, FILE_APPEND | LOCK_EX);
}

$sent = @mail(
    $to,
    '=?UTF-8?B?' . base64_encode($subject) . '?=',
    $body,
    implode("\r\n", $headers),
    '-f' . $fromAddr
);

$_SESSION['avon_last_enquiry'] = time();

if ($sent) {
    out(true, 'Thank you — your enquiry has reached our team. We usually reply within one business day.');
}

out(
    false,
    'We could not send that just now. Please call ' . $cfg['CONTACT_PHONE']
    . ' or message us on WhatsApp and we will pick it up straight away.',
    500
);
