<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <div class="logout-btn" style="margin-bottom: 0px;">
                <a href="{{ route('siswa.dashboard.index') }}"
                    style="{{ request()->RouteIs('siswa.dashboard.*') ? '' : 'color: rgba(51, 53, 72, 0.75);' }}"><span
                        class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-01.svg"
                            alt=""></span>
                    <span>Dashboard</span></a>
            </div>

            <ul>
                <li class="menu-title">SIMS</li>
                <li class="submenu">
                    @if (count(\Auth::user()->siswa->kelasSiswa) > 0)
                        @foreach (\Auth::user()->siswa->kelasSiswa as $kelasSiswa)
                            <a href="#"><span class="menu-side"><img
                                        src="{{ asset('template') }}/assets/img/icons/menu-icon-04.svg"
                                        alt=""></span>
                                <span> {{ $kelasSiswa->kelasSub->kelas->angka }} - {{ $kelasSiswa->kelasSub->sub }}</span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a class="{{ request()->RouteIs('siswa.absensi.*') ? 'active' : '' }}"
                                        href="{{ route('siswa.absensi.index',['kelasSub' => $kelasSiswa->kelasSub] ) }}">Absensi</a></li>
                                <li><a class="{{ request()->RouteIs('siswa.nilai.*') ? 'active' : '' }}"
                                        href="{{ route('siswa.nilai.index',['kelasSub' => $kelasSiswa->kelasSub] ) }}">Nilai</a></li>
                            </ul>
                        @endforeach
                    @endif
                </li>

            </ul>
            <div class="logout-btn" style="margin-bottom: 0px;">
                <a href="{{ route('siswa.profile.index') }}"
                    style="{{ request()->RouteIs('siswa.profile.*') ? '' : 'color: rgba(51, 53, 72, 0.75);' }}"><span
                        class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-01.svg"
                            alt=""></span>
                    <span>Profil</span></a>
            </div>

            @include('layouts.admin.sidebar.logout')
        </div>
    </div>
</div>
