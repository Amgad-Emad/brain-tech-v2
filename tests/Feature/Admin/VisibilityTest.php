<?php

use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::factory()->create());
});

describe('section visibility toggle', function () {
    it('flips a hideable section on and off', function () {
        expect(Setting::getValue('visibility.faq'))->toBeTrue();

        $this->post(route('admin.visibility.toggle', 'faq'))->assertRedirect()->assertSessionHas('toast');
        expect(Setting::getValue('visibility.faq'))->toBeFalse();

        $this->post(route('admin.visibility.toggle', 'faq'));
        expect(Setting::getValue('visibility.faq'))->toBeTrue();
    });

    it('refuses to toggle a non-hideable section', function () {
        $this->post(route('admin.visibility.toggle', 'seo'))->assertNotFound();
        $this->post(route('admin.visibility.toggle', 'unknown'))->assertNotFound();
    });
});
