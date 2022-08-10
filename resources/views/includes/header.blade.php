<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed header-blue">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        <a href="#!" class="b-brand">

            <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="" class="logo-thumb">
        </a>
        <a href="#!" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="#!" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon feather icon-bell"></i><span class="badge bg-danger"><span class="sr-only"></span></span></a>
                    <div class="dropdown-menu dropdown-menu-right notification">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">Notifications</h6>
                        </div>
                        <ul class="noti-body" style="height: fit-content !important;" id="notifications">
                            
                        </ul>
                        <!-- <div class="noti-footer">
                            <a href="#">Show all</a>
                        </div> -->
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown drp-user">
                    <a href="#!" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('assets/images/user/'.Auth::user()->avatar) }}" class="img-radius wid-40" alt="User-Profile-Image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-notification">
                        <div class="pro-head d-flex justify-space-between">
                            <img src="{{ asset('assets/images/user/'.Auth::user()->avatar) }}" class="img-radius" alt="User-Profile-Image">
                            <div>
                                <span>{{ Auth::user()->name }}</span>
                                <small class="d-block">{{ ucfirst(Auth::user()->level) }} - {{ Auth::user()->job_title }}</small>
                            </div>
                        </div>
                        <ul class="pro-body">
                            <li class="{{ (Route::currentRouteName() == 'settings') ? 'active' : '' }}"><a href="{{ route('settings') }}" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li>
                            <li><a href="{{ route('logout') }}" class="dropdown-item"><i class="feather icon-power"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>