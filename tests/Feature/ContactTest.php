<?php

use App\Models\ContactMessage;

beforeEach(fn () => $this->seed());

describe('contact submission', function () {
    it('stores a valid message and flashes success', function () {
        $this->post(route('contact.store'), [
            'name' => 'Jane Cooper',
            'email' => 'jane@example.com',
            'company' => 'Acme',
            'service' => 'Software Solutions',
            'message' => 'We would like to discuss a new platform build.',
        ])->assertRedirect()->assertSessionHas('contact_sent', true);

        $message = ContactMessage::firstWhere('email', 'jane@example.com');
        expect($message)->not->toBeNull();
        expect($message->locale)->toBe('en');
        expect($message->ip_address)->not->toBeNull();
    });

    it('rejects missing or malformed fields', function () {
        $this->post(route('contact.store'), ['name' => '', 'email' => 'nope', 'message' => 'hi'])
            ->assertSessionHasErrors(['name', 'email', 'message']);

        expect(ContactMessage::count())->toBe(0);
    });

    it('enforces a minimum message length', function () {
        $this->post(route('contact.store'), ['name' => 'A', 'email' => 'a@b.com', 'message' => 'short'])
            ->assertSessionHasErrors('message');
    });

    it('blocks honeypot spam', function () {
        $this->post(route('contact.store'), [
            'name' => 'Bot', 'email' => 'bot@x.com', 'message' => 'spam spam spam spam', 'website' => 'http://spam',
        ])->assertSessionHasErrors('website');

        expect(ContactMessage::count())->toBe(0);
    });
});
