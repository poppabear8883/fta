@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Statistics</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                col 1
                            </div>
                            <div class="col-md-4">
                                col 2
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="btn btn-success">
                                    Won Items <span class="badge">{{count($won)}}</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        My Bids
                        <div class="pull-right">
                            <a href="#" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i></a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div id="button_tools" style="margin-bottom: 15px"></div>

                        <table class="table table-striped table-bordered dataTable no-footer" id="bids-table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>url</th>
                                <th>Ends</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Current Bid</th>
                                <th>Max Bid</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function format(d) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Name:</td>' +
                '<td>' + d.name + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Link:</td>' +
                '<td>' + d.url + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Extra info:</td>' +
                '<td>And any further details here (images etc)...</td>' +
                '</tr>' +
                '</table>';
    }

    $(document).ready(function () {
        var sel_table = $('#bids-table');

        var table = sel_table.DataTable({
            dom: 'Blfrtip',
            buttons: {
                buttons: [
                    {extend: 'copy', className: 'btn-sm'},
                    {extend: 'excel', className: 'btn-sm'},
                    {extend: 'pdf', className: 'btn-sm'},
                    {extend: 'print', className: 'btn-sm btn-primary'}
                ]
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('home/data') !!}',
            "order": [[2, "asc"]],
            "iDisplayLength": 25,
            "rowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                setInterval(function () {
                    var now = new moment();
                    var data = new moment(aData['datetime']);
                    var dif = data.diff(now, 'hours');

                    if (dif == 0) {
                        $(nRow).removeClass('tablerow-danger');
                        $(nRow).addClass('tablerow-caution');
                    }

                    if (data < now) {
                        $(nRow).removeClass('tablerow-caution');
                        $(nRow).addClass('tablerow-danger');
                    }
                }, 1000);
            },
            "columnDefs": [
                {
                    "targets": 2,
                    "render": function (data, type, row, meta) {
                        return new moment(data).format('lll');
                    }
                },
                {
                    "targets": 3,
                    "render": function (data, type, row, meta) {

                        var itemUrl = row['url'];

                        return '<a href="' + itemUrl + '">' + data + '</a>';
                    }
                },
                {
                    "targets": 7,
                    "render": function (data, type, row, meta) {
                        return '<div class="text-center"><a href="#" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-check"></i></a> ' +
                                '<a href="#" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a> ' +
                                '<a href="#" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a></div>';
                    }
                }
            ],
            "columns": [{
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
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
            }, {
                "data": "max_bid"

            }]
        });

        table.buttons().container()
                .appendTo('#button_tools');

        // Add event listener for opening and closing details
        sel_table.find('tbody').on('click', 'td.details-control', function () {
            console.log('clicked');

            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });
</script>
@endpush