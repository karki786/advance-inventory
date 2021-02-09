@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('warehouse.View Bin Locations')
@endsection

@section('heading')
    @lang('warehouse.View Bin Locations')
@endsection

@section('content')
    <div id="app">
        <vtable url="{{action('WarehouseController@tableDetails',array('id'=>$id))}}" v-on:collapse="collapse" v-on:expand="expand" :columns="columns" threshold="9" multi-sort=true :filters="filters"></vtable>
    </div>
@endsection

@section('jquery')
    <script>
        var x = new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        "name": "whs",
                        "title": "{{ trans('warehouse.Warehouse') }}",
                        "sortField": "whs",
                        "visible": true
                    },
                    {
                        "name": "binCode",
                        "title": "{{ trans('warehouse.Bin Code') }}",
                        "sortField": "binCode",
                        "visible": true
                    },
                    {
                        "name": "binDescription",
                        "title": "{{ trans('warehouse.Description') }}",
                        "sortField": "binDescription",
                        "visible": true
                    },
                    {
                        "name": "binDisabled",
                        "title": "{{ trans('warehouse.Bin Disabled') }}",
                        "sortField": "binDisabled",
                        "visible": true
                    },
                    {
                        "name": "binBarcode",
                        "title": "{{ trans('warehouse.Barcode') }}",
                        "sortField": "binBarcode",
                        "visible": true
                    },
                    {
                        "name": "binMaxLevel",
                        "title": "{{ trans('warehouse.MaxLevel') }}",
                        "sortField": "binMaxLevel",
                        "visible": true
                    },
                    {
                        "name": "binMaxWeight",
                        "title": "{{ trans('warehouse.MaxWeight') }}",
                        "sortField": "binMaxWeight",
                        "visible": true
                    },
                    {
                        "name": "updatedBy",
                        "title": "updatedBy",
                        "sortField": "updatedBy",
                        "visible": false
                    },
                    {
                        "name": "createdBy",
                        "title": "createdBy",
                        "sortField": "createdBy",
                        "visible": false
                    },
                    {
                        "name": "hash",
                        "title": "hash",
                        "sortField": "hash",
                        "visible": false
                    },
                    {
                        "name": "deleted_at",
                        "title": "deleted_at",
                        "sortField": "deleted_at",
                        "visible": false
                    },
                    {
                        "name": "created_at",
                        "title": "created_at",
                        "sortField": "created_at",
                        "visible": false
                    },
                    {
                        "name": "updated_at",
                        "title": "updated_at",
                        "sortField": "updated_at",
                        "visible": false
                    },
                    {
                        name: '__component:custom-actions',
                        title: 'Actions',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
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