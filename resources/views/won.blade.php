@extends('layouts.v2')

@section('content')
    @include('partials.alerts.errors')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        My Won Items
                        <div class="pull-right">
                            <a href="/bids" class="btn btn-xs btn-primary">
                                Active Bids <span class="badge">{{count($active)}}</span>
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div id="button_tools" style="margin-bottom: 15px"></div>

                        <table id="won-table" class="table table-striped dt-responsive nowrap dataTable no-footer"
                               cellspacing="0"
                               width="100%"
                                >
                            <thead>
                            <tr>
                                <th class="desktop"></th>
                                <th class="never">id</th>
                                <th class="never">url</th>
                                <th class="min-tablet-l">Ended</th>
                                <th class="all">Name</th>
                                <th class="min-table-l">Location</th>
                                <th class="min-tablet-l">Amount</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script>
    function format(d) {
        // `d` is the original data object for the row
        return '<div class="row">' +
                '<div class="col-md-6">' +
                'Pickup Detials:' +
                '</div>' +
                '<div class="col-md-6">' +
                'Extra Information:' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-md-6">' +
                '<div class="well well-sm">'+d.pickup+'</div>'+
                '</div>' +
                '<div class="col-md-6">' +
                '<div class="well well-sm">'+d.notes+'</div>'+
                '</div>' +
                '</div>';
    }

    $(document).ready(function () {
        var sel_table = $('#won-table');

        var table = sel_table.DataTable({
            dom: 'Blfrtip',
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate
                }
            },
            buttons: {
                buttons: [
                    {
                        extend: 'print',
                        className: 'btn-sm btn-primary',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function (win) {
                            $(win.document.body)
                                    .css('font-size', '10pt');


                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                        }
                    }
                ]
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('won/data') !!}',
            "order": [[3, "asc"]],
            "iDisplayLength": 25,
            "rowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $(nRow).addClass('tablerow-success');
            },
            "columnDefs": [
                {
                    "targets": 3,
                    "render": function (data, type, row, meta) {
                        return new moment(data).format('lll');
                    }
                },
                {
                    "targets": 4,
                    "render": function (data, type, row, meta) {

                        var itemUrl = row['url'];

                        return '<a href="' + itemUrl + '" target="_blank">' + data + '</a>';
                    }
                }
            ],
            "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            }, {
                "data": "id",
                "visible": false
            }, {
                "data": "url",
                "visible": false
            }, {
                "data": "datetime"
            }, {
                "data": "name"
            }, {
                "data": "location"
            }, {
                "data": "cur_bid"
            }]
        });

        table.buttons().container()
                .appendTo('#button_tools');

        // Add event listener for opening and closing details
        sel_table.find('tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });
</script>
@endpush