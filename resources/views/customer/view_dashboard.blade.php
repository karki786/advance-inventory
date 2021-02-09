@extends('layouts.frontend.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('customer.View Invoices')
@endsection

@section('sidebar')

@endsection

@section('content')
    <h1>Hello, {{$customer->companyName}}</h1>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12 gutter">
            <div class="sales report">
                <div class="row">
                    <div class="col-md-6">
                        <h2>@lang('customer.Your Recent Account Activity')</h2>
                    </div>
                    <div class="col-md-6 hidden">
                        <div class="btn-group l">
                            <button class="btn btn-secondary btn-lg dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>Period:</span> Last Year
                            </button>
                            <div class="dropdown-menu">
                                <a href="#">2012</a>
                                <a href="#">2014</a>
                                <a href="#">2015</a>
                                <a href="#">2016</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr/>
                <table class="table table-paper table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('customer.Invoice Number')</th>
                        <th>@lang('customer.Invoice Date')</th>
                        <th>@lang('customer.Due Date')</th>
                        <th>@lang('customer.Amount')</th>
                        <th>@lang('customer.View')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($invoices as $invoice)
                        @if($invoice->paid == 1)
                            <tr class="success">
                        @elseif($invoice->dueDate < Carbon\Carbon::today() && $invoice->paid == 0 )
                            <tr class="danger">
                        @else
                            <tr class="info">
                                @endif
                                <th scope="row">{{$i}}</th>
                                <td>{{$invoice->invoiceNo}}</td>
                                <td>{{$invoice->invoiceDate}}</td>
                                <td>{{$invoice->dueDate}}</td>
                                <td>{{number_format($invoice->items->sum('total')+$invoice->items->sum('tax'),2)}}</td>
                                <td>
                                    <a href="{{action('CustomerFrontendController@viewInvoice',$invoice->invoiceNo)}}"
                                       class="btn btn-flat bg-green"><i class="fa fa-dot-circle-o"></i> View Invoice</a>

                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach

                    </tbody>
                </table>
                <div class="text-center">{{ $invoices->links() }}</div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection