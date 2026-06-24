<?php

use App\Models\Visit;

describe('analytics beacon', function () {
    it('records a valid page view', function () {
        $this->call('POST', route('track'), [], [], [], [
            'CONTENT_TYPE' => 'text/plain',
        ], json_encode(['path' => '/services', 'locale' => 'en', 'duration' => 42, 'referrer' => 'https://google.com/']))
            ->assertNoContent();

        $visit = Visit::first();
        expect($visit)->not->toBeNull();
        expect($visit->path)->toBe('/services');
        expect($visit->duration)->toBe(42);
        expect($visit->source)->toBe('Google');
        expect($visit->device)->toBe('Desktop');
    });

    it('ignores out-of-range or off-site beacons', function () {
        $this->call('POST', route('track'), [], [], [], ['CONTENT_TYPE' => 'text/plain'], json_encode(['path' => '/x', 'duration' => 0]));
        $this->call('POST', route('track'), [], [], [], ['CONTENT_TYPE' => 'text/plain'], json_encode(['path' => 'http://evil.com', 'duration' => 5]));

        expect(Visit::count())->toBe(0);
    });

    it('is exempt from CSRF (accepts a tokenless beacon)', function () {
        $this->call('POST', route('track'), [], [], [], ['CONTENT_TYPE' => 'text/plain'], json_encode(['path' => '/', 'duration' => 10]))
            ->assertNoContent();
        expect(Visit::count())->toBe(1);
    });
});
