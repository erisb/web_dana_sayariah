@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection

@section('body')

<!-- hero us start -->
<div class="about-us content-area-8 bg-dsi-gradient-flip">
    <div class="container ">
        <div class="row">            
            <div class="col-lg-8 align-self-center mt-5 pt-5">
                <div class="wow fadeInUp delay-04s">
                    <h1><b>@lang('menu.investasi_4')</b></h1>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-3 wow fadeInLeft delay-09s pt-3"> @lang('menu.investasi_4_title')</p>
                     
                </div>
            </div>
            <div class="col-lg-4">
                <div class="properties-service-v wow fadeInRight delay-06s">
                    <!-- <img src="/img/asset_2.png" alt="admin"  height="40" class="img-fluid pt-2"> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="services pt-5 pb-5 bg-dsi-gradient">
    <div class="container">        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12   s-brd-3 wow fadeInDown delay-04s">
                <img class="start-png" src="/img/coin.png"  alt="">  
                <div class="services-info-5 text-left ">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h6><i style="color: #4FB5B3; font-size:1rem;" class="fas fa-store pt-2"> </i> @lang('modal_property.3a')</h6>
                    
                    <h5>@lang('modal_property.3')</h5>
                    <p>@lang('modal_property.9')</p>                   
                    </div>
                </div>
            </div>
            <!--
            <div class="col-lg-6 col-md-6 col-sm-12 s-brd-2 wow fadeInLeft delay-04s">  
                           
                <div class="services-info-5 text-left">
                    <div class="col">
                    <h6><i style="color: #6DB278; font-size:1rem;" class="fas fa-star-and-crescent pt-2"> </i> @lang('modal_property.2a')</h6>
                    <h5>@lang('modal_property.2')</h5>
                    <p>@lang('modal_property.8')</p>
                    <!-- <a href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Modal%20Usaha%20Property%20yang%20Pendanaan%20Pembelian%20Lahan." target="_blank" class="blog-slider__button parallax" data-speed-x="10" data-speed-y="10"><i class="fab fa-whatsapp pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px"></i> WhatshApp</a> -->
                    <!--
                    <br>
                    </div>
                </div>
            </div>     -->
            
            
            <div class="col-lg-6 col-md-6 col-sm-12   s-brd-1 wow fadeInUp delay-04s">
                <div class="services-info-5 text-left">
                    <div class="col">
                    <h6><i style="color: #4e85b2; font-size:1rem;" class="fas fa-hand-holding-heart pt-2"> </i> Unit Terjual</h6>
                    <h5>@lang('modal_property.4')</h5>
                    <p>@lang('modal_property.10')</p>
                    <!-- <a href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Modal%20Usaha%20Property%20yang%20Pembiayaan%20Unit." target="_blank" class="blog-slider__button"><i class="fab fa-whatsapp pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px"></i> WhatshApp</a> -->
                    <br>
                    <br>
                    <br>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 s-brd-1  wow fadeInRight delay-04s">
                <div class="services-info-5 text-left">
                    <div class="col">
                    <h6><i style="color: #4FB5B3; font-size:1rem;" class="fas fa-home pt-2"> </i> Jual Beli Rumah</h6>
                    <h5>@lang('modal_property.5')</h5>
                    <p>@lang('modal_property.11')</p>
                    <!-- <a href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Modal%20Usaha%20Property%20yang%20Pendanaan%20Jual/Beli%20Rumah." target="_blank" class="blog-slider__button"><i class="fab fa-whatsapp pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px"></i> WhatshApp</a> -->
                    </div>
                </div>
            </div>
            <!--
            <div class="col-lg-6 col-md-6 col-sm-12   wow fadeInRight delay-04s">
                <div class="services-info-5 text-left">
                    <div class="col">
                    <h6><i style="color: #AD601B; font-size:1rem;" class="fas fa-lock pt-2"> </i> Sewa & Jual</h6>
                    <h5>@lang('modal_property.6')</h5>
                    <p>@lang('modal_property.12')</p>
                    <br>
                    <!-- <a href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Modal%20Usaha%20Property%20yang%20Sewa%20dan%20Jual." target="_blank" class="blog-slider__button"><i class="fab fa-whatsapp pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px"></i> WhatshApp</a> -->
                    <!--
                    </div>
                </div>
            </div>-->
            <!--
            <div class="col-lg-6 col-md-6 col-sm-12   wow fadeInRight delay-04s">
                <div class="services-info-5 text-left">
                    <div class="col">
                    <h6><i style="color: #6DB278; font-size:1rem;" class="fas fa-star-and-crescent pt-2"> </i> Hijrah ke Syariah</h6>
                    <h5>@lang('modal_property.7')</h5>
                    <p>@lang('modal_property.13')</p> -->
                    <!-- <a href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Modal%20Usaha%20Property%20yang%20Hijrah%20ke%20Syariah." target="_blank" class="blog-slider__button"> <i class="fab fa-whatsapp pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px"></i> WhatshApp</a> -->
                    <!--
                    </div>
                </div>
            </div> -->
<!--
            <div class="col-lg-12 col-md-12 col-sm-12   wow fadeInRight delay-04s">
                <div class="services-info-5 text-left">
                    <div class="row">
                        <div class="col-12 text-center">                            
                            <h4 class="pt-3 pb-3">Dapatkan Modal Usaha Property, Sekarang!</h4>
                            <a rel="noreferrer" href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Modal%20Usaha%20Property ?" target="_blank" class="blog-slider__button"> <i class="fab fa-whatsapp pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px"></i> Konsultasikan Modal Usaha</a>
                            
                        </div>
                    </div>
                </div>
            </div>
-->
        </div>
       
    </div>
</div>

@endsection