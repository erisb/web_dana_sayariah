@extends('layouts.borrower.master')

@section('title', 'Dashboard Borrower')

@section('content')
    <!-- Side Overlay-->
    @include('includes.borrower.right_menu_dashboard')
    <!-- END Side Overlay -->

    <!-- Main Container -->
    @if(Auth::guard('borrower')->user()->status == 'pending')
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
            <div class="row">
                <div id="col" class="col-12 col-md-12 mt-30">
                    <span class="mb-10 pb-10 ">
                        <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: .6em;" >Silahkan Tunggu Verifikasi dari Danasyariah</h1>                    
                    </span>
					
					
                </div>
            </div>
			<div class="row">
                <div id="col" class="col-12 col-md-12 mt-30">
                    <span class="mb-10 pb-10 ">
                        <h4 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: .6em;" >Terimakasih telah bergabung untuk maju bersama kami</h4>                    
                    </span>
					
					
                </div>
            </div>
            
            <!-- END Frequently Asked Questions -->
        </div>
        <!-- END Page Content -->

    </main>
    @elseif(Auth::guard('borrower')->user()->status == 'active') 
    <main id="main-container">
        <!-- Page Content -->
        <div id="detect-screen" class="content-full-right">
            <div class="container">
                <div class="row">
                    <div id="col" class="col-12 col-md-9 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400 judul" style="float: left; margin-block-end: 0em;" >Status Pendanaan</h1>
                            <span id="btn-ajukan-pendanaan" class="pull-right">
                                <a href="/borrower/ajukanPendanaan" class="btn btn-rounded btn-big btn-noborder btn-success min-width-150 text-white"><span class="p-5">Ajukan Pendanaan Baru</span></a>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="row mt-5 pt-5">
                    <div id="col2" class="col-md-9 mt-5 pt-5">
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <a class="block " href="#" id="change_layout_8" data-toggle="layout" data-action="side_overlay_toggle">
                                    <div class="block dsiBgGreen">
                                        <div class="block-content text-white pt-30">
                                                <i class="si si-briefcase"></i>
                                                <h1 class="text-white font-bold-x3  font-w700">{{$totalKeseluruhan}}</h1>
                                            <p>Total</br>Keseluruhan</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="block">
                                    <div class="block-content">
                                        </br>
                                        <h1 class="font-bold-x3 text-primary pt-30 font-w700">{{$totalBerjalan}}</h1>
                                        <p class="text-dark">Berjalan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="block">
                                    <div class="block-content">
                                        </br>
                                        <h1 class="font-bold-x3 text-pengajuan pt-30 font-w700">{{$totalPengajuan}}</h1>
                                        <p class="text-dark font-w500">Pengajuan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="block">
                                    <div class="block-content">
                                        </br>
                                        <h1 class="font-bold-x3 text-selesai pt-30 font-w700">{{$totalselesai}}</h1>
                                        <p class="text-dark">Selesai</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <div class="block" >
                                    <h6 class="no-paddingTop font-w400  text-dark" style="float: left;" >Dana Diterima</h6>   
                                </div>
                                <div class="block">  
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 5px ">
                                        <div class="p-10">
                                            <div class="js-pie-chart pie-chart js-pie-chart-enabled" data-percent="{{$dataPersen}}" data-line-width="4" data-size="100" data-bar-color="#00CD98" data-track-color="#e9e9e9">
                                                <span><i class="si si-diamond judul"></i></span>
                                            </div>
                                        </div>
                                        <div class="ml-5 text-left">                                                        
                                            <p class="font-size-sm text-uppercase font-w600 text-green1 mb-0">
                                                <i class="fa fa-arrow-up text-green1" style="-ms-transform: rotate(20deg); -webkit-transform: rotate(20deg); transform: rotate(20deg);"></i> + {{$dataPersen}}%
                                            </p>
                                            <p class="text-muted font-w600 mb-0 judul" style="font-size: 2em;">
                                                {{$danaditerima}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="block" >
                                    <h6 class="no-paddingTop font-w400  text-dark" style="float: left;" >Total Imbal Hasil</h6>   
                                </div> 
                                <div class="block">
                                    <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 5px ">
                                        <div class="p-10">
                                            <div class="js-pie-chart pie-chart js-pie-chart-enabled" data-percent="{{$dataPersenImbalHasil}}" data-line-width="4" data-size="100" data-bar-color="#2C7A1B" data-track-color="#e9e9e9">
                                                <span><i class="si si-present judul"></i></span>
                                            </div>
                                        </div>
                                        <div class="ml-5 text-left">                                                        
                                            <p class="font-size-sm text-uppercase font-w600 text-green2 mb-0">
                                                <i class="fa fa-arrow-up text-green2" style="-ms-transform: rotate(20deg); -webkit-transform: rotate(20deg); transform: rotate(20deg);"></i> + {{$dataPersenImbalHasil}}%
                                            </p>
                                            <p class="text-muted font-w600 mb-0 judul" style="font-size: 2em;">
											{{$danaImbalHasil}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                    <div class="block" >
                                        <h6 class="no-paddingTop font-w400  text-dark" style="float: left;" >Total Hutang Berjalan</h6>   
                                    </div>
                                    <div class="block">  
                                        <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 5px ">
                                            <div class="p-10">
                                                <div class="js-pie-chart pie-chart js-pie-chart-enabled" data-percent="0" data-line-width="4" data-size="100" data-bar-color="#CD00BC" data-track-color="#e9e9e9">
                                                    <span><i class="fa fa-clock-o judul"></i></span>
                                                </div>
                                            </div>
                                            <div class="ml-5 text-left">                                                        
                                                <p class="font-size-sm text-uppercase font-w600 text-red1 mb-0">
                                                    <i class="fa fa-arrow-up text-red1" style=" -ms-transform: rotate(20deg); -webkit-transform: rotate(20deg); transform: rotate(20deg);"></i> + 0%
                                                </p>
                                                <p class="text-muted font-w600 mb-0 judul" style="font-size: 2em;">
                                                    Rp. 0
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-12 col-md-6">
                                    <div class="block" >
                                        <h6 class="no-paddingTop font-w400  text-dark" style="float: left;" >Dana Dikembalikan</h6>   
                                    </div>
                                    <div class="block">
                                        <div class="mt-5 pt-5 block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 5px;">
                                            <div class="p-10">
                                                <div class="js-pie-chart pie-chart js-pie-chart-enabled" data-percent="0" data-line-width="4" data-size="100" data-bar-color="#960792" data-track-color="#e9e9e9">
                                                    <span><i class="fa fa-external-link judul"></i></span>
                                                </div>
                                            </div>
                                            <div class="ml-5 text-left">                                                        
                                                <p class="font-size-sm text-uppercase font-w600 text-red1 mb-0">
                                                    <i class="fa fa-arrow-up text-red1" style=" -ms-transform: rotate(20deg); -webkit-transform: rotate(20deg); transform: rotate(20deg);"></i> + 0%
                                                </p>
                                                <p class="text-muted font-w600 mb-0 judul" style="font-size: 2em;">
                                                    Rp. 0
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            <div class="col-12 col-md-12">
                                <!-- timeline -->
                                <div class="block">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title text-muted">Aktifitas Terbaru</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                                <i class="si si-refresh"></i>
                                            </button>
                                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <ul class="list list-activity">
                                            <li>
                                                <div class=" pull-r-l">
                                                    <div class="">  
                                                        <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 5px ">
                                                            
                                                            <div class="p-5 pr-30">
                                                                <div class="avatar-circle">
                                                                    <span class="initials">PD</span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="ml-2 text-left">   
                                                                <div class="font-w600 text-muted">Pendanaan Baru Diajukan</div>
                                                                <div>
                                                                    <a href="javascript:void(0)">Pendanaan Pembuatan Admin Template</a>
                                                                </div>
                                                                <div class="font-size-xs text-muted">5 min ago</div>
                                                            
                                                            </div>                                                                  
                                                        </div>
                                                    </div>
                                                </div> 
                                                
                                            </li>
                                            <li>
                                                <div class=" pull-r-l">
                                                    <div class="">  
                                                        <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 5px ">
                                                            
                                                            <div class="p-5 pr-30">
                                                                <div class="avatar-circle">
                                                                    <span class="initials">PV</span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="ml-2 text-left">   
                                                                <div class="font-w600 text-muted">Pendanaan Baru Terverifikasi</div>
                                                                <div>
                                                                    <a href="javascript:void(0)">Pendanaan Pembuatan Admin Template</a>
                                                                </div>
                                                                <div class="font-size-xs text-muted">25 min ago</div>
                                                            
                                                            </div>                                                                  
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>                           
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main> 
    @endif
    <!-- END Main Container -->
@endsection