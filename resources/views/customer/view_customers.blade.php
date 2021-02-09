@extends('layouts.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('customer.View Customers')
@endsection

@section('heading')
    @lang('customer.Customers and Their Stats')
@endsection

@section('content')

    <div id="app">

        <vtable url="customer/items/filter" :columns="columns" :filters="filters"></vtable>

    </div>

@endsection

@section('jquery')
    <script>

        new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        "name":"companyName",
                        "title":"{{ trans('customer.Company Name') }}",
                        "sortField":"companyName",
                        "visible":true
                    },
                    {
                        "name":"quotes",
                        "title":"{{ trans('customer.Quote') }}",
                        "sortField":"quotes",
                        "visible":true
                    },
                    {
                        "name":"invoices",
                        "title":"{{ trans('customer.Invoices') }}",
                        "sortField":"invoices",
                        "visible":true
                    },
                    {
                        "name":"paymentsMade",
                        "title":"{{ trans('customer.Payment') }}",
                        "sortField":"payments",
                        "visible":true
                    },
                    {
                        "name":"due",
                        "title":"{{ trans('customer.Due Amount') }}",
                        "sortField":"Due Amount",
                        "visible":true
                    },
                    {
                        "name":"companyEmail",
                        "title":"{{ trans('customer.Email') }}",
                        "sortField":"companyEmail",
                        "visible":true
                    },
                    {
                        "name":"companyCurrency",
                        "title":"{{ trans('customer.Currency') }}",
                        "sortField":"companyCurrency",
                        "visible":true
                    },

                    {
                        "name":"customerType",
                        "title":"{{ trans('customer.Customer Type') }}",
                        "sortField":"customerType",
                        "visible":true
                    },
                    {
                        "name":"statement",
                        "title":"{{ trans('customer.Statement') }}",
                        "sortField":"statement",
                        "visible":true
                    },
                    {
                        "name":"country",
                        "title":"{{ trans('customer.Country') }}",
                        "sortField":"country",
                        "visible":false
                    },
                    {
                        "name":"creditLimit",
                        "title":"{{ trans('customer.Credit Limit') }}",
                        "sortField":"creditLimit",
                        "visible":false
                    },
                    {
                        "name":"days",
                        "title":"{{ trans('customer.Credit Days') }}",
                        "sortField":"days",
                        "visible":false
                    },
                    {
                        "name":"discount",
                        "title":"{{ trans('customer.discount') }}",
                        "sortField":"Discount",
                        "visible":false
                    },
                    {
                        "name":"active",
                        "title":"{{ trans('customer.Active') }}",
                        "sortField":"active",
                        "visible":false
                    },
                    {
                        "name":"disableReason",
                        "title":"{{ trans('customer.Disable Reason') }}",
                        "sortField":"disableReason",
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

                ]

            },
            methods: {}
        });
    </script>
@endsection