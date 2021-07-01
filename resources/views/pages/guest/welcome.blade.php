@extends('layouts.guest.masterhome')

@section('style')
<style>
body{
    overflow-x: hidden;
}
/*
    .counter-box i{
      color: #0faf3f !important;
    }
    .counter-box h1, .counter-box h5 {
      color: #0faf3f !important;
    } */

    .table td
    {
        padding: .8em;
        padding-bottom: .6em;
    }
    .lead
    {
        font-size: 1rem;
        font-weight: bold;

    }
    .notify-badge{

        z-index: 900;
        width: 20% !important;
        height: 140px;
        width: 100px;

    }
    .flaticon{
        color: black;
    }
    .bg-css{
        /* background: #0e6003; */
        color: white;
    }

    .hover-card{
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, .1);
    }
    .hover-card:hover{
        box-shadow: 0 0 8px 0 rgba(0, 0, 0, .3);
        transition: all 0.4s;
    }


    /******************  News Slider Demo-7 *******************/


 .post-slide{
     padding-right:20px;
     display: inline-block;
 }
 .post-slide img{
     width: 100%;
     height: auto;
 }
 .post-slide .post-review{
 }
 .post-slide .post-date{
     float:left;
     margin-right: 10px;
     padding: 8px 15px;
     text-align:center;
     background:#444;
     font-size:26px;
     color:#fff;
     font-weight:700;
     transition:background 0.20s linear 0s;
 }
 .post-slide:hover .post-date{
     background:#078071;
 }
 .post-slide .post-date small{
     display:block;
     margin-bottom:10px;
     font-size: 13px;
     text-transform: capitalize;
 }
 .post-slide .post-date small:before{
     content:"";
     display:block;
     margin-bottom:5px;
     border-top:1px solid #fff;
 }
 .post-slide .post-title{
     margin: 0;
     padding-top: 15px;
 }
 .post-slide .post-title a{
     font-size:15px;
     color: #444;
     text-transform: uppercase;
     margin-bottom: 6px;
     display: block;
     line-height:20px;
     font-weight: bold;
 }
 .post-slide:hover .post-title a{
     color:#078071;
     text-decoration:none;
 }
 .post-comment{
     margin: 0;
     list-style:none;
 }
 .post-comment li a{
     color:#a9a9a9;
     text-transform:capitalize;
 }
 .post-comment li a:before{
     content:"|";
     margin:0 5px 0 5px;
     color:#d3d3d3;
 }

 @media only screen and (max-width: 480px) {
     .post-slide{
         padding: 0;
     }
     .modal-dialog {
         width: 100% !important;
     }
 }

@media only screen and (device-width: 768px) {
  /* For general iPad layouts */
  .col-md-4{
        max-width: 304px;
    }
    .modal-dialog {
        width: 100% !important;
    }
}

/* .headingText{
    font-size: 3vw;
} */
.modal-dialog {
      max-width: 800px;
      margin: 30px auto;
  }



.modal-body {
  position:relative;
  padding:0px;
}
.close {
  position:absolute;
  right:-30px;
  top:0;
  z-index:999;
  font-size:2rem;
  font-weight: normal;
  color:#fff;
  opacity:1;
}
/* play btn */
.video-thumbnail {
  position: relative;
  display: inline-block;
  cursor: pointer;
  margin: 30px;

  &:before {
    position:absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    content: "\f01d";
    font-family: FontAwesome;
    font-size: 100px;
    color: #fff;
    opacity: .8;
    text-shadow: 0px 0px 30px rgba(0, 0, 0, 0.5);
  }
  &:hover:before {
    color: #eee;
  }
}
.cover-image{
    display: block;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
}
.bold{
    font-weight: bolder;
}

</style>
@endsection
{{-- @if (Carbon\Carbon::now()->toDateString() >= Carbon\Carbon::parse(29-12-2019))
    
@else
  @include('includes.newversion')    
@endif --}}

@section('navbar')
@include('includes.navbar')

@endsection

@section('body')

