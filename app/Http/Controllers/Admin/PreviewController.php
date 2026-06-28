<?php

namespace App\Http\Controllers\Admin;

use App\Cms\Sections;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Stat;
use App\Models\TechLogo;
use App\Models\Testimonial;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

/**
 * Renders the real public page/section with the editor's unsaved draft
 * applied, for the CMS live preview iframe.
 */
class PreviewController extends Controller
{
    public function render(Request $request, string $section): Response
    {
        $schema = Sections::find($section) ?? abort(404);

        $overrides = $this->settingOverrides($schema, (array) $request->input('s', []));
        if ($schema['hideable'] ?? false) {
            $overrides["visibility.$section"] = true; // always show the section being edited
        }

        $rows = ! empty($schema['collection'])
            ? $this->draftRows($schema, (array) $request->input('items', []))
            : null;

        [$view, $data] = $this->page($section, $rows);

        $html = Setting::withPreview(
            $overrides,
            fn () => view($view, array_merge($data, ['previewMode' => true]))->render(),
        );

        return response($html)->header('Content-Type', 'text/html');
    }

    /**
     * @return array<string, mixed>
     */
    private function settingOverrides(array $schema, array $bag): array
    {
        $overrides = [];

        foreach ($schema['settings'] ?? [] as [$key, $type]) {
            $overrides[$key] = in_array($type, ['text', 'area'], true)
                ? ['en' => (string) ($bag[$key]['en'] ?? ''), 'ar' => (string) ($bag[$key]['ar'] ?? '')]
                : (string) ($bag[$key] ?? '');
        }

        return $overrides;
    }

    /**
     * Merge submitted draft fields onto the saved rows (preserving untouched
     * attributes like icons and slugs).
     */
    private function draftRows(array $schema, array $items): Collection
    {
        $collection = $schema['collection'];
        $model = $collection['model'];
        $fields = $collection['fields'];
        $saved = $model::orderBy('sort_order')->orderBy('id')->get()->keyBy('id');

        if (empty($items)) {
            return $saved->values();
        }

        $out = collect();
        foreach ($items as $attrs) {
            $id = $attrs['id'] ?? null;
            $row = ($id !== null && $id !== '' && $saved->has($id)) ? clone $saved[$id] : new $model;

            foreach ($fields as [$attr, $type]) {
                if (in_array($type, ['text', 'area'], true)) {
                    $row->setAttribute($attr, ['en' => $attrs[$attr]['en'] ?? '', 'ar' => $attrs[$attr]['ar'] ?? '']);
                } elseif ($type === 'bool') {
                    $row->setAttribute($attr, ! empty($attrs[$attr]));
                } else {
                    $row->setAttribute($attr, $attrs[$attr] ?? '');
                }
            }

            $out->push($row);
        }

        return $out;
    }

    /**
     * Map a section to the public view + data that renders it.
     *
     * @return array{0:string, 1:array<string,mixed>}
     */
    private function page(string $section, ?Collection $rows): array
    {
        if ($section === 'about') {
            return ['site.about', [
                'values' => Value::visible()->ordered()->get(),
                'stats' => Stat::visible()->ordered()->get(),
                'metaTitle' => st('seo.about_title'), 'metaDescription' => st('seo.about_description'),
            ]];
        }

        if ($section === 'servicespage') {
            return ['site.services', [
                'services' => $rows ?? Service::visible()->ordered()->get(),
                'metaTitle' => st('seo.services_title'), 'metaDescription' => st('seo.services_description'),
            ]];
        }

        if ($section === 'contact') {
            return ['site.contact', [
                'services' => Service::visible()->ordered()->get(),
                'metaTitle' => st('seo.contact_title'), 'metaDescription' => st('seo.contact_description'),
            ]];
        }

        // Everything else lives on the home page.
        return ['site.home', [
            'techLogos' => $section === 'trust' ? $rows : TechLogo::ordered()->get(),
            'services' => in_array($section, ['services', 'offers'], true) ? $rows : Service::visible()->ordered()->get(),
            'values' => $section === 'values' ? $rows : Value::visible()->ordered()->get(),
            'steps' => $section === 'process' ? $rows : ProcessStep::visible()->ordered()->get(),
            'stats' => $section === 'stats' ? $rows : Stat::visible()->ordered()->get(),
            'projects' => $section === 'work' ? $rows : Project::visible()->ordered()->get(),
            'testimonials' => $section === 'testimonials' ? $rows : Testimonial::visible()->ordered()->get(),
            'faqs' => $section === 'faq' ? $rows : Faq::visible()->ordered()->get(),
            'metaTitle' => st('seo.home_title'), 'metaDescription' => st('seo.home_description'),
        ]];
    }
}
