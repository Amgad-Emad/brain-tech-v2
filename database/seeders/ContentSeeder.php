<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\Value;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->services();
        $this->values();
        $this->steps();
        $this->stats();
        $this->projects();
        $this->testimonials();
        $this->faqs();
    }

    private function services(): void
    {
        $services = [
            [
                'icon_key' => 'software',
                'slug' => 'software-solutions',
                'title' => ['en' => 'Software Solutions', 'ar' => 'حلول برمجية'],
                'description' => ['en' => 'Custom web and mobile platforms architected for performance, security, and scale — from MVP to enterprise.', 'ar' => 'منصّات ويب وتطبيقات مخصّصة مصمّمة للأداء والأمان والتوسّع — من النموذج الأولي إلى المؤسسات.'],
                'tagline' => ['en' => 'Custom software, engineered to last.', 'ar' => 'برمجيات مخصّصة، مبنيّة لتدوم.'],
                'long_description' => ['en' => 'We design and build web and mobile applications that are fast, secure, and ready to scale — whether you are validating an MVP or modernizing an enterprise platform.', 'ar' => 'نصمّم ونبني تطبيقات ويب وجوال سريعة وآمنة وجاهزة للتوسّع — سواء كنت تتحقّق من نموذج أوّلي أو تحدّث منصّة مؤسسية.'],
                'deliverables' => [
                    ['en' => 'Web & mobile app development', 'ar' => 'تطوير تطبيقات الويب والجوال'],
                    ['en' => 'Product & UX design', 'ar' => 'تصميم المنتج وتجربة المستخدم'],
                    ['en' => 'API design & integrations', 'ar' => 'تصميم الواجهات والتكاملات'],
                    ['en' => 'Database & backend architecture', 'ar' => 'هندسة قواعد البيانات والخلفية'],
                    ['en' => 'QA, testing & launch support', 'ar' => 'الجودة والاختبار ودعم الإطلاق'],
                ],
            ],
            [
                'icon_key' => 'tech',
                'slug' => 'tech-solutions',
                'title' => ['en' => 'Tech Solutions', 'ar' => 'حلول تقنية'],
                'description' => ['en' => 'Cloud infrastructure, DevOps, integrations, and IT systems engineered to keep your business resilient.', 'ar' => 'بنية سحابية وDevOps وتكاملات وأنظمة تقنية مصمّمة لإبقاء أعمالك مرنة وموثوقة.'],
                'tagline' => ['en' => 'Infrastructure that stays up and scales costs down.', 'ar' => 'بنية تحتية تبقى تعمل وتخفّض التكاليف.'],
                'long_description' => ['en' => 'Cloud architecture, DevOps, and IT systems engineered for resilience, security, and predictable cost — with monitoring so you are never caught by surprise.', 'ar' => 'هندسة سحابية وDevOps وأنظمة تقنية مصمّمة للمرونة والأمان وتكلفة متوقّعة — مع مراقبة تجنّبك المفاجآت.'],
                'deliverables' => [
                    ['en' => 'Cloud architecture & migration', 'ar' => 'الهندسة السحابية والترحيل'],
                    ['en' => 'CI/CD & DevOps automation', 'ar' => 'أتمتة CI/CD وDevOps'],
                    ['en' => 'Security & compliance hardening', 'ar' => 'تعزيز الأمان والامتثال'],
                    ['en' => 'Monitoring & observability', 'ar' => 'المراقبة والرصد'],
                    ['en' => 'Ongoing maintenance & SLAs', 'ar' => 'الصيانة المستمرة واتفاقيات الخدمة'],
                ],
            ],
            [
                'icon_key' => 'marketing',
                'slug' => 'digital-marketing',
                'title' => ['en' => 'Digital Marketing', 'ar' => 'تسويق رقمي'],
                'description' => ['en' => 'Data-driven SEO, paid media, and content that compounds — growth you can attribute and trust.', 'ar' => 'تحسين لمحرّكات البحث وإعلانات مدفوعة ومحتوى قائم على البيانات — نموّ يمكنك قياسه والوثوق به.'],
                'tagline' => ['en' => 'Growth you can attribute and trust.', 'ar' => 'نموّ يمكنك عزوه والوثوق به.'],
                'long_description' => ['en' => 'Data-driven SEO, paid media, and content strategy that compounds over time — every dollar tracked against real business outcomes.', 'ar' => 'تحسين محرّكات بحث وإعلانات مدفوعة واستراتيجية محتوى قائمة على البيانات تتراكم مع الوقت — كل دولار يُقاس مقابل نتائج أعمال حقيقية.'],
                'deliverables' => [
                    ['en' => 'SEO & answer-engine optimization', 'ar' => 'تحسين محرّكات ومحرّكات الإجابة'],
                    ['en' => 'Paid search & social campaigns', 'ar' => 'حملات البحث والتواصل المدفوعة'],
                    ['en' => 'Content & email strategy', 'ar' => 'استراتيجية المحتوى والبريد'],
                    ['en' => 'Analytics & conversion tracking', 'ar' => 'التحليلات وتتبّع التحويلات'],
                    ['en' => 'Monthly reporting & insights', 'ar' => 'تقارير ورؤى شهرية'],
                ],
            ],
            [
                'icon_key' => 'video',
                'slug' => 'video-editing',
                'title' => ['en' => 'Video Editing', 'ar' => 'مونتاج فيديو'],
                'description' => ['en' => 'Professional editing, motion, and post-production that turn raw footage into brand-defining stories.', 'ar' => 'مونتاج احترافي وموشن جرافيك ومعالجة لاحقة تحوّل اللقطات الخام إلى قصص تُعرّف علامتك.'],
                'tagline' => ['en' => 'Stories that define your brand.', 'ar' => 'قصص تُعرّف علامتك.'],
                'long_description' => ['en' => 'Professional editing, motion design, and post-production that turn raw footage into content built to perform across every channel.', 'ar' => 'مونتاج احترافي وموشن جرافيك ومعالجة لاحقة تحوّل اللقطات الخام إلى محتوى مصمّم للأداء عبر كل القنوات.'],
                'deliverables' => [
                    ['en' => 'Video editing & post-production', 'ar' => 'المونتاج والمعالجة اللاحقة'],
                    ['en' => 'Motion graphics & animation', 'ar' => 'الموشن جرافيك والأنيميشن'],
                    ['en' => 'Short-form & social cuts', 'ar' => 'مقاطع قصيرة لمنصّات التواصل'],
                    ['en' => 'Color grading & sound', 'ar' => 'تصحيح الألوان والصوت'],
                    ['en' => 'Brand & promo videos', 'ar' => 'فيديوهات العلامة والترويج'],
                ],
            ],
        ];

        foreach ($services as $i => $data) {
            Service::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['sort_order' => $i, 'is_visible' => true]),
            );
        }
    }

    private function values(): void
    {
        $values = [
            ['icon_key' => 'expertise', 'title' => ['en' => 'Senior Expertise', 'ar' => 'خبرة متقدّمة'], 'description' => ['en' => 'Every engagement is led by senior specialists — no hand-offs to junior teams.', 'ar' => 'كل مشروع يقوده مختصّون كبار — دون تحويله لفرق أقل خبرة.']],
            ['icon_key' => 'speed', 'title' => ['en' => 'Speed to Ship', 'ar' => 'سرعة التسليم'], 'description' => ['en' => 'Tight feedback loops and weekly releases get you to value faster.', 'ar' => 'دورات مراجعة سريعة وإصدارات أسبوعية توصلك للقيمة أسرع.']],
            ['icon_key' => 'results', 'title' => ['en' => 'Measurable Results', 'ar' => 'نتائج قابلة للقياس'], 'description' => ['en' => 'We define success metrics up front and report against them, always.', 'ar' => 'نحدّد مؤشرات النجاح مسبقًا ونرفع تقاريرنا وفقها دائمًا.']],
            ['icon_key' => 'support', 'title' => ['en' => 'Always-On Support', 'ar' => 'دعم متواصل'], 'description' => ['en' => 'Dedicated channels and SLAs mean help is never more than a message away.', 'ar' => 'قنوات مخصّصة واتفاقيات مستوى خدمة تجعل الدعم على بُعد رسالة دائمًا.']],
        ];

        Value::query()->delete();
        foreach ($values as $i => $data) {
            Value::create(array_merge($data, ['sort_order' => $i]));
        }
    }

    private function steps(): void
    {
        $steps = [
            ['number' => '01', 'title' => ['en' => 'Discover', 'ar' => 'الاستكشاف'], 'description' => ['en' => 'We align on goals, audit constraints, and map the fastest path to impact.', 'ar' => 'نتّفق على الأهداف، ونحلّل القيود، ونرسم أسرع طريق للأثر.']],
            ['number' => '02', 'title' => ['en' => 'Design', 'ar' => 'التصميم'], 'description' => ['en' => 'Architecture, UX, and a clear plan — validated before a line is written.', 'ar' => 'البنية وتجربة المستخدم وخطة واضحة — نتحقّق منها قبل كتابة أي سطر.']],
            ['number' => '03', 'title' => ['en' => 'Build', 'ar' => 'التطوير'], 'description' => ['en' => 'Iterative delivery with weekly demos so you always see real progress.', 'ar' => 'تسليم تدريجي مع عروض أسبوعية لترى تقدّمًا حقيقيًا دائمًا.']],
            ['number' => '04', 'title' => ['en' => 'Scale', 'ar' => 'التوسّع'], 'description' => ['en' => 'We harden, optimize, and grow the solution alongside your business.', 'ar' => 'نُعزّز ونُحسّن ونوسّع الحل جنبًا إلى جنب مع نمو أعمالك.']],
        ];

        ProcessStep::query()->delete();
        foreach ($steps as $i => $data) {
            ProcessStep::create(array_merge($data, ['sort_order' => $i]));
        }
    }

    private function stats(): void
    {
        $stats = [
            ['key' => 'projects', 'value' => 480, 'suffix' => '+', 'label' => ['en' => 'Projects delivered', 'ar' => 'مشاريع منجزة']],
            ['key' => 'clients', 'value' => 160, 'suffix' => '+', 'label' => ['en' => 'Happy clients', 'ar' => 'عملاء سعداء']],
            ['key' => 'years', 'value' => 12, 'suffix' => '', 'label' => ['en' => 'Years in business', 'ar' => 'سنوات خبرة']],
            ['key' => 'satisfaction', 'value' => 99, 'suffix' => '%', 'label' => ['en' => 'Client satisfaction', 'ar' => 'رضا العملاء']],
        ];

        Stat::query()->delete();
        foreach ($stats as $i => $data) {
            Stat::create(array_merge($data, ['sort_order' => $i]));
        }
    }

    private function projects(): void
    {
        $projects = [
            [
                'slug' => 'fintech-onboarding',
                'image_path' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1100&q=80',
                'year' => '2025',
                'metric' => '+212%',
                'tag' => ['en' => 'Software', 'ar' => 'برمجيات'],
                'name' => ['en' => 'Fintech onboarding platform', 'ar' => 'منصّة تهيئة عملاء للتقنية المالية'],
                'metric_label' => ['en' => 'signup conversion', 'ar' => 'تحويل التسجيل'],
                'client' => ['en' => 'Northwind Financial', 'ar' => 'نورثويند للتمويل'],
                'alt' => ['en' => 'Analytics dashboard for a fintech onboarding platform', 'ar' => 'لوحة تحليلات لمنصّة تهيئة عملاء للتقنية المالية'],
                'summary' => ['en' => 'A regulated fintech needed an onboarding flow that converted without compromising on KYC compliance. We rebuilt it end to end.', 'ar' => 'احتاجت شركة تقنية مالية خاضعة للتنظيم تدفّق تهيئة يحقّق التحويل دون المساس بمتطلبات «اعرف عميلك». أعدنا بناءه بالكامل.'],
                'challenge' => ['en' => 'The legacy signup took 14 steps across two systems, leaking over half of applicants before completion and creating a compliance review backlog.', 'ar' => 'كان التسجيل القديم يتطلّب 14 خطوة عبر نظامين، ما تسبّب بفقدان أكثر من نصف المتقدّمين قبل الإكمال وتراكم مراجعات الامتثال.'],
                'approach' => ['en' => 'We mapped every drop-off, collapsed the flow to four smart steps, automated identity verification, and instrumented the funnel with real-time analytics.', 'ar' => 'رصدنا كل نقطة تسرّب، واختصرنا التدفّق إلى أربع خطوات ذكية، وأتمتنا التحقّق من الهوية، وزوّدنا المسار بتحليلات لحظية.'],
                'results' => [
                    ['metric' => '+212%', 'label' => ['en' => 'signup conversion', 'ar' => 'تحويل التسجيل']],
                    ['metric' => '−63%', 'label' => ['en' => 'time to approve', 'ar' => 'زمن الموافقة']],
                    ['metric' => '4.9/5', 'label' => ['en' => 'user rating', 'ar' => 'تقييم المستخدمين']],
                ],
                'services_used' => [
                    ['en' => 'Product Design', 'ar' => 'تصميم المنتج'],
                    ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
                    ['en' => 'API Integration', 'ar' => 'تكامل الواجهات'],
                ],
            ],
            [
                'slug' => 'cloud-migration',
                'image_path' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1100&q=80',
                'year' => '2024',
                'metric' => '−43%',
                'tag' => ['en' => 'Tech Solutions', 'ar' => 'حلول تقنية'],
                'name' => ['en' => 'Cloud migration & DevOps', 'ar' => 'ترحيل سحابي وDevOps'],
                'metric_label' => ['en' => 'infra cost', 'ar' => 'تكلفة البنية'],
                'client' => ['en' => 'Helio Logistics', 'ar' => 'هيليو للخدمات اللوجستية'],
                'alt' => ['en' => 'Data center servers representing cloud infrastructure', 'ar' => 'خوادم مركز بيانات تمثّل البنية السحابية'],
                'summary' => ['en' => 'A logistics platform was buckling under traffic spikes on aging on-prem servers. We migrated it to a resilient, auto-scaling cloud.', 'ar' => 'كانت منصّة لوجستية تنهار تحت ذُرى الزيارات على خوادم محلية قديمة. رحّلناها إلى سحابة مرنة ذاتية التوسّع.'],
                'challenge' => ['en' => 'Peak-season outages, manual deployments, and unpredictable infrastructure bills were holding the business back.', 'ar' => 'انقطاعات في مواسم الذروة، ونشر يدوي، وفواتير بنية غير متوقّعة كانت تعيق نمو الأعمال.'],
                'approach' => ['en' => 'We containerized the stack, built a CI/CD pipeline, introduced infrastructure-as-code, and set up auto-scaling with full observability.', 'ar' => 'حوّلنا النظام إلى حاويات، وبنينا خط CI/CD، واعتمدنا البنية ككود، وأعددنا توسّعًا تلقائيًا مع مراقبة كاملة.'],
                'results' => [
                    ['metric' => '−43%', 'label' => ['en' => 'infra cost', 'ar' => 'تكلفة البنية']],
                    ['metric' => '99.99%', 'label' => ['en' => 'uptime', 'ar' => 'زمن التشغيل']],
                    ['metric' => '12×', 'label' => ['en' => 'faster deploys', 'ar' => 'نشر أسرع']],
                ],
                'services_used' => [
                    ['en' => 'Cloud Architecture', 'ar' => 'هندسة سحابية'],
                    ['en' => 'DevOps', 'ar' => 'DevOps'],
                    ['en' => 'Monitoring', 'ar' => 'المراقبة'],
                ],
            ],
            [
                'slug' => 'growth-campaign',
                'image_path' => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=1100&q=80',
                'year' => '2025',
                'metric' => '4.8×',
                'tag' => ['en' => 'Marketing + Video', 'ar' => 'تسويق + فيديو'],
                'name' => ['en' => 'D2C growth campaign', 'ar' => 'حملة نمو للبيع المباشر'],
                'metric_label' => ['en' => 'return on ad spend', 'ar' => 'العائد على الإنفاق الإعلاني'],
                'client' => ['en' => 'Lumen Goods', 'ar' => 'لومن للمنتجات'],
                'alt' => ['en' => 'Video editor working at a multi-monitor editing workstation', 'ar' => 'محرّر فيديو يعمل على محطة مونتاج متعدّدة الشاشات'],
                'summary' => ['en' => 'A direct-to-consumer brand needed performance creative and a paid strategy that actually scaled profitably.', 'ar' => 'احتاجت علامة للبيع المباشر محتوى إعلانيًا فعّالًا واستراتيجية مدفوعة تتوسّع بربحية حقيقية.'],
                'challenge' => ['en' => 'Ad costs were rising while creative fatigue crushed returns; the in-house team lacked video and analytics firepower.', 'ar' => 'ارتفعت تكاليف الإعلان بينما أنهك تكرار المحتوى العوائد، وافتقر الفريق الداخلي لقدرات الفيديو والتحليلات.'],
                'approach' => ['en' => 'We produced a library of short-form video, restructured campaigns around audience signals, and ran weekly creative testing.', 'ar' => 'أنتجنا مكتبة من مقاطع الفيديو القصيرة، وأعدنا هيكلة الحملات حول إشارات الجمهور، وأجرينا اختبارات إبداعية أسبوعية.'],
                'results' => [
                    ['metric' => '4.8×', 'label' => ['en' => 'return on ad spend', 'ar' => 'العائد على الإنفاق']],
                    ['metric' => '+180%', 'label' => ['en' => 'revenue', 'ar' => 'الإيرادات']],
                    ['metric' => '−37%', 'label' => ['en' => 'cost per acquisition', 'ar' => 'تكلفة الاكتساب']],
                ],
                'services_used' => [
                    ['en' => 'Paid Media', 'ar' => 'إعلانات مدفوعة'],
                    ['en' => 'Video Production', 'ar' => 'إنتاج فيديو'],
                    ['en' => 'Analytics', 'ar' => 'تحليلات'],
                ],
            ],
        ];

        foreach ($projects as $i => $data) {
            Project::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['sort_order' => $i, 'is_visible' => true]),
            );
        }
    }

    private function testimonials(): void
    {
        $items = [
            ['initials' => 'SM', 'quote' => ['en' => 'Brain-Tech rebuilt our core platform in four months. It now handles 10x the load and our team finally trusts the codebase.', 'ar' => 'أعاد براين-تك بناء منصّتنا الأساسية خلال أربعة أشهر. تتحمّل الآن عشرة أضعاف الحمل وأصبح فريقنا يثق بالكود أخيرًا.'], 'name' => ['en' => 'Sara Mehta', 'ar' => 'سارة مهتا'], 'role' => ['en' => 'CTO, Northwind', 'ar' => 'المديرة التقنية، نورثويند']],
            ['initials' => 'DO', 'quote' => ['en' => 'They treated our growth targets like their own. The marketing and product teams worked as one — results spoke for themselves.', 'ar' => 'تعاملوا مع أهداف نمونا كأنها أهدافهم. عمل فريقا التسويق والمنتج كفريق واحد — والنتائج تتحدّث عن نفسها.'], 'name' => ['en' => 'David Olsen', 'ar' => 'ديفيد أولسن'], 'role' => ['en' => 'VP Growth, Helio', 'ar' => 'نائب رئيس النمو، هيليو']],
            ['initials' => 'PN', 'quote' => ['en' => 'The most accountable agency we have worked with. Clear communication, real senior talent, zero surprises on delivery.', 'ar' => 'أكثر وكالة تتحمّل المسؤولية تعاملنا معها. تواصل واضح وكفاءات حقيقية ولا مفاجآت في التسليم.'], 'name' => ['en' => 'Priya Nair', 'ar' => 'بريا ناير'], 'role' => ['en' => 'Founder, Quantix', 'ar' => 'مؤسِّسة، كوانتكس']],
            ['initials' => 'ML', 'quote' => ['en' => 'From infrastructure to brand video, they covered every gap our internal team had. A genuine end-to-end partner.', 'ar' => 'من البنية التحتية إلى فيديو العلامة، غطّوا كل ثغرة لدى فريقنا الداخلي. شريك متكامل بحق.'], 'name' => ['en' => 'Marcus Lee', 'ar' => 'ماركوس لي'], 'role' => ['en' => 'COO, Lumen', 'ar' => 'مدير العمليات، لومن']],
        ];

        Testimonial::query()->delete();
        foreach ($items as $i => $data) {
            Testimonial::create(array_merge($data, ['sort_order' => $i]));
        }
    }

    private function faqs(): void
    {
        $faqs = [
            ['q' => ['en' => 'What services does Brain-Tech offer?', 'ar' => 'ما الخدمات التي يقدّمها براين-تك؟'], 'a' => ['en' => 'Brain-Tech delivers four core services under one roof: custom software development (web and mobile applications), IT and technology solutions (cloud infrastructure, DevOps, and system integrations), digital marketing (SEO, paid media, and content strategy), and professional video editing and post-production. Because all four live in one team, projects that span disciplines move faster and stay coordinated.', 'ar' => 'يقدّم براين-تك أربع خدمات أساسية تحت سقف واحد: تطوير برمجيات مخصّصة (تطبيقات ويب وجوال)، وحلول تقنية ومعلوماتية (بنية سحابية وDevOps وتكاملات أنظمة)، وتسويق رقمي (تحسين محرّكات البحث والإعلانات المدفوعة واستراتيجية المحتوى)، ومونتاج فيديو احترافي ومعالجة لاحقة. ولأن الأربعة في فريق واحد، تتقدّم المشاريع المتعدّدة التخصصات أسرع وبتنسيق كامل.']],
            ['q' => ['en' => 'How much does a typical project cost?', 'ar' => 'كم تبلغ تكلفة المشروع عادةً؟'], 'a' => ['en' => 'Pricing depends on scope, complexity, and timeline. Most software projects start in the low five figures for a focused MVP and scale from there, while marketing and video engagements are commonly structured as monthly retainers. After a short discovery call we provide a fixed, itemized quote so there are no surprises.', 'ar' => 'تعتمد التكلفة على النطاق والتعقيد والجدول الزمني. تبدأ معظم مشاريع البرمجيات من خمسة أرقام منخفضة لنموذج أوّلي مركّز وتتوسّع من هناك، بينما تُنظَّم خدمات التسويق والفيديو غالبًا كاشتراكات شهرية. وبعد مكالمة استكشافية قصيرة نقدّم عرض سعر ثابتًا ومفصّلًا دون أي مفاجآت.']],
            ['q' => ['en' => 'How long does it take to build a custom application?', 'ar' => 'كم يستغرق بناء تطبيق مخصّص؟'], 'a' => ['en' => 'A focused MVP typically ships in 6 to 12 weeks, while larger enterprise platforms run 3 to 6 months or more. We work in weekly iterations with live demos, so you see working software early and can adjust priorities as the project progresses rather than waiting until the end.', 'ar' => 'يُسلَّم النموذج الأوّلي المركّز عادةً خلال 6 إلى 12 أسبوعًا، بينما تستغرق منصّات المؤسسات الأكبر من 3 إلى 6 أشهر أو أكثر. نعمل بدورات أسبوعية مع عروض حيّة، لترى برمجيات عاملة مبكرًا وتعدّل الأولويات أثناء التقدّم بدلًا من الانتظار حتى النهاية.']],
            ['q' => ['en' => 'Do you work with startups as well as enterprises?', 'ar' => 'هل تعملون مع الشركات الناشئة والمؤسسات الكبرى معًا؟'], 'a' => ['en' => 'Yes. We support early-stage startups validating their first product and established enterprises modernizing legacy systems. Our process scales to the engagement: lean and fast for startups, with the documentation, security, and compliance rigor that larger organizations require.', 'ar' => 'نعم. ندعم الشركات الناشئة في مراحلها المبكرة للتحقّق من منتجها الأول، والمؤسسات الراسخة في تحديث أنظمتها القديمة. تتكيّف منهجيتنا مع المشروع: رشيقة وسريعة للناشئة، مع التوثيق والأمان والامتثال الذي تتطلّبه المؤسسات الأكبر.']],
            ['q' => ['en' => 'What happens after a project launches?', 'ar' => 'ماذا يحدث بعد إطلاق المشروع؟'], 'a' => ['en' => 'Launch is the beginning, not the end. Every engagement includes a support and maintenance plan with dedicated communication channels, defined response-time SLAs, monitoring, and ongoing optimization. We can also operate as your long-term technology partner, scaling the solution as your business grows.', 'ar' => 'الإطلاق هو البداية لا النهاية. يشمل كل مشروع خطة دعم وصيانة بقنوات تواصل مخصّصة، واتفاقيات مستوى خدمة لزمن الاستجابة، ومراقبة، وتحسين مستمر. ويمكننا أيضًا العمل كشريكك التقني طويل المدى، نوسّع الحل مع نمو أعمالك.']],
            ['q' => ['en' => 'How do we get started?', 'ar' => 'كيف نبدأ؟'], 'a' => ['en' => 'Click "Get a Quote" or email hello@brain-tech.com with a short description of your goals. We respond within one business day to schedule a discovery call, and you receive a clear proposal with scope, timeline, and pricing within a few days of that conversation.', 'ar' => 'انقر «اطلب عرض سعر» أو راسلنا على hello@brain-tech.com بوصف موجز لأهدافك. نردّ خلال يوم عمل واحد لتحديد موعد مكالمة استكشافية، وتستلم عرضًا واضحًا يتضمّن النطاق والجدول الزمني والتسعير خلال أيام قليلة من تلك المكالمة.']],
        ];

        Faq::query()->delete();
        foreach ($faqs as $i => $data) {
            Faq::create([
                'question' => $data['q'],
                'answer' => $data['a'],
                'sort_order' => $i,
            ]);
        }
    }
}
