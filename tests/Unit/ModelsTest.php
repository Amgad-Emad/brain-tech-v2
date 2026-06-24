<?php

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;

describe('Stat::display', function () {
    it('formats the number with the suffix', function () {
        expect((new Stat(['value' => 480, 'suffix' => '+']))->display())->toBe('480+');
        expect((new Stat(['value' => 1000, 'suffix' => '']))->display())->toBe('1,000');
        expect((new Stat(['value' => 99, 'suffix' => '%']))->display())->toBe('99%');
    });
});

describe('Project::imageUrl', function () {
    it('returns the bundled placeholder when empty', function () {
        expect((new Project)->imageUrl())->toContain('mark-512.png');
    });

    it('returns absolute URLs untouched', function () {
        $url = 'https://images.unsplash.com/photo.jpg';
        expect((new Project(['image_path' => $url]))->imageUrl())->toBe($url);
    });

    it('maps a stored path to the public storage URL', function () {
        expect((new Project(['image_path' => 'projects/a.png']))->imageUrl())->toContain('storage/projects/a.png');
    });
});

describe('ContactMessage', function () {
    it('reports read state and marks itself read', function () {
        $m = ContactMessage::create(['name' => 'A', 'email' => 'a@b.com', 'message' => 'hello there friend']);

        expect($m->isRead())->toBeFalse();
        $m->markRead();
        expect($m->fresh()->isRead())->toBeTrue();
    });

    it('scopes to unread messages', function () {
        ContactMessage::create(['name' => 'A', 'email' => 'a@b.com', 'message' => 'unread one', 'read_at' => null]);
        ContactMessage::create(['name' => 'B', 'email' => 'b@b.com', 'message' => 'read one', 'read_at' => now()]);

        expect(ContactMessage::unread()->count())->toBe(1);
    });
});

describe('scopes & route keys', function () {
    it('visible() and ordered() filter and sort', function () {
        Service::create(['slug' => 'a', 'title' => ['en' => 'A'], 'description' => ['en' => 'a'], 'sort_order' => 2, 'is_visible' => true]);
        Service::create(['slug' => 'b', 'title' => ['en' => 'B'], 'description' => ['en' => 'b'], 'sort_order' => 1, 'is_visible' => false]);

        expect(Service::visible()->count())->toBe(1);
        expect(Service::ordered()->pluck('slug')->first())->toBe('b');
    });

    it('routes services and projects by slug', function () {
        expect((new Service)->getRouteKeyName())->toBe('slug');
        expect((new Project)->getRouteKeyName())->toBe('slug');
    });
});
