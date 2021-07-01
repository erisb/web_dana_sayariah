@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar')
@endsection

@section('body')

<!-- hero us start -->
<div class="about-us content-area-2 bg-green-soft banner-style-one parallax" data-speed-x="30" data-speed-y="40">
    <!-- <img src="img/wave-static-02.svg" class="w-100 position-absolute ts-bottom__0"> -->
<div>

    <div id="parallax-container" class="container pt-5 pb-5 banner-style-two" >
        <div class="row parallax" data-speed-x="10" data-speed-y="10">
            <div class="col-lg-7 col-xs-12 align-self-center pt-5 " >
            
                <div class="about-texts" >
                    <h2 class="wow fadeInLeft delay-03s">
                        <p style="font-weight: 500; font-size: .9em; line-height: 1em; display: block;" > @lang('pendana.head_1') </p>                        
                    </h2>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-3 wow fadeInLeft delay-09s pt-3">@lang('pendana.head_2') <br> </p>                                                           
                    
                </div>
                <div class="row">
                    <div class="col-6">
                    <a href="#" id="#register-form-link2" data-toggle="modal" data-target="#registerModal" class="blog-slider__button parallax" data-speed-x="10" data-speed-y="10">@lang('menu.daftar_sekarang') </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 pt-5 ">
            
            <!-- <canvas></canvas> -->
            <div id="parallax-container">
            <!-- <img class="start-png-home parallax" src="/img/search-man.png"  alt="" data-speed-x="60" data-speed-y="44">  -->
            <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/eiubt79exTI?start=9" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                <div class="hero-slide lazy pt-2 wow fadeInRight delay-03s">
                    <div>
                        <div class="image parallax" data-speed-x="20" data-speed-y="28">                                
                            <a id="player" href="//www.youtube.com/watch?v=eiubt79exTI" class="video-popup" >
                                <img src="/img/slideshow_video_1.png" />
                            </a>                      
                        </div>
                    </div>                                     
                </div>
            </div>
            </div>
            
        </div>
    </div>
</div>
<div>
<!-- hero us start -->
<div id="caraMenjadiInvestor"  class="about-us content-area-8">
    <div  class="container pb-4 mt-5 parallax">
        <div class="row">            
            <div class="col-lg-12 align-self-center text-center">
                <div class="about-text wow fadeInUp delay-04s">
                    <h4>@lang('pendana.satu')</h4>
                    <p> @lang('pendana.dua')</p>
                    
                </div>
            </div>            
        </div>
    </div>
</div>
<!-- hero us end -->

<div  class="container">
    <div class="row">
        <div class="col-lg-12 wow fadeInUp delay-06s text-center">
            <img class="col-12 " src="/img/cara-invest-2.png" alt="">           
        </div>        
</div>

<!-- keunggulan start -->
<div class="services content-area-2 pt-5">
    
    <div class="container">        
        <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12  s-brd-2 wow fadeInLeft delay-04s">
                    <div class="services-info-5 text-left">
                        <i style="color: #4FB5B3;" class="fas fa-award pt-2"></i>
                        <h5 class="bold">1. Daftar</h5>
                        <p>@lang('pendana.empat'), verifikasi melalui email serta melengkapi data profile anda terlebih dahulu agar mendapatkan Nomor Virtual Account</p>
                        <hr>
                        <h5 class="bold">Menyetujui Syarat & Ketentuan</h5>
                        <p>@lang('pendana.lima')</p>
                        <br>
                    </div>
                </div> 
                <div class="col-lg-4 col-md-4 col-sm-12  s-brd-3 wow fadeInDown delay-04s">
                    <div class="services-info-5 text-left">
                        <i  class="fas fa-fingerprint fast pt-2"></i>
                        <h5 class="bold">2. Memilih Proyek</h5>
                        <p>Sebelum memilih proyek anda harus melakukan TOPUP dana ke Virtual Account anda terlebih dahulu dan @lang('pendana.enam')</p>
                        <hr>
                        <h5 class="bold">Mengalokasikan Dana</h5>
                        <p>@lang('pendana.tujuh')</p>
                        <br>

<!--<style type="text/css">-->
<!--    .notification-box {-->
<!--        color: #000;-->
<!--    }-->
<!--    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {-->
<!--        color: #000;-->
<!--    }-->
<!--</style>-->
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col-2"></div>-->
<!--        <div class="col-lg-12 wow fadeInUp delay-06s text-center" style="background-color: #0faf3f;border-radius:15px;margin: 1em 1em 1em 1em;">-->
<!--            <img class="col-8 " src="/img/tatacara_pendana.PNG" alt="">-->
<!--        </div>-->
<!--        <div class="col-lg-12"><hr></div>-->
<!--        <div class="sub-banner-2" style="background-color: #0faf3f;border-radius:15px;margin-left: 10px;">-->
<!--                <div class="container">-->
<!--                    <div class="breadcrumb-area  wow fadeInDown delay-06s">-->
<!--                    <h4 class="text-center">@lang('pendana.dua')</h4>-->
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12  s-brd-2 wow fadeInLeft delay-04s">
                <div class="services-info-5 text-left" >
                    <i style="color: #6DB278;" class="fas fa-star-and-crescent pt-2"></i>
                    <h5 class="bold">3. Terima Imbal Hasil</h5>
                    <p>@lang('pendana.delapan')</p>
                    <hr>
                    <h5 class="bold">Pengembalian Dana Pokok</h5>
                    <p>@lang('pendana.sembilan')</p>
                    <br>
                </div>
            </div>
                       
        </div>
    </div>    
