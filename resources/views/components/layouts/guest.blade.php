<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ is_rtl() ? 'rtl' : 'ltr' }}" data-bt-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? __('Sign in') }} · {{ st('brand.name', config('app.name')) }}</title>

    <link rel="icon" href="{{ asset('Brain-Tech-Premium-Website/brand/mark.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        try { document.documentElement.setAttribute('data-bt-theme', localStorage.getItem('bt-theme') || 'dark'); } catch (e) {}
    </script>

    @vite(['resources/css/app.css', 'resources/css/site.css', 'resources/js/app.js'])
</head>
<body style="background:var(--bg);color:var(--fg);min-height:100vh;">
    <div style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 20px;position:relative;overflow:hidden;">
        <div aria-hidden="true" style="position:absolute;inset:0;background-image:linear-gradient(var(--grid) 1px,transparent 1px),linear-gradient(90deg,var(--grid) 1px,transparent 1px);background-size:64px 64px;animation:bt-grid 9s linear infinite;-webkit-mask-image:radial-gradient(ellipse 70% 60% at 50% 40%,#000 0%,transparent 75%);mask-image:radial-gradient(ellipse 70% 60% at 50% 40%,#000 0%,transparent 75%);"></div>
        <div aria-hidden="true" style="position:absolute;top:-120px;left:50%;transform:translateX(-50%);width:560px;height:420px;background:radial-gradient(circle,rgba(var(--accRGB),0.22),transparent 65%);filter:blur(26px);animation:bt-float 12s ease-in-out infinite;"></div>

        <a href="{{ url('/') }}" style="position:relative;display:flex;align-items:center;gap:11px;text-decoration:none;color:var(--fg);margin-bottom:28px;">
            <span style="width:44px;height:44px;border-radius:12px;background:#0c0c11;border:1px solid rgba(255,255,255,0.1);display:inline-flex;align-items:center;justify-content:center;box-shadow:0 4px 18px rgba(var(--accRGB),0.35);">
                <img src="{{ asset('Brain-Tech-Premium-Website/brand/mark.png') }}" alt="{{ st('brand.name') }}" style="width:26px;height:auto;display:block;" />
            </span>
            <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:21px;letter-spacing:-0.01em;">Brain<span style="color:var(--acc);">Tech</span></span>
        </a>

        <div style="position:relative;width:100%;max-width:430px;background:var(--panel);border:1px solid var(--border);border-radius:22px;padding:34px 32px;backdrop-filter:blur(14px);box-shadow:0 24px 60px rgba(0,0,0,0.45);">
            {{ $slot }}
        </div>

        <a href="{{ url('/') }}" style="position:relative;margin-top:24px;font-size:13.5px;color:var(--muted);text-decoration:none;">← {{ __('Back to website') }}</a>
    </div>
</body>
</html>
