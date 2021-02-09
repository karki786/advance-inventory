@extends('layouts.frontend.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('customer.View Invoice') {{$invoice->invoiceNo}}
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
            /* font-size: 1.2em;*/
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
    <h1>Invoice Details</h1>
    <div class="col-md-12 col-sm-12 col-xs-12 gutter">
        <div class="sales">
            <div class="text-center" style="margin: 0 auto; text-align: center;">

                <div class="btn-group text-center" role="group" aria-label="...">

                    @if($invoice->salesOrderId != null)
                        <a href="{{action('SalesOrderController@show',$invoice->salesOrderId)}}"
                           class="btn btn-flat bg-blue"><i
                                    class="fa fa-eye"></i> @lang('customer.View Quote')</a>
                    @endif
                    <a href="{{action('CustomerFrontendController@viewInvoice', array('invoiceNumber'=>$invoice->invoiceNo))}}?download=true"
                       class="btn btn-flat bg-yellow"><i
                                class="fa fa-download"></i> @lang('customer.Download')</a>
                    @if($invoice->paid == 0)
                        <a href="{{action('CustomerFrontendController@payInvoice', array('invoiceNumber'=>$invoice->invoiceNo))}}"
                           class="btn btn-flat bg-green "><i
                                    class="fa fa-paypal"></i> @lang('customer.Pay Invoice')</a>
                    @endif
                </div>
                <br/>
                <div class="">
                    <h1> @lang('customer.Amount Paid so far') : <span
                                class="badge">{{number_format($invoice->payment->sum('paymentAmount'),2)}}</span> left
                        with
                        <span class="badge">{{number_format(($invoice->items->sum('total')+$invoice->items->sum('tax'))-$invoice->payment->sum('paymentAmount'),2)}}</span>
                    </h1>
                </div>
            </div>
            <hr/>
            @if(Session::has('card-error'))
                <p class="alert alert-error"> Could not make the above payment our Payment Processor returned the
                    following error {{ Session::get('card-error') }}</p>
            @endif
            @if(Session::has('card-successful'))
                <p class="alert alert-success">  {{ Session::get('card-successful') }}</p>
            @endif
            <div class="quote">
                <div id="details" class="clearfix">
                    <div id="client">
                        <div class="to">@lang('customer.Quote TO'):</div>
                        <h2 class="name">{{$invoice->customerText}}</h2>
                        <div class="address">{{$invoice->present()->contact}}, {{$invoice->present()->street}}
                            , {{$invoice->present()->country}}</div>
                        <div class="email"><a
                                    href="mailto:{{$invoice->present()->email}}">{{$invoice->present()->email}}</a>
                        </div>
                    </div>
                    <div id="invoice">
                        <h1>{{$invoice->invoiceNo}}</h1>
                        <div class="date">@lang('customer.Invoice Date'): {{$invoice->invoiceDate}}</div>
                        <div class="date">@lang('customer.Due Date'): {{$invoice->dueDate}}</div>
                        <div class="date">@lang('customer.All Cost in'): <b>{{$invoice->currencyTypeText}}</b></div>
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
                            <td class="desc">{{$item->productDescription}}</td>
                            <td class="unit">{{number_format($item->convertedPrice,2)}}</td>
                            <td class="qty">{{$item->qty-$item->returned}}</td>
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
                        <td>{{number_format($invoice->items->sum('convertedPrice'),2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">@lang('customer.TAX')</td>
                        <td> {{number_format($invoice->items->sum('tax'),2)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">@lang('customer.GRAND TOTAL')</td>
                        <td>{{number_format($invoice->items->sum('total')+$invoice->items->sum('tax'),2)}}</td>
                    </tr>
                    </tfoot>

                </table>
                <div id="thanks">@lang('customer.Thank you!')</div>
                <div id="notices">
                    <div>@lang('customer.NOTICE'):</div>
                    <div class="notice">{{$invoice->present()->paymentTerms}}</div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection