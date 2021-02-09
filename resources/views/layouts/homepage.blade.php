<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dennis Wanyoike">
    <link rel="shortcut icon" href="assets/homepage/ico/favicon.ico">

    <title>Tam Advance Inventory</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('dist/homepage/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('dist/homepage/css/main.css')}}" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet'
          type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <script src="{{asset('dist/homepage/js/jquery.min.js')}}"></script>
    <script src="{{asset('dist/homepage/js/smoothscroll.js')}}"></script>
    <style>
        .t {
            width: 300px;
            text-align: center;
            margin: 0 auto;
        }
    </style>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-63399738-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">

<!-- Fixed navbar -->
<div id="navigation" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><b>Tam</b></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#home" class="smothscroll">Home</a></li>
                <li><a href="#desc" class="smothscroll">Description</a></li>
                <li><a href="#showcase" class="smothScroll">Showcase</a></li>
                <li><a href="#contact" class="smothScroll">Buy</a></li>
                <li><a href="/blog" class="">Blog</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>


<section id="home" name="home"></section>
<div id="headerwrap">
    <div class="container">
        <div class="row centered">
            <div class="col-lg-12">
                
            </div>


            <div class="col-lg-2">
                
            </div>

            <div class="col-lg-8">
                <img class="img-responsive" src="{{asset('dist/homepage/img/app-bg.png')}}" alt="">


            </div>
            <div class="col-lg-2">
                
            </div>
        </div>
    </div>
    <!--/ .container -->
</div>
<!--/ #headerwrap -->


<section id="desc" name="desc"></section>
<!-- INTRO WRAP -->
<div id="intro">
    <div class="container">
        <div class="row centered">
            <h1>Designed To Excel</h1>
            <br>
            <br>

            <div class="col-lg-4">
                <img src="{{asset('dist/homepage/img/intro01.png')}}" alt="">

                <h3>Reports</h3>

                <p>Monitor and report stock levels, costs and averages, Product history shows when items were received
                    or sold.</p>
            </div>
            <div class="col-lg-4">
                <img src="{{asset('dist/homepage/img/intro02.png')}}" alt="">

                <h3>Schedule</h3>

                <p>Schedule when certain actions should occur e.g Sending reporting, Calculating total monthly
                    costs </p>
            </div>
            <div class="col-lg-4">
                <img src="{{asset('dist/homepage/img/intro03.png')}}" alt="">

                <h3>Monitoring</h3>

                
            </div>
        </div>
        <br>
        <hr>
    </div>
    <!--/ .container -->
</div>
<!--/ #introwrap -->

<!-- FEATURES WRAP -->
<div id="features">
    <div class="container">
        <div class="row">
            <h1 class="centered">Why ?</h1>
            <br>
            <br>

            <div class="col-lg-6 centered">
                <img class="centered" src="{{asset('dist/homepage/screenshots/01_ProductOverview.png')}}" alt="">
                <img class="centered" src="{{asset('dist/homepage/screenshots/04_dispatches.png')}}" alt="">
            </div>

            <div class="col-lg-6">
                <h3>Some Features</h3>
                <br>
                <!-- ACCORDION -->
                <div class="accordion ac" id="accordion2">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                               href="#collapseOne">
                                Free Support & Modifications
                            </a>
                        </div>
                        <!-- /accordion-heading -->
                        <div id="collapseOne" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Most businesses operate differently from others and you may need modification
                                    or help in setting things up we provide this for free and do not charge you.
                                </p>
                            </div>
                            <!-- /accordion-inner -->
                        </div>
                        <!-- /collapse -->
                    </div>
                    <!-- /accordion-group -->
                    <br>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                               href="#collapseTwo">
                                Department Monitoring
                            </a>
                        </div>
                        <div id="collapseTwo" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>
                                    Do you operate on a budget? Ever need to monitor what each department is spending on
                                    office/warehouse dispatches.
                                    Now you can do it using Awesome you can even decide to block if a department
                                    has exceeded its
                                    budget
                                </p>
                            </div>
                            <!-- /accordion-inner -->
                        </div>
                        <!-- /collapse -->
                    </div>
                    <!-- /accordion-group -->
                    <br>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                               href="#collapseThree">
                                Suppliers Monitoring & Docs Storage
                            </a>
                        </div>
                        <div id="collapseThree" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Awesome Allows you to monitor how much you are spending on suppliers. Store
                                    Receipts and invoices in a secure manner </p>
                            </div>
                            <!-- /accordion-inner -->
                        </div>
                        <!-- /collapse -->
                    </div>
                    <!-- /accordion-group -->
                    <br>

                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                               href="#collapseFour">
                                Responsive Design
                            </a>
                        </div>
                        <div id="collapseFour" class="accordion-body collapse in">
                            <div class="accordion-inner">
                                <p>Awesome Responsive design allows you to use it on mobile devices and on the
                                    go</p>
                            </div>
                            <!-- /accordion-inner -->
                        </div>
                        <!-- /collapse -->
                    </div>
                    <!-- /accordion-group -->
                    <br>
                </div>
                <!-- Accordion -->
            </div>
        </div>
    </div>
    <!--/ .container -->
</div>
<!--/ #features -->


<section id="showcase" name="showcase"></section>
<div id="showcase">
    <div class="container">
        <div class="row">
            <h1 class="centered">Some Screenshots</h1>
            <br>

            <div class="col-lg-8 col-lg-offset-2">
                <div id="carousel-example-generic" class="carousel slide">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="{{asset('dist/homepage/screenshots/item-01.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('dist/homepage/screenshots/item-02.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('dist/homepage/screenshots/item-03.png')}}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('dist/homepage/screenshots/item-04.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
    </div>
    <!-- /container -->
</div>


<section id="contact" name="contact"></section>
<div id="footerwrap">
    <div class="container">
        <div class="col-lg-5">
            <h3>Thank you</h3>

            
        </div>

        <div class="col-lg-7">
            <h3>Want a Demo?</h3>
            

        </div>
    </div>
</div>
<div id="c">
    <div class="container">
        <p>&copy; 2015</p>

    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{asset('dist/homepage//js/bootstrap.js')}}"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
</script>
<script src="//load.sumome.com/" data-sumo-site-id="6604badc3e7d2211d88ecd738ae64c83563483934a4b48ddd4abd17596be6d92"
        async="async"></script>
</body>
</html>
