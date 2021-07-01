@extends('layouts.borrower.master')

@section('title', 'Dasbor Penerima Dana')

@section('content')
    <!-- Side Overlay-->
    @include('includes.borrower.right_menu_all_pendanaan')
    <!-- END Side Overlay -->
    <style>
    .css-radio .css-control-input~.css-control-indicator {
        width: 15px;
        height: 15px;
        background-color: #ddd;
        border: 0px solid #ddd;
        border-radius: 50%;
    }
    </style>
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div id="detect-screen" class="content-full-right">
            <div class="container">
                <div class="row">
                    <div id="col" class="col-12 col-md-9 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400 text-dark" >Pendanaan Anda</h1>                            
                        </span>
                    </div>
                    <div id="col" class="col-12 col-md-9">
                        <span class="mb-10">
                            <div class="form-material floating">
                                <input type="text" class="form-control col-12 col-md-10" style="height: calc(1.5em + .957143rem + 3px);" id="material-text2" name="material-text2">
                                <label for="material-text2" style="color: #8B8B8B!important;" class="font-w300"> <i class="fa fa-search"></i> Cari Berdasarkan Nama atau Lokasi</label>
                            </div>
                        </span>
                        <div class="col-12 mt-20" style="padding-left: 0px;">
                            <label class="css-control css-control-pengajuan css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Pengajuan
                            </label>
                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Aktif
                            </label>
                            <label class="css-control css-control-penggalangandana css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Penggalangan Dana
                            </label>
                            <label class="css-control css-control-ttd css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Proses TTD
                            </label>
                            <label class="css-control css-control-proyekberjalan css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Proyek Berjalan
                            </label>
                            <label class="css-control css-control-selesai css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Selesai
                            </label>
                        </div>
                    </div>
                    <!-- kanan -->
                    <div id="col" class="col-12 col-md-3 pt-30 d-none d-xl-block">
                        <span class="pt-30 ">
                            <h6 class="text-muted font-w300"></h6>                         
                        </span>
                    </div>
                </div>
                <div class="row mt-10 pt-5">
                    <div id="col" class="col-md-8 mt-5 pt-5">
                        <div class="row">

                            @foreach ($detailKeseluruhan as $row)
                            <div class="col-12 col-md-6">
                                <a href="#" class="{{$row->id}}" id="deitil" data-toggle="layoutS" data-action="side_overlay_toggle">
                                <div>
                                    <div class="block hoverCard block-active" >
                                        <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 5px ">
                                
                                            <div class="p-10">
                                                <image class="img-side" src="{{url("storage/$row->gambar_utama")}}">
                                            </div>
                                            
                                            <div class="ml-2 text-left">   
                                                <p class="font-size-sm font-w600 mb-0 text-dark">
                                                    {{$row->pendanaan_nama}}   
                                                </p> 
                                                                                                    
                                                <p class="font-size-sm font-w600 text-muted mb-0">
                                                @if($row->id_proyek == 0)
                                                    <a href="#" class="{{$row->id}}" id="deitil" data-toggle="layoutS" data-action="side_overlay_toggle">Lihat Detail</a> 
                                                @else
                                                    <a href="/borrower/detilProyek/{{$row->id_proyek}}"  data-toggle="layouts" data-action="side_overlay_toggle">Lihat Detail</a> 
                                                @endif
                                                </p>
                                                
                                            </div>
                                            <small style="font-size: .7rem; margin-top:-45px;">
                                                <?php 
                                                if($row->status == 0){ //pengajuan
                                                    echo "<i class='fa fa-circle text-pengajuan pull-right ml-4 mt-0 pt-0 mr-10'></i>"; 
                                                }elseif($row->status == 1){ //approved / aktif
                                                    echo "<i class='fa fa-circle text-success pull-right ml-4 mt-0 pt-0 mr-10'></i>"; 
                                                }elseif($row->status == 2 || $row->status == 3){ //peggalangan dana
                                                    echo "<i class='fa fa-circle text-penggalangandana pull-right ml-4 mt-0 pt-0 mr-10'></i>";
                                                }elseif($row->status == 6){ //proses tanda tangan
                                                    echo "<i class='fa fa-circle text-ttd pull-right ml-4 mt-0 pt-0 mr-10'></i>";
                                                }elseif($row->status == 4){ //selesai
                                                    echo "<i class='fa fa-circle text-selesai pull-right ml-4 mt-0 pt-0 mr-10'></i>";
                                                }elseif($row->status == 7){
                                                    echo "<i class='fa fa-circle text-proyekberjalan pull-right ml-4 mt-0 pt-0 mr-10'></i>";
                                                }?>
                                            </small>  
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>                           
                </div>

                
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
@endsection
    