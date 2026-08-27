@extends('layouts.crud.create_edit')



@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('testimonial_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            {!! CoralsForm::openForm($testimonial) !!}
            @component('components.box')
                <div class="row">
                    <div class="col-md-8">
                        {!! CoralsForm::text('title','cms::attributes.testimonial.author',true) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('content','cms::attributes.testimonial.review',true, null, []) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::text('properties[job_title]','cms::attributes.content.job_title',true) !!}
                        {!! CoralsForm::select('properties[rating]','cms::attributes.content.rating',trans('cms::attributes.content.rating_option'),true) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if($testimonial->hasMedia($testimonial->mediaCollectionName))
                            <img src="{{ $testimonial->image }}" class="img-responsive" style="max-width: 150px;"
                                 alt="Image"/>
                            <br/>
                            {!! CoralsForm::checkbox('clear', 'cms::attributes.content.clear') !!}
                        @endif
                        {!! CoralsForm::file('image', 'cms::attributes.content.featured_image',false) !!}

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::checkbox('published', 'cms::attributes.content.published',$testimonial->published) !!}
                    </div>
                </div>
                {!! CoralsForm::customFields($testimonial) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent
            {!! CoralsForm::closeForm($testimonial) !!}
        </div>
    </div>
@endsection
