@extends('layouts.crud.create_edit')



@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('faq_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            {!! CoralsForm::openForm($faq) !!}
            @component('components.box')
                <div class="row">
                    <div class="col-md-8">
                        {!! CoralsForm::text('title','cms::attributes.content.question',true) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('content','cms::attributes.content.answer',true, null, ['class'=>'ckeditor']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::select('categories[]','cms::attributes.content.categories', \CMS::getCategoriesList(false, null, null, 'faq'),true,$faq->categories->pluck('id')->toArray(),['multiple'=>true], 'select2') !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::select('tags[]','cms::attributes.content.tags', \CMS::getTagsList(),false,null,['class'=>'tags','multiple'=>true], 'select2') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::checkbox('published', 'cms::attributes.content.published',$faq->published) !!}
                    </div>
                </div>
                {!! CoralsForm::customFields($faq) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent
            {!! CoralsForm::closeForm($faq) !!}
        </div>
    </div>
@endsection
