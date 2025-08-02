<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            @include('layouts.admin.sidebar.dashboard')
            <ul>
                <li class="menu-title">SIMS</li>
                @include('layouts.admin.sidebar.laporan')
                <li class="menu-title">Pengaturan</li>
                @include('layouts.admin.sidebar.sistem')

            </ul>
            @include('layouts.admin.sidebar.profil')
            @include('layouts.admin.sidebar.logout')
        </div>
    </div>
</div>
