@extends('layouts.login')
{!! env('COMPANY_NAME') !!} | @lang('auth.Password')
@section('content')
	<div class="login-box">
		<div class="login-logo">
			{!!env('COMPANY_NAME')!!}
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<p class="login-box-msg">@lang('auth.Reset Password')</p>
			@if(isset($token))
				<div class="alert alert-danger">
					@lang('auth.Please check your email for the reset password link')
				</div>
			@endif
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
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<div class="col-md-12">
						<input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary btn-block">
							@lang('auth.Send Password Reset Link')
						</button>
					</div>
				</div>
			</form>
			<hr/>
			<div class="row">
				<div class="col-md-6">
					<a href="{{url('register')}}" class="text-center "><i class="fa fa-user"></i> @lang('auth.New User')</a>
				</div>
				<div class="col-md-6 ">
					<a href="{{url('login')}}" class="text-center pull-right"><i class="fa fa-user"></i> @lang('auth.Login')</a>
				</div>
			</div>


		</div>
		<!-- /.login-box-body -->
	</div><!-- /.login-box -->
@endsection
