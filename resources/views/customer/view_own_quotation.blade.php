@extends('layouts.frontend.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('customer.Quotation') {{$salesOrder->orderNo}}
@endsection

@section('content')
    <style>
        @font-face {
            font-family: SourceSansPro;
            /* src: url(SourceSansPro-Regular.ttf);*/
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: right;
            text-align: right;
        }

        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
            float: left;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total, table td.tax {
            /*  font-size: 1.2em;*/
        }

        table .tax {
            background: #DDDDDD;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        .quote {
            width: 90%;
            margin: 0 auto;
        }
    </style>
    <div class="col-md-12 col-sm-12 col-xs-12 gutter">
        <div class="sales">
            <div class="text-center">
                <div class="btn-group text-center" role="group" aria-label="...">
                    @if($salesOrder->approved != 1)
                        <a href="{{action('CustomerFrontendController@approveQuotation', array('order'=>$salesOrder->orderNo))}}"
                           class="btn btn-flat bg-green"><i class="fa fa-check"></i> @lang('customer.Approve Quotation')</a>
                    @endif
                    <a href="{{action('CustomerFrontendController@viewQuotation', array('orderNo'=>$salesOrder->orderNo))}}?download=true"
                       class="btn btn-flat bg-yellow"><i
                                class="fa fa-download"></i> @lang('customer.Download')</a>
                </div>
            </div>
            <hr/>
            @if(Session::has('approved'))
                <p class="alert alert-success">  {{ Session::get('approved') }}</p>
            @endif
            <div class="quote">
                <div id="details" class="clearfix">
                    <div id="client">
                        <div class="to">@lang('customer.Quote TO'):</div>
                        <h2 class="name">{{$salesOrder->customerText}}</h2>
                        <div class="address">{{$salesOrder->present()->contact}}, {{$salesOrder->present()->street}}
                            , {{$salesOrder->present()->country}}</div>
                        <div class="email"><a
                                    href="mailto:{{$salesOrder->present()->email}}">{{$salesOrder->present()->email}}</a>
                        </div>
                    </div>
                    <div id="invoice">
                        <h1>{{$salesOrder->orderNo}}</h1>
                        <div class="date">@lang('customer.Date of Quote'): {{$salesOrder->created_at}}</div>
                        <div class="date">@lang('customer.All Cost in'): <b>{{$salesOrder->currencyTypeText}}</b>
                        </div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th class="no">#</th>
                        <th class="desc">@lang('customer.DESCRIPTION')</th>
                        <th class="unit">@lang('customer.UNIT PRICE')</th>
                        <th class="qty">@lang('customer.QUANTITY')</th>
                        <th class="tax">@lang('customer.Tax')</th>
                        <th class="total">@lang('customer.TOTAL')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 1; ?>
                    @foreach($items as $item)
                        <tr>
                            <td class="no">{{$count}}</td>
                            <td class="desc">{{$item->productDescription}}
                            </td>
                            <td class="unit">{{number_format($item->convertedPrice,2)}}</td>
                            <td class="qty">{{$item->qty}}</td>
                            <td class="tax">{{number_format($item->tax,2)}}</td>
                            <td class="total">{{number_format(($item->total+$item->tax)*$item->qty,2)}}</td>
                            <?php $count++; ?>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">@lang('customer.SUBTOTAL')</td>
                        <td>{{number_format($salesOrder->items->sum('convertedPrice'),2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">@lang('customer.TAX')</td>
                        <td> {{number_format($salesOrder->items->sum('tax'),2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">@lang('customer.GRAND TOTAL')</td>
                        <td>{{number_format($salesOrder->items->sum('total')+$salesOrder->items->sum('tax'),2)}}</td>
                    </tr>
                    </tfoot>

                </table>
                <div id="thanks">@lang('customer.Thank you!')</div>
                <div id="notices">
                    <div>@lang('customer.NOTICE'):</div>
                    <div class="notice">{{$salesOrder->present()->paymentTerms}}</div>
                </div>


            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection