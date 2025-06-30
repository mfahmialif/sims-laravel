<li class="submenu">
    <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-02.svg"
                alt=""></span>
        <span> Siswa Baru </span> <span class="menu-arrow"></span></a>
    <ul style="display: none;">
        <li>
            <a class="{{ request()->RouteIs('admin.pendaftaran-siswa-baru.*') ? 'active' : '' }}"
                href="{{ route('admin.pendaftaran-siswa-baru.index') }}">Pendaftaran Siswa Baru</a>
        </li>
    </ul>
</li>
