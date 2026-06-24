<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
        ContactMessage::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'company' => $request->string('company')->toString() ?: null,
            'service' => $request->string('service')->toString() ?: null,
            'message' => $request->string('message'),
            'locale' => app()->getLocale(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()
            ->with('contact_sent', true)
            ->with('status', __('site.contact.success'));
    }
}
