@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!}|@lang('dispatch.Dispatch Items From Stock')
@endsection
@section('heading')
    @lang('dispatch.Dispatches')
@endsection
@section('content')
    <div id="app">
        <vtable url="{{action('DispatchController@table')}}" :columns="columns" :filters="filters"></vtable>
    </div>

@endsection


@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'productName',
                        title: "{{ trans('dispatch.Product Name') }}",
                        visible: true
                    }, {
                        name: 'amount',
                        title: '{{ trans('dispatch.Amount') }}',
                        visible: true
                    }, {
                        name: 'category',
                        title: "{{ trans('dispatch.Category') }}",
                        visible: true
                    }, {
                        name: 'user',
                        title: "{{ trans('dispatch.Dispatched To') }}",
                        visible: true
                    }, {
                        name: 'totalCost',
                        title: "{{ trans('dispatch.Total Cost') }}",
                        visible: true
                    }, {
                        name: 'warehouseName',
                        title: "{{ trans('dispatch.Warehouse') }}",
                        visible: true
                    }, {
                        name: 'bin',
                        title: "{{ trans('dispatch.Bin Location') }}",
                        visible: true
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
        })
    </script>
@endsection



