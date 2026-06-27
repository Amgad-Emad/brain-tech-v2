<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function store(SubscribeRequest $request): RedirectResponse
    {
        $email = $request->string('email')->lower()->toString();

        try {
            $subscriber = Subscriber::firstOrCreate(
                ['email' => $email],
                ['locale' => app()->getLocale()],
            );
        } catch (\Throwable $e) {
            Log::error('[newsletter] Failed to store subscriber.', [
                'email' => $email,
                'exception' => $e,
            ]);

            throw $e;
        }

        return back()->with(
            'status',
            $subscriber->wasRecentlyCreated
                ? __('site.newsletter.success')
                : __('site.newsletter.exists'),
        )->with('subscribed', true);
    }
}
