/* ==========================================================================
   AVON FITNESS MAHARASHTRA — catalogue engine
   Powers the product grids, filters, sorting, site search and comparison.
   Reads data/catalog.json (a slim index — the full products.json is four
   times the size and carries copy the browser never needs). Every listing page
   is also pre-rendered in HTML, so it is useful and indexable before this runs.
   ========================================================================== */
(function () {
  'use strict';

  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var esc = window.avonEsc || function (s) { return String(s == null ? '' : s); };
  var BASE = document.documentElement.getAttribute('data-base') || '';
  var PER_PAGE = 24;

  var host = $('[data-catalog]');
  if (!host) return;

  var state = {
    q: '', family: '', sub: '', segment: '', sort: 'featured', page: 1, items: []
  };

  /* preset scope from the page (e.g. a category page pins family/sub) */
  var scope = {
    family: host.getAttribute('data-family') || '',
    sub: host.getAttribute('data-sub') || '',
    segment: host.getAttribute('data-segment') || ''
  };

  var params = new URLSearchParams(window.location.search);
  state.q = params.get('q') || '';
  state.family = params.get('family') || '';
  state.sub = params.get('sub') || '';
  state.segment = params.get('segment') || '';
  state.sort = params.get('sort') || 'featured';
  state.page = Math.max(1, parseInt(params.get('page') || '1', 10));

  var grid = $('[data-catalog-grid]');
  var countEl = $('[data-catalog-count]');
  var pager = $('[data-catalog-pager]');
  var qInput = $('[data-catalog-q]');
  var sortSel = $('[data-catalog-sort]');
  var subSel = $('[data-catalog-sub]');

  if (qInput) qInput.value = state.q;
  if (sortSel) sortSel.value = state.sort;

  (window.avonCatalogue ? window.avonCatalogue() :
    fetch(BASE + 'data/catalog.json').then(function (r) { return r.json(); }))
    .then(function (items) {
      state.items = items || [];
      buildSubOptions();
      syncChips();
      render();
    })
    .catch(function () {
      if (grid && !grid.children.length) {
        grid.innerHTML = '<div class="empty"><h3>Catalogue unavailable</h3>' +
          '<p>We could not load the product list. Please refresh, or ' +
          '<a class="ulink" href="' + BASE + 'contact/">contact our team</a> ' +
          'and we will send the catalogue directly.</p></div>';
      }
    });

  function match(p) {
    if (scope.family && p.family !== scope.family) return false;
    if (scope.sub && p.subcategory_slug !== scope.sub &&
      (p.all_subcategories || []).indexOf(scope.sub) === -1) return false;
    if (scope.segment && p.segment !== scope.segment && p.segment !== 'both') return false;

    if (state.family && p.family !== state.family) return false;
    if (state.sub && p.subcategory_slug !== state.sub &&
      (p.all_subcategories || []).indexOf(state.sub) === -1) return false;
    if (state.segment && p.segment !== state.segment && p.segment !== 'both') return false;

    if (state.q) {
      var q = state.q.toLowerCase();
      var hay = (p.product_name + ' ' + p.model_number + ' ' + p.subcategory + ' ' +
        p.category + ' ' + p.short_description).toLowerCase();
      if (hay.indexOf(q) === -1) return false;
    }
    return true;
  }

  function sorted(list) {
    var l = list.slice();
    if (state.sort === 'name') {
      l.sort(function (a, b) { return a.product_name.localeCompare(b.product_name); });
    } else if (state.sort === 'model') {
      l.sort(function (a, b) { return (a.model_number || 'zzz').localeCompare(b.model_number || 'zzz'); });
    } else if (state.sort === 'spec') {
      l.sort(function (a, b) {
        return Object.keys(b.specifications || {}).length - Object.keys(a.specifications || {}).length;
      });
    } else {
      /* featured: documented models first, then alphabetical */
      l.sort(function (a, b) {
        var sa = Object.keys(a.specifications || {}).length ? 1 : 0;
        var sb = Object.keys(b.specifications || {}).length ? 1 : 0;
        if (sa !== sb) return sb - sa;
        return a.product_name.localeCompare(b.product_name);
      });
    }
    return l;
  }

  function cardHTML(p) {
    var tag = p.segment === 'commercial' ? 'Commercial'
      : p.segment === 'home' ? 'Home'
        : p.segment === 'outdoor' ? 'Outdoor' : 'Commercial & Home';
    return '<article class="card">' +
      '<div class="card__media">' +
      '<img src="' + BASE + esc(p.image) + '" alt="' + esc(p.image_alt) +
      '" loading="lazy" decoding="async" width="400" height="400">' +
      '<span class="card__tag' + (p.segment === 'commercial' ? ' card__tag--red' : '') + '">' +
      esc(tag) + '</span>' +
      '<span class="card__cmp"><label class="cmp-box"><input type="checkbox" value="' +
      esc(p.slug) + '" aria-label="Compare ' + esc(p.product_name) + '">Compare</label></span>' +
      '</div>' +
      '<div class="card__body">' +
      (p.model_number ? '<span class="card__model">' + esc(p.model_number) + '</span>' : '') +
      '<h3 class="card__name">' + esc(p.product_name) + '</h3>' +
      '<p class="card__desc">' + esc(p.short_description) + '</p>' +
      '<div class="card__foot"><span class="card__cat">' + esc(p.subcategory) + '</span>' +
      '<span class="card__go">View' +
      '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>' +
      '</span></div></div>' +
      '<a class="card__link" href="' + BASE + 'product/' + esc(p.slug) + '/">' +
      '<span class="sr-only">' + esc(p.product_name) + '</span></a>' +
      '</article>';
  }

  function render() {
    var list = sorted(state.items.filter(match));
    var total = list.length;
    var pages = Math.max(1, Math.ceil(total / PER_PAGE));
    if (state.page > pages) state.page = pages;
    var start = (state.page - 1) * PER_PAGE;
    var slice = list.slice(start, start + PER_PAGE);

    if (countEl) {
      countEl.innerHTML = total
        ? 'Showing <b>' + (start + 1) + '–' + (start + slice.length) + '</b> of <b>' + total + '</b> products'
        : 'No products matched';
    }

    if (grid) {
      // The grid is a reveal container; guarantee it is revealed before we put
      // cards in it, otherwise a missed observer leaves the products invisible.
      grid.classList.add('is-in');
      grid.innerHTML = slice.length ? slice.map(cardHTML).join('') :
        '<div class="empty"><h3>Nothing matched those filters</h3>' +
        '<p>Try a broader category, or search by model number such as TM-1000.</p>' +
        '<p><button class="btn btn--ghost btn--sm" type="button" data-catalog-clear>Clear filters</button></p></div>';
    }

    if (pager) {
      pager.innerHTML = pages > 1 ? pagerHTML(pages) : '';
    }

    if (window.avonCompare) {
      var sel = window.avonCompare.get();
      $$('.cmp-box input', grid).forEach(function (cb) {
        cb.checked = sel.indexOf(cb.value) > -1;
      });
    }
    writeURL();
  }

  function pagerHTML(pages) {
    var out = '<button type="button" data-page="' + (state.page - 1) + '"' +
      (state.page === 1 ? ' disabled' : '') + ' aria-label="Previous page">&larr;</button>';
    var from = Math.max(1, state.page - 2), to = Math.min(pages, from + 4);
    from = Math.max(1, Math.min(from, to - 4));
    if (from > 1) out += '<button type="button" data-page="1">1</button>' +
      (from > 2 ? '<button type="button" disabled>…</button>' : '');
    for (var i = from; i <= to; i++) {
      out += '<button type="button" data-page="' + i + '"' +
        (i === state.page ? ' aria-current="true"' : '') + '>' + i + '</button>';
    }
    if (to < pages) out += (to < pages - 1 ? '<button type="button" disabled>…</button>' : '') +
      '<button type="button" data-page="' + pages + '">' + pages + '</button>';
    out += '<button type="button" data-page="' + (state.page + 1) + '"' +
      (state.page === pages ? ' disabled' : '') + ' aria-label="Next page">&rarr;</button>';
    return out;
  }

  function writeURL() {
    var p = new URLSearchParams();
    if (state.q) p.set('q', state.q);
    if (state.family) p.set('family', state.family);
    if (state.sub) p.set('sub', state.sub);
    if (state.segment) p.set('segment', state.segment);
    if (state.sort && state.sort !== 'featured') p.set('sort', state.sort);
    if (state.page > 1) p.set('page', state.page);
    var qs = p.toString();
    history.replaceState(null, '', window.location.pathname + (qs ? '?' + qs : ''));
  }

  function buildSubOptions() {
    if (!subSel) return;
    var seen = {}, opts = [];
    state.items.forEach(function (p) {
      if (scope.family && p.family !== scope.family) return;
      if (state.family && p.family !== state.family) return;
      if (!seen[p.subcategory_slug]) {
        seen[p.subcategory_slug] = 1;
        opts.push({ slug: p.subcategory_slug, name: p.subcategory });
      }
    });
    opts.sort(function (a, b) { return a.name.localeCompare(b.name); });
    subSel.innerHTML = '<option value="">All equipment types</option>' +
      opts.map(function (o) {
        return '<option value="' + esc(o.slug) + '"' +
          (o.slug === state.sub ? ' selected' : '') + '>' + esc(o.name) + '</option>';
      }).join('');
  }

  function syncChips() {
    $$('[data-filter]').forEach(function (b) {
      var k = b.getAttribute('data-filter'), v = b.getAttribute('data-value');
      b.setAttribute('aria-pressed', String(state[k] === v));
    });
  }

  /* ---------- events ---------------------------------------------------- */
  var qTimer;
  if (qInput) {
    qInput.addEventListener('input', function () {
      clearTimeout(qTimer);
      qTimer = setTimeout(function () {
        state.q = qInput.value.trim(); state.page = 1; render();
      }, 200);
    });
  }
  if (sortSel) sortSel.addEventListener('change', function () { state.sort = sortSel.value; state.page = 1; render(); });
  if (subSel) subSel.addEventListener('change', function () { state.sub = subSel.value; state.page = 1; render(); });

  document.addEventListener('click', function (e) {
    var chip = e.target.closest('[data-filter]');
    if (chip) {
      var k = chip.getAttribute('data-filter'), v = chip.getAttribute('data-value');
      state[k] = state[k] === v ? '' : v;
      if (k === 'family') { state.sub = ''; buildSubOptions(); }
      state.page = 1; syncChips(); render();
      return;
    }
    if (e.target.closest('[data-catalog-clear]')) {
      state.q = ''; state.family = ''; state.sub = ''; state.segment = '';
      state.sort = 'featured'; state.page = 1;
      if (qInput) qInput.value = '';
      if (sortSel) sortSel.value = 'featured';
      buildSubOptions(); syncChips(); render();
      return;
    }
    var pg = e.target.closest('[data-page]');
    if (pg && !pg.disabled) {
      state.page = parseInt(pg.getAttribute('data-page'), 10) || 1;
      render();
      var top = host.getBoundingClientRect().top + window.pageYOffset - 100;
      window.scrollTo({ top: top, behavior: 'smooth' });
    }
  });

  /* ---------- comparison table ------------------------------------------ */
  var cmpHost = $('[data-compare-table]');
  if (cmpHost) {
    var want = (params.get('p') || '').split(',').filter(Boolean);
    if (!want.length && window.avonCompare) want = window.avonCompare.get();
    (window.avonCatalogue ? window.avonCatalogue() :
      fetch(BASE + 'data/catalog.json').then(function (r) { return r.json(); }))
      .then(function (all) {
        var picked = want.map(function (s) {
          return all.filter(function (p) { return p.slug === s; })[0];
        }).filter(Boolean).slice(0, 4);

        if (!picked.length) {
          cmpHost.innerHTML = '<div class="empty"><h3>No products selected</h3>' +
            '<p>Tick “Compare” on any product card to line equipment up side by side — ' +
            'up to four at a time.</p><p><a class="btn btn--ghost btn--sm" href="' +
            BASE + 'products/">Browse equipment</a></p></div>';
          return;
        }

        var rows = ['Model', 'Category', 'Equipment Type', 'Built For'];
        picked.forEach(function (p) {
          Object.keys(p.specifications || {}).forEach(function (k) {
            if (rows.indexOf(k) === -1) rows.push(k);
          });
        });

        var html = '<div class="cmp-table-wrap"><table class="cmp-table"><thead><tr><th>Specification</th>' +
          picked.map(function (p) {
            return '<th><a href="' + BASE + 'product/' + esc(p.slug) + '/">' +
              esc(p.product_name) + '</a></th>';
          }).join('') + '</tr></thead><tbody>' +
          '<tr><th>Photo</th>' + picked.map(function (p) {
            return '<td><img src="' + BASE + esc(p.image) + '" alt="' + esc(p.image_alt) +
              '" loading="lazy" width="150" height="150" style="width:130px;height:130px;object-fit:contain"></td>';
          }).join('') + '</tr>';

        rows.forEach(function (key) {
          var vals = picked.map(function (p) {
            if (key === 'Model') return p.model_number || '—';
            if (key === 'Category') return p.category;
            if (key === 'Equipment Type') return p.subcategory;
            if (key === 'Built For') {
              return p.segment === 'both' ? 'Commercial & home'
                : p.segment.charAt(0).toUpperCase() + p.segment.slice(1) + ' use';
            }
            return (p.specifications || {})[key] || '—';
          });
          if (vals.every(function (v) { return v === '—'; })) return;
          html += '<tr><th>' + esc(key) + '</th>' +
            vals.map(function (v) { return '<td>' + esc(v) + '</td>'; }).join('') + '</tr>';
        });

        html += '<tr><th>Enquire</th>' + picked.map(function (p) {
          return '<td><a class="btn btn--sm" href="' + BASE + 'contact/?product=' +
            encodeURIComponent(p.model_number || p.product_name) + '">Get a quote</a></td>';
        }).join('') + '</tr>';
        html += '</tbody></table></div>';
        cmpHost.innerHTML = html;
      });
  }
})();
