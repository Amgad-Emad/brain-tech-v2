<section aria-label="Frequently asked questions" style="padding:80px 28px;">
    <div style="max-width:820px;margin:0 auto;">
        <div data-reveal style="text-align:center;margin-bottom:46px;">
            <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('faq.eyebrow') }}</p>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,46px);line-height:1.08;letter-spacing:-0.02em;margin:0;">{{ st('faq.title') }}</h2>
        </div>
        <div class="bt-stagger" style="display:flex;flex-direction:column;gap:12px;">
            @foreach ($faqs as $i => $faq)
                <div data-reveal class="bt-faq-item {{ $i === 0 ? 'bt-open' : '' }}" style="background:var(--panel);border:1px solid var(--border);border-radius:16px;overflow:hidden;">
                    <button type="button" data-faq-toggle aria-expanded="{{ $i === 0 ? 'true' : 'false' }}" style="width:100%;display:flex;align-items:center;justify-content:space-between;gap:16px;padding:22px 24px;background:transparent;border:none;cursor:pointer;text-align:start;color:var(--fg);font-family:inherit;">
                        <span style="font-weight:600;font-size:16.5px;">{{ $faq->t('question') }}</span>
                        <span class="bt-faq-icon" style="flex:none;display:inline-flex;align-items:center;justify-content:center;width:26px;height:26px;border-radius:50%;background:var(--panel2);border:1px solid var(--border);transition:transform .3s ease;">
                            <x-icon name="plus" size="14" :stroke="2.4" />
                        </span>
                    </button>
                    <div class="bt-faq-panel">
                        <p style="margin:0;padding:0 24px 24px;font-size:15px;line-height:1.65;color:var(--muted);text-wrap:pretty;">{{ $faq->t('answer') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
