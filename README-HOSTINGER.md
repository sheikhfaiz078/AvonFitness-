# Deploying to Hostinger — Avon Fitness Maharashtra

This site is plain **HTML5 + CSS3 + vanilla JavaScript + PHP 8**.
No Node.js, no npm, no build step, no database, no Composer.

**Upload → extract → it works.**

---

## 1. Upload

1. Log in to **hPanel** at <https://hpanel.hostinger.com>
2. Open **Files → File Manager**
3. Enter the **`public_html`** folder
4. If `public_html` already has a default `index.html` or a parked-domain page,
   delete those files first
5. Click **Upload**, choose `AVON-FITNESS-MAHARASHTRA-WEBSITE.zip`
6. When the upload finishes, right-click the ZIP → **Extract** → extract **into
   `public_html`** (not into a subfolder)
7. Delete the ZIP once extraction is complete

After extracting, `public_html` should look like this — `index.php` must sit at
the **top level**, not inside another folder:

```
public_html/
├── index.php
├── .htaccess
├── favicon.ico
├── robots.txt
├── sitemap.xml
├── llms.txt
├── llms-full.txt
├── security.txt
├── humans.txt
├── site.webmanifest
├── 404.php
├── about/
├── accessories/
├── api/
├── assets/
├── blog/
├── cardio/
├── catalogue/
├── commercial-gym/
├── commercial-gym-solutions/
├── compare/
├── config/
├── contact/
├── data/
├── faqs/
├── gym-equipment-maharashtra/
├── home-gym/
├── includes/
├── installation/
├── outdoor-gym/
├── privacy-policy/
├── product/
├── products/
├── search/
├── sitemap/
├── strength/
├── support/
├── terms/
└── warranty/
```

> If you end up with `public_html/AVON-FITNESS.../index.php`, move everything up
> one level — the site will not work from a subfolder.

---

## 2. Set the PHP version

**hPanel → Advanced → PHP Configuration**

- Set PHP to **8.1 or newer** (8.2 / 8.3 recommended)
- On the **PHP extensions** tab make sure **`mbstring`** is enabled
  (it normally is by default)

---

## 3. Configure your contact details — ONE file

Everything the site shows — phone, WhatsApp, email, address, hours, social links
and the inbox that receives enquiries — lives in a single file:

**`public_html/config/site.php`**

Open it in File Manager (right-click → **Edit**), change the values, save.
Nothing else needs touching.

The values currently set are:

| Setting | Current value |
|---|---|
| `CONTACT_EMAIL` (enquiries go here) | `sales@pranadaequip.com` |
| `CONTACT_PHONE` | `+91 77189 22901` |
| `WHATSAPP_NUMBER` | `917718922901` |
| `EMAIL_FROM` | `website@avonfitnessmaharashtra.in` |
| `SOCIAL_FACEBOOK` | `https://www.facebook.com/AvonFitnessMaharashtra` |
| `SOCIAL_INSTAGRAM` | `https://www.instagram.com/avonfitnessmaharashtra/` |

### Important: `EMAIL_FROM` must be on your own domain

Hostinger (and every modern mail server) will reject or spam-folder mail that
claims to be *from* a Gmail/Yahoo address. Leave `EMAIL_FROM` as an address on
`avonfitnessmaharashtra.in` and create that mailbox in step 4.

`CONTACT_EMAIL` — the inbox that *receives* the enquiry — can be any address,
including Gmail.

---

## 4. Create the sending mailbox

**hPanel → Emails → Email Accounts → Create**

- Create **`website@avonfitnessmaharashtra.in`**
- This address only ever sends; you do not need to check it
- It must match `EMAIL_FROM` in `config/site.php`

While you are there, confirm **SPF** and **DKIM** are enabled for the domain
(hPanel → Emails → *your domain* → **DNS / Deliverability**). This is what keeps
enquiry emails out of the spam folder.

---

## 5. Enable HTTPS

**hPanel → Security → SSL**

1. Install the free **Let's Encrypt** certificate for
   `avonfitnessmaharashtra.in` and `www.avonfitnessmaharashtra.in`
