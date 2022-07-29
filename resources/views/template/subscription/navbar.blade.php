@php
$subscription_admin_count = \App\Models\SubscriptionUser::where('user_id', auth()->id())
    ->where('subscription_users.role', '!=', 'member')
    ->where('subscription_users.role', '!=', 'moderator')
    ->count();
@endphp
 
 <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" role="tablist">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                {{-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> --}}
                <div class="sidebar-brand-text mx-3">HMEZGEB</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/switch') }}">
                    <i class="fas fa-fw fa-arrow-left"></i>
                    <span>Acct. System Selection</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if(auth()->user()->control_panel_role != null)
                <!-- Heading -->
                <div class="sidebar-heading">
                    Control Panel
                </div>

                {{-- <li class="nav-item">
                    <a class="nav-link active dynamic-nav" href="{{ url('/control/') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link dynamic-nav" href="{{ url('/control') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Manage Users</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

            @endif


            @if($subscription_admin_count > 0)

                <!-- Heading -->
                <div class="sidebar-heading">
                    Subscriptions
                </div>

                <li class="nav-item">
                    <a class="nav-link active dynamic-nav" href="{{ url('/subscription/') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Subscription Summary</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active dynamic-nav" href="{{ url('/subscription/accounting-systems') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Manage Acct. Systems</span><br>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link dynamic-nav" href="{{ url('/subscription/users') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Manage Users</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

            @endif

            <!-- Heading -->
            <div class="sidebar-heading">
                Your Account
            </div>

            <li class="nav-item">
                <a class="nav-link active dynamic-nav" href="{{ url('/subscription/') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Account Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link active dynamic-nav" href="{{ url('/subscription/') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Referrals</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Accounting System Name & Year -->
                    <h5>Subscription Panel</h5>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">  
                                     {{-- {{ Auth::user()->firstName}} {{Auth::user()->lastName }}  --}}
                                </span>
                                {{-- <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg"> --}}
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                @if(Auth::user()->control_panel_role != null)
                                    <a class="dropdown-item" href="/control/">
                                        <i class="fas fa-fw fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Control Panel
                                    </a>
                                @endif
                                <a class="dropdown-item" href="/subscription/">
                                    <i class="fas fa-fw fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Subscription Panel
                                </a>
                                <a class="dropdown-item" href="/account/">
                                    <i class="fas fa-fw fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Account Settings
                                </a>
                                <a class="dropdown-item" href="/referrals/">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Referrals
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                 <!-- Begin Page Content -->
                <div class="container-fluid">


               

                <!-- content of the website -->
                <main>
                        @yield('content')
                </main>
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- /.container-fluid -->
           
