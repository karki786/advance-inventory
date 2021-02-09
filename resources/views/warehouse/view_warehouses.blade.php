@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!}|@lang('warehouse.Warehouses')
@endsection

@section('sidebar')

@endsection
@section('heading')
    @lang('warehouse.View Warehouses and Products Stocked in them')
@endsection
@section('content')
    <div id="app">
        <vtable url="api/warehouses" :columns="columns" :filters="filters"></vtable>
    </div>
@endsection

@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {

                columns: [
                    {
                        name: 'whsName',
                        title: "{{ trans('warehouse.Warehouse Name') }}",
                        visible:true
                    }, {
                        name: 'whsBuilding',
                        title: "{{ trans('warehouse.Warehouse Building') }}",
                        visible:true
                    }, {
                        name: 'viewProducts',
                        title: "{{ trans('warehouse.Products in warehouse') }}",
                        visible:true
                    }, {
                        name: 'whsState',
                        title: "{{ trans('warehouse.Warehouse State') }}",
                        visible:true
                    }, {
                        name: 'addBin',
                        title: "{{ trans('warehouse.Add A bin Location') }}",
                        visible:true
                    }, {
                        name: 'viewBin',
                        title: "{{ trans('warehouse.View Bin Locations') }}",
                        visible:true
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