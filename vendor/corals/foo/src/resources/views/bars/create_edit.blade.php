@extends('layouts.crud.create_edit')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('foo_bar_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($bar) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::text('name', 'Foo::attributes.bar.name' ,true,null) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($bar) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($bar) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection
