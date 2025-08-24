                <li class="submenu">
                    <a href="#"><span class="menu-side"><img
                                src="{{ asset('template') }}/assets/img/icons/menu-icon-05.svg" alt=""></span>
                        <span> Laporan & Cetak </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ request()->RouteIs('admin.laporan-akademik.*') ? 'active' : '' }}"
                                href="{{ route('admin.laporan-akademik.index') }}">Laporan Akademik</a></li>
                        <li><a class="{{ request()->RouteIs('admin.cetak-laporan.*') ? 'active' : '' }}"
                                href="{{ route('admin.cetak-laporan.index') }}">Cetak Laporan</a></li>
                    </ul>
                </li>
