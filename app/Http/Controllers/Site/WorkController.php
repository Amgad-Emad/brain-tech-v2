<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Contracts\View\View;

class WorkController extends Controller
{
    public function index(): View
    {
        return view('site.work', [
            'projects' => Project::visible()->ordered()->get(),
            'metaTitle' => st('seo.work_title'),
            'metaDescription' => st('seo.work_description'),
        ]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_visible, 404);

        $next = Project::visible()->ordered()
            ->where('id', '!=', $project->id)
            ->first()
            ?? $project;

        return view('site.work-show', [
            'project' => $project,
            'next' => $next,
            'metaTitle' => $project->t('name').' — '.st('brand.name'),
            'metaDescription' => $project->t('summary'),
        ]);
    }
}
