@extends('layouts.v2')
@section('page_header')
    Active Bids
@endsection

@section('page_header_description')
    Shows a data table of all your active bids. You can add, delete, edit and mark your bids as won!
@endsection
@section('content')
    @include('partials.alerts.errors')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif

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
                        <div class="col-xs-12">
                            <div class="well well-sm">
                                <div class="row">
                                    <div class="col-xs-1">
                                        <button type="button" class="btn btn-xs btn-success" disabled>
                                            <i class="glyphicon glyphicon-check"></i>
                                        </button>
                                    </div>
                                    <div class="col-xs-11">
                                        Use this button to mark the selected bid as <strong>WON</strong>!
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-1">
                                        <button type="button" class="btn btn-xs btn-primary" disabled>
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </button>
                                    </div>
                                    <div class="col-xs-11">
                                        Use this button to <strong>EDIT</strong> the selected bid!
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-1">
                                        <button type="button" class="btn btn-xs btn-danger" disabled>
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </button>
                                    </div>
                                    <div class="col-xs-11">
                                        Use this button to <strong>DELETE</strong> the selected bid!
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <form method="POST" action="" accept-charset="UTF-8" id="frmWon">
                                        <input name="_method" type="hidden" value="PATCH">
                                        <input name="_token" type="hidden" value="{{csrf_token()}}">
                                        <input name="won" type="hidden" value="1">
                                        <button type="submit" class="btn btn-success disabled" id="btnWon">
                                            <i class="glyphicon glyphicon-check"></i>
                                            <span class="hidden-xs">Mark as Won</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-xs-4">
                                    <a href="#" class="btn btn-primary disabled" id="btnEdit">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                        <span class="hidden-xs">Edit Selected</span>
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <form method="POST" action="" accept-charset="UTF-8" id="frmDelete">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input name="_token" type="hidden" value="{{csrf_token()}}">
                                        <button type="submit" class="btn btn-danger disabled" id="btnDelete">
                                            <i class="glyphicon glyphicon-trash"></i>
                                            <span class="hidden-xs">Delete Selected</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
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
            select: {
                style: 'single'
            },
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
                    var selected = $(nRow).hasClass('selected');

                    if (selected) {
                        $(nRow).removeClass('tablerow-danger');
                        $(nRow).removeClass('tablerow-caution');
                    }

                    if (selected && data < now) {
                        $('#btnWon').removeClass('disabled');
                    } else {
                        $('#btnWon').addClass('disabled');
                    }

                    if (dif == 0 && !skip && !selected) {
                        $(nRow).removeClass('tablerow-danger');
                        $(nRow).addClass('tablerow-caution');
                    }

                    if (data < now && !skip && !selected) {
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
                "data": "cur_bid"
            }, {
                "data": "max_bid"
            }]
        });

        $('#btnWon').on('click', function (e) {
            e.preventDefault();
            var disabled = $(this).hasClass('disabled');

            if (!disabled) {
                $('#frmWon').submit()
            }
        });
        $('#btnEdit').on('click', function (e) {
            var disabled = $(this).hasClass('disabled');

            if (disabled) {
                e.preventDefault();
            }
        });
        $('#btnDelete').on('click', function (e) {
            e.preventDefault();
            var disabled = $(this).hasClass('disabled');

            if (!disabled) {
                $('#frmDelete').submit()
            }
        });

        table.buttons().container().appendTo('#button_tools');

        table
                .on('select', function (e, dt, type, indexes) {
                    var rowData = table.rows(indexes).data().toArray();
                    var data = rowData[0];
                    var btnEdit = $('#btnEdit');

                    btnEdit.removeClass('disabled');
                    btnEdit.attr('href', 'bids/' + data.id + '/edit');
                    $('#btnDelete').removeClass('disabled');
                    $('#frmWon').attr('action', 'bid/' + data.id + '/won');
                    $('#frmDelete').attr('action', 'bids/' + data.id);
                })
                .on('deselect', function (e, dt, type, indexes) {
                    var btnEdit = $('#btnEdit');
                    btnEdit.addClass('disabled');
                    btnEdit.attr('href', '#');
                    $('#btnDelete').addClass('disabled');
                    $('#frmWon').attr('action', '');
                    $('#frmDelete').attr('action', '');
                });
    });

    /**/
</script>
@endpush