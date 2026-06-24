<?php

use App\Cms\Sections;
use App\Models\Service;

describe('Sections schema', function () {
    it('lists known sections and finds them by id', function () {
        expect(Sections::all())->toHaveKeys(['hero', 'services', 'about', 'contact', 'seo', 'offers']);

        $hero = Sections::find('hero');
        expect($hero['id'])->toBe('hero');
        expect($hero['hideable'])->toBeTrue();
        expect($hero['settings'])->not->toBeEmpty();
    });

    it('returns null for an unknown section', function () {
        expect(Sections::find('nope'))->toBeNull();
    });

    it('groups sections into global, home and pages', function () {
        $groups = Sections::groups();

        expect($groups)->toHaveKeys(['global', 'home', 'pages']);
        expect($groups['home'])->toContain('hero', 'services', 'faq');
        expect($groups['global'])->toContain('nav', 'seo');
    });

    it('binds collection sections to real models', function () {
        expect(Sections::find('services')['collection']['model'])->toBe(Service::class);
        expect(Sections::find('testimonials')['collection']['dynamic'])->toBeTrue();
        expect(Sections::find('services')['collection']['dynamic'])->toBeFalse();
    });
});
