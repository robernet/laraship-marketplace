@extends('layouts.master')

@section('title', $item->title)

@section('content')
    @include('cms::cms_internal.partials.page_header')

    <div class="row">
        <div class="col-md-12">
            {!! $item->rendered !!}
        </div>
    </div>
@stop
