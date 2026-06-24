@extends('layouts.site')

@section('content')
    <article style="padding:120px 28px 30px;">
        <div style="max-width:960px;margin:0 auto;">
            <div data-reveal style="text-align:center;max-width:760px;margin:0 auto 56px;">
                <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('about.eyebrow') }}</p>
                <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(34px,5vw,58px);line-height:1.06;letter-spacing:-0.02em;margin:0 0 20px;text-wrap:balance;">{{ st('about.title') }}</h1>
                <p style="font-size:clamp(17px,2vw,20px);line-height:1.6;color:var(--muted);margin:0;text-wrap:pretty;">{{ st('about.lead') }}</p>
            </div>

            <div class="bt-detail-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:26px;margin-bottom:14px;">
                <div data-reveal="left" style="background:var(--panel);border:1px solid var(--border);border-radius:18px;padding:32px;">
                    <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:20px;margin:0 0 14px;">{{ st('about.story_title') }}</h2>
                    <p style="font-size:15px;line-height:1.7;color:var(--muted);margin:0 0 16px;text-wrap:pretty;">{{ st('about.story1') }}</p>
                    <p style="font-size:15px;line-height:1.7;color:var(--muted);margin:0;text-wrap:pretty;">{{ st('about.story2') }}</p>
                </div>
                <div data-reveal="right" style="background:linear-gradient(135deg,rgba(var(--accRGB),0.12),rgba(var(--accRGB),0.06));border:1px solid var(--border);border-radius:18px;padding:32px;display:flex;flex-direction:column;justify-content:center;">
                    <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:20px;margin:0 0 14px;">{{ st('about.mission_title') }}</h2>
                    <p style="font-size:clamp(17px,2vw,21px);line-height:1.55;font-weight:500;margin:0;text-wrap:pretty;">{{ st('about.mission') }}</p>
                </div>
            </div>

            <div style="margin:50px 0 10px;">
                <h2 data-reveal style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(24px,3vw,34px);letter-spacing:-0.02em;margin:0 0 30px;text-align:center;">{{ st('about.values_title') }}</h2>
                <div class="bt-stagger" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;">
                    @foreach ($values as $value)
                        <div data-reveal style="background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:26px;">
                            <div style="width:46px;height:46px;border-radius:12px;background:var(--panel2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:18px;color:var(--ic);">
                                <x-icon :name="$value->icon_key" size="22" />
                            </div>
                            <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:17px;margin:0 0 9px;">{{ $value->t('title') }}</h3>
                            <p style="font-size:14.5px;line-height:1.6;color:var(--muted);margin:0;">{{ $value->t('description') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($stats->isNotEmpty())
                <div style="margin-top:46px;">
                    <div data-reveal="scale" style="background:linear-gradient(135deg,rgba(var(--accRGB),0.1),rgba(var(--accRGB),0.06));border:1px solid var(--border);border-radius:24px;padding:48px 32px;">
                        <div class="bt-stats-row bt-stagger" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;text-align:center;">
                            @foreach ($stats as $stat)
                                <div data-reveal>
                                    <div data-count="{{ $stat->value }}" data-suffix="{{ $stat->suffix }}" style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(32px,5vw,50px);line-height:1;letter-spacing:-0.02em;background:var(--g);-webkit-background-clip:text;background-clip:text;color:transparent;margin-bottom:10px;">{{ $stat->display() }}</div>
                                    <div style="font-size:14px;color:var(--muted);font-weight:500;">{{ $stat->t('label') }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </article>

    @if (st('visibility.cta', true))
        @include('site.sections.cta')
    @endif
@endsection
