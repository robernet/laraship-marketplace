@extends('layouts.crud.create_edit')



@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('page_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($page, ['files'=>true]) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('title','cms::attributes.content.title',true) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::text('slug','cms::attributes.content.slug',true) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::select('categories[]','cms::attributes.content.categories', \CMS::getCategoriesList(false, null, null, 'page'), false,$page->categories->pluck('id')->toArray(),['multiple'=>true], 'select2') !!}
                    </div>
                </div>
                @if($page->exists)
                    <div class="row">
                        <div class="col-md-2">
                            <div class="m-b-10">
                                {!! CoralsForm::link(url($resource_url.'/'.$page->hashed_id.'/design'), 'cms::labels.page.edit_in_designer',['target'=>'_blank', 'class'=>'btn btn-primary']) !!}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('content','cms::attributes.content.content',false, null, ['class'=>'ckeditor']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_keywords','cms::attributes.content.meta_keywords',false,$page->meta_keywords,['rows'=>4]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_description','cms::attributes.content.meta_description',false,$page->meta_description,['rows'=>4]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('published', 'cms::attributes.content.published',$page->published) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('private', 'cms::attributes.content.private',$page->private, 1,
                                ['help_text'=>'cms::attributes.content.private_help']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('internal', 'cms::attributes.content.internal', $page->internal, 1,
                                ['help_text'=>'cms::attributes.content.internal_help']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! CoralsForm::select('template','cms::attributes.content.template', \CMS::getFrontendThemeTemplates()) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($page->featured_image)
                            <img src="{{ $page->featured_image }}" class="img-responsive" style="max-width: 100%;"
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
                {!! CoralsForm::customFields($page) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($page) !!}
                <hr/>
                <div class="row">
                    <div class="col-md-5">
                        <small>@lang('cms::labels.page.designer_powered')</small>
                        <h4><img src="{{ asset('assets/corals/plugins/page-designer/grapesjs-logo.png') }}"
                                 height="20"
                                 alt="GrapesJS Logo"/> @lang('cms::labels.page.grapes_js') </h4>
                        <blockquote>
                            @lang('cms::labels.page.paragraph_grapes')
                        </blockquote>
                        <div class="help-text text-muted">
                            @lang('cms::labels.page.for_demo_and_docs')
                            <a href="http://grapesjs.com/" target="_blank">http://grapesjs.com/</a>
                        </div>
                        <br/>
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
@endsection
