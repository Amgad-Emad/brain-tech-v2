<?php

namespace App\Models\Concerns;

use App\Support\Translator;

/**
 * Stores translatable attributes as JSON maps keyed by locale, e.g.
 * {"en": "Services", "ar": "خدماتنا"} and resolves them to the active
 * locale with a fallback. List the leaf attributes in $translatable.
 */
trait HasTranslations
{
    public function initializeHasTranslations(): void
    {
        $this->mergeCasts(array_fill_keys($this->translatable ?? [], 'array'));
    }

    /**
     * Resolve a translatable attribute for the given (or active) locale.
     */
    public function t(string $attribute, ?string $locale = null): ?string
    {
        return static::translate($this->getAttribute($attribute), $locale);
    }

    /**
     * Resolve any {en, ar} map (or plain string) to a single locale string.
     * Static so nested values (list items) can be resolved in views too.
     */
    public static function translate(mixed $value, ?string $locale = null): ?string
    {
        return Translator::resolve($value, $locale);
    }
}
