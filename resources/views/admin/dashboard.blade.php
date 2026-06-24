@extends('admin.layout')
@section('title', __('admin.nav.overview'))

@php
    $accent = setting_raw('theme.accent', '#34e0a0');
    $grad = 'linear-gradient(135deg,'.setting_raw('theme.grad_from', '#0ddc83').','.setting_raw('theme.grad_to', '#16e89a').')';
@endphp

@section('content')
    <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(24px,3.4vw,34px);letter-spacing:-0.02em;margin:0 0 6px;">{{ __('admin.overview.welcome') }}</h1>
    <p style="color:var(--muted);font-size:15px;margin:0 0 26px;max-width:620px;line-height:1.6;">{{ __('admin.overview.sub') }}</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:14px;margin-bottom:28px;">
        @foreach ($stats as $stat)
            <div class="bt-card" style="padding:20px;">
                <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:30px;line-height:1;background:{{ $grad }};-webkit-background-clip:text;background-clip:text;color:transparent;margin-bottom:8px;">{{ $stat['value'] }}</div>
                <div style="font-size:13px;color:var(--muted);">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="bt-card" style="overflow:hidden;margin-bottom:24px;">
        <div style="padding:13px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:13px;font-weight:600;color:var(--muted);">{{ __('admin.overview.live_preview') }}</span>
            <span style="font-size:11px;color:var(--faint);">{{ __('admin.overview.hero_section') }}</span>
        </div>
        <div style="padding:48px 28px;text-align:center;">
            <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 13px;border-radius:99px;background:var(--panel2);border:1px solid var(--border);font-size:12px;color:var(--muted);margin-bottom:18px;"><span style="width:6px;height:6px;border-radius:50%;background:{{ $accent }};"></span>{{ st('hero.badge') }}</div>
            <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3.4vw,34px);line-height:1.1;letter-spacing:-0.02em;margin:0 auto 14px;max-width:560px;">{{ st('hero.h1pre') }}<span style="background:{{ $grad }};-webkit-background-clip:text;background-clip:text;color:transparent;">{{ st('hero.h1hi') }}</span>{{ st('hero.h1post') }}</div>
            <p style="color:var(--muted);font-size:14.5px;line-height:1.55;max-width:430px;margin:0 auto 22px;">{{ st('hero.sub') }}</p>
            <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
                <span style="background:{{ $grad }};color:#06281a;font-size:13.5px;font-weight:700;padding:11px 20px;border-radius:11px;">{{ st('hero.cta1') }}</span>
                <span style="background:var(--panel2);border:1px solid var(--border2);color:var(--fg);font-size:13.5px;font-weight:600;padding:11px 20px;border-radius:11px;">{{ st('hero.cta2') }}</span>
            </div>
        </div>
    </div>

    <div class="bt-card">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 18px;border-bottom:1px solid var(--border);">
            <span style="font-weight:600;">{{ __('admin.nav.messages') }} @if ($counts['unread'])<span style="margin-inline-start:8px;font-size:11px;color:#06281a;background:{{ $accent }};padding:2px 8px;border-radius:99px;font-weight:700;">{{ $counts['unread'] }}</span>@endif</span>
            <a href="{{ route('admin.messages.index') }}" style="font-size:13px;color:{{ $accent }};text-decoration:none;">{{ __('admin.an.recent') }} →</a>
        </div>
        @forelse ($recentMessages as $message)
            <a href="{{ route('admin.messages.show', $message) }}" style="display:flex;align-items:center;justify-content:space-between;padding:13px 18px;border-bottom:1px solid var(--border);text-decoration:none;color:inherit;">
                <span><span style="font-weight:600;">{{ $message->name }}</span> <span style="color:var(--faint);font-size:13px;">· {{ $message->email }}</span></span>
                <span style="font-size:12px;color:var(--faint);">{{ $message->created_at->diffForHumans() }}</span>
            </a>
        @empty
            <p style="padding:18px;color:var(--faint);font-size:14px;margin:0;">—</p>
        @endforelse
    </div>
@endsection
