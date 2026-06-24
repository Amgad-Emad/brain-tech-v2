<section id="about" style="padding:80px 28px;scroll-margin-top:90px;">
    <div style="max-width:1240px;margin:0 auto;">
        <div data-reveal style="text-align:center;max-width:640px;margin:0 auto 54px;">
            <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('values.eyebrow') }}</p>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,46px);line-height:1.08;letter-spacing:-0.02em;margin:0;">{{ st('values.title') }}</h2>
        </div>
        <div class="bt-stagger" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(232px,1fr));gap:20px;">
            @foreach ($values as $value)
                <div data-reveal style="padding:8px 4px;">
                    <div style="width:46px;height:46px;border-radius:12px;background:var(--panel2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:18px;color:var(--ic);">
                        <x-icon :name="$value->icon_key" size="22" />
                    </div>
                    <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:17px;margin:0 0 9px;">{{ $value->t('title') }}</h3>
                    <p style="font-size:14.5px;line-height:1.6;color:var(--muted);margin:0;">{{ $value->t('description') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
