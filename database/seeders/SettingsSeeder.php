<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // --- Navigation --------------------------------------------------
        $this->put('nav.home', ['en' => 'Home', 'ar' => 'الرئيسية'], 'nav', true);
        $this->put('nav.services', ['en' => 'Services', 'ar' => 'خدماتنا'], 'nav', true);
        $this->put('nav.work', ['en' => 'Work', 'ar' => 'أعمالنا'], 'nav', true);
        $this->put('nav.process', ['en' => 'Process', 'ar' => 'منهجيتنا'], 'nav', true);
        $this->put('nav.about', ['en' => 'About', 'ar' => 'من نحن'], 'nav', true);
        $this->put('nav.contact', ['en' => 'Contact', 'ar' => 'تواصل'], 'nav', true);
        $this->put('nav.quote', ['en' => 'Get a Quote', 'ar' => 'اطلب عرض سعر'], 'nav', true);

        // --- Brand -------------------------------------------------------
        $this->put('brand.name', 'Brain-Tech', 'brand');
        $this->put('brand.tagline', [
            'en' => 'Your end-to-end technology partner for software, infrastructure, marketing, and video.',
            'ar' => 'شريكك التقني المتكامل في البرمجيات والبنية التحتية والتسويق والفيديو.',
        ], 'brand', true);

        // --- Hero --------------------------------------------------------
        $this->put('hero.badge', ['en' => 'Now booking projects for Q3 2026', 'ar' => 'نستقبل الآن مشاريع الربع الثالث 2026'], 'hero', true);
        $this->put('hero.h1pre', ['en' => 'Engineering ambitious ideas into ', 'ar' => 'نحوّل الأفكار الطموحة إلى '], 'hero', true);
        $this->put('hero.h1hi', ['en' => 'enterprise-grade', 'ar' => 'منتجات بمستوى المؤسسات'], 'hero', true);
        $this->put('hero.h1post', ['en' => ' products.', 'ar' => '.'], 'hero', true);
        $this->put('hero.sub', ['en' => 'Brain-Tech is the technology partner behind high-performing software, infrastructure, marketing, and video. One team, end to end, built for scale.', 'ar' => 'براين-تك هو شريكك التقني وراء البرمجيات والبنية التحتية والتسويق والفيديو عالي الأداء. فريق واحد، من البداية إلى النهاية، مبني للتوسّع.'], 'hero', true);
        $this->put('hero.cta1', ['en' => 'Start a Project', 'ar' => 'ابدأ مشروعك'], 'hero', true);
        $this->put('hero.cta2', ['en' => 'See Our Work', 'ar' => 'شاهد أعمالنا'], 'hero', true);

        // --- Section eyebrows / titles ----------------------------------
        $this->put('trust.label', ['en' => 'The technologies we build with', 'ar' => 'التقنيات التي نبني بها'], 'sections', true);

        $this->put('services.eyebrow', ['en' => 'What we do', 'ar' => 'ماذا نقدّم'], 'sections', true);
        $this->put('services.title', ['en' => 'Four disciplines, one accountable team.', 'ar' => 'أربعة تخصصات، وفريق واحد مسؤول.'], 'sections', true);
        $this->put('services.sub', ['en' => 'From the first line of code to the final cut, we own the outcomes that move your business forward.', 'ar' => 'من أول سطر برمجي إلى اللقطة الأخيرة، نتحمّل مسؤولية النتائج التي تدفع أعمالك للأمام.'], 'sections', true);
        $this->put('services.learn', ['en' => 'Learn more', 'ar' => 'اعرف المزيد'], 'sections', true);

        $this->put('values.eyebrow', ['en' => 'Why Brain-Tech', 'ar' => 'لماذا براين-تك'], 'sections', true);
        $this->put('values.title', ['en' => "Built for teams that can't afford to get it wrong.", 'ar' => 'مبنيّ لفرق لا تحتمل الخطأ.'], 'sections', true);

        $this->put('process.eyebrow', ['en' => 'How we work', 'ar' => 'كيف نعمل'], 'sections', true);
        $this->put('process.title', ['en' => 'A proven path from idea to scale.', 'ar' => 'مسار مُثبت من الفكرة إلى التوسّع.'], 'sections', true);

        $this->put('work.eyebrow', ['en' => 'Selected work', 'ar' => 'أعمال مختارة'], 'sections', true);
        $this->put('work.title', ['en' => 'Outcomes our clients can measure.', 'ar' => 'نتائج يستطيع عملاؤنا قياسها.'], 'sections', true);
        $this->put('work.start', ['en' => 'Start yours', 'ar' => 'ابدأ مشروعك'], 'sections', true);

        $this->put('testimonials.eyebrow', ['en' => 'What clients say', 'ar' => 'ماذا يقول عملاؤنا'], 'sections', true);
        $this->put('testimonials.title', ['en' => 'Partners, not vendors.', 'ar' => 'شركاء، لا مجرّد موردين.'], 'sections', true);

        $this->put('faq.eyebrow', ['en' => 'Answers', 'ar' => 'إجابات'], 'sections', true);
        $this->put('faq.title', ['en' => 'Frequently asked questions.', 'ar' => 'الأسئلة الشائعة.'], 'sections', true);

        $this->put('cta.title', ['en' => "Let's build something worth scaling.", 'ar' => 'لنبنِ شيئًا يستحقّ التوسّع.'], 'sections', true);
        $this->put('cta.sub', ['en' => "Tell us about your project and we'll come back within one business day with a clear path forward.", 'ar' => 'أخبرنا عن مشروعك وسنعود إليك خلال يوم عمل واحد بمسار واضح للمضيّ قدمًا.'], 'sections', true);
        $this->put('cta.btn', ['en' => 'Get a Quote', 'ar' => 'اطلب عرض سعر'], 'sections', true);

        // --- About page --------------------------------------------------
        $this->put('about.eyebrow', ['en' => 'About Brain-Tech', 'ar' => 'عن براين-تك'], 'about', true);
        $this->put('about.title', ['en' => 'A technology partner built for outcomes.', 'ar' => 'شريك تقني مبنيّ لتحقيق النتائج.'], 'about', true);
        $this->put('about.lead', ['en' => 'We are a team of senior engineers, strategists, and creatives who treat your goals as our own — delivering software, infrastructure, marketing, and video under one roof.', 'ar' => 'نحن فريق من المهندسين والاستراتيجيين والمبدعين الكبار نعتبر أهدافك أهدافنا — نقدّم البرمجيات والبنية التحتية والتسويق والفيديو تحت سقف واحد.'], 'about', true);
        $this->put('about.story_title', ['en' => 'Our story', 'ar' => 'قصّتنا'], 'about', true);
        $this->put('about.story1', ['en' => 'Brain-Tech began with a simple frustration: businesses were forced to stitch together agencies and freelancers, losing time and accountability in the gaps. We built one team that owns the entire journey — from the first line of code to the final published frame.', 'ar' => 'بدأ براين-تك من إحباط بسيط: كانت الشركات مضطرّة لربط وكالات ومستقلّين، فتخسر الوقت والمسؤولية في الفجوات بينهم. فبنينا فريقًا واحدًا يملك الرحلة كاملة — من أول سطر برمجي إلى آخر لقطة منشورة.'], 'about', true);
        $this->put('about.story2', ['en' => 'Today we partner with startups and enterprises across four disciplines, holding ourselves to measurable outcomes and shipping in weekly iterations. No hand-offs, no finger-pointing — just one accountable team.', 'ar' => 'واليوم نعمل مع الشركات الناشئة والمؤسسات عبر أربعة تخصصات، ملتزمين بنتائج قابلة للقياس ونُسلّم بدورات أسبوعية. لا تحويلات ولا تبادل لوم — فريق واحد مسؤول فقط.'], 'about', true);
        $this->put('about.mission_title', ['en' => 'Our mission', 'ar' => 'مهمّتنا'], 'about', true);
        $this->put('about.mission', ['en' => 'To be the most accountable technology partner our clients have ever worked with — turning ambitious ideas into products and growth that can be measured.', 'ar' => 'أن نكون الشريك التقني الأكثر مسؤولية الذي تعامل معه عملاؤنا — نحوّل الأفكار الطموحة إلى منتجات ونموّ يمكن قياسه.'], 'about', true);
        $this->put('about.values_title', ['en' => 'What we stand for', 'ar' => 'ما نؤمن به'], 'about', true);
        $this->put('about.stats_title', ['en' => 'By the numbers', 'ar' => 'بالأرقام'], 'about', true);

        // --- Services page ----------------------------------------------
        $this->put('services_page.eyebrow', ['en' => 'Our services', 'ar' => 'خدماتنا'], 'services_page', true);
        $this->put('services_page.title', ['en' => 'Everything you need to build, launch, and grow.', 'ar' => 'كل ما تحتاجه للبناء والإطلاق والنمو.'], 'services_page', true);
        $this->put('services_page.lead', ['en' => 'Four core disciplines, delivered by one senior team and designed to work together.', 'ar' => 'أربعة تخصصات أساسية، يقدّمها فريق واحد متمرّس ومصمّمة لتعمل معًا.'], 'services_page', true);

        // --- Contact page ------------------------------------------------
        $this->put('contact.eyebrow', ['en' => 'Contact us', 'ar' => 'تواصل معنا'], 'contact', true);
        $this->put('contact.title', ['en' => "Let's talk about your project.", 'ar' => 'لنتحدّث عن مشروعك.'], 'contact', true);
        $this->put('contact.lead', ['en' => 'Tell us what you are building and we will respond within one business day with clear next steps.', 'ar' => 'أخبرنا بما تبنيه وسنردّ خلال يوم عمل واحد بخطوات تالية واضحة.'], 'contact', true);
        $this->put('contact.response_title', ['en' => 'Fast, honest answers', 'ar' => 'إجابات سريعة وصادقة'], 'contact', true);
        $this->put('contact.response_text', ['en' => 'We reply to every inquiry within one business day. No bots, no runaround — a senior team member reads your message and responds personally.', 'ar' => 'نردّ على كل استفسار خلال يوم عمل واحد. لا روبوتات ولا تعقيد — يقرأ رسالتك عضو متمرّس من الفريق ويردّ شخصيًا.'], 'contact', true);

        // --- Contact details --------------------------------------------
        $this->put('contact.email', 'hello@brain-tech.com', 'contact');
        $this->put('contact.phone', '+1 (415) 555-0148', 'contact');
        $this->put('contact.office', ['en' => '548 Market Street, San Francisco, CA', 'ar' => '548 شارع ماركت، سان فرانسيسكو، كاليفورنيا'], 'contact', true);
        $this->put('contact.hours', ['en' => 'Mon–Fri · 9am–6pm PT', 'ar' => 'الإثنين–الجمعة · 9ص–6م بتوقيت المحيط الهادئ'], 'contact', true);
        $this->put('contact.whatsapp', '+14155550148', 'contact');

        // --- Footer ------------------------------------------------------
        $this->put('footer.newsletter_p', ['en' => "Occasional notes on what we're building. No noise.", 'ar' => 'رسائل عرضية عمّا نبنيه. دون إزعاج.'], 'footer', true);
        $this->put('footer.rights', ['en' => '© 2026 Brain-Tech. All rights reserved.', 'ar' => '© 2026 براين-تك. جميع الحقوق محفوظة.'], 'footer', true);

        // --- Socials -----------------------------------------------------
        $this->put('social.items', [
            ['label' => 'Brain-Tech on X', 'short' => 'X', 'url' => '#'],
            ['label' => 'Brain-Tech on LinkedIn', 'short' => 'in', 'url' => '#'],
            ['label' => 'Brain-Tech on GitHub', 'short' => 'GH', 'url' => '#'],
        ], 'social');

        // --- Theme colors -----------------------------------------------
        $this->put('theme.accent', '#34e0a0', 'theme');
        $this->put('theme.grad_from', '#0ddc83', 'theme');
        $this->put('theme.grad_to', '#16e89a', 'theme');
        $this->put('theme.ink', '#34e0a0', 'theme');

        // --- Section visibility -----------------------------------------
        foreach (['hero', 'trust', 'services', 'values', 'process', 'work', 'stats', 'testimonials', 'faq', 'cta', 'whatsapp'] as $section) {
            $this->put("visibility.$section", $section !== 'whatsapp', 'visibility');
        }

        // --- SEO meta ----------------------------------------------------
        $this->put('seo.home_title', ['en' => 'Brain-Tech — Custom Software, IT, Marketing & Video Editing Agency', 'ar' => 'براين-تك — وكالة برمجيات وتقنية وتسويق ومونتاج فيديو'], 'seo', true);
        $this->put('seo.home_description', ['en' => 'Enterprise-grade technology agency: custom software development, IT & cloud solutions, digital marketing, and professional video editing. One accountable team, end to end.', 'ar' => 'وكالة تقنية بمستوى المؤسسات: تطوير برمجيات مخصّصة، وحلول تقنية وسحابية، وتسويق رقمي، ومونتاج فيديو احترافي. فريق واحد مسؤول من البداية إلى النهاية.'], 'seo', true);
        $this->put('seo.about_title', ['en' => 'About Brain-Tech — Our Story, Mission & Senior Team', 'ar' => 'عن براين-تك — قصّتنا ومهمّتنا وفريقنا المتمرّس'], 'seo', true);
        $this->put('seo.about_description', ['en' => 'Brain-Tech is a senior team delivering software, infrastructure, marketing, and video under one roof. Learn our story, mission, and the values we hold ourselves to.', 'ar' => 'براين-تك فريق متمرّس يقدّم البرمجيات والبنية التحتية والتسويق والفيديو تحت سقف واحد. تعرّف على قصّتنا ومهمّتنا وقيمنا.'], 'seo', true);
        $this->put('seo.services_title', ['en' => 'Services — Software, IT, Digital Marketing & Video | Brain-Tech', 'ar' => 'خدماتنا — برمجيات وتقنية وتسويق رقمي وفيديو | براين-تك'], 'seo', true);
        $this->put('seo.services_description', ['en' => 'Explore Brain-Tech services: custom software development, IT & cloud solutions, digital marketing, and professional video editing — each with clear, measurable deliverables.', 'ar' => 'اكتشف خدمات براين-تك: تطوير برمجيات مخصّصة، وحلول تقنية وسحابية، وتسويق رقمي، ومونتاج فيديو احترافي — كلٌّ بمخرجات واضحة وقابلة للقياس.'], 'seo', true);
        $this->put('seo.work_title', ['en' => 'Our Work — Case Studies & Measurable Outcomes | Brain-Tech', 'ar' => 'أعمالنا — دراسات حالة ونتائج قابلة للقياس | براين-تك'], 'seo', true);
        $this->put('seo.work_description', ['en' => 'Selected Brain-Tech projects across software, cloud, marketing, and video — with the measurable outcomes our clients can point to.', 'ar' => 'مشاريع مختارة من براين-تك في البرمجيات والسحابة والتسويق والفيديو — بنتائج قابلة للقياس يفخر بها عملاؤنا.'], 'seo', true);
        $this->put('seo.contact_title', ['en' => 'Contact Brain-Tech — Start Your Project Today', 'ar' => 'تواصل مع براين-تك — ابدأ مشروعك اليوم'], 'seo', true);
        $this->put('seo.contact_description', ['en' => 'Get in touch with Brain-Tech. Tell us about your project and a senior team member responds within one business day. Email hello@brain-tech.com or call +1 (415) 555-0148.', 'ar' => 'تواصل مع براين-تك. أخبرنا عن مشروعك وسيردّ عضو متمرّس خلال يوم عمل واحد. راسلنا على hello@brain-tech.com أو اتصل على ‎+1 (415) 555-0148.'], 'seo', true);
    }

    private function put(string $key, mixed $value, string $group, bool $translatable = false): void
    {
        Setting::put($key, $value, $group, $translatable);
    }
}
