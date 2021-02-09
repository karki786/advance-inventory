@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('dashboard.Dashboard')
@endsection


@section('content')
    <div id="app">
        <div class="row">
            <div class="col-md-12">



                    <div class="col-md-3">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{$productCount}}</h3>

                                <p> {!! \App\Helper::translateAndShorten('Products','dashboard',20)!!}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <a href="{{url('product')}}"
                               class="small-box-footer"> {!! \App\Helper::translateAndShorten('More info','dashboard',20)!!}
                                <i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                <div class="col-md-3">
                    <!-- small box -->
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3>{{$userCount}}</h3>

                            <p> {!! \App\Helper::translateAndShorten('Users','dashboard',20)!!}</p>
                        </div>
                        <div class="icon" style="top: 0 !important;">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="{{url('user')}}" class="small-box-footer">{!! \App\Helper::translateAndShorten('More info','dashboard',20)!!} <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>


                    <div class="col-md-3">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{$lowStock}}</h3>

                                <p> {!! \App\Helper::translateAndShorten('Out of stock Items','dashboard',20)!!}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <a href="{{url('product/stock/warning')}}"
                               class="small-box-footer"> {!! \App\Helper::translateAndShorten('More info','dashboard',20)!!}
                                <i
                                        class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{$supplierCount}}</h3>

                                <p> {!! \App\Helper::translateAndShorten('Suppliers','dashboard',20)!!}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-truck"></i>
                            </div>
                            <a href="{{url('supplier')}}"
                               class="small-box-footer">{!! \App\Helper::translateAndShorten('More info','dashboard',20)!!}
                                <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="canvas-holder">
                    <div class="panel panel-default cls-panel">


                        <div class="panel-body">
                            <chartjs-pie :height="200" :labels="['Paid Invoices','UnPaid Invoices']"
                                         :data="[{!! $paidInvoices->sum('amount') !!},{!! $unPaidInvoices->sum('amount') !!}]"></chartjs-pie>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div id="canvas-holder">
                    <div class="panel panel-default cls-panel">


                        <div class="panel-body">

                            <chartjs-pie :datalabel="'TestDataLabel'" :height="200"
                                         :labels="{{ $topFiveCustomers->pluck('companyName') }}"
                                         :data={!! $topFiveCustomers->pluck('amount') !!}></chartjs-pie>

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="panel panel-default cls-panel">
            <div class="panel-body">
                <canvas id="mix4" count="1"></canvas>
            </div>
        </div>

        <chartjs-bar target="mix4" :datalabel="'Past Month Cash Inflow'" :datalabel="'TestDataLabel'"
                     :labels={!! json_encode($paidGroupInvoices->pluck('month')) !!} :data="{!! json_encode($paidGroupInvoices->pluck('amount')) !!}"
                     backgroundcolor="rgba(75,0,192,0.6)"></chartjs-bar>


    </div>


@endsection

@section('jquery')

    <script>
        new Vue({
            el: '#app',
            data: {
                mylabel: 'TestDataLabel',
                mylabels: ['happy', 'myhappy', 'hello'],
                mydata: [100, 40, 60]
            },
            methods: {}
        });
    </script>

@endsection