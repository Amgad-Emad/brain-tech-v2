<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'path', 'route_name', 'locale', 'device', 'source', 'referrer',
        'country', 'city', 'ip', 'visitor_id', 'session_id', 'duration', 'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'duration' => 'integer',
    ];

    /**
     * Classify a User-Agent string into a coarse device bucket.
     */
    public static function deviceFromAgent(?string $agent): string
    {
        $agent = (string) $agent;

        if (preg_match('/iPad|Tablet/i', $agent)) {
            return 'Tablet';
        }

        if (preg_match('/Mobi|Android|iPhone/i', $agent)) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    /**
     * Derive a friendly traffic source from a referrer URL.
     */
    public static function sourceFromReferrer(?string $referrer, ?string $host = null): string
    {
        if (! $referrer) {
            return 'Direct';
        }

        $refHost = strtolower((string) parse_url($referrer, PHP_URL_HOST));

        if ($refHost === '' || ($host && str_contains($refHost, (string) $host))) {
            return 'Direct';
        }

        $refHost = preg_replace('/^www\./', '', $refHost);

        return match (true) {
            str_contains($refHost, 'google') => 'Google',
            str_contains($refHost, 'bing') => 'Bing',
            str_contains($refHost, 'duckduckgo') => 'DuckDuckGo',
            str_contains($refHost, 'linkedin') => 'LinkedIn',
            str_contains($refHost, 'facebook') || str_contains($refHost, 'fb.') => 'Facebook',
            str_contains($refHost, 't.co') || str_contains($refHost, 'twitter') || str_contains($refHost, 'x.com') => 'X / Twitter',
            str_contains($refHost, 'instagram') => 'Instagram',
            str_contains($refHost, 'github') => 'GitHub',
            default => ucfirst($refHost),
        };
    }

    /**
     * Mask the last octet/segment of an IP for privacy.
     */
    public static function maskIp(?string $ip): ?string
    {
        if (! $ip) {
            return null;
        }

        if (str_contains($ip, '.')) {
            return preg_replace('/\.\d+$/', '.x', $ip);
        }

        if (str_contains($ip, ':')) {
            return preg_replace('/[0-9a-f]+$/i', 'x', $ip);
        }

        return $ip;
    }
}
