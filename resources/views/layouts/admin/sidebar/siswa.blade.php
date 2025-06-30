<li class="submenu">
    <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-04.svg"
                alt=""></span>
        <span> Siswa </span> <span class="menu-arrow"></span></a>
    <ul style="display: none;">
        <li><a class="{{ request()->RouteIs('admin.siswa.*') ? 'active' : '' }}"
                href="{{ route('admin.siswa.index') }}">Data Siswa</a></li>
        <li><a href="add-appointment.html">Absensi</a></li>
        <li><a href="edit-appointment.html">Nilai</a></li>
    </ul>
</li>
