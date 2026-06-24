@extends('admin.layout')
@section('title', __('admin.brand.title'))

@php
    $rows = [
        ['accent', __('admin.brand.accent'), 'Outline, dots & links'],
        ['grad_from', __('admin.brand.grad_from'), 'Gradient start'],
        ['grad_to', __('admin.brand.grad_to'), 'Gradient end'],
        ['ink', __('admin.brand.ink'), 'Highlighted text & icons'],
    ];
@endphp

@section('content')
    <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0 0 6px;">{{ __('admin.brand.title') }}</h1>
    <p style="color:var(--muted);font-size:14.5px;margin:0 0 26px;line-height:1.6;">{{ __('admin.brand.sub') }}</p>

    <form method="POST" action="{{ route('admin.brand.update') }}" data-editor-form data-color-scope>
        @csrf @method('PUT')

        <div style="font-size:12px;letter-spacing:0.08em;text-transform:uppercase;color:var(--faint);font-weight:700;margin-bottom:14px;">{{ __('admin.brand.presets') }}</div>
        <div style="display:flex;flex-wrap:wrap;gap:11px;margin-bottom:30px;">
            @foreach ($presets as $ps)
                @php $presetJson = json_encode(['accent' => $ps['accent'], 'grad_from' => $ps['grad_from'], 'grad_to' => $ps['grad_to'], 'ink' => $ps['ink']]); @endphp
                <button type="button" data-preset="{{ $presetJson }}" class="bt-btn-ghost" style="display:flex;align-items:center;gap:10px;padding:9px 14px 9px 10px;border-radius:12px;font-size:13px;font-weight:600;">
                    <span style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,{{ $ps['grad_from'] }},{{ $ps['grad_to'] }});"></span>{{ $ps['name'] }}
                </button>
            @endforeach
        </div>

        <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:28px;">
            @foreach ($rows as [$key, $label, $hint])
                <div class="bt-card" style="padding:16px;display:flex;align-items:center;gap:14px;">
                    <label data-color-swatch="{{ $key }}" style="position:relative;width:48px;height:48px;border-radius:11px;border:1px solid var(--border2);overflow:hidden;flex:none;cursor:pointer;background:{{ $colors[$key] }};">
                        <input type="color" data-color="{{ $key }}" value="{{ $colors[$key] }}" aria-label="{{ $label }}" style="position:absolute;inset:-6px;width:140%;height:140%;border:none;padding:0;cursor:pointer;opacity:0;">
                    </label>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:13px;font-weight:600;margin-bottom:2px;">{{ $label }}</div>
                        <div style="font-size:11px;color:var(--muted);margin-bottom:8px;">{{ $hint }}</div>
                        <input type="text" name="{{ $key }}" data-color="{{ $key }}" value="{{ $colors[$key] }}" spellcheck="false" class="bt-input" style="font-family:ui-monospace,Menlo,monospace;font-size:13px;">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bt-card" style="padding:24px;">
            <div style="font-size:12px;letter-spacing:0.08em;text-transform:uppercase;color:var(--faint);font-weight:700;margin-bottom:16px;">{{ __('admin.brand.preview') }}</div>
            <div style="display:flex;flex-wrap:wrap;gap:14px;align-items:center;">
                <span data-color-swatch="grad_from" style="background:var(--g);color:#06281a;font-weight:700;font-size:14px;padding:12px 22px;border-radius:11px;">{{ st('hero.cta1') }}</span>
                <span style="border:1px solid var(--acc);color:var(--acc);font-weight:600;font-size:14px;padding:11px 20px;border-radius:11px;">{{ __('admin.brand.accent_outline') }}</span>
                <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:26px;background:var(--g);-webkit-background-clip:text;background-clip:text;color:transparent;">{{ st('hero.h1hi') }}</span>
                <span style="display:inline-flex;align-items:center;gap:8px;font-size:13px;color:var(--muted);"><span style="width:9px;height:9px;border-radius:50%;background:var(--acc);box-shadow:0 0 10px var(--acc);"></span>{{ __('admin.brand.accent_dot') }}</span>
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:12px;margin-top:20px;">
            <button type="submit" class="bt-btn">{{ __('admin.save') }}</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.brand.reset') }}" style="margin-top:14px;">@csrf
        <button type="submit" class="bt-btn-ghost" style="height:38px;padding:0 16px;border-radius:10px;font-size:13px;font-weight:600;">{{ __('admin.brand.reset') }}</button>
    </form>
@endsection
