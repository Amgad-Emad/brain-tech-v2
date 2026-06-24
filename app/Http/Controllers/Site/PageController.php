<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Value;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('site.about', [
            'values' => Value::visible()->ordered()->get(),
            'stats' => Stat::visible()->ordered()->get(),
            'metaTitle' => st('seo.about_title'),
            'metaDescription' => st('seo.about_description'),
        ]);
    }

    public function services(): View
    {
        return view('site.services', [
            'services' => Service::visible()->ordered()->get(),
            'metaTitle' => st('seo.services_title'),
            'metaDescription' => st('seo.services_description'),
        ]);
    }
}
