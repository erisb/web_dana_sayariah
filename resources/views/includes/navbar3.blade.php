
<style>
    #navbar-ext {
      overflow: hidden;
      background-color: rgba(76, 175, 80, 0.6);
    }

    #navbar-ext h1 {
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }

    /* Global Button */
    .transparent_btn {
      display: inline-block;
      padding: 10px 14px;
      color: #f2f2f2;
      border: 1px solid #FFF;
      text-decoration: none;
      font-size: 17px;
      line-height: 120%;
      background-color: rgba(255,255,255, 0);
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      -webkit-transition: background-color 300ms ease;
      -moz-transition: background-color 300ms ease;
      transition: background-color 300ms ease;
      cursor: pointer;
    }
    .transparent_btn:hover {
      background-color: rgba(255,255,255, 0.3);
      color: #FFF;
    }
    /* Green Button */
    .transparent_btn.green {
      color: #86ec93;
      border-color: #86ec93;
    }
    .transparent_btn.green:hover {
      background-color: rgba(134, 236, 147, 0.3);
    }
</style>
@include('includes.login_as')

<header class="main-header sticky-header" id="main-header-2">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light rounded">
                    <a class="navbar-brand logo navbar-brand d-flex w-50 mr-auto" href="/">
                        <img src="/img/logo.png" alt="logo">
                    </a>
                            
                    <button class="navbar-toggler collapsed text-right" type="button" data-toggle="collapse" data-target="#navbar_test" aria-controls="#navbar_test" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="icon-bar top-bar mx-auto"></span>
                      <span class="icon-bar middle-bar mx-auto"></span>
                      <span class="icon-bar bottom-bar mx-auto"></span>				
                    </button>
                    <div class="collapse navbar-collapse w-auto" id="navbar_test">
                        <ul class="navbar-nav ml-auto">
                          <!--
                          <li class="nav-item login_header pb-1 pt-0 pl-2 my-auto mlcustome-sm-0">
                                <a  href="{{ url('getPage/id') }}">
                                  <img src="/img/iconfinder_ID_167781.png" height="15" alt="indonesia">
                                </a>
                          </li>
                          <li class="nav-item pl-4 pr-4 pb-1 pt-0 my-auto mlcustome-sm-0"  >
                                <a href="{{ url('getPage/en') }}">
                                  <img src="/img/iconfinder_US_167805.png" height="15" alt="english">
                                </a>
                          </li>
                          -->  
                              <a class="nav-link dropdown-toggle border-radius-sm-0" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span>@lang('menu.investasi')</span>
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                  <li><a class="dropdown-item" href="/penggalangan-berlangsung">@lang('menu.investasi_1')</a></li>
                                  <li><a class="dropdown-item" href="/penggalangan-full">@lang('menu.investasi_2')</a></li>
                                  <li><a class="dropdown-item" href="/penggalangan-closed">@lang('menu.investasi_3')</a></li>
                                  <li><a class="dropdown-item" href="/modal-usaha-property">@lang('menu.investasi_4')</a></li>
                              </ul>
                          </li>
                          <li class="nav-item dropdown my-auto">
                              <a class="nav-link dropdown-toggle border-radius-sm-0" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span>@lang('menu.tatacara')</span>
                              </a>
                              <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                  <li><a class="dropdown-item" href="/tata-cara/pendana">@lang('menu.tatacara_1')</a></li>
                                  <li><a class="dropdown-item" href="/tata-cara/penerima">@lang('menu.tatacara_2')</a></li>
                                  <li><a class="dropdown-item" href="/tata-cara/pengaduan">@lang('menu.tatacara_3')</a></li>
                              </ul>
                          </li>
                          <li class="nav-item dropdown my-auto">
                              <a class="nav-link dropdown-toggle border-radius-sm-0" href="#" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <span>@lang('menu.tentang')</span>
                              </a>
                              <ul class="dropdown-menu col-12" aria-labelledby="navbarDropdownMenuLink">
                                  <li><a class="dropdown-item " href="/news">@lang('menu.berita')</a></li>
                                  <li><a class="dropdown-item" href="/tentang-kami/khazanah">@lang('menu.tentang_1')</a></li>
                                  <li><a class="dropdown-item" href="/tentang-kami/tim-kami">@lang('menu.tentang_2')</a></li>
                                  <li><a class="dropdown-item" href="/tentang-kami/kontak">@lang('menu.tentang_3')</a></li>
                              </ul>
                          </li>
                          
                          

                          @if (Auth::check('user') && Auth::user()->status != 'Not Active')
                            <li class="nav-item dropdown my-auto">
                                  <a class="nav-link dropdown-toggle border-radius-sm-0" href="#" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  
                                  <img src="{{ !empty(Auth::user()->detilInvestor) ? Storage::url(Auth::user()->detilInvestor->pic_investor) : asset('img/profile.png') }}" width="40" height="40" class="rounded-circle"> 
                                  <span class="pl-2"> Hai, 
                                    <!-- ---------////////////////////////////// -->
                                    <!-- BACA INI YA :) hapus komen ini , batasi panjang karakter nama user 12 karakter saja -->
                                    <!-- ---------////////////////////////////// -->
                                    <span class="namaUser">{{ !empty(Auth::user()->detilInvestor) ? Illuminate\Support\Str::words(Auth::user()->detilInvestor->nama_investor, 12, ' ...') : '' }}</span> 
                                  </span>                               
                                </a>
                                  <ul class="dropdown-menu">
                                      <li>
                                        <a class="dropdown-item" href="/user/dashboard">
                                              <span>Dasbor</span>
                                          </a>
                                      </li>
                                      <li class="divider"></li>
                                      <li><a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                              <span>{{-- __('Logout') --}}Keluar</span>
                                          </a>
                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              @csrf
                                          </form></li>
                                  </ul>
                              </li>    
                          @elseif (Auth::guard('borrower')->check() && Auth::guard('borrower')->user()->status != 'Not Active')
                          
                            <li class="nav-item dropdown my-auto">
                                  <a class="nav-link dropdown-toggle border-radius-sm-0" href="#" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  
                                  <img src="{{ !empty(Auth::guard('borrower')->user()->detilBorrower) ? Storage::url(Auth::guard('borrower')->user()->detilBorrower->brw_pic) : asset('img/profile.png') }}" width="40" height="40" class="rounded-circle"> 
                                  <span class="pl-2"> Hai, 
                                    <!-- ---------////////////////////////////// -->
                                    <!-- BACA INI YA :) hapus komen ini , batasi panjang karakter nama user 12 karakter saja -->
                                    <!-- ---------////////////////////////////// -->
                                    <span class="namaUser">{{ !empty(Auth::guard('borrower')->user()->detilBorrower) ? Illuminate\Support\Str::words(Auth::guard('borrower')->user()->detilBorrower->nama, 12, ' ...') : '' }}</span> 
                                  </span>                               
                                </a>
                                  <ul class="dropdown-menu">
                                      <li>
                                      @if (Auth::guard('borrower')->check() && (Auth::guard('borrower')->user()->status == 'notfilled' || Auth::guard('borrower')->user()->status == 'reject'))
                                        <a class="dropdown-item" href="/borrower/lengkapi_profile">
                                      @elseif (Auth::guard('borrower')->check() && Auth::guard('borrower')->user()->status == 'pending' || Auth::guard('borrower')->user()->status == 'active')
                                        <a class="dropdown-item" href="/borrower/dashboardPendanaan">
                                      @endif
                                              <span>Dasbor</span>
                                          </a>
                                      </li>
                                      <li class="divider"></li>
                                      <li><a class="dropdown-item"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                              <span>{{-- __('Logout') --}} Keluar</span>
                                          </a>
                                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              @csrf
                                          </form></li>
                                  </ul>
                              </li>

                          @else

                          <li class="nav-item login_header ml-lg-5 my-auto">
                              <a class="btn-md btn-block btn-danaSyariah text-white border-radius-sm-0" href="#" data-toggle="modal" data-target="#loginModalAs">
                                  <span>Masuk</span>
                              </a>
                          </li>
                          <!-- <li class="nav-item my-auto"  >
                              <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">
                                  <span>@lang('menu.daftar')</span>
                              </a>
                          </li> -->
                          
                          @endif
                                                                         
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- register nitifikasi -->
      @if (Auth::check('user') && (Auth::user()->status == 'notfilled' || Auth::user()->status == 'reject'))
      <div id="info-user1">
        <hr style="margin: 0;">
        <div id="navbar-ext" class="text-center pt-1">
          <h6 class="p-2"> Satu Langkah lagi untuk menjadi Pendana
          <a href="{{url('user/dashboard')}}" class="btn px-auto badge badge-success p-2 mt-5-onMobile"> <i class="fas fa-edit ml-2"></i>  Klik Disini! </a>
          <i data-toggle="tooltip" title="Hide!" id="close-btn1" class="btn lni-close text-dark float-right mr-4 mt-1" style="cursor:pointer;"></i>                          
        </h6>                     
        </div>
      </div>
      @elseif (Auth::check('user') && Auth::user()->status == 'pending')
      <div id="info-user">
        <hr style="margin: 0;">
        <div id="navbar-ext" class="text-center pt-1">
          <h6 class="p-2"> Akun Anda sedang dalam proses verifikasi. Mohon tunggu sampai <span class="badge badge-success text-white"> 1x24 Jam </span>  (hari kerja)   
            <i data-toggle="tooltip" title="Hide!" id="close-btn" class="lni-close text-dark float-right mr-4" style="cursor:pointer;"></i>                 
          </h6>        
        </div> 
      </div>                 
      @elseif (Auth::check('user') && Auth::user()->status == 'Not Active')
      <div id="info-user">
        <hr style="margin: 0;">
        <div id="navbar-ext" class="text-center pt-1">
          <h4 class="p-2"> Silahkan cek email anda untuk melakukan aktivasi   
            <i data-toggle="tooltip" title="Hide!" id="close-btn" class="lni-close text-dark float-right mr-4" style="cursor:pointer;"></i>                 
          </h4>        
        </div>
      @endif

      @if (Auth::guard('borrower')->check() && (Auth::guard('borrower')->user()->status == 'notfilled' || Auth::guard('borrower')->user()->status == 'reject'))
      
      <div id="info-user1">
        <hr style="margin: 0;">
        <div id="navbar-ext" class="text-center pt-1">
          <h6 class="p-2"> Satu Langkah lagi untuk menjadi Penerima Pendanaan
          <a href="{{url('borrower/lengkapi_profile')}}" class="btn px-auto badge badge-success p-2 mt-5-onMobile"> <i class="fas fa-edit ml-2"></i>  Klik Disini! </a>
          <i data-toggle="tooltip" title="Hide!" id="close-btn1" class="btn lni-close text-dark float-right mr-4 mt-1" style="cursor:pointer;"></i>                          
        </h6>                     
        </div>
      </div>
    
    @elseif (Auth::guard('borrower')->check() && Auth::guard('borrower')->user()->status == 'Not Active')
      <div id="info-user">
        <hr style="margin: 0;">
        <div id="navbar-ext" class="text-center pt-1">
          <h4 class="p-2"> Silahkan cek email anda untuk melakukan aktivasi   
            <i data-toggle="tooltip" title="Hide!" id="close-btn" class="lni-close text-dark float-right mr-4" style="cursor:pointer;"></i>                 
          </h4>        
        </div> 
      </div>

      @elseif (Auth::guard('borrower')->check() && Auth::guard('borrower')->user()->status == 'pending')
      <div id="info-user">
        <hr style="margin: 0;">
        <div id="navbar-ext" class="text-center pt-1">
          <h6 class="p-2"> Akun Anda sedang dalam proses verifikasi. Mohon tunggu sampai <span class="badge badge-success text-white"> 1x24 Jam </span>  (hari kerja)   
            <i data-toggle="tooltip" title="Hide!" id="close-btn" class="lni-close text-dark float-right mr-4" style="cursor:pointer;"></i>                 
          </h6>        
        </div> 
      </div>                 
      @endif
</header>
