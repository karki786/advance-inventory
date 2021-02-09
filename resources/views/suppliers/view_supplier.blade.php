@extends('layouts.master')

@section('title')
   {!! env('COMPANY_NAME') !!} | @lang('supplier.View Supplier')
@endsection

@section('heading')
    @lang('supplier.View Supplier')
@endsection
<style>
    .box-header > .box-tools {
        top: -2px !important;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="box box-info delivery-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('supplier.Deliveries')</h3>

                    <div class="box-tools pull-right">
                        <ul class="nav nav-pills ranges deliveries">
                            <li><a class="filter" href="#" data-range='DAY'><i class="fa fa-filter"></i> Day</a></li>

                            <li><a class="filter" href="#" data-range='WEEK'><i class="fa fa-filter"></i> Week</a>
                            </li>
                            <li><a class="filter" href="#" data-range='WEEKDAY'><i class="fa fa-filter"></i> WeekDay</a>
                            </li>
                            <li><a class="filter" href="#" data-range='MONTH'><i class="fa fa-filter"></i> Month</a>
                            </li>
                            <li><a class="filter" href="#" data-range='YEAR'><i class="fa fa-filter"></i> Year</a></li>
                        </ul>

                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="restocks" id="deliveries"></div>
                    <hr/>
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>@lang('supplier.Product Name')</th>
                            <th>@lang('supplier.Restock Date')</th>
                            <th>@lang('supplier.Amount')</th>
                            <th>@lang('supplier.Price')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($supplier->restocks->take(5) as $restock)
                            <tr class="">
                                <td>{{$supplier->present()->getSupplierProduct}}</td>
                                <td>{{ucwords($restock->created_at)}}</td>
                                <td>{{ucwords($restock->amount)}}</td>
                                <td>{{ucwords($restock->unitCost)}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-file-excel-o"></i> Excel
                        Report</a></a>
                    <a href="" class="btn btn-sm btn-default btn-flat pull-right"><i class="fa fa-file-pdf-o"></i> PDF
                        Report</a></a>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="box box-info time-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('supplier.Delivery Time')</h3>

                    <div class="box-tools pull-right">
                        <ul class="nav nav-pills ranges deliverytimes">
                            <li><a class="filter" href="#" data-range='DAY'><i class="fa fa-filter"></i> Day</a></li>

                            <li><a class="filter" href="#" data-range='WEEK'><i class="fa fa-filter"></i> Week</a>
                            </li>
                            <li><a class="filter" href="#" data-range='WEEKDAY'><i class="fa fa-filter"></i> WeekDay</a>
                            </li>
                            <li><a class="filter" href="#" data-range='MONTH'><i class="fa fa-filter"></i> Month</a>
                            </li>
                            <li><a class="filter" href="#" data-range='YEAR'><i class="fa fa-filter"></i> Year</a></li>
                        </ul>

                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="restocks" id="deliverytime"></div>
                    <hr/>
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>@lang('supplier.LPO Number')</th>
                            <th>@lang('supplier.LPO Date')</th>
                            <th>@lang('supplier.Delivered')</th>
                            <th>@lang('supplier.Delivery Time')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($supplier->orders->take(5) as $lpo)
                            <tr class="">
                                <td>{{$lpo->lpoNumber}}</td>
                                <td>{{ucwords($lpo->lpoDate)}}</td>
                                <td>{{$lpo->present()->lpoStatus}}</td>
                                <td>{{$lpo->present()->getDeliveryTime}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@section('js')

@endsection
@section('jquery')
    <script>
        $(function () {
            var table = $('table').DataTable({
                responsive: true,
                "lengthMenu": [[1, 2, 4, 8, -1], [1, 2, 4, 8, "All"]],
                "pageLength": 1

            });


            function requestData(period, chart) {
                $(".dispatch-box").notify(
                        "Updating Chart",
                        {
                            className: 'info',
                            autoHideDelay: 5000,
                            position: "top center"
                        }
                );
                $.ajax({
                            type: "GET",
                            url: "{{url('report/supplier/delivery')}}", // This is the URL to the API
                            data: {id: '{{$supplier->id}}', reportPeriod: period}
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data
                            $(".dispatch-box").notify(
                                    "Chart Updated",
                                    {
                                        className: 'success',
                                        autoHideDelay: 5000,
                                        position: "top center"
                                    }
                            );
                            chart.setData(data);
                            chart.options.labels = [];
                            $.each(data, function (i, item) {
                                chart.options.labels.push(item.productName);
                            })
                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            alert("error occured");
                        });
            }

            function requestRestockData(period, chart) {
                $(".time-box").notify(
                        "Updating Chart",
                        {
                            className: 'info',
                            autoHideDelay: 5000,
                            position: "top center"
                        }
                );
                $.ajax({
                            type: "GET",
                            url: "{{url('report/supplier/deliveryTime')}}", // This is the URL to the API
                            data: {id: '{{$supplier->id}}', reportPeriod: period}
                        })
                        .done(function (data) {
                            // When the response to the AJAX request comes back render the chart with new data
                            $(".time-box").notify(
                                    "Chart Updated",
                                    {
                                        className: 'success',
                                        autoHideDelay: 5000,
                                        position: "top center"
                                    }
                            );
                            chart.setData(data);
                        })
                        .fail(function () {
                            // If there is no communication between the server, show an error
                            alert("error occured");
                        });
            }

            var chart = Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'deliveries',
                // Set initial data (ideally you would provide an array of default data)
                data: [0, 0],
                xkey: 'month',
                barColors: ["#9b2626"],
                ykeys: ['restockcount'],
                labels: ['Dispatches']
            });

            var chart2 = Morris.Bar({
                // ID of the element in which to draw the chart.
                element: 'deliverytime',
                // Set initial data (ideally you would provide an array of default data)
                data: [0, 0],
                xkey: 'lpoNumber',
                barColors: ["#2def63"],
                ykeys: ['days'],
                labels: ['Restocks']
            });
            // Request initial data for the past 7 days:
            requestData('MONTHNAME', chart);
            requestRestockData('MONTHNAME', chart2)

            $('ul.deliveries .filter').click(function (e) {
                e.preventDefault();
                // Get the number of days from the data attribute
                var el = $(this);
                days = el.attr('data-range');
                // Request the data and render the chart using our handy function
                requestData(days, chart);
                // Make things pretty to show which button/tab the user clicked
                el.parent().addClass('active');
                el.parent().siblings().removeClass('active');
            });


            $('ul.deliverytimes .filter').click(function (e) {
                e.preventDefault();
                // Get the number of days from the data attribute
                var el = $(this);
                days = el.attr('data-range');
                // Request the data and render the chart using our handy function
                requestRestockData(days, chart2);
                // Make things pretty to show which button/tab the user clicked
                el.parent().addClass('active');
                el.parent().siblings().removeClass('active');
            });

        });
    </script>
@endsection