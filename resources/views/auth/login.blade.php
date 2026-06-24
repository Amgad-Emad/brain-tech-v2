<x-guest-layout>
    <div style="margin-bottom:26px;">
        <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:25px;letter-spacing:-0.01em;margin:0 0 6px;">{{ __('Welcome back') }}</h1>
        <p style="font-size:14px;color:var(--muted);margin:0;">{{ __('Sign in to manage your Brain-Tech site.') }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom:18px;">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" style="color:#ff6b6b;font-size:13px;margin-top:8px;" />
        </div>

        <div style="margin-bottom:16px;">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" style="color:#ff6b6b;font-size:13px;margin-top:8px;" />
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:24px;">
            <label for="remember_me" style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="width:16px;height:16px;border-radius:5px;border:1px solid var(--border2);background:var(--panel2);accent-color:var(--acc);">
                <span style="font-size:13.5px;color:var(--muted);">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:13.5px;color:var(--acc);text-decoration:none;">{{ __('Forgot password?') }}</a>
            @endif
        </div>

        <button type="submit" class="bt-auth-btn">{{ __('Sign in') }}</button>
    </form>

    @if (Route::has('register'))
        <p style="text-align:center;font-size:13.5px;color:var(--muted);margin:22px 0 0;">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" style="color:var(--acc);text-decoration:none;font-weight:600;">{{ __('Create one') }}</a>
        </p>
    @endif
</x-guest-layout>
