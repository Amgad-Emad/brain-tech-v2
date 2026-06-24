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

/* ---------- scroll reveal (animated, with a fail-safe so nothing stays hidden) ---------- */
document.body.classList.add('bt-ready');
const reveals = Array.from(document.querySelectorAll('[data-reveal]'));
const reveal = (el) => el.classList.add('bt-in');

if ('IntersectionObserver' in window && reveals.length) {
  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        reveal(entry.target);
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -8% 0px' });

  const aboveFold = [];
  reveals.forEach((el) => {
    const rect = el.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom > 0) {
      aboveFold.push(el);   // hero etc. — animate explicitly so it can't get stuck
    } else {
      io.observe(el);       // the rest animate as they scroll into view
    }
  });

  // Double rAF: let the hidden state paint first, then add .bt-in so the
  // entrance transition actually plays for above-the-fold content.
  requestAnimationFrame(() => requestAnimationFrame(() => aboveFold.forEach(reveal)));

  // Final safety net — reveal anything still hidden after the animations.
  setTimeout(() => reveals.forEach(reveal), 2000);
} else {
  reveals.forEach(reveal);
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
