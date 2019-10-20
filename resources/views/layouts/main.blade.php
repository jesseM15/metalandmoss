<!DOCTYPE html>
<html>
    <head>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link href="{{ URL::to('css/main.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great|Lexend+Zetta|Prata|Special+Elite|Spinnaker&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/79fbd3b094.js"></script>
        <script src="{{ URL::to('js/main.js') }}"></script>
        <title>@yield('title')</title>
    </head>
    <body>
        @include('layouts.nav')
        @yield('content')
        @include('layouts.footer')
    </body>
</html>
