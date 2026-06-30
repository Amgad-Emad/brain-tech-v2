<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->actingAs(User::factory()->create());
});

/** A minimal valid create/update payload. */
function projectPayload(array $overrides = []): array
{
    return array_merge([
        'name' => ['en' => 'New Build', 'ar' => 'مشروع جديد'],
        'slug' => 'new-build',
        'tag' => ['en' => 'Software', 'ar' => 'برمجيات'],
        'year' => '2025',
        'metric' => '+50%',
        'metric_label' => ['en' => 'growth', 'ar' => 'نمو'],
        'client' => ['en' => 'Acme', 'ar' => 'أكمي'],
        'alt' => ['en' => 'A screenshot', 'ar' => 'لقطة'],
        'summary' => ['en' => 'A summary', 'ar' => 'ملخص'],
        'challenge' => ['en' => 'The challenge', 'ar' => 'التحدي'],
        'approach' => ['en' => 'The approach', 'ar' => 'المنهجية'],
        'is_visible' => '1',
        'results' => [
            ['metric' => '+212%', 'label' => ['en' => 'conversion', 'ar' => 'تحويل']],
            ['metric' => '', 'label' => ['en' => '', 'ar' => '']], // blank → dropped
        ],
        'services' => [
            ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
            ['en' => '', 'ar' => ''], // blank → dropped
        ],
    ], $overrides);
}

it('renders the index, create, and edit screens', function () {
    $project = Project::create(projectPayloadModel());
    $project->addMedia(UploadedFile::fake()->image('hero.jpg'))->toMediaCollection('featured_image');
    $project->addMedia(UploadedFile::fake()->image('g.jpg'))->toMediaCollection('gallery');

    $this->get(route('admin.projects.index'))->assertOk()->assertSee('Existing');
    $this->get(route('admin.projects.create'))->assertOk();
    $this->get(route('admin.projects.edit', $project))->assertOk()->assertSee('Existing');
});

it('creates a project with a featured image and gallery', function () {
    $payload = projectPayload([
        'featured_image' => UploadedFile::fake()->image('hero.jpg', 1200, 800),
        'gallery' => [
            UploadedFile::fake()->image('g1.jpg'),
            UploadedFile::fake()->image('g2.jpg'),
        ],
    ]);

    $this->post(route('admin.projects.store'), $payload)
        ->assertRedirect()
        ->assertSessionHas('toast');

    $project = Project::where('slug', 'new-build')->firstOrFail();

    expect($project->t('name', 'en'))->toBe('New Build');
    expect($project->t('name', 'ar'))->toBe('مشروع جديد');
    expect($project->is_visible)->toBeTrue();
    expect($project->results)->toHaveCount(1);
    expect($project->results[0]['metric'])->toBe('+212%');
    expect($project->services_used)->toHaveCount(1);
    expect($project->getFirstMedia('featured_image'))->not->toBeNull();
    expect($project->getMedia('gallery'))->toHaveCount(2);
});

it('auto-generates a slug from the english name when blank', function () {
    $this->post(route('admin.projects.store'), projectPayload(['slug' => '', 'name' => ['en' => 'My Cool App', 'ar' => '']]));

    expect(Project::where('slug', 'my-cool-app')->exists())->toBeTrue();
});

it('rejects a duplicate slug and a missing english name', function () {
    Project::create(['slug' => 'taken', 'name' => ['en' => 'X', 'ar' => ''], 'tag' => ['en' => 'Software', 'ar' => '']]);

    $this->post(route('admin.projects.store'), projectPayload(['slug' => 'taken']))
        ->assertSessionHasErrors('slug');

    $this->post(route('admin.projects.store'), projectPayload(['name' => ['en' => '', 'ar' => '']]))
        ->assertSessionHasErrors('name.en');
});

it('replaces the featured image and removes a chosen gallery image on update', function () {
    $project = Project::create(projectPayloadModel());
    $project->addMedia(UploadedFile::fake()->image('old.jpg'))->toMediaCollection('featured_image');
    $project->addMedia(UploadedFile::fake()->image('keep.jpg'))->toMediaCollection('gallery');
    $project->addMedia(UploadedFile::fake()->image('drop.jpg'))->toMediaCollection('gallery');

    $dropId = $project->getMedia('gallery')->last()->id;

    $this->put(route('admin.projects.update', $project), projectPayload([
        'slug' => $project->slug,
        'featured_image' => UploadedFile::fake()->image('new.jpg'),
        'remove_gallery' => [$dropId],
    ]))->assertRedirect();

    $project->refresh();
    expect($project->getFirstMedia('featured_image')->file_name)->toBe('new.jpg');
    expect($project->getMedia('gallery'))->toHaveCount(1);
    expect($project->getMedia('gallery')->first()->file_name)->toBe('keep.jpg');
});

it('removes the featured image when asked', function () {
    $project = Project::create(projectPayloadModel());
    $project->addMedia(UploadedFile::fake()->image('hero.jpg'))->toMediaCollection('featured_image');

    $this->put(route('admin.projects.update', $project), projectPayload([
        'slug' => $project->slug,
        'remove_featured' => '1',
    ]))->assertRedirect();

    expect($project->fresh()->getFirstMedia('featured_image'))->toBeNull();
});

it('deletes a project and its media', function () {
    $project = Project::create(projectPayloadModel());
    $project->addMedia(UploadedFile::fake()->image('hero.jpg'))->toMediaCollection('featured_image');
    $mediaPath = $project->getFirstMedia('featured_image')->getPathRelativeToRoot();

    $this->delete(route('admin.projects.destroy', $project))
        ->assertRedirect(route('admin.projects.index'));

    expect(Project::find($project->id))->toBeNull();
    Storage::disk('public')->assertMissing($mediaPath);
});

/** Bare attributes for seeding a Project model directly in tests. */
function projectPayloadModel(): array
{
    return [
        'slug' => 'existing-'.uniqid(),
        'name' => ['en' => 'Existing', 'ar' => 'قائم'],
        'tag' => ['en' => 'Software', 'ar' => 'برمجيات'],
        'is_visible' => true,
    ];
}
