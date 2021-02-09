@extends('layouts.login')
@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('auth.Register')
@endsection
@section('content')
    <div class="login-box">
        <div class="login-logo">
            {!!env('COMPANY_NAME')!!}
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">@lang('auth.Sign up to start your session')</p>
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
            <form class="form-horizontal" role="form" method="POST" action="{{ url('register') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if (env('DISABLE_REGISTRATION', false) == false)
                    <div class="form-group{!! $errors->has('companyName') ? ' has-error' : '' !!}">
                        <div class="col-md-12">
                            {!! Form::text('companyName', null, ['class' => 'form-control','placeholder'=>'Company Name']) !!}
                            {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                @else
                    <input type="hidden" value="1" name="companyneeded"/>
                @endif

                <div class="form-group">

                    <div class="col-md-12">
                        <input type="text" class="form-control" name="name" placeholder="Name"
                               value="{{ old('name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                               value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" placeholder="Password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" placeholder="confirm Password" class="form-control"
                               name="password_confirmation">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-flat bg-green btn-block">
                            Register
                        </button>
                    </div>
                </div>
            </form>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    <a href="{{url('password/reset')}}"><i class="fa fa-lock"></i> @lang('auth.Forgot Password')</a>
                </div>
                <div class="col-md-6 ">
                    <a href="{{url('/login')}}" class="text-center pull-right"><i class="fa fa-user"></i> @lang('auth.Login')</a>
                </div>
            </div>


        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->

@endsection
