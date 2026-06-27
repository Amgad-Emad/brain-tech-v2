<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Value;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BackupController extends Controller
{
    /** @var array<string, class-string> */
    private const COLLECTIONS = [
        'services' => Service::class,
        'projects' => Project::class,
        'values' => Value::class,
        'process_steps' => ProcessStep::class,
        'stats' => Stat::class,
        'testimonials' => Testimonial::class,
        'faqs' => Faq::class,
    ];

    public function export(): Response
    {
        try {
            $payload = [
                'version' => 1,
                'exported_at' => now()->toIso8601String(),
                'settings' => Setting::all()->mapWithKeys(fn ($s) => [$s->key => json_decode((string) $s->value, true)]),
                'collections' => collect(self::COLLECTIONS)->map(
                    fn ($model) => $model::orderBy('sort_order')->get()->map->getAttributes()->all()
                ),
            ];
        } catch (\Throwable $e) {
            Log::error('[backup] CMS export failed.', ['exception' => $e]);

            throw $e;
        }

        return response()
            ->json($payload, 200, [
                'Content-Disposition' => 'attachment; filename="brain-tech-cms-'.now()->format('Y-m-d').'.json"',
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required', 'file', 'mimetypes:application/json,text/plain', 'max:4096']]);

        $data = json_decode($request->file('file')->get(), true);

        if (! is_array($data)) {
            return back()->withErrors(['file' => 'That file is not valid CMS JSON.']);
        }

        // Wrap the whole import in a transaction so a failure mid-way (after
        // collections are emptied) rolls back instead of wiping CMS content.
        try {
            DB::transaction(function () use ($data): void {
                foreach (($data['settings'] ?? []) as $key => $value) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => json_encode($value, JSON_UNESCAPED_UNICODE)],
                    );
                }

                foreach (($data['collections'] ?? []) as $name => $rows) {
                    $model = self::COLLECTIONS[$name] ?? null;
                    if (! $model || ! is_array($rows)) {
                        continue;
                    }

                    $model::query()->delete();
                    foreach ($rows as $row) {
                        unset($row['id'], $row['created_at'], $row['updated_at']);
                        $model::create($row);
                    }
                }
            });
        } catch (\Throwable $e) {
            Log::error('[backup] CMS import failed; all changes rolled back.', [
                'settings_count' => is_array($data['settings'] ?? null) ? count($data['settings']) : 0,
                'collections' => array_keys($data['collections'] ?? []),
                'exception' => $e,
            ]);

            return back()->withErrors(['file' => 'Import failed and was rolled back. See the application logs for details.']);
        }

        Setting::flushCache();

        return redirect()->route('admin.dashboard')->with('toast', __('admin.toast.imported'));
    }
}
