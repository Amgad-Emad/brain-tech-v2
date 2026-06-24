<?php

use App\Models\User;

describe('admin access control', function () {
    it('redirects guests to login', function (string $url) {
        $this->get($url)->assertRedirect('/login');
    })->with([
        '/admin',
        '/admin/analytics',
        '/admin/brand',
        '/admin/section/hero',
        '/admin/messages',
        '/admin/subscribers',
        '/admin/export',
    ]);

    it('allows an authenticated admin', function (string $url) {
        $this->seed();
        $this->actingAs(User::factory()->create());
        $this->get($url)->assertOk();
    })->with([
        '/admin',
        '/admin/analytics',
        '/admin/brand',
        '/admin/section/nav',
        '/admin/section/hero',
        '/admin/section/services',
        '/admin/section/testimonials',
        '/admin/section/offers',
        '/admin/section/seo',
        '/admin/messages',
        '/admin/subscribers',
    ]);

    it('404s for an unknown section', function () {
        $this->actingAs(User::factory()->create());
        $this->get('/admin/section/nonsense')->assertNotFound();
    });
});
