@php
    $logos = $techLogos ?? collect();
    $count = count($logos);
    // Each tile is 84px wide + 18px margin each side = 120px. Repeat the set so a
    // single scrolling group is always wider than the viewport (even ultrawide),
    // which keeps the loop seam invisible — one endless row, no gap on restart.
    $reps = max(1, (int) ceil(3000 / max(1, $count * 120)));
@endphp
<section aria-label="Technologies we work with" style="padding:18px 0 64px;overflow:hidden;">
    <div data-reveal style="max-width:1080px;margin:0 auto 32px;text-align:center;padding:0 28px;">
        <p style="font-size:12.5px;letter-spacing:0.16em;text-transform:uppercase;color:var(--faint);margin:0;font-weight:600;">{{ st('trust.label') }}</p>
    </div>

    @if ($count)
        <style>
            /* direction:ltr (on the whole marquee, not just the track) keeps the
               scroll seamless on RTL pages — otherwise the wide track is right-
               aligned and laid out right-to-left while the animation moves left,
               so a blank gap opens on the right. Logos + Latin names have no
               reading direction, so forcing LTR here is purely visual. */
            .bt-marquee{position:relative;width:100%;overflow:hidden;direction:ltr;
                -webkit-mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent);
                        mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent);}
            .bt-marquee-track{display:flex;direction:ltr;width:max-content;align-items:flex-start;
                animation:bt-marquee-scroll 40s linear infinite;will-change:transform;}
            .bt-marquee:hover .bt-marquee-track{animation-play-state:paused;}
            .bt-marquee-group{display:flex;align-items:flex-start;flex:0 0 auto;}
            .bt-marquee-item{flex:0 0 auto;width:84px;margin:0 18px;display:flex;flex-direction:column;align-items:center;gap:11px;}
            .bt-marquee-logo{width:64px;height:64px;border-radius:16px;background:#fff;display:flex;align-items:center;justify-content:center;padding:10px;box-shadow:0 6px 20px rgba(0,0,0,0.25);}
            .bt-marquee-logo img{max-width:100%;max-height:100%;object-fit:contain;}
            .bt-marquee-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:12.5px;color:var(--muted);letter-spacing:-0.01em;text-align:center;}
            /* Two identical groups; -50% advances exactly one group, so the second
               lands where the first began — a seamless, continuous loop. */
            @keyframes bt-marquee-scroll{from{transform:translateX(0)}to{transform:translateX(-50%)}}
            @media (prefers-reduced-motion:reduce){
                .bt-marquee{mask-image:none;-webkit-mask-image:none;}
                .bt-marquee-track{animation:none;flex-wrap:wrap;justify-content:center;width:auto;max-width:1080px;margin:0 auto;row-gap:30px;}
                .bt-marquee-group{display:contents;}
                .bt-marquee-item:not(.bt-first){display:none;}
            }
        </style>
        <div class="bt-marquee">
            <div class="bt-marquee-track">
                @for ($g = 0; $g < 2; $g++)
                    <div class="bt-marquee-group" @if ($g > 0) aria-hidden="true" @endif>
                        @for ($r = 0; $r < $reps; $r++)
                            @foreach ($logos as $i => $logo)
                                @php $name = tr($logo->name); $first = $g === 0 && $r === 0; @endphp
                                <div class="bt-marquee-item{{ $first ? ' bt-first' : '' }}">
                                    <span class="bt-marquee-logo"><img src="{{ asset($logo->image) }}" alt="{{ $first ? $name : '' }}" loading="lazy"></span>
                                    <span class="bt-marquee-name">{{ $name }}</span>
                                </div>
                            @endforeach
                        @endfor
                    </div>
                @endfor
            </div>
        </div>
    @endif
</section>
