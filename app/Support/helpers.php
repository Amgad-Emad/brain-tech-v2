<?php

use App\Models\Setting;
use App\Support\Translator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (! function_exists('st')) {
    /**
     * Locale-resolved site setting (translatable maps collapse to the locale).
     */
    function st(string $key, mixed $default = null): mixed
    {
        return Setting::localized($key, $default);
    }
}

if (! function_exists('setting_raw')) {
    /**
     * Raw decoded site setting value (scalar, list, or {en, ar} map).
     */
    function setting_raw(string $key, mixed $default = null): mixed
    {
        return Setting::getValue($key, $default);
    }
}

if (! function_exists('tr')) {
    /**
     * Resolve any {en, ar} map (or plain string) to the active locale.
     * Handy for nested values pulled out of JSON columns inside views.
     */
    function tr(mixed $value, ?string $locale = null): ?string
    {
        return Translator::resolve($value, $locale);
    }
}

if (! function_exists('locale_url')) {
    /**
     * The current URL rendered in another locale (for the language switcher).
     */
    function locale_url(string $locale): string
    {
        return LaravelLocalization::getLocalizedURL($locale, null, [], true);
    }
}

if (! function_exists('is_rtl')) {
    function is_rtl(?string $locale = null): bool
    {
        $locale ??= app()->getLocale();

        return in_array($locale, ['ar', 'he', 'fa', 'ur'], true);
    }
}
