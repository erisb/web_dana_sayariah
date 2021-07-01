@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
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
                        <p style="font-weight: 500; font-size: .9em; line-height: 1em; display: block;" >Pembiayaan Bisnis Properti </p>                        
                    </h2>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-3 wow fadeInLeft delay-09s pt-3">Dana Syariah <span style="color: #7F2529; font-weight:600;">Indonesia</span> <br> berfokus pada pembiayaan properti <br> </p>                                                           
                    
                </div>
                <!--
                <div class="row">
                    <div class="col-6">
                    <a href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20ingin%20mengajukan%20Pembiayaan%20di%20Dana%20Syariah,%20Bagaimana%20caranya?."  class="blog-slider__button parallax" data-speed-x="10" data-speed-y="10"><i class="fab fa-whatsapp pt-1 pr-1"></i> Ajukan Pembiayaan</a>
                    </div>
                </div>
                -->
            </div>
            
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 pt-5 ">
            
            <!-- <canvas></canvas> -->
            <div id="parallax-container">
            <!-- <img class="start-png-home parallax" src="/img/search-man.png"  alt="" data-speed-x="60" data-speed-y="44">  -->
            <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/eiubt79exTI?start=9" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                <div class="hero-slide lazy pt-2 wow fadeInRight delay-03s">
                    <div>
                        <div class="image parallax" data-speed-x="20" data-speed-y="28">                            
                                <img src="/img/start.png" />                            
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
                    <h4>@lang('penerima.satu')</h4>
                    <p> @lang('penerima.dua')</p>
                    
                </div>
            </div>            
        </div>
    </div>
</div>
<!-- hero us end -->

<div  class="container">
    <div class="row">
        <div class="col-lg-12 wow fadeInUp delay-06s text-center">
            <img class="col-12 " src="/img/cara-menjadi-borrower.png" alt="">           
        </div>        
</div>

<!-- keunggulan start -->
<div class="services content-area-2 pt-5">
    
    <div class="container">        
        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12  s-brd-2 wow fadeInLeft delay-04s">
                    <div class="services-info-5 text-left">
                        <i style="color: #4FB5B3;" class="fas fa-award pt-2"></i>
                        <h5 class="bold">1. Daftar</h5>
                        <p>@lang('penerima.empat')</p>
                        <hr>
                        <h5 class="bold">Menyetujui Syarat & Ketentuan</h5>
                        <p>@lang('penerima.lima')</p>
                        <br>
                    </div>
                </div> 
                <div class="col-lg-4 col-md-4 col-sm-12  s-brd-3 wow fadeInDown delay-04s">
                    <div class="services-info-5 text-left">
                        <i  class="fas fa-fingerprint fast pt-2"></i>
                        <h5 class="bold">2. Pengajuan Proyek (Verifikasi)</h5>
                        <p>@lang('penerima.enam')</p>
                        <hr>
                        <h5 class="bold">Proposal</h5>
                        <p>@lang('penerima.tujuh')</p>
                        <hr>
                        <h5 class="bold">Verifikasi</h5>
                        <p>@lang('penerima.delapan')</p>
                        <hr>
                        <h5 class="bold">Perjanjian</h5>
                        <p>@lang('penerima.sembilan')</p>
                        <br>
                    </div>
                </div> 
                <div class="col-lg-4 col-md-4 col-sm-12  s-brd-3 wow fadeInDown delay-04s">
                    <div class="services-info-5 text-left">
                        <i style="color: #6DB278;" class="fas fa-star-and-crescent pt-2"></i>
                        <h5 class="bold">3. Penggalangan Dana</h5>
                        <p>@lang('penerima.sepuluh')</p>
                        <hr>
                        <h5 class="bold">Akad (Bagi Hasil)</h5>
                        <p>@lang('penerima.sebelas')</p>
                        <hr>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12  s-brd-2 wow fadeInLeft delay-04s">
                    <div class="services-info-5 text-left" >
                        <i style="color: #6DB278;" class="fas fa-star-and-crescent pt-2"></i>

                        
                        <h5 class="bold">4. Pembayaran Imbal Hasil</h5>
                        <p>@lang('penerima.duabelas')</p>
                        <hr>
                        <h5 class="bold">Pengembalian Pokok</h5>
                        <p>@lang('penerima.tigabelas')</p>
                        <p>@lang('penerima.empatbelas')</p>
                        <br>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12  s-brd-2 wow fadeInLeft delay-04s">
                    <div class="services-info-5 text-left" >
                        <h5 class="bold">@lang('penerima.limabelas')</h5>
                        <p>@lang('penerima.enambelas')</p>
                        <br>
                    </div>
                </div>
<!--<style type="text/css">-->
<!--    .notification-box {-->
<!--        color: #000;-->
<!--    }-->
<!--    b, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {-->
<!--        color: #000;-->
<!--    }-->
<!--</style>-->
<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col-2"></div>-->
<!--        <div class="col-lg-12 wow fadeInUp delay-06s text-center" style="background-image: linear-gradient( #00e044,  #0faf3f);border-radius:15px;margin: 1em 1.5em 1em 1em;">-->
<!--            <img class="col-8 " src="/img/tatacara_penerima.PNG" alt="">-->
<!--        </div>-->
<!--        <div class="col-lg-12"><hr></div>        -->
<!--        <div class="sub-banner-2" style="background-image: linear-gradient( #00e044,  #0faf3f);border-radius:15px;margin-left: 10px;">-->
<!--                <div class="container">-->
<!--                    <div class="breadcrumb-area  wow fadeInDown delay-06s">-->
<!--                    <h4 class="text-center">@lang('penerima.dua')</h4>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        <div class="col-lg-12 wow fadeInUp delay-06s">-->
<!--        <hr>-->
<!--            <div class="notification-box mb-60" style="background-image: linear-gradient( #00e044,  #0faf3f);   border-radius:15px;">             -->
<!--                <h3>@lang('penerima.tiga')</h3><hr>-->
<!--                <ol>-->
<!--                    <li><h6>@lang('penerima.empat')<a href="/#loginModal">(danasyariah.id)</a></h6> </li><hr>-->
<!--                    <li><h6>@lang('penerima.lima')</h6></li><hr>-->
<!--                    <li><h6>@lang('penerima.enam')</h6> </li><br>-->
<!--                    <ol type="a">-->
<!--                        <li><h6>@lang('penerima.tujuh')</h6></li><br>-->
<!--                        <li><h6>@lang('penerima.delapan')</h6></li><br>-->
<!--                        <li><h6>@lang('penerima.sembilan')</h6></li><br>-->
<!--                        <li><h6>@lang('penerima.sepuluh')</h6></li><br>-->
<!--                        <li><h6>@lang('penerima.sebelas')</h6></li><br>-->
<!--                    </ol><hr>-->
<!--                    <li><h6>@lang('penerima.duabelas')</h6> </li><hr>-->
<!--                    <li><h6>@lang('penerima.tigabelas')</h6> </li><hr>-->
<!--                    <li><h6>@lang('penerima.empatbelas')</h6> </li><hr>-->
<!--                </ol>-->
<!--                <h6>@lang('penerima.limabelas')</h6>-->
<!--                <p><b>@lang('penerima.enambelas')</b></p>-->
<!--           </div>-->
<!--           <div>-->
               
<!--           </div>-->
        </div>
       
    </div>    
</div>
<!-- keunggulan end -->
</div>
</div>
</div>


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