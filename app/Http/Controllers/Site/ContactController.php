<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('site.contact', [
            'services' => Service::visible()->ordered()->get(),
            'metaTitle' => st('seo.contact_title'),
            'metaDescription' => st('seo.contact_description'),
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $message = ContactMessage::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'company' => $request->string('company')->toString() ?: null,
            'service' => $request->string('service')->toString() ?: null,
            'message' => $request->string('message'),
            'locale' => app()->getLocale(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $this->notify($message);

        return back()
            ->with('contact_sent', true)
            ->with('status', __('site.contact.success'));
    }

    /**
     * Email the submission to the address shown on the contact page
     * (the editable `contact.email` setting). A delivery failure must never
     * break the user's submission — the message is already stored in the DB.
     */
    private function notify(ContactMessage $message): void
    {
        $recipient = st('contact.email');

        if (! is_string($recipient) || ! filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            Log::warning('Contact form: no valid contact.email configured, skipping notification.');

            return;
        }

        try {
            Mail::to($recipient)->send(new ContactMessageMail($message));
        } catch (\Throwable $e) {
            Log::error('Contact notification email failed: '.$e->getMessage());
        }
    }
}
