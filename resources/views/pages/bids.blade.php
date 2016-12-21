@extends('layouts.v2')
@section('page_header')
    Active Bids
@endsection

@section('page_header_description')
    Shows a data table of all your active bids. You can add, delete, edit and mark your bids as won!
@endsection
@section('content')
    <!-- todo: should extract parts top artials, also create views for DataTable columns ie: the actions_column -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Add New Bid</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['route' => 'bids.create']) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                        <input name="itemUrl" type="text" class="form-control"
                               placeholder="Paste Item URL and Click Add ...">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">Add!</button>
                        </span>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Active Bids</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="button_tools" style="margin-bottom: 15px"></div>
                        </div>
                    </div>

                    <table id="bids-table" class="table table-striped dt-responsive nowrap dataTable no-footer"
                           cellspacing="0"
                            >
                        <thead>
                        <tr>
                            <th class="never">id</th>
                            <th class="never">url</th>
                            <th class="min-tablet-l">Ends</th>
                            <th class="all">Name</th>
                            <th class="desktop">Current Bid</th>
                            <th class="desktop">Max Bid</th>
                            <th class="desktop">Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->
                <!-- Loading (remove the following to stop the loading)-->
                <div class="overlay hide"><i class="fa fa-refresh fa-spin"></i></div>
                <!-- end loading -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var sel_table = $('#bids-table');
        var table = sel_table.DataTable({
            dom: 'Blfrtip',
            processing: true,
            serverSide: true,
            ajax: '{!! url('dt/data') !!}',
            "order": [[2, "asc"]],
            "iDisplayLength": 10,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            },
            buttons: {
                buttons: [
                    {
                        extend: 'print',
                        className: 'btn-default',
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
                    }
                }, 500);
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
                        if (data.length > 20) data = data.substring(0, 20) + ' ...';
                        return '<a href="' + itemUrl + '" target="_blank">' + data + '</a>';
                    }
                }
            ],
            "columns": [{
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
                data: 'cur_bid'
            }, {
                data: 'max_bid'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }]
        });

        table.buttons().container().appendTo('#button_tools');
    });

    /**/
</script>
@endpush