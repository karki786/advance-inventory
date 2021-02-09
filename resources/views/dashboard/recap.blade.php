<div class="row">
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
            <a href="{{url('product')}}" class="small-box-footer"> {!! \App\Helper::translateAndShorten('More info','dashboard',20)!!} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$userCount}}</h3>

                <p> {!! \App\Helper::translateAndShorten('Users','dashboard',20)!!}</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{url('user')}}" class="small-box-footer">{!! \App\Helper::translateAndShorten('More info','dashboard',20)!!} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-md-3">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$departmentCount}}</h3>

                <p> {!! \App\Helper::translateAndShorten('Departments','dashboard',20)!!}</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{url('department')}}" class="small-box-footer">{!! \App\Helper::translateAndShorten('More info','dashboard',20)!!} <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="{{url('supplier')}}" class="small-box-footer">{!! \App\Helper::translateAndShorten('More info','dashboard',20)!!} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- /.col -->
</div><!-- /.row -->