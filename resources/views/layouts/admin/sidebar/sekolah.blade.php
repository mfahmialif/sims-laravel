<li class="submenu">
    <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-03.svg"
                alt=""></span>
        <span>Sekolah </span> <span class="menu-arrow"></span></a>
    <ul style="display: none;">
        <li><a class="{{ request()->RouteIs('admin.guru.*') ? 'active' : '' }}"
                href="{{ route('admin.guru.index') }}">Guru</a></li>
        <li><a href="add-patient.html">Kepala Sekolah</a></li>
    </ul>
</li>
