@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('product.View All Items in inventory')
@endsection

@section('heading')
    @lang('product.Products')
@endsection
@section('content')

    <div id="app">

        <vtable url="products/items/filter" v-on:collapse="collapse" v-on:expand="expand" :columns="columns" threshold="9" multi-sort=true :filters="filters"></vtable>

    </div>







@endsection


@section('jquery')
    <script>
        var x = new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'hash',
                        title: 'hash',
                        visible: false
                    },
                    {
                        name: 'productName',
                        title: '{{ trans('product.Product Name') }}',
                        sortField: 'productName',
                        visible: true
                    }, {
                        name: 'image',
                        title: '{{ trans('product.Image') }}',
                        sortField: 'image',
                        visible: false
                    },{
                        name: 'location',
                        title: '{{ trans('product.Location') }}',
                        sortField: 'location',
                        visible: true
                    }, {
                        name: 'categoryName',
                        title: '{{ trans('product.Category') }}',
                        sortField: 'categoryName',
                        visible: true
                    }, {
                        name: 'productSerial',
                        title: '{{ trans('product.Product Serial Number') }}',
                        sortField: 'productSerial',
                        visible: true
                    }, {
                        name: 'unitCost',
                        title: '{{ trans('product.Unit Cost') }}',
                        sortField: 'unitCost',
                        visible: true
                    }, {
                        name: 'totalCost',
                        title: '{{ trans('product.Total Cost') }}',
                        sortField: 'totalCost',
                        visible: true
                    }, {
                        name: 'amount',
                        title: '{{trans('product.Amount')}}',
                        sortField: 'amount',
                        visible: true
                    }, {
                        name: 'reorderAmount',
                        title: '{{ trans('product.Reorder Amount') }}',
                        sortField: 'reorderAmount',
                        visible: true
                    },
                    {
                        name: '__component:custom-actions',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        visible: true
                    }
                ],
                filters: [
                    {
                        scope: 'low',
                        text: 'View Low Stock',
                        icon: 'fa fa-minus-circle',
                        color: 'bg-red'
                    },
                    {
                        scope: 'restocks',
                        text: 'Most Restocks',
                        icon: 'fa fa-calendar',
                        color: 'bg-red'
                    }
                ]

            },
            methods: {
                expand(){
                    $('body').removeClass('sidebar-collapse')
                },
                collapse(){
                    $('body').addClass('sidebar-collapse')
                }
            }
        })
    </script>
@endsection


