<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /** Translatable {en, ar} attributes editable from the form. */
    private const TRANSLATABLE = [
        'name', 'tag', 'metric_label', 'client', 'alt', 'summary', 'challenge', 'approach',
    ];

    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create', [
            'project' => new Project,
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = new Project;

        $this->persist($project, $request, isNew: true);

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('toast', __('admin.toast.saved'));
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', [
            'project' => $project,
        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $this->persist($project, $request, isNew: false);

        return redirect()
            ->route('admin.projects.edit', $project)
            ->with('toast', __('admin.toast.saved'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        // Cascade media files with the row so deleting a project leaves nothing behind.
        try {
            DB::transaction(function () use ($project): void {
                $project->clearMediaCollection('featured_image');
                $project->clearMediaCollection('gallery');
                $project->delete();
            });
        } catch (\Throwable $e) {
            Log::error('[cms] Failed to delete project.', ['id' => $project->id, 'exception' => $e]);

            throw $e;
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('toast', __('admin.projects.deleted'));
    }

    /**
     * Save scalar/translatable fields and the repeatable lists, then sync media.
     */
    private function persist(Project $project, ProjectRequest $request, bool $isNew): void
    {
        $data = [
            'slug' => $request->input('slug'),
            'year' => $request->input('year'),
            'metric' => $request->input('metric'),
            'image_path' => $request->input('image_path'),
            'is_visible' => $request->boolean('is_visible'),
            'sort_order' => $request->filled('sort_order')
                ? (int) $request->input('sort_order')
                : ($isNew ? (int) Project::max('sort_order') + 1 : $project->sort_order),
            'results' => $this->results($request),
            'services_used' => $this->services($request),
        ];

        foreach (self::TRANSLATABLE as $attr) {
            $data[$attr] = [
                'en' => (string) $request->input("$attr.en", ''),
                'ar' => (string) $request->input("$attr.ar", ''),
            ];
        }

        try {
            DB::transaction(function () use ($project, $data, $request): void {
                $project->fill($data)->save();
                $this->syncMedia($project, $request);
            });
        } catch (\Throwable $e) {
            Log::error('[cms] Failed to save project; changes rolled back.', [
                'slug' => $data['slug'],
                'exception' => $e,
            ]);

            throw $e;
        }
    }

    /**
     * Replace the featured image, drop removed gallery images, and append uploads.
     */
    private function syncMedia(Project $project, ProjectRequest $request): void
    {
        if ($request->hasFile('featured_image')) {
            $project->clearMediaCollection('featured_image');
            $project->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
        } elseif ($request->boolean('remove_featured')) {
            $project->clearMediaCollection('featured_image');
        }

        foreach ((array) $request->input('remove_gallery', []) as $mediaId) {
            $project->getMedia('gallery')->firstWhere('id', (int) $mediaId)?->delete();
        }

        foreach ((array) $request->file('gallery', []) as $file) {
            if ($file?->isValid()) {
                $project->addMedia($file)->toMediaCollection('gallery');
            }
        }
    }

    /**
     * @return array<int, array{metric:string, label:array{en:string, ar:string}}>
     */
    private function results(ProjectRequest $request): array
    {
        $out = [];

        foreach ((array) $request->input('results', []) as $row) {
            $metric = trim((string) ($row['metric'] ?? ''));
            $en = trim((string) ($row['label']['en'] ?? ''));
            $ar = trim((string) ($row['label']['ar'] ?? ''));

            if ($metric === '' && $en === '' && $ar === '') {
                continue;
            }

            $out[] = ['metric' => $metric, 'label' => ['en' => $en, 'ar' => $ar]];
        }

        return $out;
    }

    /**
     * @return array<int, array{en:string, ar:string}>
     */
    private function services(ProjectRequest $request): array
    {
        $out = [];

        foreach ((array) $request->input('services', []) as $row) {
            $en = trim((string) ($row['en'] ?? ''));
            $ar = trim((string) ($row['ar'] ?? ''));

            if ($en === '' && $ar === '') {
                continue;
            }

            $out[] = ['en' => $en, 'ar' => $ar];
        }

        return $out;
    }
}
