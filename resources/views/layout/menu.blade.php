<!-- menu start -->
<nav class="main-menu">
    <ul>
        <li class="current-list-item">
            <a href="{{config('app.url')}}">Home</a>
            <!-- <ul class="sub-menu">
                <li><a href="index.html">Static Home</a></li>
                <li><a href="index_2.html">Slider Home</a></li>
            </ul> -->
        </li>
        <!-- <li><a href="{{url('/about')}}">About</a></li> -->
        <li>
            <a href="{{ url('/products')}}">Shop</a>
        </li>
        <li><a href="contact">Contact</a></li>
        <li>
            <div class="header-icons">
                <a class="shopping-cart" href="{{ url('/cart')}}"><i class="fas fa-shopping-cart"></i></a>
                @auth
                    <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth

                @guest
                    <a class="" href="{{ route('login') }}"><i class="fas fa-user"></i></a>
                    <!-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li> -->
                @endguest

                <!-- <a class="" href="{{ url('/signup')}}"><i class="fas fa-user"></i></a> -->
                <a class="mobile-hide search-bar-icon" href="javascript:void(0);"><i class="fas fa-search"></i></a>
            </div>
        </li>
    </ul>
</nav>
<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
<div class="mobile-menu"></div>
<!-- menu end -->