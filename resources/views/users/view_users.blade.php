@extends('layouts.master')
@section('report')

@endsection
@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('user.Users')
@endsection

@section('heading')
    @lang('user.Users')
@endsection

@section('content')
    <div id="app">
        <vtable url="user/items/filter" :columns="columns" :filters="filters"></vtable>
    </div>

@endsection

@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [

                    {
                        "name": "name",
                        "title": "{{ trans('user.User') }}",
                        "sortField": "name",
                        "visible": true
                    }, {
                        "name": "email",
                        "title": "{{ trans('user.Email') }}",
                        "sortField": "Email",
                        "visible": true
                    }, {
                        "name": "department.name",
                        "title": "{{ trans('user.Department') }}",
                        "sortField": "department",
                        "visible": true
                    },

                    {
                        name: '__component:custom-actions',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    }
                ],
                filters: [

                ]

            },
            methods: {}
        });
    </script>
@endsection
