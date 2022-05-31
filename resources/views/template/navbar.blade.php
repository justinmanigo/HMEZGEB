@php
    use App\Models\Notification;

    $modules = \App\Models\Settings\Users\Module::get();
    $permissions = \App\Actions\GetAccountingSystemUserPermissions::run($modules, session('accounting_system_user_id'), true);

    $accounting_system = \App\Models\AccountingSystem::find(session('accounting_system_id'));
    $accounting_system_count = \App\Models\AccountingSystemUser::where('user_id', Auth::user()->id)->count();
    $accounting_period = \App\Models\Settings\ChartOfAccounts\AccountingPeriods::find(session('accounting_period_id'));
    $accounting_period_year = \Carbon\Carbon::parse($accounting_period->date_from);

    $notifications = Notification::orderBy('created_at', 'desc')->get();
    $unreadNotifications = Notification::where('read', 0)->count();
@endphp
 
 <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

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
                <a class="nav-link" href="/home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            {{-- <div class="sidebar-heading">
                Interface
            </div> --}}

            @for($i = 0; $i < count($modules); $i++)
                {{-- If there are more than 1 submodules --}}
                @if(count($permissions[$i]) > 1)
                    {{-- The count refers to the number of module's submodules permitted for use by the authenticated user. --}}
                    @php $count = 0; @endphp
                    {{-- Iterate on permissions to determine whether to show submodule or not. --}}
                    @foreach($permissions[$i] as $permission)
                        @if($permission->access_level != null || \App\Actions\CheckDuplicateSubModulePermission::run(session('accounting_system_user_id'), $permission->duplicate_sub_module_id) != null)
                            {{-- This checks whether the menu has already been shown. This will be checked once. --}}
                            @if($count == 0)
                                <li class="nav-item">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse-{{ $i }}"
                                        aria-expanded="true" aria-controls="collapse-{{ $i }}">
                                        <i class="fas fa-fw fa-money-bill-alt"></i>
                                        <span>{{ ucwords($modules[$i]->name) }}</span>
                                    </a>
                                    <div id="collapse-{{ $i }}" class="collapse" aria-labelledby="heading-{{ $i }} }}" data-parent="#accordionSidebar">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <h6 class="collapse-header">Menu:</h6>
                            @endif
                            {{-- The submodule item. --}}
                            <a class="collapse-item" href="{{ url($permission->url) }}">{{ ucwords($permission->name) }}</a>
                            {{-- Increment permitted module's submodules count. --}}
                            @php $count++; @endphp
                        @endif
                    @endforeach
                    @if($count > 0)
                                </div>
                            </div>
                        </li>
                    @endif

                    {{-- <a class="collapse-item" href="/receipt">Receipt</a>
                    <a class="collapse-item" href="/customer">Customer</a>
                    <a class="collapse-item" href="/deposit">Deposit</a> --}}
              

                {{-- If there is only one submodule --}}
                @else
                    @if($permissions[$i][0]->access_level != null)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url($permissions[$i][0]->url) }}">
                                <i class="fas fa-fw fa-clipboard-list"></i>
                                <span>{{ ucwords($permissions[$i][0]->name) }}</span></a>
                        </li>
                    @endif
                @endif
            @endfor

            <!-- Nav Item - Settings Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#settings"
                    aria-expanded="true" aria-controls="settings">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <div id="settings" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu:</h6>
                        <a class="collapse-item" href="/settings/company">Company Info</a>
                        <a class="collapse-item" href="/settings/users">Users</a>
                        <a class="collapse-item" href="/settings/themes">Theme</a>
                        <a class="collapse-item" href="/settings/taxes">Taxes</a>
                        <a class="collapse-item" href="/settings/withholding">Withholding</a>
                        <a class="collapse-item" href="/settings/payroll">Payroll Rules</a>
                        <a class="collapse-item" href="/settings/coa">Chart of Account</a>
                        <a class="collapse-item" href="/settings/inventory">Inventory</a>
                        <a class="collapse-item" href="/settings/defaults">Defaults</a>
                        {{-- <a class="collapse-item" href="utilities-other.html">Taxes</a> --}}
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

        

            <!-- Divider -->
            {{-- <hr class="sidebar-divider d-none d-md-block"> --}}

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
                    <div>
                        <strong>{{ date('Y') }} - {{ $accounting_system->name }}</strong><br>
                        <small><strong>{{ "Accounting Period # {$accounting_period->period_number}" }}</strong> | {{ $accounting_period_year->format('M Y') }}</small>
                    </div>

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

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                @if ($unreadNotifications > 0)
                                <span class="badge badge-danger badge-counter">{{$unreadNotifications}}</span>  
                                @endif
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                @if (count($notifications)==0)
                                    <a class="dropdown-item d-flex align-items-center">
                                        <div>
                                            No Notification
                                        </div>
                                    </a>
                                @else
                                    {{-- Display Notification --}}
                                    @foreach ($notifications->take(3) as $notification)
                                        @if($notification->read=='0')
                                        {{-- Not yet read --}}
                                            <a class="dropdown-item d-flex align-items-center bg-light" href="/{{$notification->link}}">
                                                <div>
                                                    <div class="small font-weight-bold">{{ $notification->created_at->diffForHumans() }}</div>
                                                    @if ($notification->type=='warning')
                                                    <span class="font-weight-bold text-warning">{{ $notification->title }}</span>
                                                    @elseif ($notification->type=='danger')
                                                    <span class="font-weight-bold text-danger">{{ $notification->title }}</span>
                                                    @elseif($notification->type=='success')
                                                    <span class="font-weight-bold text-success">{{ $notification->title }}</span>
                                                    @else
                                                    <span class="font-weight-bold">{{ $notification->title }}</span>
                                                    @endif
                                                    <br>
                                                    {{ $notification->message }}
                                                </div>
                                            </a>
                                            @else
                                            <a class="dropdown-item d-flex align-items-center " href="/{{$notification->link}}">
                                                <div>
                                                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                                    <span class="small">{{ $notification->title }}<br>
                                                    {{ $notification->message }}</span>
                                                </div>
                                            </a> 
                                            
                                        @endif
                                    @endforeach
                                    {{-- See all notifications --}}
                                    <a class="dropdown-item text-center" href="/notifications">Show All Alerts</a>
                                @endif
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
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
                                <a class="dropdown-item" href="/account/">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Account Settings
                                </a>
                                <a class="dropdown-item" href="/referrals/">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Referrals
                                </a>
                                <div class="dropdown-divider"></div>
                                @if($accounting_system_count > 1)
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
           
