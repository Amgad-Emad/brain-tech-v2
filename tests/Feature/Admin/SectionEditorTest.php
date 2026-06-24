<?php

use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::factory()->create());
});

/** Re-shape a translatable collection into editor "items" payload. */
function itemsFrom($models, array $fields): array
{
    return $models->map(function ($m) use ($fields) {
        $row = ['id' => $m->id];
        foreach ($fields as [$attr, $type]) {
            $v = $m->getAttribute($attr);
            $row[$attr] = is_array($v) ? ['en' => $v['en'] ?? '', 'ar' => $v['ar'] ?? ''] : $v;
        }

        return $row;
    })->values()->all();
}

describe('settings editor', function () {
    it('saves a translatable setting and it goes live', function () {
        $this->put(route('admin.section.update', 'hero'), [
            's' => [
                'hero.badge' => ['en' => 'Booking Q4 now', 'ar' => 'نحجز الربع الرابع'],
                'hero.h1hi' => ['en' => 'enterprise-grade', 'ar' => 'مؤسسي'],
            ],
        ])->assertRedirect(route('admin.section.edit', 'hero'))->assertSessionHas('toast');

        app()->setLocale('en');
        expect(Setting::localized('hero.badge'))->toBe('Booking Q4 now');
        app()->setLocale('ar');
        expect(Setting::localized('hero.badge'))->toBe('نحجز الربع الرابع');
    });

    it('splits the trust logos mono field into a list', function () {
        $this->put(route('admin.section.update', 'trust'), [
            's' => ['trust.label' => ['en' => 'Trusted', 'ar' => 'موثوق'], 'trust.logos' => 'Acme, Globex, Initech'],
        ])->assertRedirect();

        expect(Setting::getValue('trust.logos'))->toBe(['Acme', 'Globex', 'Initech']);
    });
});

describe('fixed collection editor', function () {
    it('updates existing rows without adding or deleting', function () {
        $fields = [['title', 'text'], ['description', 'area']];
        $items = itemsFrom(Service::ordered()->get(), $fields);
        $items[0]['title']['en'] = 'Renamed Service';

        $this->put(route('admin.section.update', 'services'), ['items' => $items])->assertRedirect();

        expect(Service::ordered()->first()->t('title', 'en'))->toBe('Renamed Service');
        expect(Service::count())->toBe(4);
    });

    it('saves mono + bool offer fields', function () {
        $fields = [['offer_enabled', 'bool'], ['offer_label', 'text'], ['offer_title', 'text'], ['offer_text', 'area'], ['offer_until', 'text']];
        $items = itemsFrom(Service::ordered()->get(), $fields);
        $items[0]['offer_enabled'] = '1';
        $items[0]['offer_title'] = ['en' => 'Launch deal', 'ar' => 'عرض'];

        $this->put(route('admin.section.update', 'offers'), ['items' => $items])->assertRedirect();

        $service = Service::ordered()->first()->fresh();
        expect($service->offer_enabled)->toBeTrue();
        expect($service->t('offer_title', 'en'))->toBe('Launch deal');
    });
});

describe('dynamic collection editor', function () {
    it('adds a new row', function () {
        $fields = [['quote', 'area'], ['name', 'text'], ['role', 'text']];
        $items = itemsFrom(Testimonial::ordered()->get(), $fields);
        $items[] = ['id' => '', 'quote' => ['en' => 'Great team', 'ar' => 'فريق رائع'], 'name' => ['en' => 'New Client', 'ar' => 'عميل'], 'role' => ['en' => 'CEO', 'ar' => '']];

        $this->put(route('admin.section.update', 'testimonials'), ['items' => $items])->assertRedirect();

        expect(Testimonial::count())->toBe(5);
        expect(Testimonial::where('initials', null)->get()->contains(fn ($t) => $t->t('name', 'en') === 'New Client'))->toBeTrue();
    });

    it('deletes rows that are removed from the payload', function () {
        $fields = [['quote', 'area'], ['name', 'text'], ['role', 'text']];
        $items = itemsFrom(Testimonial::ordered()->take(2)->get(), $fields);

        $this->put(route('admin.section.update', 'testimonials'), ['items' => $items])->assertRedirect();

        expect(Testimonial::count())->toBe(2);
    });

    it('reorders rows by submission order', function () {
        $fields = [['quote', 'area'], ['name', 'text'], ['role', 'text']];
        $items = itemsFrom(Testimonial::ordered()->get()->reverse(), $fields);

        $this->put(route('admin.section.update', 'testimonials'), ['items' => $items])->assertRedirect();

        $first = Testimonial::ordered()->first();
        expect($first->sort_order)->toBe(0);
    });
});
