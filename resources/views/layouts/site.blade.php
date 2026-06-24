@php
    $locale = app()->getLocale();
    $accent = st('theme.accent', '#34e0a0');
    $gradFrom = st('theme.grad_from', '#0ddc83');
    $gradTo = st('theme.grad_to', '#16e89a');
    [$ar, $ag, $ab] = sscanf($accent, '#%02x%02x%02x') ?: [13, 200, 123];

    // --- SEO ---------------------------------------------------------
    $brandName = st('brand.name', config('app.name', 'Brain-Tech'));
    $seoTitle = $metaTitle ?? st('seo.home_title', $brandName);
    $seoDescription = $metaDescription ?? st('seo.home_description', '');
    $ogImage = asset('Brain-Tech-Premium-Website/brand/mark-512.png');
    $socialUrls = collect(setting_raw('social.items', []))
        ->pluck('url')->filter(fn ($u) => $u && $u !== '#')->values()->all();

    $organizationLd = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => $brandName,
        'description' => st('seo.home_description'),
        'url' => url('/'),
        'email' => st('contact.email'),
        'telephone' => st('contact.phone'),
        'address' => st('contact.office'),
        'image' => $ogImage,
        'sameAs' => $socialUrls ?: null,
    ]);
    $websiteLd = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $brandName,
        'url' => url('/'),
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ is_rtl() ? 'rtl' : 'ltr' }}" data-bt-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="theme-color" content="#08080b">
    <link rel="canonical" href="{{ url()->current() }}">

    @foreach (LaravelLocalization::getSupportedLocales() as $code => $props)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ LaravelLocalization::getLocalizedURL($code, null, [], true) }}">
    @endforeach

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $brandName }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="{{ str_replace('-', '_', $locale) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <script type="application/ld+json">@json($organizationLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    <script type="application/ld+json">@json($websiteLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    @stack('structured-data')

    <link rel="icon" href="{{ asset('Brain-Tech-Premium-Website/brand/mark.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Apply persisted theme before paint to avoid a flash --}}
    <script>
        try {
            var t = localStorage.getItem('bt-theme') || 'dark';
            document.documentElement.setAttribute('data-bt-theme', t);
        } catch (e) {}
    </script>

    @stack('head')
    @vite(($previewMode ?? false) ? ['resources/css/site.css'] : ['resources/css/site.css', 'resources/js/site.js'])

    {{-- CMS-controlled accent / gradient — MUST come after @vite(site.css) so it
         overrides the default palette instead of being overridden by it. --}}
    <style>
        :root, html[data-bt-theme] {
            --acc: {{ $accent }};
            --ic: {{ $accent }};
            --accRGB: {{ $ar }}, {{ $ag }}, {{ $ab }};
            --g: linear-gradient(135deg, {{ $gradFrom }} 0%, {{ $gradTo }} 100%);
        }
    </style>
</head>
<body style="background:var(--bg);color:var(--fg);min-height:100vh;position:relative;">
    @include('site.partials.nav')

    <main>
        @yield('content')
    </main>

    @include('site.partials.footer')
    @include('site.partials.whatsapp')
</body>
</html>
