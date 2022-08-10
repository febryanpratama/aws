<nav class="pcoded-navbar menupos-fixed menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">
            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Menus</label>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ (Route::currentRouteName() == 'dashboard') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>


                @if(Auth::user()->id <> 1)
                
                <li class="nav-item">
                    <a href="{{ route('weeks.index') }}" class="nav-link {{ (Route::currentRouteName() == 'weeks.index') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-activity"></i>
                        </span>
                        <span class="pcoded-mtext">Weekly Working Plan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dailyActivities') }}" class="nav-link {{ (Route::currentRouteName() == 'dailyActivities') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-check"></i>
                        </span>
                        <span class="pcoded-mtext">My Daily Activities</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('permission.index') }}" class="nav-link {{ (Route::currentRouteName() == 'permission.index') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-mail"></i>
                        </span>
                        <span class="pcoded-mtext">My Permission</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fileOrder') }}" class="nav-link {{ (Route::currentRouteName() == 'fileOrder') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-file"></i>
                        </span>
                        <span class="pcoded-mtext">My File Order</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('fileOrderHistory') }}" class="nav-link {{ (Route::currentRouteName() == 'fileOrderHistory') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-file"></i>
                        </span>
                        <span class="pcoded-mtext"> My Order File</span>
                    </a>
                </li>
                @if(Auth::user()->id == '2')
                <li class="nav-item">
                    <a href="{{ route('fileOrderReview') }}" class="nav-link {{ (Route::currentRouteName() == 'fileOrderReview') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-edit"></i>
                        </span>
                        <span class="pcoded-mtext"> My Review</span>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('attendanceHistory') }}" class="nav-link {{ (Route::currentRouteName() == 'attendanceHistory') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-map-pin"></i>
                        </span>
                        <span class="pcoded-mtext">My Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fileManager') }}" class="nav-link {{ (Route::currentRouteName() == 'fileManager' || Route::currentRouteName() == 'fileManagerSearch') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-folder"></i>
                        </span>
                        <span class="pcoded-mtext">File Manager</span>
                    </a>
                </li>
                @if(Auth::user()->level == "admin")
                <li class="nav-item">
                    <a href="{{ route('userAttendance') }}" class="nav-link {{ (Route::currentRouteName() == 'userAttendance') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-map-pin"></i>
                        </span>
                        <span class="pcoded-mtext">User Attendance</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('weeks.index') }}" class="nav-link {{ (Route::currentRouteName() == 'weeks.index') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-activity"></i>
                        </span>
                        <span class="pcoded-mtext">Weekly Working Plan</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ (Route::currentRouteName() == 'permission.index') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-user"></i>
                        </span>
                        <span class="pcoded-mtext">Manage User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('permission.index') }}" class="nav-link {{ (Route::currentRouteName() == 'permission.index') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-mail"></i>
                        </span>
                        <span class="pcoded-mtext">User Permission</span>
                    </a>
                </li>
                @endif
                <li class="nav-item pcoded-menu-caption">
                    <label>Account</label>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings') }}" class="nav-link {{ (Route::currentRouteName() == 'settings') ? 'active' : '' }}">
                        <span class="pcoded-micon">
                            <i class="feather icon-settings"></i>
                        </span>
                        <span class="pcoded-mtext">Settings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link ">
                        <span class="pcoded-micon">
                            <i class="feather icon-power"></i>
                        </span>
                        <span class="pcoded-mtext">Logout</span>
                    </a>
                </li>
            </ul>
            <div class="card text-center">
                <div class="card-block">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="feather icon-phone f-40"></i>
                    <h6 class="mt-3">Butuh bantuan?</h6>
                    <p>Silahkan hubungi developer untuk meminta bantuan</p>
                    <a href="https://api.whatsapp.com/send?phone=+6285750492918&text=Halo%20mas%20alfan%20saya%20butuh%20bantuan%20terkait%20aplikasi%20AWS" target="_blank" class="btn btn-primary btn-sm text-white m-0">Kontak</a>
                </div>
            </div>
        </div>
    </div>
</nav>