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

                        <li class="nav-item">

                            <a class="nav-link" href="{{ URL::to('cart') }}"><i class="fas fa-shopping-cart"></i></a>
                            <!-- <a class="nav-link" href="#"><i class="fas fa-cart-plus"></i></a> -->

                        </li>

                    </ul>

                </div>

            @endif

            </div>
        </nav>