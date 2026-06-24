@php
    $waNumber = preg_replace('/[^0-9]/', '', (string) st('contact.whatsapp', ''));
@endphp
@if (st('visibility.whatsapp') && $waNumber)
    <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp"
       style="position:fixed;bottom:24px;inset-inline-end:24px;z-index:90;width:58px;height:58px;border-radius:50%;background:#25D366;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 28px rgba(37,211,102,0.45);transition:transform .25s ease;">
        <svg width="31" height="31" viewBox="0 0 32 32" fill="#fff" aria-hidden="true"><path d="M16 3C9.4 3 4 8.4 4 15c0 2.1.6 4.2 1.6 6L4 29l8.2-1.6c1.7.9 3.6 1.4 5.6 1.4h.2c6.6 0 12-5.4 12-12S22.6 3 16 3zm0 21.8c-1.7 0-3.4-.5-4.9-1.3l-.4-.2-4.9 1 1-4.7-.3-.4C5.6 18.4 5 16.7 5 15c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 9.8-9 9.8zm5.5-7.4c-.3-.2-1.8-.9-2-1-.3-.1-.5-.2-.7.1-.2.3-.8 1-.9 1.1-.2.2-.3.2-.6.1-1.6-.8-2.7-1.5-3.8-3.4-.3-.5.3-.5.8-1.5.1-.2 0-.4 0-.5 0-.1-.7-1.7-1-2.3-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.2.2 2.1 3.3 5.2 4.6 2.9 1.2 2.9.8 3.5.8.5-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.1-.3-.2-.6-.4z"/></svg>
    </a>
@endif
