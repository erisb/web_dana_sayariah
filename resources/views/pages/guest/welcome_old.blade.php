@extends('layouts.guest.masterhome')

@section('style')
<style>

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
 }

@media only screen and (device-width: 768px) {
  /* For general iPad layouts */
  .col-md-4{
        max-width: 304px;
    }
}

</style>
@endsection

@section('navbar')
@include('includes.navbar')

@endsection

@section('body')

<div class="banner" id="banner">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{asset('/storage')}}/{{$carousel_pertama}}" alt="banner-1">
                <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                    <div class="carousel-content container">
                        <div class="text-center golden_text">
                            <h1 data-animation="animated fadeInDown delay-05s" <br/>@lang('carosel.slide_1.3')</h1>
                            <p data-animation="animated fadeInUp delay-10s">
                            @lang('carosel.slide_1.1')
                            </p>
                            <a data-animation="animated fadeInUp delay-10s" href="/tata-cara/pendana" class="btn btn-lg btn-round btn-theme">@lang('carosel.slide_1.2')</a>
                            <a data-animation="animated fadeInUp delay-10s" href="/coming_soon" class="btn btn-lg btn-round btn-gold">@lang('carosel.slide_sukuk')</a>
                            <!-- <a data-animation="animated fadeInUp delay-12s" href="#" class="btn btn-lg btn-round btn-white-lg-outline">Ajukan Pinjaman Syariah</a> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('/storage')}}/{{$carousel_kedua}}" alt="banner-2">
                <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                    <div class="carousel-content container">

                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <!-- <img class="col-12" src="img\carousel\diskon.png" alt=""> -->
                                <br><br>
                                <a data-animation="animated fadeInUp delay-10s" href="/tata-cara/pendana" class="btn btn-lg btn-round btn-theme">@lang('carosel.slide_1.2')</a>
                                <a data-animation="animated fadeInUp delay-10s" href="/coming_soon" class="btn btn-lg btn-round btn-gold">@lang('carosel.slide_sukuk')</a>
                            </div>
                            <br><br>
                            <div class="col-lg-6 col-sm-12 golden_text">
                                <h3 data-animation="animated fadeInDown delay-05s">@lang('carosel.slide_2.1') </h3>
                                <hr>
                                <p data-animation="animated fadeInUp delay-10s">
                                @lang('carosel.slide_2.2')
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('/storage')}}/{{$carousel_ketiga}}" alt="banner-3">
                <div class="carousel-caption banner-slider-inner d-flex h-100 text-center">
                    <div class="carousel-content container">
                        <div class="text-right golden_text">
                            <h3 data-animation="animated fadeInUp delay-05s">@lang('carosel.slide_3.1') </h3>
                            <br>
                            <p data-animation="animated fadeInUp delay-10s">
                            @lang('carosel.slide_3.2')
                            </p>
                            <br>
                            <a data-animation="animated fadeInUp delay-10s" href="/tata-cara/pendana" class="btn btn-lg btn-round btn-theme">@lang('carosel.slide_1.2')</a>
                            <a data-animation="animated fadeInUp delay-10s" href="/coming_soon" class="btn btn-lg btn-round btn-gold">@lang('carosel.slide_sukuk')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="slider-mover-left" aria-hidden="true">
                <i class="fa fa-angle-left"></i>
            </span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="slider-mover-right" aria-hidden="true">
                <i class="fa fa-angle-right"></i>
            </span>
        </a>
    </div>
</div>
<!-- banner end -->
<!-- Search area start -->
<div class="search-area pt-5 pb-5" id="search-area-1" >
    <div class="container " >
        <div class="search-area-inner text-center">
            <div class="row" >
                <div class="col-lg-6 col-md-6 col-sm-6 wow fadeInLeft delay-04s" >
                    <iframe src="https://www.youtube.com/embed/pcfNZ6ooMGs?autoplay=0&controls=1&loop=1&playlist=pcfNZ6ooMGs"
                    class="col-12" allowfullscreen frameborder="0" style="height:90%" autoplay="off" loop="1">
                    </iframe>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 wow fadeInRight delay-04s">
                    <h1>@lang('page_video.judul')</h1>
                    <hr>
                    <h6>
                    @lang('page_video.detil')
                  </h6>
                    <hr>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>

{{-- <div class="intro-section">
    <div class="container">
        <div class="row ">
            <div class="col-sm-12 col-lg-5 mb-3 mb-lg-0">
                <img class="col-12" src="/img/logo.png" alt="logo" style="width:auto;">
            </div>
            <br>
            <div class="col-sm-12 col-lg-7 text-center" >
                <h5>Kalkulator</h5>
                <hr>
                    <a class="btn btn-md" href="/kalkulator" >Hitung Imbal Hasil Sekarang</a>
            </div>
        </div>
    </div>
</div> --}}

