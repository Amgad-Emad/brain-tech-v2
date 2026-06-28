<?php

namespace App\Http\Controllers\Admin;

use App\Cms\Sections;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    public function edit(string $section): View
    {
        $schema = Sections::find($section) ?? abort(404);

        return view('admin.section', [
            'section' => $schema,
            'settingValues' => $this->settingValues($schema),
            'rows' => $this->collectionRows($schema),
        ]);
    }

    public function update(Request $request, string $section): RedirectResponse
    {
        $schema = Sections::find($section) ?? abort(404);

        // Transaction: settings + collection (which deletes/recreates rows) must
        // commit together, so a failure can't leave a section half-saved.
        try {
            DB::transaction(function () use ($schema, $request): void {
                $this->saveSettings($schema, (array) $request->input('s', []));
                $this->saveCollection($schema, (array) $request->input('items', []));
            });
        } catch (\Throwable $e) {
            Log::error('[cms] Failed to save section; changes rolled back.', [
                'section' => $section,
                'exception' => $e,
            ]);

            throw $e;
        }

        Setting::flushCache();

        return redirect()
            ->route('admin.section.edit', $section)
            ->with('toast', __('admin.toast.saved'));
    }

    /* ---------------- settings ---------------- */

    /**
     * @return array<string, mixed>
     */
    private function settingValues(array $schema): array
    {
        $out = [];
        foreach ($schema['settings'] ?? [] as [$key, $type]) {
            $out[$key] = setting_raw($key);
        }

        return $out;
    }

    private function saveSettings(array $schema, array $bag): void
    {
        foreach ($schema['settings'] ?? [] as [$key, $type]) {
            $group = Str::before($key, '.');

            if (in_array($type, ['text', 'area'], true)) {
                Setting::put($key, [
                    'en' => (string) ($bag[$key]['en'] ?? ''),
                    'ar' => (string) ($bag[$key]['ar'] ?? ''),
                ], $group, true);
            } else {
                Setting::put($key, (string) ($bag[$key] ?? ''), $group);
            }
        }
    }

    /* ---------------- collections ---------------- */

    /**
     * Build row display values for the form.
     *
     * @return array<int, array{key:int|string, values:array<string,mixed>}>
     */
    private function collectionRows(array $schema): array
    {
        if (empty($schema['collection'])) {
            return [];
        }

        $collection = $schema['collection'];
        $model = $collection['model'];

        return $model::query()->orderBy('sort_order')->orderBy('id')->get()
            ->map(fn ($row) => [
                'key' => $row->id,
                'values' => collect($collection['fields'])->mapWithKeys(
                    fn ($f) => [$f[0] => $row->getAttribute($f[0])]
                )->all(),
            ])->all();
    }

    private function saveCollection(array $schema, array $items): void
    {
        if (empty($schema['collection'])) {
            return;
        }

        $collection = $schema['collection'];
        $model = $collection['model'];
        $dynamic = (bool) ($collection['dynamic'] ?? false);
        $fields = $collection['fields'];

        $seen = [];
        $order = 0;

        foreach ($items as $attrs) {
            $id = $attrs['id'] ?? null;
            $data = ['sort_order' => $order++];

            foreach ($fields as [$attr, $type]) {
                if (in_array($type, ['text', 'area'], true)) {
                    $data[$attr] = [
                        'en' => (string) ($attrs[$attr]['en'] ?? ''),
                        'ar' => (string) ($attrs[$attr]['ar'] ?? ''),
                    ];
                } elseif ($type === 'bool') {
                    $data[$attr] = ! empty($attrs[$attr]);
                } else {
                    $data[$attr] = $attrs[$attr] ?? '';
                }
            }

            if (is_numeric($id) && ($row = $model::find($id))) {
                $row->fill($data)->save();
                $seen[] = (int) $id;
            } elseif ($dynamic && $this->rowHasContent($data, $fields)) {
                $seen[] = $model::create($data)->id;
            }
        }

        if ($dynamic) {
            $model::whereNotIn('id', $seen ?: [0])->delete();
        }
    }

    /**
     * @param  array<int, array{0:string,1:string}>  $fields
     */
    private function rowHasContent(array $data, array $fields): bool
    {
        foreach ($fields as [$attr, $type]) {
            $value = $data[$attr] ?? null;
            if (is_array($value) && (filled($value['en'] ?? null) || filled($value['ar'] ?? null))) {
                return true;
            }
            if (! is_array($value) && filled($value)) {
                return true;
            }
        }

        return false;
    }
}
