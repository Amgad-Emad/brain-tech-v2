@extends('admin.layout')
@section('title', __('admin.nav.subscribers'))

@section('content')
    <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:22px;flex-wrap:wrap;">
        <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0;">{{ __('admin.nav.subscribers') }}</h1>
        <a href="{{ route('admin.subscribers.export') }}" class="bt-btn-ghost" style="height:38px;padding:0 16px;border-radius:10px;font-size:13px;font-weight:600;display:inline-flex;align-items:center;text-decoration:none;">{{ __('admin.export') }} CSV</a>
    </div>

    <div class="bt-card" style="overflow:hidden;">
        @forelse ($subscribers as $subscriber)
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 18px;border-bottom:1px solid var(--border);">
                <div>
                    <div style="font-weight:600;">{{ $subscriber->email }}</div>
                    <div style="font-size:12px;color:var(--faint);text-transform:uppercase;">{{ $subscriber->locale ?: '—' }} · {{ $subscriber->created_at->diffForHumans() }}</div>
                </div>
                <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}" onsubmit="return confirm('Remove this subscriber?')">@csrf @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:#ef6464;font-size:13px;cursor:pointer;">Remove</button>
                </form>
            </div>
        @empty
            <p style="padding:22px;color:var(--faint);margin:0;">No subscribers yet.</p>
        @endforelse
    </div>

    <div style="margin-top:16px;">{{ $subscribers->links() }}</div>
@endsection
