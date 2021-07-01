<div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                    <div class="header-left">


                        <div class="dropdown for-notification">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="count bg-danger">{{ session('jumlahNotif') }}</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="notification">
                            <p class="red">You have Notification</p>
                            @if (session('kalimat') == '')
                                <a class="dropdown-item media bg-flat-color-1" href="#">
                                    {{-- <i class="fa fa-check"></i> --}}
                                    <p>{{ session('kalimat') }}</p>
                                </a>
                            @else
                                <a class="dropdown-item media bg-flat-color-1" href="{{ route('admin.proyek.manage') }}">
                                    <i class="fa fa-check"></i>
                                    <p>{{ session('kalimat') }}</p>
                                </a>
                            @endif
                          </div>
                        </div>

                        <div class="dropdown for-message">
                          <button class="btn btn-secondary dropdown-toggle" type="button"
                                id="message"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-email"></i>
                            <span class="count bg-primary">0</span>
                          </button>
                          <div class="dropdown-menu" aria-labelledby="message">
                            <p class="red">You have Mails</p>
                            <a class="dropdown-item media bg-flat-color-1" href="#">
                                <span class="message media-body">
                                    <span class="name float-left">Under Construction</span>
                                </span>
                            </a>
                            
                          </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{Auth::user()->email}}
                        </a>

                        <div class="user-menu dropdown-menu">
                                 <a class="nav-link" href="/admin/logout"><i class="fa fa-power -off"></i>Logout</a>
                        </div>
                    </div>



                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->