@extends('layouts.master')
@section('title')
    @lang('department.Add New Department')
@endsection

@section('heading')
    @lang('department.Add New Department')
@endsection

@section('content')
    <div id="app">
    @include('departments.form')
    </div>
@endsection

@section('jquery')
    <script>

        var vm = new Vue({
            el: '#app',
            data: {}
        });
    </script>
@endsection