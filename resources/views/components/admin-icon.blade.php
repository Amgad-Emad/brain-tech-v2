@props(['name' => 'info', 'size' => 17])

@php
    $paths = [
        'dashboard' => 'M3 3h7v9H3zM14 3h7v5h-7zM14 12h7v9h-7zM3 16h7v5H3z',
        'chart' => 'M4 20V10M10 20V4M16 20v-7M22 20H2',
        'palette' => 'M12 2a10 10 0 1 0 0 20c1 0 1.5-.8 1.5-1.7 0-1.2-1-1.6-1-2.8 0-.8.7-1.5 1.5-1.5H17a5 5 0 0 0 5-5c0-5-4.5-9-10-9zM7.5 11.5h.01M9.5 7.5h.01M14.5 7.5h.01M16.5 11.5h.01',
        'menu' => 'M3 6h18M3 12h18M3 18h18',
        'star' => 'M12 3l2.6 5.6L21 9.5l-4.5 4.2L17.8 21 12 17.7 6.2 21l1.3-7.3L3 9.5l6.4-.9z',
        'shield' => 'M12 3l8 3v6c0 4.5-3.2 7.8-8 9-4.8-1.2-8-4.5-8-9V6z',
        'grid' => 'M3 3h8v8H3zM13 3h8v8h-8zM3 13h8v8H3zM13 13h8v8h-8z',
        'spark' => 'M12 3v6M12 15v6M3 12h6M15 12h6',
        'route' => 'M6 4v11a3 3 0 0 0 3 3h7',
        'folder' => 'M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z',
        'quote' => 'M7 7h4v6a4 4 0 0 1-4 4M15 7h4v6a4 4 0 0 1-4 4',
        'help' => 'M9 9a3 3 0 1 1 4 2.8c-.7.4-1 .8-1 1.7M12 17h.01',
        'flag' => 'M5 21V4M5 4h11l-1.5 4L16 12H5',
        'info' => 'M12 16v-4M12 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z',
        'layers' => 'M12 3l9 5-9 5-9-5zM3 13l9 5 9-5',
        'mail' => 'M3 6h18v12H3zM3 7l9 6 9-6',
        'tag' => 'M20.6 13.4L11 3.8a2 2 0 0 0-1.4-.6H4v5.6a2 2 0 0 0 .6 1.4l9.6 9.6a2 2 0 0 0 2.8 0l3.6-3.6a2 2 0 0 0 0-2.8zM7.5 7.5h.01',
        'search' => 'M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM21 21l-4.3-4.3',
        'users' => 'M16 21v-2a4 4 0 0 0-8 0v2M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8',
    ];
@endphp

<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" {{ $attributes }}>
    <path d="{{ $paths[$name] ?? $paths['info'] }}" />
</svg>
