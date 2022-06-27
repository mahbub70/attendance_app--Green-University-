
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('front-end/images/gree-logo.png') }}">
    <!-- Datatable -->
    <link href="{{ asset('dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
      <!-- Pick date -->
      <link rel="stylesheet" href="{{ asset('dashboard/vendor/pickadate/themes/default.css') }}">
      <link rel="stylesheet" href="{{ asset('dashboard/vendor/pickadate/themes/default.date.css') }}">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    @yield('css')
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                {{-- <img class="logo-abbr" src="{{ asset('front-end/images/gree-logo.png') }}" alt=""> --}}
                {{-- <img class="logo-compact" src="{{ asset('front-end/images/gree-logo.png') }}" alt=""> --}}
                <img class="brand-title" src="{{ asset('front-end/images/gree-logo.png') }}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->



		
		
        <!--**********************************
            Header start
        ***********************************-->Manage
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
								@yield('page-title')
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
							<li class="nav-item">
								<div class="input-group search-area d-xl-inline-flex d-none">
									<div class="input-group-append">
										<span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
									</div>
									<input type="text" class="form-control" placeholder="Search here...">
								</div>
							</li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    <img src="{{ asset('dashboard/images/profile/17.jpg') }}" width="20" alt=""/>
									<div class="header-info">
										<span class="text-black"><strong>{{ Auth::user()->name }}</strong></span>
										<p class="fs-12 mb-0">{{ CustomHelper::get_role_name(Auth::user()->role) }}</p>
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ route('account.my') }}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a class="dropdown-item ai-icon" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    @if (Auth::user()->role == 5)
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-networking"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.management') }}" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-settings-2"></i>
                                <span class="nav-text">Management</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.students.dipartments') }}" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-settings-2"></i>
                                <span class="nav-text">Departments</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.attendance.report') }}" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-networking"></i>
                                <span class="nav-text">Attendances Report</span>
                            </a>
                        </li>
                    @endif   
                    @if (Auth::user())
                        <li>
                            <a href="{{ route('account.my') }}" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-settings-2"></i>
                                <span class="nav-text">My Account</span>
                            </a>
                        </li> 
                        @if (Auth::user()->role == 1)
                            <li>
                                <a href="{{ route('students.attendance') }}" class="ai-icon" aria-expanded="false">
                                    <i class="flaticon-381-networking"></i>
                                    <span class="nav-text">Attendances</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('student.result.make') }}" class="ai-icon" aria-expanded="false">
                                    <i class="flaticon-381-networking"></i>
                                    <span class="nav-text">Make Result</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->role == 5 || Auth::user()->role == 1)
                        <li>
                            <a href="{{ route('all.students.result') }}" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-networking"></i>
                                <span class="nav-text">Students Result</span>
                            </a>
                        </li>
                        @endif
                    @endif
                    @if (Auth::user())
                        @if(Auth::user()->role == 0)
                            <li>
                                <a href="{{ route('students.attendance.report') }}" class="ai-icon" aria-expanded="false">
                                    <i class="flaticon-381-networking"></i>
                                    <span class="nav-text">Attendances Report</span>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        @yield('page-content')
        <!--**********************************
            Content body end
        ***********************************-->
        
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('dashboard/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/custom.min.js') }}"></script>
	<script src="{{ asset('dashboard/js/deznav-init.js') }}"></script>
    
	
    <!-- Datatable -->
    <script src="{{ asset('dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins-init/datatables.init.js') }}"></script>





    <!-- Daterangepicker -->
 
    <!-- pickdate -->
    <script src="{{ asset('dashboard/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/pickadate/picker.date.js') }}"></script>



 
    <!-- Pickdate -->
    <script src="{{ asset('dashboard/js/plugins-init/pickadate-init.js') }}"></script>


    @yield('js')
</body>
</html>