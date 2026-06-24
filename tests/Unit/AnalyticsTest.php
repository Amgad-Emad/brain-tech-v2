<?php

use App\Models\Visit;
use App\Support\Analytics;

describe('Visit helpers', function () {
    it('classifies devices from the user agent', function () {
        expect(Visit::deviceFromAgent('Mozilla/5.0 (iPhone)'))->toBe('Mobile');
        expect(Visit::deviceFromAgent('Mozilla/5.0 (iPad)'))->toBe('Tablet');
        expect(Visit::deviceFromAgent('Mozilla/5.0 (Macintosh)'))->toBe('Desktop');
        expect(Visit::deviceFromAgent(null))->toBe('Desktop');
    });

    it('derives a traffic source from the referrer', function () {
        expect(Visit::sourceFromReferrer(null))->toBe('Direct');
        expect(Visit::sourceFromReferrer('https://www.google.com/search'))->toBe('Google');
        expect(Visit::sourceFromReferrer('https://www.linkedin.com/feed'))->toBe('LinkedIn');
        expect(Visit::sourceFromReferrer('https://brain-tech.test/', 'brain-tech.test'))->toBe('Direct');
    });

    it('masks the last segment of an IP', function () {
        expect(Visit::maskIp('203.0.113.42'))->toBe('203.0.113.x');
        expect(Visit::maskIp(null))->toBeNull();
    });
});

describe('Analytics::duration', function () {
    it('formats seconds into a human string', function () {
        expect(Analytics::duration(45))->toBe('45s');
        expect(Analytics::duration(60))->toBe('1m');
        expect(Analytics::duration(83))->toBe('1m 23s');
    });
});

describe('Analytics::summary', function () {
    it('returns a zeroed payload with no visits', function () {
        $s = Analytics::summary();

        expect($s['hasData'])->toBeFalse();
        expect($s['kpis'])->toHaveCount(6);
        expect($s['trend'])->toHaveCount(14);
        expect($s['allCount'])->toBe(0);
    });

    it('aggregates KPIs, devices and top pages from visits', function () {
        Visit::insert([
            ['path' => '/', 'device' => 'Desktop', 'source' => 'Google', 'visitor_id' => 'v1', 'session_id' => 's1', 'duration' => 30, 'created_at' => now()],
            ['path' => '/', 'device' => 'Mobile', 'source' => 'Direct', 'visitor_id' => 'v1', 'session_id' => 's2', 'duration' => 50, 'created_at' => now()],
            ['path' => '/contact', 'device' => 'Desktop', 'source' => 'Google', 'visitor_id' => 'v2', 'session_id' => 's3', 'duration' => 10, 'created_at' => now()],
        ]);

        $s = Analytics::summary();

        expect($s['hasData'])->toBeTrue();
        expect($s['allCount'])->toBe(3);
        expect($s['kpis'][0]['value'])->toBe('2');  // 2 distinct visitors
        expect($s['kpis'][1]['value'])->toBe('3');  // 3 page views
        expect(collect($s['topPages'])->firstWhere('label', '/')['views'])->toBe(2);
        expect($s['devices'])->not->toBeEmpty();
    });
});
