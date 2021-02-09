@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('salesorder.View Sales Orders')
@endsection

@section('heading')
    @lang('salesorder.Sales Orders')
@endsection

@section('content')

    <div class="text-center">
        <div id="app">
            <vtable url="sales/items/filter" :columns="columns" :filters="filters"></vtable>
        </div>
@endsection

@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [

                    {
                        "name":"orderNo",
                        "title":"{{ trans('salesorder.Order No') }}",
                        "sortField":"orderNo",
                        "visible":true
                    },
                    {
                        "name":"customerName",
                        "title":"{{ trans('salesorder.Customer') }}",
                        "sortField":"customerNames",
                        "visible":true
                    },
                    {
                        "name":"contactName",
                        "title":"{{ trans('salesorder.Contact Person') }}",
                        "sortField":"contactName",
                        "visible":false
                    },

                    {
                        "name":"hold",
                        "title":"{{ trans('salesorder.On Hold') }}",
                        "sortField":"hold",
                        "visible":true
                    },
                    {
                        "name":"salesPersonText",
                        "title":"{{ trans('salesorder.Sales Person') }}",
                        "sortField":"salesPersonText",
                        "visible":true
                    },
                    {
                        "name":"currencyTypeText",
                        "title":"{{ trans('salesorder.Currency Type') }}",
                        "sortField":"currencyTypeText",
                        "visible":true
                    },
                    {
                        "name":"paymentMethod",
                        "title":"{{ trans('salesorder.Payment Method') }}",
                        "sortField":"paymentMethod",
                        "visible":true
                    },
                    {
                        "name":"paymentTerms",
                        "title":"{{ trans('salesorder.Payment Terms') }}",
                        "sortField":"paymentTerms",
                        "visible":false
                    },
                    {
                        "name":"total",
                        "title":"{{ trans('salesorder.Total')}}",
                        "sortField":"total",
                        "visible":true
                    },

                    {
                        "name":"isApproved",
                        "title":"{{ trans('salesorder.Approved')}}",
                        "sortField":"isApproved",
                        "visible":false
                    },
                    {
                        "name":"isInvoiced",
                        "title":"{{ trans('salesorder.Invoiced') }}",
                        "sortField":"isInvoiced",
                        "visible":true
                    },
                    {
                        "name":"isDelivered",
                        "title":"{{ trans('salesorder.Delivered') }}",
                        "sortField":"isDelivered",
                        "visible":false
                    },
                    {
                        "name":"remarks",
                        "title":"{{ trans('salesorder.Remarks') }}",
                        "sortField":"remarks",
                        "visible":false
                    },

                    {
                        "name":"updatedBy",
                        "title":"updatedBy",
                        "sortField":"updatedBy",
                        "visible":false
                    },
                    {
                        "name":"createdBy",
                        "title":"createdBy",
                        "sortField":"createdBy",
                        "visible":false
                    },
                    {
                        "name":"hash",
                        "title":"hash",
                        "sortField":"hash",
                        "visible":false
                    },
                    {
                        "name":"deleted_at",
                        "title":"deleted_at",
                        "sortField":"deleted_at",
                        "visible":false
                    },
                    {
                        "name":"created_at",
                        "title":"created_at",
                        "sortField":"created_at",
                        "visible":false
                    },
                    {
                        "name":"updated_at",
                        "title":"updated_at",
                        "sortField":"updated_at",
                        "visible":false
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
                        scope: 'trash',
                        text: 'View Deleted Items',
                        icon: 'fa fa-trash',
                        color: 'bg-purple'
                    },
                    {
                        scope: 'low',
                        text: 'View Low Stock',
                        icon: 'fa fa-minus-circle',
                        color: 'bg-red'
                    }
                ]

            },
            methods: {}
        });
    </script>
@endsection