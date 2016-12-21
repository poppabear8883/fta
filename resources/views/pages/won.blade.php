@extends('layouts.v2')
@section('page_header')
    Won Bids
@endsection

@section('page_header_description')
    Shows a data table of all your Won Bids from the beginning of time!
@endsection
@section('content')
    <!-- todo: fix up this table, should include edit action -->
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Won Bids</h3>
        </div>
        <div class="box-body">
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
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: ''
            }, {
                data: 'id',
                visible: false
            }, {
                data: 'url',
                visible: false
            }, {
                data: 'datetime'
            }, {
                data: 'name'
            }, {
                data: 'location'
            }, {
                data: 'cur_bid'
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