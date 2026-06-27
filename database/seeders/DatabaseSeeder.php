<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@brain-tech.com'],
            [
                'name' => 'Brain-Tech Admin',
                'password' => Hash::make('Br@inTech-Adm1n#2026!'),
                'email_verified_at' => now(),
            ],
        );

        $this->call([
            SettingsSeeder::class,
            ContentSeeder::class,
            // Creates the full portfolio (projects 4-23) and attaches media.
            // Must run after ContentSeeder, which seeds the first 3 case studies.
            PortfolioMediaSeeder::class,
            VisitSeeder::class,
        ]);

        Setting::flushCache();
    }
}
