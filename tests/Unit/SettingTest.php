<?php

use App\Models\Setting;

describe('Setting', function () {
    it('stores and reads a scalar value', function () {
        Setting::put('contact.email', 'hello@brain-tech.com', 'contact');
        expect(Setting::getValue('contact.email'))->toBe('hello@brain-tech.com');
    });

    it('stores a translatable map and resolves it per locale', function () {
        Setting::put('hero.badge', ['en' => 'Booking now', 'ar' => 'نحجز الآن'], 'hero', true);

        app()->setLocale('en');
        expect(Setting::localized('hero.badge'))->toBe('Booking now');

        app()->setLocale('ar');
        expect(Setting::localized('hero.badge'))->toBe('نحجز الآن');
    });

    it('returns the default for a missing key', function () {
        expect(Setting::getValue('does.not.exist', 'fallback'))->toBe('fallback');
        expect(Setting::localized('nope', 'x'))->toBe('x');
    });

    it('keeps booleans and lists intact', function () {
        Setting::put('visibility.faq', true, 'visibility');
        Setting::put('social.items', [['short' => 'X'], ['short' => 'in']], 'social');

        expect(Setting::getValue('visibility.faq'))->toBeTrue();
        expect(Setting::getValue('social.items'))->toHaveCount(2);
    });

    it('flushes its cache on save so reads are fresh', function () {
        Setting::put('brand.name', 'One', 'brand');
        expect(Setting::getValue('brand.name'))->toBe('One');

        Setting::put('brand.name', 'Two', 'brand');
        expect(Setting::getValue('brand.name'))->toBe('Two');
    });

    it('exposes the same data through the st() and setting_raw() helpers', function () {
        Setting::put('theme.accent', '#34e0a0', 'theme');
        Setting::put('contact.office', ['en' => 'SF', 'ar' => 'سان فرانسيسكو'], 'contact', true);

        app()->setLocale('ar');
        expect(st('contact.office'))->toBe('سان فرانسيسكو');
        expect(setting_raw('theme.accent'))->toBe('#34e0a0');
        expect(setting_raw('contact.office'))->toBeArray();
    });
});
