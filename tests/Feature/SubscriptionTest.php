<?php

use App\Models\Subscriber;

describe('newsletter subscription', function () {
    it('subscribes a new email and de-duplicates', function () {
        $this->post(route('subscribe'), ['email' => 'fan@example.com'])
            ->assertRedirect()->assertSessionHas('subscribed', true);
        $this->post(route('subscribe'), ['email' => 'fan@example.com'])->assertRedirect();

        expect(Subscriber::where('email', 'fan@example.com')->count())->toBe(1);
    });

    it('lowercases the stored email', function () {
        $this->post(route('subscribe'), ['email' => 'MixedCase@Example.com']);
        expect(Subscriber::first()->email)->toBe('mixedcase@example.com');
    });

    it('rejects an invalid email', function () {
        $this->post(route('subscribe'), ['email' => 'not-an-email'])->assertSessionHasErrors('email');
        expect(Subscriber::count())->toBe(0);
    });

    it('blocks honeypot spam', function () {
        $this->post(route('subscribe'), ['email' => 'a@b.com', 'website' => 'spam'])->assertSessionHasErrors('website');
        expect(Subscriber::count())->toBe(0);
    });
});