<!-- hero end -->
<!-- hero us start -->
<div>
    <div class="about-us content-area-2 bg-green-soft banner-style-one " data-speed-x="30" data-speed-y="40">
        <!-- <img  alt="dana syariah indonesia"class="lozad" data-src="img/wave-static-02.svg" class="w-100 position-absolute ts-bottom__0"> -->
    <div>

        <div id="parallax-container" class="container  pb-5 banner-style-two pt-5-onMobile" >
            <div class="row pt-5  pt-5-onMobile" data-speed-x="10" data-speed-y="10">
                <div class="col-lg-7 col-xs-12 align-self-center pt-5 pt-5-onMobile order-1" >
                        <div class="about-text pt-2 " >
                            
                            <h2 class="heading-slide pt-1 "> 
                                <span class="text-pagar" style="color: #24921D; line-height: 0.7em" >
                                <span class="pb-1" style="font-size: .4em; color:#02775B; font-style: italic;">@lang('welcome.welcome_01')</span><br> 
                                <span class="text-pagar" style="font-size: .6em; line-height: 1em;">
                                    <span style="color: #183710;"></span>
                                    <!-- <span style="color: #CD9240; margin-left: -15px;">@lang('welcome.welcome_02')</span> -->
                                    <span style="color: #CD9240; margin-left: -15px; font-weight: 400;">Marhaban</span>
                                </span>
                                <span class="text-pagar" style="font-size: .8em; line-height: 1em;">
                                    <!-- <span style="color: #02775B; margin-left: -5px;">@lang('welcome.welcome_03')</span>    -->
                                    <span style="color: #02775B; margin-left: -5px;">Ya Ramadhan</span>  
                                </span> 
                                <br>
                                </span> 
                                <br class=""> 
                                <span style="font-size: .6em; line-height: 1.3em; font-weight: 500;">
                                    <br>
                                    <span style="color: #183710;">
                                    @lang('welcome.welcome_04')
                                    </span>
                                </span>
                            </h2>
                        
                            <div class="row align-items-end">
                                <div class="col-12">
                                
                                    <p style="font-size: .8em; line-height: 1.5em; font-weight: 400;" class="pb-3">@lang('welcome.welcome_05')  </p>    
                                </div>
                                <div  class="col mt-3">
                                    <a href="https://play.google.com/store/apps/details?id=com.danasyariah.mobiledanasyariah" class="banner-btn-android mb-3  mr-4 parallax wowc fadeInUp delay-04s" data-speed-x="10" data-speed-y="4">
                                        <i  class="fa fa-play"></i>
                                        @lang('welcome.welcome_06')<span>Google Play</span>
                                    </a>
                                    <a href="https://itunes.apple.com/US/app/id1461445952?mt=8" class="banner-btn parallax  mb-3" data-speed-x="20" data-speed-y="4">
                                        <i class="fab fa-apple"></i>
                                        @lang('welcome.welcome_06')<span>App Store</span>
                                    </a>
                                </div>
                            </div>
                                                        
                            
                        </div>                       
                    </div>
                    
                    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 pt-5 mt-2 order-sm-3">
                        <div id="container" >
                            <img  alt="dana syariah indonesia"class="start-png-home parallax d-none d-xl-block d-lg-block pl-10" class="lozad" src="/img/phone.png"  alt="" data-speed-x="60" data-speed-y="44"> 
                        </div>
                    </div>
                    
                    
                </div>
                <div> 
                <div class="container mb-3" style="padding-top: 5rem; ">
                    <div class="delapan-keunggulan lazy pt-2 slick-slider">
                            <div class="slide-wrap slick-slider">
                                <div class="card image parallax mx-auto" >
                                    <div class="features-center counter-box">
                                        <img  alt="dana syariah indonesia" class="lozad" data-src="/img/investorRocket.png" style="width: 20%; display: inline-block;"  alt="Dana Syariah Pendanaan">
                                        <h4 class="pt-4">99.85%</h4>
                                        <!--                    <h5>
                                        @php
                                            $tkb = 100- (($dana_crowd / $dana_pinjaman) * 1);
                                            echo $tkb;
                                        @endphp %
                                        </h5> -->
                                        @php
                                        $dt= Carbon\Carbon::now()->format('m');
                                        if ($dt == 1) {
                                            $Bulan = "Januari";
                                        } elseif ($dt == 2) {
                                            $Bulan ="Februari";
                                        } elseif ($dt == 3) {
                                            $Bulan ="Maret";
                                        } elseif ($dt == 4) {
                                            $Bulan ="April";
                                        } elseif ($dt == 5) {
                                            $Bulan ="Mei";
                                        } elseif ($dt == 6) {
                                            $Bulan ="Juni";
                                        } elseif ($dt == 7) {
                                            $Bulan ="Juli";
                                        } elseif ($dt == 8) {
                                            $Bulan ="Agustus";
                                        } elseif ($dt == 9) {
                                            $Bulan ="September";
                                        } elseif ($dt == 10) {
                                            $Bulan ="Oktober";
                                        } elseif ($dt == 11) {
                                            $Bulan ="November";
                                        } elseif ($dt == 12) {
                                            $Bulan ="Desember";
                                        } else {$Bulan = "";}
                                        @endphp
                                        <h5>@lang('welcome.TKB') {{ $Bulan.' '.\Carbon\Carbon::now()->format('Y') }} )</h5><!-- format indo -->
                                    </div>
                                </div>
                            </div>
                            <div class="slide-wrap slick-slider">
                                <div class="card image parallax mx-auto" >
                                    <div class="counter-box featured-center">
                                        <img  alt="dana syariah indonesia" class="lozad pt-5" data-src="/img/agenMitra.png" style="width: 20%; display: inline-block;" alt="Pendana Dana Syhariah">
                                        <h4 class="counter pt-4">{{ $jumlah_investor }}</h4>
                                        <h5>@lang('welcome.Total_investor')</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="slide-wrap slick-slider">
                                <div class="card image parallax mx-auto" >
                                    <div class="counter-box featured-center">
                                        <img  alt="dana syariah indonesia" class="lozad pt-5" data-src="/img/pendanaanSelesai.png" style="width: 20%; display: inline-block;" alt="Dana Syariah Pendanaan">
                                        <h4 class="pt-4">
                                        Rp. 
                                            @php
                                                $number = $dana_pinjaman;
                                                if ($number < 1000000) {
                                                    // ribuan
                                                    $format = number_format($number / 1000, 2,',','.') . ' Ribu';
                                                } 
                                                else if ($number < 1000000000) {
                                                    // jutaan
                                                    $format = number_format($number / 1000000, 2,',','.') . ' JT';
                                                } 
                                                else if ($number < 1000000000000) {
                                                    // milliar
                                                    $format = number_format($number / 1000000000, 2,',','.') . ' M';
                                                }
                                                else {
                                                    // milliar
                                                    $format = number_format($number / 1000000000000, 2,',','.') . ' T';
                                                }

                                                echo $format
                                            @endphp


                                        </h4>
                                        <h5>@lang('welcome.Total_pinjaman_a')</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="slide-wrap slick-slider">
                                <div class="card image parallax mx-auto" >
                                    <div class="counter-box featured-center">
                                        <img  alt="dana syariah indonesia"class="lozad pt-5" data-src="/img/pendanaanAktif.png" style="width: 20%; display: inline-block;" alt="Dana Syariah Pendanaan">
                                        <h4 class="pt-4">
                                        Rp. 
                                                @php
                                                    $number = $dana_pinjaman_2;
                                                    if ($number < 1000000) {
                                                        // ribuan
                                                        $format = number_format($number / 1000, 2,',','.') . ' Ribu';
                                                    } 
                                                    else if ($number < 1000000000) {
                                                        // jutaan
                                                        $format = number_format($number / 1000000, 2,',','.') . ' JT';
                                                    } 
                                                    else if ($number < 1000000000000) {
                                                        // milliar
                                                        $format = number_format($number / 1000000000, 2,',','.') . ' M';
                                                    }
                                                    else {
                                                        // milliar
                                                        $format = number_format($number / 1000000000000, 2,',','.') . ' T';
                                                    }

                                                    echo $format
                                                @endphp


                                        </h4>
                                        <h5>@lang('welcome.Total_pinjaman_b')</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="slide-wrap slick-slider">
                                <div class="card image parallax mx-auto" >
                                    <div class="counter-box  featured-center">
                                        <img  alt="dana syariah indonesia" class="lozad pt-5" data-src="/img/borrowerAll.png" style="width: 20%; display: inline-block;" alt="Dana Syariah Pendanaan">
                                        <h4 class="pt-4">{{ $borrower_all }}</h4>
                                        <h5>@lang('welcome.Jumlah_borrower')</h5>
                                    </div>
                                </div> 
                            </div>
                            <div class="slide-wrap slick-slider">
                                <div class="card image parallax mx-auto" >
                                    <div class="counter-box fetured-center">
                                        <img  alt="dana syariah indonesia" class="lozad pt-5" data-src="/img/borrowerAktiff.png" style="width: 20%; display: inline-block;" alt="Dana Syariah Pendanaan">
                                        <h4 class="pt-4">{{ $borrower_aktif }}</h4>
                                        <h5>@lang('welcome.Jumlah_borrower_a')</h5>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-5 order-1"> 
                <div class="hero-slide lazy pt-2 slick-slider">
                    <div class="slide-wrap slick-slider">
                        <div class="image parallax" >
                            <a href="https://berkah.danasyariah.id/" >
                                <div class="row no-gutters card-m card-m-round" style="background-color: #FCFFFC; margin-left: 25px; margin-right: 25px">
                                    <div class="col-12 p-5">                        
                                        <h2 class="card-title bold">Ayo Cari Berkah</h2>
                                        <p class="card-text pb-5">Keberkahan dan kemudahan dalam berdonasi dan pelaksanaan </br> Zakat,Infaq, Sodaqoh. Aman, Mudah & Amanah </br><strong>#100%delivered.</strong></p>
                                        <a href="https://berkah.danasyariah.id/" class="card-link mt-5 pt-5 bold">Donasi Sekarang →</a>                                                                        
                                    </div>
                                    <div class="image-card-right mt-3 d-none d-sm-none d-md-block">
                                        <span>
                                        <img src="img/wa-1.png" style="width: auto !important" height="230" class="pull-right"/>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="image parallax" >
                            <a href="/penggalangan-berlangsung">
                                <div class="row no-gutters card-m card-m-round" style="background-color: #FCFFFC; margin-left: 25px; margin-right: 25px">
                                    <div class="col-12 p-5">                        
                                        <h2 class="card-title bold">Pendanaan Properti</h2>
                                        <p class="card-text pb-5">ikuti proyek-proyek yang sudah terverifikasi ketat </br> oleh Tim Danasyariah.id </p>
                                        <a href="/penggalangan-berlangsung" class="card-link mt-5 pt-5 bold">Ikuti Sekarang →</a>                                                                        
                                    </div>
                                    <div class="image-card-right mt-3 d-none d-sm-none d-md-block">
                                        <span>
                                        <img src="img/wa-2.png" style="width: auto !important" height="230" class="pull-right"/>
                                        </span>
                                    </div>
                                </div>
                                <!-- <img  alt="dana syariah indonesia" class="lozad slick-slider" data-src="{{asset('/storage')}}/{{$carousel_kedua}}" /> -->
                            </a>
                        </div>
                    </div>
                    <div class="slick-slider">
                        <div class="image parallax" >
                            <a id="keunggulan_btn" href="#keunggulan">
                                <div class="row no-gutters card-m card-m-round" style="background-color: #FCFFFC; margin-left: 25px; margin-right: 25px">
                                    <div class="col-12 p-5">                        
                                        <h2 class="card-title bold">Ayo Tunaikan Zakat</h2>
                                        <p class="card-text pb-5">Tunaikan kewajiban zakat mu, untuk rezeki yang lebih berkah </br>dunia & akhirat.</p>
                                        <a href="https://berkah.danasyariah.id/ziswaf" class="card-link mt-5 pt-5 bold">Kalkulator Zakat →</a>                                                                        
                                    </div>
                                    <div class="image-card-right mt-3 d-none d-sm-none d-md-block">
                                        <span>
                                        <img src="img/wa-3.png" style="width: auto !important" height="230" class="pull-right"/>
                                        </span>
                                    </div>
                                </div>
                                <!-- <img  alt="dana syariah indonesia" class="lozad slick-slider" data-src="{{asset('/storage')}}/{{$carousel_ketiga}}" /> -->
                            </a>
                        </div>
                    </div>                   
                </div>
            </div>      
            </div>          
                
        </div>
    </div>
    <div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <h2>Produktifkan Danamu bersama <b>Danasyariah.id</b></h2>
            <p class="mb-5">Manfaatkan banyak keunggulan dengan menjadi #PendanaHalal  di <b>Danasyariah.id</b> dan #AyoCariBerkah dengan melaksanakan Zakat dan memberikan donasi terbaikmu</p>
        </div>        
        <div class="col-md-4 col-xs-12 mb-5">
            <div class="card">
                <a class="features-center" href="/penggalangan-berlangsung">
                    <img src="img/property.png" height="100" alt="">
                    <div class="konten">
                        <p class="card-text">Pendanaan Property yang sudah terverifikasi danasyariah</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 mb-5">
            <div class="card">
                <a class="features-center" href="https://berkah.danasyariah.id">
                    <img src="img/sosial.png" height="100"  alt="">
                    <div class="konten">
                        <p class="card-text">Pendanaan Sosial untuk membantu sesama</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 mb-5">
            <div class="card">
                <a class="features-center" href="https://berkah.danasyariah.id/ziswaf">
                    <img src="img/zakat.png" height="100"  alt="">
                    <div class="konten">
                        <p class="card-text">Tunaikan Kewajiban Zakatmu bersama danasyariah.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<section class="video-box-style-one gray-bg pt-5">
    <div class="thm-container container">
        <div class="col-md-12 col-xs-12 col-sm-12 mb-10" style="padding-left: 0px; padding-left: 0px">
            <div class="row ">
                <div class="col-md-6 col-xs-12 col-sm-12 mb-5">
                    <div class="card-m card-m-round" style="background-color: #FFFCF0;">
                        <div class="block p-5">
                            <h3 class="card-title bold">@lang('welcome.reg_inv')</h3>
                            <p class="card-text pb-5">@lang('welcome.desc_inv') </p>
                            <a href="#" href="#" data-toggle="modal" data-target="#loginModalAs" class="card-link btn btn-success pl-3 pr-3"> Jadi Pendana</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-12 mb-5">
                    <div class="card-m card-m-round" style="background-color: #F4F9EE;">
                        <div class="block p-5">
                            <h3 class="card-title bold">@lang('welcome.reg_donatur')</h3>
                            <p class="card-text pb-5">@lang('welcome.desc_donatur')</p>
                            <a href="https://berkah.danasyariah.id/admin-donatur/register" class="btn btn-info card-link  pl-3 pr-3">Jadi Donatur</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section  id="proyek" class="pb-0 ts-block ts-overflow__hidden ts-shape-mask__down pt-5" 