2. Wait for the status to show **Active** (usually a few minutes)
3. Turn on **Force HTTPS** if hPanel offers it

The bundled `.htaccess` also redirects `http → https` and `www → non-www`, so
the canonical address is `https://avonfitnessmaharashtra.in`.

> Do this **after** the certificate is active. Forcing HTTPS before the
> certificate exists will make the site unreachable.

---

## 6. Add your social profiles (optional)

In `config/site.php`, fill in any of:

```php
'SOCIAL_FACEBOOK'  => 'https://www.facebook.com/yourpage',
'SOCIAL_INSTAGRAM' => 'https://www.instagram.com/yourpage',
'SOCIAL_YOUTUBE'   => 'https://www.youtube.com/@yourchannel',
'SOCIAL_LINKEDIN'  => 'https://www.linkedin.com/company/yourpage',
```

Facebook and Instagram are already set. Leave a value as `''` and that icon
simply does not appear, so YouTube and LinkedIn are hidden until you add them.

WhatsApp always shows and is built from `WHATSAPP_NUMBER` — there is no separate
URL to set.

**Only add profiles you have confirmed are official** — anything unverified was
left blank rather than guessed.

---

## 7. Test the site

Open `https://avonfitnessmaharashtra.in` and check:

- [ ] Homepage loads, hero and statistics animate
- [ ] Mega menu opens on desktop, drawer menu opens on mobile
- [ ] Search (magnifier icon, or press `/`) returns products
- [ ] `/products/` loads and the filters, sorting and paging work
- [ ] A product page loads, e.g. `/product/tm-1000-commercial-treadmill/`
- [ ] Product images appear
- [ ] Tick **Compare** on two products → the compare bar appears → `/compare/` works
- [ ] **Send the enquiry form a real test** — check the inbox in step 3
- [ ] WhatsApp buttons open a chat with the right number
- [ ] A bad URL such as `/no-such-page/` shows the custom 404
- [ ] `/sitemap.xml`, `/robots.txt` and `/llms.txt` all load

### Check it on an actual phone

- [ ] Logo sits left, search + menu sit hard right on the same line
- [ ] Nothing scrolls sideways on any page — swipe left/right, the page should not move
- [ ] `/products/` shows product cards within about one screen of scrolling
- [ ] Product photos fill their tiles without spilling over the edges
- [ ] The category strip under the page heading swipes sideways
- [ ] Search box is full width; the two filter dropdowns share one row
- [ ] The bottom bar (Call / WhatsApp / Get Quote) does not cover the filters
- [ ] The banner slider under the header changes every 5 seconds; dots and swipe work
- [ ] The red **Enquiry Now** tab on the right opens the popup form
- [ ] The product tabs on the home page (Treadmills, Cross Trainers…) switch the products shown
- [ ] Tap the hero dots and arrows — the carousel responds and keeps looping
- [ ] Open the menu, tap a category, confirm the drawer closes on navigation

### If the enquiry form does not arrive

1. Check spam/junk in the receiving inbox
2. Confirm the mailbox from step 4 exists and matches `EMAIL_FROM`
3. Every submission is also appended to **`public_html/api/enquiries.log`** as a
   backup — open it in File Manager to confirm the form itself is working
4. If the log has entries but no email arrives, the issue is mail delivery, not
   the website. Check SPF/DKIM in hPanel.

---

## 8. Submit to Google

1. Go to <https://search.google.com/search-console>
2. Add the property `https://avonfitnessmaharashtra.in`
3. Verify with the **DNS TXT record** method (add the record in
   hPanel → Domains → DNS Zone), or upload the HTML verification file to
   `public_html`
4. Open **Sitemaps** and submit: `sitemap.xml`
5. Use **URL Inspection → Request indexing** on the homepage to speed up the
   first crawl

Do the same at <https://www.bing.com/webmasters> — Bing feeds Copilot, and
`llms.txt` / `llms-full.txt` help AI answer engines describe the business
correctly.

---

