@extends('layouts.master')

@section('title',$title)

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 offset-md-3 my-3">
            @component('components.box')
                <h4>{!! $message !!}</h4>
                <div class="text-right">
                    {!!  CoralsForm::openForm(null,$continueUrl?['url'=>url($continueUrl)]:['class'=>'']) !!}

                    {!! CoralsForm::hidden('confirmed', true) !!}

                    {!! CoralsForm::button('Subscriptions::labels.subscription.continue',['class'=>'btn btn-success'], 'submit') !!}

                    {!! CoralsForm::link(url('dashboard'), 'Corals::labels.cancel',['class'=>'btn btn-warning']) !!}

                    {!!CoralsForm::closeForm() !!}
                </div>
            @endcomponent
        </div>
    </div>
@endsection
