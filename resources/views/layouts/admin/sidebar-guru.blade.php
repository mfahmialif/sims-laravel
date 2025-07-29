<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img
                                src="{{ asset('template') }}/assets/img/icons/menu-icon-01.svg" alt=""></span>
                        <span> Dashboard </span></span></a>
                </li>
            </ul>

            <ul>
                <li class="menu-title">SIMS</li>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img
                                src="{{ asset('template') }}/assets/img/icons/menu-icon-04.svg" alt=""></span>
                        <span> Siswa </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ request()->RouteIs('guru.siswa.*') ? 'active' : '' }}"
                                href="{{ route('guru.siswa.index') }}">Data Siswa</a></li>
                        <li><a class="{{ request()->RouteIs('admin.absensi.*') ? 'active' : '' }}"
                                href="{{ route('admin.absensi.index') }}">Absensi</a></li>
                        <li><a class="{{ request()->RouteIs('admin.nilai.*') ? 'active' : '' }}"
                                href="{{ route('admin.nilai.index') }}">Nilai</a></li>
                    </ul>
                </li>

            </ul>
            <div class="logout-btn" style="margin-bottom: 0px;">
                <a href="{{ route('guru.profile.index') }}" style="color: rgba(51, 53, 72, 0.75);"><span class="menu-side"><img
                            src="{{ asset('template') }}/assets/img/icons/menu-icon-01.svg" alt=""></span>
                    <span>Profil</span></a>
            </div>

            @include('layouts.admin.sidebar.logout')
        </div>
    </div>
</div>
