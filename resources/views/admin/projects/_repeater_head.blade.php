{{-- Reorder / remove controls shared by the results and services repeater rows. --}}
<div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:12px;">
    <span data-row-num style="display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:24px;padding:0 7px;border-radius:7px;background:var(--panel2);border:1px solid var(--border);font-size:12px;font-weight:700;">•</span>
    <span style="display:flex;align-items:center;gap:6px;">
        <button type="button" data-repeater-up aria-label="Move up" class="bt-btn-ghost" style="width:30px;height:30px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg></button>
        <button type="button" data-repeater-down aria-label="Move down" class="bt-btn-ghost" style="width:30px;height:30px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg></button>
        <button type="button" data-repeater-remove aria-label="Delete" class="bt-btn-danger" style="width:30px;height:30px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14"/></svg></button>
    </span>
</div>
