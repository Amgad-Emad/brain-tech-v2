<?php

namespace App\Http\Controllers\Admin;

use App\Cms\Sections;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;

class VisibilityController extends Controller
{
    public function toggle(string $section): RedirectResponse
    {
        $schema = Sections::find($section);

        abort_unless($schema && ($schema['hideable'] ?? false), 404);

        $current = (bool) setting_raw("visibility.$section", true);
        Setting::put("visibility.$section", ! $current, 'visibility');
        Setting::flushCache();

        return back()->with('toast', __('admin.toast.visibility'));
    }
}
