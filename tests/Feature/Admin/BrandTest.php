<?php

use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    $this->seed();
    $this->actingAs(User::factory()->create());
});

describe('brand & colours', function () {
    it('renders the editor with presets', function () {
        $this->get(route('admin.brand.edit'))->assertOk()->assertSee('Emerald');
    });

    it('saves valid colours', function () {
        $this->put(route('admin.brand.update'), [
            'accent' => '#ff8a4c', 'grad_from' => '#ff6a3d', 'grad_to' => '#ffb347', 'ink' => '#ffa766',
        ])->assertRedirect(route('admin.brand.edit'));

        expect(Setting::getValue('theme.accent'))->toBe('#ff8a4c');
    });

    it('rejects invalid hex colours', function () {
        $this->put(route('admin.brand.update'), [
            'accent' => 'red', 'grad_from' => '#0ddc83', 'grad_to' => '#16e89a', 'ink' => '#34e0a0',
        ])->assertSessionHasErrors('accent');
    });

    it('resets to the default palette', function () {
        Setting::put('theme.accent', '#000000', 'theme');
        $this->post(route('admin.brand.reset'))->assertRedirect();
        expect(Setting::getValue('theme.accent'))->toBe('#34e0a0');
    });
});
