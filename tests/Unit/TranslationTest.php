<?php

use App\Models\Service;
use App\Support\Translator;

describe('Translator::resolve', function () {
    it('returns plain strings unchanged', function () {
        expect(Translator::resolve('hello'))->toBe('hello');
    });

    it('returns null for null or non-string scalars', function () {
        expect(Translator::resolve(null))->toBeNull();
        expect(Translator::resolve(123))->toBeNull();
    });

    it('picks the requested locale from an {en, ar} map', function () {
        $map = ['en' => 'Services', 'ar' => 'خدماتنا'];
        expect(Translator::resolve($map, 'ar'))->toBe('خدماتنا');
        expect(Translator::resolve($map, 'en'))->toBe('Services');
    });

    it('uses the active locale when none is passed', function () {
        app()->setLocale('ar');
        expect(Translator::resolve(['en' => 'A', 'ar' => 'ب']))->toBe('ب');
    });

    it('falls back to the other locale when the value is empty', function () {
        expect(Translator::resolve(['en' => 'Only EN', 'ar' => ''], 'ar'))->toBe('Only EN');
        expect(Translator::resolve(['en' => '', 'ar' => ''], 'ar'))->toBeNull();
    });

    it('returns the first non-empty string for non-locale arrays', function () {
        expect(Translator::resolve(['x', 'y']))->toBe('x');
    });
});

describe('HasTranslations::t', function () {
    it('resolves a model attribute for the active locale with fallback', function () {
        $service = new Service(['title' => ['en' => 'Software', 'ar' => 'برمجيات']]);

        expect($service->t('title', 'en'))->toBe('Software');
        expect($service->t('title', 'ar'))->toBe('برمجيات');

        app()->setLocale('ar');
        expect($service->t('title'))->toBe('برمجيات');
    });

    it('casts translatable attributes to arrays', function () {
        $service = new Service(['title' => ['en' => 'A', 'ar' => 'ب']]);
        expect($service->title)->toBeArray()->toHaveKeys(['en', 'ar']);
    });
});

describe('helpers', function () {
    it('tr() resolves maps and is_rtl() detects Arabic', function () {
        expect(tr(['en' => 'Hi', 'ar' => 'مرحبا'], 'ar'))->toBe('مرحبا');
        expect(is_rtl('ar'))->toBeTrue();
        expect(is_rtl('en'))->toBeFalse();

        app()->setLocale('ar');
        expect(is_rtl())->toBeTrue();
    });
});
