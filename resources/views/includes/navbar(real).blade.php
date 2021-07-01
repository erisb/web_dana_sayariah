<style>
    .nav-link:hover {
        background: #0faf3f !important;  
    }
    .nav-link:hover span {
        color: white !important;
    }
    /* .nav-link span {
        font-size: 15px;
        color: #F1C411 ;
    }
    .dropdown-item  {
        color: #F1C411 !important;
    } */
    /* .dropdown-item:hover  {
        color: #FFF !important;
    } */
</style>
@include('includes.login_register')
<header class="main-header sticky-header" id="main-header-2">
    <div class="container col-12">
        <div class="row">
            <div class="">
                <nav class="navbar navbar-expand-lg navbar-light col-12" style="margin: 0px;background:">
                    <a href="/" class="col-4">
                    <img class="col-12 m-0" src="/img/logo.png" alt="logo" style="width:auto;" >
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa fa-bars"></span>
                    </button>
                   


                    
                    <div class="navbar-collapse collapse col-8" id="navbar">

                    @if (Auth::check())
                    <ul class="nav navbar-nav justify-content-center col-8" style="margin-top: auto;">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>PENDANAAN</span> 
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="/penggalangan_berlangsung">PENGGALANGAN DANA SEDANG BERLANGSUNG</a></li>
                                    <li><a class="dropdown-item" href="/modal_usaha_property">MODAL USAHA PROPERTI</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>TATACARA</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="/tata-cara/pendana">MENJADI PENDANA</a></li>
                                    <li><a class="dropdown-item" href="/tata-cara/penerima">MENJADI PENERIMA PEMBIAYAAN</a></li>
                                </ul>
                            </li>
                    </ul>

                    @else
                    <ul class="nav navbar-nav justify-content-center col-8" style="margin-top: auto;">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>INVESTASI</span> 
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="/penggalangan_berlangsung">PENGGALANGAN DANA SEDANG BERLANGSUNG</a></li>
                                    <li><a class="dropdown-item" href="/modal_usaha_property">MODAL USAHA PROPERTI</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>TATACARA</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="/tata-cara/pendana">MENJADI PENDANA</a></li>
                                    <li><a class="dropdown-item" href="/tata-cara/penerima">MENJADI PENERIMA PEMBIAYAAN</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>TENTANG KAMI</span>
                                </a>
                                <ul class="dropdown-menu col-12" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="/tentang-kami/khazanah">KHAZANAH</a></li>
                                    <li><a class="dropdown-item" href="/tentang-kami/tim-kami">TIM KAMI</a></li>
                                    <li><a class="dropdown-item" href="/tentang-kami/kontak">KONTAK</a></li>
                                </ul>
                            </li>
                        </ul>

                    @endif

                    
                        <ul class="nav navbar-nav col-4">
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>ACCOUNT &nbsp;</span>
                                    <span class="glyphicon glyphicon-user"></span>
                                </a>
                                <ul class="dropdown-menu col-12" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" data-toggle="modal" data-target="#loginModal">MASUK</a></li>
                                    <li><a class="dropdown-item" data-toggle="modal" data-target="#registerModal">DAFTAR</a></li>
                                </ul>
                            </li> -->
                            @if (Auth::check())
                            <li class="nav-item login_header">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                     <span>{{ __('LOGOUT') }}</span>
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                     @csrf
                                 </form>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/user/dashboard">
                                    <span>PROFILE</span>
                                </a>
                            </li>
                            @else
                            <li class="nav-item login_header">
                                <a class="nav-link" data-toggle="modal" data-target="#loginModal">
                                    <span>LOGIN</span>
                                </a>
                            </li>
                            <li class="nav-item"  >
                                <a class="nav-link" data-toggle="modal" data-target="#registerModal">
                                    <span>REGISTER</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <a class="" href=""><img src="/img/flag-usa.jpg" style="padding-top: auto !important;"></a>
                </nav>
            </div>
        </div>
    </div>
</header>

@if (session('emailconfirmation'))
    <script>
    window.alert('Silahkan cek email Anda untuk konfirmasi akun');
    window.location.href="/";
    </script>
@endif