data-bg-color="#fff" data-bg-image="/img/" 
data-bg-repeat="no-repeat" data-bg-position="bottom" data-bg-size="inherit" 
style=" background-image: url('/img/'); background-size: inherit; background-repeat: no-repeat; background-position: left top;">           
<div class="featured-properties content-area-2 bg-transparent dsi-block " >
    <div class="container-fluid"> 
        <div class="row">
            <div class="container"> 
                <div class="row">                       
                    <div class="col-lg-8 align-self-center">
                        <div class="about-text mt-2">
                        <h1 style="font-weight: 600;">@lang('welcome.pendanaan_aktif')</h1>
                        <p style="font-size: 18px">@lang('welcome.pendanaan_aktif_det')</p>
                            
                        </div>
                    </div>
                    
                </div>
            </div> 
            <div class="container-fluid "> 
        <div class="col-lg-12 ml-auto justify-content-end">               
            <div class="row slick-normal ">
                @foreach ($proyek as $proyek)
                <div class="slick-slide-item mt-5 mb-3 wow fadeInUp delay-0{{$proyek->id}}s">
                    
                    <div class="slide-wrap property-box project-card single-service-one" >
                      
                        <div class="property-thumbnail cover-image" >
                                    
                            <a href="/proyek/{{$proyek->id}}" class="property-img">
                            
                                <div style="font-weight: bold;  margin: 0; float: right;">
                                    @if($proyek->status == 2)
                                    <!-- <div class="tag button alt featured bg-secondary"></div> -->
                                    <div class="ribbon-wrapper-green"><div class="ribbon-green">Closed</div></div>  
                                    @elseif($proyek->status == 3)
                                    <div class="ribbon-wrapper-green"><div class="ribbon-gold">Full</div></div> 
                                    @else
                                    <div class="tag button alt featured" style="font-size: 12px; background-color: #1F5865;"><i class="fas fa-stopwatch"></i> Sisa {!! date_diff(date_create(Carbon\Carbon::now()->format('Y-m-d')),date_create(Carbon\Carbon::parse($proyek->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d') + 1 !!} Hari Lagi</div>
                                    @endif
                                </div>
                            
                                <!-- <div class="tag button alt featured-right two_chars" style="position: absolute; background-color: white; color: ">{{substr($proyek->profit_margin, 0, 2)}}%
                                </div> -->

                                
                                
                                <img  alt="dana syariah indonesia" src="/storage/{{$proyek->gambar_utama}}" style="max-height:150px; margin-top: 0px; border-radius: 5px 5px 5px 5px; object-fit: cover;" alt="property-1" class="img-fluid">
                            </a>                       
                        </div>
                        <a href="/proyek/{{$proyek->id}}" class="property-img">
                        <div class="detail" style="cursor:default;">
                            <div class="location row no-gutters">
                                    <div class="col-12 text-left">
                                        <div class="ratings text-secondary">
                                            <h6 class="bold">{{$proyek->nama}}</h6>                                
                                        </div>
                                    </div>
                                    <div class="col-6 text-left">
                                        <div class="ratings text-dark">
                                            <span class="proyek-bold">Dana Terkumpul</span>                                
                                        </div>
                                    </div>
                                    <div class="col-6 text-right">
                                        <div>
                                            @if($proyek->status == 2)
                                                
                                                <h1 class="title" style=" color: #00775b; font-weight: 600; ">{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}  %
                                                </h1>
                                                
                                            @elseif($proyek->status == 3)
                                            
                                                <h1 class="title" style=" color: #00775b; font-weight: 600; ">100%
                                                </h1>
                                                
                                                
                                            @else
                                                @if($proyek->total_need > 0)
                                                <h1 class="title" style=" color: #00775b; font-weight: 600; ">{{$proyek->total_need !=0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}  %
                                                </h1>
                                                
                                                @else
                                                
                                                <h1 class="title" style=" color: #00775b; font-weight: 600; ">0.00%
                                                </h1>
                                                
                                                @endif
                                            @endif
                                            
                                        </div>
                                    </div>
                        <!--<div class="detail">-->
                        <!--    <div style="font-weight: bold;  margin: 0; float: right;">-->
                        <!--        @if($proyek->status == 2)-->
                        <!--            <span class="badge badge-warning badge-sm">Closed</span>-->
                        <!--        @elseif($proyek->status == 3)-->
                        <!--            <span class="badge badge-success badge-sm">Full</span>-->
                        <!--        @else-->
                        <!--        Sisa Hari <span class="badge badge-light badge-sm">{{ Carbon\Carbon::now()->parse($proyek->tgl_selesai_penggalangan)->diffInDays()+2 }}</span></span>-->
                        <!--        @endif-->
                        <!--    </div>-->
                        <!--    {{-- <button type="button" class="btn btn bg-css"  style="font-weight: bold; padding:2px; margin: 0; float: right;">-->
                        <!--        Sisa Hari <span class="badge badge-primary badge-sm">{{ $proyek->tgl_selesai->diffInDays(Carbon\Carbon::now()->toDateString()) }}</span></span>-->
                        <!--        <span class="sr-only">days left</span>-->
                        <!--    </button> --}}-->
                        <!--    <h5 style=" margin:5px;display: block;width: 200px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; float:left;color:black; !important">{{$proyek->nama}}&nbsp;&nbsp;</h5>-->
                        <!--    <div class="location" style="margin-left:0.5rem !important;">-->
                        <!--        <a href="https://www.google.com/maps/place/{{$proyek->alamat}}" target="_Blank">-->
                        <!--            <i class="flaticon-facebook-placeholder-for-locate-places-on-maps flaticon" style="  display: block;width: 200px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{$proyek->alamat}}</i>-->
                        <!--        </a>-->
                            </div>
                            <!-- progressbar -->
                            <div>                                                        
                                <div>
                                        <div>
                                            <!--  //close -->
                                            @if($proyek->status == 2) 
                                                <div class="progress-outer">
                                                    <div class="progress" style="background-color: #e2e3e4; height: 10px;">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="font-weight: bold; box-shadow:-1px 10px 10px rgba(116, 195, 116,0.7) !important; font-size: 15px; width:{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}%" aria-valuenow="{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- //full -->
                                            @elseif($proyek->status == 3) 
                                                <div class="progress-outer">
                                                    <div class="progress" style="background-color: #e2e3e4; height: 10px;">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="font-weight: bold; box-shadow:-1px 10px 10px rgba(116, 195, 116,0.7) !important; font-size: 15px; width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                @if($proyek->total_need > 0) 
                                                <div class="progress-outer">
                                                    <div class="progress" style="background-color: #e2e3e4; height: 10px;">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped active"  role="progressbar" style="font-weight: bold; box-shadow:-1px 10px 10px rgba(116, 195, 116,0.7) !important; font-size: 15px; width:{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}%" aria-valuenow="{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                
                                                <div class="progress-outer">
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped active" style="width:0%; box-shadow:-1px 10px 10px rgba(116, 195, 116,0.7) !important;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>                                                  
                                                    </div>
                                                </div>
                                                @endif
                                            @endif
                                            
                                        </div>
                                </div>
                            </div>
                            <div class="location row no-gutters pt-3">
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12  text-left pr-2">
                                        <div class="ratings text-secondary">
                                            <span class="p-text-regular">Dana Dibutuhkan</span> <br> 
                                            <span class="p-text-bold" >Rp {{number_format($proyek->total_need,  0, '', '.')}}</span>                               
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12  text-left pt-onMobile">
                                        <div class="ratings text-secondary ">
                                            <span class="p-text-regular" >Durasi Proyek</span>  <br>
                                            <span class="p-text-bold">{{$proyek->tenor_waktu}} Bulan</span>                               
                                        </div>
                                    
                                    </div>
                            </div>
                            <div class="location row no-gutters">
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12  text-left pr-2">
                                        <div class="ratings text-secondary">
                                            <span class="p-text-regular" >Imbal Hasil/Tahun</span> <br> 
                                        <span class="p-text-bold"> 
                                            Rp {{number_format((($proyek->total_need*($proyek->profit_margin/100))),0, '', '.')}}
                                            ({{$proyek->profit_margin}}%)
                                        </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12  text-left pt-onMobile">
                                        <div class="ratings text-secondary ">
                                            <span class="p-text-regular" >Minimum Pendanaan</span>  <br>
                                            <span class="p-text-bold">Rp {{number_format($proyek->harga_paket,  0, '', '.')}}</span>                               
                                        </div>
                                    
                                    </div>
                            </div>
                            <div class=" row no-gutters">
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12  text-left">
                                        <div class="ratings text-secondary">
                                            <span class="p-text-regular" >Jenis Akad</span> <br> 
                                             <span class="p-text-bold">@if($proyek->akad == 1)
                                                    Murabahah
                                                @else
                                                    Mudharabah
                                                @endif
                                            </span>                               
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 text-left pt-onMobile">
                                        <div class="ratings text-secondary ">
                                            <span class="p-text-regular" >Terima Imbal Hasil</span>  <br>
                                            <span class="p-text-bold">@if($proyek->waktu_bagi == 1)
                                                    Tiap Bulan
                                                @else
                                                    Akhir Proyek
                                                @endif
                                            </span>                               
                                        </div>
                                    
                                    </div>
                            </div>
                            <div class=" wow fadeInUp delay-10s">
                                <a  class="line-button" href="/proyek/{{$proyek->id}}" style="font-size: 0.6em; padding-top: 5em; color: #175D43; text-decoration: underline;"><i> @lang('language.selengkapnya')  →</i></a>
                            </div>
                        </div>
                        </a>
                    </div>
                    
                </div>   
                @endforeach
                
            </div>
        </div>

        </div>     
        <!-- end for -->
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="main-title pb-2 pt-0 mr-4 wow fadeInUp delay-10s">
                        <a  href="/penggalangan-berlangsung" class="btn btn-md banner-btn-right-ico ">@lang('proyek.lihat') <i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
</section>
<!-- Modal Video -->
<!-- Modal -->
<div class="modal fade" id="myModal" style="z-index:9999" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      
      <div class="modal-body">

       <button id="pause" type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>        
        <!-- 16:9 aspect ratio -->
        <div class="embed-responsive embed-responsive-16by9">
            {{-- <iframe class="video-to-stop embed-responsive-item" class="lozad" data-src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe> --}}
        </div>
        
        
      </div>

    </div>
  </div>
</div> 
<!-- end Modal Video -->


<!-- Testimonial Slider DSI -->`
<div class="testimonial  bg-dsi-gradient-flip ">
    <div class="customer-feedback  pt-5">
        <div class="container text-center ">
            <div class="row">
                <div class="col-12 ">
                    <div>
                        <h1 class="section-title" style="font-weight: 600;">@lang('welcome.testimoni')</h1>
                        <p > @lang('welcome.testimoni_det')</p>
                    </div>
                </div><!-- /End col -->
            </div><!-- /End row -->

            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel feedback-slider p-10">
                        <!-- Start Source Code Old
                        <div class="feedback-slider-item">
                            <img  alt="dana syariah indonesia" src="/img/hilman.png" class=" mx-auto rounded-circle" alt="Customer Feedback">
                            <h3 class="customer-name">Hilman Suyudi</h3>
                            <p>@lang('welcome.testimoni_1')</p>
                            <a rel="noreferrer" href="https://www.youtube.com/watch?v=uJFNbkpoZY0&list=UULPxmUGo-cK2ai9LLJeO--A&index=26" target="_blank">
                                <i class="fab fa-youtube" style=" font-size: 1.4rem;"> <i style="color: #202225">  </i></i> 
                            </a>             
                        </div>
                    
                        <div class="feedback-slider-item">
                        <img  alt="dana syariah indonesia"  src="/img/setyo.png" class=" mx-auto rounded-circle" alt="Customer Feedback">
                            <h3 class="customer-name">Setyo Winarno</h3> 
                            <p>@lang('welcome.testimoni_2')</p>
                            <a rel="noreferrer" href="https://www.youtube.com/watch?v=82Rwca37lIM&list=UULPxmUGo-cK2ai9LLJeO--A&index=20" target="_blank">
                                <i class="fab fa-youtube" style=" font-size: 1.4rem;"> <i style="color: #202225">  </i></i> 
                            </a>
                        </div>

                        <div class="feedback-slider-item">
                            <img  alt="dana syariah indonesia" src="/img/sunarto.png" class=" mx-auto rounded-circle" alt="Customer Feedback">
                            <h3 class="customer-name">Sunarto</h3>
                            <p>@lang('welcome.testimoni_3')</p>
                            <a rel="noreferrer" href="https://www.youtube.com/watch?v=smIBDdDk6lY&list=UULPxmUGo-cK2ai9LLJeO--A&index=22" target="_blank">
                                <i class="fab fa-youtube" style=" font-size: 1.4rem;"> <i style="color: #202225">  </i></i> 
                            </a>
                        </div>
                        End Source Code Old -->
                        
                        @foreach ($testimoni as $testimoni)
                        <div class="feedback-slider-item">
                            <img  alt="dana syariah indonesia" src="{{asset('/storage')}}/{{$testimoni->gambar}}" class=" mx-auto rounded-circle" alt="Customer Feedback">
                            <h3 class="customer-name">{{$testimoni->nama}}</h3>
                            <p>{!!$testimoni->content!!}</p>
                            <!--a rel="noreferrer" href="https://www.youtube.com/watch?v=uJFNbkpoZY0&list=UULPxmUGo-cK2ai9LLJeO--A&index=26" target="_blank">
                                <i class="fab fa-youtube" style=" font-size: 1.4rem;"> <i style="color: #202225">  </i></i> 
                            </a-->             
                        </div>
                        @endforeach   
                    </div><!-- /End feedback-slider -->         
                </div><!-- /End col -->
            </div><!-- /End row -->
        </div><!-- /End container -->
    </div><!-- /End customer-feedback -->
</div>
<!-- end testimonial -->


<!-- Blog start -->
<div class="blog content-area-2 pb-5 pt-5 mb-5">
    <div class="container pb-5 pt-5">
        <div class="main-title pb-5">
            <h1>@lang('welcome.news')</h1>
            <p>@lang('welcome.news_desc')</p>
        </div>
        <div class="row">
          @foreach($news as $dataNews)
                        @php
                          $data_url = str_slug($dataNews->title,'-');
                        @endphp
            <div class="col-lg-4 col-md-6">
                <div class="blog-1">
                    <a href="/news_detil/{{ $dataNews->id }}/{{ $data_url }}">
                        <img  alt="dana syariah indonesia {{$dataNews->title}}" data-src="{{asset('/storage')}}/{{$dataNews->image}}" alt="blog" class="img-fluid lozad">
                    </a>
                    <div class="detail mb-5" style="overflow-wrap: break-word;">
                        <div class="date-box">
                            <h5>{{ Carbon\Carbon::parse($dataNews->created_at)->format('d') }}</h5>
                            <h5>{{ Carbon\Carbon::parse($dataNews->created_at)->format('M') }}</h5>
                        </div>
                        <h3 class="pt-3">
                            <a href="/news_detil/{{ $dataNews->id }}/{{ $data_url }}" class="text-dark">{{$dataNews->title}}</a>
                        </h3>
                        <div class="post-meta">
                            <h6 style="font-size: .8rem"><i class="fa fa-user"></i> <span class="pl-2"> {{$dataNews->writer}} </span> </h6>
                        </div>
                        <p>{!! substr(strip_tags($dataNews->deskripsi),0,250) !!}..</p>
                        <a href="/news_detil/{{ $dataNews->id }}/{{ $data_url }}" class="text-success ">@lang('language.selengkapnya') →</a>
                    </div>
                </div>
            </div>
          @endforeach
        </div>
        <!-- end for -->
        <div class="container">
            <div class="row">
                <div class="col text-center pt-5">
                    <div class="main-title pb-2 pt-0 mr-4">
                        <a  href="news" class="btn btn-md banner-btn-right-ico ">@lang('language.selengkapnya') →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog end -->

<!-- partner end

@endsection
