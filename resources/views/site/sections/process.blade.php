<section id="process" style="padding:80px 28px;scroll-margin-top:90px;">
    <div style="max-width:1240px;margin:0 auto;">
        <div data-reveal style="text-align:center;max-width:640px;margin:0 auto 60px;">
            <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('process.eyebrow') }}</p>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,46px);line-height:1.08;letter-spacing:-0.02em;margin:0;">{{ st('process.title') }}</h2>
        </div>
        <div class="bt-process bt-stagger">
            @foreach ($steps as $step)
                <div class="bt-process-step" data-reveal>
                    @unless ($loop->last)
                        <span class="bt-process-connector" aria-hidden="true"></span>
                    @endunless
                    <div class="bt-process-node">{{ $step->number }}</div>
                    <div class="bt-process-content">
                        <h3 class="bt-process-title">{{ $step->t('title') }}</h3>
                        <p class="bt-process-desc">{{ $step->t('description') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
