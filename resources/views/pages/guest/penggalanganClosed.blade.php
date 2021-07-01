@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar')
@endsection

@section('body')
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
        padding: 0.3em;
        padding-right: .8em;
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
        background: #0e6003;
        color: white;
    }
    .hover-card{
        background-color: white;

    }
    .hover-card:hover{
        box-shadow: 0 0 8px 0 #444;
        transition: 0.5s;
    }
</style>
<!-- Featured properties start -->
<div class="featured-properties content-area-2 bg-dsi-gradient pt-5" >
    <div class="container pt-4"> 
            <div class="col-lg-6 pl-1 pt-5 ">
                <div class="about-text wow fadeInUp delay-04s">
                    <h2><b>@lang('menu.investasi_3')</b></h2>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-3 wow fadeInLeft delay-09s pt-3"> @lang('menu.investasi_3_title')</p>
                    
                </div>
            </div>
        <div class="row">
                @foreach ($proyeks as $proyek)
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 slick-slide-item mt-5 mb-3 wow fadeInUp delay-0{{$proyek->id}}s">
                    
                    <div class="property-box project-card-single pb-4 single-service-one" >
                      
                        <div class="property-thumbnail cover-image" >
                                    
                            <a href="/proyek/{{$proyek->id}}" class="property-img">
                            
                                <div style="font-weight: bold;  margin: 0; float: right;">
                                    @if($proyek->status == 2)
                                    <!-- <div class="tag button alt featured bg-secondary"></div> -->
                                    <div class="ribbon-wrapper-green"><div class="ribbon-green">Closed</div></div>  
                                    @elseif($proyek->status == 3)
                                    <div class="ribbon-wrapper-green"><div class="ribbon-gold">Full</div></div> 
                                    @else
                                    <div class="tag button alt featured" style="font-size: 12px; background-color: #1F5865;"><i class="fas fa-stopwatch"></i> Sisa {{ Carbon\Carbon::now()->parse($proyek->tgl_selesai_penggalangan)->diffInDays()+1}} Hari Lagi</div>
                                    @endif
                                </div>
                            
                                <!-- <div class="tag button alt featured-right two_chars" style="position: absolute; background-color: white; color: ">{{substr($proyek->profit_margin, 0, 2)}}%
                                </div> -->

                                
                                
                                <img src="/storage/{{$proyek->gambar_utama}}" style="max-height:150px; margin-top: 0px; border-radius: 5px 5px 5px 5px; object-fit: cover;" alt="property-1" class="img-fluid">
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
                                    <div class="col-6 text-left pr-2">
                                        <div class="ratings text-secondary">
                                            <span class="p-text-regular">Dana Dibutuhkan</span> <br> 
                                            <span class="p-text-bold" >Rp {{number_format($proyek->total_need,  0, '', '.')}}</span>                               
                                        </div>
                                    </div>
                                    <div class="col-6 text-left">
                                        <div class="ratings text-secondary">
                                            <span class="p-text-regular" >Durasi Proyek</span>  <br>
                                            <span class="p-text-bold">{{$proyek->tenor_waktu}} Bulan</span>                               
                                        </div>
                                    
                                    </div>
                            </div>
                            <div class="location row no-gutters">
                                    <div class="col-lg-6 text-left pr-2">
                                        <div class="ratings text-secondary">
                                            <span class="p-text-regular" >Imbal Hasil/Tahun</span> <br> 
                                            <span class="p-text-bold">{{$proyek->profit_margin}} %</span>                               
                                        </div>
                                    </div>
                                    <div class="col-6 text-left">
                                        <div class="ratings text-secondary">
                                            <span class="p-text-regular" >Minimum Pendanaan</span>  <br>
                                            <span class="p-text-bold">Rp {{number_format($proyek->harga_paket,  0, '', '.')}}</span>                               
                                        </div>
                                    
                                    </div>
                            </div>
                            <div class="location row no-gutters">
                                    <div class="col-6 text-left pr-2">
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
                                    <div class="col-6 text-left">
                                        <div class="ratings text-secondary">
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
                                <a data-animation="animated fadeInUp delay-10s" class="line-button" href="/proyek/{{$proyek->id}}" style="font-size: 0.6em; padding-top: 5em; color: #175D43; text-decoration: underline;"><i> @lang('language.selengkapnya')  </i> <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                        </a>
                    </div>
                    
                </div>   
                @endforeach
                <div class="col-12 pb-5">
                    {{$proyeks->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Featured properties end -->
@endsection