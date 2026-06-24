<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    public function store(SubscribeRequest $request): RedirectResponse
    {
        $email = $request->string('email')->lower()->toString();

        $subscriber = Subscriber::firstOrCreate(
            ['email' => $email],
            ['locale' => app()->getLocale()],
        );

        return back()->with(
            'status',
            $subscriber->wasRecentlyCreated
                ? __('site.newsletter.success')
                : __('site.newsletter.exists'),
        )->with('subscribed', true);
    }
}
