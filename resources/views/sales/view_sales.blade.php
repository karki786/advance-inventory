@extends('layouts.master')


@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('viewsales.View Sale')
@endsection

@section('content')
    <section class="content-header">
        <h1>
            @lang('viewsalesorders.Sales Orders')
            <small>@lang('viewsalesorders.Sales Orders Created')</small>
        </h1>

    </section>
    <hr/>
    <div class="text-center">

        <table class="table table-paper table-bordered ">

            <tbody>
            <tr>


            </tr>

            </tbody>
        </table>
    </div>
    <hr/>
    <div id="app">

        <vtable url="sales/items/filter" :columns="columns" :filters="filters"></vtable>

    </div>
    <table class="table table-paper table-condensed table-bordered sales">
        <thead>
        <tr>
            <th>#</th>
            <th>@lang('viewsalesorders.Order No')</th>
            <th>@lang('viewsalesorders.Customer')</th>
            <th>@lang('viewsalesorders.Sales Person')</th>
            <th>@lang('viewsalesorders.Currency')</th>
            <th>@lang('viewsalesorders.Payment Method')</th>
            <th>@lang('viewsalesorders.Total')</th>
            <th>@lang('viewsalesorders.Created On')</th>
            <th>@lang('viewsalesorders.Last Revised')</th>
            <th>@lang('viewsalesorders.Actions')</th>

        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($sales as $sale)
            <tr class="">
                <th scope="row">{{$i}}</th>
                <th>{{$sale->saleNo}}</th>
                <td>{{ucwords($sale->customerText)}}</td>
                <td>{{$sale->salesPersonText}}</td>
                <td>{{$sale->currencyTypeText}} </td>
                <td>{{$sale->present()->paymentMethod}}</td>
                <td>{{number_format($sale->items->sum('total'),2)}}</td>
                <td>{{Carbon::parse($sale->created_at)->format('d/m/Y')}} </td>
                <td>{{Carbon::parse($sale->updated_at)->format('d/m/Y')}} </td>
                <td>
                    <div aria-label="Actions" role="group" class="btn-group">
                        @if(isset($restore))
                            <a href="{{action('SalesOrderController@restore', $sale->id)}}"
                               class="btn btn-flat bg-purple"><i
                                        class="fa fa-undo"></i></a>
                        @else
                            <a href="#delete-popup" class="open-popup-link btn btn-flat bg-red delete-button"
                               data-url="{{action('SalesOrderController@destroy', $sale->id)}}"><i
                                        class="fa fa-remove"></i></a>
                            <a class="btn btn-flat bg-green" href="{{action('SalesOrderController@edit', $sale->id)}}">
                                <i
                                        class="   fa fa-edit"></i></a>
                            <a class="btn btn-flat bg-yellow"
                               href="{{action('SalesOrderController@show', $sale->id)}}"> <i
                                        class="   fa fa-eye"></i></a>
                            <a class="btn btn-flat bg-purple"
                               href="{{action('InvoiceController@create', array('order'=>$sale->id))}}"> <i
                                        class="   fa fa-credit-card"></i></a>
                        @endif
                    </div>
                </td>
                <?php $i++; ?>
            </tr>
        @endforeach

        </tbody>
    </table>



@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [
                    {
                        name: 'orderNo',
                        title: 'Order No',
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