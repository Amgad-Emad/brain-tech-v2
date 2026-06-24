@extends('admin.layout')
@section('title', __('admin.nav.analytics'))

@php
    $grad = 'linear-gradient(135deg,'.setting_raw('theme.grad_from', '#0ddc83').','.setting_raw('theme.grad_to', '#16e89a').')';
    $accent = setting_raw('theme.accent', '#34e0a0');
@endphp

@section('content')
    <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0 0 6px;">{{ __('admin.an.title') }}</h1>
    <p style="color:var(--muted);font-size:14.5px;margin:0 0 22px;line-height:1.6;max-width:640px;">{{ __('admin.an.sub') }}</p>

    <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;background:linear-gradient(135deg,rgba(var(--accRGB),0.12),rgba(var(--accRGB),0.05));border:1px solid var(--border);border-radius:14px;padding:14px 18px;margin-bottom:22px;">
        <span style="display:inline-flex;align-items:center;gap:8px;font-size:12px;font-weight:700;"><span style="width:8px;height:8px;border-radius:50%;background:{{ $accent }};box-shadow:0 0 9px {{ $accent }};"></span>{{ __('admin.an.live') }}</span>
        <span style="font-size:13px;color:var(--muted);">{{ $an['live']['sessions'] }} <span style="opacity:.7;">sessions</span></span>
        <span style="font-size:13px;color:var(--muted);">{{ $an['live']['views'] }} <span style="opacity:.7;">views</span></span>
        <span style="font-size:13px;color:var(--muted);">~{{ $an['live']['avg'] }} <span style="opacity:.7;">avg</span></span>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:13px;margin-bottom:22px;">
        @foreach ($an['kpis'] as $k)
            <div class="bt-card" style="padding:18px;">
                <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:26px;line-height:1;margin-bottom:7px;background:{{ $grad }};-webkit-background-clip:text;background-clip:text;color:transparent;">{{ $k['value'] }}</div>
                <div style="font-size:12.5px;color:var(--muted);">{{ $k['label'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="bt-card" style="padding:22px;margin-bottom:18px;">
        <div style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:18px;">{{ __('admin.an.trend') }}</div>
        <div style="display:flex;align-items:flex-end;gap:6px;height:120px;">
            @foreach ($an['trend'] as $b)
                <div title="{{ $b['label'] }}: {{ $b['value'] }}" style="flex:1;height:{{ $b['height'] }};min-height:4px;background:{{ $grad }};border-radius:5px 5px 0 0;opacity:.88;"></div>
            @endforeach
        </div>
    </div>

    <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">
        <div class="bt-card" style="padding:22px;">
            <div style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:16px;">{{ __('admin.an.top_pages') }}</div>
            <div style="display:flex;flex-direction:column;gap:14px;">
                @forelse ($an['topPages'] as $p)
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:baseline;gap:10px;margin-bottom:6px;"><span style="font-size:13.5px;font-weight:600;">{{ $p['label'] }}</span><span style="font-size:12px;color:var(--muted);">{{ $p['views'] }} · ⏱ {{ $p['time'] }}</span></div>
                        <div style="height:7px;border-radius:99px;background:var(--panel2);overflow:hidden;"><div style="height:100%;width:{{ $p['width'] }};background:{{ $grad }};border-radius:99px;"></div></div>
                    </div>
                @empty
                    <p style="font-size:13px;color:var(--faint);margin:0;">—</p>
                @endforelse
            </div>
        </div>
        <div class="bt-card" style="padding:22px;">
            <div style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:16px;">{{ __('admin.an.geo') }}</div>
            <div style="display:flex;flex-direction:column;gap:13px;">
                @forelse ($an['geo'] as $c)
                    <div>
                        <div style="display:flex;justify-content:space-between;align-items:baseline;gap:10px;margin-bottom:6px;"><span style="font-size:13px;font-weight:500;">{{ $c['label'] }}</span><span style="font-size:12px;color:var(--muted);">{{ $c['count'] }}</span></div>
                        <div style="height:7px;border-radius:99px;background:var(--panel2);overflow:hidden;"><div style="height:100%;width:{{ $c['percent'] }};background:{{ $grad }};border-radius:99px;"></div></div>
                    </div>
                @empty
                    <p style="font-size:13px;color:var(--faint);line-height:1.6;margin:0;">{{ __('admin.an.geo_empty') }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bt-twocol" style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">
        @foreach ([['admin.an.devices', $an['devices']], ['admin.an.sources', $an['sources']]] as [$titleKey, $rows])
            <div class="bt-card" style="padding:22px;">
                <div style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:16px;">{{ __($titleKey) }}</div>
                <div style="display:flex;flex-direction:column;gap:13px;">
                    @forelse ($rows as $r)
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span style="font-size:13px;font-weight:500;width:90px;flex:none;">{{ $r['label'] }}</span>
                            <div style="flex:1;height:9px;border-radius:99px;background:var(--panel2);overflow:hidden;"><div style="height:100%;width:{{ $r['percent'] }};background:{{ $grad }};border-radius:99px;"></div></div>
                            <span style="font-size:12.5px;color:var(--muted);width:40px;text-align:end;flex:none;">{{ $r['percent'] }}</span>
                        </div>
                    @empty
                        <p style="font-size:13px;color:var(--faint);margin:0;">—</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <div class="bt-card" style="padding:22px;margin-bottom:16px;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:14px;">
            <span style="font-size:13px;font-weight:600;color:var(--muted);">{{ __('admin.an.recent') }}</span>
            <span style="font-size:12px;font-weight:700;background:var(--panel2);border:1px solid var(--border);padding:3px 10px;border-radius:99px;">{{ $an['allCount'] }}</span>
        </div>
        @if ($an['hasData'])
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;min-width:520px;">
                    <thead><tr style="color:var(--faint);text-align:start;">
                        <th style="text-align:start;font-weight:600;padding:0 10px 10px 0;">{{ __('admin.an.col_when') }}</th>
                        <th style="text-align:start;font-weight:600;padding:0 10px 10px 0;">{{ __('admin.an.col_page') }}</th>
                        <th style="text-align:start;font-weight:600;padding:0 10px 10px 0;">{{ __('admin.an.col_loc') }}</th>
                        <th style="text-align:start;font-weight:600;padding:0 10px 10px 0;">IP</th>
                        <th style="text-align:start;font-weight:600;padding:0 10px 10px 0;">{{ __('admin.an.col_dev') }}</th>
                        <th style="text-align:start;font-weight:600;padding:0 0 10px 0;">{{ __('admin.an.col_dur') }}</th>
                    </tr></thead>
                    <tbody>
                        @foreach ($an['recent'] as $v)
                            <tr style="border-top:1px solid var(--border);">
                                <td style="padding:11px 10px 11px 0;color:var(--muted);white-space:nowrap;">{{ $v->created_at?->diffForHumans() }}</td>
                                <td style="padding:11px 10px 11px 0;font-weight:500;">{{ $v->path }}</td>
                                <td style="padding:11px 10px 11px 0;color:var(--muted);">{{ $v->country ?: '—' }}</td>
                                <td style="padding:11px 10px 11px 0;color:var(--faint);font-family:ui-monospace,Menlo,monospace;font-size:12px;">{{ $v->ip ?: '—' }}</td>
                                <td style="padding:11px 10px 11px 0;color:var(--muted);">{{ $v->device }}</td>
                                <td style="padding:11px 0;font-weight:500;">{{ \App\Support\Analytics::duration((int) $v->duration) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="font-size:13px;color:var(--muted);line-height:1.6;margin:0;">{{ __('admin.an.empty') }}</p>
        @endif
    </div>
    <p style="font-size:12px;color:var(--faint);line-height:1.6;margin:0;">{{ __('admin.an.note') }}</p>
@endsection
