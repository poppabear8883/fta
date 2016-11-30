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
                            <div class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i></div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped table-bordered dataTable no-footer" id="users-table">
                            <thead>
                            <tr>
                                <th>url</th>
                                <th>won</th>
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
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url('home/data') !!}',
            "rowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if(aData[1] == '1') {
                    $(nRow).addClass('tablerow-won');
                }
            },
            "columnDefs": [
                {
                    "targets": 3,
                    "render": function ( data, type, row, meta ) {
                        var itemUrl = row[0];
                        return '<a href="' + itemUrl + '">' + data + '</a>';
                    }
                },
                {
                    "targets": 7,
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
    });
</script>
@endpush