@php
    $navLinks = [
        ['label' => st('nav.home', __('site.nav.home')), 'href' => route('home')],
        ['label' => st('nav.services', __('site.nav.services')), 'href' => route('services')],
        ['label' => st('nav.work', __('site.nav.work')), 'href' => route('work.index')],
        ['label' => st('nav.process', __('site.nav.process')), 'href' => route('home').'#process'],
        ['label' => st('nav.about', __('site.nav.about')), 'href' => route('about')],
        ['label' => st('nav.contact', __('site.nav.contact')), 'href' => route('contact')],
    ];
    $quoteLabel = st('nav.quote', __('site.nav.quote'));
    $otherLocale = app()->getLocale() === 'ar' ? 'en' : 'ar';
@endphp

<header style="position:fixed;top:0;left:0;right:0;z-index:100;">
    <nav class="bt-nav" data-nav aria-label="Primary">
        <div class="bt-nav-inner" style="max-width:1240px;margin:0 auto;padding:0 28px;height:72px;display:grid;grid-template-columns:auto 1fr auto;align-items:center;gap:12px;">
            <a href="{{ route('home') }}" class="bt-brand" style="display:flex;align-items:center;gap:11px;text-decoration:none;color:var(--fg);justify-self:start;min-width:0;">
                <span class="bt-brand-mark" style="width:38px;height:38px;flex:none;border-radius:10px;background:#0c0c11;border:1px solid rgba(255,255,255,0.1);display:inline-flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(var(--accRGB),0.3);">
                    <img src="{{ asset('Brain-Tech-Premium-Website/brand/mark.png') }}" alt="{{ st('brand.name') }} logo" style="width:23px;height:auto;display:block;" />
                </span>
                <span class="bt-brand-text" style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:18px;letter-spacing:-0.01em;white-space:nowrap;">Brain<span style="color:var(--acc);">Tech</span></span>
            </a>

            <ul class="bt-desktop-nav" style="display:flex;gap:32px;list-style:none;margin:0;padding:0;justify-self:center;">
                @foreach ($navLinks as $lnk)
                    <li><a href="{{ $lnk['href'] }}" style="color:var(--muted);text-decoration:none;font-size:14.5px;font-weight:500;transition:color .2s;">{{ $lnk['label'] }}</a></li>
                @endforeach
            </ul>

            <div class="bt-nav-actions" style="justify-self:end;display:flex;align-items:center;gap:8px;">
                <a href="{{ locale_url($otherLocale) }}" aria-label="{{ __('site.actions.toggle_lang') }}" class="bt-nav-btn bt-lang-btn" style="display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:11px;background:var(--panel2);border:1px solid var(--border);cursor:pointer;color:var(--fg);font-size:13px;font-weight:700;letter-spacing:0.02em;text-decoration:none;white-space:nowrap;">{{ strtoupper($otherLocale) }}</a>
                <button type="button" data-theme-toggle aria-label="{{ __('site.actions.toggle_theme') }}" class="bt-nav-btn" style="display:inline-flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:11px;background:var(--panel2);border:1px solid var(--border);cursor:pointer;color:var(--fg);"><span data-theme-icon>☾</span></button>
                <a href="{{ route('contact') }}" class="bt-cta-desktop" style="display:inline-flex;align-items:center;gap:8px;background:var(--g);color:#fff;text-decoration:none;font-size:14px;font-weight:600;padding:10px 18px;border-radius:11px;box-shadow:0 6px 22px rgba(var(--accRGB),0.35);">{{ $quoteLabel }}</a>
                <button type="button" class="bt-burger bt-nav-btn" data-menu-toggle aria-label="{{ __('site.actions.toggle_menu') }}" aria-expanded="false" style="display:none;align-items:center;justify-content:center;width:42px;height:42px;border-radius:11px;background:var(--panel2);border:1px solid var(--border);cursor:pointer;color:var(--fg);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="7" x2="21" y2="7"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="17" x2="21" y2="17"/></svg>
                </button>
            </div>
        </div>

        <div class="bt-mobile-panel" data-mobile-panel style="overflow:hidden;background:var(--bg);backdrop-filter:blur(16px);border-bottom:1px solid var(--border);transition:max-height .4s ease,opacity .3s ease;">
            <ul style="list-style:none;margin:0;padding:14px 28px 22px;display:flex;flex-direction:column;gap:4px;">
                @foreach ($navLinks as $lnk)
                    <li><a href="{{ $lnk['href'] }}" style="display:block;padding:12px 6px;color:var(--fg);text-decoration:none;font-size:16px;font-weight:500;border-bottom:1px solid var(--border);">{{ $lnk['label'] }}</a></li>
                @endforeach
                <li style="margin-top:12px;"><a href="{{ route('contact') }}" style="display:block;text-align:center;background:var(--g);color:#fff;text-decoration:none;font-size:15px;font-weight:600;padding:13px;border-radius:12px;">{{ $quoteLabel }}</a></li>
            </ul>
        </div>
    </nav>
</header>
