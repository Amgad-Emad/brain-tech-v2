<?php

namespace Database\Seeders;

use App\Models\TechLogo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechLogoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Technology logos for the home "trust" bar. Images live in /public.
     * Brand names are kept identical across locales.
     */
    public function run(): void
    {
        $logos = [
            ['image' => 'python.jpeg', 'name' => 'Python'],
            ['image' => 'PHP.jpeg', 'name' => 'PHP'],
            ['image' => 'react.jpeg', 'name' => 'React'],
            ['image' => 'flutter.jpeg', 'name' => 'Flutter'],
            ['image' => 'MySQL.jpeg', 'name' => 'MySQL'],
            ['image' => 'SQLA.jpeg', 'name' => 'SQLAlchemy'],
            ['image' => 'docker.jpeg', 'name' => 'Docker'],
            ['image' => 'google_cloud.jpeg', 'name' => 'Google Cloud'],
            ['image' => 'gemini.jpeg', 'name' => 'Gemini'],
            ['image' => 'crewai.jpeg', 'name' => 'CrewAI'],
            ['image' => 'langchain.jpeg', 'name' => 'LangChain'],
            ['image' => 'pytorch.jpeg', 'name' => 'PyTorch'],
            ['image' => 'MCP.jpeg', 'name' => 'MCP'],
        ];

        TechLogo::query()->delete();

        foreach ($logos as $i => $data) {
            TechLogo::create([
                'image' => $data['image'],
                'name' => ['en' => $data['name'], 'ar' => $data['name']],
                'sort_order' => $i,
            ]);
        }
    }
}
