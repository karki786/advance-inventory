@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('payment.View Payments')
@endsection

@section('heading')
    @lang('payment.Invoice Payments')
@endsection

@section('content')
    <div id="app">
        <vtable url="payments/items/filter" :columns="columns" :filters="filters"></vtable>
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
                        "title": "{{ trans('payment.Invoice No') }}",
                        "sortField": "invoiceNo",
                        "visible": true
                    },
                    {
                        "name": "customer",
                        "title": "{{ trans('payment.Customer') }}",
                        "sortField": "customer",
                        "visible": true
                    },
                    {
                        "name": "paymentMethod",
                        "title": "{{ trans('payment.Payment Method') }}",
                        "sortField": "paymentMethod",
                        "visible": false
                    },
                    {
                        "name": "paymentNarration",
                        "title": "{{ trans('payment.Narration') }}",
                        "sortField": "paymentNarration",
                        "visible": true
                    },
                    {
                        "name": "total",
                        "title": "{{ trans('payment.Total') }}",
                        "sortField": "total",
                        "visible": true
                    },
                    {
                        "name": "paymentMethod",
                        "title": "{{ trans('payment.Payment Method') }}",
                        "sortField": "paymentMethod",
                        "visible": true
                    },
                    {
                        "name": "paymentTerms",
                        "title": "{{ trans('payment.Payment Terms') }}",
                        "sortField": "paymentTerms",
                        "visible": false
                    },
                    {
                        "name": "total",
                        "title": "{{ trans('payment.Total') }}",
                        "sortField": "total",
                        "visible": true
                    },

                    {
                        "name": "paymentRemarks",
                        "title": "{{ trans('payment.Remarks') }}",
                        "sortField": "paymentRemarks",
                        "visible": false
                    },
                    {
                        "name": "viewInvoice",
                        "title": "{{ trans('payment.View Invoice') }}",
                        "sortField": "viewInvoice",
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