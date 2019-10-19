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
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
            <div class="container">
                <a href="{{ URL::to('/') }}" class="navbar-brand font-weight-bold">Metal&nbsp;&amp;&nbsp;Moss</a>
                <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler">
                    <span class="navbar-toggler-icon"></span>
                </button>

            @if ($nav_pages)

                <div id="navbarContent" class="collapse navbar-collapse">

                    <ul class="navbar-nav mr-auto">

                    @foreach ($nav_pages as $nav_page)

                        <li class="nav-item{{ !isset($nav_page->pages) ?: ' dropdown' }}">

                        @if (!isset($nav_page->pages))

                            <a href="{{ URL::to($nav_page->uri) }}" class="nav-link">{{ $nav_page->title }}</a>

                        @else

                            <a id="dropdownMenu1" href="{{ URL::to($nav_page->uri) }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ $nav_page->title }}</a>

                            <ul aria-labelledby="dropdownMenu1" class="dropdown-menu border-0 shadow">

                            @foreach ($nav_page->pages as $dd1_page)

                                <li class="{{ !isset($dd1_page->pages) ? 'dropdown-item' : 'dropdown-submenu' }}">

                                @if (!isset($dd1_page->pages))

                                    <a href="{{ URL::to($nav_page->uri . '/' . $dd1_page->uri) }}" class="dropdown-item">{{ $dd1_page->title }} </a>

                                @else

                                    <a id="dropdownMenu2" href="{{ URL::to($nav_page->uri . '/' . $dd1_page->uri) }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">{{ $dd1_page->title }}</a>

                                    <ul aria-labelledby="dropdownMenu2" class="dropdown-menu border-0 shadow">

                                    @foreach ($dd1_page->pages as $dd2_page)

                                        <li class="{{ !isset($dd2_page->pages) ? 'dropdown-item' : 'dropdown-submenu' }}">

                                        @if (!isset($dd2_page->pages))

                                            <a tabindex="-1" href="{{ URL::to($nav_page->uri . '/' . $dd1_page->uri . '/' . $dd2_page->uri) }}" class="dropdown-item">{{ $dd2_page->title }} </a>

                                        @endif

                                        </li>

                                    @endforeach

                                    </ul>

                                @endif

                                </li>

                            @endforeach

                            </ul>

                        @endif

                        </li>

                    @endforeach

                    </ul>

                </div>

            @endif

            </div>
        </nav>
        @yield('content')
    </body>
</html>
