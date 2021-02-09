<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img alt="User Image" class="img-circle" src="{{App\Helper::avatar()}}">
            </div>
            <div class="pull-left info">
                <p>{{Helper::getUser()->name}}</p>

                <a href="#"><i
                            class="fa fa-circle text-success"></i> {!! Helper::translateAndShorten('Online','sidebar',200)!!}
                    ({{Helper::getUser()->company->companyName}}
                    )</a>
            </div>
            @if(Helper::getUser()->role_id== 1)
                {!! Form::open(array('action' => 'UserController@postLogin', 'class'=>'form-sidebar ','onsubmit' => 'return postForm();', 'files'=>false)) !!}
                <div class="form-group{!! $errors->has('userid') ? ' has-error' : '' !!}">
                    {!! Form::label('userid',  trans('sidebar.Quick User Change') ) !!}
                    <div class="input-group">
                        {!! Form::select('userid',$users, Helper::getUser()->id, ['class' => 'choose-users form-control ']) !!}
                        <span class="input-group-btn">
                      <button class="btn btn-info btn-flat" type="submit">{{ trans('sidebar.Go') }}</button>
                    </span>
                    </div>
                    {!! $errors->first('userid', '<p class="help-block">:message</p>') !!}
                </div>
                {!! Form::close() !!}
            @endif
        </div>
        @if(Request::segment(1)!='home')
                <!-- search form -->
        <form class="sidebar-form" method="get" action="{{url(Request::segment(1))}}">
            <div class="input-group">
                <input type="text" placeholder="Search..." value="{{$search}}" class="form-control search-box"
                       name="search">
              <span class="input-group-btn">
                  @if($search)
                      <a class="btn btn-flat" href="{{url(Request::segment(1))}}" id="search-btn" type="submit"><i
                                  class="fa fa-remove"></i></a>
                  @else
                      <button class="btn btn-flat" id="search-btn" type="submit"><i class="fa fa-search"></i></button>
                  @endif

              </span>
            </div>
        </form>

        <div class="report-buttons text-center" style="">
            <div class="btn-group">
                <a class="btn btn-flat  bg-orange" href="{{url(Request::segment(1)."/stock/export?type=xlsx")}}"><i
                            class="fa fa-file-excel-o"></i> Excel</a>

                <a class="btn btn-flat  bg-purple" href="{{url(Request::segment(1)."/stock/export?type=csv")}}"><i
                            class="fa fa-file-pdf-o"></i> CSV</a>

                <div data-url="{{url(Request::segment(1)."/stock/export?type=email")}}"
                     class="btn btn-flat  bg-green email-popup-link send-email"><i class="fa fa-envelope"></i> Email
                </div>
            </div>
        </div>
        @endif
                <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header"> {!! Helper::translateAndShorten('MAIN NAVIGATION','sidebar',50)!!}</li>
            <li {{ HTML::current('home/*', 'home/*') }}>
                <a href="#">
                    <i class="fa fa-dashboard"></i>
                    <span> {!! Helper::translateAndShorten('Dashboard','sidebar',15)!!}</span> <i
                            class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li {{ HTML::current('home', 'home') }} ><a href="{{url('home')}}"><i
                                    class="fa fa-circle-o"></i>
                            {!! Helper::translateAndShorten('Dashboard','sidebar',15)!!}</a></li>
                    @if(env('ENABLEPRINTERS',true) == true)
                        <li {{ HTML::current('home2', 'home2') }} ><a href="{{url('home2')}}"><i
                                        class="fa fa-print"></i>
                                {!! Helper::translateAndShorten('Printer Dashboard','sidebar',15)!!}</a></li>
                    @endif

                </ul>
            </li>
            <li {{ HTML::current('irq/request/*', 'irq/request/*') }}>
                <a href="#">
                    <i class="fa fa-level-up"></i> <span>Your Requests </span> <i
                            class="fa fa-angle-left pull-right"></i>
                    <span class="label label-primary pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li {{ HTML::current('irq/request/view/products', 'irq/request/view/products') }}><a
                                href="{{url('irq/request/view/products')}}"><i
                                    class='fa fa-plus'></i> Products</a></li>
                    <li {{ HTML::current('irq/request/create', 'irq/request/create') }}><a
                                href="{{url('irq/request/create')}}"><i
                                    class='fa fa-plus'></i> New Requests</a></li>
                    <li {{ HTML::current('irq/request', 'irq/request') }}><a href="{{url('irq/request')}}"><i
                                    class='fa fa-users'></i>
                            View Requests</a></li>

                </ul>
            </li>

            <li {{ HTML::current('setting/'.Helper::getUser()->id.'/edit', 'setting/'.Helper::getUser()->id.'/edit') }}>
                <a
                        href="{{url('setting/'.Helper::getUser()->id.'/edit')}}" class="bg-purple"><i
                            class='fa fa-cog'></i> {!! Helper::translateAndShorten('Your Settings','sidebar',15)!!}
                </a></li>
        </ul>


    </section>
    <!-- /.sidebar -->
</aside>