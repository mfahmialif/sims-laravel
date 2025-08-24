<div class="logout-btn" style="margin-bottom: 0px">
    <a href="{{ route('admin.dashboard.index') }}"
        style="{{ request()->RouteIs('admin.dashboard.*') ? '' : 'color: rgba(51, 53, 72, 0.75);' }}"><span
            class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-01.svg" alt=""></span>
        <span>Dashboard</span></a>
</div>
