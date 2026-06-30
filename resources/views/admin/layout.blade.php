@php
    use App\Cms\Sections;
    $uiLocale = app()->getLocale();
    $otherLocale = $uiLocale === 'ar' ? 'en' : 'ar';
    $groups = Sections::groups();
    $all = Sections::all();
    $isSection = fn ($id) => request()->routeIs('admin.section.edit') && request()->route('section') === $id;
    $counts = [
        'services' => \App\Models\Service::count(),
        'values' => \App\Models\Value::count(),
        'process' => \App\Models\ProcessStep::count(),
        'work' => \App\Models\Project::count(),
        'stats' => \App\Models\Stat::count(),
        'testimonials' => \App\Models\Testimonial::count(),
        'faq' => \App\Models\Faq::count(),
        'servicespage' => \App\Models\Service::count(),
        'offers' => \App\Models\Service::count(),
    ];
    $unread = \App\Models\ContactMessage::unread()->count();

    // Apply the brand palette to the admin chrome too.
    $accent = setting_raw('theme.ink', null) ?: setting_raw('theme.accent', '#34e0a0');
    $gradFrom = setting_raw('theme.grad_from', '#0ddc83');
    $gradTo = setting_raw('theme.grad_to', '#16e89a');
    [$ar, $ag, $ab] = sscanf(setting_raw('theme.accent', '#34e0a0'), '#%02x%02x%02x') ?: [13, 200, 123];
@endphp
<!DOCTYPE html>
<html lang="{{ $uiLocale }}" dir="{{ is_rtl() ? 'rtl' : 'ltr' }}" data-bt-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('admin.nav.overview')) · Brain-Tech {{ __('admin.cms') }}</title>
    <link rel="icon" href="{{ asset('Brain-Tech-Premium-Website/brand/mark.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>try { document.documentElement.setAttribute('data-bt-theme', localStorage.getItem('bt-theme') || 'dark'); } catch (e) {}</script>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    {{-- Brand palette applied to the admin chrome — after @vite so it wins. --}}
    <style>
        :root, html[data-bt-theme] {
            --acc: {{ $accent }};
            --accRGB: {{ $ar }}, {{ $ag }}, {{ $ab }};
            --g: linear-gradient(135deg, {{ $gradFrom }} 0%, {{ $gradTo }} 100%);
        }
    </style>
