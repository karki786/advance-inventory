@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('invoice.View Invoices')
@endsection
@section('heading')
    @lang('invoice.Invoices')
@endsection
@section('content')
    <div id="app">

        <vtable url="invoice/items/filter" :columns="columns" :filters="filters"></vtable>

    </div>
@endsection

@section('jquery')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [

                    {
                        "name": "invoiceNo",
                        "title": "{{ trans('invoice.Invoice No') }}",
                        "sortField": "invoiceNo",
                        "visible": true
                    },
                    {
                        "name": "customerName",
                        "title": "{{ trans('invoice.Customer') }}",
                        "sortField": "customerNames",
                        "visible": true
                    },
                    {
                        "name": "contactName",
                        "title": "{{ trans('invoice.Contact Person') }}",
                        "sortField": "contactName",
                        "visible": false
                    },
                    {
                        "name": "salesPersonText",
                        "title": "{{ trans('invoice.Sales Person') }}",
                        "sortField": "salesPersonText",
                        "visible": true
                    },
                    {
                        "name": "currencyTypeText",
                        "title": "{{ trans('invoice.Currency Type') }}",
                        "sortField": "currencyTypeText",
                        "visible": true
                    },
                    {
                        "name": "paymentMethod",
                        "title": "{{ trans('invoice.Payment Method') }}",
                        "sortField": "paymentMethod",
                        "visible": true
                    },
                    {
                        "name": "paymentTerms",
                        "title": "{{ trans('invoice.Payment Terms') }}",
                        "sortField": "paymentTerms",
                        "visible": false
                    },
                    {
                        "name": "total",
                        "title": "{{ trans('invoice.Total') }}",
                        "sortField": "total",
                        "visible": true
                    },

                    {
                        "name": "isApproved",
                        "title": "{{ trans('invoice.Approved') }}",
                        "sortField": "isApproved",
                        "visible": false
                    },
                    {
                        "name": "isPaid",
                        "title": "{{ trans('invoice.Settled?') }}",
                        "sortField": "isPaid",
                        "visible": true
                    },
                    {
                        "name": "isDelivered",
                        "title": "{{ trans('invoice.Delivered') }}",
                        "sortField": "isDelivered",
                        "visible": false
                    },
                    {
                        "name": "remarks",
                        "title": "{{ trans('invoice.Remarks') }}",
                        "sortField": "remarks",
                        "visible": false
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

                ]

            },
            methods: {}
        });
    </script>
@endsection