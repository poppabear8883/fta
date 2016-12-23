@extends('layouts.v2')
@section('page_header')
    Edit Bid Item
@endsection

@section('page_header_description')
    You can use this form to make changes to an active bid. Typically used to update Current and Max Bids!
@endsection
@section('content')
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

                if(attrName == 'datetime' || attrName == 'url') {
                    el.attr('readonly', true);
                }
            });
        });
    </script>
@endpush