<section id="process" style="padding:80px 28px;scroll-margin-top:90px;">
    <div style="max-width:1240px;margin:0 auto;">
        <div data-reveal style="text-align:center;max-width:640px;margin:0 auto 60px;">
            <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('process.eyebrow') }}</p>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,46px);line-height:1.08;letter-spacing:-0.02em;margin:0;">{{ st('process.title') }}</h2>
        </div>
        <div class="bt-process-row bt-stagger" style="display:flex;gap:0;align-items:flex-start;">
            @foreach ($steps as $i => $step)
                <div data-reveal style="flex:1;min-width:0;position:relative;display:flex;flex-direction:column;align-items:center;text-align:center;padding:0 14px;">
                    @unless ($loop->last)
                        <div class="bt-proc-line" style="position:absolute;top:26px;inset-inline-start:50%;width:100%;height:1px;background:linear-gradient(90deg,var(--acc),transparent);z-index:0;opacity:.4;"></div>
                    @endunless
                    <div style="position:relative;z-index:1;width:54px;height:54px;border-radius:50%;background:var(--bg);border:1px solid var(--border2);display:flex;align-items:center;justify-content:center;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:17px;background-image:linear-gradient(135deg,rgba(var(--accRGB),0.18),rgba(var(--accRGB),0.18));margin-bottom:20px;">{{ $step->number }}</div>
                    <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:18px;margin:0 0 9px;">{{ $step->t('title') }}</h3>
                    <p style="font-size:14px;line-height:1.6;color:var(--muted);margin:0;max-width:220px;">{{ $step->t('description') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
