<section aria-label="Technologies we work with" style="padding:18px 28px 64px;">
    <div data-reveal style="max-width:1080px;margin:0 auto;text-align:center;">
        <p style="font-size:12.5px;letter-spacing:0.16em;text-transform:uppercase;color:var(--faint);margin:0 0 32px;font-weight:600;">{{ st('trust.label') }}</p>
        <div style="display:flex;flex-wrap:wrap;gap:30px 36px;align-items:flex-start;justify-content:center;">
            @foreach ($techLogos ?? [] as $logo)
                @php $name = tr($logo->name); @endphp
                <div style="display:flex;flex-direction:column;align-items:center;gap:11px;width:84px;">
                    <span style="width:64px;height:64px;border-radius:16px;background:#fff;display:flex;align-items:center;justify-content:center;padding:10px;box-shadow:0 6px 20px rgba(0,0,0,0.25);">
                        <img src="{{ asset($logo->image) }}" alt="{{ $name }}" loading="lazy" style="max-width:100%;max-height:100%;object-fit:contain;">
                    </span>
                    <span style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:12.5px;color:var(--muted);letter-spacing:-0.01em;">{{ $name }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>
