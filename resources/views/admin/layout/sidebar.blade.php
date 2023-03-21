<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <ul class="nav navbar-nav d-xl-none" style="display: flex;
    justify-content: center;
    align-items: center;">
            <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
        </ul>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">Owner</span><span class="user-status">Admin</span></div><span class="avatar"><img class="round" src="{{asset('admin_assets/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{url('/superAdmin/admins')}}"><i data-feather='trending-up'></i> Super Admin</a>
                    <a class="dropdown-item" href="{{url('/logout')}}"><i class="me-50" data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="{{url('/')}}"><span class="">
                        <img style="height: 30px;width: 130px;" src="{{asset('project_assets/images/'.$settings->admin_logo)}}" alt="">
                    </span>

                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="@yield('dashboard')">
                <a class="d-flex align-items-center" href="{{url('/admin')}}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Dashboards</span>
                </a>
            </li>
            <li class="@yield('users')">
                <a class="d-flex align-items-center" href="{{url('/admin/users')}}">
                    <i data-feather="user"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Users</span>
                </a>
            </li>
            <li class="@yield('podcasts')">
                <a class="d-flex align-items-center" href="{{url('/admin/users/podcasts')}}">
                    <i data-feather="video"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">User Podcasts</span>
                </a>
            </li>
            <li class="@yield('new_podcast')">
                <a class="d-flex align-items-center" href="{{ url('/admin/podcast/new') }}">
                    <i data-feather='plus-circle'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">New Podcasts</span>
                </a>
            </li>
            <li class="@yield('my_podcasts')">
                <a class="d-flex align-items-center" href="{{ url('/admin/podcasts') }}">
                    <i data-feather='video'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">My Podcasts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{ url('/') }}">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">My Pages</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">3</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('home_page')">
                        <a class="d-flex align-items-center" href="{{ url('/admin/pages/home') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Home Page</span>
                        </a>
                    </li>
                    <li class="@yield('contact_page')">
                        <a class="d-flex align-items-center" href="{{ url('/admin/pages/contact') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Contact Page</span>
                        </a>
                    </li>
                    <li class="@yield('about_page')">
                        <a class="d-flex align-items-center" href="{{ url('/admin/pages/about') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">About Page</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{url('/')}}">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">User Default Pages</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">3</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('default_home_page')">
                        <a class="d-flex align-items-center" href="{{url('/admin/default/pages/home')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Home Page</span>
                        </a>
                    </li>
                    <li class="@yield('default_contact_page')">
                        <a class="d-flex align-items-center" href="{{url('/admin/default/pages/contact')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Contact Page</span>
                        </a>
                    </li>
                    <li class="@yield('default_about_page')">
                        <a class="d-flex align-items-center" href="{{url('/admin/default/pages/about')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">About Page</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="@yield('categories')">
                <a class="d-flex align-items-center" href="{{url('/admin/categories')}}">
                    <i data-feather='sidebar'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Categories</span>
                </a>
            </li>
            <li class="@yield('profile')">
                <a class="d-flex align-items-center" href="{{ url('/admin/profile') }}">
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
                        <a class="d-flex align-items-center" href="{{ url('/admin/messages/unread') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Unread Messages</span>
                        </a>
                    </li>
                    <li class="@yield('read-messages')">
                        <a class="d-flex align-items-center" href="{{ url('/admin/messages/read') }}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Read Messages</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="@yield('support')">
                <a class="d-flex align-items-center d-none" href="{{url('/admin/support')}}">
                    <i data-feather='message-circle'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Support Center</span>
                </a>
            </li>
        </ul>
    </div>
</div>