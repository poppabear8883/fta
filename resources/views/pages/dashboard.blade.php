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
                    <i class="fa fa-bookmark-o"></i>
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
                    <h3>{{$won_count}}</h3>

                    <p>Won Items</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <a href="#" class="small-box-footer">
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
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>${{$max_total}}</h3>

                    <p>${{ $max_total }} out of ${{auth()->user()->budget}}</p>
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
        <div class="col-md-8">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-envelope"></i>
                    <h3 class="box-title">Quick Email | Suggestions | Issues</h3>
                </div>
                <div class="box-body">
                    <form action="#" method="post">
                        <div class="form-group">
                            <input name="support_email" type="email" class="form-control" value="support@bidftaapp.com" disabled>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea class="textarea" style="margin: 0; width: 100%; height: 250px;" placeholder="Message"></textarea>
                        </div>
                    </form>
                </div>
                <div class="box-footer clearfix">
                    <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                        <i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
                                    <a href="javascript:void(0)" class="product-title">
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
                <div class="box-footer text-center">
                    <a href="javascript:void(0)" class="uppercase">View All Products</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>

@endsection