@extends('layouts.v2')

@section('content')
    @include('partials.alerts.errors')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif

    {!! Form::open(['route' => 'bids.store']) !!}

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

            $('input').each(function() {
                var el = $(this);
                var attrName = el.attr('name');

                if(attrName && attrName != 'notes' && attrName != '_token') {
                    if(el.val() != '') {
                        el.closest('.form-group').addClass('has-success')

                    } else {
                        el.closest('.form-group').addClass('has-error');
                    }
                }
            });
        });
    </script>
@endpush