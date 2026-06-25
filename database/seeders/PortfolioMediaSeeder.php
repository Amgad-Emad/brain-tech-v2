<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * Seeds the portfolio media (featured_image + gallery) from the holistecpath
 * dump onto our Project model via Spatie Media Library.
 *
 * Run explicitly (it downloads images, so it's kept out of the default seed):
 *   php artisan db:seed --class=Database\Seeders\PortfolioMediaSeeder
 *
 * Unsplash photos (photo-*) are downloaded and display immediately. The other
 * (uploaded) files aren't in this repo, so a placeholder is stored under the
 * original filename — drop the real file into storage/app/public/<id>/<file>.
 */
class PortfolioMediaSeeder extends Seeder
{
    /** Tag (en) => ar */
    private const TAGS = [
        'Software' => 'برمجيات',
        'Tech Solutions' => 'حلول تقنية',
        'Marketing' => 'تسويق رقمي',
        'Video' => 'مونتاج فيديو',
    ];

    public function run(): void
    {
        $projects = $this->ensureProjects();

        // portfolio id => [featured file, [gallery files...]]
        $media = [
            1 => ['photo-1531746790731-6c087fecd65a.jpeg', ['photo-1551288049-bebda4e38f71.jpeg', 'photo-1460925895917-afdab827c52f.jpeg']],
            2 => ['photo-1454165804606-c3d57bc86b40.jpeg', ['photo-1551288049-bebda4e38f71.jpeg']],
            3 => ['photo-1551288049-bebda4e38f71.jpeg', []],
            4 => ['photo-1550751827-4bd374c3f58b.jpeg', ['photo-1558494949-ef010cbdcc31.jpeg']],
            5 => ['photo-1461773518188-b3e86f98242f.jpeg', ['photo-1512941937669-90a1b58e7e9c.jpeg', 'photo-1434494878577-86c23bcb06b9.jpeg']],
            6 => ['photo-1557426272-fc759fdf7a8d.jpeg', []],
            7 => ['photo-1561070791-2526d30994b5.jpeg', ['photo-1586717791821-3f44a563fa4c.jpeg', 'photo-1558655146-364adaf1fcc9.jpeg']],
            8 => ['photo-1551288049-bebda4e38f71.jpeg', []],
            9 => ['photo-1576091160399-112ba8d25d1d.jpeg', ['photo-1551288049-bebda4e38f71.jpeg']],
            10 => ['61SnF6pwxtL._AC_SL1500_.jpg', ['images-(1).jpeg']],
            11 => ['dressai.jpg', []],
            12 => ['20241001184512.jpg', []],
            13 => ['images.jfif', []],
            14 => ['Upper-gastrointestinal-endoscopic-findings.png', []],
            15 => ['Screenshot-2026-01-31-at-1.03.47-PM.png', []],
            16 => ['pexels-hello-pipcke-1008732483-20285350.jpg', []],
            17 => ['pexels-cottonbro-3584994.jpg', []],
            18 => ['Screenshot-2026-02-01-at-11.29.18-AM.png', ['Screenshot-2026-02-01-at-11.29.18-AM.png', 'Screenshot-2026-02-01-at-11.31.11-AM.png', 'Screenshot-2026-02-01-at-11.31.32-AM.png', 'Screenshot-2026-02-01-at-11.31.57-AM.png', 'Screenshot-2026-02-01-at-11.32.58-AM.png']],
            19 => ['Screenshot-2026-02-01-at-12.28.07-PM.png', ['Screenshot-2026-02-01-at-12.27.37-PM.png', 'Screenshot-2026-02-01-at-12.28.07-PM.png']],
            20 => ['Screenshot-2026-02-01-at-12.46.46-PM.png', ['Screenshot-2026-02-01-at-12.46.46-PM.png', 'Screenshot-2026-02-01-at-12.47.06-PM.png', 'Screenshot-2026-02-01-at-12.47.15-PM.png', 'Screenshot-2026-02-01-at-12.47.30-PM.png']],
            21 => ['CRM-project-automation.png', []],
            22 => ['ChatGPT-Image-Feb-6-2026.png', []],
            23 => ['ChatGPT-Image-Feb-26-2026.png', []],
        ];

        $placeholder = public_path('Brain-Tech-Premium-Website/brand/mark-512.png');

        foreach ($media as $id => [$featured, $gallery]) {
            $project = $projects[$id] ?? null;
            if (! $project) {
                continue;
            }

            $project->clearMediaCollection('featured_image');
            $project->clearMediaCollection('gallery');

            $this->attach($project, 'featured_image', $featured, $placeholder);
            foreach ($gallery as $file) {
                $this->attach($project, 'gallery', $file, $placeholder);
            }
        }

        $this->command?->info('Portfolio media seeded across '.count($media).' projects.');
    }

    private function attach(Project $project, string $collection, string $file, string $placeholder): void
    {
        $name = pathinfo($file, PATHINFO_FILENAME);

        // Unsplash photos can be fetched live; everything else gets a placeholder
        // stored under the original filename for the user to replace.
        if (str_starts_with($name, 'photo-')) {
            try {
                $project->addMediaFromUrl("https://images.unsplash.com/{$name}?w=1400&q=80")
                    ->usingName($name)->usingFileName($file)->toMediaCollection($collection);

                return;
            } catch (\Throwable $e) {
                // fall through to placeholder when offline
            }
        }

        try {
            $project->addMedia($placeholder)->preservingOriginal()
                ->usingName($name)->usingFileName($file)->toMediaCollection($collection);
        } catch (\Throwable $e) {
            $this->command?->warn("Skipped media {$file}: {$e->getMessage()}");
        }
    }

    /**
     * @return array<int, Project> portfolio id (1-23) => Project
     */
    private function ensureProjects(): array
    {
        $map = [];

        // Portfolios 1-3 map onto the curated case studies already seeded.
        foreach (Project::orderBy('sort_order')->orderBy('id')->take(3)->get()->values() as $i => $project) {
            $map[$i + 1] = $project;
        }

        // Portfolios 4-23 — light, editable entries created for the media.
        foreach ($this->definitions() as $offset => [$slug, $nameEn, $nameAr, $tag, $metric, $labelEn, $labelAr]) {
            $id = $offset + 4;
            $map[$id] = Project::updateOrCreate(['slug' => $slug], [
                'name' => ['en' => $nameEn, 'ar' => $nameAr],
                'tag' => ['en' => $tag, 'ar' => self::TAGS[$tag]],
                'year' => '2025',
                'metric' => $metric,
                'metric_label' => ['en' => $labelEn, 'ar' => $labelAr],
                'client' => ['en' => 'Confidential', 'ar' => 'سرّي'],
                'alt' => ['en' => $nameEn, 'ar' => $nameAr],
                'summary' => [
                    'en' => "A {$tag} engagement delivered end to end by Brain-Tech.",
                    'ar' => 'مشروع نفّذه براين-تك من البداية إلى النهاية.',
                ],
                'sort_order' => $id,
                'is_visible' => true,
            ]);
        }

        return $map;
    }

    /**
     * @return array<int, array{0:string,1:string,2:string,3:string,4:string,5:string,6:string}>
     */
    private function definitions(): array
    {
        return [
            ['onboarding-analytics-suite', 'Onboarding Analytics Suite', 'منصّة تحليلات التهيئة', 'Software', '+38%', 'activation', 'التفعيل'],
            ['logistics-control-tower', 'Logistics Control Tower', 'برج تحكّم لوجستي', 'Tech Solutions', '99.9%', 'uptime', 'زمن التشغيل'],
            ['brand-launch-campaign', 'Brand Launch Campaign', 'حملة إطلاق علامة', 'Marketing', '5.2×', 'reach', 'الوصول'],
            ['product-explainer-series', 'Product Explainer Series', 'سلسلة فيديو تعريفية', 'Video', '+120%', 'watch time', 'وقت المشاهدة'],
            ['customer-portal-revamp', 'Customer Portal Revamp', 'تجديد بوّابة العملاء', 'Software', '−45%', 'support tickets', 'تذاكر الدعم'],
            ['cloud-cost-optimizer', 'Cloud Cost Optimizer', 'مُحسّن تكلفة السحابة', 'Tech Solutions', '−52%', 'infra cost', 'تكلفة البنية'],
            ['ecommerce-storefront', 'E-commerce Storefront', 'متجر إلكتروني', 'Software', '+64%', 'revenue', 'الإيرادات'],
            ['dressai-styling-platform', 'DressAI Styling Platform', 'منصّة DressAI', 'Software', '4.8/5', 'user rating', 'تقييم المستخدمين'],
            ['corporate-rebrand', 'Corporate Rebrand', 'إعادة هوية مؤسسية', 'Marketing', '+210%', 'brand recall', 'تذكّر العلامة'],
            ['booking-engine', 'Booking Engine', 'محرّك حجوزات', 'Software', '+88%', 'bookings', 'الحجوزات'],
            ['healthcare-imaging-portal', 'Healthcare Imaging Portal', 'بوّابة تصوير طبّي', 'Software', '−30%', 'review time', 'زمن المراجعة'],
            ['saas-admin-dashboard', 'SaaS Admin Dashboard', 'لوحة إدارة SaaS', 'Software', '3×', 'faster ops', 'عمليات أسرع'],
            ['photography-showcase', 'Photography Showcase', 'معرض تصوير', 'Video', '+95%', 'engagement', 'التفاعل'],
            ['creative-studio-reel', 'Creative Studio Reel', 'ريل استوديو إبداعي', 'Video', '2.1M', 'views', 'مشاهدات'],
            ['operations-dashboard', 'Operations Dashboard', 'لوحة العمليات', 'Software', '−40%', 'manual work', 'العمل اليدوي'],
            ['sales-pipeline-app', 'Sales Pipeline App', 'تطبيق مسار المبيعات', 'Software', '+57%', 'win rate', 'معدّل الفوز'],
            ['marketing-ops-platform', 'Marketing Ops Platform', 'منصّة عمليات التسويق', 'Marketing', '4.4×', 'ROAS', 'العائد الإعلاني'],
            ['crm-automation', 'CRM Automation', 'أتمتة CRM', 'Tech Solutions', '−60%', 'admin time', 'وقت الإدارة'],
            ['ai-visual-generator', 'AI Visual Generator', 'مولّد بصري بالذكاء', 'Software', '10×', 'output', 'الإنتاجية'],
            ['generative-design-tool', 'Generative Design Tool', 'أداة تصميم توليدي', 'Software', '+72%', 'iteration speed', 'سرعة التكرار'],
        ];
    }
}
