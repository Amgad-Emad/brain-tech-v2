@extends('admin.layout')
@section('title', __('admin.nav.messages'))

@section('content')
    <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0 0 22px;">{{ __('admin.nav.messages') }}</h1>

    <div class="bt-card" style="overflow:hidden;">
        @forelse ($messages as $message)
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 18px;border-bottom:1px solid var(--border);{{ $message->isRead() ? '' : 'background:rgba(var(--accRGB),0.05);' }}">
                <a href="{{ route('admin.messages.show', $message) }}" style="text-decoration:none;color:inherit;min-width:0;">
                    <div style="font-weight:600;display:flex;align-items:center;gap:8px;">
                        @unless ($message->isRead())<span style="width:7px;height:7px;border-radius:50%;background:var(--acc);flex:none;"></span>@endunless
                        {{ $message->name }}
                    </div>
                    <div style="font-size:13px;color:var(--faint);">{{ $message->email }} @if ($message->service)· {{ $message->service }}@endif</div>
                </a>
                <div style="display:flex;align-items:center;gap:14px;flex:none;">
                    <span style="font-size:12px;color:var(--faint);">{{ $message->created_at->diffForHumans() }}</span>
                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;color:#ef6464;font-size:13px;cursor:pointer;">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="padding:22px;color:var(--faint);margin:0;">No messages yet.</p>
        @endforelse
    </div>

    <div style="margin-top:16px;">{{ $messages->links() }}</div>
@endsection
