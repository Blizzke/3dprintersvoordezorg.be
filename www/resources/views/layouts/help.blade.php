<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Wij Helpen :: @yield('title')</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

       <!-- Fonts -->
       <link rel="dns-prefetch" href="//fonts.gstatic.com">
       <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

       <!-- Styles -->
       <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
       <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="top-right links">
            <a href="{{ route('logout') }}">Logout</a>
        </div>

        @section('sidebar')
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>

