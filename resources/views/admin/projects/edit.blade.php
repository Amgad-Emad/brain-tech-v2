@extends('admin.layout')
@section('title', $project->t('name') ?: __('admin.projects.edit_action'))

@section('content')
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:18px;">
        <div>
            <a href="{{ route('admin.projects.index') }}" style="display:inline-flex;align-items:center;gap:7px;color:var(--muted);text-decoration:none;font-size:13.5px;font-weight:600;margin-bottom:14px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                {{ __('admin.projects.title') }}
            </a>
            <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0;">{{ $project->t('name') ?: $project->slug }}</h1>
        </div>
        <a href="{{ route('work.show', $project) }}" target="_blank" rel="noopener" class="bt-btn-ghost" style="height:40px;display:inline-flex;align-items:center;gap:7px;padding:0 14px;border-radius:10px;font-size:13.5px;font-weight:600;flex:none;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 3h6v6"/><path d="M10 14L21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
            {{ __('admin.projects.view_live') }}
        </a>
    </div>

    @include('admin.projects._form', ['action' => route('admin.projects.update', $project), 'method' => 'PUT'])
@endsection
