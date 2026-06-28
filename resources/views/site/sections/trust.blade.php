@php $logos = $techLogos ?? collect(); @endphp
<section aria-label="Technologies we work with" style="padding:18px 0 64px;overflow:hidden;">
    <div data-reveal style="max-width:1080px;margin:0 auto 32px;text-align:center;padding:0 28px;">
        <p style="font-size:12.5px;letter-spacing:0.16em;text-transform:uppercase;color:var(--faint);margin:0;font-weight:600;">{{ st('trust.label') }}</p>
    </div>

    @if (count($logos))
        <style>
            .bt-marquee{position:relative;width:100%;overflow:hidden;
                -webkit-mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent);
                        mask-image:linear-gradient(90deg,transparent,#000 7%,#000 93%,transparent);}
            .bt-marquee-track{display:flex;width:max-content;align-items:flex-start;
                animation:bt-marquee-scroll 38s linear infinite;will-change:transform;}
            .bt-marquee:hover .bt-marquee-track{animation-play-state:paused;}
            .bt-marquee-item{flex:0 0 auto;width:84px;margin:0 18px;display:flex;flex-direction:column;align-items:center;gap:11px;}
            .bt-marquee-logo{width:64px;height:64px;border-radius:16px;background:#fff;display:flex;align-items:center;justify-content:center;padding:10px;box-shadow:0 6px 20px rgba(0,0,0,0.25);}
            .bt-marquee-logo img{max-width:100%;max-height:100%;object-fit:contain;}
            .bt-marquee-name{font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:12.5px;color:var(--muted);letter-spacing:-0.01em;text-align:center;}
            @keyframes bt-marquee-scroll{from{transform:translateX(0)}to{transform:translateX(-50%)}}
            @media (prefers-reduced-motion:reduce){
                .bt-marquee{mask-image:none;-webkit-mask-image:none;}
                .bt-marquee-track{animation:none;flex-wrap:wrap;justify-content:center;width:auto;max-width:1080px;margin:0 auto;row-gap:30px;}
                .bt-marquee-clone{display:none;}
            }
        </style>
        <div class="bt-marquee">
            <div class="bt-marquee-track">
                {{-- Two identical copies make the -50% scroll loop seamlessly. --}}
                @foreach ($logos as $logo)
                    @php $name = tr($logo->name); @endphp
                    <div class="bt-marquee-item">
                        <span class="bt-marquee-logo"><img src="{{ asset($logo->image) }}" alt="{{ $name }}" loading="lazy"></span>
                        <span class="bt-marquee-name">{{ $name }}</span>
                    </div>
                @endforeach
                @foreach ($logos as $logo)
                    @php $name = tr($logo->name); @endphp
                    <div class="bt-marquee-item bt-marquee-clone" aria-hidden="true">
                        <span class="bt-marquee-logo"><img src="{{ asset($logo->image) }}" alt="" loading="lazy"></span>
                        <span class="bt-marquee-name">{{ $name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
