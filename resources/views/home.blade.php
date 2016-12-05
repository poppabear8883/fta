@extends('layouts.app')

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
                <div class="panel-heading">Statistics</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h3>Budget:</h3>
                            <div class="progress">
                                <div id="budgetProgress" class="progress-bar progress-bar-info text-center" role="progressbar"
                                     aria-valuenow="{{$max_amount}}"
                                     aria-valuemin="0"
                                     aria-valuemax="{{\Auth::user()->budget}}"
                                     style="width: 40%"
                                >
                                    ${{ $max_amount }} of ${{\Auth::user()->budget}}
                                </div>
                            </div>
                            <a href="/profile">Change Budget</a>
                        </div>
                        <div class="col-md-4">
                            col 2
                        </div>
                        <div class="col-md-4">
                            <a href="/won" class="btn btn-success">
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
                        <a href="bids/create" class="btn btn-xs btn-success"><i
                                    class="glyphicon glyphicon-plus"></i></a>
                    </div>
                </div>

                <div class="panel-body">
                    <div id="button_tools" style="margin-bottom: 15px"></div>

                    <table class="table table-striped dataTable no-footer" id="bids-table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>id</th>
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
@endsection

@push('scripts')
<script>
    function format(d) {
        return '<div class="alert alert-danger text-center"><strong>ONLY use this frame for information and to place bid!</strong></div>' +
                '<div class="panel panel-default">' +
                '<div class="panel-body" id="pnlFrame"></div>' +
                '</div>';
    }

    $(document).ready(function () {
        var sel_table = $('#bids-table');

        var table = sel_table.DataTable({
            dom: 'Blfrtip',
            buttons: {
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'excel',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-sm'
                    },
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
            ajax: '{!! url('home/data') !!}',
            "order": [[3, "asc"]],
            "iDisplayLength": 25,
            "rowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                setInterval(function () {
                    var now = new moment();
                    var data = new moment(aData['datetime']);
                    var dif = data.diff(now, 'hours');
                    var skip = $(nRow).hasClass('tablerow-danger');

                    if (dif == 0 && !skip) {
                        $(nRow).removeClass('tablerow-danger');
                        $(nRow).addClass('tablerow-caution');
                    }

                    if (data < now && !skip) {
                        $(nRow).removeClass('tablerow-caution');
                        $(nRow).addClass('tablerow-danger');
                        $(nRow).find('#btnWon' + aData['id']).removeClass('hide');
                        //$(nRow).find('#btnEdit' + aData['id']).addClass('hide');
                    }
                }, 1000);
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
                        //return data;
                    }
                },
                {
                    "targets": 8,
                    "render": function (data, type, row, meta) {
                        var id = row['id'];

                        return '<div class="row">' +
                                '<div class="col-md-1">' +
                                '<form method="POST" action="bid/' + id + '/won" accept-charset="UTF-8">' +
                                '<input name="_method" type="hidden" value="PATCH">' +
                                '<input name="_token" type="hidden" value="{{csrf_token()}}">' +
                                '<input name="won" type="hidden" value="1">' +
                                '<button type="submit" class="btn btn-xs btn-success hide" id="btnWon' + id + '">' +
                                '<i class="glyphicon glyphicon-check"></i></button>' +
                                '</form>' +
                                '</div><div class="col-md-1">' +
                                '<a href="bids/' + id + '/edit" class="btn btn-xs btn-primary" id="btnEdit' + id + '">' +
                                '<i class="glyphicon glyphicon-pencil"></i></a>' +
                                '</div><div class="col-md-1">' +
                                '<form method="POST" action="bids/' + id + '" accept-charset="UTF-8">' +
                                '<input name="_method" type="hidden" value="DELETE">' +
                                '<input name="_token" type="hidden" value="{{csrf_token()}}">' +
                                '<button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></button>' +
                                '</form>' +
                                '</div></div>';
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
            }, {
                "data": "max_bid"

            }]
        });

        table.buttons().container()
                .appendTo('#button_tools');

        // Add event listener for opening and closing details
        sel_table.find('tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var url = row.data().url;

            if (row.child.isShown()) {
                $('#pnlFrame').html('');
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
                $('#pnlFrame').html('<iframe src="' + url + '" width="100%" height="600px"></iframe>');
            }
        });
    });
</script>
@endpush