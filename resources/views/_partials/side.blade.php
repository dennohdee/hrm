<!-- side menu items -->
<ul id="accordion-menu">
    <li class="dropdown">
        <a href="{{ url('/')}}" class="dropdown-toggle no-arrow {{ (request()->is('home')) ? 'active' : '' }}">
            <span class="micon icon-copy ti-dashboard"></span><span class="mtext">Home</span>
        </a>
    </li>
    <li class="dropdown">
        <a href="{{ route('users')}}" class="dropdown-toggle no-arrow {{ (request()->is('users*')) ? 'active' : '' }}">
            <span class="micon fa fa-users"></span><span class="mtext">Users</span>
        </a>
    </li>
</ul>