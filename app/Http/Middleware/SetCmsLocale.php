<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the admin UI language (independent of the public site locale).
 */
class SetCmsLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('cms_locale');

        if (in_array($locale, ['en', 'ar'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
