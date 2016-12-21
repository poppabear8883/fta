@extends('layouts.v2')
@section('page_header')
    New Bid Item
@endsection

@section('page_header_description')
    You can use this form to create a NEW active bid.! Check all fields, then click Save.
@endsection
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Create New Bid</h3>
        </div>
        <div class="box-body">
            {!! Form::open(['route' => 'bids.store']) !!}

            @include('partials.forms.frmBids')

            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var dates = [];

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