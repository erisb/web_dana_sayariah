@extends('layouts.borrower.master')

@section('title', 'Welcome Borrower')

@section('content')
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div id="detect-screen" class="content-full-right">
            <div class="container">
                <div class="row">
                    <div id="col" class="col-12 col-md-12 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: 0em;" >Lengkapi Data</h1>
                            <span class="pull-right">
                            <h6 class=" font-w700 text-dark" style="float: left; margin-block-end: 0em;" >1 dari 2 Langkah</h6>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-md-12 mt-5 pt-5">
                        <div class="row">
                            
                            <div class="col-12 col-md-12">
                                <!-- Progress Wizard 2 -->
                                <div class="js-wizard-simple block">
                                    <!-- Wizard Progress Bar -->
                                    <div class="progress rounded-0" data-wizard="progress" style="height: 8px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- END Wizard Progress Bar -->

                                    <!-- Step Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#wizard-progress2-step1" data-toggle="tab">1. Data Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-progress2-step2" data-toggle="tab">2. Informasi Pendanaan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-progress2-step3" data-toggle="tab">3. Dokumen Pendukung</a>
                                        </li>
                                    </ul>
                                    <!-- END Step Tabs -->

                                    <!-- Form -->
                                    <form action="#" method="post">
                                        <!-- Steps Content -->
                                        <div class="block-content block-content-full tab-content" style="min-height: 274px;">
                                            <!-- Step 1 -->
                                            <div class="tab-pane active" id="wizard-progress2-step1" role="tabpanel">
                                                <!-- Pribadi -->
                                                <!-- satuBaris -->
                                                <div class="row">
                                                    <div class="col-md-6 mt-5 mb-5">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text input-group-text-dsi">
                                                                    <i class="fa fa-gear "></i>
                                                                </span>
                                                            </div>
                                                            <select class="form-control col-4" style="font-size: 1em" id="type-select" name="type-select">
                                                                <option value="layout-pribadi">Pribadi</option>
                                                                <option value="layout-badanhukum">Badan Hukum</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="pb-5">
                                                <div id="layout-pribadi" class="layout">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Nama Pengguna</label>
                                                                            <input class="form-control" type="text" id="wizard-progress2-namapengguna" name="wizard-progress2-namapengguna" placeholder="Masukkan Nama Anda...">  
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Pendidikan Terakhir</label>
                                                                        <select class="form-control col-6" id="example-select" name="example-select">
                                                                            <option value="0">Pilih Pendidikan</option>
                                                                            <option value="1">SMP</option>
                                                                            <option value="2">SMA</option>
                                                                            <option value="2">Sarjana (S1)</option>
                                                                            <option value="2">Magister (S2)</option>
                                                                            <option value="2">Doctor (S3)</option>
                                                                        </select>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Nomor Kartu Tanda Penduduk (KTP)</label>
                                                                        <input class="form-control" type="number" id="wizard-progress2-ktp" name="wizard-progress2-ktp" placeholder="Masukkan nomor KTP">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Nomor NPWP</label>
                                                                        <input class="form-control col-8" type="text" id="wizard-progress2-npwp" name="wizard-progress2-npwp" placeholder="Masukkan nomor NPWP">  
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-tempatlahir">Tempat Lahir</label>
                                                                        <input class="form-control" type="number" id="wizard-progress2-tempatlahir" name="wizard-progress2-tempatlahir" placeholder="Masukkan tempat lahir">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                    <div class="form-group col-12 col-md-4">
                                                                        <label for="wizard-progress2-npwp">Hari</label>
                                                                        <select class="form-control" id="example-select" name="example-select">
                                                                            <option value="0">Pilih hari</option>
                                                                            <option value="1">01</option>
                                                                            <option value="2">02</option>
                                                                            <option value="3">03</option>
                                                                            <option value="4">04</option>
                                                                            <option value="5">05</option>
                                                                            <option value="6">06</option>
                                                                            <option value="7">07</option>
                                                                            <option value="8">08</option>
                                                                            <option value="9">09</option>
                                                                            <option value="10">10</option>
                                                                            <option value="11">11</option>
                                                                            <option value="12">12</option>
                                                                            <option value="13">13</option>
                                                                            <option value="14">14</option>
                                                                            <option value="15">15</option>
                                                                            <option value="16">16</option>
                                                                            <option value="17">17</option>
                                                                            <option value="18">18</option>
                                                                            <option value="19">19</option>
                                                                            <option value="20">20</option>
                                                                            <option value="21">21</option>
                                                                            <option value="22">22</option>
                                                                            <option value="23">23</option>
                                                                            <option value="24">24</option>
                                                                            <option value="25">25</option>
                                                                            <option value="26">26</option>
                                                                            <option value="27">27</option>
                                                                            <option value="28">28</option>
                                                                            <option value="29">29</option>
                                                                            <option value="30">30</option>
                                                                            <option value="31">31</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-12 col-md-4">
                                                                        <label for="wizard-progress2-npwp">Bulan</label>
                                                                        <select class="form-control" id="example-select" name="example-select">
                                                                            <option value="0">Pilih Bulan</option>
                                                                            <option value="1">Januari</option>
                                                                            <option value="2">Ferbruari</option>
                                                                            <option value="3">Maret</option>
                                                                            <option value="4">April</option>
                                                                            <option value="5">Mei</option>
                                                                            <option value="6">Juni</option>
                                                                            <option value="7">Juli</option>
                                                                            <option value="8">Agustus</option>
                                                                            <option value="9">September</option>
                                                                            <option value="10">Oktober</option>
                                                                            <option value="11">Nopember</option>
                                                                            <option value="12">Desember</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-12 col-md-4">
                                                                        <label for="wizard-progress2-npwp">Tahun</label>
                                                                        <select class="form-control" id="example-select" name="example-select">
                                                                            <option value="0">Pilih Tahun</option>
                                                                            <option value="1">1990</option>
                                                                            <option value="2">1991</option>
                                                                        </select>
                                                                    </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Jenis Kelamin</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="jeniskelamin">
                                                                                <span class="css-control-indicator"></span> Perempuan
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="jeniskelamin">
                                                                                <span class="css-control-indicator"></span> Laki-Laki
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Agama</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="agama">
                                                                                <span class="css-control-indicator"></span> Islam
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="agama">
                                                                                <span class="css-control-indicator"></span> Kristen
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="agama">
                                                                                <span class="css-control-indicator"></span> Hindu
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="agama">
                                                                                <span class="css-control-indicator"></span> Budhaislam
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Status Perkawinan</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="statusperkawinan">
                                                                                <span class="css-control-indicator"></span> Single
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="statusperkawinan">
                                                                                <span class="css-control-indicator"></span> Menikah
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="statusperkawinan">
                                                                                <span class="css-control-indicator"></span> Duda / Janda
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- /// -->
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Tempat Tinggal</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kota</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Kota</option>
                                                                                    <option value="1">Jakarta</option>
                                                                                    <option value="2">Bali</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Provinsi</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Provinsi</option>
                                                                                    <option value="1">Provinsi 1</option>
                                                                                    <option value="2">Provinsi 2</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kode Pos</label>
                                                                                <input class="form-control" type="number" id="wizard-progress2-namapengguna" name="wizard-progress2-namapengguna" placeholder="Masukkan kode Pos">  
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris --> 
                                                                        <div class="col-md-9">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Alamat Lengkap</label>
                                                                                <textarea class="form-control form-control-lg" id="alamat-bio" name="alamat-bio" rows="6" placeholder="Masukkan alamat lengkap Anda.."></textarea>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="col-12">Status Kepemilikan Rumah</label>
                                                                                <div class="col-12">
                                                                                    <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                        <input type="checkbox" class="css-control-input" name="statusrumah">
                                                                                        <span class="css-control-indicator"></span> Milik Pribadi
                                                                                    </label>
                                                                                    <label class="css-control css-control-primary css-radio text-dark">
                                                                                        <input type="checkbox" class="css-control-input" name="statusrumah">
                                                                                        <span class="css-control-indicator"></span> Sewa / Kontrak
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Lain-lain</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Pekerjaan</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Pekerjaan</option>
                                                                                    <option value="1">Pegawai Negri Sipil</option>
                                                                                    <option value="2">Wiraswasta</option>
                                                                                    <option value="3">Karyawan Swasta</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Bidang Pekerjaan</option>
                                                                                    <option value="1">Industri 1</option>
                                                                                    <option value="2">Industri 2</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan Online</label>
                                                                                <input class="form-control" type="text" id="wizard-progress2-namapengguna" name="wizard-progress2-namapengguna" placeholder="Masukkan Bidang Pekerjaan">  
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris -->  
                                                                    </div>
                                                                    <div class="row mb-20">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Pengalaman Kerja</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Pengalaman</option>
                                                                                    <option value="1">Pegawai Negri Sipil</option>
                                                                                    <option value="2">Wiraswasta</option>
                                                                                    <option value="3">Karyawan Swasta</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Pendapatan Bulanan</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Bidang Pekerjaan</option>
                                                                                    <option value="1">Industri 1</option>
                                                                                    <option value="2">Industri 2</option>
                                                                                </select>
                                                                            </div>
                                                                        </div> 
                                                                        <!-- satuBaris -->  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Badan Hukum -->
                                                <div id="layout-badanhukum" class="layout" style="display: none">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namabadanhukum">Nama Badan Hukum</label>
                                                                            <input class="form-control" type="text" id="wizard-progress2-namabadanhukum" name="wizard-progress2-namabadanhukum" placeholder="Masukkan Nama Perusahaan anda...">  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Nomor NPWP</label>
                                                                        <input class="form-control col-8" type="text" id="wizard-progress2-npwp" name="wizard-progress2-npwp" placeholder="Masukkan nomor NPWP">  
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Pengurus</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-12 " >
                                                                            <div class="row " id="tambahPenanggungJawab">
                                                                                <!-- satuBaris -->

                                                                                <div class="col-12 ">
                                                                                    <div class="row ">
                                                                                        <div class="col-12">
                                                                                            <h6 class="content-heading text-muted font-w600 mt-0 pt-0" style="font-size: 1em;">Pengurus 1</h6>                                                                                            
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-namapengurus">Nama Pengurus</label>
                                                                                                <input class="form-control" type="text" id="wizard-progress2-namapengurus" name="wizard-progress2-namapengurus" placeholder="Masukkan nama pengurus...">  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">NIK</label>
                                                                                                <input class="form-control" type="text" id="wizard-progress2-namapengurus" name="wizard-progress2-nik" placeholder="Masukkan NIK pengurus...">  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nomorhp">No Telepon / HP</label>
                                                                                                <input class="form-control" type="number" id="wizard-progress2-nomorhp" name="wizard-progress2-nomorhp" placeholder="Masukkan nomor telepon">  
                                                                                            </div>
                                                                                        </div> 
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-jabatan">Jabatan</label>
                                                                                                <input class="form-control" type="text" id="wizard-progress2-jabatan" name="wizard-progress2-jabatan" placeholder="Masukkan nomor telepon">  
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                 
                                                                            </div>
                                                                        </div>
                                                                        <!-- new row -->
                                                                        <div class="col-12">
                                                                            <button type="button" class="btn btn-rounded btn-primary btn-dsi min-width-200 mb-10 push-right" onclick="add_penanggung_jawab()">Tambah Pengurus</button>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Lokasi Kantor</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kota</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Kota</option>
                                                                                    <option value="1">Jakarta</option>
                                                                                    <option value="2">Bali</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Provinsi</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Provinsi</option>
                                                                                    <option value="1">Provinsi 1</option>
                                                                                    <option value="2">Provinsi 2</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kode Pos</label>
                                                                                <input class="form-control" type="number" id="wizard-progress2-namapengguna" name="wizard-progress2-namapengguna" placeholder="Masukkan kode Pos">  
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris --> 
                                                                        <div class="col-md-9">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Alamat Lengkap</label>
                                                                                <textarea class="form-control form-control-lg" id="alamat-bio" name="alamat-bio" rows="6" placeholder="Masukkan alamat lengkap Anda.."></textarea>
                                                                            </div>
                                                                        </div> 
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Lain-lain</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan</label>
                                                                                <select class="form-control" id="example-select" name="example-select">
                                                                                    <option value="0">Pilih Bidang Pekerjaan</option>
                                                                                    <option value="1">Industri 1</option>
                                                                                    <option value="2">Industri 2</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan Online</label>
                                                                                <input class="form-control" type="text" id="wizard-progress2-namapengguna" name="wizard-progress2-namapengguna" placeholder="Masukkan Bidang Pekerjaan">  
                                                                            </div>
                                                                        </div>  
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-revenue">Revenue Bulanan</label>
                                                                                <input class="form-control" type="number" id="wizard-progress2-revenue" name="wizard-progress2-revenue" placeholder="Masukkan Revenue bulanan">  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-aset">Total Aset</label>
                                                                                <input class="form-control" type="number" id="wizard-progress2-aset" name="wizard-progress2-aset" placeholder="Masukkan Total aset">  
                                                                            </div>
                                                                        </div>
                                                                        <!-- satuBaris -->  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Step 1 -->

                                            <!-- Step 2 -->
                                            <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
                                                <div id="layout-x">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div id="layout-pribadi" class="layout col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Tipe Pendanaan (Pribadi)</label>
                                                                            <select class="form-control" id="type-pendanaan-select" name="type-pendanaan-select">
                                                                                <option value="0">Pilih Tipe Pendanaan</option>
                                                                                <option value="layout-pembangunan-property-terjual">Pembangunan Properti Terjual</option>
                                                                                <option value="layout-renovasi-properti">Renovasi Properti</option>
                                                                                <option value="layout-kepemilikan-aset">Kepemilikan Aset</option>
                                                                                <option value="layout-invoice-financing">Invoice FInancing (Factoring)</option>
                                                                                <option value="layout-modal-kerja">Modal Kerja</option>
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div id="layout-badanhukum" class="layout col-md-3" style="display: none;">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Tipe Pendanaan (Badan Hukum)</label>
                                                                            <select class="form-control" id="type-pendanaan-select" name="type-pendanaan-select">
                                                                                <option value="0">Pilih Tipe Pendanaan</option>
                                                                                <option value="layout-pembangunan-property-terjual">Pembangunan Properti Terjual</option>
                                                                                <option value="layout-renovasi-properti">Renovasi Properti</option>
                                                                                <option value="layout-kepemilikan-aset">Kepemilikan Aset</option>
                                                                                <option value="layout-invoice-financing">Invoice FInancing (Factoring)</option>
                                                                                <option value="layout-modal-kerja">Modal Kerja</option>
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-namapendanaan">Nama Pendanaan</label>
                                                                        <input class="form-control" type="number" id="wizard-progress2-namapendanaan" name="wizard-progress2-namapendanaan" placeholder="Masukkan nama pendanaan">  
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Akad</label>
                                                                        <select class="form-control" id="example-select" name="example-select">
                                                                            <option value="0">Pilih Jenis Akad</option>
                                                                            <option value="1">Muarabahah - Jual Beli</option>
                                                                            <option value="1">Mura - X Beli</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group pb-0 mb-0">
                                                                        <label for="wizard-progress2-ktp">Margin Keuntungan</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="number" id="wizard-progress2-ktp" name="wizard-progress2-ktp" placeholder="--" disabled>  
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text input-group-text-dsi">
                                                                                %
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-tempatlahir">Dana Dibutuhkan</label>
                                                                        <input class="form-control" type="number" id="wizard-progress2-tempatlahir" name="wizard-progress2-tempatlahir" placeholder="Masukkan dana yang anda butuhkan...">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="row">
                                                                        <div class="form-group col-12">
                                                                            <label for="wizard-progress2-npwp">Harga Per-Paket</label>
                                                                            <select class="form-control" id="example-select" name="example-select">
                                                                                <option value="0">1 Juta</option>
                                                                            </select>
                                                                        </div>
                                                                    
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-8">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Mode Pembayaran</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="jeniskelamin">
                                                                                <span class="css-control-indicator"></span> Cicilan Bulanan
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="jeniskelamin">
                                                                                <span class="css-control-indicator"></span> Pelunasan di Akhir
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- satuBaris -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Estimasi Mulai Proyek</label>
                                                                        <input class="form-control" type="text" id="wizard-progress2-tempatlahir" name="wizard-progress2-tempatlahir" placeholder="00/00/0000">  
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-tempatlahir">Estimasi Selesai Proyek</label>
                                                                        <input class="form-control" type="text" id="wizard-progress2-tempatlahir" name="wizard-progress2-tempatlahir" placeholder="00/00/0000">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group pb-0 mb-0">
                                                                        <label for="wizard-progress2-ktp">Durasi Proyek/Tenor</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="number" id="wizard-progress2-ktp" name="wizard-progress2-ktp" placeholder="Estimasi Hari" disabled>  
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text input-group-text-dsi"> Hari
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Estimasi Mulai Penggalangan</label>
                                                                        <input class="form-control" type="text" id="wizard-progress2-tempatlahir" name="wizard-progress2-tempatlahir" placeholder="00/00/0000">  
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-tempatlahir">Estimasi Selesai Penggalangan</label>
                                                                        <input class="form-control" type="text" id="wizard-progress2-tempatlahir" name="wizard-progress2-tempatlahir" placeholder="00/00/0000">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group pb-0 mb-0">
                                                                        <label for="wizard-progress2-ktp">Durasi Proyek/Tenor</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="number" id="wizard-progress2-ktp" name="wizard-progress2-ktp" placeholder="Estimasi Hari" disabled>  
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text input-group-text-dsi"> Hari
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-8">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Pembagian Imbal Hasil</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="imbalhasil">
                                                                                <span class="css-control-indicator"></span> Tiap Bulanan
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="checkbox" class="css-control-input" name="imbalhasil">
                                                                                <span class="css-control-indicator"></span> Per 3 Bulanan
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                                <!-- satuBaris --> 
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Detail Pendanaan</h6>        
                                                            <div class="form-group row">
                                                                <div class="col-12">
                                                                    <textarea class="js-simplemde" id="simplemde" name="simplemde" style="display: none;">Hello SimpleMDE!</textarea><div class="editor-toolbar"><a title="Bold (Cmd-B)" tabindex="-1" class="fa fa-bold"></a><a title="Italic (Cmd-I)" tabindex="-1" class="fa fa-italic"></a><a title="Heading (Cmd-H)" tabindex="-1" class="fa fa-header"></a><i class="separator">|</i><a title="Quote (Cmd-')" tabindex="-1" class="fa fa-quote-left"></a><a title="Generic List (Cmd-L)" tabindex="-1" class="fa fa-list-ul"></a><a title="Numbered List (Cmd-⌥-L)" tabindex="-1" class="fa fa-list-ol"></a><i class="separator">|</i><a title="Create Link (Cmd-K)" tabindex="-1" class="fa fa-link"></a><a title="Insert Image (Cmd-⌥-I)" tabindex="-1" class="fa fa-picture-o"></a><i class="separator">|</i><a title="Toggle Preview (Cmd-P)" tabindex="-1" class="fa fa-eye no-disable"></a><a title="Toggle Side by Side (F9)" tabindex="-1" class="fa fa-columns no-disable no-mobile"></a><a title="Toggle Fullscreen (F11)" tabindex="-1" class="fa fa-arrows-alt no-disable no-mobile"></a><i class="separator">|</i><a title="Markdown Guide" tabindex="-1" class="fa fa-question-circle" href="https://simplemde.com/markdown-guide" target="_blank"></a></div><div class="CodeMirror cm-s-paper CodeMirror-wrap"><div style="overflow: hidden; position: relative; width: 3px; height: 0px; top: 15px; left: 15px;"><textarea autocorrect="off" autocapitalize="off" spellcheck="false" style="position: absolute; padding: 0px; width: 1000px; height: 1em; outline: none;" tabindex="0"></textarea></div><div class="CodeMirror-vscrollbar" cm-not-content="true" style="width: 18px; pointer-events: none;"><div style="min-width: 1px; height: 0px;"></div></div><div class="CodeMirror-hscrollbar" cm-not-content="true" style="height: 18px; pointer-events: none;"><div style="height: 100%; min-height: 1px; width: 0px;"></div></div><div class="CodeMirror-scrollbar-filler" cm-not-content="true"></div><div class="CodeMirror-gutter-filler" cm-not-content="true"></div><div class="CodeMirror-scroll" tabindex="-1"><div class="CodeMirror-sizer" style="margin-left: 0px; margin-bottom: 0px; border-right-width: 30px; min-height: 29px; padding-right: 0px; padding-bottom: 0px;"><div style="position: relative; top: 0px;"><div class="CodeMirror-lines"><div style="position: relative; outline: none;"><div class="CodeMirror-measure"></div><div class="CodeMirror-measure"></div><div style="position: relative; z-index: 1;"></div><div class="CodeMirror-cursors"><div class="CodeMirror-cursor" style="left: 4px; top: 0px; height: 21px;">&nbsp;</div></div><div class="CodeMirror-code"><pre class=" CodeMirror-line "><span style="padding-right: 0.1px;">Hello SimpleMDE!</span></pre></div></div></div></div></div><div style="position: absolute; height: 30px; width: 1px; border-bottom: 0px solid transparent; top: 29px;"></div><div class="CodeMirror-gutters" style="display: none; height: 59px;"></div></div></div><div class="editor-preview-side"></div><div class="editor-statusbar"><span class="autosave"></span><span class="lines">1</span><span class="words">2</span><span class="cursor">0:0</span></div>
                                                                </div>
                                                            </div> 
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Media Gallery</h6>
                                                            <!-- satuBaris -->
                                                            <div class="form-group row">
                                                                <label class="col-12">Pilih Gambar Utama</label>
                                                                <div class="col-8">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input js-custom-file-input-enabled" id="example-file-input-custom" name="example-file-input-custom" data-toggle="custom-file-input">
                                                                        <label class="custom-file-label" for="example-file-input-custom">Pilih Gambar</label>
                                                                    </div>
                                                                </div>
                                                            </div> 

                                                            <div class="form-group row mt-20 mb-10">
                                                                <label class="col-12">Gambar Gallery</label>
                                                                <div class="col-12">
                                                                    <!-- Dropzone.js -->
                                                                    <form ></form> 
                                                                    <form action="/upload-target" class="dropzone" id="drop" >
                                                                        <div class="dz-message needsclick">
                                                                            <i class="fa fa-picture-o fa-5x text-primary" aria-hidden="true"></i>
                                                                            <p class="text-dark">
                                                                                Drag Gambar ke sini! <br>
                                                                                <small>file type : .jpeg, .jpg, .png</small>
                                                                            </p>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div> 
                                                            
                                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Step 2 -->

                                            <!-- Step 3 -->
                                            <div class="tab-pane" id="wizard-progress2-step3" role="tabpanel">
                                            <!-- 1 -->
                                            <div id="layout-pembangunan-property-terjual"  class="layout-dokumen">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row"> 
                                                            <div class="col-12">
                                                                <h3 class="content-heading text-dark mt-0 pt-0 font-w600" >Kelengkapan Dokumen</h3>
                                                                <p class="text-dark">Dalam mengajukan pendanaan <span class="font-w700"> PEMBANGUNAN PROPERTI TERJUAL </span> berikut dokumen pendukung yang harus anda miliki, centang jika file tersedia dan
                                                                siap untuk di periksa tim Dana Syariah Indonesia.</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <div class="col-12">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input " name="sd">
                                                                            <span class="css-control-indicator"></span> Semua Dokumen Tersedia
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Permohonan Pengajuan Pembiayaan
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> KTP/SIM/Pasport Suami/isteri
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="ktpsim">
                                                                            <span class="css-control-indicator"></span> Kartu Keluarga
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="pprk">
                                                                            <span class="css-control-indicator"></span> Surat Nikah/Cerai
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="kk">
                                                                            <span class="css-control-indicator"></span> Surat Kewarganegaraan dan ganti nama untuk WNI Keturunan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Curriculum Vitae Pemohon
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Usaha Perdagangan (SIUP), Kontraktor (SIUJK)
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Tanda Daftar Perusahaan (TDP)
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Tempat Usaha (SITU)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Surat Keterangan Domisili (M)
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Izin/Undang-undang Gangguan (HO)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> NPWP
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Past Performance (R/K) 6 bulan terakhir
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Laporan Keuangan/Neraca &amp; Laba Rugi 2 tahun terakhir (Audited)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Rencana Anggaran Biaya (RAB) Proyek
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana jadwal pembangunan proyek (persiapan s/d akhir)/Timeline
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Daftar Pemesan / SPR
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Feasibility Study
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-12 mt-2">
                                                                        <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Dokumen Jaminan</h6>    
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Seritifikat (SHM/SHGB)
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Bukti pembayaran pajak/PBB terbaru
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> IMB
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Hasil Penilaian Asset/Apraisal terbaru
                                                                        </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>    
                                                        </div>         
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- ./ 1 -->
                                            <!-- 2 -->
                                            <div id="layout-renovasi-properti" style="display: none;" class="layout-dokumen">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row"> 
                                                            <div class="col-12">
                                                                <h3 class="content-heading text-dark mt-0 pt-0 font-w600" >Kelengkapan Dokumen</h3>
                                                                <p class="text-dark">Dalam mengajukan pendanaan <span class="font-w700 class="text-dark""> RENOVASI PROPERTI </span> berikut dokumen pendukung yang harus anda miliki, centang jika file tersedia dan
                                                                siap untuk di periksa tim Dana Syariah Indonesia.</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <div class="col-12">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input " name="sd">
                                                                            <span class="css-control-indicator"></span> Semua Dokumen Tersedia
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Permohonan Pengajuan Pembiayaan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> NPWP
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="ktpsim">
                                                                            <span class="css-control-indicator"></span> KTP/SIM/Pasport Suami atau Istri
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="pprk">
                                                                            <span class="css-control-indicator"></span> Past Performance (R/K) 6 bulan terakhir
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="kk">
                                                                            <span class="css-control-indicator"></span> Kartu Keluarga
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Laporan Keuangan/Neraca Laba Rugi 2 tahun terakhir (Audited)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Nikah / Cerai
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Anggaran Biaya (RAB) Proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Kewarganegaraan dan ganti nama untuk WNI Keturunan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana jadwal pembangunan proyek (persiapan s/d akhir)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Curriculum Vitae Pemohon
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Cash flow/Arus kas proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Usaha Perdagangan (SIUP), Kontraktor (SIUJK)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Feasibility Study
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Tanda Daftar Perusahaan (TDP)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Seritifikat (SHM/SHGB) asset jaminan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Tempat Usaha (SITU)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Bukti pembayaran pajak/PBB terbaru
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Keterangan Domisili
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> IMB
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Undang-undang Gangguan (HO)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Hasil Penilaian Asset/Apraisal terbaru
                                                                        </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>    
                                                        </div>         
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- ./ 2 -->
                                            <!-- 3 -->
                                            <div id="layout-kepemilikan-aset" style="display: none;" class="layout-dokumen">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row"> 
                                                            <div class="col-12">
                                                                <h3 class="content-heading text-dark mt-0 pt-0 font-w600" >Kelengkapan Dokumen</h3>
                                                                <p class="text-dark">Dalam mengajukan pendanaan <span class="font-w700"> KEPEMILIKAN ASET </span> berikut dokumen pendukung yang harus anda miliki, centang jika file tersedia dan
                                                                siap untuk di periksa tim Dana Syariah Indonesia.</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <div class="col-12">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input " name="sd">
                                                                            <span class="css-control-indicator"></span> Semua Dokumen Tersedia
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Permohonan Pengajuan Pembiayaan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> NPWP
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="ktpsim">
                                                                            <span class="css-control-indicator"></span> KTP/SIM/Pasport Suami atau Istri
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="pprk">
                                                                            <span class="css-control-indicator"></span> Past Performance (R/K) 6 bulan terakhir
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="kk">
                                                                            <span class="css-control-indicator"></span> Kartu Keluarga
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Laporan Keuangan/Neraca Laba Rugi 2 tahun terakhir (Audited)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Nikah / Cerai
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Anggaran Biaya (RAB) Proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Kewarganegaraan dan ganti nama untuk WNI Keturunan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana jadwal pembangunan proyek (persiapan s/d akhir)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Curriculum Vitae Pemohon
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Cash flow/Arus kas proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Usaha Perdagangan (SIUP), Kontraktor (SIUJK)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Feasibility Study
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Tanda Daftar Perusahaan (TDP)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Seritifikat (SHM/SHGB) asset jaminan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Tempat Usaha (SITU)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Bukti pembayaran pajak/PBB terbaru
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Keterangan Domisili
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> IMB
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Undang-undang Gangguan (HO)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Hasil Penilaian Asset/Apraisal terbaru
                                                                        </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>    
                                                        </div>         
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- ./ 3 -->
                                            <!-- 4 -->
                                            <div id="layout-invoice-financing" style="display: none;" class="layout-dokumen">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row"> 
                                                            <div class="col-12">
                                                                <h3 class="content-heading text-dark mt-0 pt-0 font-w600" >Kelengkapan Dokumen</h3>
                                                                <p class="text-dark">Dalam mengajukan pendanaan <span class="font-w700"> INVOICE FINANCING </span> berikut dokumen pendukung yang harus anda miliki, centang jika file tersedia dan
                                                                siap untuk di periksa tim Dana Syariah Indonesia.</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <div class="col-12">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input " name="sd">
                                                                            <span class="css-control-indicator"></span> Semua Dokumen Tersedia
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Permohonan Pengajuan Pembiayaan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> NPWP
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="ktpsim">
                                                                            <span class="css-control-indicator"></span> KTP/SIM/Pasport Suami atau Istri
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="pprk">
                                                                            <span class="css-control-indicator"></span> Past Performance (R/K) 6 bulan terakhir
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="kk">
                                                                            <span class="css-control-indicator"></span> Kartu Keluarga
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Laporan Keuangan/Neraca Laba Rugi 2 tahun terakhir (Audited)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Nikah / Cerai
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Anggaran Biaya (RAB) Proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Kewarganegaraan dan ganti nama untuk WNI Keturunan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana jadwal pembangunan proyek (persiapan s/d akhir)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Curriculum Vitae Pemohon
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Cash flow/Arus kas proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Usaha Perdagangan (SIUP), Kontraktor (SIUJK)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Feasibility Study
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Tanda Daftar Perusahaan (TDP)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Seritifikat (SHM/SHGB) asset jaminan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Tempat Usaha (SITU)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Bukti pembayaran pajak/PBB terbaru
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Keterangan Domisili
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> IMB
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Undang-undang Gangguan (HO)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Hasil Penilaian Asset/Apraisal terbaru
                                                                        </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>    
                                                        </div>         
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- ./ 4 -->
                                            <!-- 5 -->
                                            <div id="layout-modal-kerja" style="display: none;" class="layout-dokumen">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row"> 
                                                            <div class="col-12">
                                                                <h3 class="content-heading text-dark mt-0 pt-0 font-w600" >Kelengkapan Dokumen</h3>
                                                                <p class="text-dark">Dalam mengajukan pendanaan <span class="font-w700"> MODAL KERJA </span> berikut dokumen pendukung yang harus anda miliki, centang jika file tersedia dan
                                                                siap untuk di periksa tim Dana Syariah Indonesia.</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row">
                                                                    <div class="col-12">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input " name="sd">
                                                                            <span class="css-control-indicator"></span> Semua Dokumen Tersedia
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Permohonan Pengajuan Pembiayaan
                                                                            <span class="text-danger">*</span>
                                                                        </label>                                                                        
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> NPWP
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="ktpsim">
                                                                            <span class="css-control-indicator"></span> KTP/SIM/Pasport Suami atau Istri
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="pprk">
                                                                            <span class="css-control-indicator"></span> Past Performance (R/K) 6 bulan terakhir
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="kk">
                                                                            <span class="css-control-indicator"></span> Kartu Keluarga
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Laporan Keuangan/Neraca Laba Rugi 2 tahun terakhir (Audited)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Nikah / Cerai
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Anggaran Biaya (RAB) Proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Kewarganegaraan dan ganti nama untuk WNI Keturunan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana jadwal pembangunan proyek (persiapan s/d akhir)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Curriculum Vitae Pemohon
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Rencana Cash flow/Arus kas proyek
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Usaha Perdagangan (SIUP), Kontraktor (SIUJK)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Feasibility Study
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Tanda Daftar Perusahaan (TDP)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Seritifikat (SHM/SHGB) asset jaminan
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Ijin Tempat Usaha (SITU)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Bukti pembayaran pajak/PBB terbaru
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Surat Keterangan Domisili
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> IMB
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="sppp">
                                                                            <span class="css-control-indicator"></span> Undang-undang Gangguan (HO)
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                            <input type="checkbox" class="css-control-input" name="npwp">
                                                                            <span class="css-control-indicator"></span> Hasil Penilaian Asset/Apraisal terbaru
                                                                        </label>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>    
                                                        </div>         
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- ./ 5 -->
                                            <!-- END Step 3 -->
                                        </div>
                                        <!-- END Steps Content -->

                                        <!-- Steps Navigation -->
                                        <div class="block-content block-content-sm block-content-full bg-body-light">
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-alt-secondary" data-wizard="prev">
                                                        <i class="fa fa-angle-left mr-5"></i> Previous
                                                    </button>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                                                        Next <i class="fa fa-angle-right ml-5"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish">
                                                        <i class="fa fa-check mr-5"></i> Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Steps Navigation -->
                                    </form>
                                    <!-- END Form -->
                                </div>
                                <!-- END Progress Wizard 2 -->                                

                            </div>
                            
                        </div>
                    </div>                           
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
    <script>
        // active layout type untuk borrower
        $(function() {
            $('#type-select').change(function(){
                $('.layout').hide();
                $('#' + $(this).val()).show();
                $( '#layout-x >' + 'div >' + 'div >' + 'div >' + '#' + $(this).val()).show();
            });
        });
        // active layout type dokumen
        $(function() {
            $('#type-pendanaan-select').change(function(){
                $('.layout-dokumen').hide();
                $('#' + $(this).val()).show();
            });
        });
        // start
        // tambah penanggung jawab untuk tipe Badan Hukum
        var tambahPenanggungJawab = '<div class="col-12 mt-3" id="containerPenanggungJawab">'
                                        +'<div class="row">'
                                            +'<div class="col-12">'
                                                +'<h6 class="content-heading text-muted font-w600 mt-0 pt-0" style="font-size: 1em;">Pengurus ke-n</h6>'
                                            +'</div>'
                                            +'<div class="col-md-4">'
                                                +'<div class="form-group">'
                                                    +'<label for="wizard-progress2-namapengurus">Nama Pengurus</label>'
                                                    +'<input class="form-control" type="text" id="wizard-progress2-namapengurus" name="wizard-progress2-namapengurus" placeholder="Masukkan nama pengurus...">'
                                                +'</div>'
                                            +'</div>'
                                            +'<div class="col-md-5">'
                                                +'<div class="form-group">'
                                                    +'<label for="wizard-progress2-nik">NIK</label>'
                                                    +'<input class="form-control" type="text" id="wizard-progress2-namapengurus" name="wizard-progress2-nik" placeholder="Masukkan NIK pengurus...">'
                                                +'</div>'
                                            +'</div>'
                                            +'<div class="col-md-4">'
                                                +'<div class="form-group">'
                                                    +'<label for="wizard-progress2-nomorhp">No Telepon / HP</label>'
                                                    +'<input class="form-control" type="number" id="wizard-progress2-nomorhp" name="wizard-progress2-nomorhp" placeholder="Masukkan nomor telepon">'
                                                +'</div>'
                                            +'</div> '
                                            +'<div class="col-md-5">'
                                                +'<div class="form-group">'
                                                    +'<label for="wizard-progress2-jabatan">Jabatan</label>'
                                                    +'<input class="form-control" type="text" id="wizard-progress2-jabatan" name="wizard-progress2-jabatan" placeholder="Masukkan nomor telepon">'
                                                +'</div>'
                                            +'</div>'  
                                        +'</div>'
                                        +'<button type="button" class="btn btn-rounded btn-danger mb-10 push-right" id="delete_penanggung_jawab"> <i class="fa fa-times"></i>  Hapus Pengurus Ini</button><hr>'
                                    +'</div>';
        function add_penanggung_jawab() {
            $('#tambahPenanggungJawab').append(tambahPenanggungJawab);
        }
        $(document).on("click", "#delete_penanggung_jawab", function() { 
            $(this).parent().remove();
        });
        // end
    </script>
@endsection
    