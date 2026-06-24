<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;

/*
 | mcamara binds the route prefix to the first locale per process, so the
 | /ar HTTP path is covered by the live smoke test. Here we verify the
 | translation layer the localized pages depend on resolves correctly.
 */
beforeEach(fn () => $this->seed());

describe('Arabic resolution', function () {
    it('resolves seeded content in Arabic', function () {
        app()->setLocale('ar');

        expect(Service::where('slug', 'software-solutions')->first()->t('title'))->toBe('حلول برمجية');
        expect(Faq::ordered()->first()->t('question'))->toContain('براين-تك');
    });

    it('resolves settings in Arabic', function () {
        app()->setLocale('ar');
        expect(Setting::localized('hero.badge'))->toBe('نستقبل الآن مشاريع الربع الثالث 2026');
    });

    it('resolves UI chrome from lang files per locale', function () {
        app()->setLocale('en');
        expect(__('site.nav.services'))->toBe('Services');

        app()->setLocale('ar');
        expect(__('site.nav.services'))->toBe('خدماتنا');
        expect(is_rtl())->toBeTrue();
    });
});
