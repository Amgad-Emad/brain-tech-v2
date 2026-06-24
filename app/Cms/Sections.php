<?php

namespace App\Cms;

use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Value;

/**
 * Declarative schema for the CMS section editors. Each section may edit
 * site settings (key/value, often translatable) and/or a collection of
 * model rows. Field types: text | area | mono (non-translatable) | bool.
 */
class Sections
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'nav' => [
                'group' => 'global', 'icon' => 'menu', 'hideable' => false,
                'label' => ['en' => 'Navigation', 'ar' => 'القائمة'],
                'desc' => ['en' => 'Header menu links and the quote button.', 'ar' => 'روابط القائمة وزر العرض.'],
                'settings' => [
                    ['nav.home', 'text', 'Home link'],
                    ['nav.services', 'text', 'Services link'],
                    ['nav.work', 'text', 'Work link'],
                    ['nav.process', 'text', 'Process link'],
                    ['nav.about', 'text', 'About link'],
                    ['nav.contact', 'text', 'Contact link'],
                    ['nav.quote', 'text', 'Quote button'],
                ],
            ],
            'seo' => [
                'group' => 'global', 'icon' => 'search', 'hideable' => false,
                'label' => ['en' => 'SEO & Meta', 'ar' => 'تحسين محركات البحث'],
                'desc' => ['en' => 'Search-engine title and description for each page. Keep titles ~60 chars, descriptions ~160.', 'ar' => 'عنوان ووصف كل صفحة في محركات البحث.'],
                'settings' => [
                    ['seo.home_title', 'text', 'Home — title'],
                    ['seo.home_description', 'area', 'Home — description'],
                    ['seo.about_title', 'text', 'About — title'],
                    ['seo.about_description', 'area', 'About — description'],
                    ['seo.services_title', 'text', 'Services — title'],
                    ['seo.services_description', 'area', 'Services — description'],
                    ['seo.work_title', 'text', 'Work — title'],
                    ['seo.work_description', 'area', 'Work — description'],
                    ['seo.contact_title', 'text', 'Contact — title'],
                    ['seo.contact_description', 'area', 'Contact — description'],
                ],
            ],
            'hero' => [
                'group' => 'home', 'icon' => 'star', 'hideable' => true,
                'label' => ['en' => 'Hero', 'ar' => 'الواجهة'],
                'desc' => ['en' => 'The first thing visitors see — headline, subtext, and buttons.', 'ar' => 'أول ما يراه الزائر — العنوان والنص والأزرار.'],
                'settings' => [
                    ['hero.badge', 'text', 'Badge'],
                    ['hero.h1pre', 'text', 'Headline — start'],
                    ['hero.h1hi', 'text', 'Headline — highlight'],
                    ['hero.h1post', 'text', 'Headline — end'],
                    ['hero.sub', 'area', 'Subtext'],
                    ['hero.cta1', 'text', 'Primary button'],
                    ['hero.cta2', 'text', 'Secondary button'],
                ],
            ],
            'trust' => [
                'group' => 'home', 'icon' => 'shield', 'hideable' => true,
                'label' => ['en' => 'Trust bar', 'ar' => 'شريط الثقة'],
                'desc' => ['en' => 'The "trusted by" line and client logo names.', 'ar' => 'سطر «موثوق من» وأسماء الشعارات.'],
                'settings' => [
                    ['trust.label', 'text', 'Heading'],
                    ['trust.logos', 'mono', 'Logo names (comma separated)'],
                ],
            ],
            'services' => [
                'group' => 'home', 'icon' => 'grid', 'hideable' => true,
                'label' => ['en' => 'Services section', 'ar' => 'قسم الخدمات'],
                'desc' => ['en' => 'Section heading and the service cards.', 'ar' => 'عنوان القسم وبطاقات الخدمات.'],
                'settings' => [
                    ['services.eyebrow', 'text', 'Eyebrow'],
                    ['services.title', 'text', 'Title'],
                    ['services.sub', 'area', 'Subtext'],
                    ['services.learn', 'text', '"Learn more" link'],
                ],
                'collection' => [
                    'model' => Service::class, 'label' => 'Service cards', 'dynamic' => false,
                    'fields' => [['title', 'text', 'Title'], ['description', 'area', 'Description']],
                ],
            ],
            'values' => [
                'group' => 'home', 'icon' => 'spark', 'hideable' => true,
                'label' => ['en' => 'Why us', 'ar' => 'لماذا نحن'],
                'desc' => ['en' => 'The value proposition cards.', 'ar' => 'بطاقات القيمة المضافة.'],
                'settings' => [
                    ['values.eyebrow', 'text', 'Eyebrow'],
                    ['values.title', 'text', 'Title'],
                ],
                'collection' => [
                    'model' => Value::class, 'label' => 'Value cards', 'dynamic' => false,
                    'fields' => [['title', 'text', 'Title'], ['description', 'area', 'Description']],
                ],
            ],
            'process' => [
                'group' => 'home', 'icon' => 'route', 'hideable' => true,
                'label' => ['en' => 'Process', 'ar' => 'المنهجية'],
                'desc' => ['en' => 'The step-by-step timeline.', 'ar' => 'الخط الزمني للخطوات.'],
                'settings' => [
                    ['process.eyebrow', 'text', 'Eyebrow'],
                    ['process.title', 'text', 'Title'],
                ],
                'collection' => [
                    'model' => ProcessStep::class, 'label' => 'Steps', 'dynamic' => true,
                    'fields' => [['number', 'mono', 'Number'], ['title', 'text', 'Title'], ['description', 'area', 'Description']],
                ],
            ],
            'work' => [
                'group' => 'home', 'icon' => 'folder', 'hideable' => true,
                'label' => ['en' => 'Portfolio', 'ar' => 'الأعمال'],
                'desc' => ['en' => 'Section heading and case-study cards. Manage full case studies under Collections.', 'ar' => 'عنوان القسم وبطاقات دراسات الحالة.'],
                'settings' => [
                    ['work.eyebrow', 'text', 'Eyebrow'],
                    ['work.title', 'text', 'Title'],
                    ['work.start', 'text', 'Link label'],
                ],
                'collection' => [
                    'model' => Project::class, 'label' => 'Project cards', 'dynamic' => false,
                    'fields' => [['name', 'text', 'Name'], ['tag', 'text', 'Category'], ['metric', 'mono', 'Metric'], ['metric_label', 'text', 'Metric label']],
                ],
            ],
            'stats' => [
                'group' => 'home', 'icon' => 'chart', 'hideable' => true,
                'label' => ['en' => 'Stats band', 'ar' => 'شريط الأرقام'],
                'desc' => ['en' => 'The animated counters.', 'ar' => 'العدّادات المتحرّكة.'],
                'collection' => [
                    'model' => Stat::class, 'label' => 'Counters', 'dynamic' => true,
                    'fields' => [['value', 'mono', 'Number'], ['suffix', 'mono', 'Suffix'], ['label', 'text', 'Label']],
                ],
            ],
            'testimonials' => [
                'group' => 'home', 'icon' => 'quote', 'hideable' => true,
                'label' => ['en' => 'Testimonials', 'ar' => 'الشهادات'],
                'desc' => ['en' => 'Customer quotes in the slider. Avatar initials are generated automatically.', 'ar' => 'اقتباسات العملاء في العارض.'],
                'settings' => [
                    ['testimonials.eyebrow', 'text', 'Eyebrow'],
                    ['testimonials.title', 'text', 'Title'],
                ],
                'collection' => [
                    'model' => Testimonial::class, 'label' => 'Testimonials', 'dynamic' => true,
                    'fields' => [['quote', 'area', 'Quote'], ['name', 'text', 'Name'], ['role', 'text', 'Role']],
                ],
            ],
            'faq' => [
                'group' => 'home', 'icon' => 'help', 'hideable' => true,
                'label' => ['en' => 'FAQ', 'ar' => 'الأسئلة الشائعة'],
                'desc' => ['en' => 'Questions and answers (also power search/answer engines).', 'ar' => 'الأسئلة والأجوبة.'],
                'settings' => [
                    ['faq.eyebrow', 'text', 'Eyebrow'],
                    ['faq.title', 'text', 'Title'],
                ],
                'collection' => [
                    'model' => Faq::class, 'label' => 'Questions', 'dynamic' => true,
                    'fields' => [['question', 'text', 'Question'], ['answer', 'area', 'Answer']],
                ],
            ],
            'cta' => [
                'group' => 'home', 'icon' => 'flag', 'hideable' => true,
                'label' => ['en' => 'Final CTA', 'ar' => 'الدعوة النهائية'],
                'desc' => ['en' => 'The closing call-to-action band.', 'ar' => 'شريط الدعوة الختامي.'],
                'settings' => [
                    ['cta.title', 'text', 'Title'],
                    ['cta.sub', 'area', 'Subtext'],
                    ['cta.btn', 'text', 'Button'],
                ],
            ],
            'about' => [
                'group' => 'pages', 'icon' => 'info', 'hideable' => false,
                'label' => ['en' => 'About page', 'ar' => 'صفحة من نحن'],
                'desc' => ['en' => 'All copy on the About page.', 'ar' => 'كل نصوص صفحة من نحن.'],
                'settings' => [
                    ['about.eyebrow', 'text', 'Eyebrow'],
                    ['about.title', 'text', 'Title'],
                    ['about.lead', 'area', 'Lead paragraph'],
                    ['about.story_title', 'text', 'Story heading'],
                    ['about.story1', 'area', 'Story paragraph 1'],
                    ['about.story2', 'area', 'Story paragraph 2'],
                    ['about.mission_title', 'text', 'Mission heading'],
                    ['about.mission', 'area', 'Mission text'],
                    ['about.values_title', 'text', 'Values heading'],
                    ['about.stats_title', 'text', 'Stats heading'],
                ],
            ],
            'servicespage' => [
                'group' => 'pages', 'icon' => 'layers', 'hideable' => false,
                'label' => ['en' => 'Services page', 'ar' => 'صفحة الخدمات'],
                'desc' => ['en' => 'Heading and the detailed description for each service.', 'ar' => 'العنوان والوصف المفصّل لكل خدمة.'],
                'settings' => [
                    ['services_page.eyebrow', 'text', 'Eyebrow'],
                    ['services_page.title', 'text', 'Title'],
                    ['services_page.lead', 'area', 'Lead'],
                ],
                'collection' => [
                    'model' => Service::class, 'label' => 'Service details', 'dynamic' => false,
                    'fields' => [['tagline', 'text', 'Tagline'], ['long_description', 'area', 'Long description']],
                ],
            ],
            'contact' => [
                'group' => 'pages', 'icon' => 'mail', 'hideable' => false,
                'label' => ['en' => 'Contact page', 'ar' => 'صفحة التواصل'],
                'desc' => ['en' => 'Contact copy and details.', 'ar' => 'نصوص وبيانات التواصل.'],
                'settings' => [
                    ['contact.eyebrow', 'text', 'Eyebrow'],
                    ['contact.title', 'text', 'Title'],
                    ['contact.lead', 'area', 'Lead'],
                    ['contact.response_title', 'text', 'Response heading'],
                    ['contact.response_text', 'area', 'Response text'],
                    ['contact.email', 'mono', 'Contact email'],
                    ['contact.phone', 'mono', 'Contact phone'],
                    ['contact.office', 'text', 'Office address'],
                    ['contact.hours', 'text', 'Working hours'],
                    ['contact.whatsapp', 'mono', 'WhatsApp number'],
                ],
            ],
            'offers' => [
                'group' => 'pages', 'icon' => 'tag', 'hideable' => false,
                'label' => ['en' => 'Offers & Promotions', 'ar' => 'العروض والتخفيضات'],
                'desc' => ['en' => 'Add a promotional offer to any service. Toggle it on and fill the title to show it.', 'ar' => 'أضف عرضًا ترويجيًا لأي خدمة.'],
                'collection' => [
                    'model' => Service::class, 'label' => 'Offers per service', 'dynamic' => false,
                    'fields' => [
                        ['offer_enabled', 'bool', 'Show offer'],
                        ['offer_label', 'text', 'Badge label'],
                        ['offer_title', 'text', 'Offer title'],
                        ['offer_text', 'area', 'Offer details'],
                        ['offer_until', 'text', 'Valid until'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(string $id): ?array
    {
        $section = self::all()[$id] ?? null;

        return $section ? ['id' => $id, ...$section] : null;
    }

    /**
     * Sidebar groups in display order.
     *
     * @return array<string, array<int, string>>
     */
    public static function groups(): array
    {
        $groups = ['global' => [], 'home' => [], 'pages' => []];

        foreach (self::all() as $id => $section) {
            $groups[$section['group']][] = $id;
        }

        return $groups;
    }
}
