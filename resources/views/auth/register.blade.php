@extends('auth.layout')

@section('body')
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="/"><b>Bidfta App</b> v2</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Register a new membership</p>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <input type="hidden" name="timezone" id="users_tz" value="">

                <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                           required
                           autofocus
                           placeholder="Full Name"
                    >
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                           required
                           placeholder="Email"
                    >
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                    <input id="phone_number" type="text" class="form-control" name="phone_number"
                           value="{{ old('phone_number') }}"
                           required
                           placeholder="Phone # 15551112222"
                     >
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    @if ($errors->has('phone_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone_number') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('bidder_number') ? ' has-error' : '' }}">
                    <input id="bidder_number" type="text" class="form-control" name="bidder_number"
                           value="{{ old('bidder_number') }}"
                           required
                            placeholder="FTA Bidder Number"
                    >
                    <span class="glyphicon glyphicon-tag form-control-feedback"></span>
                    @if ($errors->has('bidder_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('bidder_number') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password"
                           required
                            placeholder="Password"
                    >
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group has-feedback">
                    <input id="password-confirm" type="password" class="form-control"
                           name="password_confirmation"
                           required
                            placeholder="Confirm Password"
                    >
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <a href="/login" class="text-center">I already have a membership</a>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.register-box -->

    @include('auth.scripts')

    <script>
        $(document).ready(function() {
            $('#users_tz').val(jstz.determine().name());
        });
    </script>
</body>
@endsection