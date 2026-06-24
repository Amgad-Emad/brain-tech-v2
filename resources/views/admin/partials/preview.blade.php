@php
    $anchors = ['services' => 'services', 'work' => 'work', 'process' => 'process', 'values' => 'about', 'cta' => 'contact-cta', 'offers' => 'services'];
    $anchor = $anchors[$section['id']] ?? '';
@endphp

<div class="bt-card" style="overflow:hidden;margin-bottom:18px;">
    <div style="padding:11px 16px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:10px;">
        <span style="display:flex;align-items:center;gap:8px;">
            <span style="width:7px;height:7px;border-radius:50%;background:var(--acc);box-shadow:0 0 8px var(--acc);"></span>
            <span style="font-size:12.5px;font-weight:600;color:var(--muted);">{{ __('admin.overview.live_preview') }}</span>
        </span>
        <span style="display:flex;align-items:center;gap:10px;">
            <span data-preview-loading style="display:none;font-size:11px;color:var(--faint);">…</span>
            <button type="button" data-preview-refresh class="bt-btn-ghost" style="height:30px;padding:0 12px;border-radius:8px;font-size:12px;font-weight:600;">↻ {{ __('admin.brand.preview') }}</button>
        </span>
    </div>
    <iframe data-preview-frame
            data-preview-url="{{ route('admin.section.preview', $section['id']) }}"
            data-preview-anchor="{{ $anchor }}"
            title="Live preview"
            style="width:100%;height:520px;border:none;background:#08080b;display:block;"></iframe>
</div>
