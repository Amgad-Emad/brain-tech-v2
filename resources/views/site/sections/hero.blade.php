<section class="bt-hero" aria-label="Hero" style="position:relative;padding:172px 28px 110px;overflow:hidden;">
    <div aria-hidden="true" style="position:absolute;inset:0;background-image:linear-gradient(var(--grid) 1px,transparent 1px),linear-gradient(90deg,var(--grid) 1px,transparent 1px);background-size:64px 64px;animation:bt-grid 9s linear infinite;-webkit-mask-image:radial-gradient(ellipse 80% 65% at 50% 35%,#000 0%,transparent 75%);mask-image:radial-gradient(ellipse 80% 65% at 50% 35%,#000 0%,transparent 75%);"></div>
    <div aria-hidden="true" style="position:absolute;top:-140px;left:50%;transform:translateX(-50%);width:680px;height:520px;background:radial-gradient(circle,rgba(var(--accRGB),0.28),transparent 65%);filter:blur(20px);animation:bt-float 12s ease-in-out infinite;"></div>
    <div aria-hidden="true" style="position:absolute;top:40px;right:8%;width:420px;height:420px;background:radial-gradient(circle,rgba(var(--accRGB),0.20),transparent 65%);filter:blur(30px);animation:bt-float2 14s ease-in-out infinite;"></div>
    <div style="position:relative;max-width:920px;margin:0 auto;text-align:center;">
        @if (st('hero.badge'))
            <div data-reveal style="display:inline-flex;align-items:center;gap:9px;padding:7px 15px;border-radius:999px;background:var(--panel2);border:1px solid var(--border);font-size:13px;color:var(--muted);margin-bottom:30px;">
                <span style="width:7px;height:7px;border-radius:50%;background:var(--ic);box-shadow:0 0 10px var(--ic);"></span>
                {{ st('hero.badge') }}
            </div>
        @endif
        <h1 data-reveal="clip" style="transition-delay:.07s;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(40px,6.4vw,76px);line-height:1.04;letter-spacing:-0.025em;margin:0 0 22px;text-wrap:balance;">{{ st('hero.h1pre') }}<span style="background:var(--g);-webkit-background-clip:text;background-clip:text;color:transparent;">{{ st('hero.h1hi') }}</span>{{ st('hero.h1post') }}</h1>
        <p data-reveal style="transition-delay:.14s;font-size:clamp(17px,2vw,20px);line-height:1.6;color:var(--muted);max-width:620px;margin:0 auto 40px;text-wrap:pretty;">{{ st('hero.sub') }}</p>
        <div class="bt-hero-ctas" data-reveal style="transition-delay:.21s;display:flex;gap:14px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('contact') }}" style="display:inline-flex;align-items:center;justify-content:center;gap:9px;background:var(--g);color:#fff;text-decoration:none;font-size:16px;font-weight:600;padding:16px 30px;border-radius:13px;box-shadow:0 10px 34px rgba(var(--accRGB),0.4);">{{ st('hero.cta1', __('site.actions.start_project')) }}
                <x-icon name="arrow" size="17" :stroke="2.4" />
            </a>
            <a href="{{ route('work.index') }}" style="display:inline-flex;align-items:center;justify-content:center;gap:9px;background:var(--panel2);color:var(--fg);text-decoration:none;font-size:16px;font-weight:600;padding:16px 28px;border-radius:13px;border:1px solid var(--border2);">{{ st('hero.cta2', __('site.actions.see_work')) }}</a>
        </div>
    </div>
</section>
