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
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header"> {!! Helper::translateAndShorten('MAIN NAVIGATION','sidebar',50)!!}</li>
           
            @if(($homepage))
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

                    </ul>
                </li>
            @endif
        <!-- Products-->

            @can('glance', \App\Product::class)
                <li {{ HTML::current('product/*', 'product/*') }}>
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span>{!! Helper::translateAndShorten('Products','sidebar',15)!!} </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!--   <span class="label label-primary pull-right">@{{products }} </span> -->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('product/create', 'product/create') }} ><a
                                    href="{{url('/product/create')}}"><i
                                        class='fa fa-plus'></i> {!! Helper::translateAndShorten('Add Product','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('product', 'product') }}><a href="{{url('product')}}"><i
                                        class='fa fa-archive'></i> {!! Helper::translateAndShorten('Stock Items','sidebar',15)!!}
                            </a></li>


                        <li {{ HTML::current('product/stock/import', 'product/stock/import') }}><a
                                    href="{{url('/product/stock/import')}}"><i
                                        class='fa fa-upload'></i> {!! Helper::translateAndShorten('Upload CSV File','sidebar', 15)!!}
                            </a></li>

                    </ul>
                </li>
            @endcan
            @can('glance', \App\ProductCategory::class)
                <li {{ HTML::current('category/*', 'category/*') }}>
                    <a href="#">
                        <i class="fa fa-object-group"></i> <span>@lang('sidebar.Product Category') </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <span class="label label-primary pull-right"></span>
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('category/create', 'category/create') }}><a
                                    href="{{url('/category/create')}}"><i
                                        class='fa fa-plus'></i> @lang('sidebar.Create Category')</a></li>
                        <li {{ HTML::current('category', 'category') }}><a href="{{url('/category')}}"><i
                                        class='fa fa-users'></i>
                                @lang('sidebar.View Categories')</a></li>
                    </ul>
                </li>
            @endcan
            @can('glance', \App\Warehouse::class)
                <li {{ HTML::current('warehouse/*', 'warehouse/*') }}>
                    <a href="#">
                        <i class="fa fa-building"></i> <span>@lang('sidebar.Warehousing') </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!-- <span class="label label-primary pull-right">@{{warehouse}}</span> -->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('warehouse/create', 'warehouse/create') }}><a
                                    href="{{url('warehouse/create')}}"><i
                                        class='fa fa-plus'></i> @lang('sidebar.New Warehouse')</a></li>
                        <li {{ HTML::current('warehouse', 'warehouse') }}><a href="{{url('warehouse')}}"><i
                                        class='fa fa-users'></i>
                                @lang('sidebar.View Warehouse')</a></li>
                    </ul>
                </li>
            @endcan
            @can('glance', \App\PurchaseOrder::class)
                <li {{ HTML::current('order/*', 'order/*') }}>
                    <a href="#">
                        <i class="fa fa-archive"></i>
                        <span>  {!! Helper::translateAndShorten('Orders','sidebar',15)!!} </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!-- <span class="label label-primary pull-right">@{{purchaseorder}}</span> -->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('order/create', 'order/create') }}><a href="{{url('order/create')}}"><i
                                        class='fa fa-archive'></i> {!! Helper::translateAndShorten('New Order','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('order', 'order') }}><a href="{{url('order')}}"><i
                                        class='fa fa-users'></i> {!! Helper::translateAndShorten('Orders','sidebar',15)!!}
                            </a></li>


                    </ul>
                </li>
            @endcan
            @can('glance', \App\Restock::class)
            <!-- Restock-->
                <li {{ HTML::current('restock/*', 'restock/*') }}>
                    <a href="#">
                        <i class="fa fa-level-up"></i>
                        <span> {!! Helper::translateAndShorten('Restock','sidebar',15)!!} </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!-- <span class="label label-primary pull-right">@{{restock}}</span>-->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('restock/create', 'restock/create') }}><a
                                    href="{{url('restock/create')}}"><i
                                        class='fa fa-plus'></i> {!! Helper::translateAndShorten('Add Items to Stock','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('restock', 'restock') }}><a href="{{url('restock')}}"><i
                                        class='fa fa-users'></i> {!! Helper::translateAndShorten('Restocked Items','sidebar',15)!!}
                            </a></li>
                    </ul>
                </li>
            @endcan
            @can('glance', \App\Dispatch::class)
            <!-- Dispatch-->
                <li {{ HTML::current('dispatch/*', 'dispatch/*') }}>
                    <a href="#">
                        <i class="fa fa-user-plus"></i>
                        <span> {!! Helper::translateAndShorten('Dispatch To Staff','sidebar',15)!!} </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!-- <span class="label label-primary pull-right">@{{dispatch}}</span>-->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('dispatch/create', 'dispatch/create') }} ><a
                                    href="{{url('/dispatch/create')}}"><i
                                        class='fa fa-plus'></i> {!! Helper::translateAndShorten('Dispatch Item','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('dispatch', 'dispatch') }}><a href="{{url('dispatch')}}"><i
                                        class='fa fa-shopping-cart'></i> {!! Helper::translateAndShorten('View Dispatches','sidebar',15)!!}
                            </a></li>

                    </ul>
                </li>
            @endcan

            @can('glance', \App\Supplier::class)
            <!-- Suppliers-->
                <li {{ HTML::current('supplier/*', 'supplier/*') }}>
                    <a href="#">
                        <i class="fa fa-truck fa-flip-horizontal"></i>
                        <span> {!! Helper::translateAndShorten('Suppliers','sidebar',15)!!} </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!-- <span class="label label-primary pull-right">@{{suppliers}}</span>-->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('supplier/create', 'supplier/create') }}><a
                                    href="{{url('supplier/create')}}"><i
                                        class='fa fa-plus'></i> {!! Helper::translateAndShorten('Add Supplier','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('supplier', 'supplier') }}><a href="{{url('supplier')}}"><i
                                        class='fa fa-users'></i> {!! Helper::translateAndShorten('Suppliers','sidebar',15)!!}
                            </a></li>

                    </ul>
                </li>
            @endcan
            @can('glance', \App\Customer::class)
                <li {{ HTML::current('customer/*', 'customer/*') }}>
                    <a href="#">
                        <i class="fa fa-shopping-basket"></i> <span>@lang('sidebar.Customers') </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <span class="label label-primary pull-right"></span>
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('customer/create', 'customer/create') }}><a
                                    href="{{url('customer/create')}}"><i
                                        class='fa fa-plus'></i> @lang('sidebar.New Customers')</a></li>
                        <li {{ HTML::current('customer', 'customer') }}><a href="{{url('customer')}}"><i
                                        class='fa fa-users'></i>
                                @lang('sidebar.View Customers')</a></li>
                    </ul>
                </li>
            @endcan
            @can('glance', \App\SalesOrder::class)
                <li {{ HTML::current('sales/*', 'sales/*') }}>
                    <a href="#">
                        <i class="fa fa-truck"></i> <span>@lang('sidebar.Sales Order') </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <span class="label label-primary pull-right"></span>
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('sales/create', 'sales/create') }}><a href="{{url('sales/create')}}"><i
                                        class='fa fa-plus'></i> @lang('sidebar.New Sales Order')</a></li>
                        <li {{ HTML::current('sales', 'sales') }}><a href="{{url('sales')}}"><i
                                        class='fa fa-truck'></i>
                                @lang('sidebar.View Sales Order')</a></li>

                    </ul>
                </li>
            @endcan
            @can('glance', \App\Invoice::class)
                <li {{ HTML::current('invoice/*', 'invoice/*') }}>
                    <a href="#">
                        <i class="fa fa-list-alt"></i> <span>@lang('sidebar.Invoice') </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <span class="label label-primary pull-right"></span>
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('invoice/create', 'invoice/create') }}><a
                                    href="{{url('invoice/create')}}"><i
                                        class='fa fa-plus'></i> @lang('sidebar.New Invoice')</a></li>
                        <li {{ HTML::current('invoice', 'invoice') }}><a href="{{url('invoice')}}"><i
                                        class='fa fa-users'></i>
                                @lang('sidebar.View Invoice')</a></li>

                    </ul>
                </li>
            @endcan
            @can('glance', \App\Payment::class)
                <li {{ HTML::current('payment/*', 'payment/*') }}>
                    <a href="#">
                        <i class="fa fa-money"></i> <span> @lang('sidebar.Payments') </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <span class="label label-primary pull-right"></span>
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('payment/create', 'payment/create') }}><a
                                    href="{{url('payment/create')}}"><i
                                        class='fa fa-money'></i> @lang('sidebar.New Payments')</a></li>
                        <li {{ HTML::current('payment', 'payment') }}><a href="{{url('payment')}}"><i
                                        class='fa fa-money'></i>
                                @lang('sidebar.View Payments')</a></li>

                    </ul>
                </li>
            @endcan
            @can('glance', \App\Staff::class)
                <li {{ HTML::current('staff/*', 'staff/*') }}>
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span> {!! Helper::translateAndShorten('Staff','sidebar',15)!!} </span>
                        <i class="fa fa-angle-left pull-right"></i>
                        <!-- <span class="label label-primary pull-right">@{{staff}}</span>-->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('staff/create', 'staff/create') }}><a href="{{url('staff/create')}}"><i
                                        class='fa fa-plus'></i> {!! Helper::translateAndShorten('New Staff','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('staff', 'staff') }}><a href="{{url('staff')}}"><i
                                        class='fa fa-users'></i> {!! Helper::translateAndShorten('View Staff','sidebar',15)!!}
                            </a></li>

                    </ul>
                </li>
            @endcan
            @can('glance', \App\Department::class)
            <!-- Department-->
                <li {{ HTML::current('department/*', 'department/*') }}>
                    <a href="#">
                        <i class="fa fa-briefcase"></i>
                        <span> {!! Helper::translateAndShorten('Departments','sidebar',15)!!} </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!--    <span class="label label-primary pull-right">@{{department}}</span>-->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('department/create', 'department/create') }}><a
                                    href="{{url('department/create')}}"><i
                                        class='fa fa-plus'></i> {!! Helper::translateAndShorten('Add Departments','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('department', 'department') }}><a href="{{url('department')}}"><i
                                        class='fa fa-users'></i> {!! Helper::translateAndShorten('View Departments','sidebar',15)!!}
                            </a></li>

                    </ul>
                </li>
            @endcan

        <!-- Users-->
            @can('glance', \App\User::class)
                <li {{ HTML::current('user/*', 'user/*') }}>
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span> {!! Helper::translateAndShorten('Users','sidebar',15)!!} </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <!--   <span class="label label-primary pull-right">@{{users}}</span>-->
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('user/create', 'user/create') }}><a
                                    href="{{url('user/create')}}"><i
                                        class='fa fa-plus'></i> {!! Helper::translateAndShorten('Create User','sidebar',15)!!}
                            </a></li>
                        <li {{ HTML::current('user', 'user') }}><a href="{{url('user')}}"><i
                                        class='fa fa-users'></i> {!! Helper::translateAndShorten('All Users','sidebar',15)!!}
                            </a></li>

                        <li {{ HTML::current('roles', 'roles') }}><a
                                    href="{{url('roles')}}"><i
                                        class='fa fa-ban'></i> {!! Helper::translateAndShorten('User Roles','sidebar',15)!!}
                            </a></li>

                    </ul>
                </li>
            @endcan
            @can('glance', \App\Currency::class)
                <li {{ HTML::current('currency/*', 'currency/*') }}>
                    <a href="#">
                        <i class="fa fa-money"></i> <span>@lang('sidebar.Currency Settings')  </span> <i
                                class="fa fa-angle-left pull-right"></i>
                        <span class="label label-primary pull-right"></span>
                    </a>
                    <ul class="treeview-menu">
                        <li {{ HTML::current('currency', 'currency') }}><a href="{{url('currency')}}"><i
                                        class='fa fa-money'></i>
                                @lang('sidebar.Set Currency')</a></li>
                    </ul>
                </li>
            @endcan
            <li {{ HTML::current('language/*', 'language/*') }}>
                <a href="#">
                    <i class="fa fa-globe"></i>
                    <span> {!! Helper::translateAndShorten('Language','sidebar',15)!!} </span> <i
                            class="fa fa-angle-left pull-right"></i>
                    <span class="label label-primary pull-right"></span>
                </a>
                <ul class="treeview-menu">
                    <li {{ HTML::current('language/create', 'language/create') }}><a
                                href="{{url('language/create')}}"><i
                                    class='fa fa-plus'></i>{!! Helper::translateAndShorten('New Language','sidebar',15)!!}
                        </a></li>
                    <li {{ HTML::current('language', 'language') }}><a href="{{url('language')}}"><i
                                    class='fa fa-globe'></i>
                            {!! Helper::translateAndShorten('View Language','sidebar',15)!!}</a></li>
                </ul>
            </li>
            @can('glance', \App\Setting::class)
                <li {{ HTML::current('setting/'.Helper::getUser()->id.'/edit', 'setting/'.Helper::getUser()->id.'/edit') }}>
                    <a
                            href="{{url('setting/'.Helper::getUser()->id.'/edit')}}" class="bg-purple"><i
                                class='fa fa-cog'></i> {!! Helper::translateAndShorten('Your Settings','sidebar',15)!!}
                    </a></li>
            @endcan

            
        </ul>


    </section>
    <!-- /.sidebar -->
</aside>