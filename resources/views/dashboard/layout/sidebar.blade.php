<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <ul class="nav navbar-nav d-xl-none" style="display: flex;
    justify-content: center;
    align-items: center;">
            <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon"
                        data-feather="menu"></i></a></li>
        </ul>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                    id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span
                            class="user-name fw-bolder">{{ Auth::user()->name }}</span><span
                            class="user-status">User</span></div><span class="avatar"><img class="round"
                            src="{{ asset('project_assets/images/'.$about_page->profile_image) }}" alt="avatar"
                            height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ url('/logout') }}"><i class="me-50" data-feather="power"></i>
                        Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="{{ url('/') }}"><span class="">
                        <img style="height: 30px;width: 130px;"
                            src="{{ asset('project_assets/images/' . $settings->admin_logo) }}" alt="">
                    </span>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="@yield('dashborad')">
                <a class="d-flex align-items-center" href="{{ url('/users/dashboard') }}">
                    <i data-feather='home'></i>
                    <span class="menu-title text-truncate" data-i18n="home">Dashboard</span>
                </a>
            </li>
            <li class="@yield('new_podcast')">
                <a class="d-flex align-items-center" href="{{ url('/users/podcast/new') }}">
                    <i data-feather='plus-circle'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">New Podcasts</span>
                </a>
            </li>
            <li class="@yield('all_podcasts')">
                <a class="d-flex align-items-center" href="{{ url('/users/podcasts') }}">
                    <i data-feather='video'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">My Podcasts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{url('/')}}">
                    <i data-feather='slack'></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Store</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">3</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('store_add_product')">
                        <a class="d-flex align-items-center" href="{{url('/users/store/add_product')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Add Product</span>
                        </a>
                    </li>
                    <li class="@yield('store_products')">
                        <a class="d-flex align-items-center" href="{{url('/users/store/all_products')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Products</span>
                        </a>
                    </li>
                    <li class="@yield('store_categories')">
                        <a class="d-flex align-items-center" href="{{url('/users/store/categories')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Categories</span>
                        </a>
                    </li>
                    <li class="@yield('store_sizes')">
                        <a class="d-flex align-items-center" href="{{url('/users/store/sizes')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Sizes</span>
                        </a>
                    </li>
                    <li class="@yield('store_colors')">
                        <a class="d-flex align-items-center" href="{{url('/users/store/colors')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Colors</span>
                        </a>
                    </li>
                    <li class="@yield('store_orders')">
                        <a class="d-flex align-items-center" href="{{url('/users/store/orders')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Orders</span>
                        </a>
                    </li>
                    <li class="@yield('store_payout')">
                        <a class="d-flex align-items-center" href="{{ url('/users/store/payout') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Payout</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="@yield('subscription_payout')">
                <a class="d-flex align-items-center" href="{{url('/admin/subscription/payout')}}">
                    <i data-feather='sidebar'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Subscription Payouts</span>
                </a>
            </li>
            <li class="@yield('profile')">
                <a class="d-flex align-items-center" href="{{ url('/users/profile') }}">
                    <i data-feather='user-check'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{ url('/') }}">
                    <i data-feather='message-square'></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Messages</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">2</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('unread-messages')">
                        <a class="d-flex align-items-center" href="{{ url('/users/messages/unread') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Unread Messages</span>
                        </a>
                    </li>
                    <li class="@yield('read-messages')">
                        <a class="d-flex align-items-center" href="{{ url('/users/messages/read') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Read Messages</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{ url('/') }}">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Pages</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">3</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('home_page')">
                        <a class="d-flex align-items-center" href="{{ url('/users/pages/home') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Home Page</span>
                        </a>
                    </li>
                    <li class="@yield('contact_page')">
                        <a class="d-flex align-items-center" href="{{ url('/users/pages/contact') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Contact Page</span>
                        </a>
                    </li>
                    <li class="@yield('about_page')">
                        <a class="d-flex align-items-center" href="{{ url('/users/pages/about') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">About Page</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
