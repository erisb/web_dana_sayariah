@extends('layouts.borrower.master')

@section('title', 'Selamat Datang Penerima Dana')
<style>
  .dataTables_paginate { 
     float: right; 
     text-align: right; 
  }
  #allDetilImbal:hover{
    background-color: forestgreen !important;
  }
  #overlay{   
      position: fixed;
      top: 0;
      left: 0;
      z-index: 900;
      width: 100%;
      height:100%;
      display: none;
      background: rgba(0,0,0,0.6);
  }
  .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;  
  }
  .spinner {
      width: 40px;
      height: 40px;
      border: 4px #ddd solid;
      border-top: 4px #2e93e6 solid;
      border-radius: 50%;
      animation: sp-anime 0.8s infinite linear;
  }
  @keyframes sp-anime {
      100% { 
          transform: rotate(360deg); 
      }
  }
  .is-hide{
      display:none;
  }
</style>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@section('content')
    <div id="overlay">
    <div class="cv-spinner">
          <span class="spinner"></span>
    </div>
    </div>
    <!-- Main Container -->
    <main id="main-container">        
        <!-- Page Content -->
        <div id="detect-screen" class="content-full-right">
            <div class="container">
                <div class="row">
                    <div id="col" class="col-12 col-md-12 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: 0em;" >{{$namaproyek}}</h1> 
                            <p class="pull-right mt-20 pt-5 text-dark"> 
                            <!-- <i class="fa fa-circle text-primary"></i> Aktif -->
                            <?php 
                                                if($status == 0){ //pengajuan
                                                    echo "<i class='fa fa-circle text-pengajuan pull-right ml-4 mt-0 pt-0 mr-10'></i> Pengajuan"; 
                                                }elseif($status == 1){ //approved / aktif
                                                    echo "<i class='fa fa-circle text-success pull-right ml-4 mt-0 pt-0 mr-10'></i> Aktif"; 
                                                }elseif($status == 2 || $status == 3){ //peggalangan dana
                                                    echo "<i class='fa fa-circle text-penggalangandana pull-right ml-4 mt-0 pt-0 mr-10'></i> Penggalangan Dana";
                                                }elseif($status == 6){ //proses tanda tangan
                                                    echo "<i class='fa fa-circle text-ttd pull-right ml-4 mt-0 pt-0 mr-10'></i> Proses TTD";
                                                }elseif($status == 4){ //selesai
                                                    echo "<i class='fa fa-circle text-selesai pull-right ml-4 mt-0 pt-0 mr-10'></i> Selesai";
                                                }elseif($status == 7){
                                                    echo "<i class='fa fa-circle text-proyekberjalan pull-right ml-4 mt-0 pt-0 mr-10'></i> Proyek Berjalan";
                                                }?>
                            </p>   
                            </p>                   
                        </span>
                    </div>
                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-md-12 mt-5 pt-5">
                        <div class="row">
                            <div class="col-12 col-md-12">
                            <div class="col-md-12">
                                <h3 class="block-title text-muted mb-10 font-w600">Pendanaan Gallery</h3>                                
                                <!-- Slider with multiple images and center mode -->
                                <div class="block">
                                    <div class="js-slider slick-nav-black slick-nav-hover p-20" data-dots="true" data-arrows="true" data-slides-to-show="4" data-center-mode="false" data-autoplay="true" data-autoplay-speed="3000">
                                        @foreach ($gambarProyek as $row)
                                        <div>
                                            <img class="img-fluid" src='{{url("storage/$row->gambar")}}' alt="">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- END Slider with multiple images and center mode -->
                            </div>
                            <div class="col-12 col-md-12">
                                <!-- DISPLAY PROGRESS UNTUK DESKTOP -->
                                <h3 class="block-title text-muted mb-10 font-w400 d-none d-lg-block">Progress dan Status Pendanaan Proyek</h3>
                                <div class="block d-none d-lg-block">
                                    <div class="row pt-30 mt-10 bs-wizard" style="border-bottom:0;">
                                    <!-- step 1 -->
                                        <div class="bs-wizard-step complete d-none d-lg-block"><!-- complete -->
                                            <div class="progress" style="">
                                                <div class="progress-bar"></div>
                                            </div>
                                        </div>
                                        <div class="col-2 bs-wizard-step {{$pengajuan}} d-none d-lg-block">
                                            <div class="text-center bs-wizard-stepnum">1</div>
                                            <p class="text-center text-dark">Pengajuan Pendanaan</p>
                                                <div class="progress" style="margin-left: 40px; border-radius: 10px 0px 0px 10px;">
                                                    <div class="progress-bar"></div>
                                                </div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            
                                        </div>
                                        <!-- step 2 -->
                                        <div class="col-2 bs-wizard-step {{$verifikasi}} d-none d-lg-block"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">2</div>
                                            <p class="text-center text-dark">Verifikasi Berhasil</p>
                                            <div class="progress">
                                                <div class="progress-bar"></div>
                                            </div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            
                                        </div>
                                        <!-- step 3 -->
                                        <div class="col-2 bs-wizard-step {{$penggalangandana}} d-none d-lg-block"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">3</div>
                                            <p class="text-center text-dark">Penggalangan Dana</p>
                                            <div class="progress">
                                                <div class="progress-bar"></div>
                                            </div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            
                                        </div>
                                        <!-- step 4 -->
                                        <div class="col-2 bs-wizard-step {{$ttd}} d-none d-lg-block"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">4</div>
                                            <p class="text-center text-dark">Daftar dan TTD Pencairan</p>
                                            <div class="progress">
                                                <div class="progress-bar"></div>
                                            </div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                        </div>
                                        <!-- step 5 -->
                                        <div class="col-2 bs-wizard-step {{$proyekberjalan}} d-none d-lg-block"><!-- disable -->
                                            <div class="text-center bs-wizard-stepnum">5</div>
                                            <p class="text-center text-dark">Proyek Berjalan</p>
                                            <div class="progress">
                                                <div class="progress-bar"></div>
                                            </div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            
                                        </div>
                                        <!-- step 6 -->
                                        <div class="col-2 bs-wizard-step {{$proyekselesai}} d-none d-lg-block"><!-- disable -->
                                            <div class="text-center bs-wizard-stepnum">6</div>
                                            <p class="text-center text-dark">Proyek Selesai</p>
                                            <div class="progress" style="margin-right: 40px; border-radius: 0px 10px 10px 0px;">
                                                <div class="progress-bar"></div>
                                            </div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            
                                        </div>
                                        <div class="bs-wizard-step disabled d-none d-lg-block"><!-- complete -->
                                            <div class="progress">
                                                <div class="progress-bar"></div>
                                            </div>
                                        </div>
                                        
                                    </div>  
                                                                      
                                </div>
                                <!-- DISPLAY PROGRESS UNTUK DESKTOP -->
                                <!-- DISPLAY PROGRESS UNTUK MOBILE -->
                                <div class="block hidden-xs-up">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title text-dark">Status Detail</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                                <i class="si si-refresh"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                    <div class="col-xs pl-30 pb-30 pt-30">
                                        <p class="font-w600 {{$tc_pengajuan}} mb-0  ">1. Pengajuan Pendanaan
                                            <i class="fa {{$icon_pengajuan}}"></i>
                                            <p class="pl-20 text-dark">Proses tahap pertama, pengajuan pendanaan dan memberikan dokumen pendukung</p>
                                        </p>
                                        <p class="font-w600 {{$tc_verifikasi}} mb-0 ">2. Verifikasi Berhasil
                                            <i class="fa {{$icon_verifikasi}}"></i>
                                            @if ($statusproyek == 1 && ($statusLogSP3 == 1 || $statusLogSP3 == 0))
                                                <button id="sp3" class="btn btn-success">SP3</button>
                                            @endif
                                            <p class="pl-20 text-dark">Proses tahap dua, proses verifikasi kelayakan oleh pihak Dana Syariah & Persetujuan SP3
                                            </p>
                                        </p>
                                        <p class="font-w600 {{$tc_penggalangandana}} mb-0 ">3. Masa Penggalangan Dana
                                            <i class="fa {{$icon_penggalangandana}}"></i>
                                            <p class="pl-20 text-dark">Proses tahap tiga, proses penggalangan dana oleh pihak Dana Syariah</p>
                                        </p>
                                        @if ($status == 6)
                                            <p class="font-w600 {{$tc_ttd}} mb-0 ">4. Daftar dan TTD Pencairan 
                                                <!-- <button class="btn btn-success btn_small" onclick="fct()">Daftar</button> -->
                                                @if ($showKontrak == 'buka' || $cekRegDigiSign == null)
                                                <button id="kontrak" class="btn btn-success">Daftar Akad Wakalah</button>
                                                @elseif ($showKontrak == 'ttd_akhir')
                                                <button id="kontrak_ttd_akhir" class="btn btn-success">TTD Akad Wakalah</button>
                                                @elseif ($showKontrak == 'ttd_awal')
                                                <button id="kontrak_ttd_awal" class="btn btn-success">TTD Akad Wakalah</button>
                                                @elseif ($showKontrak == 'unduh')
                                                <button id="kontrak_unduh_base64" class="btn btn-success">Unduh Akad Wakalah</button>
                                                @endif
                                                <p class="pl-20 text-dark">Proses tahap empat, proses Pendaftaran Digisign dan Pencairan Dana oleh pihak Pemohon Pembiayaan</p> 
                                            </p>
                                        @else
                                            <p class="font-w600 {{$tc_ttd}} mb-0 ">4. Daftar dan TTD Pencairan 
                                                <i class="fa {{$icon_ttd}}"></i>
                                                <p class="pl-20 text-dark">Proses tahap empat, proses Pendaftaran Digisign dan Pencairan Dana oleh pihak Pemohon Pembiayaan</p> 
                                            </p>
                                        @endif
                                        <p class="font-w600 mb-0 {{$tc_proyekberjalan}}">5. Proyek Berjalan
                                            <i class="fa {{$icon_proyekberjalan}}"></i>
                                            <p class="pl-20 text-dark">Proses tahap lima, proses pembangunan dan cicilan bagi hasil kepada Pendana (*jika jenis cicilan bulanan) oleh pihak (*Nama Perusahaan)</p>
                                        </p>
                                        <p class="font-w600 mb-0 {{$tc_proyekselesai}}">6. Proyek Selesai
                                            <i class="fa {{$icon_proyekselesai}}"></i>
                                            <p class="pl-20 text-dark">Proses tahap enam, proses pembangunan selesai dan pelunasan pembiayaan oleh pihak (*Nama Perusahaan)</p>
                                        </p>
                                    </div>
                                    </div>
                                </div>
                                <!-- DISPLAY PROGRESS UNTUK MOBILE -->
                            </div>
                            
                            <div class="col-12 col-md-12">
                                <h3 class="block-title text-muted mb-10 font-w400">Deskripsi Detail</h3>
                                <!-- Progress Wizard 2 -->
                                <div class="js-wizard-simple block">
                                    <!-- Step Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-progress2-step1" data-toggle="tab">Detail Pendanaan</a>
                                        </li>
                                        <li class="nav-item hide">
                                            <a class="nav-link"  href="#wizard-progress2-step2" data-toggle="tab">Unggah Progress</a>
                                        </li>
                                        <li class="nav-item">
                                            <!-- <a class="nav-link" href="#wizard-progress2-step3" data-toggle="tab">Pembayaran</a> -->
                                            <a class="nav-link" href="#testpembayaran" data-toggle="tab">Pembayaran</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-progress2-step4" data-toggle="tab">Riwayat Mutasi</a>
                                        </li>
                                    </ul>
                                    <!-- END Step Tabs -->
                                    <!-- Form -->
                                    <div>
                                        <!-- Steps Content -->
                                        <div class="block-content block-content-full tab-content pl-30 pr-30" style="min-height: 274px;">
                                            <!-- Step 1 -->
                                            <div class="tab-pane active pb-30" id="wizard-progress2-step1" role="tabpanel">
                                                <!-- Pribadi -->
                                                <!-- satuBaris -->
                                                <div class="row justify-content-between">
                                                    <div class="col-6">
                                                         <h3 class="block-title text-dark mb-10 font-w600">Dana Terkumpul
                                                            
                                                        </h3>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <p class="text-dark font-w600 ">{{$persendana}}</p>
                                                    </div>
                                                </div>
                                                <div class="row mt-5 mb-5">
                                                    <div class="col-12 col-md-12 ml-5 ">
                                                        <div class="progress" style="border-radius: 10px; height: 10px">
                                                            <div class="progress-bar" role="progressbar" style="width: {{$persendana}};" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="pb-5">
                                                <div class="layout">
                                                    <h3 class="block-title text-muted mb-10 font-w600">Detail Pendanaan</h3>
                                                    <div class="row ml-30 mt-30">
                                                        <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Dana Dibutuhkan</h6>
                                                            <p class="font-w600 text-dark">{{$danadibutuhkan}}</p>
                                                        </div>
                                                        <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Durasi Proyek</h6>
                                                            <p class="font-w600 text-dark">{{$durasiproyek}}</p>
                                                        </div>
                                                        <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Imbal Hasil</h6>
                                                            <p class="font-w600 text-dark">{{$imbalhasil}}</p>
                                                        </div>
                                                        <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Minimal Pendanaan</h6>
                                                            <p class="font-w600 text-dark">{{$hargapaket}}</p>
                                                        </div>
                                                        <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Jenis Akad</h6>
                                                            <p class="font-w600 text-dark">{{$pendanaanakad}}</p>
                                                        </div>
                                                        <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Terima Hasil</h6>
                                                            <p class="font-w600 text-dark">{{$modepembayaran}}</p>
                                                        </div>
                                                        <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Metode Pembayaran</h6>
                                                            <p class="font-w600 text-dark">{{$metodepembayaran}}</p>
                                                        </div>
                                                        <!-- <div class="col-12 col-md-3 pl-10">
                                                            <h6 class="mb-0 text-muted font-w300">Grade Pendanaan</h6>
                                                            <p class="font-size-sm font-w600 text-muted mb-0">
                                                                <i class="fa fa-star mt-5 text-primary" style="font-size: 1.5em;"></i>
                                                                <i class="fa fa-star mt-5 text-primary" style="font-size: 1.5em;"></i>
                                                                <i class="fa fa-star mt-5 text-primary" style="font-size: 1.5em;"></i>
                                                                <i class="fa fa-star-half-full mt-5 text-primary" style="font-size: 1.5em;"></i>
                                                                <i class="fa fa-star-o mt-5 text-primary" style="font-size: 1.5em;"></i>
                                                            </p>
                                                        </div> -->
                                                    </div>
                                                </div>
                                                <div class="layout mt-30">
                                                    <h3 class="block-title text-muted mb-10 font-w600">Detail Deskripsi</h3>
                                                    <div class="row ml-30 mt-30">
                                                        <div class="col-12 col-md-12 pl-10">
                                                            <p class="font-size-md font-w300 text-muted mb-0">
                                                            {{$deskripsi}}
                                                            </p>
                                                            <p class="font-size-sm mt-30 font-w600 text-dark">
                                                               Powered by : Dana Syariah Indonesia | #HijrahFinansial
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Step 1 -->
                                            <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
                                                <h4 class="pl-10 text-dark">Unggah Progress</h4>
                                                <!-- satuBaris -->
                                                <div class="form-group row">
                                                    <div class="p-10 pl-30">
                                                        <image class="img-side" src="{{url('')}}/assetsBorrower/media/photos/photo10.jpg">
                                                    </div>
                                                    <label class="col-12">Pilih Gambar Utama</label>
                                                    <div class="col-8">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input js-custom-file-input-enabled" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input">
                                                            <label class="custom-file-label" for="example-file-input-custom">Pilih Gambar</label>
                                                        </div>
                                                    </div>
                                                </div> 

                                                <!-- Image Default -->
                                                <h6 class="content-heading text-muted font-w600 mt-0 pt-0" style="font-size: 1em;">Media Gallery</h6>
                                                <div class="row items-push">
                                                    <div class="col-md-3 animated fadeIn">
                                                        <div class="options-container">
                                                            <img class="img-fluid options-item" src="{{url('')}}/assetsBorrower/media/photos/photo1.jpg" alt="">
                                                            <div class="options-overlay bg-primary-dark-op">
                                                                <div class="options-overlay-content">
                                                                    <a class="btn btn-sm btn-rounded btn-alt-danger min-width-75" href="javascript:void(0)">
                                                                        <i class="fa fa-times"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 animated fadeIn">
                                                        <div class="options-container">
                                                            <img class="img-fluid options-item" src="{{url('')}}/assetsBorrower/media/photos/photo1.jpg" alt="">
                                                            <div class="options-overlay bg-primary-dark-op">
                                                                <div class="options-overlay-content">
                                                                    <a class="btn btn-sm btn-rounded btn-alt-danger min-width-75" href="javascript:void(0)">
                                                                        <i class="fa fa-times"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 animated fadeIn">
                                                        <div class="options-container">
                                                            <img class="img-fluid options-item" src="{{url('')}}/assetsBorrower/media/photos/photo1.jpg" alt="">
                                                            <div class="options-overlay bg-primary-dark-op">
                                                                <div class="options-overlay-content">
                                                                    <a class="btn btn-sm btn-rounded btn-alt-danger min-width-75" href="javascript:void(0)">
                                                                        <i class="fa fa-times"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 animated fadeIn">
                                                        <div class="options-container">
                                                            <img class="img-fluid options-item" src="{{url('')}}/assetsBorrower/media/photos/photo1.jpg" alt="">
                                                            <div class="options-overlay bg-primary-dark-op">
                                                                <div class="options-overlay-content">
                                                                    <a class="btn btn-sm btn-rounded btn-alt-danger min-width-75" href="javascript:void(0)">
                                                                        <i class="fa fa-times"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END Image Default -->
                                                
                                                <div class="form-group row mt-20 mb-10">
                                                
                                                    <div class="col-12">
                                                        <h6 class="content-heading text-muted font-w600 mt-0 pt-0" style="font-size: 1em;">Tambah Gallery</h6>
                                                        <!-- Dropzone.js -->
                                                        <form ></form> 
                                                        <form action="/upload-target" class="dropzone" id="drop" >
                                                            <div class="dz-message needsclick">
                                                                <i class="fa fa-picture-o fa-5x text-primary" aria-hidden="true"></i>
                                                                <p class="text-dark">
                                                                    Tarik Gambar ke sini! <br>
                                                                    <small>file type : .jpeg, .jpg, .png</small>
                                                                </p>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="tab-pane" id="wizard-progress2-step3" role="tabpanel">
                                                <h4 class="pl-20 text-dark">Pembayaran</h4>
                                                <!-- Table Sections (.js-table-sections class is initialized in Helpers.tableToolsSections()) -->                                                
                                                <div class="block">
                                                    <div class="block-content">                                                        
                                                        <table class="table table-hover" id="list_tbl_invoice">
                                                            <thead>
                                                                <tr>
                                                                    <th>brw_id</th>
                                                                    <th>proyek_id</th>
                                                                    <th>STATUS</th>
                                                                    <th>JATUH TEMPO</th>
                                                                    <th>DANA POKOK</th>
                                                                    <th>IMBAL HASIL</th>
                                                                    <th>BAYAR</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                <!-- END Table Sections -->
                                            </div>

                                            <div class="tab-pane" id="testpembayaran" role="tabpanel">
                                            @php 
                                                if($status == 7){
                                                    echo "<p align='center'><button class='btn btn-lg btn-primary' id='btnpembayaran' type='button'>Pembayaran</button>";
                                                }else{
                                                    echo "<p align='center'><button class='btn btn-lg btn-primary' type='button' disabled>Pembayaran</button>";
                                                }  
                                            @endphp
                                                
                                            </div>

                                            <div class="tab-pane" id="wizard-progress2-step4" role="tabpanel">
                                                <h4 class="pl-20 text-dark">Riwayat Mutasi</h4>
                                                <!-- Table Sections (.js-table-sections class is initialized in Helpers.tableToolsSections()) -->                                                
                                                <div class="block">
                                                    <div class="block-content">                                                        
                                                        <table class="js-table-sections table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>NO</th>
                                                                    <th>KETERANGAN</th>
                                                                    <th style="width: 15%;">TANGGAL</th>
                                                                    <th class="d-none d-sm-table-cell" style="width: 20%;">DEBIT</th>
                                                                    <th class="d-none d-sm-table-cell" style="width: 20%;">KREDIT</th>
                                                                    <th class="d-none d-sm-table-cell" style="width: 20%;">SALDO</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="js-table-sections-header">
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>
                                                                        Keterangan ini adalah keterangan untuk riwayat mutasi
                                                                    </td>
                                                                    <td class="font-w600">
                                                                        <em class="text-muted">October 28, 2017</em>
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">
                                                                        Rp. 52.000.000
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">
                                                                        Rp. -
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">
                                                                        Rp. 52.000.000
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>
                                                                        Keterangan ini adalah keterangan untuk riwayat mutasi
                                                                    </td>
                                                                    <td class="font-w600">
                                                                        <em class="text-muted">October 28, 2017</em>
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">
                                                                        Rp. -
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">
                                                                        Rp. 2.000.000
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">
                                                                        Rp. 50.000.000
                                                                    </td>
                                                                </tr>
                                                            </tbody>                                                            
                                                            
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- END Table Sections -->
                                            </div>
                                        </div>   
                                        
                                    </div>
                                    <!-- END Form -->
                                </div>
                                <!-- END Progress Wizard 2 -->                                

                            </div>
                            <div class="col-12 col-md-12">
                                <h3 class="block-title text-muted mb-10 font-w400">Detail Pendana</h3>
                                <!-- Progress Wizard 2 -->
                                <div class="js-wizard-simple block">
                                    <!-- Step Tabs -->
                                                <!-- Table Sections (.js-table-sections class is initialized in Helpers.tableToolsSections()) -->                       
                                                <div class="block">
                                                    <div class="block-content">
                                                        <table class="js-table-sections table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 30px;"></th>
                                                                    <th hidden="hidden">ID Proyek</th>
                                                                    <th hidden="hidden">ID Borrower</th>
                                                                    <th hidden="hidden">ID Investor</th>
                                                                    <th>NAMA</th>
                                                                    <th style="width: 15%;">JENIS PENDANA</th>
                                                                    <th class="d-none d-sm-table-cell" style="width: 20%;">DANA POKOK</th>
                                                                    <th class="d-none d-sm-table-cell" style="width: 20%;">TANDA TANGAN</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="js-table-sections-header show table-success">
                                                            @foreach ($dataPendana as $row)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <i class="fa fa-angle-right"></i>
                                                                    </td>
                                                                    <td class="text-center" hidden="hidden">
                                                                        {{ $row->proyek_id }}
                                                                    </td>
                                                                    <td class="text-center" hidden="hidden">
                                                                        {{ $row->investor_id }}
                                                                    </td>
                                                                    <td class="text-center" hidden="hidden">
                                                                        {{ $row->brw_id }}
                                                                    </td>
                                                                    <td>
                                                                        <span class="font-w700 text-primary">{{$row->nama_investor}} </span>
                                                                    </td>
                                                                    <td class="font-w600">
                                                                        <em class="text-muted">
                                                                        @php
                                                                            if(($row->tipe_pengguna ==1) || ($row->tipe_pengguna==0)){
                                                                                        echo "Individu";
                                                                                }else {
                                                                                        echo "Badan Hukum / PT";
                                                                                }
                                                                        @endphp
                                                                        </em>
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">{{number_format($row->total_dana,0,'','.')}}
                                                                    </td>
                                                                    <td class="d-none d-sm-table-cell">
                                                                        @php 
                                                                        if($cekRegDigiSign == null)
                                                                        {
                                                                            echo '<button class="btn sm btn-primary akad-murobahah" id="akad_murobahah">Daftar Akad Murobahah</button>';
                                                                        }
                                                                        else
                                                                        {
                                                                            if($row->status_log != '')
                                                                            {
                                                                                if($row->status_log == 'kirim' || $row->status_log == 'waiting')
                                                                                {
                                                                                    echo '<button class="btn sm btn-primary ttd-akad-murobahah" id="ttd_akad_murobahah" onclick="btn_sign_digital_sign('.Auth::guard('borrower')->user()->brw_id.', '.$row->investor_id.','.$row->proyek_id.')">TTD Akad Murobahah</button>';
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo '<button class="btn sm btn-primary unduh-akad-murobahah" id="unduh_akad_murobahah" onclick="btn_download_digital_sign('.$row->proyek_id.','.$row->investor_id.')">Unduh Akad Murobahah</button>';
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                echo '<button class="btn sm btn-primary ttd-akad-murobahah" id="send_ttd_akad_murobahah" onclick="btn_download_digital_sign('.$row->proyek_id.','.$row->investor_id.','.Auth::guard('borrower')->user()->brw_id.')">TTD Akad Murobahah</button>';
                                                                            }
                                                                        }
                                                                        @endphp
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody> 

                                                        </table>
                                                    </div>
                                                </div>

                                </div>
                           </div> 
                        </div>
                    </div>                           
                </div>
            </div>
        </div>
        <!-- END Page Content -->
        @include('includes.borrower.modal_invoice')
        {{-- Modal Aktivasi --}}
        <div class="modal fade" id="modalAktivasi" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Aktivasi DigiSign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyAktivasi">
                    
                </div>
                {{-- <div class="modal-footer">
                
                </div> --}}
            </div>
            </div>
        </div>
        {{-- Modal Aktivasi End --}}

        {{-- Modal TTD --}}
        <div class="modal fade" id="modalTTD" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>TTD DigiSign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBodyTTD">
                    
                </div>
                {{-- <div class="modal-footer">
                
                </div> --}}
            </div>
            </div>
        </div>
        {{-- Modal TTD End --}}

        {{-- Modal SP3 --}}
        <div id="modalSP3"  class="modal fade in" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scrollmodalLabel">SP3</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="agree">
                    @csrf
                        <div class="modal-body" id="modalBodySP3">
                            {{-- <iframe src="{{ url('perjanjian') }}" scrolling="yes" width="100%" height="500" id="iprem"></iframe> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="setujuSP3">Saya Setuju</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Modal SP3 End --}}
    </main>
   
    <!-- END Main Container -->
    <!--script>
    function fct() {
        var brw_id = "{{Auth::guard('borrower')->user()->brw_id}}";
        $.ajax({
            url : "/admin/borrower/regDigiSignborrower/"+brw_id,
            method : "get",
            success:function(data)
            {
                var dataJSON = JSON.parse(data.status_all);
                console.log(dataJSON);
                swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                .then((result) => {
                        if (dataJSON.JSONFile.result == '00')
                        {
                            if (dataJSON.JSONFile.info)
                            {
                                var url_notif = dataJSON.JSONFile.info.split('https://')[1];
                                console.log(url_notif);
                                $.ajax({
                                    url : "/admin/borrower/callbackDigiSignBorrower/",
                                    method : "post",
                                    data : {brw_id:brw_id,provider_id:1,status:dataJSON.JSONFile.notif,step:'register',url:url_notif},
                                    success:function(data)
                                    {
                                        console.log(data.status)
                                    },
                                    error: function(xhr, status, error){
                                        var errorMessage = xhr.status + ': ' + xhr.statusText
                                        console.log('Error - ' + errorMessage);
                                    }
                                });
                                window.open(dataJSON.JSONFile.info,'_blank');
                            }
                        }
                });
                
            },
            error: function(xhr, status, error){
                var errorMessage = xhr.status + ': ' + xhr.statusText
                alert('Error - ' + errorMessage);
            }
        });
    }
    </script-->
    <link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="{{asset('js/sweetalert.js')}}"></script>
    <script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
    <script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="/admin/assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <style>
        .modal-dialog{
        min-width: 80%;
        }

        .btn-cancel {
            background-color: #C0392B;
            color: #FFFF;
        }
    </style>
    <script>
    
    
        $('#kontrak').on('click',function(){
        var brw_id = {{  Auth::guard('borrower')->user()->brw_id }};
        var text = "{{ $teks }}";
        console.log(brw_id)
        Swal.fire({
                title: "Informasi",   
                text: text,   
                type: "info",   
                showCancelButton: true,
                cancelButtonClass: 'btn-cancel',
                confirmButtonText: "Setuju",   
                cancelButtonText: "Batal",   
                closeOnConfirm: false,   
                closeOnCancel: true
                }).then((result) => {
                // function(isConfirm){ 
                    if (result.value) 
                    {
                        $.ajax({
                            url:"/borrower/regDigiSignBorrower/"+brw_id,
                            method:'get',
                            dataType:'json',
                            beforeSend: function() {
                                $("#overlay").css('display','block');
                                //swal.fire.close()
                            },
                            success:function(data)
                            {
                                
                                $("#overlay").css('display','none');
                                var dataJSON = JSON.parse(data.status_all);
                                console.log(dataJSON);
                                if (dataJSON.JSONFile.result == '00')
                                {
                                    if (dataJSON.JSONFile.info)
                                    {
                                        var url_notif = dataJSON.JSONFile.info.split('https://')[1];
                                        $.ajax({
                                            url : "/borrower/callbackDigiSignBorrower/",
                                            method : "post",
                                            data : {brw_id:brw_id,provider_id:1,status:dataJSON.JSONFile.notif,step:'register',url:url_notif},
                                            success:function(data)
                                            {
                                                console.log(data.status)
                                                var email = "{{ Auth::guard('borrower')->user()->email }}"
                                                $.ajax({
                                                    url : "/borrower/actDigiSignBorrower/"+email,
                                                    method : "get",
                                                    success:function(data)
                                                    {
                                                        var dataJSON2 = JSON.parse(data.status_all);
                                                        console.log(dataJSON2)
                                                        if (dataJSON2.hasOwnProperty('JSONFile'))
                                                        {
                                                            if (dataJSON2.JSONFile.result == '00')
                                                            {
                                                                $('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                                $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                                $('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="100%" height="750"></iframe>');
                                                                $('#linkAktivasi').attr('src',dataJSON2.JSONFile.link)
                                                                $("#modalAktivasi").appendTo('body');
                                                                $('#linkAktivasi').load(function(){
                                                                    var myFrame = $("#linkAktivasi").contents().find('body').text();
                                                                    console.log(myFrame)
                                                                    if (myFrame !== '')
                                                                    {
                                                                        $('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
                                                                        $('.modal-backdrop').remove()
                                                                        location.reload(true);
                                                                    }
                                                                })
                                                                
                                                            }
                                                            else
                                                            {
                                                                
                                                                Swal.fire({title:"Notifikasi",text:dataJSON2.JSONFile.notif,type:"info"})
                                                                        .then(function(){
                                                                             swal.close()
                                                                        })
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if (dataJSON2.result == '14')
                                                            {
                                var id_proyek = {{ $id }};
                                                                $.ajax({
                                                                    url : "/borrower/sendDigiSignWakalahBorrower/"+brw_id+"/"+id_proyek,
                                                                    method : "get",
                                                                    beforeSend: function() {
                                                                        $("#overlay").css('display','block');
                                                                    },
                                                                    success:function(data)
                                                                    {
                                                                        $("#overlay").css('display','none');
                                                                        var dataJSON = JSON.parse(data.status_all);
                                                                        if (dataJSON.JSONFile.result == '00')
                                                                        {
                                                                            $.ajax({
                                                                                url:'/borrower/signDigiSignWakalahBorrower/'+brw_id+"/"+id_proyek,
                                                                                method:'get',
                                                                                dataType:'json',
                                                                                beforeSend: function() {
                                                                                    $("#overlay").css('display','block');
                                                                                    swal.close()
                                                                                },
                                                                                success:function(data)
                                                                                {
                                                                                    $("#overlay").css('display','none');
                                                                                    var dataJSON = JSON.parse(data.status_all);
                                                                                    console.log(dataJSON);
                                                                                    if (dataJSON.JSONFile.result == '00')
                                                                                    {
                                                                                        $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                                                        $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                                                        $('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
                                                                                        $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                                                                                        $("#modalTTD").appendTo('body');
                                                                                        $('#linkTTD').load(function(){
                                                                                            var myFrame = $("#linkTTD").contents().find('body').text();
                                                                                            console.log(myFrame)
                                                                                            if (myFrame !== '')
                                                                                            {
                                                                                                $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                                                                                                $('.modal-backdrop').remove()
                                                                                                location.reload(true);
                                                                                            }
                                                                                        })
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                                                                .then(function(){
                                                                                                     swal.close()
                                                                                                })
                                                                                    }
                                                                                },
                                                                                error: function(request, status, error)
                                                                                {
                                                                                    $("#overlay").css('display','none');
                                                                                    alert(status)
                                                                                }
                                                                            })
                                                                        }
                                                                        else
                                                                        {
                                                                            Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                                                    .then(function(){
                                                                                         swal.close()
                                                                                })
                                                                        }
                                                                        
                                                                    },
                                                                    error: function(request, status, error)
                                                                    {
                                                                        $("#overlay").css('display','none');
                                                                        alert(status)
                                                                    } 
                                                                });
                                                            }
                                                            else
                                                            {
                                                                Swal.fire({title:"Notifikasi",text:dataJSON2.notif,type:"info"})
                                                                            .then(function(){
                                                                                 swal.close()
                                                                        })
                                                                // swal({title:"Notifikasi",text:dataJSON2.notif,type:"info"},
                                                                //   function(){
                                                                //         swal.close()
                                                                //    }
                                                                // );
                                                            }
                                                        }
                                                    },
                                                    error: function(request, status, error)
                                                    {
                                                        // $("#overlay").css('display','none');
                                                        alert(status)
                                                    }
                                                });
                                            },
                                            error: function(request, status, error)
                                            {
                                                // $("#overlay").css('display','none');
                                                alert(status)
                                            }
                                        });
                                    }
                                    else
                                    {
                                        var regDigiSign = '{{ $cekRegDigiSign}}';
                                        if(regDigiSign == '')
                                        {
                                            Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                .then(function(){
                                                    //swal.close()
                                                    var email = "{{ Auth::guard('borrower')->user()->email }}"
                                                    $.ajax({
                                                        url : "/borrower/actDigiSignBorrower/"+email,
                                                        method : "get",
                                                        success:function(data)
                                                        {
                                                            var dataJSON2 = JSON.parse(data.status_all);
                                                            console.log(dataJSON2)
                                                            if (dataJSON2.hasOwnProperty('JSONFile'))
                                                            {
                                                                if (dataJSON2.JSONFile.result == '00')
                                                                {
                                                                    $('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                                    $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                                    $('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="100%" height="750"></iframe>');
                                                                    $('#linkAktivasi').attr('src',dataJSON2.JSONFile.link)
                                                                    $("#modalAktivasi").appendTo('body');
                                                                    $('#linkAktivasi').load(function(){
                                                                        var myFrame = $("#linkAktivasi").contents().find('body').text();
                                                                        console.log(myFrame)
                                                                        if (myFrame !== '')
                                                                        {
                                                                            $('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
                                                                            $('.modal-backdrop').remove()
                                                                            location.reload(true);
                                                                        }
                                                                    })
                                                                    
                                                                }
                                                                else
                                                                {
                                                                    Swal.fire({title:"Notifikasi",text:dataJSON2.JSONFile.notif,type:"info"})
                                                                                .then(function(){
                                                                                     swal.close()
                                                                            })
                                                                }
                                                            }
                                                            else
                                                            {
                                                                  if (dataJSON2.result == '14')
                                                                  {
                                                                      var id_proyek = {{ $id }};
                                      $.ajax({
                                                                          url : "/borrower/sendDigiSignWakalahBorrower/"+brw_id+"/"+id_proyek,
                                                                          method : "get",
                                                                          beforeSend: function() {
                                                                              $("#overlay").css('display','block');
                                                                          },
                                                                          success:function(data)
                                                                          {
                                                                              $("#overlay").css('display','none');
                                                                              var dataJSON = JSON.parse(data.status_all);
                                                                              if (dataJSON.JSONFile.result == '00')
                                                                              {
                                                                                  $.ajax({
                                                                                      url:'/borrower/signDigiSignWakalahBorrower/'+brw_id+"/"+id_proyek,
                                                                                      method:'get',
                                                                                      dataType:'json',
                                                                                      beforeSend: function() {
                                                                                          $("#overlay").css('display','block');
                                                                                          swal.close()
                                                                                      },
                                                                                      success:function(data)
                                                                                      {
                                                                                          $("#overlay").css('display','none');
                                                                                          var dataJSON = JSON.parse(data.status_all);
                                                                                          console.log(dataJSON);
                                                                                          if (dataJSON.JSONFile.result == '00')
                                                                                          {
                                                                                              $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                                                              $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                                                              $('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
                                                                                              $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                                                                                              $("#modalTTD").appendTo('body');
                                                                                              $('#linkTTD').load(function(){
                                                                                                  var myFrame = $("#linkTTD").contents().find('body').text();
                                                                                                  console.log(myFrame)
                                                                                                  if (myFrame !== '')
                                                                                                  {
                                                                                                      $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                                                                                                      $('.modal-backdrop').remove()
                                                                                                      location.reload(true);
                                                                                                  }
                                                                                              })
                                                                                          }
                                                                                          else
                                                                                          {
                                                                                              Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                                                                    .then(function(){
                                                                                                         swal.close()
                                                                                                })
                                                                                          }
                                                                                      },
                                                                                      error: function(request, status, error)
                                                                                      {
                                                                                          $("#overlay").css('display','none');
                                                                                          alert(status)
                                                                                      }
                                                                                  })
                                                                              }
                                                                              else
                                                                              {
                                                                                  Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                                                                .then(function(){
                                                                                                     swal.close()
                                                                                            })
                                                                              }
                                                                              
                                                                          },
                                                                          error: function(request, status, error)
                                                                          {
                                                                              $("#overlay").css('display','none');
                                                                              alert(status)
                                                                          } 
                                                                      });
                                                                  }
                                                                  else
                                                                  {
                                                                      Swal.fire({title:"Notifikasi",text:dataJSON2.notif,type:"info"})
                                                                                    .then(function(){
                                                                                         swal.close()
                                                                                })
                                                                  }
                                                            }
                                                        },
                                                        error: function(request, status, error)
                                                        {
                                                            // $("#overlay").css('display','none');
                                                            alert(status)
                                                        }
                                                    });
                                                });
                                        }
                                        else
                                        {
                                            Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                .then(function(){
                                                  swal.close()
                                                  {{--var id_user = {{ Auth::user()->id }} --}}
                                                  var id_proyek = {{ $id }};
                                                  $.ajax({
                                                      url : "/borrower/sendDigiSignWakalahBorrower/"+brw_id+"/"+id_proyek,
                                                      method : "get",
                                                      beforeSend: function() {
                                                          $("#overlay").css('display','block');
                                                      },
                                                      success:function(data)
                                                      {
                                                          $("#overlay").css('display','none');
                                                          var dataJSON = JSON.parse(data.status_all);
                                                          if (dataJSON.JSONFile.result == '00')
                                                          {
                                                              $.ajax({
                                                                  url:'/borrower/signDigiSignWakalahBorrower/'+brw_id+"/"+id_proyek,
                                                                  method:'get',
                                                                  dataType:'json',
                                                                  beforeSend: function() {
                                                                      $("#overlay").css('display','block');
                                                                      swal.close()
                                                                  },
                                                                  success:function(data)
                                                                  {
                                                                      $("#overlay").css('display','none');
                                                                      var dataJSON = JSON.parse(data.status_all);
                                                                      console.log(dataJSON);
                                                                      if (dataJSON.JSONFile.result == '00')
                                                                      {
                                                                          $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                                          $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                                          $('#modalBodyTTD').append('<iframe id="linkTTD" width="100%" height="750"></iframe>');
                                                                          $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                                                                          $("#modalTTD").appendTo('body');
                                                                          $('#linkTTD').load(function(){
                                                                              var myFrame = $("#linkTTD").contents().find('body').text();
                                                                              console.log(myFrame)
                                                                              if (myFrame !== '')
                                                                              {
                                                                                  $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                                                                                  $('.modal-backdrop').remove()
                                                                                  location.reload(true);
                                                                              }
                                                                          })
                                                                      }
                                                                      else
                                                                      {
                                                                          Swal.fire({title:"Notifikasi",text:'TTD Gagal',type:"info"})
                                                                            .then(function(){
                                                                                  swal.close()
                                                                             });
                                                                      }
                                                                  },
                                                                  error: function(request, status, error)
                                                                  {
                                                                      $("#overlay").css('display','none');
                                                                      alert(status)
                                                                  }
                                                              })
                                                          }
                                                          else
                                                          {
                                                              Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                                .then(function(){
                                                                     location.reload(true)
                                                                 });
                                                          }
                                                          
                                                      },
                                                      error: function(request, status, error)
                                                      {
                                                          $("#overlay").css('display','none');
                                                          alert(status)
                                                      } 
                                                  });
                                              });
                                        }
                                    }
                                }
                                else if(dataJSON.JSONFile.result == '12')
                                {
                                      Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                    .then(function(){
                                                        
                                                    });
                                }
                                else
                                {
                                      Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                                                    .then(function(){
                                                        
                                                    });
                                }
                            },
                            error: function(request, status, error)
                            {
                                $("#overlay").css('display','none');
                                alert(status)
                            }
                        })  
                    }
        });
    });

    $('#kontrak_ttd_awal').on('click',function(){
        var brw_id = {{  Auth::guard('borrower')->user()->brw_id }}
        id_proyek = {{ $id }}
        $.ajax({
          url : "/borrower/sendDigiSignWakalahBorrower/"+brw_id+"/"+id_proyek,
          method : "get",
          beforeSend: function() {
              $("#overlay").css('display','block');
          },
          success:function(data)
          {
              $("#overlay").css('display','none');
              var dataJSON = JSON.parse(data.status_all);
              if (dataJSON.JSONFile.result == '00')
              {
                  $.ajax({
                      url:'/borrower/signDigiSignWakalahBorrower/'+brw_id+"/"+id_proyek,
                      method:'get',
                      dataType:'json',
                      beforeSend: function() {
                          $("#overlay").css('display','block');
                          swal.close()
                      },
                      success:function(data)
                      {
                          $("#overlay").css('display','none');
                          var dataJSON = JSON.parse(data.status_all);
                          console.log(dataJSON);
                          if (dataJSON.JSONFile.result == '00')
                          {
                              $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                              $('.modal-backdrop').addClass('modal-backdrop fade show in')
                              $('#modalBodyTTD').append('<iframe id="linkTTD" width="100%" height="750"></iframe>');
                              $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                              $("#modalTTD").appendTo('body');
                              $('#linkTTD').load(function(){
                                  var myFrame = $("#linkTTD").contents().find('body').text();
                                  console.log(myFrame)
                                  if (myFrame !== '')
                                  {
                                      $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                                      $('.modal-backdrop').remove()
                                      location.reload(true);
                                  }
                              })
                          }
                          else
                          {
                              Swal.fire({title:"Notifikasi",text:'TTD Gagal',type:"info"})
                                .then(function(){
                                            
                                });
                          }
                      },
                      error: function(request, status, error)
                      {
                          $("#overlay").css('display','none');
                          alert(status)
                      }
                  })
              }
              else
              {
                  Swal.fire({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"})
                    .then(function(){
                         location.reload(true)
                     });
              }
              
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          } 
      });  
              
    });

    $('#kontrak_ttd_akhir').on('click',function(){
        var brw_id = {{  Auth::guard('borrower')->user()->brw_id }}
        id_proyek = {{ $id }}
        $.ajax({
          url:'/borrower/signDigiSignWakalahBorrower/'+brw_id+"/"+id_proyek,
          method:'get',
          dataType:'json',
          beforeSend: function() {
              $("#overlay").css('display','block');
              //swal.close()
          },
          success:function(data)
          {
              $("#overlay").css('display','none');
              var dataJSON = JSON.parse(data.status_all);
              console.log(dataJSON);
              if (dataJSON.JSONFile.result == '00')
              {
                  $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                  $('.modal-backdrop').addClass('modal-backdrop fade show in')
                  $('#modalBodyTTD').append('<iframe id="linkTTD" width="100%" height="750"></iframe>');
                  $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                  $("#modalTTD").appendTo('body');
                  $('#linkTTD').load(function(){
                      var myFrame = $("#linkTTD").contents().find('body').text();
                      console.log(myFrame)
                      if (myFrame !== '')
                      {
                          $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                          $('.modal-backdrop').remove()
                          location.reload(true);
                      }
                  })
              }
              else
              {
                  Swal.fire({title:"Notifikasi",text:'TTD Gagal',type:"info"})
                    .then(function(){
                                            
                    });
              }
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          }
      })        
    });

    $('#kontrak_unduh').on('click',function(){
        var brw_id = {{  Auth::guard('borrower')->user()->brw_id }}
        id_proyek = {{ $id }}
        console.log(brw_id)
        $.ajax({
          url:'/borrower/downloadDigiSignBorrower/',
          method:'post',
          //responseType: "blob",
          data:{id:brw_id,proyek_id:id_proyek},
          beforeSend: function(jqXHR,settings) {
              $("#overlay").css('display','block');
          },
          success: function (response) {
              $('#overlay').css('display','none')
              var dataBersih = response.FileContent
              console.log(response)
              var newData = b64toBlob(dataBersih,'',512)
              var blob = new Blob([newData], {type: "application/pdf"});
              var link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Akad Wakalah Bil Ujroh.pdf";
              link.click();
              //console.log(response)
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          }
      })  
              
    });

    $('#kontrak_unduh_base64').on('click',function(){
        $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
    var brw_id = {{  Auth::guard('borrower')->user()->brw_id }}
        id_proyek = {{ $id }}
        console.log(brw_id)
        $.ajax({
          url:'/borrower/downloadBase64DigiSignBorrower/',
          method:'post',
          //responseType: "blob",
          data:{id:brw_id,proyek_id:id_proyek},
          beforeSend: function(jqXHR,settings) {
              $("#overlay").css('display','block');
          },
          success: function (response) {
              $('#overlay').css('display','none')
              var dataBersih = JSON.parse(response.status_all)
              console.log(dataBersih.JSONFile)
              var newData = b64toBlob(dataBersih.JSONFile.file,'',512)
              var blob = new Blob([newData], {type: "application/pdf"});
              var link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Akad Wakalah Bil Ujroh.pdf";
              link.click();
              //console.log(response)
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          }
      })             
    });

    $('#sp3').on('click',function(){
        var id_proyek = {{ $id }};
        var brw_id = {{ $brwId }};
        $.ajax({
          url:'/borrower/generateSP3/'+brw_id+'/'+id_proyek,
          method:'get',
          success: function (response) {
                if (response.status == 'Berhasil')
                {
                    
                    $('#modalSP3').modal('show');
                    $('#modalBodySP3').append('<iframe id="linkSP3" scrolling="yes" width="100%" height="500" id="iprem"></iframe>');
                    $('#linkSP3').attr('src',"{{ url('viewSP3') }}/"+brw_id)
                }
                else
                {
                    alert(response.status)
                }

          },
          error: function(request, status, error)
          {
              alert(status)
          }
        });
    })

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }

    $('#setujuSP3').on('click',function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var id_proyek = {{ $id }};
        $.ajax({
              url:'/borrower/updateSP3/',
              method:'post',
              data: {'proyek_id': id_proyek},
              success: function (response) {
                    // console.log(response.jsonFile.message)
                    if (response.jsonFile.status == '00')
                    {
                        Swal.fire({title:"Notifikasi",text:response.jsonFile.message,type:"info"})
                            .then(function(){
                                 location.reload(true)
                            })
                    }
                    else
                    {
                        Swal.fire({title:"Notifikasi",text:response.jsonFile.message,type:"info"})
                            .then(function(){
                                 location.reload(true)
                            })
                    }

              },
              error: function(request, status, error)
              {
                  alert(status)
              }
        });
    })

    $('#modalAktivasi .close,#modalTTD .close,#modalSP3 .close').on('click',function(){
          location.reload(true);
          console.log('test')
    })

    $('.akad-murobahah').on('click',function(){
          $('#kontrak').trigger('click');
    });

    function btn_send_digital_sign(proyek_id,investor_id,user_id){
      $.ajax({
          url:'/borrower/sendDigiSignMurobahahBorrower/'+proyek_id+'/'+investor_id,
          method:'get',
          dataType:'json',
          beforeSend: function() {
              $("#overlay").css('display','block');
              swal.close()
          },
          success:function(data)
          {
              $("#overlay").css('display','none');
              var dataJSON = JSON.parse(data.status_all);
              console.log(dataJSON);
              if (dataJSON.JSONFile.result == '00')
              {
                  $.ajax({
                      url:'/borrower/signDigiSignMurobahahBorrower/'+user_id+'/'+investor_id+'/'+proyek_id,
                      method:'get',
                      dataType:'json',
                      beforeSend: function() {
                          $("#overlay").css('display','block');
                          swal.close()
                      },
                      success:function(data)
                      {
                          $("#overlay").css('display','none');
                          var dataJSON = JSON.parse(data.status_all);
                          console.log(dataJSON);
                          if (dataJSON.JSONFile.result == '00')
                          {
                              $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                              $('.modal-backdrop').addClass('modal-backdrop fade show in')
                              $('#modalBodyTTD').append('<iframe id="linkTTD" width="100%" height="750"></iframe>');
                              $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                              $("#modalTTD").appendTo('body');
                              $('#linkTTD').load(function(){
                                  var myFrame = $("#linkTTD").contents().find('body').text();
                                  console.log(myFrame)
                                  if (myFrame !== '')
                                  {
                                      $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                                      $('.modal-backdrop').remove()
                                      location.reload(true);
                                  }
                              })
                          }
                          else
                          {
                              Swal.fire({title:"Notifikasi",text:'TTD Gagal',type:"info"})
                                .then(function(){
                                     swal.close()
                                })
                          }
                      },
                      error: function(request, status, error)
                      {
                          $("#overlay").css('display','none');
                          alert(status)
                      }
                  })
              }
              else
              {
                  Swal.fire({title:"Notifikasi",text:'TTD Gagal',type:"info"})
                    .then(function(){
                         swal.close()
                    })
              }
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          }
      })
    }

    function btn_sign_digital_sign(user_id, investor_id, proyek_id){
        
      $.ajax({
          url:'/borrower/signDigiSignMurobahahBorrower/'+user_id+'/'+investor_id+'/'+proyek_id,
          method:'get',
          dataType:'json',
          beforeSend: function() {
              $("#overlay").css('display','block');
              swal.close()
          },
          success:function(data)
          {
              $("#overlay").css('display','none');
              var dataJSON = JSON.parse(data.status_all);
              console.log(dataJSON);
              if (dataJSON.JSONFile.result == '00')
              {
                  $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                  $('.modal-backdrop').addClass('modal-backdrop fade show in')
                  $('#modalBodyTTD').append('<iframe id="linkTTD" width="100%" height="750"></iframe>');
                  $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                  $("#modalTTD").appendTo('body');
                  $('#linkTTD').load(function(){
                      var myFrame = $("#linkTTD").contents().find('body').text();
                      console.log(myFrame)
                      if (myFrame !== '')
                      {
                          $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                          $('.modal-backdrop').remove()
                          location.reload(true);
                      }
                  })
              }
              else
              {
                  Swal.fire({title:"Notifikasi",text:'TTD Gagal',type:"info"})
                    .then(function(){
                         swal.close()
                    })
              }
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          }
      })
    }

    function btn_download_digital_sign(proyek_id,investor_id){
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });      

    $.ajax({
          url:'/borrower/downloadBase64DigiSignMurobahahBorrower/',
          method:'post',
          //responseType: "blob",
          data:{proyek_id:proyek_id,investor_id:investor_id},
          beforeSend: function(jqXHR,settings) {
              $("#overlay").css('display','block');
          },
          success: function (response) {
              $('#overlay').css('display','none')
              var dataBersih = JSON.parse(response.status_all)
              console.log(dataBersih.JSONFile)
              var newData = b64toBlob(dataBersih.JSONFile.file,'',512)
              var blob = new Blob([newData], {type: "application/pdf"});
              var link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Akad Murobahah.pdf";
              link.click();
              //console.log(response)
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          }
      })
    }

    </script>
    <script>
        $(document).ready(function() {   
            var brw_id      = "{{Auth::guard('borrower')->user()->brw_id}}";
            var proyek_id   = "{{$id}}";
            var list_tbl_invoice = $('#list_tbl_invoice').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                bFilter: false, 
                bInfo: false,
                // ajax : {
                  // url : '/borrower/list_invoice'+brw_id+'/'+proyek_id,
                  // type : 'get',
                // },
                
                "columnDefs" :[
                    {
                        "targets": 0,
                        class : 'text-left',
                        "visible" : false,
                    },
                    {
                        "targets": 1,
                        class : 'text-left',
                        "visible" : false,
                    },
                    {
                        "targets": 2,
                        class : 'text-left',
                        // "visible" : false,
                    },
                    {
                        "targets": 3,
                        class : 'text-left',
                        // "visible" : false,
                    },
                    {
                        "targets": 4,
                        class : 'text-left',
                        // "visible" : false,
                    },
                    {
                        "targets": 5,
                        class : 'text-left',
                        // "visible" : false,
                    },
                    {
                        "targets": 6,
                        class : 'text-left',
                        "visible" : false,
                    },
                    {
                        "targets": 7,
                        class : 'text-left'
                        //"visible" : false
                        
                    }
                ]
             });
            // $("#radio_normal, #radio_percepatan").change(function () {
                // if ($("#radio_normal").is(":checked")) {
                    // $('#tr_percepatan').hide();
                // }
                // else if ($("#radio_percepatan").is(":checked")) {
                    // $('#tr_percepatan').show();
                // }
                // else 
                    // $('#tr_percepatan').hide();
            // }); 
            // $("#radio_lunas, #radio_sebagian").change(function () {
                // if ($("#radio_lunas").is(":checked")) {
                    // $('#input_mode').attr("disabled", "disabled");
                // }
                // else if ($("#radio_sebagian").is(":checked")) {
                    // $('#input_mode').removeAttr("disabled", "disabled");
                    // $('#input_mode').focus();
                // }
                // else 
                // $('#input_mode').attr("disabled", "disabled");
            // });        
        });

        $('#btnpembayaran').on('click',function(){
            Swal.fire({
            title: 'Lunasi Pembayaran Proyek?',
            text: "Rp. "+<?php echo $danadicairkan?>,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batalkan !',
            confirmButtonText: 'Ya, Lunasi !'
            }).then((result) => {
            // if (result.value) {
            //     Swal.fire(
            //     'Deleted!',
            //     'Your file has been deleted.',
            //     'success'
            //     )
            // }
            })
        });
    </script>
@endsection