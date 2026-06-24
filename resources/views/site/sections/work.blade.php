<section id="work" style="padding:80px 28px;scroll-margin-top:90px;">
    <div style="max-width:1240px;margin:0 auto;">
        <div data-reveal style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:18px;margin-bottom:50px;">
            <div style="max-width:560px;">
                <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('work.eyebrow') }}</p>
                <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,46px);line-height:1.08;letter-spacing:-0.02em;margin:0;">{{ st('work.title') }}</h2>
            </div>
            <a href="{{ route('contact') }}" style="color:var(--acc);text-decoration:none;font-size:14.5px;font-weight:600;display:inline-flex;align-items:center;gap:7px;">{{ st('work.start', __('site.actions.start_yours')) }}
                <x-icon name="arrow" size="15" :stroke="2.4" />
            </a>
        </div>
        <div class="bt-stagger" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:22px;">
            @foreach ($projects as $project)
                <a href="{{ route('work.show', $project) }}" data-reveal="rise" style="text-decoration:none;color:inherit;background:var(--panel);border:1px solid var(--border);border-radius:20px;overflow:hidden;display:block;">
                    <div style="height:210px;overflow:hidden;position:relative;background:var(--panel2);">
                        <div role="img" aria-label="{{ $project->t('alt') }}" style="position:absolute;inset:0;background-image:url('{{ $project->imageUrl() }}');background-size:cover;background-position:center;"></div>
                        <div aria-hidden="true" style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(8,8,11,0) 40%,rgba(8,8,11,0.55) 100%);pointer-events:none;"></div>
                    </div>
                    <div style="padding:24px 24px 26px;">
                        <span style="display:inline-block;font-size:11.5px;letter-spacing:0.06em;text-transform:uppercase;color:var(--acc);font-weight:600;background:rgba(var(--accRGB),0.12);padding:4px 10px;border-radius:999px;margin-bottom:14px;">{{ $project->t('tag') }}</span>
                        <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:19px;margin:0 0 16px;letter-spacing:-0.01em;">{{ $project->t('name') }}</h3>
                        <div style="display:flex;align-items:baseline;gap:8px;border-top:1px solid var(--border);padding-top:16px;">
                            <span style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:26px;background:var(--g);-webkit-background-clip:text;background-clip:text;color:transparent;">{{ $project->metric }}</span>
                            <span style="font-size:13px;color:var(--muted);">{{ $project->t('metric_label') }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
