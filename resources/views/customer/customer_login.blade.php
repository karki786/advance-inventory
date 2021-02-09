@extends('layouts.frontend.master')

@section('title')

@endsection

@section('sidebar')

@endsection

@section('content')
    @if (Request::session()->exists('login'))
        <div class="alert alert-error text-center" style="border-radius: 0px;">
            {{Request::session()->pull('login', @lang('customer.You have not been verified as a user, please contact your admin'))}}
        </div>
    @endif
    <div class="login-box">
        <div class="login-logo">
            {!!env('COMPANY_NAME')!!}
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">@lang('customer.Sign in to start your session')
            </p>


            <p class="text-center">
                @if (env('APP_DEMO')==1)
                    <b> Username: customer@example.com, Password: test123</b>
                @endif
            </p>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>@lang('auth.Whoops!')</strong> @lang('auth.There were some problems with your input')<br/>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{ action('Auth\CustomerLoginController@login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">

                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn bg-green btn-block btn-flat">@lang('customer.Sign In')</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>


        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@endsection

@section('js')

@endsection