<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @section('title')@show
    </title>
    <link rel="stylesheet" href="{{url('css/all.css')}}" type="text/css" media="all"/>
    <link rel="shortcut icon" href="{{asset('dist/img/favicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{url('favicon.ico')}}" type="image/x-icon"/>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed|Ubuntu|Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed|Ubuntu|Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic'
          rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <style>

        /*
  ##Device = Desktops
  ##Screen = 1281px to higher resolution desktops
*/

        @media (min-width: 1281px) {

            .login-page, .register-page {
                background: #333;
                background: url({{url(Storage::url('home_image/home2.jpg'))}}) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            .login-logo, .footer {
                font-weight: bold;
                color: #422626;
            }

        }

        /*
          ##Device = Laptops, Desktops
          ##Screen = B/w 1025px to 1280px
        */

        @media (min-width: 1025px) and (max-width: 1280px) {

            .login-page, .register-page {
                background: #333;
                background: url({{url(Storage::url('home_image/home2.jpg'))}}) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            .login-logo, .footer {
                font-weight: bold;
                color: #422626;
            }

        }

        /*
          ##Device = Tablets, Ipads (portrait)
          ##Screen = B/w 768px to 1024px
        */

        @media (min-width: 768px) and (max-width: 1024px) {

            .login-page, .register-page {
                background: #333;
                background: url({{url(Storage::url('home_image/home2.jpg'))}}) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            .login-logo, .footer {
                font-weight: bold;
                color: #422626;
            }

        }

        /*
          ##Device = Tablets, Ipads (landscape)
          ##Screen = B/w 768px to 1024px
        */

        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {

            .login-page, .register-page {
                background: #333;
                background: url({{url(Storage::url('home_image/home2.jpg'))}}) no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
            .login-logo, .footer {
                font-weight: bold;
                color: #422626;
            }
        }

        /*
          ##Device = Low Resolution Tablets, Mobiles (Landscape)
          ##Screen = B/w 481px to 767px
        */

        @media (min-width: 481px) and (max-width: 767px) {

            .login-page, .register-page {
                background: #333;

            }
            .login-logo, .footer {
                font-weight: bold;
                color: white;
            }
        }

        /*
          ##Device = Most of the Smartphones Mobiles (Portrait)
          ##Screen = B/w 320px to 479px
        */

        @media (min-width: 320px) and (max-width: 480px) {

            .login-page, .register-page {
                background: #333;

            }

            .login-logo, .footer {
                font-weight: bold;
                color: white;
            }
        }


        .login-box, .register-box {

            margin: 7% auto;
        }



        .login-box-body, .register-box-body {
            background: none repeat scroll 0 0 #fff;
            border-top: 0 none;
            box-shadow: 0 -1px 6px 3px rgba(255, 255, 255, 1);
            color: #666;
            padding: 20px;

        }

        .footer {
            padding-top: 5px;
        }
    </style>
</head>
<body class="login-page">
<div id="app">
    @yield('content')

</div>


<script type="text/javascript" src="{{url('js/app.js')}}"></script>
<script>

    var app = new Vue({
        el: '#app',
        http: {
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        mounted: function () {


        },

        data: {
            action: '{{action('Auth\LoginController@login')}}',
            user: ''
        },
        methods: {},
        watch: {
            'user': function (val, oldVal) {
                console.log(val);
                if (val == 'Customer') {
                    this.action = '{{action('Auth\CustomerLoginController@login')}}';

                }
                else if (val == 'Admin') {
                    this.action = '{{action('Auth\LoginController@login')}}';
                }

            }
        }
    });


</script>
</body>
</html>
