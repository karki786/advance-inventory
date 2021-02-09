<header class="main-header">
    <!-- Logo -->
    <a class="logo" href="{{url('/')}}">{!!env('COMPANY_NAME')!!}</a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav role="navigation" class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a role="button" data-toggle="offcanvas" class="sidebar-toggle" href="#">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="User Image" class="user-image" src="{{App\Helper::avatar()}}">
                        <span class="hidden-xs">{{Helper::getUser()->name ?? ''}} </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img alt="User Image" class="img-circle" src="{{App\Helper::avatar()}}">

                            <p>
                                {{Helper::getUser()->name ?? ''}} - {{Auth::user()->myrole->name ?? ''}}
                                <small>{!!Helper::translateAndShorten('Member since','sidebar',200)!!} {{Helper::getUser()->created_at->format('Y-m-d')}}</small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a class="btn bg-red  btn-flat"
                                   href="{{url('user/'.Helper::getUser()->id.'/edit')}}"> {!! Helper::translateAndShorten('Reset Password','sidebar',50)!!}</a>
                            </div>
                            <div class="pull-right">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" >{{ csrf_field() }}
                                    <button type="submit" class="btn bg-purple  btn-flat"
                                       href="{{url('/logout')}}"> {!! Helper::translateAndShorten('Sign out','sidebar',10)!!}</button>
                                </form>




                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>