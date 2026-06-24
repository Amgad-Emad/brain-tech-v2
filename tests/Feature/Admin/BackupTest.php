<?php

use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::factory()->create());
});

describe('export', function () {
    it('downloads a JSON backup of settings and collections', function () {
        $response = $this->get(route('admin.export'));

        $response->assertOk();
        $response->assertHeader('content-disposition');

        $data = $response->json();
        expect($data)->toHaveKeys(['settings', 'collections']);
        expect($data['settings'])->toHaveKey('hero.badge');
        expect($data['collections'])->toHaveKey('services');
    });
});

describe('import', function () {
    it('applies settings and replaces collections from a JSON file', function () {
        $payload = [
            'settings' => ['hero.badge' => ['en' => 'Imported badge', 'ar' => 'مستورد']],
            'collections' => [
                'faqs' => [
                    ['question' => ['en' => 'Imported Q', 'ar' => 'سؤال'], 'answer' => ['en' => 'Imported A', 'ar' => 'جواب'], 'sort_order' => 0, 'is_visible' => true],
                ],
            ],
        ];

        $file = UploadedFile::fake()->createWithContent('cms.json', json_encode($payload));

        $this->post(route('admin.import'), ['file' => $file])->assertRedirect(route('admin.dashboard'));

        expect(Setting::getValue('hero.badge'))->toBe(['en' => 'Imported badge', 'ar' => 'مستورد']);
        expect(Faq::count())->toBe(1);
        expect(Faq::first()->t('question', 'en'))->toBe('Imported Q');
    });

    it('rejects a non-JSON upload', function () {
        $file = UploadedFile::fake()->createWithContent('bad.json', 'not json at all');
        $this->post(route('admin.import'), ['file' => $file])->assertSessionHasErrors('file');

        // settings untouched
        expect(Setting::getValue('hero.badge'))->not->toBe(null);
        expect(Service::count())->toBe(4);
    });
});
