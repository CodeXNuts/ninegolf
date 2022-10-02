<header>
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">

                <p>Free 1 dozen golf balls with 1st order! </p>
            </div>
        </div>
    </div>
    <div class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-1 ">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('user/images/logo.png') }}" alt="" class="logo-sec">
                    </a>
                </div>
                <div class="col-md-11 ml-auto menu-sec text-right">
                    <div id="navigation">
                        <nav>
                            <ul>
                                <li><a href="javascript: ;">List My Clubs</a></li>
                                <li><a href="javascript: ;">Rent Clubs</a></li>
                                <li><a href="javascript: ;">Learn more</a></li>
                            </ul>
                        </nav>
                    </div>
                    <ul class="cart">
                        @auth
                            <li class="dropdown"><a href="#"><img
                                        src="{{ auth()->user()->avatar ? URL('/' . auth()->user()->avatar) : '' }}"
                                        alt="" class="profile"></a>
                                <ul class="nav-dropdown">
                                    <li>
                                        <a href="{{ route('profile') }}">

                                            View Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('profile',['sec'=>'club-list']) }}">

                                            Manage Listing
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript: ;">

                                            Manage Membership
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" style="display: none">
                                            @csrf
                                            <input type="submit" name="logout" id="logoutBtn">
                                        </form>
                                        <a href="javascript:void(0)" onclick="document.getElementById('logoutBtn').click()">

                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        @endauth
                        @guest
                            <li><a href="{{ route('login') }}">Sign In</a></li>
                        @endguest
                        <li><a href="#" class="shopping-cart"><img src="{{ asset('user/images/cart.svg') }}" alt="">
                            <span class="KK-o3G">{{ Session::get('cart_cnt') ?? 0 }}</span>
                        </a></li>
                       
                    </ul>
                </div>

            </div>
        </div>
    </div>


</header>
