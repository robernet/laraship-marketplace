@extends('layouts.master')

@section('title', $item->title)

@section('content')
    @include('cms::cms_internal.partials.page_header')

    <div class="row">
        <div class="col-md-8">
            {!! $item->rendered !!}
        </div>

        <div class="col-md-4">
            @include('cms::cms_internal.partials.sidebar')
        </div>
    </div>
@stop