<!-- Featured properties start -->
<div class="featured-properties content-area-2">
    <div class="container  wow fadeInDown delay-04s">
        <div class="main-title">
            <h1>@lang('proyek.judul')</h1>
            <p>@lang('proyek.subjudul')</p>
            <br><hr>
        </div>

        <div class="row filter-portfolio">
                @foreach ($proyek as $proyek)
            <div class="cars" >

                <div class="col-lg-12 col-md-4 col-sm-12 filtr-item m-2" data-category="3" >
                    <div class="Properti-box hover-card" >
                       <div class="property-thumbnail">
                            <a href="/proyek/{{$proyek->id}}" class="property-img" style="z-index:1">
                                <div class="tag button alt featured" style="position: absolute; max-height:150px;">
                                    
                                    @if($proyek->status == 2) 
                                        <img src="/Badge/Closed1.png" style="width:100%; max-height:auto;" alt="">
                                    @elseif($proyek->status == 3)
                                        <img src="/Badge/Full.png" style="width:100%; max-height:auto;" alt="">
                                    {{-- @elseif($proyek->embed_picture == 1) --}}
                                    @else
                                        <img src="{{$proyek->embed_picture}}" style="width:120px; max-height:150px;" alt="">
                                    @endif
								</div>
							</a>
							<div style="background-image:url('/storage/{{$proyek->gambar_utama}}');background-size:cover;min-height:220px; min-width:100%">
								<a href="/proyek/{{$proyek->id}}" class="property-img" style="height:px;">

									 {{-- <img src="img/popular_project/img_307x232.jpg" background-image:url('/storage/app/public/{{$proyek->gambar_utama}}') alt="popular-places" class="img-fluid" style="min-height: 250px;"> --}}
									 {{-- <img src="/storage/{{$proyek->gambar_utama}}" class="img-fluid" style="min-height: 250px;"> --}}
								</a>
							</div>
                            <div class="property-overlay" onClick="return true">
                                <a href="/proyek/{{$proyek->id}}" onClick="return true" class="overlay-link">
                                    <i onClick="return true" class="fa fa-link"></i>
                                </a>
                            </div>
                            {{-- <div class="text-right align-baseline" style="position: absolute; bottom:2rem; right:0.2rem; padding:2px;">
                                <h5 style="color:white;">{{$proyek->nama}}&nbsp;&nbsp;</h5>
                            </div> --}}
                        </div>
                        <div class="detail">
                            <div style="font-weight: bold;  margin: 0; float: right;">
                                @if($proyek->status == 2)
                                    <span class="badge badge-warning badge-sm">Closed</span>
                                @elseif($proyek->status == 3)
                                    <span class="badge badge-success badge-sm">Full</span>
                                @else
                                Sisa Hari <span class="badge badge-light badge-sm">{{ Carbon\Carbon::now()->parse($proyek->tgl_selesai_penggalangan)->diffInDays()+1}}</span></span>
                                @endif
                            </div>
                            {{-- <button type="button" class="btn btn bg-css"  style="font-weight: bold; padding:2px; margin: 0; float: right;">
                                Sisa Hari <span class="badge badge-primary badge-sm">{{ $proyek->tgl_selesai->diffInDays(Carbon\Carbon::now()->toDateString()) }}</span></span>
                                <span class="sr-only">days left</span>
                            </button> --}}
                            <h5 style=" margin:5px;display: block;width: 200px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; float:left;color:black; !important">{{$proyek->nama}}&nbsp;&nbsp;</h5>
                            <div class="location" style="margin-left:0.5rem !important;">
                                <a href="https://www.google.com/maps/place/{{$proyek->alamat}}" target="_Blank">
                                    <i class="flaticon-facebook-placeholder-for-locate-places-on-maps flaticon" style="  display: block;width: 200px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{$proyek->alamat}}</i>
                                </a>
                            </div>
                            <hr>

                            <table class="table table-borderless table-condensed" onClick="return true"  style="margin-bottom: .6em;">
                                <tbody>
                                <tr>
                                    <td colspan="2">
                                        @if($proyek->status == 2)
                                            <span class="title">{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}  %
                                            </span>
                                            <div class="progress" style="background-color: #aaf442; height: 15px;">
                                                <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}%" aria-valuenow="{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        @elseif($proyek->status == 3)
                                            <span class="title">100%
                                            </span>
                                            <div class="progress" style="background-color: #aaf442; height: 15px;">
                                                <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        @else
                                            @if($proyek->total_need > 0)
                                            <span class="title">{{$proyek->total_need !=0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}  %
                                            </span>
                                            <div class="progress" style="background-color: #aaf442; height: 15px;">
                                                <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}%" aria-valuenow="{{$proyek->total_need != 0 ? number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '') : '0'}}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            @else
                                            <span class="title">0.00%
                                            </span>
                                            <div class="progress" style="background-color: #aaf442; height: 15px;">
                                                <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                        
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                      <div class="agent-details">
                                          <span>Dana Dibutuhkan</span>
                                          <h6>Rp {{number_format($proyek->total_need,  0, '', '.')}}</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="agent-details">
                                          <span>Periode / Tenor</span>
                                          <h6>{{$proyek->tenor_waktu}} Bulan</h6>
                                      </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                      <div class="agent-details">
                                          <span>Imbal Hasil/Tahun</span>
                                          <h6>{{$proyek->profit_margin}} %</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="agent-details">
                                          <span>Minimum investasi</span>
                                          <h6>Rp. {{number_format($proyek->harga_paket,  0, '', '.')}}</h6>
                                      </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                      <div class="agent-details">
                                          <span>Jenis Akad</span>
                                          <h6>@if($proyek->akad == 1)
                                              Murabahah
                                          @else
                                              Mudharabah
                                          @endif</h6>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="agent-details">
                                          <span>Terima Imbal Hasil</span>
                                          <h6>@if($proyek->waktu_bagi == 1)
                                              Tiap Bulan
                                          @else
                                              Akhir Proyek
                                          @endif</h6>
                                      </div>
                                  </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- <!--
                        <div class="footer">
                            <ul>
                                <li><em>Sampai waktu</em></li>
                                <li><b><mark class="text-right text-nowrap">{{$proyek->tgl_mulai->toDateString()}}</mark></b></li>
                            </ul>
                        </div> --> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="main-title pb-2 pt-5">
          <a data-animation="animated fadeInUp delay-10s" href="/penggalangan_berlangsung" class="btn btn-lg btn-round btn-theme">@lang('proyek.lihat')</a>
    </div>
