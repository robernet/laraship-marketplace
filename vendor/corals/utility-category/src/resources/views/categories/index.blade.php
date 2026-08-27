@extends('layouts.crud.index')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('utility_categories') }}
        @endslot
    @endcomponent
@endsection

@section('actions')
    @parent
    @if (user()->can('update', \Corals\Utility\Category\Models\Category::class))
        {!! CoralsForm::link(url($resource_url.'/hierarchy'), trans('utility-category::labels.category.hierarchy'), ['class'=>'btn btn-info']) !!}
    @endif
@endsection
