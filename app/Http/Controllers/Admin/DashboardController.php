<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Subscriber;
use App\Models\Visit;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => __('admin.an.visitors'), 'value' => number_format(Visit::distinct('visitor_id')->count('visitor_id'))],
                ['label' => __('admin.an.views'), 'value' => number_format(Visit::count())],
                ['label' => __('admin.nav.messages'), 'value' => number_format(ContactMessage::count())],
                ['label' => __('admin.nav.subscribers'), 'value' => number_format(Subscriber::count())],
            ],
            'counts' => [
                'services' => Service::count(),
                'projects' => Project::count(),
                'unread' => ContactMessage::unread()->count(),
            ],
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }
}
