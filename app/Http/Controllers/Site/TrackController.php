<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TrackController extends Controller
{
    /**
     * Receive a page-view beacon (sendBeacon → text/plain JSON) and store it.
     */
    public function store(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        if (! is_array($data)) {
            $data = $request->all();
        }

        $path = (string) ($data['path'] ?? '/');
        $duration = (int) ($data['duration'] ?? 0);

        // Only record sane, same-site page views.
        if (! str_starts_with($path, '/') || $duration < 1 || $duration > 7200) {
            return response()->noContent();
        }

        // Best-effort analytics: never let a tracking failure break the beacon.
        try {
            Visit::create([
                'path' => Str::limit($path, 250, ''),
                'locale' => in_array(($data['locale'] ?? null), ['en', 'ar'], true) ? $data['locale'] : app()->getLocale(),
                'device' => Visit::deviceFromAgent($request->userAgent()),
                'source' => Visit::sourceFromReferrer($data['referrer'] ?? null, $request->getHost()),
                'referrer' => ! empty($data['referrer']) ? Str::limit((string) $data['referrer'], 250, '') : null,
                'country' => $request->header('CF-IPCountry') ?: ($data['country'] ?? null),
                'ip' => Visit::maskIp($request->ip()),
                'visitor_id' => Str::limit((string) $request->cookie('bt_visitor'), 40, ''),
                'session_id' => Str::limit((string) $request->cookie('bt_session'), 40, ''),
                'duration' => $duration,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('[track] Failed to record page-view beacon.', [
                'path' => $path,
                'exception' => $e,
            ]);
        }

        return response()->noContent();
    }
}
