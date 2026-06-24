<?php

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        if (Visit::count() > 0) {
            return;
        }

        $pages = ['/' => 40, '/services' => 18, '/work' => 14, '/about' => 12, '/contact' => 9, '/work/fintech-onboarding' => 7];
        $devices = ['Desktop' => 60, 'Mobile' => 33, 'Tablet' => 7];
        $sources = ['Direct' => 38, 'Google' => 30, 'LinkedIn' => 14, 'X / Twitter' => 9, 'GitHub' => 9];
        $geo = ['United States' => 32, 'United Arab Emirates' => 16, 'United Kingdom' => 12, 'Germany' => 10, 'India' => 10, 'Saudi Arabia' => 9, 'Egypt' => 7, 'Canada' => 4];

        $rows = [];
        $visitors = [];
        for ($v = 0; $v < 90; $v++) {
            $visitors[] = 'v_'.Str::random(24);
        }

        for ($i = 0; $i < 320; $i++) {
            $visitor = $visitors[array_rand($visitors)];
            $session = 's_'.substr(md5($visitor.random_int(1, 4)), 0, 18);
            $when = Carbon::now()->subDays(random_int(0, 13))->subMinutes(random_int(0, 1439));

            $rows[] = [
                'path' => $this->weighted($pages),
                'locale' => random_int(0, 100) < 78 ? 'en' : 'ar',
                'device' => $this->weighted($devices),
                'source' => $this->weighted($sources),
                'country' => $this->weighted($geo),
                'ip' => random_int(11, 220).'.'.random_int(0, 255).'.'.random_int(0, 255).'.x',
                'visitor_id' => $visitor,
                'session_id' => $session,
                'duration' => random_int(4, 240),
                'created_at' => $when,
            ];
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            Visit::insert($chunk);
        }
    }

    /**
     * @param  array<string, int>  $weights
     */
    private function weighted(array $weights): string
    {
        $total = array_sum($weights);
        $r = random_int(1, $total);
        $acc = 0;
        foreach ($weights as $key => $weight) {
            $acc += $weight;
            if ($r <= $acc) {
                return $key;
            }
        }

        return (string) array_key_first($weights);
    }
}
