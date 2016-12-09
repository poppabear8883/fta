@extends('layouts.app')

@section('content')
    @include('partials.alerts.errors')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif

    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['profile.update', $user->id]]) !!}

    <div class="row">
        <div class="pull-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="/home" class="btn btn-default">Done</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('name', 'Full Name:', ['class' => 'control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
                {!! Form::email('email', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone_number', 'Phone Number:', ['class' => 'control-label']) !!}
                {!! Form::text('phone_number', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('bidder_number', 'FTA Bidder Number:', ['class' => 'control-label']) !!}
                {!! Form::text('bidder_number', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('budget', 'Current Budget:', ['class' => 'control-label']) !!}
                {!! Form::text('budget', null, ['class' => 'form-control money-input']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="pull-right">
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            <a href="/home" class="btn btn-default">Done</a>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.money-input').maskMoney({allowZero:true});
        });
    </script>
@endpush