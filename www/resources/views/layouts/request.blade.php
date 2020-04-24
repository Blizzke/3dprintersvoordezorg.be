<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>3d printers voor de zorg :: @yield('title', 'Welkom')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Overpass:300,400,500|Dosis:400,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/ionicons/4.0.0-19/css/ionicons.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/4.1.0//css/bootstrap.min.css" >

        <link rel="stylesheet" href="{{ url('/css/aos.css') }}">
        <link rel="stylesheet" href="{{ url('/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ url('/css/icomoon.css') }}">
        <link rel="stylesheet" href="{{ url('/css/style.css') }}">

        <!-- jQuery -->
        <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>

        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="{{ url('') }}"><img src="{{ url('/images/logo.svg') }}" style="width: 80px"></a>
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
                        <img src="{{ url('/images/logo.png') }}" class="img-fluid">
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

        <!-- loader -->
        <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/stellar.js/0.6.2/jquery.stellar.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-animateNumber/0.0.14/jquery.animateNumber.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.min.js"></script>

        <script src="{{ url('/js/aos.js') }}"></script>
        <script src="{{ url('/js/main.js') }}"></script>


    </body>
</html>

