@extends('layouts.crud.create_edit')



@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('news_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            {!! CoralsForm::openForm($news, ['files'=>true]) !!}
            @component('components.box')
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('title','cms::attributes.content.title',true) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::text('slug','cms::attributes.content.slug',true) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('content','cms::attributes.content.content',true, null, ['class'=>'ckeditor']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_keywords','cms::attributes.content.meta_keywords',false,$news->meta_keywords,['rows'=>4]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_description','cms::attributes.content.meta_description',false,$news->meta_description,['rows'=>4]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                @if($news->featured_image)
                                    <img src="{{ $news->featured_image }}" class="img-responsive"
                                         style="max-width: 100%;"
                                         alt="Featured Image"/>
                                    <br/>
                                    {!! CoralsForm::checkbox('clear', 'cms::attributes.content.clear') !!}
                                @endif
                                {!! CoralsForm::file('featured_image', 'cms::attributes.content.featured_image') !!}
                                -- OR --
                                <br/>
                                <br/>
                                {!! CoralsForm::text('featured_image_link','cms::attributes.content.featured_image_link') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('published', 'cms::attributes.content.published',$news->published) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('private', 'cms::attributes.content.private',$news->private, 1,
                                ['help_text'=>'cms::attributes.content.private_help']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('internal', 'cms::attributes.content.internal', $news->internal, 1,
                                ['help_text'=>'cms::attributes.content.internal_help']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! CoralsForm::select('template','cms::attributes.content.template', \CMS::getFrontendThemeTemplates() ) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! CoralsForm::customFields($news) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent
            {!! CoralsForm::closeForm($news) !!}
        </div>
    </div>
@endsection
