@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar')
@endsection

@section('body')

<style>
  table td p {
    margin: 0;
  }
  .lead
    {
        font-size: 14px;
        font-weight: bold;

    }

  .texth{
    font-size: 13px;

  }
  .ldBar.label-center > .ldBar-label{
      color: black;
      text-shadow: none !important;
  }
  .bg-dsi-gradient{
    background: rgb(231,255,238);
    background: -moz-linear-gradient(176deg, rgba(231, 255, 238, 0.3) 0%, rgba(255,255,255,1) 100%);
    background: -webkit-linear-gradient(176deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
    background: linear-gradient(176deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e7ffee",endColorstr="#ffffff",GradientType=1);
}
.bg-dsi-gradient-flip{
    background: rgb(231,255,238);
background: -moz-linear-gradient(0deg, rgba(231, 255, 238, 0.3) 0%, rgba(255,255,255,1) 100%);
background: -webkit-linear-gradient(0deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
background: linear-gradient(0deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e7ffee",endColorstr="#ffffff",GradientType=1);
}
</style>
<link rel="stylesheet" type="text/css" href="/loader/loading-bar.css">

<!-- Sub banner 2 start -->
  <!-- <div class="sub-banner overview-bgi" style="background: rgba(0, 0, 0, 0.04) url('{{asset('/storage')}}/{{!empty($images[0]->gambar)?$images[0]->gambar:''}}') center center/80% auto no-repeat !important;">
    <div class="container">
        <div class="breadcrumb-area">
          <h1>{{$detil->nama}}</h1>
        </div>
    </div>
  </div> -->
<!-- Sub banner 2 end -->
<div class="bg-dsi-gradient pt-5">
    <div class="properties-details-page" style="padding-top: 50px">
        <div class="container pt-5">
            <div class="row  wow fadeInDown delay-04s " >
                <div class="col-12 slider" style=" padding-bottom: 0;">
                    
                      <div class="col-lg-8 float-left ">
                        <!-- carousel start -->
                        <div id="propertiesDetailsSlider" class="carousel properties-details-sliders slide mb-60">
                            
                            <!-- main slider carousel items -->
                            <div class="carousel-inner">
    
                                {{-- <div class="active item carousel-item" data-slide-number="0">
                                    @if($detil->status == 2 || $detil->status == 4)
                                        <img src="/Badge/Closed1.png" style="width:100%; max-height:auto; position:absolute;" data-toggle="modal" data-target="#activefirst" alt="">
                                    @elseif($detil->status == 3)
                                        <img src="/Badge/Full.png" style="width:100%; max-height:auto;position:absolute;" data-toggle="modal" data-target="#activefirst" alt="">
                                    @else
                                        <img src="{{$detil->embed_picture}}" style="width:120px; max-height:150px; position:absolute;" data-toggle="modal" data-target="#activefirst" alt="">
                                    @endif
                                    <img src="{{asset('/storage')}}/{{!empty($images[0]->gambar)?$images[0]->gambar:''}}" data-toggle="modal" data-target="#activefirst" class="img-fluid" >
                                    
                                </div> --}}
    
                                @foreach($images as $img)
                                <div class="item carousel-item {{ $loop->first ? 'active' : '' }}" data-slide-number="{{$loop->iteration}}">
                                    @if($detil->status == 2 || $detil->status == 4)
                                        <img src="/Badge/Closed1.png" data-toggle="modal" data-target="#activesecond" style="width:100%; max-height:auto; position:absolute;" alt="">
                                    @elseif($detil->status == 3)
                                        <img src="/Badge/Full.png" data-toggle="modal" data-target="#activesecond" style="width:100%; max-height:auto;position:absolute;"  alt="">
                                    @else
                                        <img src="{{$detil->embed_picture}}" data-toggle="modal" data-target="#activesecond" style="width:120px; max-height:150px; position:absolute;" alt="">
                                    @endif
                                    <img src="{{asset('/storage')}}/{{$img->gambar}}" data-toggle="modal" data-target="#activesecond" class="img-fluid" >
                                </div>
                                @endforeach
                                
                                <a class="carousel-control left" href="#propertiesDetailsSlider" data-slide="prev"><i class="fas fa-angle-left"></i></a>
                                <a class="carousel-control right" href="#propertiesDetailsSlider" data-slide="next"><i class="fas fa-angle-right"></i></a>
    
                            </div>
                            <ul class="carousel-indicators smail-properties list-inline nav nav-justified p-1" style="background:whitesmoke;">
                                {{-- <li class="list-inline-item active">
                                    <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#propertiesDetailsSlider">
                                        @if($detil->status == 2 || $detil->status == 4)
                                            <img src="/Badge/Closed1.png" style="width:100%; max-height:auto; position:absolute;" alt="">
                                        @elseif($detil->status == 3)
                                            <img src="/Badge/Full.png" style="width:100%; max-height:auto;position:absolute;"  alt="">
                                        @else
                                            <img src="{{$detil->embed_picture}}" style="width:20px; max-height:20px; position:absolute;" alt="">
                                        @endif
                                            <img src="{{asset('/storage')}}/{{!empty($images[0]->gambar)?$images[0]->gambar:''}}" class="img-fluid" >
                                    </a>
                                </li> --}}
                                @foreach($images as $i)
                                <li class="list-inline-item {{ $loop->first ? 'active' : '' }} " >
                                    <a id="carousel-selector-1"  data-slide-to="{{$loop->iteration}}" data-target="#propertiesDetailsSlider">
                                        @if($detil->status == 2 || $detil->status == 4)
                                            <img src="/Badge/Closed1.png" style="width:100%; max-height:auto; position:absolute;" alt="">
                                        @elseif($detil->status == 3)
                                            <img src="/Badge/Full.png" style="width:100%; max-height:auto;position:absolute;"  alt="">
                                        @else
                                            <img src="{{$detil->embed_picture}}" style="width:20px; max-height:20px; position:absolute;" alt="">
                                        @endif
                                        <img src="/storage/{{$i->gambar}}" class="img-fluid" >
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                            
                        </div>
                    </div>
                    <!-- carousel end -->
                    <!-- PRogres Proyek Start -->
                    
                    <div class="col-lg-4 col-sm-12 float-right card-pro pb-3" >
                        <div class="col-lg-12 col-sm-12 p-1 mt-2  float-left" style="background:transparent;">
                                <div class="heading-properties">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pull-left">
                                                <h3>{{$detil->nama}}</h3>
                                                <p><i style="font-size: 14px" class="fas fa-map-marker-alt"></i> {{$detil->alamat}}</p>
                                            <hr>                                            
                                            </div>
                                            <div class="col-12">
                                            @if($detil->status == 2 || $detil->status == 4)
                                            <h1 class="text-left" style="color: #00775b">100%
                                            </h1>
                                            <div class="progress mb-3" style="background-color: #e2e3e4; height: 10px;">
                                                <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        @elseif($detil->status == 3)
                                            <h1 class="text-left" style="color: #00775b">100%
                                            </h1>
                                            <div class="progress mb-3" style="background-color: #e2e3e4; height: 10px;">
                                                <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        @else
                                        {{-- <span class="title">{{number_format(($detil->terkumpul+$detil->pendanaanAktif->where('proyek_id',$detil->id)->where('status', 1)->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}  % --}}
                                        <span class="" style="color: black; font-weight: 600; font-size: 1.2;" >Dana Terkumpul <h1 class="text-left" style="color: #00775b">{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}  %</h1>
                                            </span>
                                            <div class="progress mb-3" style="background-color: #e2e3e4; height: 10px;">
                                                {{-- <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:{{number_format(($detil->terkumpul+$detil->pendanaanAktif->where('proyek_id',$detil->id)->where('status', 1)->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}%" aria-valuenow="{{number_format(($detil->terkumpul+$detil->pendanaanAktif->where('proyek_id',$detil->id)->where('status', 1)->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100"> --}}
                                                <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}%" aria-valuenow="{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        @endif</div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                          <!-- Start Fill Progres  -->
                        <div class="" >
                            <div class="form-group col-lg-6 col-sm-6  float-left ">
                              <div class="texth">Dana Dibutuhkan</div>
                              <span class="golden_text lead">Rp.{{number_format($detil->total_need, 0, '', '.')}}</span>
                            </div>
                            <div class="form-group col-lg-6 col-sm-6  float-right">
                              <div class="texth">Periode / Tenor</div>
                              <span class="golden_text lead">{{ $detil->tenor_waktu }} Bulan</span>
                            </div>
                            <div class="form-group col-lg-6 col-sm-6  float-left">
                                <div class="texth">Imbal Hasil / Tahun </div>
                                <span class="golden_text lead">{{ $detil->profit_margin }} %</span>
                            </div>
                            <div class="form-group col-lg-6 col-sm-6  float-left ">
                                <div class="texth">Minimum Pendanaan</div>
                                <span class="golden_text lead">Rp.{{number_format($detil->harga_paket,  0, '', '.')}}</span>
                            </div>
                            <div class="form-group col-lg-6 col-sm-6  float-right">
                                <div class="texth">Terima Imbal Hasil</div>
                                <span class="golden_text lead">
                                    @if($detil->waktu_bagi == 1)
                                        Tiap Bulan
                                    @else
                                        Akhir Proyek
                                    @endif</span>
                            </div>
                            <div class="form-group col-lg-6 col-sm-6 float-left ">
                                <div class="texth">Jenis Akad</div>
                                @if($detil->akad == 1)
                                    <span class="golden_text lead">Murabahah</span>
                                @else
                                    <span class="golden_text lead">Mudharabah</span>
                                @endif
                            </div>
                          </div>
                          <div class="col-lg-12 mt-2 p-1">
                                <div class="col-lg-12 col-sm-12 float-left">
                                 <div class="col-lg-12 p-0">
                                        <hr>
                                        <!--@if($detil->status == 2)-->
                                        <!--    <span class="title" style="margin:88%">{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}%-->
                                        <!--    </span>-->
                                        <!--    <div class="progress mb-3" style="background-color: #aaf442; height: 5px;">-->
                                        <!--        <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}%" aria-valuenow="{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100">-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--@elseif($detil->status == 3)-->
                                        <!--    <span class="title">100%-->
                                        <!--    </span>-->
                                        <!--    <div class="progress mb-3" style="background-color: #aaf442; height: 5px;">-->
                                        <!--        <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--@else-->
                                        <!--{{-- <span class="title">{{number_format(($detil->terkumpul+$detil->pendanaanAktif->where('proyek_id',$detil->id)->where('status', 1)->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}  % --}}-->
                                        <!--<span class="title">{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}  %-->
                                        <!--    </span>-->
                                        <!--    <div class="progress mb-3" style="background-color: #aaf442; height: 5px;">-->
                                        <!--        {{-- <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:{{number_format(($detil->terkumpul+$detil->pendanaanAktif->where('proyek_id',$detil->id)->where('status', 1)->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}%" aria-valuenow="{{number_format(($detil->terkumpul+$detil->pendanaanAktif->where('proyek_id',$detil->id)->where('status', 1)->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100"> --}}-->
                                        <!--        <div class="progress-bar progress-bar-animated  bg-success" role="progressbar" style="font-weight: bold; font-size: 15px; width:{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}%" aria-valuenow="{{number_format(($detil->terkumpul+$data_pendana->sum('nominal_awal'))/$detil->total_need*100, 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100">-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--@endif-->
                                    <div class="text-center">
                                        {{-- <button class="btn btn-info btn-sm p-1" data-toggle="modal" data-target=".bd-example-modal-lg">Kalkulator</button> --}}
                                        @if($detil->status == 2 || $detil->status == 4)
                                            <h4 style="color:grey" class=""> <i class="fas fa-lock"></i> Habis waktu</h4>
                                        @else
                                            @if($detil->status == 3)
                                                <h4 style="color:grey" class=""><i class="fas fa-lock"></i> Pendanaan Terpenuhi</h4> 
                                            @else
                                                @if(Auth::Check('user'))
                                                        <a href="/user/investation_feed" class="btn btn-theme-big btn-md pt-2 btn-block">DANAI SEKARANG!</a>
                                                @else
                                                        <button class="btn btn-theme-big btn-md btn-block pt-2" data-toggle="modal" data-target="#registerModal">DANAI SEKARANG!</button>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                  </div>
                                </div>
                              </div>
                        
                    </div>
                </div>
                    
                <div class="col-lg-12 col-sm-12 pb-5">
                    <!-- hero us end -->
                    <div class="container pt-5 pb-0">
                        <div class="container-slick">
                            <div class="row delapan-keu nggulan lazy pt-2 wow fadeIn delay-03s">
                                <div class="col-12 pb-4">
                                    <h4>Informasi Penggalangan <br> <b>{{$detil->nama}}</b></h4>
                                </div>
                                <div class="col-lg-3 pb-2">           
                                    <div class="team-wrapper">
                                    <!-- <div class="team-photo _1"></div> -->
                                    <i class="lni-seo-monitoring size-lg pt-3 pb-3 text-success"></i>
                                        <h4 class="team-title" >{{number_format($detil->profit_margin)}}%</h4>  
                                        <input type="text" class="form-control" id="margin_sim" style="display: none;" value="{{number_format($detil->profit_margin)}}" placeholder="" disabled>
                                        <p class="sub-testi-text">Imbal Hasil<br>Pertahun</p>
                                    </div>
                                </div>

                                <div class="col-lg-3 pb-2">           
                                    <div class="team-wrapper">
                                    <i class="lni-calendar size-lg pt-3 pb-3 text-success"></i>
                                        <h4 class="team-title">{{$detil->tgl_selesai_penggalangan}}</h4>
                                        <input type="date" class="form-control" id="tgl_mulai_proyek" style="display: none;" value="{{$detil->tgl_selesai_penggalangan}}" disabled>                                                                  
                                        <p class="sub-testi-text">Selesai Penggalangan<br>Dana</p>                
                                    </div>
                                </div>

                                <div class="col-lg-3 pb-2">           
                                    <div class="team-wrapper">
                                    <i class="lni-calendar size-lg pt-3 pb-3 text-success"></i>
                                        <h4 class="team-title">{{date("Y-m-d",strtotime($detil->tgl_mulai))}}</h4>
                                        <input type="date" class="form-control" id="tgl_mulai_proyek" style="display: none;" value="{{$detil->tgl_mulai}}" disabled> 

                                        <p class="sub-testi-text">Tanggal Mulai<br>Proyek</p>                
                                    </div>
                                </div>

                                <div class="col-lg-3 pb-5">           
                                    <div class="team-wrapper">
                                    <i class="lni-timer size-lg pt-3 pb-3 text-success"></i>
                                        <h4 class="team-title">{{$detil->tenor_waktu}} Bulan</h4>
                                        <input type="text" class="form-control" id="tenor_sim" style="display: none;" value="{{$detil->tenor_waktu}}" placeholder="" disabled>
                                        <p class="sub-testi-text">Tenor / Durasi<br>Proyek</p>                
                                    </div>
                                </div>
                            </div>                   
                            

                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                                <div class="col-12">
                                    <h3 class="heading">Hitung Imbal Hasil (*Simulasi)</h3>
                                    <hr>
                                </div>
                                <div class="col-lg-4 pb-3">
                                    <div class="form-group">

                                    <label for="dana_sim"><b> Masukkan Jumlah Uang </b></label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control float-left" value="" id="dana_sim" placeholder="" required autofocus>
                                            <div class="input-group-append">
                                                <button class="btn btn-success" data-type="tambah" id="tambah_dana"> <i class="lni-plus text-white"></i> </button>                                               
                                            </div>
                                        </div>
                                    </div>
                                    <small>*Minimum : <b>Rp. 1.000.000</b></small>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="tes_out"><b> Pilih Tanggal Pendanaan</b></label>
                                        <input type="date" class="form-control" id="tgl_invest" min="{{$detil->tgl_mulai_penggalangan}}" max="{{$detil->tgl_selesai_penggalangan}}"required>
                                        
                                    </div>
                                    <small>*Tidak Boleh Melebihi : <b>{{$detil->tgl_selesai_penggalangan}}</b></small>
                                </div>

                                <div class="col-lg-8 ">
                                    <button id="hitung_kal" class="btn btn-success btn-block mt-3 mb-5">Hitung Imbal Hasil</button>
                                </div>
                        </div>
                    
                            
                        <div class="col-lg-12 team-wrapper" >
                        <div class="col-12">
                            <h3  id="judulBelum" > <i class="lni-calculator"></i> Simulasi Proyek Belum di Hitung!</h3>
                            <h3 id="judulSudah" style="display: none;"> <i class="lni-bar-grow"></i> Simulasi Imbal Hasil</h3>
                        </div>
                            <table class="table table-hover mt-2" style="display:none; overflow:auto; width:100%;" id="DataKalSim">

                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal Pendanaan</th>
                                        <th scope="col">Jumlah Dana</th>
                                        <th scope="col">Jumlah Hari</th>
                                        <th scope="col">Penggalangan</th>
                                        <th scope="col">Bulan 1</th>
                                        <th scope="col">Pembayaran Bulan 1</th>
                                        <th scope="col">Bulan 2 - Akhir</th>
                                        <th scope="col">Sisa Imbal Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td id="tgl_invest_out"></td>
                                        <td id="dana_s_out"></td>
                                        <td id="diffDays_out"></td>
                                        <td id="penggalangan_out"></td>
                                        <td id="bulan1_out"></td>
                                        <td id="jumlah_out"></td>
                                        <td id="bulan2_out"></td>
                                        <td id="sisa_imbal_out"></td>
                                    </tr>
                                    <tr>
                                            <td colspan="7"><h5 class="text-right">Total Imbal Hasil dan Dana Pokok : </h5></td>
                                            <td id="total_out"></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h3 >Informasi Detail</h3>
                </div>

                <!-- Start New Deskripsi -->
                <div class="col-12 tabbing tabbing-box mb-60  wow fadeInDown delay-02s mt-2 team-wrapper text-left">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="deskripsi-tab" data-toggle="tab" href="#deskripsi" role="tab" aria-controls="deskripsi" aria-selected="true">Ikhtisar</a>
                      </li>
                      {{-- <li class="nav-item">
                        <a class="nav-link" id="lokasi-tab" data-toggle="tab" href="#lokasi" role="tab" aria-controls="lokasi" aria-selected="false">Lokasi</a>
                      </li> --}}
                      <li class="nav-item">
                        <a class="nav-link" id="legalitas-tab" data-toggle="tab" href="#legalitas" role="tab" aria-controls="legalitas" aria-selected="false">Legalitas</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="pemilik-tab" data-toggle="tab" href="#pemilik" role="tab" aria-controls="pemilik" aria-selected="false">Pemilik Proyek</a>
                      </li>
                      <!--
                      <li class="nav-item">
                        <a class="nav-link" id="simulasi-tab" data-toggle="tab" href="#simulasi" role="tab" aria-controls="simulasi" aria-selected="false">Simulasi</a>
                      </li> -->
                      <!-- <li class="nav-item">
                        <a class="nav-link" id="kalkulator-tab" data-toggle="tab" href="#kalkulator" role="tab" aria-controls="kalkulator" aria-selected="false">Kalkulator</a>
                      </li> -->
                      <li class="nav-item">
                        <a class="nav-link" id="update-tab" data-toggle="tab" href="#update" role="tab" aria-controls="update" aria-selected="false">Perbaharui</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent" >
                      <div class="tab-pane fade show active" id="deskripsi" role="tabpanel" aria-labelledby="deskripsi-tab" style="overflow-x:auto">
                            <div class="col-lg-12 col-sm-12 p-3">
                            <br>
                                <h3 class="heading">Deskripsi Properti</h3>
                                <hr>
                                {!! !empty($detil->deskripsi)?$detil->deskripsi:''!!}
                            </div>
                      </div>

                      <div class="tab-pane fade" id="legalitas" role="tabpanel" aria-labelledby="legalitas-tab">
                        
                                <div class="col-lg-12 col-sm-12 p-3">
                                    <br>
                                        <h3 class="heading">Legalitas</h3>
                                    <hr>
                                    @if(Auth::user())
                                        {!! !empty($detil->deskripsi_legalitas)?$detil->deskripsi_legalitas:'' !!}
                                    @else
                                        <h5>Assalammualaikum</h5>
                                        <p>
                                            Silahkan lakukan pendaftaran dahulu ... <a href=""></a> 
                                        </p>
                                    @endif
                                </div>
                      </div>
                      <div class="tab-pane fade" id="pemilik" role="tabpanel" aria-labelledby="pemilik-tab">
                        
                            <div class="col-lg-12 col-sm-12  p-3">
                                <br>
                                    <h3 class="heading">Pemilik Proyek</h3>
                                <hr>
                                    {!! !empty($detil->deskripsi_pemilik)?$detil->deskripsi_pemilik:'' !!}
                            </div>
                      </div>
                      <div class="tab-pane fade" id="simulasi" role="tabpanel" aria-labelledby="simulasi-tab">
                            <div class="col-lg-12 col-sm-12 p-3">
                                <br>
                                    <h3 class="heading">Simulasi Proyek</h3>
                                <hr>
                                    {!! !empty($detil->deskripsi_simulasi)?$detil->deskripsi_simulasi:'' !!}
                            </div>
                      </div>

                      <div class="tab-pane fade" id="update" role="tabpanel" aria-labelledby="update-tab">
                            <div class="col-lg-12 col-sm-12 p-3" style="overflow-y: scroll; max-height:500px; ">
                            <br>
                                <h3 class="heading">Perkembangan Properti</h3>
                                <hr>
                                      @foreach($data as $d)
                                        <ul class="timeline">
                                              <li>
                                                  <a target="_blank" href="#">Proyek {{!empty($d->proyek_id)?$d->proyek_id:0}} - Tanggal {{!empty($d->created_at)?$d->created_at->format('d/m/Y'):''}}</a>
                                                  <a href="#" class="float-right"><img style="max-height: 150px; max-width: 200px; " src="/storage/{{!empty($d->pic)?$d->pic:''}}" class="rounded float-right img-responsive" alt="..."></a>
                                                  <p>{!!isset($d->deskripsi)?$d->deskripsi:'' !!}</p>
                                              </li>
                                        </ul>
                                      @endforeach
                                        
                                        <style type="text/css">

                                          ul.timeline {
                                              list-style-type: none;
                                              position: relative;
                                              overflow:auto;
                                              line-height: 1.3rem;
                                              margin: 10px
                                          }
                                          ul.timeline:before {
                                              content: ' ';
                                              background: #d4d9df;
                                              display: inline-block;
                                              position: absolute;
                                              left: 20px;
                                              width: 2px;
                                              height: 100%;
                                              z-index: 400;
                                          }
                                          ul.timeline > li {
                                              margin: 5px 0;
                                              padding-left: 35px;
                                          }
                                          ul.timeline > li:before {
                                              content: '';
                                              background: white;
                                              display: inline-block;
                                              position: absolute;
                                              border-radius: 50%;
                                              border: 3px solid #22c0e8;
                                              left: 10px;
                                              width: 20px;
                                              height: 20px;
                                              z-index: 400;
                                          }
                                        </style>
                            </div>
                      </div>
                    </div>
                </div>
                <!-- End New Deskripsi -->


            </div>
        </div>
      </div>
      {{-- <style>
      .respon{
          width: 100%;
      }

      .modal-dialog{
          max-width: 70% !important;
      }
      </style> --}}
      {{-- modal --}}
        <div id="activefirst" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="{{asset('/storage')}}/{{!empty($images[0]->gambar)?$images[0]->gambar:''}}" class="img-responsive respon">
                    </div>
                </div>
            </div>
        </div>

        <div id="activesecond" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="{{asset('/storage')}}/{{!empty($img->gambar)?$img->gambar:''}}" class="img-responsive respon">
                    </div>
                </div>
            </div>
        </div>


</div>
        @endsection

@section('script')
    <script type="text/javascript" src="/loader/loading-bar.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    $(document).ready(function(){

        // $(document).ready(function() {
        //     $('#testtgl').datepicker({
        //         onSelect: function(dateText, inst) {
        //             //Get today's date at midnight
        //             var today = new Date();
        //             today = Date.parse(today.getMonth()+1+'/'+today.getDate()+'/'+today.getFullYear());
        //             //Get the selected date (also at midnight)
        //             var selDate = Date.parse(dateText);

        //             if(selDate < today) {
        //                 //If the selected date was before today, continue to show the datepicker
        //                 $('#Date').val('');
        //                 $(inst).datepicker('show');
        //             }
        //         }
        //     });
        // });
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }
          
        $('#tambah_dana').click(function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            // fieldName = $(this).attr('field');
            // Get its current value
            var currentVal = parseInt($('#dana_sim').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                $('#dana_sim').val(currentVal + 1000000);
            } else {
                // Otherwise put a 0 there
                $('#dana_sim').val(0);
            }
        });
        $('#hitung_kal').on('click', function(){

            // get data frome column simulasi 
            var dana_s = $('#dana_sim').val();
            var tenor_s = $('#tenor_sim').val();
            var margin_s = $('#margin_sim').val();
            
            var mulai_proyek = $('#tgl_mulai_proyek').val();
            var data_tgl = mulai_proyek.split(" ");
            var tgl_invest = $('#tgl_invest').val();
            var data_tgl_invest = tgl_invest.split(" ");
            
            
            if (dana_s == '' && tgl_invest == ''){
                // view to table
                // console.log(tgl_invest)
                $('#DataKalSim').attr('style','display:none');
                $('#judul').attr('style','display:none');
                swal("Data Kosong", "Data Pendanaan dan Tanggal Pendanaan Kosong", "error");
            }
                else if (dana_s == '' && tgl_invest != ''){
                    // view to table
                    $('#DataKalSim').attr('style','display:none');
                    $('#judul').attr('style','display:none');
                    $('#judulBelum').attr('style','display:block');
                    $('#judulSudah').attr('style','display:none');
                    swal("Data Kosong", "Dana Pendanaan Kosong", "error");
                }

                    else if (dana_s != '' && tgl_invest == ''){
                        // view to table
                        $('#DataKalSim').attr('style','display:none');
                        $('#judul').attr('style','display:none');
                        $('#judulBelum').attr('style','display:block');
                        $('#judulSudah').attr('style','display:none');
                        swal("Data Kosong", "Tanggal Pendanaan Kosong", "error");
                    }
                        else if (tgl_invest > mulai_proyek){
                            // view to table
                            $('#DataKalSim').attr('style','display:none');
                            $('#judul').attr('style','display:none');
                            $('#judulBelum').attr('style','display:block');
                            $('#judulSudah').attr('style','display:none');
                            swal("Data Error", "Tanggal Pendanaan tidak boleh melebihi tanggal mulai proyek", "error");
                        }

                            else {
                                // get last and first day of this month
                                if(margin_s <= 12)
                                {
                                    
                                    var date = new Date();
                                    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                                    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                                    var firsttgl = firstDay.getDate(); 
                                    var tanggalterakhir = lastDay.getDate(); 
                                    // diffdate / pengurangan date
                                    var date1 = new Date(data_tgl);
                                    // date1 muncul
                                    var date2 = new Date(data_tgl_invest);
                                    // date2 muncul
                                    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                                    var jumlah_hari = Math.ceil((timeDiff + 1) / (1000 * 3600 * 24));
                                    
                                        // hitung jumlah margin %
                                        var propos = margin_s/12;
                                        var porposdata = parseFloat(propos).toFixed(2)
                                        

                                        // hitungjumlah proposional
                                        var effektifcal = (propos/30)*jumlah_hari;


                                        // hitung jumlah perbuan yg didapat
                                        var imbalcal = (propos*dana_s)/100;
                                        var dataimbal = parseInt(imbalcal/100)*100;

                                        // jumlah proposional yg didapat
                                        var propres = (effektifcal*dana_s)/100;

                                        var propimbal = parseInt(propres + imbalcal)
                                        
                                        var imbal_tenor = parseInt(dataimbal*tenor_s)
                                        var imbal_propes = parseInt(imbal_tenor+propres)
                                        var jumimbal = parseInt(imbal_propes)+parseInt(dana_s)
                                        //console.log(effektifcal)
                                        
    
                                        // view to table formatNumber()
                                        $('#DataKalSim').attr('style','display:inline-block;overflow:auto;');
                                        $('#judul').attr('style','display:inline-block;');
                                        $('#judulBelum').attr('style','display:none;');
                                        $('#judulSudah').attr('style','display:inline-block;');
                                        $('#tgl_invest_out').html(data_tgl_invest);
                                        $('#dana_s_out').html(formatNumber(dana_s));
                                        $('#diffDays_out').html(jumlah_hari);
                                        $('#penggalangan_out').html(formatNumber(parseInt(propres/100)*100));
                                        $('#bulan1_out').html(formatNumber(parseInt(imbalcal/100)*100));
                                        $('#jumlah_out').html(formatNumber(parseInt(propimbal/100)*100));
                                        $('#bulan2_out').html(formatNumber(parseInt(imbalcal/100)*100));
                                        $('#sisa_imbal_out').html(parseInt('0'));
                                        $('#total_out').html(formatNumber(parseInt(jumimbal/100)*100));  

                                }
                                else
                                {
                                    
                                var date = new Date();
                                var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
                                var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                                var firsttgl = firstDay.getDate(); 
                                var tanggalterakhir = lastDay.getDate(); 
                                // diffdate / pengurangan date
                                var date1 = new Date(data_tgl);
                                // console.log(date1)
                                // date1 muncul
                                var date2 = new Date(data_tgl_invest);
                                // console.log(date2)
                                // date2 muncul
                                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                                var jumlah_hari = Math.ceil((timeDiff + 1) / (1000 * 3600 * 24));
                                    
                                //proposional margin 
                                var proposional_margin = (1/30)*jumlah_hari;
                                    console.log(proposional_margin);
                                //persent margin awal
                                var persent_margin_awal = (margin_s/12)*tenor_s;
                                    console.log(persent_margin_awal)
                                //proposional 
                                var proposional = parseInt(proposional_margin*dana_s)/100;
                                    console.log(proposional);
                                //sisa margin
                                var sisa_margin = parseInt((persent_margin_awal-tenor_s)*dana_s)/100;
                                    console.log(sisa_margin)

                                var imbal_bulan = parseInt(dana_s/100);
                                    console.log(imbal_bulan)
                                var total_imbal_dan_proposional = (imbal_bulan*tenor_s)+(proposional+sisa_margin);
                                    console.log(total_imbal_dan_proposional)
                                
                                var jumlah_bulan_awal = parseInt(proposional+imbal_bulan);
                                var total_all = parseInt(total_imbal_dan_proposional)+parseInt(dana_s)
                                    

                                    // view to table
                                    $('#DataKalSim').attr('style','display:inline-block;overflow:auto;');
                                    $('#judul').attr('style','display:inline-block;');
                                    $('#judulBelum').attr('style','display:none;');
                                    $('#judulSudah').attr('style','display:inline-block;');
                                    $('#tgl_invest_out').html(data_tgl_invest);
                                    $('#dana_s_out').html(formatNumber(dana_s));
                                    $('#diffDays_out').html(jumlah_hari);
                                    $('#penggalangan_out').html(formatNumber(parseInt(proposional/100)*100));
                                    $('#bulan1_out').html(formatNumber(parseInt(imbal_bulan/100)*100));
                                    $('#jumlah_out').html(formatNumber(parseInt(jumlah_bulan_awal/100)*100));
                                    $('#bulan2_out').html(formatNumber(parseInt(imbal_bulan/100)*100));
                                    $('#sisa_imbal_out').html(formatNumber(parseInt(sisa_margin/100)*100));
                                    $('#total_out').html(formatNumber(parseInt(total_all/100)*100));
                                }
                                        
                            }
        });        
    });
    
    </script>
    <script>
        AOS.init({
            duration: 1000
        });
    </script>
    
    <script>
        // function centerModal() {
        // $(this).css('display', 'block');
        // var $dialog = $(this).find(".modal-dialog");
        // var offset = ($(window).height() - $dialog.height()) / 2;
        // // Center modal vertically in window
        // $dialog.css("margin-top", offset);
        // }

        // $('.modal').on('show.bs.modal', centerModal);
        // $(window).on("resize", function () {
        //     $('.modal:visible').each(centerModal);
        // });
        //
        // function total_investasi(){
        //     var package = document.getElementById("investpack").value;
        //     var total = package * {{$detil->minimum_payment}};
        //
        //     var  number_string = total.toString(),
        //         sisa   = number_string.length % 3,
        //         rupiah   = number_string.substr(0, sisa),
        //         ribuan   = number_string.substr(sisa).match(/\d{3}/g);
        //
        //     if (ribuan) {
        //         separator = sisa ? '.' : '';
        //         rupiah += separator + ribuan.join('.');
        //     }
        //     document.getElementById("investpack_jumlah").innerHTML = "Total investasi anda: Rp. " + rupiah;
        // }
    </script>


@endsection