</div>



<!-- services start -->
<div class="services content-area-17 ">
    <div class="container">
        <div class="main-title">
            <hr>
            <h2>@lang('judul.isi')</h2>
            <hr>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 wow fadeInUp delay-04s">
                    <div class="media-body text-center">
                        <img  src="https://www.danasyariah.id/templates/dsi/assets/images/main/icon-1.png" alt="">
                        <br><br>
                        <h4 class="text-success">MAISIR</h4>
                        <p>@lang('info.maisir')</p>
                        <br>
                        <a href="/tentang-kami/khazanah"><p class="text-success">@lang('info.pelajari')</p></a>
                    </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 wow fadeInUp delay-04s">
                    <div class="media-body text-center">
                        <img src="https://www.danasyariah.id/templates/dsi/assets/images/main/icon-2.png" alt="">
                        <br><br>
                        <h4 class="text-success">GHARAR</h4>
                        <p>@lang('info.gharar')</p>
                        <br>
                        <a href="/tentang-kami/khazanah"><p class="text-success">@lang('info.pelajari')</p></a>
                    </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 wow fadeInUp delay-04s">
                    <div class="media-body text-center">
                        <img src="https://www.danasyariah.id/templates/dsi/assets/images/main/icon-3.png" alt="">
                        <br><br>
                        <h4 class="text-success">RIBA</h4>
                        <p>@lang('info.riba')</p>
                        <br>
                        <a href="/tentang-kami/khazanah"><p class="text-success">@lang('info.pelajari')</p></a>
                    </div>
            </div>

        </div>
    </div>
</div>
<!-- services end -->



<!-- Most popular places start -->
{{--
<div class="most-popular-places content-area-3">
    <div class="container">
        <div class="main-title">
            <h1>Beberapara Proyek Ternama</h1>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-md-12">
                    <div class="row">
                        <div class="col-md-12 col-pad wow fadeInLeft delay-04s">
                            <div class="overview overview-box">
                                <img src="img/popular_project/img_632x232.jpg" alt="popular-places">
                                <div class="mask">
                                    <h2>Depoks</h2>
                                    <p>14 Properti</p>
                                    <a href="/penggalangan_berlangsung" class="btn btn-border">Pelajari Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-pad wow fadeInUp delay-04s">
                            <div class="overview overview-box">
                                <img src="img/popular_project/img_307x232.jpg" alt="popular-places-2">
                                <div class="mask">
                                    <h2>Cilandak</h2>
                                    <p>25 Properti</p>
                                    <a href="/penggalangan_berlangsung" class="btn btn-border">Pelajari Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-pad wow fadeInUp delay-04s">
                            <div class="overview overview-box">
                                <img src="img/popular_project/img_307x232_2.jpg" alt="popular-places-4">
                                <div class="mask">
                                    <h2>Kuningan</h2>
                                    <p>12 Properti</p>
                                    <a href="/penggalangan_berlangsung" class="btn btn-border">Pelajari Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-pad wow fadeInRight delay-04s">
                    <div class="overview aa overview-box">
                        <img src="img/popular_project/img_447x480.jpg" alt="popular-places-3" class="big-img">
                        <div class="mask">
                            <h2>Cireunde</h2>
                            <p>45 Properti</p>
                            <a href="/penggalangan_berlangsung" class="btn btn-border">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
