@extends('admin.layout')
@section('title', __('admin.projects.title'))

@section('content')
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:8px;">
        <div>
            <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0;">{{ __('admin.projects.title') }}</h1>
            <p style="color:var(--muted);font-size:14px;margin:6px 0 0;line-height:1.6;max-width:560px;">{{ __('admin.projects.intro') }}</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="bt-btn" style="height:42px;display:inline-flex;align-items:center;gap:8px;flex:none;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            {{ __('admin.projects.add') }}
        </a>
    </div>

    <div class="bt-card" style="overflow:hidden;margin-top:18px;">
        @forelse ($projects as $project)
            <div style="display:flex;align-items:center;gap:14px;padding:13px 16px;border-bottom:1px solid var(--border);">
                <div style="width:64px;height:44px;border-radius:9px;overflow:hidden;border:1px solid var(--border);flex:none;background:var(--panel2);background-image:url('{{ $project->imageUrl() }}');background-size:cover;background-position:center;"></div>
                <a href="{{ route('admin.projects.edit', $project) }}" style="flex:1;min-width:0;text-decoration:none;color:inherit;">
                    <div style="font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $project->t('name') ?: $project->slug }}</div>
                    <div style="font-size:12.5px;color:var(--faint);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $project->t('tag') }}@if ($project->year) · {{ $project->year }}@endif</div>
                </a>
                <span style="font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;border:1px solid var(--border);flex:none;{{ $project->is_visible ? 'color:var(--acc);background:rgba(var(--accRGB),0.12);' : 'color:var(--faint);background:var(--panel2);' }}">
                    {{ $project->is_visible ? __('admin.projects.visible') : __('admin.projects.hidden') }}
                </span>
                <div style="display:flex;align-items:center;gap:8px;flex:none;">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="bt-btn-ghost" style="height:34px;padding:0 13px;border-radius:9px;font-size:13px;font-weight:600;display:inline-flex;align-items:center;text-decoration:none;">{{ __('admin.projects.edit_action') }}</a>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('{{ __('admin.projects.confirm_delete') }}')">@csrf @method('DELETE')
                        <button type="submit" class="bt-btn-danger" style="height:34px;padding:0 13px;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;">{{ __('admin.projects.delete_action') }}</button>
                    </form>
                </div>
            </div>
        @empty
            <p style="padding:26px;color:var(--faint);margin:0;text-align:center;">{{ __('admin.projects.empty') }}</p>
        @endforelse
    </div>
@endsection
