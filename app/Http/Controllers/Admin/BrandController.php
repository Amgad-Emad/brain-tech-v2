<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public const PRESETS = [
        ['name' => 'Emerald', 'accent' => '#34e0a0', 'grad_from' => '#0ddc83', 'grad_to' => '#16e89a', 'ink' => '#34e0a0'],
        ['name' => 'Electric', 'accent' => '#9aa6ff', 'grad_from' => '#4f7dff', 'grad_to' => '#a24bff', 'ink' => '#9aa6ff'],
        ['name' => 'Sunset', 'accent' => '#ffa766', 'grad_from' => '#ff6a3d', 'grad_to' => '#ffb347', 'ink' => '#ffa766'],
        ['name' => 'Royal', 'accent' => '#c98bff', 'grad_from' => '#7c5cff', 'grad_to' => '#c026d3', 'ink' => '#c98bff'],
        ['name' => 'Cyan', 'accent' => '#5fd3e0', 'grad_from' => '#06b6d4', 'grad_to' => '#3b82f6', 'ink' => '#5fd3e0'],
        ['name' => 'Crimson', 'accent' => '#ff8aa0', 'grad_from' => '#f43f5e', 'grad_to' => '#fb923c', 'ink' => '#ff8aa0'],
    ];

    public const DEFAULTS = ['accent' => '#34e0a0', 'grad_from' => '#0ddc83', 'grad_to' => '#16e89a', 'ink' => '#34e0a0'];

    public function edit(): View
    {
        return view('admin.brand', [
            'colors' => [
                'accent' => setting_raw('theme.accent', self::DEFAULTS['accent']),
                'grad_from' => setting_raw('theme.grad_from', self::DEFAULTS['grad_from']),
                'grad_to' => setting_raw('theme.grad_to', self::DEFAULTS['grad_to']),
                'ink' => setting_raw('theme.ink', self::DEFAULTS['ink']),
            ],
            'presets' => self::PRESETS,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'accent' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'grad_from' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'grad_to' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'ink' => ['required', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::put("theme.$key", $value, 'theme');
        }

        Setting::flushCache();

        return redirect()->route('admin.brand.edit')->with('toast', __('admin.toast.saved'));
    }

    public function reset(): RedirectResponse
    {
        foreach (self::DEFAULTS as $key => $value) {
            Setting::put("theme.$key", $value, 'theme');
        }

        Setting::flushCache();

        return redirect()->route('admin.brand.edit')->with('toast', __('admin.toast.reset'));
    }
}
