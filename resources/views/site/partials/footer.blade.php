@php
    $footerServices = \App\Models\Service::visible()->ordered()->get();
    $socials = setting_raw('social.items', []);
@endphp

<footer style="border-top:1px solid var(--border);padding:64px 28px 36px;">
    <div style="max-width:1240px;margin:0 auto;">
        <div class="bt-foot-grid" style="display:grid;grid-template-columns:1.6fr 1fr 1fr 1.4fr;gap:40px;margin-bottom:54px;align-items:start;">
            <div>
                <a href="{{ route('home') }}" style="display:inline-block;text-decoration:none;margin-bottom:18px;">
                    <span style="display:inline-flex;padding:18px 22px;border-radius:16px;background:#ffffff;border:1px solid rgba(0,0,0,0.06);box-shadow:0 8px 30px rgba(0,0,0,0.3);">
                        <img src="{{ asset('Brain-Tech-Premium-Website/brand/lockup.png') }}" alt="{{ st('brand.name') }}" style="width:158px;height:auto;display:block;" />
                    </span>
                </a>
                <p style="font-size:14.5px;line-height:1.6;color:var(--muted);max-width:280px;margin:0;">{{ st('brand.tagline') }}</p>
            </div>

            <div>
                <h3 style="font-size:13px;letter-spacing:0.06em;text-transform:uppercase;color:var(--faint);font-weight:600;margin:0 0 16px;">{{ __('site.footer.services_heading') }}</h3>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:11px;">
                    @foreach ($footerServices as $s)
                        <li><a href="{{ route('services') }}" style="color:var(--muted);text-decoration:none;font-size:14.5px;">{{ $s->t('title') }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 style="font-size:13px;letter-spacing:0.06em;text-transform:uppercase;color:var(--faint);font-weight:600;margin:0 0 16px;">{{ __('site.footer.company_heading') }}</h3>
                <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:11px;">
                    <li><a href="{{ route('about') }}" style="color:var(--muted);text-decoration:none;font-size:14.5px;">{{ __('site.nav.about') }}</a></li>
                    <li><a href="{{ route('work.index') }}" style="color:var(--muted);text-decoration:none;font-size:14.5px;">{{ __('site.nav.work') }}</a></li>
                    <li><a href="{{ route('home') }}#process" style="color:var(--muted);text-decoration:none;font-size:14.5px;">{{ __('site.nav.process') }}</a></li>
                    <li><a href="{{ route('contact') }}" style="color:var(--muted);text-decoration:none;font-size:14.5px;">{{ __('site.nav.contact') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 style="font-size:13px;letter-spacing:0.06em;text-transform:uppercase;color:var(--faint);font-weight:600;margin:0 0 16px;">{{ __('site.footer.newsletter_heading') }}</h3>
                <p style="font-size:14px;color:var(--muted);margin:0 0 14px;line-height:1.55;">{{ st('footer.newsletter_p') }}</p>
                <form action="{{ route('subscribe') }}" method="POST" style="display:flex;gap:8px;max-width:320px;">
                    @csrf
                    <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true" />
                    <input type="email" name="email" required aria-label="{{ __('site.contact.email') }}" placeholder="{{ __('site.footer.email_placeholder') }}" style="flex:1;min-width:0;background:var(--panel2);border:1px solid var(--border);border-radius:11px;padding:11px 14px;color:var(--fg);font-size:14px;outline:none;" />
                    <button type="submit" aria-label="{{ __('site.actions.subscribe') }}" style="flex:none;background:var(--g);border:none;border-radius:11px;padding:0 16px;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                        <x-icon name="arrow" size="17" :stroke="2.4" />
                    </button>
                </form>
                @if (session('subscribed'))
                    <p style="margin:10px 0 0;font-size:13px;color:var(--acc);">{{ session('status') }}</p>
                @endif
                @error('email')
                    <p style="margin:10px 0 0;font-size:13px;color:#ff6b6b;">{{ $message }}</p>
                @enderror

                <div style="display:flex;gap:10px;margin-top:22px;">
                    @foreach ($socials as $soc)
                        <a href="{{ $soc['url'] ?? '#' }}" aria-label="{{ $soc['label'] ?? '' }}" style="width:38px;height:38px;border-radius:10px;background:var(--panel2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);text-decoration:none;font-size:12px;font-weight:600;font-family:'Space Grotesk',sans-serif;">{{ $soc['short'] ?? '' }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bt-foot-bottom" style="border-top:1px solid var(--border);padding-top:26px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <p style="font-size:13px;color:var(--faint);margin:0;">{{ st('footer.rights') }}</p>
            <p style="font-size:13px;color:var(--faint);margin:0;"><bdi dir="ltr">{{ st('contact.email') }}</bdi> · <bdi dir="ltr">{{ st('contact.phone') }}</bdi></p>
        </div>
    </div>
</footer>
