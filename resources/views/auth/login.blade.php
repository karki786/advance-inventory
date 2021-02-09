@extends('layouts.login')
@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('auth.Login')
@endsection
@section('content')
    @if (Request::session()->exists('login'))
        <div class="alert alert-error text-center" style="border-radius: 0px;">
            {{Request::session()->pull('login', 'You have not been verified as a user, please contact your admin')}}
        </div>
    @endif
    <div class="login-box">
        <div class="login-logo">
            {!!env('COMPANY_NAME')!!}
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">@lang('auth.Sign in to start your session')
            </p>


            <p class="text-center">
                @if (env('APP_DEMO')==1)
                    <b> Username: example@example.com, Password: test123</b>
                @endif
            </p>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>@lang('auth.Whoops!')</strong> @lang('auth.There were some problems with your input')<br/>
                    .<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(env('Customer_login') == true)
                <div class="well">

                    @lang('auth.You will be loggin in as') : @{{user |json}}

                </div>
            @endif
            <form method="post" v-bind:action="action">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group{!! $errors->has('loginType') ? ' has-error' : '' !!}">
                    {!! Form::label('loginType', 'Login As') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-list"></i></span>
                        {!! Form::select('loginType',array(''=>'','Admin'=>'Admin','Customer'=>'Customer'), null, ['v-model'=>'user','class' => 'form-control']) !!}
                    </div>
                    {!! $errors->first('loginType', '<p class="help-block">:message</p>') !!}
                </div>
                @if(env('Customer_login') == true)
                    <div class="form-group has-feedback">
                        <select class="form-control" v-model="user">
                            <option selected>@lang('auth.Customer')</option>
                            <option>@lang('auth.Admin')</option>
                        </select>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> @lang('auth.Remember Me')
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">

                        <button type="submit" v-if="action" class="btn bg-green btn-block btn-flat"><i
                                    class="fa fa-sign-in"></i> @lang('auth.Sign In')</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            @if(env('DISABLE_REGISTRATION')==false)
                <hr/>
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{url('password/reset')}}"><i class="fa fa-lock"></i> @lang('auth.Forgot Password')</a>
                    </div>
                    <div class="col-md-6 ">
                        <a href="{{url('/register')}}" class="text-center pull-right"><i
                                    class="fa fa-user"></i> @lang('auth.New User')</a>
                    </div>
                </div>
            @endif

        </div>
        <!-- /.login-box-body -->
        <div class="footer text-center">
            <b>@lang('auth.Version')</b> {!!Config::get('app.APP_VERSION')!!} <br/>
            Copyright &copy;{{date("Y")}} {!!env('COMPANY_NAME')!!} , @lang('auth.All Rights Reserved')
        </div>

    </div><!-- /.login-box -->


@endsection
