@php
    /** @var string $name  field name, e.g. "name" -> name[en]/name[ar] */
    $v = $value ?? null;
    $enVal = is_array($v) ? ($v['en'] ?? '') : '';
    $arVal = is_array($v) ? ($v['ar'] ?? '') : '';
    $type = $type ?? 'text';
    $rows = $rows ?? 3;
@endphp
<div>
    <span class="bt-label">{{ $label }}</span>
    <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div>
            <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.english') }}</span>
            @if ($type === 'area')
                <textarea name="{{ $name }}[en]" rows="{{ $rows }}" dir="ltr" class="bt-input">{{ old($name.'.en', $enVal) }}</textarea>
            @else
                <input type="text" name="{{ $name }}[en]" value="{{ old($name.'.en', $enVal) }}" dir="ltr" class="bt-input">
            @endif
        </div>
        <div>
            <span style="font-size:10px;color:var(--faint);">{{ __('admin.editor.arabic') }}</span>
            @if ($type === 'area')
                <textarea name="{{ $name }}[ar]" rows="{{ $rows }}" dir="rtl" class="bt-input bt-ar">{{ old($name.'.ar', $arVal) }}</textarea>
            @else
                <input type="text" name="{{ $name }}[ar]" value="{{ old($name.'.ar', $arVal) }}" dir="rtl" class="bt-input bt-ar">
            @endif
        </div>
    </div>
</div>
