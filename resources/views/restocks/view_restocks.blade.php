@extends('layouts.master')

@section('title')
    @lang('restock.Restock Item in inventory')
@endsection

@section('heading')
    @lang('restocks.Restocks')
@endsection


@section('content')
    <div id="app">
        <vtable url="restock/filter/items" :columns="columns" :filters="filters"></vtable>

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
                        title: "{{ trans('restock.Product Name') }}",
                        visible:true
                    }, {
                        name: 'untCost',
                        title: "{{ trans('restock.Unit Cost') }}",
                        visible:true
                    }, {
                        name: 'itemCost',
                        title: "{{ trans('restock.Item Cost') }}",
                        visible:true
                    }, {
                        name: 'amount',
                        title: "{{ trans('restock.Amount') }}",
                        visible:true
                    }, {
                        name: 'warehouse.whsName',
                        title: "{{ trans('restock.Warehouse') }}",
                        visible:true
                    }, {
                        name: 'bin',
                        title: "{{ trans('restock.Location') }}",
                        visible:true
                    }, {
                        name: 'supplierName',
                        title: "{{ trans('restock.Supplier Name') }}",
                    },
                    {
                        name: '__component:custom-actions',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    }
                ],
                filters: []

            },
            methods: {}
        })
    </script>
@endsection
