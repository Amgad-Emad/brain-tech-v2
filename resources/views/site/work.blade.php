@extends('layouts.site')

@section('content')
    <div style="padding-top:64px;">
        @include('site.sections.work')
    </div>

    @if (st('visibility.cta', true))
        @include('site.sections.cta')
    @endif
@endsection
