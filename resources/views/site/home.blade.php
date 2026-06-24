@extends('layouts.site')

@if ($faqs->isNotEmpty())
    @php
        $faqLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $faqs->map(fn ($faq) => [
                '@type' => 'Question',
                'name' => $faq->t('question'),
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq->t('answer')],
            ])->all(),
        ];
    @endphp
    @push('structured-data')
        <script type="application/ld+json">@json($faqLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    @endpush
@endif

@section('content')
    @if (st('visibility.hero', true))
        @include('site.sections.hero')
    @endif

    @if (st('visibility.trust', true))
        @include('site.sections.trust')
    @endif

    @if (st('visibility.services', true) && $services->isNotEmpty())
        @include('site.sections.services')
    @endif

    @if (st('visibility.values', true) && $values->isNotEmpty())
        @include('site.sections.values')
    @endif

    @if (st('visibility.process', true) && $steps->isNotEmpty())
        @include('site.sections.process')
    @endif

    @if (st('visibility.work', true) && $projects->isNotEmpty())
        @include('site.sections.work')
    @endif

    @if (st('visibility.stats', true) && $stats->isNotEmpty())
        @include('site.sections.stats')
    @endif

    @if (st('visibility.testimonials', true) && $testimonials->isNotEmpty())
        @include('site.sections.testimonials')
    @endif

    @if (st('visibility.faq', true) && $faqs->isNotEmpty())
        @include('site.sections.faq')
    @endif

    @if (st('visibility.cta', true))
        @include('site.sections.cta')
    @endif
@endsection
