@extends('layouts.borrower.master')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Side Overlay-->
    
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
                    <div class="col-12 col-md-12 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: 0em;" >Riwayat Mutasi</h1>                            
                        </span>
                    </div>
                    <div  class="col-12 col-md-12">
                        <span class="mb-10">
                            <div class="form-material floating">
                                <input type="text" class="form-control col-12 col-md-12" style="height: calc(1.5em + .757143rem + 2px);" id="material-text2" name="material-text2">
                                <label for="material-text2" style="color: #8B8B8B!important;" class="font-w300"> <i class="fa fa-search"></i> Cari Berdasarkan Nama atau Lokasi</label>
                            </div>
                        </span>
                        <div class="col-12 mt-20" style="padding-left: 0px;">
                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Aktif
                            </label>
                            <label class="css-control css-control-fully css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Fully Funded
                            </label>
                            <label class="css-control css-control-closed css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Closed
                            </label>
                            <label class="css-control css-control-selesai css-radio mr-10 text-dark">
                                <input type="checkbox" class="css-control-input" name="sppp" checked>
                                <span class="css-control-indicator"></span> Selesai
                            </label>
                        </div>
                    </div>
                   
                </div>
                <div class="row mt-10 pt-5">
                    <div class="col-md-12 mt-5 pt-5">
                        <div class="row">                        
                            <div class="col-12">
                            <!-- Full Table -->
                            <div class="block">
                                <div class="block-content">                                    
                                    <div class="table-responsive">
                                            
                                        <table class="table table-striped table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 100px;">NO</th>
                                                    <th style="width: 30%;" data-toggle="tooltip" title="Nama Pendanaan Proyek">NAMA PENDANAAN</th>
                                                    <th style="width: 15%;" data-toggle="tooltip" title="Tanggal Penerimaan Pendanaan">TERIMA DANA</th>
                                                    <th class="text-center" style="width: 20%;" data-toggle="tooltip" title="Dana Pokok yang diterima">DANA POKOK</th>
                                                    <th class="text-center" style="width: 20%;" data-toggle="tooltip" title="Total Dana Imbal Hasil yang harus dikembalikan">IMBAL HASIL</th>
                                                    <th class="text-center" style="width: 25%;" data-toggle="tooltip" title="Total Dana  yang harus dibayar">TOTAL BAYAR</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr data-toggle="modal" data-target="#modal-mutasi">
                                                    <td class="text-center">
                                                        1
                                                    </td>
                                                    <td style="cursor: pointer;" class="text-primary font-w700" data-toggle="tooltip" title="Klik untuk melihat detail"> Pendanaan XI/09 Bojong Gede</td>
                                                    <td > 07 April 2020</td>
                                                    <td class="text-right">Rp. 500.000.000</td>
                                                    <td class="text-right">Rp. 50.000.000</td>
                                                    <td class="text-right">Rp. 550.000.000</td>
                                                </tr>
                                                <tr data-toggle="modal" data-target="#modal-mutasi">
                                                    <td class="text-center">
                                                        2
                                                    </td>
                                                    <td style="cursor: pointer;" class="text-primary font-w700" data-toggle="tooltip" title="Klik untuk melihat detail"> Pendanaan XI/09 Bojong Gede</td>
                                                    <td > 07 April 2020</td>
                                                    <td class="text-right">Rp. 500.000.000</td>
                                                    <td class="text-right">Rp. 50.000.000</td>
                                                    <td class="text-right">Rp. 550.000.000</td>
                                                </tr>
                                                <tr data-toggle="modal" data-target="#modal-mutasi">
                                                    <td class="text-center">
                                                        3
                                                    </td>
                                                    <td style="cursor: pointer;" class="text-primary font-w700" data-toggle="tooltip" title="Klik untuk melihat detail"> Pendanaan XI/09 Bojong Gede</td>
                                                    <td > 07 April 2020</td>
                                                    <td class="text-right">Rp. 500.000.000</td>
                                                    <td class="text-right">Rp. 50.000.000</td>
                                                    <td class="text-right">Rp. 550.000.000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- END Full Table -->
                            </div>
                            
                        </div>
                    </div>                           
                </div>
                @include('includes.borrower.modal_detail_riwayat_mutasi')
                
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
@endsection
    