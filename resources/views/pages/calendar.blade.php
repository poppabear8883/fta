@extends('layouts.v2')

@section('page_header')
Calendar
@endsection

@section('page_header_description')
Shows a calendar with your won bids and their pickup dates and times
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var cal = $('#calendar');

        cal.fullCalendar({
            editable: false,
            events: {
                url: 'calendar/events',
                type: 'GET',
                backgroundColor: '#39ffb0',
                borderColor: '#000000',
                textColor: '#000000'
            },
            eventRender: function(event, element) {
                //console.log($(element));
                element.attr('data-toggle', 'tooltip');
                element.attr('data-placement', 'top');
                element.attr('data-html', 'true');
                element.attr('title', event.description);
            }
        });

        cal.on('click', '.fc-event', function(e){
            e.preventDefault();
            window.open($(this).attr('href'), '_blank');
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    });
</script>
@endpush