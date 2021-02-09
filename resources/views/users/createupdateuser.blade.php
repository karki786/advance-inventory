@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('user.Edit/Create Users')
@endsection

@section('heading')
    @lang('user.Create User')
@endsection

@section('content')
    <div id="app">
        @include('users.form')
    </div>

@endsection

@section('jquery')
    <script>
        app = new Vue({
            el: '#app',
            data: {

            }
        });
    </script>

@endsection