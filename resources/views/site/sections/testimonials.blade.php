<section aria-label="Testimonials" style="padding:80px 28px;">
    <div style="max-width:920px;margin:0 auto;">
        <div data-reveal style="text-align:center;margin-bottom:46px;">
            <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('testimonials.eyebrow') }}</p>
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4vw,46px);line-height:1.08;letter-spacing:-0.02em;margin:0;">{{ st('testimonials.title') }}</h2>
        </div>
        <div data-reveal="scale" style="position:relative;background:var(--panel);border:1px solid var(--border);border-radius:24px;overflow:hidden;backdrop-filter:blur(12px);">
            <div style="overflow:hidden;direction:ltr;">
                <div class="bt-slider-track" data-slider-track>
                    @foreach ($testimonials as $tm)
                        <div dir="{{ is_rtl() ? 'rtl' : 'ltr' }}" style="flex:0 0 100%;padding:48px 52px;box-sizing:border-box;text-align:center;">
                            <div aria-hidden="true" style="font-family:'Space Grotesk',sans-serif;font-size:44px;line-height:0.5;color:var(--acc);height:24px;">&ldquo;</div>
                            <p style="font-size:clamp(18px,2.4vw,23px);line-height:1.55;font-weight:500;margin:0 auto 28px;max-width:660px;color:var(--fg);text-wrap:pretty;">{{ $tm->t('quote') }}</p>
                            <div style="display:flex;align-items:center;justify-content:center;gap:13px;">
                                <div aria-hidden="true" style="width:44px;height:44px;border-radius:50%;background:var(--g);display:flex;align-items:center;justify-content:center;font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:16px;color:#fff;">{{ $tm->initials }}</div>
                                <div style="text-align:start;">
                                    <div style="font-weight:600;font-size:15px;">{{ $tm->t('name') }}</div>
                                    <div style="font-size:13px;color:var(--muted);">{{ $tm->t('role') }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if ($testimonials->count() > 1)
                <button type="button" data-slider-prev aria-label="Previous testimonial" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);width:42px;height:42px;border-radius:50%;background:var(--panel2);border:1px solid var(--border);color:var(--fg);cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
                </button>
                <button type="button" data-slider-next aria-label="Next testimonial" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);width:42px;height:42px;border-radius:50%;background:var(--panel2);border:1px solid var(--border);color:var(--fg);cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>
                </button>
            @endif
        </div>
        @if ($testimonials->count() > 1)
            <div style="display:flex;justify-content:center;gap:9px;margin-top:26px;">
                @foreach ($testimonials as $i => $tm)
                    <button type="button" class="bt-slider-dot" data-slider-dot aria-label="Go to testimonial {{ $i + 1 }}" style="border:none;cursor:pointer;padding:0;height:8px;border-radius:999px;"></button>
                @endforeach
            </div>
        @endif
    </div>
</section>
