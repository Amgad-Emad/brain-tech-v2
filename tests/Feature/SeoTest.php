<?php

use App\Models\Setting;

beforeEach(fn () => $this->seed());

describe('SEO meta per page', function () {
    it('renders the seeded title and description on each page', function (string $url, string $titleNeedle) {
        $this->get($url)
            ->assertOk()
            ->assertSee('<title>'.$titleNeedle, false)
            ->assertSee('<meta name="description"', false);
    })->with([
        ['/', 'Brain-Tech — Custom Software'],
        ['/about', 'About Brain-Tech'],
        ['/services', 'Services — Software'],
        ['/work', 'Our Work'],
        ['/contact', 'Contact Brain-Tech'],
    ]);

    it('uses the project name for a case-study page', function () {
        $this->get('/work/fintech-onboarding')
            ->assertOk()
            ->assertSee('<title>Fintech onboarding platform', false);
    });
});

describe('SEO is CMS-editable', function () {
    it('reflects an edited title and description live', function () {
        Setting::put('seo.home_title', ['en' => 'New Home Title', 'ar' => 'عنوان'], 'seo', true);
        Setting::put('seo.home_description', ['en' => 'New home description here', 'ar' => 'وصف'], 'seo', true);
        Setting::flushCache();

        $this->get('/')
            ->assertSee('<title>New Home Title', false)
            ->assertSee('New home description here', false)
            ->assertSee('og:title" content="New Home Title', false)
            ->assertSee('twitter:description" content="New home description here', false);
    });
});

describe('structured data & social meta', function () {
    it('emits Organization, WebSite and FAQPage JSON-LD on the home page', function () {
        $this->get('/')
            ->assertSee('"@type":"ProfessionalService"', false)
            ->assertSee('"@type":"WebSite"', false)
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('"@type":"Question"', false);
    });

    it('includes Open Graph and Twitter image tags', function () {
        $this->get('/')
            ->assertSee('property="og:image"', false)
            ->assertSee('name="twitter:image"', false)
            ->assertSee('name="robots"', false);
    });

    it('does not emit FAQ structured data on pages without FAQs', function () {
        $this->get('/contact')->assertDontSee('"@type":"FAQPage"', false);
    });
});
