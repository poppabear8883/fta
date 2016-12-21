@extends('layouts.v2')
@section('page_header')
    Profile
@endsection

@section('page_header_description')
    Edit your profile settings here including your budget!
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Profile</h3>
        </div>
        <div class="box-body">
            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['profile.update', $user->id]]) !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="/" class="btn btn-default">Done</a>
                    </div>
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
                <div class="col-md-12">
                    <div class="pull-right">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="/" class="btn btn-default">Done</a>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.money-input').maskMoney({allowZero:true});
        });
    </script>
@endpush