## 9. Keeping the site up to date

| I want to change… | Edit this |
|---|---|
| Phone, WhatsApp, email, address, hours, social | `config/site.php` |
| Anything in the header or navigation | `includes/header.php` |
| Anything in the footer | `includes/footer.php` |
| Colours, spacing, typography | `assets/css/main.css` (tokens at the top) |
| Product data (names, specs, descriptions) | `data/products.json` |
| Blog articles | `data/articles.json` |
| Home page banner slides (text, links, machines) | `$slides` near the top of `index.php` |
| Banner slider speed | `data-interval` on the slider in `index.php` (milliseconds) |
| Home page banner photos / partner logos | see section 9a below |
| A product's photograph | replace the `.webp` in `assets/images/products/…` |

### Adding a new product

1. Add an object to `data/products.json` (copy an existing one as a template)
2. Create the folder `product/<your-slug>/` containing a file `index.php` with:

   ```php
   <?php
   $SLUG = 'your-slug';
   require dirname(__DIR__, 2) . '/includes/tpl-product.php';
   ```

3. Put the photo at the path given by the `image` field, as a `.webp`
4. Add the URL to `sitemap.xml`

---

## 9a. Home page banners and partner logos

The home page banners are drawn in HTML/CSS from the product photos, so they
look sharp on every screen and need no image files. You can replace any of them
with your own artwork. No code changes are needed.

Upload the image to **`public_html/assets/images/home/`** using these exact file
names (`.webp`, `.jpg` or `.png`):

| File name | Replaces |
|---|---|
| `slide-1` | Banner slide 1 (Molten Series) |
| `slide-2` | Banner slide 2 (Commercial treadmills) |
| `slide-3` | Banner slide 3 (Home gym) |
| `banner-run` | The rounded treadmill banner under the category cards |
| `banner-products` | The full-width "products to choose from" banner |

For a different crop on phones, also upload `<name>-mobile.webp`, for example
`slide-1-mobile.webp`. Recommended sizes are 1920 x 860 px for slides, 1100 x 470
px for `banner-run` and 1920 x 840 px for `banner-products`.

**Partner logos:** upload logo files to **`public_html/assets/images/partners/`**.
The section heading changes to **"Our Fitness Partners"** and the logos appear
automatically. The alt text comes from the file name, so name each file after the
organisation, for example `gail-india-limited.png`. Prefix a number to set the
order, for example `01-gail-india-limited.png`. While the folder is empty, the
section shows the kinds of facility you equip instead. Only add logos you have
permission to show.

The transparent product cut-outs used in the banners live in
`assets/images/home/cut/`.

## 10. Security notes

- `config/`, `includes/` and `api/enquiries.log` are blocked by `.htaccess` and
  cannot be fetched over the web
- The enquiry form validates everything server-side and protects against mail
  header injection, cross-site posting, bots (honeypot + timing trap) and rapid
  repeat submissions
- No passwords, API keys or credentials are stored anywhere in these files
- There are no third-party tracking scripts

### Adding Google Analytics later

Paste your tag just before `</head>` in **`includes/header.php`** — it applies
to every page at once. If you do, add a cookie notice and update
`privacy-policy/index.php`, which currently states that the site sets no
tracking cookies.

---

## Troubleshooting

**Blank white page**
PHP version is too old, or `mbstring` is off. See step 2.

**"500 Internal Server Error" on every page**
Rename `.htaccess` to `.htaccess.bak` and reload. If the site comes back, your
server is missing a module the file references — restore it and remove the
block that caused it (each block is wrapped in `<IfModule>`, so this is rare).

**Styles missing / page looks like plain text**
`assets/` did not extract. Confirm `assets/css/main.css` exists in File Manager.

**Product images missing**
Confirm `assets/images/products/` extracted with its subfolders. Some ZIP
extractors skip deep folder trees — re-extract if needed.

**Pages work but URLs need `/index.php` on the end**
`.htaccess` did not upload. It starts with a dot, so File Manager may hide it —
enable **Show hidden files** in the File Manager settings and re-upload.
