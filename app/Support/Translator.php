<?php

namespace App\Support;

class Translator
{
    /**
     * Resolve an {en, ar} map (or plain string) to a single locale string.
     */
    public static function resolve(mixed $value, ?string $locale = null): ?string
    {
        if ($value === null || is_string($value)) {
            return $value;
        }

        if (! is_array($value)) {
            return null;
        }

        $locale ??= app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        // Treat empty strings as "missing" so a blank translation falls back.
        if (isset($value[$locale]) && $value[$locale] !== '') {
            return $value[$locale];
        }

        if (isset($value[$fallback]) && $value[$fallback] !== '') {
            return $value[$fallback];
        }

        foreach ($value as $candidate) {
            if (is_string($candidate) && $candidate !== '') {
                return $candidate;
            }
        }

        return null;
    }
}
