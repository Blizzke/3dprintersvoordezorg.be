<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>3d printers voor de zorg :: @yield('title', 'Welkom')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Overpass:300,400,500|Dosis:400,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="/css/open-iconic-bootstrap.min.css">
        <link rel="stylesheet" href="/css/animate.css">
        <link rel="stylesheet" href="/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="/css/magnific-popup.css">
        <link rel="stylesheet" href="/css/aos.css">
        <link rel="stylesheet" href="/css/ionicons.min.css">
        <link rel="stylesheet" href="/css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="/css/jquery.timepicker.css">
        <link rel="stylesheet" href="/css/flaticon.css">
        <link rel="stylesheet" href="/css/icomoon.css">
        <link rel="stylesheet" href="/css/fancybox.min.css">

        <link href="https://netdna.bootstrapcdn.com/bootstrap/4.1.0//css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css">

        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('') }}"><img src="/images/logo.svg" style="width: 80px"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="oi oi-menu"></span> Menu
                </button>

                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a href="{{ url('') }}" class="nav-link">Home</a></li>
{{--                        <li class="nav-item"><a href="#" class="nav-link">Partners</a></li>--}}
                        <li class="nav-item"><a href="{{ url('/order/new') }}" class="nav-link">ik ZOEK materiaal</a></li>
                        <li class="nav-item"><a href="{{ url('/helper/register') }}" class="nav-link">ik wil HELPEN</a></li>
                        {{--<li class="nav-item"><a href="#" class="nav-link">Doneren</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Over ons</a></li>--}}
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a></li>
                            @else
                                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END nav -->




    </head>
    <body>
        @yield('content')

        <footer class="footer">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-md-6 col-lg-4">
                        <h3 class="heading-section">About Us</h3>
                        <p class="lead">
                            Met tientallen vrijwilligers helpen wij graag een handje mee in deze moeilijke tijden.
                            Via deze site bieden we tal van hulpstukken aan om mensen bij te staan in hun strijd tegen COVID-19.
                        </p>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <img src="/images/logo.png" class="img-fluid">
                    </div>
                </div>
                <div class="row pt-5">
                    <div class="col-md-12 text-center">

                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            <script>document.write(new Date().getFullYear());</script> 3dprintersvoordezorg.be | Template  by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>

                    </div>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="/js/jquery.min.js"></script>
        <script src="/js/jquery-migrate-3.0.1.min.js"></script>
        <script src="/js/popper.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.easing.1.3.js"></script>
        <script src="/js/jquery.waypoints.min.js"></script>
        <script src="/js/jquery.stellar.min.js"></script>
        <script src="/js/owl.carousel.min.js"></script>
        <script src="/js/jquery.magnific-popup.min.js"></script>
        <script src="/js/bootstrap-datepicker.js"></script>

        <script src="/js/jquery.fancybox.min.js"></script>

        <script src="/js/aos.js"></script>
        <script src="/js/jquery.animateNumber.min.js"></script>
        <script src="/js/main.js"></script>
    </body>
</html>

