<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Issues stable visitor + rolling session identifiers (cookies) so the
 * client-side analytics beacon can attribute page views. No PII is stored.
 */
class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $visitor = $request->cookie('bt_visitor') ?: 'v_'.Str::random(24);
        $session = $request->cookie('bt_session') ?: 's_'.Str::random(20);

        // Visitor: 1 year. Session: 30 minutes (refreshed on each view).
        $response->headers->setCookie(cookie('bt_visitor', $visitor, 60 * 24 * 365));
        $response->headers->setCookie(cookie('bt_session', $session, 30));

        return $response;
    }
}
