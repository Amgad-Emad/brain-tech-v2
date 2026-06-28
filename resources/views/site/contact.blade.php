@extends('layouts.site')

@php $socials = setting_raw('social.items', []); @endphp

@section('content')
    <article style="padding:120px 28px 60px;">
        <div style="max-width:1040px;margin:0 auto;">
            <div data-reveal style="max-width:680px;margin:0 0 48px;">
                <p style="font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:var(--acc);font-weight:600;margin:0 0 14px;">{{ st('contact.eyebrow') }}</p>
                <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(34px,5vw,58px);line-height:1.06;letter-spacing:-0.02em;margin:0 0 20px;text-wrap:balance;">{{ st('contact.title') }}</h1>
                <p style="font-size:clamp(17px,2vw,20px);line-height:1.6;color:var(--muted);margin:0;text-wrap:pretty;">{{ st('contact.lead') }}</p>
            </div>

            <div class="bt-detail-grid" style="display:grid;grid-template-columns:1.15fr 0.85fr;gap:30px;align-items:start;">
                <form data-reveal="left" data-contact-form action="{{ route('contact.store') }}" method="POST" style="background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:32px;">
                    @csrf
                    {{-- Anti-bot: honeypot (must stay empty) + time-trap (form render time) --}}
                    <input type="text" name="website" tabindex="-1" autocomplete="off" style="display:none" aria-hidden="true" />
                    <input type="hidden" name="ts" value="{{ encrypt(time()) }}" />
                    <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:20px;margin:0 0 22px;">{{ __('site.contact.form_title') }}</h2>

                    @if (session('contact_sent'))
                        <p role="status" style="margin:0 0 18px;padding:14px 16px;border-radius:12px;background:rgba(var(--accRGB),0.12);border:1px solid rgba(var(--accRGB),0.4);color:var(--fg);font-size:14px;line-height:1.55;">{{ session('status') }}</p>
                    @endif

                    <div style="display:flex;flex-direction:column;gap:16px;">
                        <div>
                            <label for="ct-name" style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:8px;display:block;">{{ __('site.contact.name') }}</label>
                            <input id="ct-name" name="name" type="text" value="{{ old('name') }}" required style="width:100%;background:var(--panel2);border:1px solid var(--border);border-radius:11px;padding:13px 15px;color:var(--fg);font-size:15px;outline:none;" />
                            @error('name') <p style="color:#ff6b6b;font-size:13px;margin:6px 0 0;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="ct-email" style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:8px;display:block;">{{ __('site.contact.email') }}</label>
                            <input id="ct-email" name="email" type="email" value="{{ old('email') }}" required style="width:100%;background:var(--panel2);border:1px solid var(--border);border-radius:11px;padding:13px 15px;color:var(--fg);font-size:15px;outline:none;" />
                            @error('email') <p style="color:#ff6b6b;font-size:13px;margin:6px 0 0;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="ct-company" style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:8px;display:block;">{{ __('site.contact.company') }}</label>
                            <input id="ct-company" name="company" type="text" value="{{ old('company') }}" style="width:100%;background:var(--panel2);border:1px solid var(--border);border-radius:11px;padding:13px 15px;color:var(--fg);font-size:15px;outline:none;" />
                            @error('company') <p style="color:#ff6b6b;font-size:13px;margin:6px 0 0;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="ct-service" style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:8px;display:block;">{{ __('site.contact.service') }}</label>
                            <select id="ct-service" name="service" style="width:100%;background:var(--panel2);border:1px solid var(--border);border-radius:11px;padding:13px 15px;color:var(--fg);font-size:15px;outline:none;">
                                <option value="">{{ __('site.contact.select_placeholder') }}</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->t('title') }}" @selected(old('service') === $service->t('title'))>{{ $service->t('title') }}</option>
                                @endforeach
                                <option value="{{ __('site.contact.general_inquiry') }}" @selected(old('service') === __('site.contact.general_inquiry'))>{{ __('site.contact.general_inquiry') }}</option>
                            </select>
                            @error('service') <p style="color:#ff6b6b;font-size:13px;margin:6px 0 0;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="ct-msg" style="font-size:13px;font-weight:600;color:var(--muted);margin-bottom:8px;display:block;">{{ __('site.contact.message') }}</label>
                            <textarea id="ct-msg" name="message" rows="4" required style="width:100%;background:var(--panel2);border:1px solid var(--border);border-radius:11px;padding:13px 15px;color:var(--fg);font-size:15px;outline:none;resize:vertical;">{{ old('message') }}</textarea>
                            @error('message') <p style="color:#ff6b6b;font-size:13px;margin:6px 0 0;">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" style="background:var(--g);color:#fff;border:none;border-radius:12px;padding:15px;font-size:15px;font-weight:600;cursor:pointer;box-shadow:0 8px 26px rgba(var(--accRGB),0.35);">{{ __('site.actions.send_message') }}</button>
                    </div>
                </form>

                <div data-reveal="right" style="display:flex;flex-direction:column;gap:14px;">
                    <a href="mailto:{{ st('contact.email') }}" style="text-decoration:none;color:inherit;background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:22px;">
                        <div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);margin-bottom:6px;">{{ __('site.contact.email_label') }}</div>
                        <div style="font-weight:600;font-size:16px;color:var(--acc);">{{ st('contact.email') }}</div>
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', st('contact.phone')) }}" style="text-decoration:none;color:inherit;background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:22px;">
                        <div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);margin-bottom:6px;">{{ __('site.contact.phone_label') }}</div>
                        <div style="font-weight:600;font-size:16px;"><bdi dir="ltr">{{ st('contact.phone') }}</bdi></div>
                    </a>
                    <div style="background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:22px;">
                        <div style="font-size:12px;text-transform:uppercase;letter-spacing:0.08em;color:var(--faint);margin-bottom:6px;">{{ __('site.contact.office_label') }}</div>
                        <div style="font-weight:600;font-size:15px;line-height:1.5;">{{ st('contact.office') }}</div>
                        <div style="font-size:13px;color:var(--muted);margin-top:6px;">{{ st('contact.hours') }}</div>
                    </div>
                    <div style="background:linear-gradient(135deg,rgba(var(--accRGB),0.12),rgba(var(--accRGB),0.06));border:1px solid var(--border);border-radius:16px;padding:22px;">
                        <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:16px;margin:0 0 8px;">{{ st('contact.response_title') }}</h2>
                        <p style="font-size:14px;line-height:1.6;color:var(--muted);margin:0;text-wrap:pretty;">{{ st('contact.response_text') }}</p>
                    </div>
                    <div style="display:flex;gap:10px;">
                        @foreach ($socials as $soc)
                            <a href="{{ $soc['url'] ?? '#' }}" aria-label="{{ $soc['label'] ?? '' }}" style="width:42px;height:42px;border-radius:11px;background:var(--panel2);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);text-decoration:none;font-size:13px;font-weight:600;font-family:'Space Grotesk',sans-serif;">{{ $soc['short'] ?? '' }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </article>

    {{-- Loading overlay shown while the contact form submits (the email send is synchronous) --}}
    <div data-contact-loader aria-hidden="true" role="alertdialog" aria-busy="true" aria-label="{{ __('site.contact.sending_title') }}"
        style="position:fixed;inset:0;z-index:1000;display:flex;align-items:center;justify-content:center;padding:24px;background:rgba(6,6,10,0.62);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);">
        <div style="background:var(--panel);border:1px solid var(--border);border-radius:20px;padding:34px 38px;max-width:340px;width:100%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,0.45);">
            <span class="bt-spinner" aria-hidden="true" style="display:inline-block;width:46px;height:46px;border-radius:50%;border:3px solid rgba(var(--accRGB),0.22);border-top-color:var(--acc);margin-bottom:20px;"></span>
            <h3 style="font-family:'Space Grotesk',sans-serif;font-weight:600;font-size:18px;margin:0 0 8px;color:var(--fg);">{{ __('site.contact.sending_title') }}</h3>
            <p style="font-size:14px;line-height:1.55;color:var(--muted);margin:0;">{{ __('site.contact.sending_text') }}</p>
        </div>
    </div>
@endsection
