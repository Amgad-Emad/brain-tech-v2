@extends('admin.layout')
@section('title', __('admin.projects.add'))

@section('content')
    <a href="{{ route('admin.projects.index') }}" style="display:inline-flex;align-items:center;gap:7px;color:var(--muted);text-decoration:none;font-size:13.5px;font-weight:600;margin-bottom:14px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        {{ __('admin.projects.title') }}
    </a>
    <h1 style="font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:clamp(22px,3vw,30px);letter-spacing:-0.02em;margin:0 0 20px;">{{ __('admin.projects.add') }}</h1>

    @include('admin.projects._form', ['action' => route('admin.projects.store'), 'method' => 'POST'])
@endsection
