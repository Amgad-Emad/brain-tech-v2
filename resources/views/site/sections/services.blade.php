<section id="services" style="padding:80px 28px;scroll-margin-top:90px;">
    <div style="max-width:1240px;margin:0 auto;">
        <div data-reveal style="max-width:680px;margin-bottom:54px;">
            <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('services.eyebrow') }}</p>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,46px);line-height:1.08;letter-spacing:-0.02em;margin:0 0 16px;">{{ st('services.title') }}</h2>
            <p style="font-size:17px;line-height:1.6;color:var(--muted);margin:0;">{{ st('services.sub') }}</p>
        </div>
        <div class="bt-stagger" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(258px,1fr));gap:20px;">
            @foreach ($services as $service)
                <article data-reveal="scale" style="position:relative;background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:30px 28px;backdrop-filter:blur(12px);display:flex;flex-direction:column;overflow:hidden;">
                    @if ($service->offer_enabled)
                        <span style="position:absolute;top:0;inset-inline-end:0;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;background:var(--g);color:#06281a;font-size:10.5px;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;padding:6px 14px;border-radius:0 20px 0 14px;box-shadow:0 4px 16px rgba(var(--accRGB),0.45);">
                            <x-icon name="tag" size="11" :stroke="2.4" />{{ $service->t('offer_label') }}
                        </span>
                    @endif
                    <div style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,rgba(var(--accRGB),0.22),rgba(var(--accRGB),0.10));border:1px solid var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:22px;color:var(--ic);">
                        <x-icon :name="$service->icon_key" size="24" />
                    </div>
                    <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:19px;margin:0 0 10px;letter-spacing:-0.01em;">{{ $service->t('title') }}</h3>
                    <p style="font-size:14.5px;line-height:1.6;color:var(--muted);margin:0 0 22px;flex:1;">{{ $service->t('description') }}</p>
                    @if ($service->offer_enabled)
                        <div style="position:relative;border-radius:14px;padding:16px;margin:0 0 20px;background:linear-gradient(135deg,rgba(var(--accRGB),0.14),rgba(var(--accRGB),0.05));border:1px solid rgba(var(--accRGB),0.35);">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                                <span style="display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:7px;background:var(--g);color:#06281a;flex:none;"><x-icon name="tag" size="13" :stroke="2.4" /></span>
                                <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:15px;color:var(--fg);">{{ $service->t('offer_title') }}</span>
                            </div>
                            <div style="font-size:12.5px;color:var(--muted);line-height:1.55;">{{ $service->t('offer_text') }}</div>
                            @if ($service->t('offer_until'))
                                <div style="display:inline-flex;align-items:center;gap:5px;margin-top:10px;font-size:11px;font-weight:700;color:#06281a;background:var(--g);padding:3px 9px;border-radius:99px;"><x-icon name="clock" size="11" :stroke="2.4" />{{ $service->t('offer_until') }}</div>
                            @endif
                        </div>
                    @endif
                    <a href="{{ route('services') }}" style="display:inline-flex;align-items:center;gap:7px;color:var(--acc);text-decoration:none;font-size:14px;font-weight:600;">{{ st('services.learn', __('site.actions.learn_more')) }}
                        <x-icon name="arrow" size="15" :stroke="2.4" />
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
