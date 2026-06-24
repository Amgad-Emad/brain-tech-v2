<?php

namespace App\Models;

use App\Support\Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Key/value site settings. Each value is stored as JSON so it can hold a
 * scalar, a list, or an {en, ar} translation map. Reads are cached.
 */
class Setting extends Model
{
    public const CACHE_KEY = 'settings.all';

    /**
     * Temporary draft overrides used while rendering the CMS live preview.
     *
     * @var array<string, mixed>
     */
    public static array $preview = [];

    protected $fillable = ['key', 'value', 'group', 'is_translatable'];

    protected $casts = [
        'is_translatable' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::flushCache());
        static::deleted(fn () => static::flushCache());
    }

    /**
     * Cached, fully-serializable snapshot of every setting:
     * [key => ['value' => rawJson, 'translatable' => bool]].
     *
     * @return array<string, array{value: ?string, translatable: bool}>
     */
    public static function cached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn () => static::all()
            ->mapWithKeys(fn (self $s) => [
                $s->key => ['value' => $s->value, 'translatable' => (bool) $s->is_translatable],
            ])
            ->all());
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Raw decoded value for a key (scalar, array or {en, ar} map).
     */
    /**
     * Render the given callback with draft setting overrides applied.
     */
    public static function withPreview(array $overrides, \Closure $callback): mixed
    {
        $previous = static::$preview;
        static::$preview = $overrides;

        try {
            return $callback();
        } finally {
            static::$preview = $previous;
        }
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, static::$preview)) {
            return static::$preview[$key] ?? $default;
        }

        $row = static::cached()[$key] ?? null;

        if ($row === null) {
            return $default;
        }

        $value = json_decode((string) $row['value'], true);

        return $value ?? $default;
    }

    /**
     * Locale-resolved value for a key. Translatable maps collapse to the
     * active locale; everything else is returned as-is.
     */
    public static function localized(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, static::$preview)) {
            $value = static::$preview[$key];

            if (is_array($value) && (array_key_exists('en', $value) || array_key_exists('ar', $value))) {
                return Translator::resolve($value) ?? $default;
            }

            return $value ?? $default;
        }

        $row = static::cached()[$key] ?? null;

        if ($row === null) {
            return $default;
        }

        $value = json_decode((string) $row['value'], true);

        if ($row['translatable'] && is_array($value)) {
            return Translator::resolve($value) ?? $default;
        }

        return $value ?? $default;
    }

    public static function put(string $key, mixed $value, string $group = 'general', bool $translatable = false): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => json_encode($value, JSON_UNESCAPED_UNICODE),
                'group' => $group,
                'is_translatable' => $translatable,
            ],
        );
    }
}
