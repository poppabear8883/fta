@extends('layouts.v2')
@section('page_header')
    Edit Bid Item
@endsection

@section('page_header_description')
    You can use this form to make changes to an active bid. Typically used to update Current and Max Bids!
@endsection
@section('content')
    @include('partials.alerts.errors')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Editing {{$bid->name}}</h3>
        </div>
        <div class="box-body">
            {!! Form::model($bid, ['method' => 'PATCH', 'route' => ['bids.update', $bid->id]]) !!}

            @include('partials.forms.frmBids')

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.money-input').maskMoney({allowZero:true});

            $('#datetimepicker').datetimepicker({
                step: 5,
                format: 'Y-m-d H:i:s',
                formatTime: 'H:i'
            });
        });
    </script>
@endpush