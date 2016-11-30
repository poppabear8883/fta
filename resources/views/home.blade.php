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

                        <table class="table table-striped table-bordered dataTable no-footer" id="users-table">
                            <thead>
                            <tr>
                                <th>url</th>
                                <th>Ending Date</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Current Bid</th>
                                <th>Max Bid</th>
                                <th>Actions</th>
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
    $(function() {
        var table = $('#users-table').DataTable({
            dom: 'Blfrtip',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn-sm' },
                    { extend: 'excel', className: 'btn-sm' },
                    { extend: 'pdf', className: 'btn-sm' },
                    { extend: 'print', className: 'btn-sm btn-primary' }
                ]
            },
            processing: true,
            serverSide: true,
            ajax: '{!! url('home/data') !!}',
            "rowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                var currentdate = new Date().toLocaleString();
                var ONE_HOUR = 60 * 60 * 1000;
                if((currentdate - aData[1]) < ONE_HOUR) {
                    $(nRow).addClass('tablerow-caution');
                }

                if ( Date.parse ( aData[1] ) < Date.parse ( currentdate ) ) {
                    $(nRow).addClass('tablerow-danger');
                }
            },
            "columnDefs": [
                {
                    "targets": 2,
                    "render": function ( data, type, row, meta ) {
                        var itemUrl = row[0];
                        return '<a href="' + itemUrl + '">' + data + '</a>';
                    }
                },
                {
                    "targets": 6,
                    "render": function( data, type, row, meta) {
                        return '<div class="text-center"><a href="#" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-check"></i></a> ' +
                                '<a href="#" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a> ' +
                                '<a href="#" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a></div>';
                    }
                }
            ],
            "columns": [{
                "visible": false
            },{
                "visible": true
            }, {
                "visible": true
            }, {
                "visible": true
            }, {
                "visible": true
            },{
                "visible": true
            }]
        });

        table.buttons().container()
                .appendTo('#button_tools');
    });
</script>
@endpush