@props(['name' => 'arrow', 'size' => 24, 'stroke' => 1.7])

<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
     {{ $attributes }}>
    @switch($name)
        @case('software')
            <polyline points="8 7 4 12 8 17" /><polyline points="16 7 20 12 16 17" />
            @break
        @case('tech')
            <rect x="4" y="4" width="16" height="5" rx="1.5" /><rect x="4" y="11" width="16" height="5" rx="1.5" />
            <circle cx="7.5" cy="6.5" r="0.7" fill="currentColor" stroke="none" /><circle cx="7.5" cy="13.5" r="0.7" fill="currentColor" stroke="none" />
            @break
        @case('marketing')
            <line x1="4" y1="19" x2="20" y2="19" /><rect x="6" y="12" width="3" height="4" /><rect x="11" y="7" width="3" height="9" /><rect x="16" y="14" width="3" height="2" />
            @break
        @case('video')
            <rect x="4" y="6" width="16" height="12" rx="2" /><polygon points="11 10 15 12 11 14" fill="currentColor" stroke="none" />
            @break
        @case('expertise')
            <polygon points="12 4 20 12 12 20 4 12" />
            @break
        @case('speed')
            <polygon points="13 3 5 14 11 14 11 21 19 10 13 10 13 3" />
            @break
        @case('results')
            <circle cx="12" cy="12" r="8" /><polyline points="9 12 11 14 15 9" />
            @break
        @case('support')
            <circle cx="12" cy="12" r="8" /><circle cx="12" cy="12" r="3" />
            @break
        @case('arrow')
            <path d="M5 12h14M13 6l6 6-6 6" />
            @break
        @case('arrow-back')
            <path d="M19 12H5M11 6l-6 6 6 6" />
            @break
        @case('check')
            <polyline points="20 6 9 17 4 12" />
            @break
        @case('plus')
            <line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" />
            @break
        @case('clock')
            <circle cx="12" cy="12" r="9" /><path d="M12 7v5l3 2" />
            @break
        @case('tag')
            <path d="M20.6 13.4L11 3.8a2 2 0 0 0-1.4-.6H4v5.6a2 2 0 0 0 .6 1.4l9.6 9.6a2 2 0 0 0 2.8 0l3.6-3.6a2 2 0 0 0 0-2.8z" /><circle cx="7.5" cy="7.5" r="1.2" fill="currentColor" />
            @break
        @default
            <path d="M5 12h14M13 6l6 6-6 6" />
    @endswitch
</svg>
