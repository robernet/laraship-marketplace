@extends('layouts.crud.create_edit')



@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('post_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            {!! CoralsForm::openForm($post, ['url' => url($resource_url.'/'.$post->hashed_id),'method'=>$post->exists?'PUT':'POST','files'=>true,'class'=>'ajax-form']) !!}
            @component('components.box')
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('title','cms::attributes.content.title',true) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::text('slug','cms::attributes.content.slug',true) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::select('categories[]','cms::attributes.content.categories', \CMS::getCategoriesList(false, null, null, 'post'),true,$post->categories->pluck('id')->toArray(),['multiple'=>true], 'select2') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::textarea('content','cms::attributes.content.content',true, null, ['class'=>'ckeditor']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_keywords','cms::attributes.content.meta_keywords',false,$post->meta_keywords,['rows'=>4]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::textarea('meta_description','cms::attributes.content.meta_description',false,$post->meta_description,['rows'=>4]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                {!! CoralsForm::select('tags[]','cms::attributes.content.tags', \CMS::getTagsList(),false,null,['class'=>'tags','multiple'=>true], 'select2') !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('published', 'cms::attributes.content.published',$post->published) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('private', 'cms::attributes.content.private',$post->private, 1,
                                ['help_text'=>'cms::attributes.content.private_help']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! CoralsForm::checkbox('internal', 'cms::attributes.content.internal', $post->internal, 1,
                                ['help_text'=>'cms::attributes.content.internal_help']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! CoralsForm::select("author_id",'cms::attributes.content.author', [],  true, null,
                                     ['class'=>'select2-ajax',
                                     'data'=>[
                                    'model'=>\Corals\User\Models\User::class,
                                    'columns'=> json_encode(['name','last_name', 'email']),
                                    'selected'=>json_encode([$post->author_id ?? user()->id]),
                                    'where'=>json_encode([]),
                                    ]],'select2') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" class="img-responsive" style="max-width: 100%;"
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
                {!! CoralsForm::customFields($post) !!}
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
            @endcomponent
            {!! CoralsForm::closeForm($post) !!}
        </div>
    </div>
@endsection
