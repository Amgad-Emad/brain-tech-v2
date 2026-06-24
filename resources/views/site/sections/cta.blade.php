<section id="contact-cta" style="padding:60px 28px 90px;scroll-margin-top:90px;">
    <div data-reveal="scale" style="position:relative;max-width:1080px;margin:0 auto;border-radius:28px;overflow:hidden;background:var(--g);padding:clamp(48px,7vw,84px) 32px;text-align:center;">
        <div aria-hidden="true" style="position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.07) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.07) 1px,transparent 1px);background-size:48px 48px;-webkit-mask-image:radial-gradient(ellipse 70% 90% at 50% 50%,#000,transparent 75%);mask-image:radial-gradient(ellipse 70% 90% at 50% 50%,#000,transparent 75%);"></div>
        <div style="position:relative;">
            <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(30px,4.6vw,50px);line-height:1.08;letter-spacing:-0.02em;margin:0 auto 18px;color:#fff;max-width:680px;text-wrap:balance;">{{ st('cta.title') }}</h2>
            <p style="font-size:18px;line-height:1.55;color:rgba(255,255,255,0.82);max-width:520px;margin:0 auto 36px;">{{ st('cta.sub') }}</p>
            <a href="{{ route('contact') }}" style="display:inline-flex;align-items:center;gap:10px;background:#fff;color:#1a1a2e;text-decoration:none;font-size:16px;font-weight:600;padding:17px 34px;border-radius:13px;box-shadow:0 14px 40px rgba(0,0,0,0.28);">{{ st('cta.btn', __('site.nav.quote')) }}
                <x-icon name="arrow" size="17" :stroke="2.4" />
            </a>
        </div>
    </div>
</section>
