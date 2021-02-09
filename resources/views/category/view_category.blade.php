@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('category.View Category')
@endsection

@section('sidebar')

@endsection
@section('heading')
    @lang('auth.View Product Category Details')
@endsection
@section('content')
    <div id="app">
        <vtable url="{{action('ProductController@table',array('id'=>$id,'scope'=>array('category',$id)))}}"
                :columns="columns"
                :filters="filters"></vtable>
    </div>
@endsection

@section('jquery')
    <script>
        var x = new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'categoryName',
                        title: 'Category',
                        sortField: 'categoryName',
                        visible: true
                    },
                    {
                        name: 'hash',
                        title: 'hash',
                        visible: false
                    },
                    {
                        name: 'productName',
                        title: 'Product Name',
                        sortField: 'productName',
                        visible: true
                    }, {
                        name: 'location',
                        title: 'Location',
                        sortField: 'location',
                        visible: true
                    }, {
                        name: 'productSerial',
                        title: 'Serial',
                        sortField: 'productSerial',
                        visible: true
                    }, {
                        name: 'unitCost',
                        title: 'Unit Cost',
                        sortField: 'unitCost',
                        visible: true
                    }, {
                        name: 'totalCost',
                        title: 'Total Cost',
                        sortField: 'totalCost',
                        visible: true
                    }, {
                        name: 'amount',
                        title: 'Amount',
                        sortField: 'amount',
                        visible: true
                    }, {
                        name: 'reorderAmount',
                        title: 'Reorder Amount',
                        sortField: 'reorderAmount',
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
                        scope: 'trash',
                        text: 'View Deleted Items',
                        icon: 'fa fa-trash',
                        color: 'bg-purple'
                    },

                    {
                        scope: 'latest',
                        text: 'Latest Products',
                        icon: 'fa fa-clock-o',
                        color: 'bg-red'
                    },
                    {
                        scope: 'lastupdate',
                        text: 'Last Updated',
                        icon: 'fa fa-clock-o',
                        color: 'bg-red'
                    },
                    {
                        scope: 'today',
                        text: 'Created Today',
                        icon: 'fa fa-clock-o',
                        color: 'bg-red'
                    },
                    {
                        scope: 'week',
                        text: 'Past Week',
                        icon: 'fa fa-calendar',
                        color: 'bg-red'
                    },
                    {
                        scope: 'month',
                        text: 'Past Month',
                        icon: 'fa fa-calendar',
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