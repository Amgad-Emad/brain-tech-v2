/* Brain-Tech public site — progressive enhancement (no framework needed). */

const root = document.documentElement;

/* ---------- theme ---------- */
function applyTheme(theme) {
  root.setAttribute('data-bt-theme', theme);
  try { localStorage.setItem('bt-theme', theme); } catch (e) { /* ignore */ }
  document.querySelectorAll('[data-theme-icon]').forEach((el) => {
    el.textContent = theme === 'dark' ? '☾' : '☀';
  });
}

(function initTheme() {
  let theme = 'dark';
  try { theme = localStorage.getItem('bt-theme') || 'dark'; } catch (e) { /* ignore */ }
  applyTheme(theme);
})();

document.addEventListener('click', (e) => {
  const toggle = e.target.closest('[data-theme-toggle]');
  if (toggle) {
    const current = root.getAttribute('data-bt-theme') === 'light' ? 'light' : 'dark';
    applyTheme(current === 'dark' ? 'light' : 'dark');
  }
});

/* ---------- mobile menu ---------- */
document.addEventListener('click', (e) => {
  const burger = e.target.closest('[data-menu-toggle]');
  if (!burger) return;
  const panel = document.querySelector('[data-mobile-panel]');
  if (!panel) return;
  const open = panel.classList.toggle('bt-open');
  burger.setAttribute('aria-expanded', open ? 'true' : 'false');
});

/* close mobile menu after tapping a link */
document.querySelectorAll('[data-mobile-panel] a').forEach((a) => {
  a.addEventListener('click', () => {
    document.querySelector('[data-mobile-panel]')?.classList.remove('bt-open');
  });
});

/* ---------- sticky nav background on scroll ---------- */
const nav = document.querySelector('[data-nav]');
function onScroll() {
  if (!nav) return;
  nav.classList.toggle('bt-scrolled', window.scrollY > 12);
}
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

/* ---------- scroll reveal (matches the original: toggle .bt-in by viewport position) ---------- */
root.classList.add('bt-ready'); // enable reveal-hiding only now that JS runs

let revealEls = [];
let revealRaf = null;

function refreshReveal() {
  revealEls = Array.from(document.querySelectorAll('[data-reveal]'));
}

function handleReveal() {
  const vh = window.innerHeight || 800;
  for (const el of revealEls) {
    const r = el.getBoundingClientRect();
    const inView = r.top < vh * 0.9 && r.bottom > vh * 0.08;
    // Reveal once and keep it — never toggle back to the hidden state. The
    // hidden state shifts an element down 46px with a blur, so re-hiding a
    // heading as you scroll past makes it slide down over the content below
    // it (e.g. the process heading dropping onto the step nodes).
    if (inView) el.classList.add('bt-in');
  }
}

function onRevealScroll() {
  if (revealRaf) return;
  revealRaf = requestAnimationFrame(() => { revealRaf = null; handleReveal(); });
}

refreshReveal();
// Double rAF: paint the hidden state first, then reveal in-view elements so the
// hero's entrance transition actually plays on load (not just appears).
requestAnimationFrame(() => requestAnimationFrame(handleReveal));
window.addEventListener('scroll', onRevealScroll, { passive: true });
window.addEventListener('resize', onRevealScroll);

// Re-check as layout/fonts settle so above-the-fold content always appears.
[150, 450, 900].forEach((d) => setTimeout(() => { refreshReveal(); handleReveal(); }, d));
if (document.fonts && document.fonts.ready) {
  document.fonts.ready.then(handleReveal).catch(() => {});
}

/* ---------- stat count-up ---------- */
function animateCount(el) {
  const target = parseInt(el.getAttribute('data-count') || '0', 10);
  const suffix = el.getAttribute('data-suffix') || '';
  const dur = 1400;
  const start = performance.now();
  function frame(now) {
    const p = Math.min((now - start) / dur, 1);
    const eased = 1 - Math.pow(1 - p, 3);
    el.textContent = Math.round(target * eased).toLocaleString() + suffix;
    if (p < 1) requestAnimationFrame(frame);
  }
  requestAnimationFrame(frame);
}
const counters = document.querySelectorAll('[data-count]');
if ('IntersectionObserver' in window && counters.length) {
  const co = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        animateCount(entry.target);
        co.unobserve(entry.target);
      }
    });
  }, { threshold: 0.4 });
  counters.forEach((el) => co.observe(el));
}

/* ---------- testimonial slider ---------- */
(function slider() {
  const track = document.querySelector('[data-slider-track]');
  if (!track) return;
  const slides = track.children.length;
  let index = 0;
  const dots = document.querySelectorAll('[data-slider-dot]');

  function go(i) {
    index = (i + slides) % slides;
    track.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((d, di) => d.classList.toggle('bt-active', di === index));
  }

  document.querySelector('[data-slider-prev]')?.addEventListener('click', () => go(index - 1));
  document.querySelector('[data-slider-next]')?.addEventListener('click', () => go(index + 1));
  dots.forEach((d, di) => d.addEventListener('click', () => go(di)));
  go(0);
})();

/* ---------- faq accordion ---------- */
document.querySelectorAll('[data-faq-toggle]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const item = btn.closest('.bt-faq-item');
    if (!item) return;
    const isOpen = item.classList.contains('bt-open');
    document.querySelectorAll('.bt-faq-item').forEach((i) => i.classList.remove('bt-open'));
    if (!isOpen) item.classList.add('bt-open');
    btn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
  });
});

/* ---------- analytics beacon (page-view + dwell time) ---------- */
(function analytics() {
  const enter = Date.now();
  const referrer = document.referrer || '';
  let sent = false;

  function flush() {
    if (sent) return;
    const duration = Math.round((Date.now() - enter) / 1000);
    if (duration < 1 || duration > 7200) return;
    sent = true;
    const payload = JSON.stringify({
      path: location.pathname,
      locale: root.getAttribute('lang') || document.documentElement.lang || 'en',
      duration,
      referrer,
    });
    try {
      navigator.sendBeacon('/track', new Blob([payload], { type: 'text/plain' }));
    } catch (e) { /* ignore */ }
  }

  window.addEventListener('pagehide', flush);
  document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') flush();
  });
})();

/* ---------- contact form: loading overlay while sending ---------- */
(function contactLoader() {
  const form = document.querySelector('[data-contact-form]');
  const loader = document.querySelector('[data-contact-loader]');
  if (!form || !loader) return;

  const btn = form.querySelector('button[type="submit"]');

  // The submit event only fires once native validation passes, so the
  // overlay never shows for an invalid form. It clears on the next page load.
  form.addEventListener('submit', () => {
    loader.classList.add('bt-open');
    loader.setAttribute('aria-hidden', 'false');
    if (btn) {
      btn.disabled = true;
      btn.style.opacity = '0.7';
      btn.style.cursor = 'wait';
    }
  });

  // Restore a clean state if the user returns via the back/forward cache.
  window.addEventListener('pageshow', (e) => {
    if (e.persisted) {
      loader.classList.remove('bt-open');
      loader.setAttribute('aria-hidden', 'true');
      if (btn) { btn.disabled = false; btn.style.opacity = ''; btn.style.cursor = ''; }
    }
  });
})();
