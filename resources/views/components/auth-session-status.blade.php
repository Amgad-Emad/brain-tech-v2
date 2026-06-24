@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['style' => 'margin-bottom:16px;padding:12px 14px;border-radius:11px;background:rgba(var(--accRGB),0.12);border:1px solid rgba(var(--accRGB),0.4);color:var(--fg);font-size:13.5px;']) }}>
        {{ $status }}
    </div>
@endif
