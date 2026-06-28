/* Brain-Tech CMS admin interactivity. */
const root = document.documentElement;

/* ---------- theme ---------- */
function applyTheme(theme) {
  root.setAttribute('data-bt-theme', theme);
  try { localStorage.setItem('bt-theme', theme); } catch (e) { /* ignore */ }
  document.querySelectorAll('[data-theme-icon]').forEach((el) => { el.textContent = theme === 'dark' ? '☾' : '☀'; });
}
(function () {
  let t = 'dark';
  try { t = localStorage.getItem('bt-theme') || 'dark'; } catch (e) { /* ignore */ }
  applyTheme(t);
})();
document.addEventListener('click', (e) => {
  if (e.target.closest('[data-theme-toggle]')) {
    applyTheme(root.getAttribute('data-bt-theme') === 'light' ? 'dark' : 'light');
  }
});

/* ---------- sidebar (mobile) ---------- */
document.addEventListener('click', (e) => {
  if (e.target.closest('[data-sidebar-toggle]')) {
    document.querySelector('[data-sidebar]')?.classList.toggle('bt-open');
  }
});

/* ---------- dirty tracking + topbar Save ---------- */
const form = document.querySelector('[data-editor-form]');
let dirty = false;
function setDirty(v) {
  dirty = v;
  document.querySelectorAll('[data-unsaved]').forEach((el) => { el.style.display = v ? '' : 'none'; });
}
if (form) {
  form.addEventListener('input', () => setDirty(true));
  form.addEventListener('change', () => setDirty(true));
  form.addEventListener('submit', () => { dirty = false; reindexAll(); });
}
document.querySelectorAll('[data-save]').forEach((btn) => {
  btn.addEventListener('click', () => { if (form) { reindexAll(); form.submit(); } });
});
// Hide the topbar Save / unsaved hint on pages without an editor form.
if (!form) {
  document.querySelectorAll('[data-save], [data-unsaved]').forEach((el) => { el.style.display = 'none'; });
}
window.addEventListener('beforeunload', (e) => {
  if (dirty) { e.preventDefault(); e.returnValue = ''; }
});

/* ---------- live colour preview ---------- */
function syncColors() {
  // Only on the Brand & Colors editor — elsewhere the layout's injected brand
  // palette must stand untouched.
  if (!document.querySelector('[data-color]')) return;
  const get = (k) => document.querySelector(`[data-color="${k}"]`)?.value;
  const accent = get('accent') || '#34e0a0';
  const from = get('grad_from') || accent;
  const to = get('grad_to') || accent;
  const ink = get('ink') || accent;
  // Recolour the entire admin chrome live as the user drags.
  root.style.setProperty('--acc', ink);
  root.style.setProperty('--g', `linear-gradient(135deg, ${from} 0%, ${to} 100%)`);
  const rgb = accent.replace('#', '').match(/.{2}/g);
  if (rgb) root.style.setProperty('--accRGB', rgb.map((h) => parseInt(h, 16)).join(', '));
  document.querySelectorAll('[data-color-swatch]').forEach((sw) => {
    const k = sw.getAttribute('data-color-swatch');
    sw.style.background = get(k);
  });
}
document.querySelectorAll('[data-color]').forEach((input) => {
  input.addEventListener('input', (e) => {
    // keep paired hex text + color picker in sync
    const key = input.getAttribute('data-color');
    document.querySelectorAll(`[data-color="${key}"]`).forEach((other) => { if (other !== input) other.value = input.value; });
    syncColors();
    setDirty(true);
  });
});
document.querySelectorAll('[data-preset]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const p = JSON.parse(btn.getAttribute('data-preset'));
    Object.entries(p).forEach(([k, v]) => {
      document.querySelectorAll(`[data-color="${k}"]`).forEach((inp) => { inp.value = v; });
    });
    syncColors();
    setDirty(true);
  });
});

/* ---------- repeaters (FAQ / testimonials) ---------- */
function reindex(container) {
  const name = container.getAttribute('data-repeater');
  container.querySelectorAll('[data-repeater-row]').forEach((row, i) => {
    row.querySelector('[data-row-num]') && (row.querySelector('[data-row-num]').textContent = i + 1);
    row.querySelectorAll('[data-field]').forEach((field) => {
      const path = field.getAttribute('data-field'); // e.g. "q[en]"
      field.setAttribute('name', `${name}[${i}]${path}`);
    });
  });
}
function reindexAll() {
  document.querySelectorAll('[data-repeater]').forEach(reindex);
}
document.querySelectorAll('[data-repeater]').forEach((container) => {
  const items = container.querySelector('[data-repeater-items]');
  const tpl = container.querySelector('template[data-repeater-template]');

  container.querySelector('[data-repeater-add]')?.addEventListener('click', () => {
    const node = tpl.content.firstElementChild.cloneNode(true);
    items.appendChild(node);
    reindex(container);
    setDirty(true);
  });

  items.addEventListener('click', (e) => {
    const row = e.target.closest('[data-repeater-row]');
    if (!row) return;
    if (e.target.closest('[data-repeater-remove]')) { row.remove(); reindex(container); setDirty(true); }
    else if (e.target.closest('[data-repeater-up]')) { const p = row.previousElementSibling; if (p) { items.insertBefore(row, p); reindex(container); setDirty(true); } }
    else if (e.target.closest('[data-repeater-down]')) { const n = row.nextElementSibling; if (n) { items.insertBefore(n, row); reindex(container); setDirty(true); } }
  });

  reindex(container);
});

/* ---------- live preview (real page in an iframe) ---------- */
(function livePreview() {
  const frame = document.querySelector('[data-preview-frame]');
  if (!frame || !form) return;

  const url = frame.getAttribute('data-preview-url');
  const anchor = frame.getAttribute('data-preview-anchor');
  const loading = document.querySelector('[data-preview-loading]');
  let timer;

  function update() {
    reindexAll();
    const fd = new FormData(form);
    fd.delete('_method'); // POST to the preview route, not a spoofed PUT
    if (loading) loading.style.display = '';
    fetch(url, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then((r) => r.text())
      .then((html) => { frame.srcdoc = html; })
      .catch(() => {})
      .finally(() => { if (loading) loading.style.display = 'none'; });
  }

  frame.addEventListener('load', () => {
    if (!anchor) return;
    // Scroll the iframe's OWN viewport to the section — never call
    // scrollIntoView(), which also scrolls the parent page (jumping the
    // admin view up to the preview on every keystroke-triggered reload).
    try {
      const win = frame.contentWindow;
      const el = win.document.getElementById(anchor);
      if (el) win.scrollTo(0, el.getBoundingClientRect().top + win.scrollY);
    } catch (e) { /* ignore */ }
  });

  form.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(update, 550); });
  document.querySelector('[data-preview-refresh]')?.addEventListener('click', update);

  update(); // initial render
})();

/* ---------- toast auto-dismiss ---------- */
document.querySelectorAll('.bt-toast').forEach((t) => setTimeout(() => t.remove(), 3400));

syncColors();
