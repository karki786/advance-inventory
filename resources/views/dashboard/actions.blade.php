<div class="row">
    <!-- Low Stock Items -->
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
               class="small-box-footer"> {!! \App\Helper::translateAndShorten('More info','dashboard',20)!!} <i
                        class="fa fa-arrow-circle-right"></i></a>
        </div>
        <!-- Low Stock items -->

        <!--Papers-->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    {{number_format($stockWorth)}}
                </h3>

                <p> {!! \App\Helper::translateAndShorten('Stock Worth','dashboard',20)!!}</p>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
            <a href="{{url('setting/'.Auth::user()->id.'/edit')}}"
               class="small-box-footer"> {!! \App\Helper::translateAndShorten('Stock Worth','dashboard',20)!!} <i
                        class="fa fa-arrow-circle-right"></i></a>
        </div>
        <!--Papers-->
        <!--Dispatches Per Month -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    {{number_format($dispatchCount)}}
                </h3>

                <p> {!! \App\Helper::translateAndShorten('Dispatched Products so far','dashboard',20)!!}</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="{{url('dispatch')}}"
               class="small-box-footer"> {!! \App\Helper::translateAndShorten('View Dispatches','dashboard',20)!!} <i
                        class="fa fa-arrow-circle-right"></i></a>
        </div>

    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"> {!! \App\Helper::translateAndShorten('Warehouse Utilization','dashboard',50)!!}</h3>

                <div class="box-tools pull-right">
                    <button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                    <button data-widget="remove" class="btn btn-box-tool"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-responsive">
                            <div class="warehouse"></div>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>


                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>

            <!-- /.footer -->
        </div>
    </div>
</div><!-- /.row -->
