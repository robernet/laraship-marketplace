@extends('layouts.master')

@section('title', $item->title)

@section('content')
    @include('cms::cms_internal.partials.page_header')

    @php \Actions::do_action('pre_content',$item,$home) @endphp

    <div class="row">
        <div class="col-md-12">
            {!! $item->rendered !!}
        </div>
    </div>
@stop
