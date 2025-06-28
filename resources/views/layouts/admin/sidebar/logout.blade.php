<div class="logout-btn">
    <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
                                                     document.getElementById('logout-form-sidenav').submit();"><span
            class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/logout.svg" alt=""></span>
        <span>Logout</span></a>
    <form id="logout-form-sidenav" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
