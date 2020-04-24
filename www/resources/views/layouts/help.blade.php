<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>3d printers voor de zorg :: @yield('title')</title>

        <!-- Scripts -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <!--<script src="{{ asset('js/app.js') }}" defer></script>-->

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="//fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <a class='btn btn-primary' href="{{route('dashboard')}}">Bestellingen</a>
                    <a class='btn btn-primary' href="https://discord.gg/T7mP48X" target="_blank">Discord (chat)</a></div>
            </div>
        </div>

        <div class="container">
            @yield('content')
        </div>
    </body>
    <script type="text/javascript">
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
          $('[data-confirm="1"]').click(function(e) {
              // "tooltip" empties out the title attribute, so get value from data-original-title
              if (!confirm($(this).data('original-title') + '. Ben je zeker?'))
                  e.preventDefault();
          })
        })
    </script>
</html>

