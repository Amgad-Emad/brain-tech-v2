<?php

use App\Models\User;
use App\Models\Visit;

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::factory()->create());
});

describe('overview', function () {
    it('shows the welcome panel and a live hero preview', function () {
        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(__('admin.overview.welcome'))
            ->assertSee(st('hero.badge'));
    });
});

describe('analytics', function () {
    it('renders KPIs and the visits table from seeded sample data', function () {
        $this->get(route('admin.analytics'))
            ->assertOk()
            ->assertSee(__('admin.an.title'))
            ->assertSee(__('admin.an.visitors'));
    });

    it('reflects a freshly recorded visit', function () {
        Visit::query()->delete();
        Visit::create(['path' => '/', 'device' => 'Desktop', 'source' => 'Direct', 'visitor_id' => 'v1', 'session_id' => 's1', 'duration' => 20, 'created_at' => now()]);

        $this->get(route('admin.analytics'))->assertOk()->assertSee('Desktop');
    });
});
