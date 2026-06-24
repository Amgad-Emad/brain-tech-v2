@extends('layouts.site')

@section('content')
    <article style="padding:118px 28px 40px;">
        <div style="max-width:980px;margin:0 auto;">
            <a href="{{ route('work.index') }}" data-reveal style="display:inline-flex;align-items:center;gap:8px;color:var(--muted);text-decoration:none;font-size:14px;font-weight:600;margin-bottom:34px;">
                <x-icon name="arrow-back" size="16" :stroke="2.2" />
                {{ __('site.actions.back_to_work') }}
            </a>

            <div data-reveal style="margin-bottom:28px;">
                <span style="display:inline-block;font-size:11.5px;letter-spacing:0.06em;text-transform:uppercase;color:var(--acc);font-weight:600;background:rgba(var(--accRGB),0.12);padding:4px 10px;border-radius:999px;margin-bottom:18px;">{{ $project->t('tag') }}</span>
                <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(32px,5vw,56px);line-height:1.06;letter-spacing:-0.02em;margin:0;text-wrap:balance;">{{ $project->t('name') }}</h1>
            </div>

            <div data-reveal="scale" style="border-radius:22px;overflow:hidden;border:1px solid var(--border);margin-bottom:34px;aspect-ratio:16/8;background:var(--panel2);">
                <div role="img" aria-label="{{ $project->t('alt') }}" style="width:100%;height:100%;background-image:url('{{ $project->imageUrl() }}');background-size:cover;background-position:center;"></div>
            </div>

            <div class="bt-detail-meta" data-reveal style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;padding:24px;background:var(--panel);border:1px solid var(--border);border-radius:18px;margin-bottom:46px;">
                <div><div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);margin-bottom:6px;">{{ __('site.detail.client') }}</div><div style="font-weight:600;font-size:15px;">{{ $project->t('client') }}</div></div>
                <div><div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);margin-bottom:6px;">{{ __('site.detail.year') }}</div><div style="font-weight:600;font-size:15px;">{{ $project->year }}</div></div>
                <div><div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);margin-bottom:6px;">{{ __('site.detail.category') }}</div><div style="font-weight:600;font-size:15px;">{{ $project->t('tag') }}</div></div>
                <div><div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);margin-bottom:6px;">{{ __('site.detail.headline') }}</div><div style="font-weight:700;font-size:15px;background:var(--g);-webkit-background-clip:text;background-clip:text;color:transparent;">{{ $project->metric }}</div></div>
            </div>

            <div data-reveal style="max-width:760px;margin-bottom:48px;">
                <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ __('site.detail.overview') }}</p>
                <p style="font-size:clamp(18px,2.3vw,22px);line-height:1.55;font-weight:500;margin:0;text-wrap:pretty;">{{ $project->t('summary') }}</p>
            </div>

            <div class="bt-detail-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:26px;margin-bottom:48px;">
                <div data-reveal="left" style="background:var(--panel);border:1px solid var(--border);border-radius:18px;padding:30px;">
                    <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:20px;margin:0 0 14px;">{{ __('site.detail.challenge') }}</h2>
                    <p style="font-size:15px;line-height:1.7;color:var(--muted);margin:0;text-wrap:pretty;">{{ $project->t('challenge') }}</p>
                </div>
                <div data-reveal="right" style="background:var(--panel);border:1px solid var(--border);border-radius:18px;padding:30px;">
                    <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:20px;margin:0 0 14px;">{{ __('site.detail.approach') }}</h2>
                    <p style="font-size:15px;line-height:1.7;color:var(--muted);margin:0;text-wrap:pretty;">{{ $project->t('approach') }}</p>
                </div>
            </div>

            @if (is_array($project->results) && count($project->results))
                <div data-reveal style="margin-bottom:30px;">
                    <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 20px;">{{ __('site.detail.results') }}</p>
                    <div class="bt-stagger" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:18px;">
                        @foreach ($project->results as $result)
                            <div data-reveal style="background:var(--panel);border:1px solid var(--border);border-radius:18px;padding:28px;text-align:center;">
                                <div style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,42px);line-height:1;background:var(--g);-webkit-background-clip:text;background-clip:text;color:transparent;margin-bottom:10px;">{{ $result['metric'] ?? '' }}</div>
                                <div style="font-size:14px;color:var(--muted);">{{ tr($result['label'] ?? null) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (is_array($project->services_used) && count($project->services_used))
                <div data-reveal style="display:flex;flex-wrap:wrap;gap:9px;margin-bottom:56px;align-items:center;">
                    <span style="font-size:13px;color:var(--faint);font-weight:600;margin-inline-end:6px;">{{ __('site.detail.services') }}:</span>
                    @foreach ($project->services_used as $su)
                        <span style="font-size:13px;color:var(--muted);background:var(--panel2);border:1px solid var(--border);padding:6px 13px;border-radius:999px;">{{ tr($su) }}</span>
                    @endforeach
                </div>
            @endif

            <div data-reveal style="display:flex;flex-wrap:wrap;gap:18px;justify-content:space-between;align-items:center;border-top:1px solid var(--border);padding-top:34px;">
                <a href="{{ route('work.show', $next) }}" style="text-decoration:none;color:inherit;display:flex;flex-direction:column;gap:5px;">
                    <span style="font-size:12.5px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);">{{ __('site.detail.next') }}</span>
                    <span style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:19px;display:inline-flex;align-items:center;gap:8px;">{{ $next->t('name') }}
                        <x-icon name="arrow" size="17" :stroke="2.4" />
                    </span>
                </a>
                <a href="{{ route('contact') }}" style="display:inline-flex;align-items:center;gap:9px;background:var(--g);color:#fff;text-decoration:none;font-size:15px;font-weight:600;padding:14px 26px;border-radius:13px;box-shadow:0 10px 30px rgba(var(--accRGB),0.4);">{{ __('site.actions.start_project') }}</a>
            </div>
        </div>
    </article>
@endsection
