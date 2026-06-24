<section aria-label="Trusted by" style="padding:18px 28px 64px;">
    <div data-reveal style="max-width:1080px;margin:0 auto;text-align:center;">
        <p style="font-size:12.5px;letter-spacing:0.16em;text-transform:uppercase;color:var(--faint);margin:0 0 28px;font-weight:600;">{{ st('trust.label') }}</p>
        <div style="display:flex;flex-wrap:wrap;gap:18px 48px;align-items:center;justify-content:center;opacity:0.72;">
            @foreach (setting_raw('trust.logos', []) as $logo)
                <span style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:19px;color:var(--muted);letter-spacing:-0.01em;">{{ $logo }}</span>
            @endforeach
        </div>
    </div>
</section>
