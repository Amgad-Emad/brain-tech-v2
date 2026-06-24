<?php

use App\Models\Project;
use App\Models\Setting;

beforeEach(fn () => $this->seed());

describe('public routes', function () {
    it('renders the home page with seeded sections', function () {
        $this->get('/')
            ->assertOk()
            ->assertSee('Software Solutions')      // service card
            ->assertSee('dir="ltr"', false);
    });

    it('renders the about page', function () {
        $this->get(route('about'))->assertOk()->assertSee('Our story');
    });

    it('renders the services page with deliverables', function () {
        $this->get(route('services'))->assertOk()->assertSee('What you get');
    });

    it('renders the work index', function () {
        $this->get(route('work.index'))->assertOk()->assertSee('Fintech onboarding platform');
    });

    it('renders a project detail page by slug', function () {
        $this->get(route('work.show', 'fintech-onboarding'))
            ->assertOk()
            ->assertSee('The challenge');
    });

    it('404s for unknown or hidden projects', function () {
        $this->get('/work/does-not-exist')->assertNotFound();

        Project::where('slug', 'cloud-migration')->update(['is_visible' => false]);
        $this->get('/work/cloud-migration')->assertNotFound();
    });

    it('renders the contact page with the form', function () {
        $this->get(route('contact'))->assertOk()->assertSee('Send message');
    });
});

describe('CMS visibility controls the home page', function () {
    it('hides a section when its visibility flag is off', function () {
        $this->get('/')->assertSee('Frequently asked questions');

        Setting::put('visibility.faq', false, 'visibility');
        Setting::flushCache();

        $this->get('/')->assertDontSee('Frequently asked questions');
    });
});

describe('CMS settings drive the page', function () {
    it('reflects an edited hero badge', function () {
        Setting::put('hero.badge', ['en' => 'Brand new badge text', 'ar' => 'شارة'], 'hero', true);
        Setting::flushCache();

        $this->get('/')->assertSee('Brand new badge text');
    });
});
