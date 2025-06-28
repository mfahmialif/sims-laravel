<li class="submenu">
    <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-02.svg"
                alt=""></span>
        <span> Sistem </span> <span class="menu-arrow"></span></a>
    <ul style="display: none;">
        <li><a class="{{ request()->RouteIs('admin.role.*') ? 'active' : '' }}" href="{{ route('admin.role.index') }}">Role</a></li>
        <li><a class="{{ request()->RouteIs('admin.user.*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">User</a></li>
    </ul>
</li>
