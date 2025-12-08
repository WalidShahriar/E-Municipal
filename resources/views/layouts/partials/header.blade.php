<header>
    <div id="navbar_container" class="{{ $navbarClass ?? '' }}">
        <div id="nav_1">

            <div id="logo_name">
                <div id="govt_logo">
                    <img src="{{ asset('images/govt_logo.png') }}" alt="govt_logo" height="60px">
                </div>
                <div id="site_name">
                    <a href="/home"><p>City of Dhaka</p></a>
                </div>
            </div>

            <div id="searchbar">
                <input type="text" id="search_input" placeholder="Search  Dhaka.gov">
                <button id="search_button">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='195' height='195' viewBox='15 15 195 195'%3E%3Cpath fill='%23eef3f7' stroke='transparent' stroke-width='0' d='M203.8 192.6l-46.4-48.3c11.9-14.2 18.5-32 18.5-50.6 0-43.4-35.3-78.7-78.7-78.7S18.4 50.3 18.4 93.7s35.3 78.7 78.7 78.7c16.3 0 31.8-4.9 45.1-14.2l46.8 48.6c2 2 4.6 3.1 7.4 3.1 2.7 0 5.2-1 7.1-2.9 4.1-3.8 4.2-10.3.3-14.4zM97.1 35.5c32.1 0 58.2 26.1 58.2 58.2s-26.1 58.2-58.2 58.2-58.2-26.1-58.2-58.2S65 35.5 97.1 35.5z'/%3E%3C/svg%3E" alt="search logo">
                </button>
            </div>

            <div id="login_signup">
                @auth
                    <a href="{{ route('profile') }}" id="login">Profile</a>
                    @if(Auth::user()->isAdmin())
                        <p>/</p>
                        <a href="{{ route('admin_panel') }}">Admin Panel</a>
                    @endif
                    <p>/</p>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline; margin: 0; padding: 0;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" id="login">Login</a>
                    <p>/</p>
                    <a href="{{ route('signup') }}">SignUp</a>
                @endauth
            </div>

        </div>


        <div id="nav_2">
            <ul>
                <li class="nav-item"><p>Residents</p>
                    <ul class="submenu">
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Permits</a></li>
                    </ul>
                </li>
                <li class="nav-item"><p>Businesses</p>
                    <ul class="submenu">
                        <li><a href="#">Licenses</a></li>
                        <li><a href="#">Resources</a></li>
                    </ul>
                </li>
                <li class="nav-item"><p>Explore Dhaka</p>
                    <ul class="submenu">
                        <li><a href="#">Attractions</a></li>
                        <li><a href="#">Parks</a></li>
                    </ul>
                </li>
                <li class="nav-item"><p>City Administration</p>
                    <ul class="submenu">
                        <li><a href="/dashboard_admin">Municipal Dashboard</a></li>
                        <li><a href="#">Budget</a></li>
                    </ul>
                </li>
                <li class="nav-item"><p>News</p>
                    <ul class="submenu">
                        <li><a href="#">Latest</a></li>
                        <li><a href="#">Archives</a></li>
                    </ul>
                </li>
                <li class="nav-item"><p>Contact Us</p>
                    <ul class="submenu">
                        <li><a href="#">Contact Form</a></li>
                        <li><a href="#">Offices</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <button id="hamburger_btn" aria-label="Open menu" aria-expanded="false">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
    </button>

    <div id="mobile_sidebar" aria-hidden="true">
        <div id="mobile_sidebar_inner">
            <div id="mobile_sidebar_header">
                <div id="mobile_logo_name">
                    <img src="{{ asset('images/govt_logo.png') }}" alt="govt_logo" height="50px">
                    <a href="/home"><p>City of Dhaka</p></a>
                </div>
                <button id="mobile_close" aria-label="Close menu">&times;</button>
            </div>

            <div id="mobile_auth_section">
                @auth
                    <a href="{{ route('profile') }}" class="mobile-auth-link">Profile</a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin_panel') }}" class="mobile-auth-link">Admin Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="mobile-logout-form">
                        @csrf
                        <button type="submit" class="mobile-auth-link mobile-logout-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-auth-link">Login</a>
                    <a href="{{ route('signup') }}" class="mobile-auth-link">SignUp</a>
                @endauth
            </div>

            <nav id="mobile_nav">
                <ul>
                    <li class="mobile-item">
                        <button class="mobile-toggle" aria-expanded="false">Residents</button>
                        <ul class="mobile-submenu">
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Permits</a></li>
                        </ul>
                    </li>
                    <li class="mobile-item">
                        <button class="mobile-toggle" aria-expanded="false">Businesses</button>
                        <ul class="mobile-submenu">
                            <li><a href="#">Licenses</a></li>
                            <li><a href="#">Resources</a></li>
                        </ul>
                    </li>
                    <li class="mobile-item">
                        <button class="mobile-toggle" aria-expanded="false">Explore Dhaka</button>
                        <ul class="mobile-submenu">
                            <li><a href="#">Attractions</a></li>
                            <li><a href="#">Parks</a></li>
                        </ul>
                    </li>
                    <li class="mobile-item">
                        <button class="mobile-toggle" aria-expanded="false">City Administration</button>
                        <ul class="mobile-submenu">
                            <li><a href="#">Departments</a></li>
                            <li><a href="#">Budget</a></li>
                        </ul>
                    </li>
                    <li class="mobile-item">
                        <button class="mobile-toggle" aria-expanded="false">News</button>
                        <ul class="mobile-submenu">
                            <li><a href="#">Latest</a></li>
                            <li><a href="#">Archives</a></li>
                        </ul>
                    </li>
                    <li class="mobile-item">
                        <button class="mobile-toggle" aria-expanded="false">Contact Us</button>
                        <ul class="mobile-submenu">
                            <li><a href="#">Contact Form</a></li>
                            <li><a href="#">Offices</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div id="mobile_sidebar_overlay"></div>
</header>