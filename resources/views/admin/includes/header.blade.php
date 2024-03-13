<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('admin/images/AdminLTELogo.png') }}" alt="" height="60" width="60">
</div>

<div id="pageloader">
        <!--<img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />-->
        <!--<img src="https://acegif.com/wp-content/uploads/loading-11.gif" alt="processing..." />-->
    <img src="https://cutewallpaper.org/21/loading-gif-transparent-background/CBP-Portal.gif" alt="processing..." />
</div>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-th-large"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ auth()->user()->name }}</span>
                <div class="dropdown-divider"></div>
                <a href="{{ URL('admin/change-password') }}" class="dropdown-item">
                    <i class="fas fa-lock mr-2"></i> Change Password
                </a>
                <!--<div class="dropdown-divider"></div>-->
                <!--a href="{{ URL('admin/logout') }}" class="dropdown-item">
                    <i class="fas fa-key mr-2"></i> Logout
                </a-->
            </div>
        </li>
        <!--li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li-->
    </ul>
</nav>
<!-- /.navbar -->
