<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Value;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('site.home', [
            'services' => Service::visible()->ordered()->get(),
            'values' => Value::visible()->ordered()->get(),
            'steps' => ProcessStep::visible()->ordered()->get(),
            'stats' => Stat::visible()->ordered()->get(),
            'projects' => Project::visible()->ordered()->get(),
            'testimonials' => Testimonial::visible()->ordered()->get(),
            'faqs' => Faq::visible()->ordered()->get(),
            'metaTitle' => st('seo.home_title'),
            'metaDescription' => st('seo.home_description'),
        ]);
    }
}
