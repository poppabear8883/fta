@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
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
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Information</div>

                    <div class="panel-body">
                        Stats go here
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
            ajax: '{!! url('home/data') !!}'
        });
    });
</script>
@endpush