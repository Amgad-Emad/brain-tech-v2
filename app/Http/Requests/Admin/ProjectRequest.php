<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route is already behind the `auth` middleware group.
        return true;
    }

    /**
     * Normalise the slug (and the visibility flag) before validation so the
     * unique check runs against the value we actually store. Falls back to a
     * slug derived from the English name when the slug field is left blank.
     */
    protected function prepareForValidation(): void
    {
        $slug = Str::slug((string) $this->input('slug'));

        if ($slug === '') {
            $slug = Str::slug((string) $this->input('name.en', ''));
        }

        $this->merge([
            'slug' => $slug,
            'is_visible' => $this->boolean('is_visible'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $projectId = $this->route('project')?->id;

        return [
            'slug' => ['required', 'alpha_dash', 'max:255', Rule::unique('projects', 'slug')->ignore($projectId)],
            'name.en' => ['required', 'string', 'max:255'],
            'name.ar' => ['nullable', 'string', 'max:255'],
            'tag.en' => ['nullable', 'string', 'max:120'],
            'tag.ar' => ['nullable', 'string', 'max:120'],
            'year' => ['nullable', 'string', 'max:8'],
            'metric' => ['nullable', 'string', 'max:60'],
            'metric_label.en' => ['nullable', 'string', 'max:120'],
            'metric_label.ar' => ['nullable', 'string', 'max:120'],
            'client.en' => ['nullable', 'string', 'max:160'],
            'client.ar' => ['nullable', 'string', 'max:160'],
            'alt.en' => ['nullable', 'string', 'max:255'],
            'alt.ar' => ['nullable', 'string', 'max:255'],
            'summary.en' => ['nullable', 'string', 'max:2000'],
            'summary.ar' => ['nullable', 'string', 'max:2000'],
            'challenge.en' => ['nullable', 'string', 'max:2000'],
            'challenge.ar' => ['nullable', 'string', 'max:2000'],
            'approach.en' => ['nullable', 'string', 'max:2000'],
            'approach.ar' => ['nullable', 'string', 'max:2000'],
            'image_path' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_visible' => ['boolean'],

            'results' => ['nullable', 'array'],
            'results.*.metric' => ['nullable', 'string', 'max:60'],
            'results.*.label.en' => ['nullable', 'string', 'max:160'],
            'results.*.label.ar' => ['nullable', 'string', 'max:160'],

            'services' => ['nullable', 'array'],
            'services.*.en' => ['nullable', 'string', 'max:160'],
            'services.*.ar' => ['nullable', 'string', 'max:160'],

            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif,avif', 'max:8192'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif,avif', 'max:8192'],
        ];
    }
}
