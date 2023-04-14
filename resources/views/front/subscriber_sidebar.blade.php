

<aside class="sidebar mt-2" id="sidebar">
    <ul class="nav nav-list flex-column mb-5">
        <li class="nav-item"><a class="nav-link text-3 @yield('subscriber-profile-orders')"
                href="{{url($user->username.'/subscriber/orders')}}">Orders</a></li>
        <li class="nav-item"><a class="nav-link text-3 @yield('subscriber-profile-users')"
                href="{{url($user->username.'/subscriber/users_subscribed')}}">Users Subscribed</a></li>
        <li class="nav-item"><a class="nav-link text-3" href="{{url('/subscriber/logout/')}}">Logout</a></li>
    </ul>
</aside>