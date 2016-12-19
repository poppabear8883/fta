@extends('layouts.v2')

@section('content')
    @include('partials.alerts.errors')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif

    {!! Form::model($bid, ['method' => 'PATCH', 'route' => ['bids.update', $bid->id]]) !!}

    @include('partials.forms.frmBids')

    {!! Form::close() !!}
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