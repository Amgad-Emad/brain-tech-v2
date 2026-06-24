@extends('admin.layout')
@section('title', __('admin.nav.messages'))

@section('content')
    <a href="{{ route('admin.messages.index') }}" style="font-size:13px;color:var(--muted);text-decoration:none;">← {{ __('admin.nav.messages') }}</a>

    <div class="bt-card" style="padding:26px;margin-top:14px;max-width:720px;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:22px;">
            <div>
                <h2 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:21px;margin:0 0 4px;">{{ $message->name }}</h2>
                <a href="mailto:{{ $message->email }}" style="color:var(--acc);text-decoration:none;font-size:14px;">{{ $message->email }}</a>
            </div>
            <span style="font-size:12px;color:var(--faint);white-space:nowrap;">{{ $message->created_at->format('M j, Y · g:i a') }}</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;font-size:13.5px;margin-bottom:22px;">
            <div><div style="color:var(--faint);font-size:12px;">Company</div><div style="font-weight:600;">{{ $message->company ?: '—' }}</div></div>
            <div><div style="color:var(--faint);font-size:12px;">Service</div><div style="font-weight:600;">{{ $message->service ?: '—' }}</div></div>
            <div><div style="color:var(--faint);font-size:12px;">Locale</div><div style="font-weight:600;text-transform:uppercase;">{{ $message->locale ?: '—' }}</div></div>
            <div><div style="color:var(--faint);font-size:12px;">IP</div><div style="font-weight:600;">{{ $message->ip_address ?: '—' }}</div></div>
        </div>

        <div style="border-top:1px solid var(--border);padding-top:18px;">
            <div style="color:var(--faint);font-size:12px;margin-bottom:8px;">Message</div>
            <p style="white-space:pre-line;line-height:1.6;margin:0;">{{ $message->message }}</p>
        </div>

        <div style="display:flex;align-items:center;gap:12px;margin-top:22px;border-top:1px solid var(--border);padding-top:18px;">
            <a href="mailto:{{ $message->email }}" class="bt-btn">Reply by email</a>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')
                <button type="submit" class="bt-btn-danger" style="height:40px;padding:0 16px;border-radius:10px;font-size:13.5px;font-weight:600;">Delete</button>
            </form>
        </div>
    </div>
@endsection