</head>
<body>
    <header style="position:sticky;top:0;z-index:50;display:flex;align-items:center;gap:14px;height:64px;padding:0 20px;background:var(--bg2);border-bottom:1px solid var(--border);">
        <button class="bt-burger" data-sidebar-toggle aria-label="Menu" style="display:none;align-items:center;justify-content:center;width:40px;height:40px;border-radius:10px;background:var(--panel2);border:1px solid var(--border);color:var(--fg);cursor:pointer;">
            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="7" x2="21" y2="7"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="17" x2="21" y2="17"/></svg>
        </button>
        <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:11px;text-decoration:none;color:var(--fg);">
            <span style="width:34px;height:34px;border-radius:9px;background:#0c0c11;border:1px solid rgba(255,255,255,0.1);display:inline-flex;align-items:center;justify-content:center;"><img src="{{ asset('Brain-Tech-Premium-Website/brand/mark.png') }}" alt="" style="width:20px;"></span>
            <span style="line-height:1.1;"><span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:15px;">Brain<span style="color:var(--acc);">Tech</span> <span style="color:var(--faint);font-weight:500;">{{ __('admin.cms') }}</span></span><br><span style="font-size:11px;color:var(--faint);">{{ __('admin.subtitle') }}</span></span>
        </a>
        <div style="flex:1;"></div>
        <div style="display:flex;align-items:center;gap:8px;">
            <span data-unsaved style="display:none;font-size:12px;color:#f5a524;align-items:center;gap:6px;margin-inline-end:4px;"><span style="width:7px;height:7px;border-radius:50%;background:#f5a524;"></span>{{ __('admin.unsaved') }}</span>
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="bt-btn-ghost" style="height:40px;display:inline-flex;align-items:center;gap:7px;padding:0 14px;border-radius:10px;font-size:13.5px;font-weight:600;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h6v6"/><path d="M10 14L21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                {{ __('admin.open_site') }}
            </a>
            <a href="{{ route('admin.locale', $otherLocale) }}" class="bt-btn-ghost" style="height:40px;min-width:46px;padding:0 12px;border-radius:10px;font-size:13px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">{{ $otherLocale === 'ar' ? 'العربية' : 'EN' }}</a>
            <button type="button" data-theme-toggle aria-label="Theme" class="bt-btn-ghost" style="width:40px;height:40px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;"><span data-theme-icon>☾</span></button>
            <button type="button" data-save class="bt-btn" style="height:40px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                {{ __('admin.save') }}
            </button>
        </div>
    </header>

    <div style="display:flex;align-items:stretch;min-height:calc(100vh - 64px);">
        <nav class="bt-sidebar" data-sidebar aria-label="Sections" style="width:268px;flex:none;background:var(--sidebar);border-inline-end:1px solid var(--border);padding:16px 12px;overflow-y:auto;max-height:calc(100vh - 64px);position:sticky;top:64px;">
            @php
                $topLinks = [
                    ['admin.dashboard', 'dashboard', __('admin.nav.overview'), request()->routeIs('admin.dashboard')],
                    ['admin.analytics', 'chart', __('admin.nav.analytics'), request()->routeIs('admin.analytics')],
                    ['admin.brand.edit', 'palette', __('admin.nav.brand'), request()->routeIs('admin.brand.*')],
                ];
            @endphp
            @foreach ($topLinks as [$route, $icon, $label, $active])
                <a href="{{ route($route) }}" style="width:100%;display:flex;align-items:center;gap:11px;padding:11px 13px;border-radius:11px;text-decoration:none;font-size:14px;font-weight:600;margin-bottom:4px;{{ $active ? 'background:rgba(var(--accRGB,13,200,123),0.14);color:var(--acc);' : 'color:var(--fg);' }}">
                    <span style="color:var(--acc);display:inline-flex;"><x-admin-icon :name="$icon" /></span>{{ $label }}
                </a>
            @endforeach

            @foreach ($groups as $groupKey => $ids)
                <div style="margin-top:16px;">
                    <div style="font-size:11px;letter-spacing:0.09em;text-transform:uppercase;color:var(--faint);font-weight:700;padding:0 13px 8px;">{{ __('admin.group.'.$groupKey) }}</div>
                    <div style="display:flex;flex-direction:column;gap:2px;">
                        @foreach ($ids as $id)
                            @php $sec = $all[$id]; $active = $isSection($id); $hidden = $sec['hideable'] && ! setting_raw("visibility.$id", true); @endphp
                            <div style="display:flex;align-items:center;border-radius:10px;{{ $active ? 'background:rgba(var(--accRGB,13,200,123),0.14);' : '' }}">
                                <a href="{{ route('admin.section.edit', $id) }}" style="flex:1;min-width:0;display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 13px;text-decoration:none;font-size:13.5px;font-weight:500;{{ $active ? 'color:var(--acc);' : 'color:var(--fg);' }}">
                                    <span style="display:flex;align-items:center;gap:10px;min-width:0;{{ $hidden ? 'opacity:.5;' : '' }}"><span style="color:var(--acc);display:inline-flex;flex:none;"><x-admin-icon :name="$sec['icon']" size="16" /></span><span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ tr($sec['label']) }}</span></span>
                                    @isset($counts[$id])<span style="font-size:11px;color:var(--faint);background:var(--panel2);padding:2px 7px;border-radius:99px;flex:none;">{{ $counts[$id] }}</span>@endisset
                                </a>
                                @if ($sec['hideable'])
                                    <form method="POST" action="{{ route('admin.visibility.toggle', $id) }}" style="flex:none;margin-inline-end:4px;">@csrf
                                        <button type="submit" title="Show / hide on site" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;background:transparent;border:none;cursor:pointer;color:var(--muted);">
                                            @if ($hidden)
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9.9 4.2A9.1 9.1 0 0 1 12 4c6 0 10 8 10 8a18 18 0 0 1-2.2 3.2M6.6 6.6A18 18 0 0 0 2 12s4 8 10 8a9 9 0 0 0 4-.9M3 3l18 18"/></svg>
                                            @else
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s4-8 10-8 10 8 10 8-4 8-10 8-10-8-10-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div style="margin-top:16px;">
                <div style="font-size:11px;letter-spacing:0.09em;text-transform:uppercase;color:var(--faint);font-weight:700;padding:0 13px 8px;">{{ __('admin.group.collections') }}</div>
                <a href="{{ route('admin.projects.index') }}" style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 13px;border-radius:10px;text-decoration:none;font-size:13.5px;font-weight:500;{{ request()->routeIs('admin.projects.*') ? 'background:rgba(var(--accRGB,13,200,123),0.14);color:var(--acc);' : 'color:var(--fg);' }}">
                    <span style="display:flex;align-items:center;gap:10px;"><span style="color:var(--acc);"><x-admin-icon name="folder" size="16" /></span>{{ __('admin.projects.title') }}</span>
                    <span style="font-size:11px;color:var(--faint);background:var(--panel2);padding:2px 7px;border-radius:99px;">{{ \App\Models\Project::count() }}</span>
                </a>
                <a href="{{ route('admin.messages.index') }}" style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 13px;border-radius:10px;text-decoration:none;font-size:13.5px;font-weight:500;{{ request()->routeIs('admin.messages.*') ? 'background:rgba(var(--accRGB,13,200,123),0.14);color:var(--acc);' : 'color:var(--fg);' }}">
                    <span style="display:flex;align-items:center;gap:10px;"><span style="color:var(--acc);"><x-admin-icon name="mail" size="16" /></span>{{ __('admin.nav.messages') }}</span>
                    @if ($unread)<span style="font-size:11px;color:#06281a;background:var(--acc);padding:2px 7px;border-radius:99px;font-weight:700;">{{ $unread }}</span>@endif
                </a>
                <a href="{{ route('admin.subscribers.index') }}" style="display:flex;align-items:center;gap:10px;padding:10px 13px;border-radius:10px;text-decoration:none;font-size:13.5px;font-weight:500;{{ request()->routeIs('admin.subscribers.*') ? 'background:rgba(var(--accRGB,13,200,123),0.14);color:var(--acc);' : 'color:var(--fg);' }}">
                    <span style="color:var(--acc);"><x-admin-icon name="users" size="16" /></span>{{ __('admin.nav.subscribers') }}
                </a>
            </div>

            <div style="margin-top:18px;padding:13px;border-radius:12px;background:var(--panel);border:1px solid var(--border);">
                <div style="font-size:12px;color:var(--muted);line-height:1.5;margin-bottom:10px;">{{ __('admin.data_note') }}</div>
                <div style="display:flex;gap:7px;">
                    <a href="{{ route('admin.export') }}" class="bt-btn-ghost" style="flex:1;height:34px;border-radius:9px;font-size:12.5px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">{{ __('admin.export') }}</a>
                    <form method="POST" action="{{ route('admin.import') }}" enctype="multipart/form-data" style="flex:1;">@csrf
                        <label class="bt-btn-ghost" style="height:34px;border-radius:9px;font-size:12.5px;font-weight:600;display:flex;align-items:center;justify-content:center;cursor:pointer;">{{ __('admin.import') }}<input type="file" name="file" accept="application/json" onchange="this.form.submit()" style="display:none;"></label>
                    </form>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="margin-top:14px;padding:0 4px;">@csrf
                <button type="submit" style="background:transparent;border:none;color:var(--muted);font-size:13px;font-weight:600;cursor:pointer;padding:8px 9px;">↪ {{ __('admin.logout') }}</button>
            </form>
        </nav>

        <main style="flex:1;min-width:0;padding:28px clamp(18px,4vw,40px);max-width:1080px;">
            @if ($errors->any())
                <div style="margin-bottom:18px;padding:14px 16px;border-radius:12px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ff8a8a;font-size:13.5px;">
                    @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    @if (session('toast'))
        <div class="bt-toast">{{ session('toast') }}</div>
    @endif
</body>
</html>
