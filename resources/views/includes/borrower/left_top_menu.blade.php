<!-- Sidebar -->
    
<nav id="sidebar">
        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="content-header content-header-fullrow px-15 mt-10 " style="height: 90px !important">
                <!-- Mini Mode -->
                <div class="content-header-section sidebar-mini-visible-b">
                    <!-- Logo -->
                    <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                        <span class="text-dual-primary-dark">D</span><span class="text-primary">B</span>
                    </span>
                    <!-- END Logo -->
                </div>
                <!-- END Mini Mode -->

                <!-- Normal Mode -->
                <div class="content-header-section text-left pl-20 align-parent sidebar-mini-hidden">
                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                    <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times text-danger"></i>
                    </button>
                    <!-- END Close Sidebar -->

                    <!-- Logo -->
                    <div class="content-header-item ">
                        <a class="link-effect font-w600 " href="">
                            <span class="font-size-h3 text-primary">DSI </span><span class="font-size-h3 text-dual-primary-dark">Penerima Pendanaan</span>
                        </a>
                    </div>
                    <!-- END Logo -->
                </div>
                <!-- END Normal Mode -->
            </div>
            <!-- END Side Header -->

            <!-- Side User -->
            <div class="content-side content-side-full content-side-user px-10 align-parent">

                <!-- Visible only in normal mode -->
                <div id="slide-side" class="sidebar-mini-hidden-b">
                    <div class="block text-left bg-white mb-0" style="padding-bottom: 0px;">
                        <p class="font-w700 pl-4 pt-2">
                            <i class="fa fa-bell text-muted"></i> 
                            <span class="dsiColor pl-10"> Informasi Pendanaan</span>
                        </p>
                        
                            @if(!empty(Session::get('pendanaan')))
                            <div class="js-slider slick-nav-hover" data-dots="true" data-arrows="true">
                            @foreach(Session::get('pendanaan') as $row)
                                <div class="text-center bg-white mb-0 pb-5 ">
                                    <a class="block-content block-content-full block-content-sm">
                                        <div class="font-size-h6 font-w600">{{$row->nama}}</div>
                                        <div class="text-muted">@if(!empty($row->tgl_jatuh_tempo)) Jatuh Tempo : {{date("d-M-Y",strtotime($row->tgl_jatuh_tempo))}} @endif</div>
                                    </a>
                                </div>
                            @endforeach
                            </div> 
                            @endif
                            <!-- <div class="text-center bg-white mb-0 pb-5 ">
                                <a class="block-content block-content-full block-content-sm ">
                                    <div class="font-size-h6 font-w600">Pendanaan X/2019...</div>
                                    <div class="text-muted">Jatuh Tempo : 01/02/2019</div>
                                </a>
                            </div>
                            <div class="text-center bg-white mb-0 pb-5 ">
                                <a class="block-content block-content-full block-content-sm ">
                                    <div class="font-size-h6 font-w600">Pendanaan X/2019...</div>
                                    <div class="text-muted">Jatuh Tempo : 01/03/2019</div>
                                </a>
                            </div> -->
                         
                    </div>           
                </div>
                <!-- END Visible only in normal mode -->
            </div>
            <!-- END Side User -->
            <?php if(Auth::guard('borrower')->check() && (Auth::guard('borrower')->user()->status == 'notfilled' || Auth::guard('borrower')->user()->status == 'reject')){
                $dashboard = "/borrower/lengkapi_profile";
                $ajukan = "/borrower/lengkapi_profile";
                $pendanaanPage = "/borrower/lengkapi_profile";
                $riwayat = "/borrower/lengkapi_profile";
                $pengaturanakun = "/borrower/lengkapi_profile";
            }elseif(Auth::guard('borrower')->check() && Auth::guard('borrower')->user()->status == 'pending'){
                $dashboard = "/borrower/dashboardPendanaan";
                $ajukan = "/borrower/dashboardPendanaan";
                $pendanaanPage = "/borrower/dashboardPendanaan";
                $riwayat = "/borrower/dashboardPendanaan";
                $pengaturanakun = "/borrower/dashboardPendanaan";
            }elseif(Auth::guard('borrower')->user()->status == 'active'){
                $dashboard = "/borrower/dashboardPendanaan";
                $ajukan = "/borrower/ajukanPendanaan";
                $pendanaanPage = "/borrower/pendanaanPage";
                $riwayat = "/borrower/all_riwayat_mutasi_borrower";
                $pengaturanakun = "/borrower/edit_profile_borrower";
            }?>
                
            <!-- Side Navigation -->
            <div class="content-side content-side-full">
                <ul class="nav-main">
                    <li>
                        <a class="active" href="<?php echo $dashboard;?>">
                            <i class="si si-bar-chart"></i>
                            <span class="sidebar-mini-hide">Dasbor</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="si si-briefcase"></i>
                            <span class="sidebar-mini-hide">Pendanaan</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{$ajukan}}">Ajukan Pendanaan</a>
                            </li>
                            <li>
                                <a href="{{$pendanaanPage}}">Lihat Pendanaan</a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li>
                        <a href="{{$riwayat}}">
                            <i class="si si-book-open"></i>
                            <span class="sidebar-mini-hide">Riwayat Mutasi</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="si si-settings"></i>
                            <span class="sidebar-mini-hide">Akun</span>
                        </a>
                        <ul>                            
                            <li>
                                <a href="/edit_profile_borrower">Edit Profile</a>
                            </li>
                            <li>
                                <a href="/notifikasi_borrower">Notifikasi</a>
                            </li>
                            <li>
                                <a href="/log_borrower">Log Aktifitas</a>
                            </li>
                            <li>
                                <a href="/faq_borrower">FAQ</a>
                            </li>
                            <li>
                                <a href="/lock_borrower">Lock Screen</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                            <i class="fa fa-lightbulb-o"></i>
                            <span class="sidebar-mini-hide">Theme <small>beta</small> </span>
                        </a>
                        <ul>                            
                            <li>
                                <i class="fa fa-moon-o float-left pt-10 pr-10"></i>
                                <a href="#" data-toggle="layout" data-action="sidebar_style_inverse_on"> Dark</a>
                            </li>
                            <li>
                                <i class="fa fa-sun-o float-left pt-10 pr-10"></i>
                                <a href="#" data-toggle="layout" data-action="sidebar_style_inverse_off">Light</a>
                            </li>
                        </ul>
                    </li> -->
                    <li>
                            <a href="{{$pengaturanakun}}">
                                <i class="si si-bar-chart"></i>
                                <span class="sidebar-mini-hide">Pengaturan Akun</span>
                            </a>
                    </li>
                </ul>
            </div>
            <!-- END Side Navigation -->
        </div>
        <!-- Sidebar Content -->
    </nav>
    <!-- END Sidebar -->

    <!-- Header -->
    <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
            <!-- Left Section -->
            <div class="content-header-section">
                <!-- Toggle Sidebar -->
                <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                    <i class="fa fa-navicon"></i>
                </button>
                <a class="btn btn-dual-secondary">
                        <span class="font-w400 ml-2 judul" style="font-size: 1.271429rem;">Hai, <span class="judul">{{Session::get('brw_nama')}}</span></span>
                </a>
                <!-- END Toggle Sidebar -->
            </div>
            <!-- END Left Section -->

            <!-- Right Section -->
            <div class="content-header-section">    
                <span id="status-plafon" >
                    <a style="font-size: .93rem" class="mr-4 judul">
                        <i class="fa fa-circle mr-5 text-primary"></i><span class="font-w500 text-dark">Plafon </span>Rp. {{number_format(Session::get('brw_ptotal'),2,",",".")}}
                    </a>
                    <a style="font-size: .93rem" class="mr-4 judul">
                        <i class="fa fa-circle mr-5 text-warning"></i><span class="font-w500 text-dark">Terpakai </span>Rp. {{number_format(Session::get('brw_ppake'),2,",",".")}}
                    </a>
                    <a style="font-size: .93rem" class="mr-4 judul">
                        <i class="fa fa-circle mr-5 text-success"></i><span class="font-w500 text-dark">Tersedia </span>Rp. {{number_format(Session::get('brw_psisa'),2,",",".")}}
                    </a> 
                </span>

                <div class="btn-group show" role="group">
                    <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fa fa-bell text-dark"></i>
                        <span class="badge badge-primary badge-pill">5</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right min-width-300" style="z-index: 9999" aria-labelledby="page-header-notifications" x-placement="bottom-end" style="position: absolute; transform: translate3d(-231px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notifications</h5>
                        <ul class="list-unstyled my-20">
                            <li>
                                <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                    <div class="ml-5 mr-15">
                                        <i class="fa fa-fw fa-check text-success"></i>
                                    </div>
                                    <div class="media-body pr-10">
                                        <p class="mb-0">You’ve upgraded to a VIP account successfully!</p>
                                        <div class="text-muted font-size-sm font-italic">15 min ago</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                    <div class="ml-5 mr-15">
                                        <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                                    </div>
                                    <div class="media-body pr-10">
                                        <p class="mb-0">Please check your payment info since we can’t validate them!</p>
                                        <div class="text-muted font-size-sm font-italic">50 min ago</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                    <div class="ml-5 mr-15">
                                        <i class="fa fa-fw fa-times text-danger"></i>
                                    </div>
                                    <div class="media-body pr-10">
                                        <p class="mb-0">Web server stopped responding and it was automatically restarted!</p>
                                        <div class="text-muted font-size-sm font-italic">4 hours ago</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                    <div class="ml-5 mr-15">
                                        <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                                    </div>
                                    <div class="media-body pr-10">
                                        <p class="mb-0">Please consider upgrading your plan. You are running out of space.</p>
                                        <div class="text-muted font-size-sm font-italic">16 hours ago</div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                                    <div class="ml-5 mr-15">
                                        <i class="fa fa-fw fa-plus text-primary"></i>
                                    </div>
                                    <div class="media-body pr-10">
                                        <p class="mb-0">New purchases! +$250</p>
                                        <div class="text-muted font-size-sm font-italic">1 day ago</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center mb-0" href="/notifikasi_borrower">
                            <i class="fa fa-flag mr-5"></i> View All
                        </a>
                    </div>
                </div>

                <!-- Toggle Side Overlay -->
                <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                <button id="btn_logout" onclick="location.href='{{route('borrower.logout')}}'" class="btn btn-dual-secondary text-danger" >
                    <i class="si si-power"></i> Keluar
                </button>
                <!-- END Toggle Side Overlay -->
            </div>
            <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Search -->
        <div id="page-header-search" class="overlay-header">
            <div class="content-header content-header-fullrow">
                <form>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <!-- Close Search Section -->
                            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
                            <button type="button" class="btn btn-secondary px-15" data-toggle="layout" data-action="header_search_off">
                                <i class="fa fa-times"></i>
                            </button>
                            <!-- END Close Search Section -->
                        </div>
                        <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary px-15">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Header Search -->

        <!-- Header Loader -->
        <div id="page-header-loader" class="overlay-header bg-primary">
            <div class="content-header content-header-fullrow text-center">
                <div class="content-header-item">
                    <i class="fa fa-sun-o fa-spin text-white"></i>
                </div>
            </div>
        </div>
        <!-- END Header Loader -->
    </header>
    <!-- END Header -->