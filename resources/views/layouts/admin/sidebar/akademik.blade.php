 <li class="submenu">
     <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-08.svg"
                 alt=""></span>
         <span> Akademik </span> <span class="menu-arrow"></span></a>
     <ul style="display: none;">
         <li><a class="{{ request()->RouteIs('admin.mata-pelajaran.*') ? 'active' : '' }}" href="{{ route('admin.mata-pelajaran.index') }}">Mata Pelajaran</a></li>
         <li><a class="{{ request()->RouteIs('admin.kurikulum.*') ? 'active' : '' }}" href="{{ route('admin.kurikulum.index') }}">Kurikulum</a></li>
         <li><a class="{{ request()->RouteIs('admin.tahun-pelajaran.*') ? 'active' : '' }}" href="{{ route('admin.tahun-pelajaran.index') }}">Tahun Pelajaran</a></li>
         <li><a class="{{ request()->RouteIs('admin.kelas.*') ? 'active' : '' }}" href="{{ route('admin.kelas.index') }}">Kelas</a></li>
         <li><a class="{{ request()->RouteIs('admin.jadwal.*') ? 'active' : '' }}" href="{{ route('admin.jadwal.index') }}">Jadwal</a></li>
     </ul>
 </li>
