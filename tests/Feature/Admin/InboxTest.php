<?php

use App\Models\ContactMessage;
use App\Models\Subscriber;
use App\Models\User;

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::factory()->create());
});

describe('messages inbox', function () {
    it('lists messages', function () {
        ContactMessage::create(['name' => 'Jane', 'email' => 'jane@x.com', 'message' => 'A real enquiry here']);
        $this->get(route('admin.messages.index'))->assertOk()->assertSee('jane@x.com');
    });

    it('marks a message read when opened', function () {
        $m = ContactMessage::create(['name' => 'Jane', 'email' => 'jane@x.com', 'message' => 'A real enquiry here']);
        expect($m->isRead())->toBeFalse();

        $this->get(route('admin.messages.show', $m))->assertOk()->assertSee('A real enquiry here');
        expect($m->fresh()->isRead())->toBeTrue();
    });

    it('deletes a message', function () {
        $m = ContactMessage::create(['name' => 'Jane', 'email' => 'jane@x.com', 'message' => 'A real enquiry here']);
        $this->delete(route('admin.messages.destroy', $m))->assertRedirect();
        expect(ContactMessage::count())->toBe(0);
    });
});

describe('subscribers', function () {
    it('lists and exports subscribers as CSV', function () {
        Subscriber::create(['email' => 'fan@x.com', 'locale' => 'en']);

        $this->get(route('admin.subscribers.index'))->assertOk()->assertSee('fan@x.com');

        $response = $this->get(route('admin.subscribers.export'));
        $response->assertOk();
        expect($response->headers->get('content-type'))->toContain('text/csv');
        expect($response->streamedContent())->toContain('fan@x.com');
    });

    it('deletes a subscriber', function () {
        $s = Subscriber::create(['email' => 'fan@x.com']);
        $this->delete(route('admin.subscribers.destroy', $s))->assertRedirect();
        expect(Subscriber::count())->toBe(0);
    });
});

describe('admin UI language', function () {
    it('switches the CMS language via session', function () {
        $this->get(route('admin.locale', 'ar'));
        expect(session('cms_locale'))->toBe('ar');

        $this->get(route('admin.dashboard'))->assertOk()->assertSee(__('admin.overview.welcome', [], 'ar'));
    });
});