</div>
<!-- keunggulan end -->
</div>
</div>
</div>

<!-- hero us start -->
<div  class="about-us content-area-8" style="background-color: #FDFFFC;">
    <div  class="container pb-4 mt-5 parallax">
        <div class="row">            
            <div class="col-lg-12 align-self-center">
                <div class="about-text wow fadeInUp delay-04s">
                    <h1> <span class="headingText"> Mengapa di Dana Syariah ?</span></h1>
                    <p> Manfaatkan 8 keunggulan menjadi Pendana di Dana Syariah</p>
                    
                </div>
            </div>
            <div  class="col-lg-4">
                <div class="properties-service-v wow delay-06s ">
                    <!-- <img src="/img/asset_2.png" alt="admin"  height="40" class="img-fluid pt-2 wow fadeInright delay-04s" > -->
                    <!-- <img class="start-png  wow fadeInUp delay-08s" src="/img/coin.png"  alt="" >   -->
                </div>
            </div>
        <!--<div class="col-lg-12 wow fadeInUp delay-06s">-->
        <!--<hr>-->
        <!--    <div class="notification-box mb-60" style="background-color: #0faf3f;border-radius:15px;">             -->
        <!--        <h3>@lang('pendana.tiga')</h3><hr>-->
        <!--        <ol>-->
        <!--            <li><h6>@lang('pendana.empat')</h6> </li><hr>-->
        <!--            <li><h6>@lang('pendana.lima')</h6> </li><hr>-->
        <!--            <li><h6>@lang('pendana.enam')</h6> </li><hr>-->
        <!--            <li><h6>@lang('pendana.tujuh')</h6> </li><hr>-->
        <!--            <li><h6>@lang('pendana.delapan')</h6> </li><hr>-->
        <!--            <li><h6>@lang('pendana.sembilan')</h6> </li><hr>-->
        <!--            <li><h6>@lang('pendana.sepuluh')</h6> </li><hr>-->
        <!--            <li><h6>@lang('pendana.sebelas')</h6> </li>-->
        <!--        </ol>-->
        <!--        <hr>-->
        <!--   </div>-->
        <!--   <div>-->
               
        <!--   </div>-->
        </div>
    </div>
</div>
<!-- hero us end -->
<!-- hero us end -->
<div class="container pt-5 pb-5">
    <div class="container-slick">
        <div class="row delapan-keu nggulan lazy pt-2 wow fadeInRight delay-03s">
            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                <i class="lni-seo-monitoring size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Imbal Hasil Tinggi</h4>
                    <p class="sub-testi-text">Setara hingga 15 - 20% setara per tahun</p>                
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                <i class="lni-shopping-basket size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Online & Mudah</h4>
                    <p class="sub-testi-text">Semudah <br> belanja Online</p>                
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                <i class="lni-credit-cards size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Tarik Dana</h4>
                    <p class="sub-testi-text">Tanpa denda & penalti.<br>(Kami carikan Pendana pengganti)</p>                
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                <i class="lni-protection size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Legal & <br> Aman</h4>
                    <p class="sub-testi-text">Terdaftar di OJK Agunan Properti</p>                
                </div>
            </div>
            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                <i class="lni-certificate size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Pendanaan Syariah</h4>
                    <p class="sub-testi-text">Sesuai dengan prinsip syariah</p>                
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                <i class="lni-handshake size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Imbal Hasil <br> Pasti & tetap</h4>
                    <p class="sub-testi-text">Imbal Hasil Jual-Beli properti</p>                
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                <i class="lni-grow size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Pendanaan Terjangkau</h4>
                    <p class="sub-testi-text">Mulai Rp 1 Juta dan Kelipatannya</p>                
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                <!-- <div class="team-photo _1"></div> -->
                    <i class="lni-sprout size-lg pt-3 pb-3 text-success"></i>
                    <h4 class="team-title">Terima Hasil Tiap Bulan</h4>
                    <p class="sub-testi-text">Otomatis tiap bulan di transfer ke rekening</p>                
                </div>
            </div>
        </div>                   
        

    </div>
</div>

<!-- end cara invest versi 2 -->
<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
      
        <iframe id="iframeYoutube" width="560" height="315"  src="https://www.youtube.com/embed/eiubt79exTI" frameborder="0" allowfullscreen></iframe> 
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection