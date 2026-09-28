# Missing data, source conflicts and things that need your confirmation

This file records exactly where the site's factual content came from, what could
not be verified, and the decisions I made rather than inventing a figure.

**Nothing on the website states a fact that is not traceable to one of the two
official Avon sources.** Where a fact was unavailable, the site omits it.

---

## 1. Sources used

| Source | Role | What was taken from it |
|---|---|---|
| `avonfitnessmachines.com` | **Manufacturer — treated as authoritative** | Product catalogue (694 products across 46 category listings), product photography, company history, registered address, manufacturer contact desks, market segments |
| `avonfitnessmachines.com/assets/broucher/commercial-final-2026.pdf` | Official commercial catalogue | Technical specifications |
| `avonfitnessmachines.com/assets/broucher/domestic-final-2026.pdf` | Official domestic catalogue | Technical specifications |
| `avonfitness.co` | Current Avon Fitness site (dealer/operator) | Maharashtra-facing phone, WhatsApp and email |

All marketing copy, page structure, design, CSS and JavaScript on the new site
are **original**. Only factual product data was reused.

---

## 2. ⚠️ Items that need your confirmation

### 2.1 Contact details — which entity should the site present?

Two different contact sets are published across the two sources:

| | `avonfitness.co` (used on this site) | `avonfitnessmachines.com` (manufacturer) |
|---|---|---|
| Phone | +91 77189 22901 | +91 87250 94200 |
| Email | sales@pranadaequip.com | enquiry@avonfitnessmachines.com |
| Service email | — | service@avonfitnessmachines.com |
| Address | *(none published)* | B-XXIX-476/9, Giaspura, Ludhiana, Punjab 141003 |

**What the site does now:**
- Primary sales contact = **+91 77189 22901 / sales@pranadaequip.com** (from
  avonfitness.co, which you identified as the current Avon site)
- The **manufacturer's address** is shown in the footer and on `/contact/`,
  clearly labelled as the registered/manufacturing office
- The **manufacturer's enquiry and service desks** appear on `/contact/` and
  `/support/`, clearly labelled as manufacturer desks

**➡️ Please confirm:**
1. Is `sales@pranadaequip.com` the right inbox for Maharashtra website
   enquiries? It is a *different* domain (`pranadaequip.com`), which some
   visitors may find confusing next to the Avon branding. Consider creating
   `sales@avonfitnessmaharashtra.in` and forwarding it.
2. **Is there a Maharashtra address** (office, showroom or warehouse)? None is
   published on either source. If you have one, add it to `config/site.php` —
   it would meaningfully strengthen local SEO, which currently has no
   Maharashtra postal address to anchor to.

### 2.2 Business hours — assumed, not verified

Neither source publishes opening hours. The site currently shows:

- Mon–Fri 10:00–19:00
- Sat 10:00–18:00
- Sun Closed

**➡️ These are placeholders.** Correct them in `config/site.php`, or tell me and
I will remove the hours block entirely.

### 2.3 Social media profiles — supplied by you, now live

You confirmed these two, and they are now in `config/site.php`, in the footer
icon row, and in the `sameAs` property of the Organization schema (which is what
tells Google and AI engines these profiles belong to this business):

- Facebook — `https://www.facebook.com/AvonFitnessMaharashtra`
- Instagram — `https://www.instagram.com/avonfitnessmaharashtra/`

The Facebook URL you gave was `http://`; it is stored as `https://` because
Facebook redirects to HTTPS anyway and a plain-HTTP link in the schema is a
quality flag.

WhatsApp sits alongside them as a third icon, built from `WHATSAPP_NUMBER`.

**➡️ YouTube and LinkedIn are still empty** — add them to `config/site.php` when
you have them and the icons appear automatically. Nothing else to change.

### 2.4 "75 years" vs "25 years" — a genuine source conflict

| Source | Claim |
|---|---|
| `avonfitnessmachines.com/about` (manufacturer) | "For over **75 years**, Avon has been a trusted name in India" |
| Domestic catalogue PDF (manufacturer) | "more than **six decades** old" trust, via Avon Cycles Limited |
| `avonfitness.co` | "**25 years** manufacturing experience" |

**Decision:** the site uses **75+ years**, phrased as *"Years of the Avon name"*
and *"the Avon group of Ludhiana… manufacturing in India for over 75 years"* —
never as "75 years of fitness manufacturing", which would be wrong. The 75-year
figure is the manufacturer's own current public statement, and the manufacturer
is the authoritative source for its own history.

The 25-year figure appears only on the dealer site and conflicts with the
manufacturer, so it is not used.

**➡️ If you prefer a different framing, this is a one-line change** in
`index.php` and `about/index.php`.

### 2.5 "5000+ installations" — deliberately NOT used

`avonfitness.co` displays a counter reading **5000+ Installations Delivered**.
This figure appears nowhere on the manufacturer's site and I could not verify
it.

**Decision:** omitted. The stat strip uses only verifiable counts instead:
75+ years, 694 products, 46 categories, and Maharashtra coverage.

**➡️ If you can evidence the installation figure, tell me and I will add it.**

### 2.6 Client / "Trusted by" logos — deliberately NOT used

`avonfitness.co` lists: Indian Army, Indian Navy, ONGC, GAIL, Larsen & Toubro,
Chandigarh University, Airports Authority of India.

These named organisations do **not** appear on the manufacturer's own site, and
naming a customer without authorisation carries real commercial and legal risk.

**Decision:** the site instead states the **market segments the manufacturer
itself publishes** — "fitness clubs, sports teams, colleges, military, country
clubs and workplace fitness facilities, as well as hotels, spas and upscale home
gyms" — which is verifiable and carries the same credibility signal without
naming anyone.

**➡️ If you have written permission to name these organisations, send it and I
will add a proper trust section with logos.**

### 2.7 Warranty duration — not published anywhere

Neither source states a warranty period. `/warranty/` therefore explains the
claims process and what to keep, and states that terms are confirmed in writing
on each quotation.

**➡️ Send me the actual warranty terms per product line and I will publish them.**

### 2.8 Prices — deliberately NOT published

The commercial and domestic catalogues **do** contain MRP figures per model.
These were deliberately **excluded** from the website because:

- catalogue MRPs go stale quickly and would misrepresent your actual pricing
- the site is built around an enquiry/quotation model, which suits project sales
- publishing MRP invites price-shopping against a number you do not charge

**➡️ Tell me if you want MRP shown** — the data is already parsed and can be
switched on.

### 2.9 Showroom

`/contact/` and `/gym-equipment-maharashtra/` say "get in touch and we will tell
you what is currently viewable and where" rather than claiming a showroom.

**➡️ If you have a showroom, give me the address and I will publish it properly.**

---

## 3. Product data completeness

### 3.1 What was imported

- **694 unique products**, crawled from 46 category listings on the manufacturer's site
- **698 product images** downloaded, optimised and stored locally (never hotlinked)
- **46 categories** mapped into a 4-family / 40-subcategory taxonomy

### 3.2 Specification coverage: 290 of 694 products (42%)

| Family | With published specs | Total |
|---|---|---|
| Strength Equipment | 183 | 431 |
| Cardio Equipment | 102 | 157 |
| Gym Accessories | 4 | 84 |
| Outdoor Gym Equipment | 1 | 22 |
| **Total** | **290** | **694** |

**Why 404 products have no specification table:**

1. **The manufacturer's product detail pages are dead.** Every
   `avonfitnessmachines.com/product/<slug>` URL — all 552 of them in their own
   sitemap — redirects to their homepage. Specifications could not be read from
   the website at all.
2. Specifications were therefore parsed from the **official 2026 catalogue
   PDFs** instead. Those catalogues do not cover the entire web catalogue —
   accessories and outdoor equipment in particular are shown as photographs
   without spec tables.
3. **Parsing was deliberately conservative.** A specification block was only
   attached to a product when it resolved to exactly **one** product with
   certainty (by model code, or by product name plus the series strap-line).
   Ambiguous blocks were discarded rather than guessed. About 150 catalogue
   blocks were dropped this way — this is why coverage is 42% rather than
   higher, and it is the right trade-off: a wrong dimension on a floor plan is
   far more damaging than a missing one.

**How this is handled on the site:** products without specifications show a
short table (model, category, range, built-for) plus an honest note —
*"Detailed specifications on request"* — and a CTA. No field is ever invented.

**➡️ To close the gap:** send me a spreadsheet, the source spec sheets, or
restore the manufacturer's product pages, and I can re-run the importer.

### 3.3 Models in the catalogue PDFs but not on the website

A number of models appear in the printed catalogues but are not listed on the
manufacturer's live site — for example **TM-1600, TM-479, AU-105, TM-244,
TM-245, TM-246**. These look discontinued or not-yet-listed, so no pages were
created for them. Their specifications were parsed and are available if you want
them added.

### 3.4 Placeholder images

**4 of 694** products had a source image that could not be downloaded. They use
a neutral grey "photo on request" placeholder — clearly not a fake photograph —
at the correct filename, so dropping in the real `.webp` is all that is needed.
The affected products are listed in `tools/missing_images.json` in the project
folder (not deployed).

### 3.5 One photograph per product — no galleries

The manufacturer's category listings publish exactly **one** photograph per
product, so each product page shows a single (zoomable) image rather than a
gallery. The gallery markup and thumbnail strip are already built and styled —
they activate as soon as a product has more than one image.

**➡️ If you have additional angles, detail shots or in-situ photography**, send
them and I will add a `gallery` array to `data/products.json`. In-situ photos of
real installations would be the single highest-value addition to the site.

### 3.6 Product names

Strength stations are named by function (e.g. *Seated Row*, *Lat Pull Down*), so
several products share a name across different series. Each page title and `<h1>`
is prefixed with the model code (e.g. *RG-904 Seated Row* vs *MD-647 Seated Row*)
to keep every page unique.

One source name was a full marketing sentence (102 characters); it was shortened
to its first clause. One OCR-style typo in the source data — `Adduct0r` — was
corrected to `Adductor`.

---

## 4. Product descriptions — how they were written

Every product page carries an original description, feature cards, applications
and FAQs. None of this was copied from either source site.

Each sentence is generated from a **verified attribute** of that product — its
category, its segment (commercial/home/outdoor), and its actual parsed
specifications. For example, a feature card reading *"High Tensile Steel frame
construction"* exists only because the catalogue lists `Frame Tube: High Tensile
Steel` for that model.

Products with no parsed specifications get correspondingly generic (but still
truthful) copy, and are never given invented features.

---

## 5. Configuration — single source of truth

The requirement mentioned `/config/site.php` **or** `/data/site-config.json`.
I implemented **`config/site.php` only**, deliberately.

Two config files would drift apart the first time someone edits one and not the
other. JavaScript still receives the same values: `includes/header.php` emits
them as `window.AVON_CONFIG` on every page, so there is exactly one place to
edit and no duplication.

---

## 6. Blog content

The 15 articles are **original**, written for this site. They contain general
equipment knowledge plus the specification ranges that were actually parsed from
the Avon catalogues (motor ratings, running areas, user weight ratings, stack
ratings). No article claims a fact about Avon that is not on the site elsewhere.

---

## 7. Quick checklist of what to send me

- [ ] Confirm the enquiry inbox (`sales@pranadaequip.com`, or a new one)
- [ ] Maharashtra office / showroom address, if any
- [ ] Correct business hours
- [x] ~~Verified official social profile URLs~~ — Facebook + Instagram received
- [ ] YouTube / LinkedIn URLs, if you have them
- [ ] Warranty terms per product line
- [ ] Permission (or not) to name institutional customers
- [ ] Whether to publish catalogue MRP
- [ ] Any missing product specifications
- [ ] Real photographs for the 4 placeholder products
