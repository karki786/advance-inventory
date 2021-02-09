<html>
<head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{url('css/all.css')}}" type="text/css" media="all"/>
    <link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed|Ubuntu|Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <style>


        .btn-default {
            color: white;
        }

        .content-wrapper {
            background-color: #ffffff !important;
        }

        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {
            border: 0.1px solid #f4f4f4;
        }

        .table-bordered > thead > tr > th {
            border: 0.1px solid #f4f4f4;
        }

        .table-paper thead tr th {
            font-size: 13px;
            font-weight: bold;
            background: #422626;
            color: #fff;
            border-radius: 0 !important;
            border-top: none;
            text-decoration: none !important;
            text-align: center;
        }

        /*

          font-size: 13px;
    font-weight: bold;
    background: #463232;
    color: #fff;
    border-radius: 0 !important;
    border-top: none;
         */
        .form-sidebar {
            padding: 0px;
            margin: 0px !important;
        }

        .form-sidebar label {
            color: white !important;
        }

        .user-panel {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 1px !important;
            padding-bottom: 0px !important;
        }

        .wrapper {
            /*min-height: 100%;
            position: relative;
            overflow: hidden;*/
            width: 100%;
            min-height: 100%;
            height: auto !important;
            position: absolute;
        }

        .content-wrapper {
            -webkit-transition: min-height 0.2s ease-in-out;
            -o-transition: min-height 0.2s ease-in-out;
            transition: min-height 0.2s ease-in-out;
        }

        .content-head {
            padding-bottom: 5px;
            margin-right: auto;
            margin-left: auto;
            padding-left: 15px;
            padding-right: 15px;
            border-bottom: 1px solid #e7e6e8;
        }

        .main-footer {
            background: #fcfcfc !important;
        }

        .dropdown-menu > li > a {
            padding: 10px 20px !important;
        }

        .sidebar-mini.sidebar-collapse .sidebar-menu > li:hover > .treeview-menu {
            top: 40px !important;
            margin-left: 0;
        }
    </style>

    <title>
        @section('title')@show
    </title>
</head>
<body class="{{$theme}}  sidebar-mini">
@if(env('APP_ONLINE',1))
    @include('layouts/analytics')
@endif
<div class="wrapper">
    @include('layouts/header')

    @include('layouts/sidebar')


    <div class="content-wrapper">
        <section class="content-head">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 style="font-weight: bold; font-size:26px; text-transform: uppercase; ">
                        @yield('heading')
                    </h1>
                </div>

            </div>

        </section>
        <section class="content">
            @if(Session::has('flash_notification.message'))
                <div class="callout callout-{{Session::get('flash_notification.level')}} no-margin flash_message">
                    <b>{{Session::get('flash_notification.message')}}</b>
                </div>
            @endif

        <!--Settings Check-->
            @if(\App\Role::count()<1)
                <div class="alert alert-error">
                    @lang('warning.Please set up Roles to unlock all side bar menu items click here') <a
                            href="{{action('UserRolesController@index')}}" class="btn btn-flat bg-green ">Create
                        Role</a>
                </div>
            @endif
            @if(\App\Country::count()<1)
                <div class="alert alert-error">
                    @lang('warning.Please Import Countries table from Extra Schema, Invoicing and Sales Order will not work without it !!!')
                </div>
            @endif
            @if(\App\ModulePermission::count()<1)
                <div class="alert alert-error">
                    @lang('warning.Please set up Roles Permissions to unlock all menu items') <a
                            href="{{action('UserRolesController@index')}}" class="btn btn-flat bg-green ">Create
                        Role</a>
                </div>
            @endif
            @if($companySettings->invoiceNumberingFormat == "")
                <div class="alert alert-info">
                    @lang('warning.Please set Invoice Order Format in Settings Module.')
                </div>
            @endif
            @if($companySettings->salesOrderNumberingFormat == "")
                <div class="alert alert-info">
                    @lang('warning.Please set Invoice Order Format in Settings Module.')
                </div>
            @endif
            @if($companySettings->defaultCurrency == "")
                <div class="alert alert-info">
                    @lang('warning.Please set Default Currency in Settings Module.')
                </div>
            @endif
            @if($companySettings->defaultLpoTaxAmmount== "")
                <div class="alert alert-info">
                    @lang('warning.Please set Default LPO Tax Amount in Settings Module.')
                </div>
            @endif
            @if($companySettings->city== "")
                <div class="alert alert-info">
                    @lang('warning.Please set City in Settings Module.')
                </div>
            @endif
            @yield('content')
        </section>
    </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>@lang('master.Version')</b> {!!env('APP_VERSION')!!}
        </div>
        @lang('master.Copyright') &copy;{{date("Y")}} {!!env('COMPANY_NAME')!!} , @lang('master.All Rights Reserved')
    </footer>
</div>
</body>
<script type="text/javascript" src="{{url('js/app.js')}}"></script>

@section('jquery')

@show


</html>