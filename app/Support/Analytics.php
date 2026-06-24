<?php

namespace App\Support;

use App\Models\Visit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Analytics
{
    /**
     * Build the full analytics payload for the dashboard.
     *
     * @return array<string, mixed>
     */
    public static function summary(): array
    {
        $views = (int) Visit::count();
        $visitors = (int) Visit::distinct('visitor_id')->count('visitor_id');
        $sessions = (int) Visit::distinct('session_id')->count('session_id');
        $totalDuration = (int) Visit::sum('duration');

        $singleViewSessions = Visit::select('session_id')
            ->groupBy('session_id')
            ->havingRaw('COUNT(*) = 1')
            ->get()
            ->count();

        $sessionsPerVisitor = Visit::selectRaw('visitor_id, COUNT(DISTINCT session_id) as s')
            ->whereNotNull('visitor_id')
            ->groupBy('visitor_id')
            ->pluck('s', 'visitor_id');
        $returning = $sessionsPerVisitor->filter(fn ($s) => (int) $s > 1)->count();

        return [
            'hasData' => $views > 0,
            'live' => self::live(),
            'kpis' => [
                ['label' => __('admin.an.visitors'), 'value' => number_format($visitors)],
                ['label' => __('admin.an.views'), 'value' => number_format($views)],
                ['label' => __('admin.an.visit_duration'), 'value' => self::duration($sessions ? (int) round($totalDuration / $sessions) : 0)],
                ['label' => __('admin.an.time_per_page'), 'value' => self::duration($views ? (int) round($totalDuration / $views) : 0)],
                ['label' => __('admin.an.bounce'), 'value' => $sessions ? round($singleViewSessions / $sessions * 100).'%' : '0%'],
                ['label' => __('admin.an.returning'), 'value' => $visitors ? round($returning / $visitors * 100).'%' : '0%'],
            ],
            'trend' => self::trend(),
            'topPages' => self::topPages(),
            'devices' => self::breakdown('device', $views),
            'sources' => self::breakdown('source', $views),
            'geo' => self::geo($views),
            'recent' => self::recent(),
            'allCount' => $views,
        ];
    }

    /**
     * @return array{sessions:int, views:int, avg:string}
     */
    private static function live(): array
    {
        $today = Visit::whereDate('created_at', today());
        $views = (int) $today->count();
        $sessions = (int) Visit::whereDate('created_at', today())->distinct('session_id')->count('session_id');
        $dur = (int) Visit::whereDate('created_at', today())->sum('duration');

        return [
            'sessions' => $sessions,
            'views' => $views,
            'avg' => self::duration($views ? (int) round($dur / $views) : 0),
        ];
    }

    /**
     * Distinct visitors per day for the last 14 days.
     *
     * @return array<int, array{label:string, value:int, height:string}>
     */
    private static function trend(): array
    {
        $rows = Visit::where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->get(['visitor_id', 'created_at'])
            ->groupBy(fn ($v) => $v->created_at->toDateString())
            ->map(fn (Collection $g) => $g->pluck('visitor_id')->unique()->count());

        $days = collect(range(13, 0))->map(fn ($i) => now()->subDays($i)->toDateString());
        $max = max(1, (int) $rows->max());

        return $days->map(fn ($d) => [
            'label' => Carbon::parse($d)->format('M j'),
            'value' => (int) ($rows[$d] ?? 0),
            'height' => round(((int) ($rows[$d] ?? 0)) / $max * 100).'%',
        ])->all();
    }

    /**
     * @return array<int, array{label:string, views:int, time:string, width:string}>
     */
    private static function topPages(): array
    {
        $rows = Visit::selectRaw('path, COUNT(*) as views, AVG(duration) as avg_dur')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(6)
            ->get();

        $max = max(1, (int) $rows->max('views'));

        return $rows->map(fn ($r) => [
            'label' => $r->path,
            'views' => (int) $r->views,
            'time' => self::duration((int) round((float) $r->avg_dur)),
            'width' => round((int) $r->views / $max * 100).'%',
        ])->all();
    }

    /**
     * @return array<int, array{label:string, count:int, percent:string}>
     */
    private static function breakdown(string $column, int $total): array
    {
        if ($total === 0) {
            return [];
        }

        return Visit::selectRaw("$column as label, COUNT(*) as c")
            ->whereNotNull($column)
            ->groupBy($column)
            ->orderByDesc('c')
            ->limit(6)
            ->get()
            ->map(fn ($r) => [
                'label' => (string) $r->label,
                'count' => (int) $r->c,
                'percent' => round((int) $r->c / $total * 100).'%',
            ])
            ->all();
    }

    /**
     * @return array<int, array{label:string, count:int, percent:string}>
     */
    private static function geo(int $total): array
    {
        if ($total === 0) {
            return [];
        }

        return Visit::selectRaw('country as label, COUNT(*) as c')
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('c')
            ->limit(6)
            ->get()
            ->map(fn ($r) => [
                'label' => (string) $r->label,
                'count' => (int) $r->c,
                'percent' => round((int) $r->c / $total * 100).'%',
            ])
            ->all();
    }

    /**
     * @return Collection<int, Visit>
     */
    private static function recent(): Collection
    {
        return Visit::latest('created_at')->limit(12)->get();
    }

    public static function duration(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds.'s';
        }

        $minutes = intdiv($seconds, 60);
        $rest = $seconds % 60;

        return $rest ? "{$minutes}m {$rest}s" : "{$minutes}m";
    }
}
