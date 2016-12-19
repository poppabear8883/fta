@extends('layouts.v2')

@section('content')
    @include('partials.alerts.errors')

    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{$active_count}}</h3>

                    <p>Active Bids</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tags"></i>
                </div>
                <a href="/" class="small-box-footer">
                    View Now <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$won_count}} <span style="font-size: 19px">(${{$won_amount}})</span></h3>

                    <p>Won Items</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bookmark-o"></i>
                </div>
                <a href="/won" class="small-box-footer">
                    View Now <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>${{$cur_total}}</h3>

                    <p>Current Bids Total</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box {{(($max_total/auth()->user()->budget)*100 >= 75 ? 'bg-red' : 'bg-purple')}}">
                <div class="inner">
                    <h3>${{$max_total}} <small>{{(($max_total/auth()->user()->budget)*100 >= 75 ? 'Warning!' : '')}}</small></h3>

                    <p>{{($max_total/auth()->user()->budget)*100}}% of ${{auth()->user()->budget}}</p>
                </div>
                <div class="icon">
                    <i class="fa fa-credit-card-alt"></i>
                </div>
                <a href="/profile" class="small-box-footer">
                    Change Budget <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Recently Won</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach($recently_won as $item)
                            <li class="item">
                                <div class="product-img">
                                    <img src="images/default-50x50.gif" alt="Product Image">
                                </div>
                                <div class="product-info">
                                    <a href="{{$item->url}}" class="product-title">
                                        {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->datetime)->setTimezone(auth()->user()->timezone)->format('m/d/Y')}}
                                        | {{$item->location}}
                                        <span class="label label-success pull-right">${{$item->cur_bid}}</span>
                                    </a>
                            <span class="product-description">
                              {{$item->name}}
                            </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-8">
                            <a href="/won" class="btn btn-default uppercase pull-left">View All</a>
                        </div>
                        <div class="col-md-4">
                            <a href="/calendar" class="btn btn-info uppercase pull-right">Calendar</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-envelope"></i>
                    <h3 class="box-title">Quick Email | Suggestions | Issues</h3>
                </div>
                <div class="box-body">
                    <form id="quickEmailForm" action="/quick/email" method="post">
                        {{csrf_field()}}
                        <input name="from" type="hidden" value="{{auth()->user()->email}}">

                        <div class="form-group">
                            <input name="email" type="text" class="form-control" value="support@bidftaapp.com" readonly>
                        </div>
                        <div class="form-group">
                            <input name="subject" type="text" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="5" placeholder="Message"></textarea>
                        </div>
                    </form>
                </div>
                <div class="box-footer clearfix">
                    <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                        <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#sendEmail').click(function(e) {
            e.preventDefault();
            var inSubject = $('input[name="subject"]');
            var inMessage = $('textarea[name="message"]');

            inSubject.closest('.form-group').removeClass('has-error');
            inMessage.closest('.form-group').removeClass('has-error');

            if(inSubject.val() == '') {
                inSubject.closest('.form-group').addClass('has-error');
            } else if(inMessage.val() == '') {
                inMessage.closest('.form-group').addClass('has-error');
            } else {
                $('#quickEmailForm').submit();
            }
        })
    });
</script>
@endpush