<div data-repeater-row class="bt-card" style="padding:18px;">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:13px;">
        <span data-row-num style="display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:24px;padding:0 7px;border-radius:7px;background:var(--panel2);border:1px solid var(--border);font-size:12px;font-weight:700;">•</span>
        @if ($dynamic)
            <span style="display:flex;align-items:center;gap:6px;">
                <button type="button" data-repeater-up aria-label="Move up" class="bt-btn-ghost" style="width:30px;height:30px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 15l-6-6-6 6"/></svg></button>
                <button type="button" data-repeater-down aria-label="Move down" class="bt-btn-ghost" style="width:30px;height:30px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg></button>
                <button type="button" data-repeater-remove aria-label="Delete" class="bt-btn-danger" style="width:30px;height:30px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14"/></svg></button>
            </span>
        @endif
    </div>

    <input type="hidden" data-field="[id]" value="{{ $rowId }}">

    <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach ($fields as [$attr, $type, $label])
            @php $v = $values[$attr] ?? null; @endphp
            @if (in_array($type, ['text', 'area'], true))
                <div>
                    <span class="bt-label">{{ $label }}</span>
                    <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div>
                            <span style="font-size:10px;color:var(--faint);">EN</span>
                            @if ($type === 'area')
                                <textarea data-field="[{{ $attr }}][en]" rows="3" dir="ltr" class="bt-input">{{ is_array($v) ? ($v['en'] ?? '') : '' }}</textarea>
                            @else
                                <input type="text" data-field="[{{ $attr }}][en]" value="{{ is_array($v) ? ($v['en'] ?? '') : '' }}" dir="ltr" class="bt-input">
                            @endif
                        </div>
                        <div>
                            <span style="font-size:10px;color:var(--faint);">عربي</span>
                            @if ($type === 'area')
                                <textarea data-field="[{{ $attr }}][ar]" rows="3" dir="rtl" class="bt-input bt-ar">{{ is_array($v) ? ($v['ar'] ?? '') : '' }}</textarea>
                            @else
                                <input type="text" data-field="[{{ $attr }}][ar]" value="{{ is_array($v) ? ($v['ar'] ?? '') : '' }}" dir="rtl" class="bt-input bt-ar">
                            @endif
                        </div>
                    </div>
                </div>
            @elseif ($type === 'bool')
                <label style="display:inline-flex;align-items:center;gap:9px;cursor:pointer;">
                    <input type="checkbox" data-field="[{{ $attr }}]" value="1" @checked($v) style="width:16px;height:16px;accent-color:var(--acc);">
                    <span style="font-size:13px;font-weight:600;">{{ $label }}</span>
                </label>
            @else
                <div>
                    <span class="bt-label">{{ $label }}</span>
                    <input type="text" data-field="[{{ $attr }}]" value="{{ is_array($v) ? '' : $v }}" class="bt-input" style="max-width:260px;">
                </div>
            @endif
        @endforeach
    </div>
</div>
