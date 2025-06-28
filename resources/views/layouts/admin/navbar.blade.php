 <div class="header">
     <div class="header-left">
         <a href="index.html" class="logo">
             <img src="{{ asset('template') }}/assets/img/logo.png" width="35" height="35" alt="">
             <span>TITLE</span>
         </a>
     </div>
     <a id="toggle_btn" href="javascript:void(0);"><img src="{{ asset('template') }}/assets/img/icons/bar-icon.svg"
             alt=""></a>
     <a id="mobile_btn" class="mobile_btn float-start" href="#sidebar"><img
             src="{{ asset('template') }}/assets/img/icons/bar-icon.svg" alt=""></a>
     <div class="top-nav-search mob-view">
         <form>
             <input type="text" class="form-control" placeholder="Search here">
             <a class="btn"><img src="{{ asset('template') }}/assets/img/icons/search-normal.svg" alt=""></a>
         </form>
     </div>
     <ul class="nav user-menu float-end">
         <li class="nav-item dropdown d-none d-md-block">
             <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown"><img
                     src="{{ asset('template') }}/assets/img/icons/note-icon-02.svg" alt=""><span
                     class="pulse"></span> </a>
             <div class="dropdown-menu notifications">
                 <div class="topnav-dropdown-header">
                     <span>Notifications</span>
                 </div>
                 <div class="drop-scroll">
                     <ul class="notification-list">
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">
                                         <img alt="John Doe" src="{{ asset('template') }}/assets/img/user.jpg"
                                             class="img-fluid">
                                     </span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">John Doe</span> added new task
                                             <span class="noti-title">Patient appointment booking</span>
                                         </p>
                                         <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">V</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Tarah Shropshire</span>
                                             changed the task name <span class="noti-title">Appointment booking with
                                                 payment gateway</span></p>
                                         <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">L</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span
                                                 class="noti-title">Domenic Houston</span> and <span
                                                 class="noti-title">Claire Mapes</span> to project <span
                                                 class="noti-title">Doctor available module</span></p>
                                         <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">G</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Rolland Webber</span>
                                             completed task <span class="noti-title">Patient and Doctor video
                                                 conferencing</span></p>
                                         <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                         <li class="notification-message">
                             <a href="activities.html">
                                 <div class="media">
                                     <span class="avatar">V</span>
                                     <div class="media-body">
                                         <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added
                                             new task <span class="noti-title">Private chat module</span></p>
                                         <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                     </div>
                                 </div>
                             </a>
                         </li>
                     </ul>
                 </div>
                 <div class="topnav-dropdown-footer">
                     <a href="activities.html">View all Notifications</a>
                 </div>
             </div>
         </li>
         <li class="nav-item dropdown d-none d-md-block">
             <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><img
                     src="{{ asset('template') }}/assets/img/icons/note-icon-01.svg" alt=""><span
                     class="pulse"></span> </a>
         </li>
         <li class="nav-item dropdown has-arrow user-profile-list">
             <a href="#" class="dropdown-toggle nav-link user-link" data-bs-toggle="dropdown">
                 <div class="user-names">
                     <h5>Liam Michael </h5>
                     <span>Admin</span>
                 </div>
                 <span class="user-img">
                     <img src="{{ asset('template') }}/assets/img/user-06.jpg" alt="Admin">
                 </span>
             </a>
             <div class="dropdown-menu">
                 <a class="dropdown-item" href="profile.html">My Profile</a>
                 <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                 <a class="dropdown-item" href="settings.html">Settings</a>
                 <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                                     document.getElementById('logout-form-nav-1').submit();">Logout</a>
                 <form id="logout-form-nav-1" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>
             </div>
         </li>
         <li class="nav-item ">
             <a href="settings.html" class="hasnotifications nav-link"><img
                     src="{{ asset('template') }}/assets/img/icons/setting-icon-01.svg" alt=""> </a>
         </li>
     </ul>
     <div class="dropdown mobile-user-menu float-end">
         <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                 class="fa-solid fa-ellipsis-vertical"></i></a>
         <div class="dropdown-menu dropdown-menu-end">
             <a class="dropdown-item" href="profile.html">My Profile</a>
             <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
             <a class="dropdown-item" href="settings.html">Settings</a>
             <a class="dropdown-item" href="{{ route('logout') }}"
                 onclick="event.preventDefault();
                                                     document.getElementById('logout-form-nav-2').submit();">Logout</a>
             <form id="logout-form-nav-2" action="{{ route('logout') }}" method="POST" class="d-none">
                 @csrf
             </form>
         </div>
     </div>
 </div>
