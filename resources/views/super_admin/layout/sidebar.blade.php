<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <ul class="nav navbar-nav d-xl-none" style="display: flex;
    justify-content: center;
    align-items: center;">
            <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
        </ul>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">Super</span><span class="user-status">Admin</span></div><span class="avatar"><img class="round" src="{{asset('admin_assets/images/portrait/small/avatar-s-11.jpg')}}" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{url('/superAdmin/logout')}}"><i class="me-50" data-feather="power"></i> Logout</a>
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
                <a class="d-flex align-items-center" href="{{url('/superAdmin')}}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Dashboards</span>
                </a>
            </li>
            <li class="@yield('admins')">
                <a class="d-flex align-items-center" href="{{url('/superAdmin/admins')}}">
                    <i data-feather="user"></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Admins</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{url('/')}}">
                    <i data-feather="file-text"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Pages</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">4</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('home_page')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/pages/home')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Home Page</span>
                        </a>
                    </li>
                    <li class="@yield('login_page')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/pages/login')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Login Page</span>
                        </a>
                    </li>
                    <li class="@yield('contact_page')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/pages/contact')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Contact Page</span>
                        </a>
                    </li>
                    <li class="@yield('about_page')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/pages/about')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">About Page</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="@yield('basic-settings')">
                <a class="d-flex align-items-center" href="{{url('/superAdmin/basic-settings')}}">
                    <i data-feather='settings'></i>
                    <span class="menu-title text-truncate" data-i18n="Email">Basic Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{url('/')}}">
                    <i data-feather='message-circle'></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Support Center</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">2</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('support-unread-messages')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/support/messages/unread')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Unread Messages</span>
                        </a>
                    </li>
                    <li class="@yield('support-read-messages')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/support/messages/read')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Read Messages</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{url('/')}}">
                    <i data-feather="message-square"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">Messages</span>
                    <span class="badge badge-light-warning rounded-pill ms-auto me-1">2</span>
                </a>
                <ul class="menu-content">
                    <li class="@yield('unread-messages')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/messages/unread')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Unread Messages</span>
                        </a>
                    </li>
                    <li class="@yield('read-messages')">
                        <a class="d-flex align-items-center" href="{{url('/superAdmin/messages/read')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="Analytics">Read Messages</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>