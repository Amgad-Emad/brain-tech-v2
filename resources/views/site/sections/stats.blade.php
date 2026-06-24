<section id="stats-band" aria-label="Key statistics" style="padding:60px 28px;">
    <div data-reveal="scale" style="max-width:1160px;margin:0 auto;background:linear-gradient(135deg,rgba(var(--accRGB),0.1),rgba(var(--accRGB),0.08));border:1px solid var(--border);border-radius:24px;padding:54px 32px;backdrop-filter:blur(12px);">
        <div class="bt-stats-row bt-stagger" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;text-align:center;">
            @foreach ($stats as $stat)
                <div data-reveal>
                    <div data-count="{{ $stat->value }}" data-suffix="{{ $stat->suffix }}" style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(36px,5vw,54px);line-height:1;letter-spacing:-0.02em;background:var(--g);-webkit-background-clip:text;background-clip:text;color:transparent;margin-bottom:10px;">{{ $stat->display() }}</div>
                    <div style="font-size:14px;color:var(--muted);font-weight:500;">{{ $stat->t('label') }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
