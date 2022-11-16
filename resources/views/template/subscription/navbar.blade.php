@php
$subscription_admin_count = \App\Models\SubscriptionUser::where('user_id', auth()->id())
    ->where('subscription_users.role', '!=', 'member')
    ->where('subscription_users.role', '!=', 'moderator')
    ->where('subscription_users.is_accepted', true)
    ->count();

if(session('accounting_system_id'))
    $curr_acct_sys = \App\Models\AccountingSystem::where('id', session('accounting_system_id'))->first();

$acct_systems = \App\Models\SubscriptionUser::select(
            'accounting_systems.id as accounting_system_id',
            'accounting_systems.name',
            'accounting_systems.accounting_year',
            'accounting_systems.calendar_type',
            'subscriptions.id as subscription_id',
            'users.firstName as user_first_name',
            'users.lastName as user_last_name',
        )
        ->where('subscription_users.user_id', Auth::id())
        ->rightJoin('accounting_system_users', 'subscription_users.id', '=', 'accounting_system_users.subscription_user_id')
        ->leftJoin('accounting_systems', 'accounting_system_users.accounting_system_id', '=', 'accounting_systems.id')
        ->leftJoin('subscriptions', 'subscription_users.subscription_id', '=', 'subscriptions.id')
        ->leftJoin('users', 'subscriptions.user_id', '=', 'users.id')
        ->where('subscription_users.is_accepted', true)
        ->get();

$route_name = Route::currentRouteName();
$route_name = explode('.', $route_name);
$route_name = $route_name[0];
@endphp

 <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar" role="tablist">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <img src="{{URL::asset('img/logo-64x51.png')}}" id="brand_logo" style="width:auto;height:56px!important">
            </a>

            @if(auth()->user()->must_update_password == false && !(auth()->user()->firstName == 'New' && auth()->user()->lastName == 'User'))

                <!-- Divider -->
                <hr class="sidebar-divider">

                @if(isset($curr_acct_sys))
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Go back
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-fw fa-arrow-left"></i>
                            <span>{{ $curr_acct_sys->name }}</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">
                @endif

                @if(!isset($curr_acct_sys) && count($acct_systems) == 1)
                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Go To
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-fw fa-arrow-left"></i>
                            <span>{{ $acct_systems[0]->name }}</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">
                @endif


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
                        <a class="nav-link dynamic-nav" href="{{ url('/control/admins') }}">
                            <i class="fas fa-fw fa-user"></i>
                            <span>Manage Super Admins</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link dynamic-nav" href="{{ url('/control/subscriptions') }}">
                            <i class="fas fa-fw fa-user"></i>
                            <span>Manage Subscriptions</span>
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                @endif

                <!-- Heading -->
                <div class="sidebar-heading">
                    Subscriptions
                </div>

                <li class="nav-item">
                    <a class="nav-link active dynamic-nav" href="{{ url('/subscription/') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Subscriptions</span>
                    </a>
                </li>

                @if($subscription_admin_count > 0)
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

                @endif

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Your Account
                </div>

                <li class="nav-item">
                    <a class="nav-link active dynamic-nav" href="{{ url('/account/') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Account Settings</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active dynamic-nav" href="{{ url('/referrals/') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Referrals</span>
                    </a>
                </li>

            @endif

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
                    <h5>
                        @if($route_name == 'control') Control Panel
                        @elseif($route_name == 'subscription') Subscription
                        @elseif($route_name == 'account' || $route_name == 'referrals') Your Account
                        @endif
                    </h5>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        {{-- <li class="nav-item dropdown no-arrow d-sm-none">
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
                        </li> --}}

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <span>{{ auth()->user()->firstName }} ▼</span>
                                </span>
                                {{-- <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg"> --}}
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                @if(Auth::user()->control_panel_role != null)
                                    <a class="dropdown-item" href="{{ url('/control') }}">
                                        <i class="fas fa-fw fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Control Panel
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ url('/subscription') }}">
                                    <i class="fas fa-fw fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Subscription Panel
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/account') }}">
                                    <i class="fas fa-fw fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Account Settings
                                </a>
                                <a class="dropdown-item" href="{{ url('/referrals') }}">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Referrals
                                </a>
                                <div class="dropdown-divider"></div>
                                @if(session('acct_system_count') > 1)
                                    <a class="dropdown-item" href="{{ url('/switch') }}">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Switch Accounting Systems
                                    </a>
                                @endif
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

