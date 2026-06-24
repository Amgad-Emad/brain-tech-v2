<?php

use App\Models\Service;
use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::factory()->create());
});

describe('live preview', function () {
    it('renders the real page with draft settings applied', function () {
        $response = $this->post(route('admin.section.preview', 'hero'), [
            's' => ['hero.badge' => ['en' => 'DRAFT BADGE XYZ', 'ar' => 'مسودة']],
        ]);

        $response->assertOk();
        expect($response->getContent())
            ->toContain('DRAFT BADGE XYZ')   // the unsaved edit
            ->toContain('bt-hero');          // the real hero section markup
    });

    it('renders draft collection rows', function () {
        $service = Service::ordered()->first();

        $response = $this->post(route('admin.section.preview', 'services'), [
            'items' => [
                ['id' => $service->id, 'title' => ['en' => 'DRAFT SERVICE NAME', 'ar' => 'خدمة'], 'description' => ['en' => 'd', 'ar' => 'و']],
            ],
        ]);

        $response->assertOk();
        expect($response->getContent())->toContain('DRAFT SERVICE NAME');
    });

    it('does not persist draft edits', function () {
        $this->post(route('admin.section.preview', 'hero'), [
            's' => ['hero.badge' => ['en' => 'Temporary', 'ar' => 'مؤقت']],
        ])->assertOk();

        // The real setting is untouched by a preview.
        expect(Setting::localized('hero.badge'))->not->toBe('Temporary');
    });

    it('requires authentication', function () {
        auth()->logout();
        $this->post(route('admin.section.preview', 'hero'))->assertRedirect('/login');
    });

    it('404s for an unknown section', function () {
        $this->post(route('admin.section.preview', 'nope'))->assertNotFound();
    });
});
