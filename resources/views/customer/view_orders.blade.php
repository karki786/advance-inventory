@extends('layouts.frontend.master')

@section('title')
    {!!env('COMPANY_NAME')!!} | @lang('customer.View Quotations')
@endsection

@section('sidebar')

@endsection

@section('content')
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12 gutter">
            <div class="sales report">
                <div class="row">
                    <div class="col-md-6">
                        <h2>@lang('customer.View Quotations')</h2>
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
                        <th>@lang('customer.Raised By')</th>
                        <th>@lang('customer.Due Date')</th>
                        <th>@lang('customer.Amount')</th>
                        <th>@lang('customer.View')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($orders as $order)
                        @if($order->approved == 1 || $order->invoiced == 1)
                            <tr class="success">
                        @else
                            <tr class="">
                                @endif
                                <th scope="row">{{$i}}</th>
                                <td>{{$order->orderNo}}</td>
                                <td>{{$order->salesPersonText}}</td>
                                <td>{{$order->dueDate}}</td>
                                <td>{{number_format($order->items->sum('total')+$order->items->sum('tax'),2)}}</td>
                                <td>
                                    <a href="{{action('CustomerFrontendController@viewQuotation',$order->orderNo)}}"
                                       class="btn btn-flat bg-green"><i class="fa fa-dot-circle-o"></i> @lang('customer.View Quotation')</a>

                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach

                    </tbody>
                </table>
                <div class="text-center">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@endsection