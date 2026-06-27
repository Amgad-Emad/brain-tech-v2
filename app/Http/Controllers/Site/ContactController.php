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
        try {
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
        } catch (\Throwable $e) {
            Log::error('[contact] Failed to store contact submission.', [
                'sender_email' => (string) $request->string('email'),
                'exception' => $e,
            ]);

            throw $e;
        }

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
            Log::warning('[contact-mail] No valid contact.email configured; notification skipped.', [
                'configured_value' => $recipient,
                'contact_message_id' => $message->id,
            ]);

            return;
        }

        try {
            Mail::to($recipient)->send(new ContactMessageMail($message));

            Log::info('[contact-mail] Notification sent.', [
                'contact_message_id' => $message->id,
                'recipient' => $recipient,
                'reply_to' => $message->email,
                'mailer' => config('mail.default'),
            ]);
        } catch (\Throwable $e) {
            Log::error('[contact-mail] Notification failed to send.', [
                'contact_message_id' => $message->id,
                'recipient' => $recipient,
                'sender_email' => $message->email,
                'sender_name' => $message->name,
                'mailer' => config('mail.default'),
                'error' => $e->getMessage(),
                'exception' => $e,
            ]);
        }
    }
}
