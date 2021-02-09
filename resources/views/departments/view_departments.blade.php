@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!}|@lang('department.View All Departments')
@endsection

@section('heading')

    {!! Helper::translateAndShorten('Departments And Budgets','department',50)!!}

@endsection

@section('content')
    <div id="app">
        <vtable url="department/items/filter" :columns="columns" :filters="filters"></vtable>
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
                    "title": "{{ trans('department.User') }}",
                    "sortField": "name",
                    "visible": true
                }, {
                    "name": "budgetLimit",
                    "title": "{{ trans('department.Limit') }}",
                    "sortField": "Limit",
                    "visible": true
                }, {
                    "name": "dispatchCount",
                    "title": "{{ trans('department.Dispatch Count') }}",
                    "sortField": "department",
                    "visible": true
                }, {
                    "name": "dispatchSum",
                    "title": "{{ trans('department.Dispatch Sum') }}",
                    "sortField": "dispatchSum",
                    "visible": true
                }, {
                    "name": "departmentEmail",
                    "title": "{{ trans('department.Department Email') }}",
                    "sortField": "departmentEmail",
                    "visible": true
                }, {
                    "name": "budgetStartDate",
                    "title": "{{ trans('department.Budget Start Date') }}",
                    "sortField": "budgetStartDate",
                    "visible": true
                },{
                    "name": "budgetEndDate",
                    "title": "{{ trans('department.Budget Start Date') }}",
                    "sortField": "budgetEndDate",
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
