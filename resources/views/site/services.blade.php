@extends('layouts.site')

@section('content')
    <article style="padding:120px 28px 30px;">
        <div style="max-width:1000px;margin:0 auto;">
            <div data-reveal style="text-align:center;max-width:720px;margin:0 auto 54px;">
                <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('services_page.eyebrow') }}</p>
                <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(34px,5vw,58px);line-height:1.06;letter-spacing:-0.02em;margin:0 0 20px;text-wrap:balance;">{{ st('services_page.title') }}</h1>
                <p style="font-size:clamp(17px,2vw,20px);line-height:1.6;color:var(--muted);margin:0;text-wrap:pretty;">{{ st('services_page.lead') }}</p>
            </div>

            <div class="bt-stagger" style="display:flex;flex-direction:column;gap:22px;">
                @foreach ($services as $service)
                    <div data-reveal style="background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:34px;display:grid;grid-template-columns:auto 1fr;gap:26px;align-items:start;">
                        <div style="width:58px;height:58px;border-radius:15px;background:linear-gradient(135deg,rgba(var(--accRGB),0.22),rgba(var(--accRGB),0.18));border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--ic);">
                            <x-icon :name="$service->icon_key" size="26" />
                        </div>
                        <div>
                            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:22px;margin:0 0 6px;letter-spacing:-0.01em;">{{ $service->t('title') }}</h2>
                            <p style="color:var(--acc);font-weight:600;font-size:15px;margin:0 0 14px;">{{ $service->t('tagline') }}</p>
                            <p style="font-size:15px;line-height:1.7;color:var(--muted);margin:0 0 22px;max-width:640px;text-wrap:pretty;">{{ $service->t('long_description') ?: $service->t('description') }}</p>

                            @if ($service->offer_enabled)
                                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:14px 20px;border-radius:16px;padding:18px 22px;margin:0 0 24px;max-width:640px;background:linear-gradient(135deg,rgba(var(--accRGB),0.15),rgba(var(--accRGB),0.05));border:1px solid rgba(var(--accRGB),0.4);">
                                    <div style="display:flex;align-items:center;justify-content:center;width:46px;height:46px;border-radius:12px;background:var(--g);color:#06281a;flex:none;"><x-icon name="tag" size="22" :stroke="2.2" /></div>
                                    <div style="flex:1;min-width:180px;">
                                        <div style="display:flex;align-items:center;gap:9px;margin-bottom:3px;flex-wrap:wrap;">
                                            <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:17px;color:var(--fg);">{{ $service->t('offer_title') }}</span>
                                            <span style="font-size:10px;font-weight:800;letter-spacing:0.06em;text-transform:uppercase;color:#06281a;background:var(--g);padding:3px 9px;border-radius:99px;">{{ $service->t('offer_label') }}</span>
                                        </div>
                                        <div style="font-size:13.5px;color:var(--muted);line-height:1.55;">{{ $service->t('offer_text') }}</div>
                                    </div>
                                    @if ($service->t('offer_until'))
                                        <div style="display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:700;color:var(--acc);white-space:nowrap;"><x-icon name="clock" size="13" :stroke="2.2" />{{ $service->t('offer_until') }}</div>
                                    @endif
                                </div>
                            @endif

                            @if (is_array($service->deliverables) && count($service->deliverables))
                                <p style="font-size:12.5px;letter-spacing:0.08em;text-transform:uppercase;color:var(--faint);font-weight:600;margin:0 0 14px;">{{ __('site.services_page.deliverables') }}</p>
                                <ul style="list-style:none;margin:0;padding:0;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:11px 24px;">
                                    @foreach ($service->deliverables as $deliverable)
                                        <li style="display:flex;align-items:center;gap:10px;font-size:14.5px;color:var(--fg);">
                                            <span style="flex:none;width:19px;height:19px;border-radius:50%;background:rgba(var(--accRGB),0.16);color:var(--acc);display:inline-flex;align-items:center;justify-content:center;"><x-icon name="check" size="11" :stroke="3" /></span>
                                            {{ tr($deliverable) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </article>

    @if (st('visibility.cta', true))
        @include('site.sections.cta')
    @endif
@endsection
