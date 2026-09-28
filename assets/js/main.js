/* ==========================================================================
   AVON FITNESS MAHARASHTRA — site interactions
   Vanilla JS, no dependencies. Everything degrades to a working page if JS
   fails, and every motion path checks prefers-reduced-motion.
   ========================================================================== */
(function () {
  'use strict';

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

  /* ---------- site config (shared with the PHP layer) ------------------- */
  var CFG = window.AVON_CONFIG || {};
  var BASE = (document.documentElement.getAttribute('data-base') || '');

  function waLink(text) {
    var n = (CFG.whatsapp || '').replace(/[^0-9]/g, '');
    return 'https://wa.me/' + n + '?text=' + encodeURIComponent(text ||
      'Hello Avon Fitness, I would like a quote for gym equipment.');
  }
  window.avonWaLink = waLink;

  /* ---------- 1. Header ------------------------------------------------- */
  var hdr = $('.hdr');
  var lastY = 0;
  function onScroll() {
    var y = window.pageYOffset;
    if (hdr) hdr.classList.toggle('is-stuck', y > 8);
    var top = $('.to-top');
    if (top) top.classList.toggle('is-on', y > 700);
    var bar = $('.progress');
    if (bar) {
      var h = document.documentElement.scrollHeight - window.innerHeight;
      bar.style.width = (h > 0 ? (y / h) * 100 : 0) + '%';
    }
    lastY = y;
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- 2. Mega menu ---------------------------------------------- */
  var megaTimer;
  $$('[data-mega]').forEach(function (trigger) {
    var panel = document.getElementById(trigger.getAttribute('data-mega'));
    if (!panel) return;
    var host = trigger.closest('.hdr');

    function open() {
      clearTimeout(megaTimer);
      $$('.mega.is-open').forEach(function (m) {
        if (m !== panel) { m.classList.remove('is-open'); }
      });
      $$('[data-mega][aria-expanded="true"]').forEach(function (t) {
        if (t !== trigger) t.setAttribute('aria-expanded', 'false');
      });
      panel.classList.add('is-open');
      trigger.setAttribute('aria-expanded', 'true');
    }
    function close(delay) {
      clearTimeout(megaTimer);
      megaTimer = setTimeout(function () {
        panel.classList.remove('is-open');
        trigger.setAttribute('aria-expanded', 'false');
      }, delay || 0);
    }

    trigger.addEventListener('mouseenter', open);
    trigger.addEventListener('focus', open);
    trigger.addEventListener('click', function (e) {
      e.preventDefault();
      panel.classList.contains('is-open') ? close() : open();
    });
    trigger.addEventListener('mouseleave', function () { close(220); });
    panel.addEventListener('mouseenter', function () { clearTimeout(megaTimer); });
    panel.addEventListener('mouseleave', function () { close(160); });
    if (host) {
      host.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { close(); trigger.focus(); }
      });
    }
  });
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.hdr')) {
      $$('.mega.is-open').forEach(function (m) { m.classList.remove('is-open'); });
      $$('[data-mega]').forEach(function (t) { t.setAttribute('aria-expanded', 'false'); });
    }
  });

  /* ---------- 3. Mobile nav --------------------------------------------- */
  var mnav = $('.mnav');
  var burger = $('.burger');
  function setNav(open) {
    if (!mnav) return;
    mnav.classList.toggle('is-open', open);
    if (burger) burger.setAttribute('aria-expanded', String(open));
    document.body.style.overflow = open ? 'hidden' : '';
    if (open) {
      $$('.mnav__list > li', mnav).forEach(function (li, i) {
        li.style.animationDelay = (0.05 + i * 0.045) + 's';
      });
      var first = $('.mnav__close', mnav);
      if (first) first.focus();
    }
  }
  if (burger) burger.addEventListener('click', function () { setNav(!mnav.classList.contains('is-open')); });
  $$('[data-close-nav]').forEach(function (b) { b.addEventListener('click', function () { setNav(false); }); });
  if (mnav) {
    $$('.mnav__sub a', mnav).forEach(function (a) { a.addEventListener('click', function () { setNav(false); }); });
    $$('[data-mtoggle]', mnav).forEach(function (btn) {
      btn.addEventListener('click', function () {
        var sub = document.getElementById(btn.getAttribute('data-mtoggle'));
        if (!sub) return;
        var open = sub.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', String(open));
      });
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && mnav && mnav.classList.contains('is-open')) setNav(false);
  });

  /* ---------- 4. Search overlay ----------------------------------------- */
  var sbox = $('.searchbox');
  var sInput = $('#site-search');
  var sResults = $('#search-results');
  var catalogue = null;

  function loadCatalogue() {
    if (catalogue) return Promise.resolve(catalogue);
    return fetch(BASE + 'data/catalog.json')
      .then(function (r) { return r.json(); })
      .then(function (d) { catalogue = d; return d; })
      .catch(function () { catalogue = []; return catalogue; });
  }
  window.avonCatalogue = loadCatalogue;

  function openSearch() {
    if (!sbox) return;
    sbox.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    loadCatalogue();
    setTimeout(function () { if (sInput) sInput.focus(); }, 60);
  }
  function closeSearch() {
    if (!sbox) return;
    sbox.classList.remove('is-open');
    document.body.style.overflow = '';
  }
  $$('[data-search-open]').forEach(function (b) { b.addEventListener('click', openSearch); });
  $$('[data-search-close]').forEach(function (b) { b.addEventListener('click', closeSearch); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeSearch();
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
    if (e.key === '/' && !/^(INPUT|TEXTAREA|SELECT)$/.test(document.activeElement.tagName)) {
      e.preventDefault(); openSearch();
    }
  });
  if (sbox) sbox.addEventListener('click', function (e) { if (e.target === sbox) closeSearch(); });

  function scoreMatch(p, q) {
    var hay = (p.product_name + ' ' + p.model_number + ' ' + p.subcategory + ' ' +
      p.category + ' ' + p.segment).toLowerCase();
    if (hay.indexOf(q) === -1) return 0;
    var s = 1;
    if ((p.model_number || '').toLowerCase().indexOf(q) === 0) s += 10;
    if (p.product_name.toLowerCase().indexOf(q) === 0) s += 6;
    if (p.product_name.toLowerCase().indexOf(q) > -1) s += 3;
    return s;
  }

  var sTimer;
  if (sInput) {
    sInput.addEventListener('input', function () {
      clearTimeout(sTimer);
      sTimer = setTimeout(function () {
        var q = sInput.value.trim().toLowerCase();
        if (!sResults) return;
        if (q.length < 2) { sResults.innerHTML = ''; return; }
        loadCatalogue().then(function (items) {
          var hits = items.map(function (p) { return { p: p, s: scoreMatch(p, q) }; })
            .filter(function (x) { return x.s > 0; })
            .sort(function (a, b) { return b.s - a.s; })
            .slice(0, 12);
          if (!hits.length) {
            sResults.innerHTML = '<p class="searchbox__hint">No equipment matched “' +
              esc(q) + '”. Try a model number such as TM-1000, or a category like treadmill.</p>';
            return;
          }
          sResults.innerHTML = hits.map(function (x) {
            var p = x.p;
            return '<a class="sresult" href="' + BASE + 'product/' + p.slug + '/">' +
              '<img src="' + BASE + p.image + '" alt="" loading="lazy" width="52" height="52">' +
              '<span><span class="sresult__name">' + esc(p.product_name) + '</span><br>' +
              '<span class="sresult__meta">' + esc(p.model_number || p.subcategory) +
              ' · ' + esc(p.subcategory) + '</span></span></a>';
          }).join('');
        });
      }, 140);
    });
    var sform = sInput.closest('form');
    if (sform) {
      sform.addEventListener('submit', function (e) {
        e.preventDefault();
        var q = sInput.value.trim();
        if (q) window.location.href = BASE + 'search/?q=' + encodeURIComponent(q);
      });
    }
  }

  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }
  window.avonEsc = esc;

  /* ---------- 5. Scroll reveal + counters -------------------------------- */
  if ('IntersectionObserver' in window && !reduce) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var el = en.target;
        el.classList.add('is-in');
        if (el.hasAttribute('data-stagger')) {
          Array.prototype.forEach.call(el.children, function (c, i) {
            c.style.transitionDelay = (i * 0.07) + 's';
          });
        }
        io.unobserve(el);
      });
      // threshold must stay 0: a percentage threshold can never be met by an
      // element taller than the viewport (the 10,000px product grid on a
      // phone), which left every product card stuck at opacity 0.
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0 });
    $$('[data-reveal], [data-stagger], .rule, .eyebrow').forEach(function (el) { io.observe(el); });

    var cio = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        count(en.target);
        cio.unobserve(en.target);
      });
    }, { threshold: 0.4 });
    $$('[data-count]').forEach(function (el) { cio.observe(el); });
    // Last-resort sweep: anything still hidden but already on screen after the
    // page settles gets revealed outright. Content must never be invisible.
    window.addEventListener('load', function () {
      setTimeout(function () {
        $$('[data-reveal]:not(.is-in), [data-stagger]:not(.is-in)').forEach(function (el) {
          var r = el.getBoundingClientRect();
          if (r.top < window.innerHeight * 1.5) el.classList.add('is-in');
        });
      }, 400);
    });
  } else {
    $$('[data-reveal], [data-stagger], .rule, .eyebrow').forEach(function (el) { el.classList.add('is-in'); });
    $$('[data-count]').forEach(function (el) {
      el.textContent = el.getAttribute('data-count') + (el.getAttribute('data-suffix') || '');
    });
  }

  function count(el) {
    var target = parseFloat(el.getAttribute('data-count')) || 0;
    var suffix = el.getAttribute('data-suffix') || '';
    var dur = 1500, t0 = null;
    function step(t) {
      if (!t0) t0 = t;
      var k = Math.min((t - t0) / dur, 1);
      var eased = 1 - Math.pow(1 - k, 3);
      el.textContent = Math.round(target * eased).toLocaleString('en-IN') + suffix;
      if (k < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  /* ---------- 6. FAQ accordions ------------------------------------------ */
  $$('.faq__q').forEach(function (q) {
    q.addEventListener('click', function () {
      var panel = document.getElementById(q.getAttribute('aria-controls'));
      if (!panel) return;
      var open = q.getAttribute('aria-expanded') === 'true';
      var group = q.closest('.faq');
      if (group && !open) {
        $$('.faq__q[aria-expanded="true"]', group).forEach(function (o) {
          o.setAttribute('aria-expanded', 'false');
          var p = document.getElementById(o.getAttribute('aria-controls'));
          if (p) p.classList.remove('is-open');
        });
      }
      q.setAttribute('aria-expanded', String(!open));
      panel.classList.toggle('is-open', !open);
    });
  });

  /* ---------- 7. Product gallery ----------------------------------------- */
  var gmain = $('.gallery__main');
  if (gmain) {
    gmain.addEventListener('click', function () { gmain.classList.toggle('is-zoom'); });
    gmain.addEventListener('mousemove', function (e) {
      if (!gmain.classList.contains('is-zoom')) return;
      var r = gmain.getBoundingClientRect();
      var img = $('img', gmain);
      if (img) {
        img.style.transformOrigin =
          ((e.clientX - r.left) / r.width * 100) + '% ' +
          ((e.clientY - r.top) / r.height * 100) + '%';
      }
    });
    $$('.gallery__thumbs button').forEach(function (b) {
      b.addEventListener('click', function () {
        var src = b.getAttribute('data-full');
        var img = $('img', gmain);
        if (img && src) { img.src = src; gmain.classList.remove('is-zoom'); }
        $$('.gallery__thumbs button').forEach(function (o) { o.setAttribute('aria-current', 'false'); });
        b.setAttribute('aria-current', 'true');
      });
    });
  }

  /* ---------- 8. Cursor glow (fine pointers only) ------------------------ */
  if (!reduce && window.matchMedia('(pointer: fine)').matches && window.innerWidth > 1024) {
    var glow = document.createElement('div');
    glow.className = 'cursor-glow';
    glow.setAttribute('aria-hidden', 'true');
    document.body.appendChild(glow);
    var gx = 0, gy = 0, cx = 0, cy = 0, raf = null;
    document.addEventListener('mousemove', function (e) {
      gx = e.clientX; gy = e.clientY;
      glow.style.opacity = '1';
      if (!raf) raf = requestAnimationFrame(tick);
    });
    document.addEventListener('mouseleave', function () { glow.style.opacity = '0'; });
    function tick() {
      cx += (gx - cx) * 0.13; cy += (gy - cy) * 0.13;
      glow.style.transform = 'translate(' + cx + 'px,' + cy + 'px) translate(-50%,-50%)';
      raf = Math.abs(gx - cx) + Math.abs(gy - cy) > 0.5 ? requestAnimationFrame(tick) : null;
    }
  }

  /* ---------- 9. Back to top --------------------------------------------- */
  var toTop = $('.to-top');
  if (toTop) {
    toTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
    });
  }

  /* ---------- 10. Enquiry forms ------------------------------------------ */
  $$('form[data-enquiry]').forEach(function (form) {
    var msg = $('.form__msg', form);
    var btn = $('button[type="submit"]', form);
    var btnText = btn ? btn.innerHTML : '';

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (msg) { msg.className = 'form__msg'; msg.textContent = ''; }

      var ok = true;
      $$('[data-field]', form).forEach(function (wrap) {
        var input = $('input, select, textarea', wrap);
        if (!input) return;
        var v = (input.value || '').trim();
        var bad = false;
        if (input.required && !v) bad = true;
        if (!bad && v && input.type === 'email' && !/^[^@\s]+@[^@\s]+\.[a-z]{2,}$/i.test(v)) bad = true;
        if (!bad && v && input.name === 'phone' && v.replace(/\D/g, '').length < 10) bad = true;
        wrap.classList.toggle('is-invalid', bad);
        if (bad && ok) { input.focus(); }
        if (bad) ok = false;
      });
      if (!ok) return;

      if (btn) { btn.classList.add('is-busy'); btn.innerHTML = '<i class="spin"></i> Sending'; }

      fetch(form.getAttribute('action'), {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: new FormData(form)
      })
        .then(function (r) { return r.json().catch(function () { return { ok: false }; }); })
        .then(function (d) {
          if (d && d.ok) {
            if (msg) {
              msg.className = 'form__msg is-ok';
              msg.textContent = d.message ||
                'Thank you — your enquiry has reached our team. We usually reply within one business day.';
            }
            form.reset();
            if (window.dataLayer) window.dataLayer.push({ event: 'enquiry_submitted' });
          } else {
            throw new Error((d && d.message) || 'failed');
          }
        })
        .catch(function (err) {
          if (msg) {
            msg.className = 'form__msg is-err';
            msg.innerHTML = 'We could not send that just now. Please call ' +
              '<a href="tel:' + esc(CFG.phone_raw || '') + '">' + esc(CFG.phone || '') +
              '</a> or <a href="' + waLink() + '" rel="noopener">message us on WhatsApp</a>.';
          }
        })
        .then(function () {
          if (btn) { btn.classList.remove('is-busy'); btn.innerHTML = btnText; }
        });
    });

    $$('[data-field] input, [data-field] select, [data-field] textarea', form).forEach(function (i) {
      i.addEventListener('input', function () {
        var w = i.closest('[data-field]');
        if (w) w.classList.remove('is-invalid');
      });
    });
  });

  /* ---------- 11. Prefill enquiry subject from the product page ---------- */
  var prod = document.body.getAttribute('data-product');
  if (prod) {
    $$('[data-prefill]').forEach(function (i) { if (!i.value) i.value = prod; });
  }

  /* ---------- 12. Compare drawer ----------------------------------------- */
  var CMP_KEY = 'avon-compare';
  function cmpGet() {
    try { return JSON.parse(localStorage.getItem(CMP_KEY) || '[]'); } catch (e) { return []; }
  }
  function cmpSet(list) {
    try { localStorage.setItem(CMP_KEY, JSON.stringify(list.slice(0, 4))); } catch (e) { /* private mode */ }
    cmpRender();
  }
  window.avonCompare = { get: cmpGet, set: cmpSet };

  function cmpRender() {
    var list = cmpGet();
    var bar = $('.cmp-bar');
    $$('.cmp-box input').forEach(function (cb) {
      cb.checked = list.indexOf(cb.value) > -1;
    });
    if (!bar) return;
    bar.classList.toggle('is-on', list.length > 0);
    var items = $('.cmp-bar__items', bar);
    if (items) {
      loadCatalogue().then(function (all) {
        items.innerHTML = list.map(function (slug) {
          var p = all.filter(function (x) { return x.slug === slug; })[0];
          var label = p ? (p.model_number || p.product_name) : slug;
          return '<span class="cmp-pill">' + esc(label) +
            '<button type="button" data-cmp-remove="' + esc(slug) +
            '" aria-label="Remove ' + esc(label) + ' from comparison">&times;</button></span>';
        }).join('');
      });
    }
    var link = $('[data-cmp-go]', bar);
    if (link) link.href = BASE + 'compare/?p=' + list.join(',');
    var cnt = $('[data-cmp-count]', bar);
    if (cnt) cnt.textContent = list.length;
  }

  document.addEventListener('change', function (e) {
    var cb = e.target.closest('.cmp-box input');
    if (!cb) return;
    var list = cmpGet();
    var i = list.indexOf(cb.value);
    if (cb.checked && i === -1) {
      if (list.length >= 4) { cb.checked = false; alert('You can compare up to four products at a time.'); return; }
      list.push(cb.value);
    } else if (!cb.checked && i > -1) { list.splice(i, 1); }
    cmpSet(list);
  });
  document.addEventListener('click', function (e) {
    var rm = e.target.closest('[data-cmp-remove]');
    if (rm) {
      var list = cmpGet().filter(function (s) { return s !== rm.getAttribute('data-cmp-remove'); });
      cmpSet(list);
    }
    if (e.target.closest('[data-cmp-clear]')) cmpSet([]);
  });
  cmpRender();

  /* ---------- 13. Lazy images fade --------------------------------------- */
  $$('img[loading="lazy"]').forEach(function (img) {
    if (img.complete) return;
    img.style.opacity = '0';
    img.style.transition = 'opacity .45s ease';
    img.addEventListener('load', function () { img.style.opacity = '1'; }, { once: true });
    img.addEventListener('error', function () { img.style.opacity = '1'; }, { once: true });
  });

  /* ---------- 14. Hero carousel ------------------------------------------ */
  (function () {
    var root = $('[data-hero-carousel]');
    if (!root) return;

    var slides = $$('[data-hero-slide]', root);
    var copies = $$('[data-hero-copy]', root);
    var dots = $$('[data-hero-dot]', root);
    var live = $('[data-hero-live]', root);
    var pauseBtn = $('[data-hero-pause]', root);
    if (slides.length < 2) {
      if (pauseBtn) pauseBtn.style.display = 'none';
      return;
    }

    var interval = parseInt(root.getAttribute('data-interval'), 10) || 3000;
    root.style.setProperty('--hero-interval', interval + 'ms');

    var index = 0;
    var timer = null;
    var userPaused = false;
    var hovering = false;
    var h1 = $('[data-hero-h1]', root);

    /* Swap the single <h1>'s contents and replay its line-reveal animation.
       Rebuilding the nodes is what restarts the CSS animation. */
    function setHeadline(slide) {
      if (!h1) return;
      var raw = slide.getAttribute('data-h1');
      if (!raw) return;
      var lines;
      try { lines = JSON.parse(raw); } catch (e) { return; }
      if (!lines || !lines.length) return;

      var html = '';
      for (var i = 0; i < lines.length; i++) {
        var cls = lines[i][0] ? ' class="' + lines[i][0] + '"' : '';
        html += '<span class="ln"><span' + cls + '>' + esc(lines[i][1]) + '</span></span>';
      }
      h1.innerHTML = html;
      // after the first paint this is a slide change, not a page entrance
      h1.classList.add('is-swap');
      if (reduce) {
        $$('.ln > span', h1).forEach(function (s) { s.style.animation = 'none'; });
      }
    }

    function show(next, dir) {
      next = (next + slides.length) % slides.length;   // wraps both ways = infinite
      if (next === index) return;
      var prev = index;
      index = next;

      slides.forEach(function (s, i) {
        s.classList.toggle('is-active', i === index);
        // the outgoing slide exits opposite the incoming one
        s.classList.toggle('is-prev', i === prev && dir !== 'prev');
        if (i !== prev) s.classList.remove('is-prev');
        s.setAttribute('aria-hidden', i === index ? 'false' : 'true');
        $$('a', s).forEach(function (a) { a.tabIndex = i === index ? 0 : -1; });
      });

      copies.forEach(function (c, i) {
        c.classList.toggle('is-active', i === index);
        c.setAttribute('aria-hidden', i === index ? 'false' : 'true');
      });

      dots.forEach(function (d, i) {
        // restart the fill animation by detaching and re-adding the class
        d.classList.remove('is-active');
        d.setAttribute('aria-selected', i === index ? 'true' : 'false');
      });
      void dots[index].offsetWidth;
      dots[index].classList.add('is-active');

      setHeadline(slides[index]);

      if (live) {
        var name = slides[index].getAttribute('aria-label') || '';
        live.textContent = name;
      }
    }

    function next() { show(index + 1, 'next'); }
    function prev() { show(index - 1, 'prev'); }

    function start() {
      stop();
      if (reduce || userPaused || hovering || document.hidden) return;
      root.classList.remove('is-paused');
      timer = setInterval(next, interval);
    }
    function stop() {
      if (timer) { clearInterval(timer); timer = null; }
      root.classList.add('is-paused');
    }

    $$('[data-hero-next]', root).forEach(function (b) {
      b.addEventListener('click', function () { next(); start(); });
    });
    $$('[data-hero-prev]', root).forEach(function (b) {
      b.addEventListener('click', function () { prev(); start(); });
    });
    dots.forEach(function (d, i) {
      d.addEventListener('click', function () {
        show(i, i < index ? 'prev' : 'next');
        start();
      });
    });

    if (pauseBtn) {
      pauseBtn.addEventListener('click', function () {
        userPaused = !userPaused;
        pauseBtn.setAttribute('aria-pressed', String(userPaused));
        pauseBtn.setAttribute('aria-label',
          userPaused ? 'Play the equipment carousel' : 'Pause the equipment carousel');
        userPaused ? stop() : start();
      });
      if (reduce) pauseBtn.style.display = 'none';
    }

    /* pause while the visitor is reading or interacting */
    root.addEventListener('mouseenter', function () { hovering = true; stop(); });
    root.addEventListener('mouseleave', function () { hovering = false; start(); });
    root.addEventListener('focusin', function () { hovering = true; stop(); });
    root.addEventListener('focusout', function (e) {
      if (!root.contains(e.relatedTarget)) { hovering = false; start(); }
    });
    document.addEventListener('visibilitychange', function () {
      document.hidden ? stop() : start();
    });

    /* keyboard */
    root.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowRight') { e.preventDefault(); next(); start(); }
      if (e.key === 'ArrowLeft') { e.preventDefault(); prev(); start(); }
    });

    /* touch swipe */
    var sx = 0, sy = 0, swiping = false;
    root.addEventListener('touchstart', function (e) {
      sx = e.touches[0].clientX; sy = e.touches[0].clientY; swiping = true; stop();
    }, { passive: true });
    root.addEventListener('touchend', function (e) {
      if (!swiping) return;
      swiping = false;
      var dx = e.changedTouches[0].clientX - sx;
      var dy = e.changedTouches[0].clientY - sy;
      if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) { dx < 0 ? next() : prev(); }
      start();
    }, { passive: true });

    /* only run once the hero is actually on screen */
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        entries.forEach(function (en) { en.isIntersecting ? start() : stop(); });
      }, { threshold: 0.15 }).observe(root);
    } else {
      start();
    }

    if (!reduce) dots[0].classList.add('is-active');
  })();

  /* ---------- 15. Navigation loading indicator ---------------------------- */
  (function () {
    var bar = $('.progress');
    if (!bar) return;
    document.addEventListener('click', function (e) {
      var a = e.target.closest('a[href]');
      if (!a || e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || a.target === '_blank') return;
      var href = a.getAttribute('href') || '';
      if (href.charAt(0) === '#' || /^(mailto:|tel:|https?:\/\/(?!127\.0\.0\.1|localhost))/.test(href)) return;
      if (a.origin && a.origin !== location.origin) return;
      if (a.pathname === location.pathname && a.search === location.search) return;
      bar.classList.add('is-loading');
    });
    // clear it when returning via the back/forward cache
    window.addEventListener('pageshow', function () { bar.classList.remove('is-loading'); });
    window.addEventListener('pagehide', function () { bar.classList.remove('is-loading'); });
  })();

  /* ---------- 16. Footer year -------------------------------------------- */
  $$('[data-year]').forEach(function (el) { el.textContent = new Date().getFullYear(); });
})();
