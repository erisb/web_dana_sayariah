@extends('layouts.borrower.master')
@section('title', 'Welcome Borrower')

@section('content')
    <!-- select2 -->
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div id="detect-screen" class="content-full-right">
            <div class="container">
                <div class="row">
                    <div id="col" class="col-12 col-md-12 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400" style="float: left; margin-block-end: 0em; color: #31394D" >Lengkapi Data</h1>
                            <span class="pull-right">
                            <h6 class=" font-w700" style="float: left; margin-block-end: 0em; color: #31394D" >1 dari 3 Langkah</h6>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-md-12 mt-5 pt-5">
                        <div class="row">
                            
                            <div class="col-12 col-md-12">
                                <!-- Progress Wizard 2 -->
                                <div class="js-wizard-validation-classic block">
                                    <!-- Wizard Progress Bar -->
                                    <div class="progress rounded-0" data-wizard="progress" style="height: 8px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- END Wizard Progress Bar -->

                                    <!-- Step Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#wizard-validation-classic-step1" data-toggle="tab">1. Data Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-validation-classic-step2" data-toggle="tab">2. Informasi Pendanaan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-validation-classic-step3" data-toggle="tab">3. Dokumen Pendukung</a>
                                        </li>
                                    </ul>
                                    <!-- END Step Tabs -->

                                    <!-- Form -->
                                    <!--<form id="form_lengkapi_profile" action="{{route('borrower.action_lengkapi_profile')}}" method="POST">-->
                                    <form id="form_lengkapi_profile" class="js-wizard-validation-classic-form" method="POST"  enctype="multipart/form-data">
                                        <!-- Steps Content -->
										@csrf
                                        <div class="block-content block-content-full tab-content" style="min-height: 274px;">
                                            <!-- Step 1 -->
                                            <div class="tab-pane active" id="wizard-validation-classic-step1" role="tabpanel">
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
                                                            <select class="form-control col-4" style="font-size: 1em" id="type_borrower" name="type_borrower" required>
                                                                <option value="layout-pribadi">Pribadi - Pegawai</option>
                                                                <option value="layout-pribadi">Pribadi - Wirausaha</option>
                                                                <option value="layout-badanhukum">Perusahaan / Badan Hukum</option>
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
                                                                            <label for="wizard-progress2-namapengguna">Nama Pengguna *</label>
                                                                            <input class="form-control checkKarakterAneh" type="text" id="txt_nm_pengguna_pribadi" name="txt_nm_pengguna_pribadi" placeholder="Masukkan Nama Anda..." required>  
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Nama Ibu Kandung *</label>
                                                                            <input class="form-control checkKarakterAneh" type="text" id="txt_nm_ibu_pribadi" name="txt_nm_ibu_pribadi" placeholder="Masukkan Nama Ibu Kandung Anda..." required>  
                                                                        </div> 
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Pendidikan Terakhir *</label>
                                                                        <select class="form-control"  id="txt_pendidikanT_pribadi" name="txt_pendidikanT_pribadi" required>
                                                                        </select>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group" id="divNoKTP">
                                                                        <label for="wizard-progress2-ktp">Nomor Kartu Tanda Penduduk (KTP) *</label>
                                                                        <input class="form-control" type="number" id="txt_no_ktp_pribadi" name="txt_no_ktp_pribadi" placeholder="Masukkan nomor KTP" onkeyup="CheckNik()" required>  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Nomor NPWP *</label>
                                                                        <input class="form-control" type="text" id="txt_npwp_pribadi" name="txt_npwp_pribadi" placeholder="Masukkan nomor NPWP" required>  
                                                                    </div>
                                                                </div>  
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-group" id="div_tlp_pribadi">
                                                                            <label for="wizard-progress2-namapengguna">No HP Anda *</label>
                                                                            <input class="form-control" type="nnumber" id="txt_notlp_pribadi" name="txt_notlp_pribadi" placeholder="Masukkan No TLP Anda..." onkeyup="check_tlp_pribadi()" required>  
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-tempatlahir">Tempat Lahir *</label>
                                                                        <input class="form-control checkKarakterAneh" type="text" id="txt_tmpt_lahir_pribadi" name="txt_tmpt_lahir_pribadi" placeholder="Masukkan tempat lahir" required>  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                    <div class="form-group col-12 col-md-4">
                                                                        <label for="wizard-progress2-npwp">Hari *</label>
                                                                        <select class="form-control" id="txt_hari_pribadi" name="txt_hari_pribadi" required>
                                                                            <option value="">--Pilih--</option>
                                                                            <option value="01">01</option>
                                                                            <option value="02">02</option>
                                                                            <option value="03">03</option>
                                                                            <option value="04">04</option>
                                                                            <option value="05">05</option>
                                                                            <option value="06">06</option>
                                                                            <option value="07">07</option>
                                                                            <option value="08">08</option>
                                                                            <option value="09">09</option>
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
                                                                        <label for="wizard-progress2-npwp">Bulan *</label>
                                                                        <select class="form-control" id="txt_bulan_pribadi" name="txt_bulan_pribadi" required>
                                                                            <option value="">--Pilih--</option>
                                                                            <option value="01">Januari</option>
                                                                            <option value="02">Ferbruari</option>
                                                                            <option value="03">Maret</option>
                                                                            <option value="04">April</option>
                                                                            <option value="05">Mei</option>
                                                                            <option value="06">Juni</option>
                                                                            <option value="07">Juli</option>
                                                                            <option value="08">Agustus</option>
                                                                            <option value="09">September</option>
                                                                            <option value="10">Oktober</option>
                                                                            <option value="11">Nopember</option>
                                                                            <option value="12">Desember</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-12 col-md-4">
                                                                        <label for="wizard-progress2-npwp">Tahun *</label>
                                                                        <select class="form-control" id="txt_tahun_pribadi" name="txt_tahun_pribadi" required></select>
                                                                    </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Jenis Kelamin *</label>
                                                                        <div class="col-12" id="divJenisKelamin">
																			
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Agama *</label>
                                                                        <div class="col-12" id="divAgama">
																			
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Status Perkawinan *</label>
                                                                        <div class="col-12" id="divStsPerkawinan">
																			
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <!-- /// -->
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                            </div>
                                                             <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Ahli Waris</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <div class="form-group">
                                                                                    <label for="wizard-progress2-namapengguna">Nama Ahli Waris *</label>
                                                                                    <input class="form-control checkKarakterAneh" type="text" id="txt_nm_aw_pribadi" name="txt_nm_aw_pribadi" placeholder="Masukkan Nama Anda..." required>  
                                                                                </div> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group" id="divNIK_AW">
                                                                                <label for="wizard-progress2-namapengguna">NIK Ahli Waris *</label>
                                                                                <input class="form-control" type="number" id="txt_nik_aw_pribadi" name="txt_nik_aw_pribadi" placeholder="Masukkan NIK Ahli Waris Anda..." required>  
                                                                                
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <div class="form-group">
                                                                                    <label for="wizard-progress2-namapengguna">No HP Ahli Waris *</label>
                                                                                    <input class="form-control" type="nnumber" id="txt_notlp_aw_pribadi" name="txt_notlp_aw_pribadi" placeholder="Masukkan No TLP Ahli Waris Anda..." required>  
                                                                                </div> 
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <div class="form-group" id="div_txt_email_aw_pribadi">
                                                                                    <label for="wizard-progress2-namapengguna">Email *</label>
                                                                                    <input class="form-control" type="text" id="txt_email_aw_pribadi" name="txt_email_aw_pribadi" placeholder="Masukkan Email Ahli Waris..." onkeyup="check_format_email(this.id, this.value)" required>
                                                                                    <div>
                                                                                        <span id="error_email" style="color:red;font-size:11px"></span>
                                                                                    </div>  
                                                                                </div> 
                                                                            </div>
                                                                        </div>
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <div class="form-group">
                                                                                    <label for="wizard-progress2-namapengguna">Alamat Sesuai KTP *</label>
                                                                                    <input class="form-control" type="text" id="txt_alamat_aw_pribadi" name="txt_alamat_aw_pribadi" placeholder="Masukkan Alamat Ahli Waris..." required>  
                                                                                </div> 
                                                                            </div>
                                                                        </div> 
																		 <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Provinsi *</label>
                                                                                <select class="form-control" id="txt_provinsi_aw_pribadi" name="txt_provinsi_aw_pribadi" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kota *</label>
                                                                                <select class="form-control select2-multiple" id="txt_kota_aw_pribadi" name="txt_kota_aw_pribadi" required></select>
                                                                            </div>
                                                                        </div>
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kecamatan *</label>
                                                                               <input class="form-control" type="text" id="txt_kecamatan_aw_pribadi" name="txt_kecamatan_aw_pribadi" required>  
                                                                            </div>
                                                                        </div>
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kelurahan *</label>
                                                                                <input class="form-control" type="text" id="txt_kelurahan_aw_pribadi" name="txt_kelurahan_aw_pribadi" required>  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kode Pos *</label>
                                                                                <input class="form-control" type="text" id="txt_kode_pos_aw_pribadi" size="5" maxlength="5" name="txt_kode_pos_aw_pribadi" required>  
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Tempat Tinggal Sesuai KTP</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Alamat Sesuai KTP *</label>
                                                                                <textarea class="form-control form-control-lg" id="txt_alamat_pribadi" name="txt_alamat_pribadi" rows="2" placeholder="Masukkan alamat lengkap sesuai KTP Anda.." required></textarea>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Provinsi *</label>
                                                                                <select class="form-control" id="txt_provinsi_pribadi" name="txt_provinsi_pribadi" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kota *</label>
                                                                                <select class="form-control select2-multiple" id="txt_kota_pribadi" name="txt_kota_pribadi" required></select>
                                                                            </div>
                                                                        </div>
																		 <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kecamatan *</label>
                                                                                <input class="form-control" type="text" id="txt_kecamatan_pribadi" name="txt_kecamatan_pribadi" placeholder="Masukkan Kecamatan" required>  
                                                                            </div>
                                                                        </div> 
																		 <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kelurahan *</label>
                                                                                <input class="form-control" type="text" id="txt_kelurahan_pribadi" name="txt_kelurahan_pribadi" placeholder="Masukkan Kelurahan" required>  
                                                                            </div>
                                                                        </div> 
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kode Pos *</label>
                                                                                <input class="form-control" type="number" id="txt_kd_pos_pribadi" name="txt_kd_pos_pribadi" size="5" maxlength="5" placeholder="Masukkan kode Pos" required>  
                                                                            </div>
                                                                        </div>
                                                                        <!-- satuBaris --> 
                                                                        
																		
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="col-12">Status Kepemilikan Rumah *</label>
                                                                                <div class="col-12">
                                                                                    <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                        <input type="radio" class="css-control-input" id="txt_sts_rmh_pribadi" name="txt_sts_rmh_pribadi" value="1" required>
                                                                                        <span class="css-control-indicator"></span> Milik Pribadi
                                                                                    </label>
                                                                                    <label class="css-control css-control-primary css-radio text-dark">
                                                                                        <input type="radio" class="css-control-input" id="txt_sts_rmh_pribadi" name="txt_sts_rmh_pribadi" value="2" required>
                                                                                        <span class="css-control-indicator"></span> Sewa / Kontrak
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
															
															 <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Domisili Berbeda Dengan KTP <input type="checkbox" id="hide_domisili_pribadi"></h6>
                                                            <div class="row" id="div_hide_domisili">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Alamat Sesuai Domisili</label>
                                                                                <textarea class="form-control form-control-lg" id="txt_alamat_domisili_pribadi" name="txt_alamat_domisili_pribadi" rows="2" placeholder="Masukkan alamat lengkap sesuai domisili Anda.."></textarea>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Provinsi</label>
                                                                                <select class="form-control" id="txt_provinsi_domisili_pribadi" name="txt_provinsi_domisili_pribadi"></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kota</label>
                                                                                <select class="form-control select2-multiple" id="txt_kota_domisili_pribadi" name="txt_kota_domisili_pribadi"></select>
                                                                            </div>
                                                                        </div>
																		 <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kecamatan</label>
                                                                                <input class="form-control" type="text" id="txt_kecamatan_domisili_pribadi" name="txt_kecamatan_domisili_pribadi" placeholder="Masukkan Kecamatan">  
                                                                            </div>
                                                                        </div> 
																		 <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kelurahan</label>
                                                                                <input class="form-control" type="text" id="txt_kelurahan_domisili_pribadi" name="txt_kelurahan_domisili_pribadi" placeholder="Masukkan Kelurahan">  
                                                                            </div>
                                                                        </div> 
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kode Pos</label>
                                                                                <input class="form-control" type="number" id="txt_kd_pos_domisili_pribadi" size="5" maxlength="5" name="txt_kd_pos_domisili_pribadi" placeholder="Masukkan kode Pos">  
                                                                            </div>
                                                                        </div>
                                                                        <!-- satuBaris -->
                                                                    </div>
                                                                </div>
                                                            </div>
															
															<!-- baris pemisah -->
															<h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Foto Diri & KTP</h6>
                                                            <div class="row">
                                                                <div class="col-md-12" id="div_foto">
																	<div class="row">
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto Anda *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_diri">
																						<input type="file" class="custom-file-input" id="pic_brw" name="pic_brw" required>
                                                                                        <label class="custom-file-label" id="txt_filename_pribadi" for="example-file-input-custom">Choose file</label>
                                                                                        <input type="hidden" name="url_pic_brw" id="url_pic_brw">
                                                                                    </div><br/><br/-->
                                                                                    <div id="take_camera_foto_diri">
                                                                                        <label class="btn btn-success col-md-11"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_fotodiri">
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/user-guide.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 180px; top: 22px;">
                                                                                        <div id="camera_foto" style="z-index:-1 !important; margin-top: 70px;"></div>
                                                                                        <button class="btn btn-success col-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" onClick="take_snapshot_foto_diri()">Ambil Foto</button>
                                                                                        <input type="hidden" name="image_foto_diri" id="image_foto_diri" class="image-tag"><br/>
                                                                                        <input type="hidden" name="url_pic_brw" id="url_pic_brw">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_diri"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto KTP Anda *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_ktp">
                                                                                        <input type="file" class="custom-file-input" id="pic_brw_ktp" name="pic_brw_ktp" required>
                                                                                        <input type="hidden" name="url_pic_brw_ktp" id="url_pic_brw_ktp">
                                                                                        <label class="custom-file-label" id="txt_filename_ktp_pribadi" for="example-file-input-custom">Choose file</label>
                                                                                    </div><br/><br/-->
                                                                                    <div id="take_camera_foto_ktp">
                                                                                        <label class="btn btn-success col-md-11"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_fotoktp">
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                                        <div id="camera_ktp" style="z-index:-1 !important; margin-top: 70px;"></div>
                                                                                        <button class="btn btn-success col-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" onClick="take_snapshot_foto_ktp()">Ambil Foto</button>
                                                                                        <input type="hidden" name="image_foto_ktp" id="image_foto_ktp" class="image-tag"><br/>
                                                                                        <input type="hidden" name="url_pic_brw_ktp" id="url_pic_brw_ktp">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_ktp"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto Anda Dengan KTP *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_ktpdiri">
                                                                                        <input type="file" class="custom-file-input" id="pic_brw_dengan_ktp" name="pic_brw_dengan_ktp" data-toggle="pic_brw_dengan_ktp" required>
                                                                                        <input type="hidden" name="url_pic_brw_dengan_ktp" id="url_pic_brw_dengan_ktp">
                                                                                        <label class="custom-file-label" id="txt_filename_brw_ktp_pribadi" for="example-file-input-custom">Choose file</label>
                                                                                    </div><br/><br/-->
                                                                                    <div id="take_camera_foto_ktpdiri">
                                                                                        <label class="btn btn-success col-11"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_foto_ktpdiri">
                                                                                        <div id="camera_ktpdiri" style="z-index:-1 !important; margin-top: -30px;"></div>
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/guide-diridanktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                                        <button class="btn btn-success col-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" onClick="take_snapshot_foto_ktpdiri()">Ambil Foto</button>
                                                                                        <input type="hidden" name="image_foto_ktp_diri" id="image_foto_ktp_diri" class="image-tag"><br/>
                                                                                        <input type="hidden" name="url_pic_brw_dengan_ktp" id="url_pic_brw_dengan_ktp">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_ktp_diri"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto NPWP Anda *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_npwp">
                                                                                        <input type="file" class="custom-file-input" id="pic_brw_npwp" name="pic_brw_npwp" data-toggle="pic_brw_npwp" required>
                                                                                        <input type="hidden" name="url_pic_brw_npwp" id="url_pic_brw_npwp">
                                                                                        <label class="custom-file-label" id="txt_filename_npwp_pribadi" for="example-file-input-custom">Choose file</label>
                                                                                    </div><br/><br/-->
                                                                                    <div id="take_camera_foto_npwp">
                                                                                        <label class="btn btn-success col-md-11"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_foto_npwp">
                                                                                        <div id="camera_npwp" style="z-index:-1 !important; margin-top: -30px;"></div>
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                                        <button class="btn btn-success col-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" onClick="take_snapshot_foto_npwp()">Ambil Foto</button>
                                                                                        <input type="hidden" name="image_foto_npwp" id="image_foto_npwp" class="image-tag"><br/>
                                                                                        <input type="hidden" name="url_pic_brw_npwp" id="url_pic_brw_npwp">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_npwp"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
																	</div>
                                                                </div>
                                                            </div>
															
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Bank</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Nama Pemilik Rekening *</label>
                                                                                <input class="form-control checkKarakterAneh" type="text" id="txt_nm_pemilik" name="txt_nm_pemilik" placeholder="Masukkan Nama Pemilik Rekening..." required>  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">No Rekening *</label>
                                                                                <input class="form-control" type="text" id="txt_no_rekening" name="txt_no_rekening" placeholder="Masukkan No Rekening..." required>  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bank *</label>
                                                                                <select class="form-control" id="txt_bank" name="txt_bank" required></select>
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris -->  
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
                                                                                <label for="wizard-progress2-kota">Pekerjaan *</label>
                                                                                <select class="form-control" id="txt_pekerjaan_pribadi" name="txt_pekerjaan_pribadi" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan *</label>
                                                                                <select class="form-control" id="txt_bd_pekerjaan_pribadi" name="txt_bd_pekerjaan_pribadi" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan Online *</label>
                                                                                <select class="form-control" id="txt_bd_pekerjaanO_pribadi" name="txt_bd_pekerjaanO_pribadi" required></select>
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris -->  
                                                                    </div>
                                                                    <div class="row mb-20">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Pengalaman Kerja *</label>
                                                                                <select class="form-control" id="txt_pengalaman_kerja_pribadi" name="txt_pengalaman_kerja_pribadi" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Pendapatan Bulanan *</label>
                                                                                <select class="form-control" id="txt_pendapatan_bulanan_pribadi" name="txt_pendapatan_bulanan_pribadi" required></select>
                                                                            </div>
                                                                        </div> 
                                                                        <!-- satuBaris -->  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

















                                                <!--------------------------------------------------------------- Badan Hukum ----------------------------------------------->
                                                <div id="layout-badanhukum" class="layout" style="display: none">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namabadanhukum">Nama Badan Hukum *</label>
                                                                            <input class="form-control checkKarakterAneh" type="text" id="txt_nm_bdn_hukum" name="txt_nm_bdn_hukum" placeholder="Masukkan Nama Perusahaan anda..." required>  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Nomor NPWP *</label>
                                                                        <input class="form-control" type="number" id="txt_npwp_bdn_hukum" name="txt_npwp_bdn_hukum" placeholder="Masukkan Nomor NPWP" required>  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Nama Anda *</label>
                                                                        <input class="form-control checkKarakterAneh" type="text" id="txt_nm_anda_bdn_hukum" name="txt_nm_anda_bdn_hukum" placeholder="Masukkan Nama Anda" required>  
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group" id="divNIKBH">
                                                                        <label for="wizard-progress2-namabadanhukum">NIK *</label>
                                                                        <input class="form-control" type="number" id="txt_nik_anda_bdn_hukum" name="txt_nik_anda_bdn_hukum" placeholder="Masukkan NIK anda..." onkeyup="check_nik_badan_hukum()" required>  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" id="div_tlp_bdn_hukum"> 
                                                                        <label for="wizard-progress2-npwp">No HP Anda *</label>
                                                                        <input class="form-control" type="text" id="txt_notlp_anda_bdn_hukum" name="txt_notlp_anda_bdn_hukum" placeholder="Masukkan No TLP/HP Anda" onkeyup="check_tlp_bdn_hukum()" required>  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Jabatan *</label>
                                                                        <input class="form-control checkKarakterAneh" type="text" id="txt_jabatan_anda_bdn_hukum" name="txt_jabatan_anda_bdn_hukum" placeholder="Masukkan Jabatan Anda" required>  
                                                                    </div>
                                                                </div>   
                                                                <!-- satuBaris --> 
                                                                
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Pengurus</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-12" id="containerPenanggungJawab">
                                                                            <div class="row" id="tambahPenanggungJawab">
                                                                                <!-- satuBaris -->

                                                                                <div class="col-12">
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <h6 class="content-heading text-muted font-w600 mt-0 pt-0" style="font-size: 1em;">Pengurus 1</h6>                                                                                            
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-namapengurus">Nama Pengurus *</label>
                                                                                                <input class="form-control checkKarakterAneh" type="text" id="txt_nm_pengurus_bdn_hukum" name="txt_nm_pengurus_bdn_hukum" placeholder="Masukkan nama pengurus..." required>  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">NIK Pengurus</label>
                                                                                                <input class="form-control" type="number" id="txt_nik_pengurus_bdn_hukum" name="txt_nik_pengurus_bdn_hukum" placeholder="Masukkan NIK pengurus..." required>  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nomorhp">No Telepon / HP</label>
                                                                                                <input class="form-control" type="number" id="txt_notlp_pengurus_bdn_hukum" name="txt_notlp_pengurus_bdn_hukum" placeholder="Masukkan nomor telepon" required>  
                                                                                            </div>
                                                                                        </div> 
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-jabatan">Jabatan *</label>
                                                                                                <input class="form-control checkKarakterAneh" type="text" id="txt_jabatan_pengurus_bdn_hukum" name="txt_jabatan_pengurus_bdn_hukum" placeholder="Masukkan nomor telepon" required>  
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
															<h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Foto Diri & KTP</h6>
                                                            <div class="row">
                                                                <div class="col-md-12" id="div_foto_bdn_hukum">
																	<div class="row">
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto Anda *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_diri_hukum">
                                                                                        <input type="file" class="custom-file-input" id="pic_brw_bdn_hukum" name="pic_brw_bdn_hukum" data-toggle="pic_brw_bdn_hukum" required>
                                                                                        <input type="hidden" id="url_pic_brw_bdn_hukum" name="url_pic_brw_bdn_hukum">
                                                                                        <label class="custom-file-label" id="txt_filename_bdn_hukum" for="example-file-input-custom">Choose file</label>
                                                                                    </div><br/><br/-->
                                                                                    <div id="take_camera_foto_diri_hukum">
                                                                                        <label class="btn btn-success col-md-11"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_fotodiri_hukum">
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/user-guide.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 180px; top: 22px;">
                                                                                        <div id="camera_foto_hukum" style="z-index:-1 !important; margin-top: 70px;"></div>
                                                                                        <input class="btn btn-success col-md-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" value="Ambil Foto" onClick="take_snapshot_foto_diri_hukum()">
                                                                                        <input type="hidden" name="image_foto_diri_hukum" id="image_foto_diri_hukum" class="image-tag"><br/>
                                                                                        <input type="hidden" id="url_pic_brw_bdn_hukum" name="url_pic_brw_bdn_hukum">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_diri_hukum"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto KTP Anda *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_ktp_hukum">
                                                                                        <input type="file" class="custom-file-input" id="pic_brw_ktp_bdn_hukum" name="pic_brw_ktp_bdn_hukum" data-toggle="pic_brw_ktp" required>
                                                                                        <input type="hidden" id="url_pic_brw_ktp_bdn_hukum" name="url_pic_brw_ktp_bdn_hukum">
                                                                                        <label class="custom-file-label" id="txt_filename_ktp_bdn_hukum" for="example-file-input-custom">Choose file</label>
                                                                                    </div><br/><br/-->
                                                                                    <div id="take_camera_foto_ktp_hukum">
                                                                                        <label class="btn btn-success col-md-12"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_fotoktp_hukum">
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                                        <div id="camera_ktp_hukum" style="z-index:-1 !important; margin-top: 70px;"></div>
                                                                                        <input class="btn btn-success col-md-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_hukum()">
                                                                                        <input type="hidden" name="image_foto_ktp_hukum" id="image_foto_ktp_hukum" class="image-tag"><br/>
                                                                                        <input type="hidden" id="url_pic_brw_ktp_bdn_hukum" name="url_pic_brw_ktp_bdn_hukum">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_ktp_hukum"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto Anda Dengan KTP *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_ktpdiri_hukum">
                                                                                        <input type="file" class="custom-file-input" id="pic_brw_dengan_ktp_bdn_hukum" name="pic_brw_dengan_ktp_bdn_hukum" data-toggle="pic_brw_dengan_ktp_bdn_hukum" required>
                                                                                        <input type="hidden" id="url_pic_brw_dengan_ktp_bdn_hukum" name="url_pic_brw_dengan_ktp_bdn_hukum">
                                                                                        <label class="custom-file-label" id="txt_filename_brw_ktp_bdn_hukum" for="example-file-input-custom">Choose file</label>
                                                                                    </div>
                                                                                    <br/><br/-->
                                                                                    <div id="take_camera_foto_ktpdiri_hukum">
                                                                                        <label class="btn btn-success col-md-12"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_foto_ktpdiri_hukum">
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/guide-diridanktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                                        <div id="camera_ktpdiri_hukum" style="z-index:-1 !important; margin-top: -30px;"></div>
                                                                                        <input class="btn btn-success col-md-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktpdiri_hukum()">
                                                                                        <input type="hidden" name="image_foto_ktp_diri" id="image_foto_ktp_diri_hukum" class="image-tag"><br/>
                                                                                        <input type="hidden" id="url_pic_brw_dengan_ktp_bdn_hukum" name="url_pic_brw_dengan_ktp_bdn_hukum">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_ktp_diri_hukum"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                                <label class="col-12">Foto NPWP *</label>
                                                                                <div class="col-12">
                                                                                    <!--div class="custom-file" id="base_foto_npwp_hukum">
                                                                                        <input type="file" class="custom-file-input" id="pic_brw_npwp_bdn_hukum" name="pic_brw_npwp_bdn_hukum" data-toggle="pic_brw_npwp_bdn_hukum" required>
                                                                                        <input type="hidden" id="url_pic_brw_npwp_bdn_hukum" name="url_pic_brw_npwp_bdn_hukum">
                                                                                        <label class="custom-file-label" id="txt_filename_npwp_bdn_hukum" for="example-file-input-custom">Choose file</label>
                                                                                    </div><br/><br/-->
                                                                                    <div id="take_camera_foto_npwp_hukum">
                                                                                        <label class="btn btn-success col-md-12"><i class="fa fa-camera"> Kamera</i></label>
                                                                                    </div>
                                                                                    <div class="col-md-12" id="webcam_foto_npwp_hukum">
                                                                                        <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                                        <div id="camera_npwp_hukum" style="z-index:-1 !important; margin-top: -30px;"></div>
                                                                                        <input class="btn btn-success col-md-12" style="margin-top:20px ; margin-bottom: 20px; z-index:2 !important; position:relative;" type="button" value="Ambil Foto" onClick="take_snapshot_foto_npwp_hukum()">
                                                                                        <input type="hidden" name="image_foto_npwp" id="image_foto_npwp_hukum" class="image-tag"><br/>
                                                                                        <input type="hidden" id="url_pic_brw_npwp_bdn_hukum" name="url_pic_brw_npwp_bdn_hukum">
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <label class="font-weight-bold" style="margin-left:0">Hasil</label>
                                                                                        <div id="results_foto_npwp_hukum"></div>
                                                                                    </div><br/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
																	</div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
															<h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Bank</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Nama Pemilik Rekening *</label>
                                                                                <input class="form-control" type="text" id="txt_nm_pemilik_rekening_bdn_hukum" name="txt_nm_pemilik_rekening_bdn_hukum" placeholder="Masukkan Nama Pemilik Rekening..." required>  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">No Rekening *</label>
                                                                                <input class="form-control" type="text" id="txt_no_rekening_bdn_hukum" name="txt_no_rekening_bdn_hukum" placeholder="Masukkan No Rekening..." required>  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bank *</label>
                                                                                <select class="form-control" id="txt_bank_bdn_hukum" name="txt_bank_bdn_hukum" required></select>
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris -->  
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Lokasi Kantor</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
																		 <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Alamat Lengkap *</label>
                                                                                <textarea class="form-control form-control-lg" id="txt_alamat_bdn_hukum" name="txt_alamat_bdn_hukum" rows="2" placeholder="Masukkan alamat lengkap Anda.." required></textarea>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-provinsi">Provinsi *</label>
                                                                                <br/>
                                                                                <select class="form-control" id="txt_provinsi_bdn_hukum" name="txt_provinsi_bdn_hukum" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kota *</label>
                                                                                <select class="form-control" id="txt_kota_bdn_hukum" name="txt_kota_bdn_hukum" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kecamatan *</label>
                                                                                <input class="form-control" type="text" id="txt_kecamatan_bdn_hukum" name="txt_kecamatan_bdn_hukum" placeholder="Masukkan Kecamatan" required>  
                                                                            </div>
                                                                        </div>
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kelurahan *</label>
                                                                                <input class="form-control" type="text" id="txt_kelurahan_bdn_hukum" name="txt_kelurahan_bdn_hukum" placeholder="Masukkan Kelurahan Pos" required>  
                                                                            </div>
                                                                        </div>
																		<div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Kode Pos *</label>
                                                                                <input class="form-control" type="number" id="txt_kd_pos_bdn_hukum" size="5" maxlength="5" name="txt_kd_pos_bdn_hukum" placeholder="Masukkan kode Pos" required>  
                                                                            </div>
                                                                        </div>																		
                                                                        <!-- satuBaris --> 
                                                                       
                                                                        
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
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan *</label>
                                                                                <br/>
                                                                                <select class="form-control js-example-basic-basic" id="txt_bd_pekerjaan_bdn_hukum" name="txt_bd_pekerjaan_bdn_hukum" required></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan Online *</label>
																				<select class="form-control" id="txt_bpo_bdn_hukum" name="txt_bpo_bdn_hukum" required></select>
                                                                            </div>
                                                                        </div>  
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-revenue">Revenue Bulanan *</label>
                                                                                <br/>
																				<select class="form-control js-example-basic-basic" id="txt_revenueB_bdn_hukum" name="txt_revenueB_bdn_hukum" required></select>
                                                                                <!--<input class="form-control" type="number" id="" name="txt_revenueB_bdn_hukum" placeholder="Masukkan Revenue bulanan">-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-aset">Total Aset *</label>
                                                                                <input class="form-control" type="number" id="txt_asset_bdn_hukum" name="txt_asset_bdn_hukum" placeholder="Masukkan Total aset" required>  
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
                                            <div class="tab-pane" id="wizard-validation-classic-step2" role="tabpanel">
                                                <div id="layout-x">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div id="layout-pribadi" class="layout col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Tipe Pendanaan (Pribadi) *</label>
                                                                            <select class="form-control" id="type_pendanaan_select" name="type_pendanaan_select" required></select>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div id="layout-badanhukum" class="layout col-md-3" style="display: none;">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Tipe Pendanaan (Badan Hukum) *</label>
                                                                            <select class="form-control" id="type_pendanaan_select_bdn_hukum" name="type_pendanaan_select_bdn_hukum" required></select>
                                                                        </div> 
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-namapendanaan">Nama Pendanaan *</label>
                                                                        <input class="form-control allowCharacter" type="text" id="txt_nm_pendanaan" name="txt_nm_pendanaan" placeholder="Masukkan nama pendanaan" required>  
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Akad *</label>
                                                                        <select class="form-control" id="txt_jenis_akad_pendanaan" name="txt_jenis_akad_pendanaan" required>
                                                                            <option value="1">Murabahah</option>
                                                                            <option value="2">Mudarabah</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group" id="div_dana_dibutuhkan">
                                                                        <label for="wizard-progress2-tempatlahir">Dana Dibutuhkan (RP) *</label>
                                                                        <input class="form-control" type="number" id="txt_dana_pendanaan" name="txt_dana_pendanaan" onkeyup="check_dana_dibutuhkan()" placeholder="Masukkan dana yang anda butuhkan..." required>  
                                                                    </div>
                                                                </div>
                                                                 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Estimasi Mulai Proyek *</label>
                                                                        <input type="text" class="js-flatpickr form-control bg-white allowCharacterdate" data-date-format="d-m-Y" data-min-date="01.01.2020" id="txt_estimasi_proyek" name="txt_estimasi_proyek" placeholder="dd-mm-YYYY" data-allow-input="true" required>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group pb-0 mb-0">
                                                                        <label for="wizard-progress2-ktp">Durasi Proyek/Tenor *</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <input class="form-control" type="text" id="txt_durasi_pendanaan" name="txt_durasi_pendanaan" placeholder="Estimasi Bulan" required>  
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text input-group-text-dsi"> Bulan
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Mode Pembayaran *</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_pembayaran_pendanaan" name="txt_pembayaran_pendanaan" value="1" required>
                                                                                <span class="css-control-indicator"></span> Cicilan Bulanan
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_pembayaran_pendanaan" name="txt_pembayaran_pendanaan" value="2" required>
                                                                                <span class="css-control-indicator"></span> Pelunasan di Akhir
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Metode Pembayaran *</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_metode_pembayaran_pendanaan" name="txt_metode_pembayaran_pendanaan" value="1" required>
                                                                                <span class="css-control-indicator"></span> FULL
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_metode_pembayaran_pendanaan" name="txt_metode_pembayaran_pendanaan" value="2" required>
                                                                                <span class="css-control-indicator"></span> Parsial
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                            <!-- baris pemisah jaminan -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Jaminan Pendanaan</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-12 " >
                                                                            <div class="row" id="tambahJaminan">
                                                                                <!-- satuBaris -->

                                                                                <div class="col-12 ">
                                                                                    <div class="row ">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-namapengurus">Nama Jaminan *</label>
                                                                                                <input class="form-control allowCharacter" type="text"  name="txt_nm_jaminan_pendanaan[]" placeholder="Nama Jaminan Pendanaan..." required>  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Nomor Jaminan *</label>
                                                                                                <input class="form-control allowCharacter" type="text" id="txt_nomor_jaminan_pendanaan" name="txt_nomor_jaminan_pendanaan[]" placeholder="Nomor Jaminan Pendanaan..." required> 
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Jenis Jaminan *</label>
                                                                                                <select class="form-control jenisjaminan" id="txt_jenis_jaminan_pendanaan" name="txt_jenis_jaminan_pendanaan[]" required></select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row ">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Nilai Jaminan (Rp) *</label>
                                                                                                <input class="form-control" min="1" max="10000000000" type="number" id="txt_nilai_jaminan_pendanaan" name="txt_nilai_jaminan_pendanaan[]" placeholder="Nilai Jaminan Pendanaan..." required> 
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-8">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Detail Jaminan *</label>
                                                                                                <textarea class="form-control detailjaminan allowCharacter" rows="4" cols="80" id="txt_detail_jaminan_pendanaan" name="txt_detail_jaminan_pendanaan[]" required></textarea>
                                                                                                <!-- <input class="form-control" type="text" id="txt_detail_jaminan_pendanaan" name="txt_detail_jaminan_pendanaan[]" placeholder="Nilai Jaminan Pendanaan...">  -->
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                 
                                                                            </div>
                                                                        </div>
                                                                        <!-- new row -->
                                                                        <div class="col-12">
                                                                            <button type="button" class="btn btn-rounded btn-primary btn-dsi min-width-200 mb-10 push-right" onclick="add_jaminan()">Tambah Jaminan</button>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Detail Pendanaan</h6>        
                                                            <div class="form-group row">
                                                                <div class="col-12">
                                                                    <textarea id="txt_detail_pendanaan" rows="4" cols="50" class="form-control" name="txt_detail_pendanaan"></textarea>
                                                                </div>
                                                            </div> 
                                                            <!-- baris pemisah -->
                                                            <!--
															<h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Media Gallery</h6>
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-12">Pilih Gambar</label>
                                                                <div class="col-8">
                                                                <select class="form-control" id="txt_jenis_akad_pendanaanss" name="txt_jenis_akad_pendanaanss">
                                                                    <option value="0">Pilih Jenis Akad</option>
                                                                    <option value="1">Muarabahah - Jual Beli</option>
                                                                    <option value="1">Mura - X Beli</option>
                                                                </select>
                                                                </div>
                                                            </div> 
															-->
                                                             
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Step 2 -->

                                            <!-- Step 3 -->
                                            <div class="tab-pane" id="wizard-validation-classic-step3" role="tabpanel">
												<!-- 1 -->
												<div class="layout-dokumen">
													<div class="row">
														<div class="col-md-12">
															<div class="row"> 
																<div class="col-12">
																	<h3 class="content-heading text-dark mt-0 pt-0 font-w600" >Kelengkapan Dokumen</h3>
																	<p>Dalam mengajukan pendanaan <span class="font-w700" id="txt_judul_pendanaan"> </span> berikut dokumen pendukung yang harus anda miliki, centang jika file tersedia dan
																	siap untuk di periksa tim Dana Syariah Indonesia.</p>
																</div>
																<div class="col-md-12">
																	
																	<div class="form-group row" id="checklist_persyaratan">
																		
																	</div>
																	<label><b>Tanda</b></label> <label style="color:red"> * </label> <label><b>Dokumen harus ada</b></label>
																</div>         
															</div>
														</div>
													</div>
												<!-- ./ 1 -->
												</div>
											<!-- END Steps Content -->
											</div>
										</div>
										<!-- Steps Navigation -->
										<div class="block-content block-content-sm block-content-full bg-body-light">
											<div class="row">
												<div class="col-6">
													<button type="button" class="btn btn-alt-secondary" data-wizard="prev">
														<i class="fa fa-angle-left mr-5"></i> Previous
													</button>
												</div>
												<div class="col-6 text-right">
													<button type="button" id="next" class="btn btn-alt-secondary" data-wizard="next">
														Next <i class="fa fa-angle-right ml-5"></i>
													</button>
													<button type="button" id="btn_lengkapi_profile" class="btn btn-alt-primary d-none" data-wizard="finish">
														<i class="fa fa-check mr-5"></i> Submit
													</button>
												</div>
											</div>
										</div>
                                        <!-- END Steps Navigation -->
                                    </form>
                                    <!-- END Form -->
                                <!-- END Progress Wizard 2 -->   
								</div>
							</div>                           
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
	<!-- Pop In Modal -->
        <div class="modal fade" id="modal_action_lengkapi_profile" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Proses Lengkapi Profile</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <p>Anda Yakin Ingin Memprosesnya ?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btn_proses_lengkapi_profile" class="btn btn-alt-success" data-dismiss="modal" data-toggle="modal" data-target="#otp">Proses</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Pop In Modal -->
    {{-- modal OTP --}}
      <div class="modal fade" id="otp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header mb-3">
                      <h5 class="modal-title" id="scrollmodalLabel">Verifikasi</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="alert alert-success col-sm-12" id="alertError" style="display: none;">
                  </div>
                  <div class="modal-body">
                      <form id="form_otp">
                      @csrf
                      <div class="form-group row ml-1">
                          <label class="col-sm-3 col-form-label">No HP</label>
                          <div class="col-sm-9">
                          <input type="text" class="form-control col-sm-10" value="" name="no_hp" id="no_hp" disabled>
                          </div>
                      </div>
                      <div class="form-group row ml-1">
                          <label class="col-sm-3 col-form-label">Kode OTP</label>
                          <div class="col-sm-9">
                          <input type="text" class="form-control col-sm-6" value="" name="kode_otp" id="kode_otp">
                          </div>
                      </div>
                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-info" id="kirim_lagi">Kirim Lagi <span id="count"></span></button>
                      <button type="button" class="btn btn-success" id="kirim_data" disabled>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end modal OTP --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> -->
    <style>
       .image--cover {
            width: 200px;
            height: 200px;
            /* border-radius: 5%; */
            /* object-fit: cover; */
            /* object-position: center right; */
            }
    </style>
    <script language="JavaScript">

    $(document).ready(function(){
        $("#webcam_fotodiri").hide();
        $("#take_camera_foto_diri").click(function(){
            $("#webcam_fotodiri").fadeIn();
            $("#base_foto_diri").hide();
            $("#take_camera_foto_diri").hide();
            $("#results_foto_diri").show();
            $("#webcam_fotodiri").css( { "margin-top" : "-100px"} );
        });
    });

    $(document).ready(function(){
        $("#base_upload_fotodiri").click(function(){
            $("#webcam_fotodiri").hide();
            $("#base_foto_diri").fadeIn();
            $("#take_camera_foto_diri").fadeIn();
            $("#results_foto_diri").hide();
            
        });
    });

    $(document).ready(function(){
        $("#webcam_fotoktp").hide();
        $("#take_camera_foto_ktp").click(function(){
            $("#webcam_fotoktp").fadeIn();
            $("#base_foto_ktp").hide();
            $("#take_camera_foto_ktp").hide();
            $("#results_foto_ktp").show();
            $("#webcam_fotoktp").css( { "margin-top" : "-100px"} );
        });
    });

    $(document).ready(function(){
        $("#base_upload_foto_ktp").click(function(){
            $("#webcam_fotoktp").hide();
            $("#base_foto_ktp").fadeIn();
            $("#results_foto_ktp").hide();
            $("#take_camera_foto_ktp").fadeIn();
        });
    });

    $(document).ready(function(){
        $("#webcam_foto_ktpdiri").hide();
        $("#take_camera_foto_ktpdiri").click(function(){
            $("#webcam_foto_ktpdiri").fadeIn();
            $("#base_foto_ktpdiri").hide();
            $("#take_camera_foto_ktpdiri").hide();
            $("#results_foto_ktp_diri").show();
            $("#webcam_foto_ktpdiri").css( { "margin-top" : "-100px;"} );
        });
    });

    $(document).ready(function(){
        $("#base_upload_foto_ktpdiri").click(function(){
            $("#webcam_foto_ktpdiri").hide();
            $("#base_foto_ktpdiri").fadeIn();
            $("#take_camera_foto_ktpdiri").fadeIn();
            $("#results_foto_ktp_diri").hide();
        });
    });

    $(document).ready(function(){
        $("#webcam_foto_npwp").hide();
        $("#take_camera_foto_npwp").click(function(){
            $("#webcam_foto_npwp").fadeIn();
            $("#base_foto_npwp").hide();
            $("#take_camera_foto_npwp").hide();
            $("#results_foto_npwp").show();
            $("#webcam_foto_npwp").css( { "position" : "-100px;"} );
        });
    });

    $(document).ready(function(){
        $("#base_upload_foto_npwp").click(function(){
            $("#webcam_foto_npwp").hide();
            $("#base_foto_npwp").fadeIn();
            $("#take_camera_foto_npwp").fadeIn();
            $("#results_foto_npwp").hide();
        });
    });

    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpg',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_foto' );

        function take_snapshot_foto_diri()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_diri').value = data_uri;
                document.getElementById('results_foto_diri').innerHTML = '<img class="image--cover" src="'+data_uri+'" style="width:200px;height:160px;"/>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var foto = data_uri;
                $.ajax({

                    url : "/borrower/webcam_1",
                    method : "POST",
                    dataType: 'JSON',
                    data: foto,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );
        }
    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpg',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_ktp' );

        function take_snapshot_foto_ktp()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_ktp').value = data_uri;
                document.getElementById('results_foto_ktp').innerHTML = '<img  class="image--cover" src="'+data_uri+'" style="width:200px;height:160px;"/>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp = data_uri;
                $.ajax({

                    url : "/borrower/webcam_2",
                    method : "POST",
                    dataType: 'JSON',
                    data: ktp,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw_ktp').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );
        }
    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpg',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_ktpdiri' );

        function take_snapshot_foto_ktpdiri()
        {
            
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_ktp_diri').value = data_uri;
                document.getElementById('results_foto_ktp_diri').innerHTML = '<img class="image--cover" src="'+data_uri+'" style="width:200px;height:160px;"/>';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp_diri = data_uri;
                $.ajax({

                    url : "/borrower/webcam_3",
                    method : "POST",
                    dataType: 'JSON',
                    data: ktp_diri,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw_dengan_ktp').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );

        }
    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpg',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_npwp' );

        function take_snapshot_foto_npwp()
        {
            
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_npwp').value = data_uri;
                document.getElementById('results_foto_npwp').innerHTML = '<img class="image--cover" src="'+data_uri+'" style="width:200px;height:160px;"/>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var npwp = data_uri;
                $.ajax({

                    url : "/borrower/webcam_4",
                    method : "POST",
                    dataType: 'JSON',
                    data: npwp,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw_npwp').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );
        }
    </script>
    
    <script language="JavaScript">
        $(document).ready(function(){
            $("#webcam_fotodiri_hukum").hide();
            $("#take_camera_foto_diri_hukum").click(function(){
                $("#webcam_fotodiri_hukum").fadeIn();
                $("#base_foto_diri_hukum").hide();
                $("#take_camera_foto_diri_hukum").hide();
                $("#results_foto_diri_hukum").show();
                $("#webcam_fotodiri_hukum").css( { "margin-top" : "-100px"} );
            });
        });

        $(document).ready(function(){
            $("#base_upload_fotodiri_hukum").click(function(){
                $("#webcam_fotodiri_hukum").hide();
                $("#base_foto_diri_hukum").fadeIn();
                $("#take_camera_foto_diri_hukum").fadeIn();
                $("#results_foto_diri_hukum").hide();
                
            });
        });

        $(document).ready(function(){
            $("#webcam_fotoktp_hukum").hide();
            $("#take_camera_foto_ktp_hukum").click(function(){
                $("#webcam_fotoktp_hukum").fadeIn();
                $("#base_foto_ktp_hukum").hide();
                $("#take_camera_foto_ktp_hukum").hide();
                $("#results_foto_ktp_hukum").show();
                $("#webcam_fotoktp_hukum").css( { "margin-top" : "-100px"} );
            });
        });

        $(document).ready(function(){
            $("#base_upload_foto_ktp_hukum").click(function(){
                $("#webcam_fotoktp_hukum").hide();
                $("#base_foto_ktp_hukum").fadeIn();
                $("#take_camera_foto_ktp_hukum").fadeIn();
            });
        });

        $(document).ready(function(){
            $("#webcam_foto_ktpdiri_hukum").hide();
            $("#take_camera_foto_ktpdiri_hukum").click(function(){
                $("#webcam_foto_ktpdiri_hukum").fadeIn();
                $("#base_foto_ktpdiri_hukum").hide();
                $("#take_camera_foto_ktpdiri_hukum").hide();
                $("#results_foto_ktp_diri_hukum").show();
                $("#webcam_foto_ktpdiri_hukum").css( { "margin-top" : "-100px;"} );
            });
        });

        $(document).ready(function(){
            $("#base_upload_foto_ktpdiri_hukum").click(function(){
                $("#webcam_foto_ktpdiri_hukum").hide();
                $("#base_foto_ktpdiri_hukum").fadeIn();
                $("#take_camera_foto_ktpdiri_hukum").fadeIn();
            });
        });

        $(document).ready(function(){
            $("#webcam_foto_npwp_hukum").hide();
            $("#take_camera_foto_npwp_hukum").click(function(){
                $("#webcam_foto_npwp_hukum").fadeIn();
                $("#base_foto_npwp_hukum").hide();
                $("#take_camera_foto_npwp_hukum").hide();
                $("#results_foto_npwp_hukum").show();
                $("#webcam_foto_npwp").css( { "position" : "-100px;"} );
            });
        });

        $(document).ready(function(){
            $("#base_upload_foto_npwp_hukum").click(function(){
                $("#webcam_foto_npwp_hukum").hide();
                $("#base_foto_npwp_hukum").fadeIn();
                $("#take_camera_foto_npwp_hukum").fadeIn();
            });
        });
    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpg',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_foto_hukum' );

        function take_snapshot_foto_diri_hukum()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_diri_hukum').value = data_uri;
                document.getElementById('results_foto_diri_hukum').innerHTML = '<img class="image--cover"  src="'+data_uri+'" style="width:200px;height:160px;"/>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var foto_hukum = data_uri;
                $.ajax({

                    url : "/borrower/webcam_hukum_1",
                    method : "POST",
                    dataType: 'JSON',
                    data: foto_hukum,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw_bdn_hukum').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );
        }
    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'png',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_ktp_hukum' );

        function take_snapshot_foto_ktp_hukum()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_ktp_hukum').value = data_uri;
                document.getElementById('results_foto_ktp_hukum').innerHTML = '<img class="image--cover"  src="'+data_uri+'" style="width:200px;height:160px;"/>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp_hukum = data_uri;
                $.ajax({

                    url : "/borrower/webcam_hukum_2",
                    method : "POST",
                    dataType: 'JSON',
                    data: ktp_hukum,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw_ktp_bdn_hukum').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );
        }
    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'png',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_ktpdiri_hukum' );

        function take_snapshot_foto_ktpdiri_hukum()
        {
            
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_ktp_diri_hukum').value = data_uri;
                document.getElementById('results_foto_ktp_diri_hukum').innerHTML = '<img class="image--cover"  src="'+data_uri+'" style="width:200px;height:160px;"/>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp_diri_hukum = data_uri;
                $.ajax({

                    url : "/borrower/webcam_hukum_3",
                    method : "POST",
                    dataType: 'JSON',
                    data: ktp_diri_hukum,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw_dengan_ktp_bdn_hukum').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );

        }
    </script>
    <script language="JavaScript">
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'png',
            jpeg_quality: 90
        });

        Webcam.attach( '#camera_npwp_hukum' );

        function take_snapshot_foto_npwp_hukum()
        {
            
            Webcam.snap( function(data_uri) {
                document.getElementById('image_foto_npwp_hukum').value = data_uri;
                document.getElementById('results_foto_npwp_hukum').innerHTML = '<img class="image--cover"  src="'+data_uri+'" style="width:200px;height:160px;"/>';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var npwp_hukum = data_uri;
                $.ajax({

                    url : "/borrower/webcam_hukum_4",
                    method : "POST",
                    dataType: 'JSON',
                    data: npwp_hukum,
                    contentType: false,
                    processData: false,
                    success:function(data)
                    {
                        console.log(data);
                        if(data.success){
							alert(data.success);
							$('#url_pic_brw_npwp_bdn_hukum').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );
        }
    </script>
    <script type="text/javascript">

        // active layout type untuk borrower
        $(function() {
            $('#type_borrower').change(function(){
                $('.layout').hide();
                $('#' + $(this).val()).show();
                $( '#layout-x >' + 'div >' + 'div >' + 'div >' + '#' + $(this).val()).show();
            });
        });
        // active layout type dokumen
        /*
        $(function() {
            $('#type-pendanaan-select').change(function(){
                $('.layout-dokumen').show();
                //$('#' + $(this).val()).show();
            });
        });
        */
	
		
		// set tahun lahir
        var thn = document.getElementById('txt_tahun_pribadi');
        var minOffset = 17; maxOffset = 100; // Change to whatever you want
        var thisYear = new Date().getFullYear();
        var html_thn = '<option value="">--Pilih--</option>';
        for (i = new Date().getFullYear(); i > 1900; i--)
        {
            html_thn += '<option value='+i+'>'+i+'</option>';
        }
		
        thn.innerHTML = html_thn;
		
        var link = "{{config('app.clientlink')}}";
		
		$("#div_hide_domisili").hide(); // hide div domisili
		
		// hide & show domisili
		$("#hide_domisili_pribadi").click(function(){
			if($('#hide_domisili_pribadi').is(":checked"))  {
				$("#div_hide_domisili").show();
                $("#txt_alamat_domisili_pribadi").prop('required',true);
                $("#txt_provinsi_domisili_pribadi").prop('required',true);
                $("#txt_kota_domisili_pribadi").prop('required',true);
                $("#txt_kecamatan_domisili_pribadi").prop('required',true);
                $("#txt_kelurahan_domisili_pribadi").prop('required',true);
                $("#txt_kd_pos_domisili_pribadi").prop('required',true);
			}
			else{
				$("#div_hide_domisili").hide();
                $("#txt_alamat_domisili_pribadi").prop('required',false);
                $("#txt_provinsi_domisili_pribadi").prop('required',false);
                $("#txt_kota_domisili_pribadi").prop('required',false);
                $("#txt_kecamatan_domisili_pribadi").prop('required',false);
                $("#txt_kelurahan_domisili_pribadi").prop('required',false);
                $("#txt_kd_pos_domisili_pribadi").prop('required',false);
			}
		});
		
		
        // data pendidikan
        $.getJSON(link+"/borrower/data_pendidikan", function(data_pendidikan){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_pendidikan", function(data_pendidikan){
			
            $('#txt_pendidikanT_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pendidikan",
				allowClear: true,
				data: data_pendidikan,
                
				//multiple: true,
				//width: 200
			});
        });
		
		// data provinsi
        $.getJSON(link+"/borrower/data_provinsi", function(data_provinsi){
		//$.getJSON( "http://core.danasyariah.id/borrower/data_provinsi", function(data_provinsi){
			
            $('#txt_provinsi_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Provinsi",
				allowClear: true,
				data: data_provinsi
				//multiple: true,
				//width: 200
			});
        });
        
        // data kota
        $(function() {
            $('#txt_provinsi_pribadi').change(function(){
                var provinsi = $('#txt_provinsi_pribadi option:selected').val();
                $("#txt_kota_pribadi").empty().trigger('change'); // set null
                $.getJSON(link+"/borrower/data_kota/"+provinsi, function(data_kota){
                //$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
			
                    $('#txt_kota_pribadi').prepend('<option selected></option>').select2({
                        placeholder: "Pilih Kota",
                        allowClear: true,
                        data: data_kota
                        //multiple: true,
                        //width: 200
                    });
                });
            });
        });
		
		// data provinsi ahli waris
        $.getJSON(link+"/borrower/data_provinsi", function(data_provinsi){
		//$.getJSON( "http://core.danasyariah.id/borrower/data_provinsi", function(data_provinsi){
			
            $('#txt_provinsi_aw_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Provinsi",
				allowClear: true,
				data: data_provinsi
				//multiple: true,
				//width: 200
			});
        });
        
        // data kota ahli waris
        $(function() {
            $('#txt_provinsi_aw_pribadi').change(function(){
                var provinsi = $('#txt_provinsi_aw_pribadi option:selected').val();
                $("#txt_kota_aw_pribadi").empty().trigger('change'); // set null
                $.getJSON(link+"/borrower/data_kota/"+provinsi, function(data_kota){
                //$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
			
                    $('#txt_kota_aw_pribadi').prepend('<option selected></option>').select2({
                        placeholder: "Pilih Kota",
                        allowClear: true,
                        data: data_kota
                        //multiple: true,
                        //width: 200
                    });
                });
            });
        });
		
		// data provinsi domisili
        $.getJSON(link+"/borrower/data_provinsi", function(data_provinsi){
		//$.getJSON( "http://core.danasyariah.id/borrower/data_provinsi", function(data_provinsi){
			
            $('#txt_provinsi_domisili_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Provinsi",
				allowClear: true,
				data: data_provinsi,
				//multiple: true,
				width: 300
			});
        });
        
        // data kota domisili
        $(function() {
            $('#txt_provinsi_domisili_pribadi').change(function(){
                var provinsi = $('#txt_provinsi_domisili_pribadi option:selected').val();
                $("#txt_kota_domisili_pribadi").empty().trigger('change'); // set null
                $.getJSON(link+"/borrower/data_kota/"+provinsi, function(data_kota){
                //$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
			
                    $('#txt_kota_domisili_pribadi').prepend('<option selected></option>').select2({
                        placeholder: "Pilih Kota",
                        allowClear: true,
                        data: data_kota,
                        //multiple: true,
						width: 200
                    });
                });
            });
        });
		
		// data provinsi badan hukum
        $.getJSON(link+"/borrower/data_provinsi_bdn_hukum", function(data_provinsi){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_provinsi_bdn_hukum", function(data_provinsi){
			
			$('#txt_provinsi_bdn_hukum').prepend('<option selected></option>').select2({
				placeholder: "Pilih Provinsi",
				allowClear: true,
				data: data_provinsi,
				//multiple: true,
		 		width: 300
			});
        });
		
		// data kota badan hukum
        $(function() {
            $('#txt_provinsi_bdn_hukum').change(function(){
                var provinsi = $('#txt_provinsi_bdn_hukum option:selected').val();
                $("#txt_kota_bdn_hukum").empty().trigger('change'); // set null
                $.getJSON(link+"/borrower/data_kota_bdn_hukum/"+provinsi, function(data_kota){
                //$.getJSON("http://core.danasyariah.id/borrower/data_kota_bdn_hukum/"+provinsi, function(data_kota){
			
                    $('#txt_kota_bdn_hukum').prepend('<option selected></option>').select2({
                        placeholder: "Pilih Kota",
                        allowClear: true,
                        data: data_kota
                        //multiple: true,
                        //width: 200
                    });
                });
            });
        });
		
		// data bank
        //$.getJSON( "http://core.danasyariah.id/borrower/data_bank", function(data_bank){
        $.getJSON(link+"/borrower/data_bank", function(data_bank){	
            $('#txt_bank').prepend('<option selected></option>').select2({
				placeholder: "Pilih Bank",
				allowClear: true,
				data: data_bank
				//multiple: true,
				//width: 200
			});
		});
		
		// data bank
        $.getJSON(link+"/borrower/data_bank", function(data_bank){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_bank", function(data_bank){
			
            $('#txt_bank_bdn_hukum').prepend('<option selected></option>').select2({
				placeholder: "Pilih Bank",
				allowClear: true,
				data: data_bank,
				//multiple: true,
				width: 300
			});
		});
        
		// data pekerjaan
        $.getJSON(link+"/borrower/data_pekerjaan", function(data_pekerjaan){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_pekerjaan", function(data_pekerjaan){
			
            $('#txt_pekerjaan_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pekerjaan",
				allowClear: true,
				data: data_pekerjaan
				//multiple: true,
				//width: 200
			});
		});
		
		// data bidang pekerjaan
        $.getJSON(link+"/borrower/data_bidang_pekerjaan", function(data_bidang_pekerjaan){
		//$.getJSON( "http://core.danasyariah.id/borrower/data_bidang_pekerjaan", function(data_bidang_pekerjaan){
			
        
            $('#txt_bd_pekerjaan_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Bidang Pekerjaan",
				allowClear: true,
				data: data_bidang_pekerjaan
				//multiple: true,
				//width: 200
			});
		});

		// data pengalaman pekerjaan
        $.getJSON(link+"/borrower/data_pengalaman_pekerjaan", function(data_pengalaman_pekerjaan){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_pengalaman_pekerjaan", function(data_pengalaman_pekerjaan){
			
        
            $('#txt_pengalaman_kerja_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pengalaman Pekerjaan",
				allowClear: true,
				data: data_pengalaman_pekerjaan
				//multiple: true,
				//width: 200
			});
		});
		
		// data pendapatan
        $.getJSON(link+"/borrower/data_pendapatan", function(data_pendapatan){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_pendapatan", function(data_pendapatan){
			
        
            $('#txt_pendapatan_bulanan_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pendapatan",
				allowClear: true,
				data: data_pendapatan
				//multiple: true,
				//width: 200
			});

		});
		
		// data pekerjaan badan hukum
        $.getJSON(link+"/borrower/data_pekerjaan_bdn_hukum", function(data_pekerjaan){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_pekerjaan_bdn_hukum", function(data_pekerjaan){
			
            $('#txt_bd_pekerjaan_bdn_hukum').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pekerjaan",
				allowClear: true,
				data: data_pekerjaan,
				//multiple: true,
				width: 300
			});
		});

		// data pendapatan badan hukum
        $.getJSON(link+"/borrower/data_pendapatan_bdn_hukum", function(data_pendapatan){
        //$.getJSON( "http://core.danasyariah.id/borrower/data_pendapatan_bdn_hukum", function(data_pendapatan){
			
        
            $('#txt_revenueB_bdn_hukum').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pendapatan",
				allowClear: true,
				data: data_pendapatan,
				//multiple: true,
				width: 300
			});

		});
		
		// data pekerjaan online pribadi
        $.getJSON(link+"/borrower/bidang_pekerjaan_online", function(data_pendapatan){
		//$.getJSON( "http://core.danasyariah.id/borrower/bidang_pekerjaan_online", function(data_pendapatan){
			
        
            $('#txt_bd_pekerjaanO_pribadi').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pendapatan",
				allowClear: true,
				data: data_pendapatan,
				//multiple: true,
				width: 300
			});

		});
		
		// data pekerjaan online badan hukum
        $.getJSON(link+"/borrower/bidang_pekerjaan_online", function(data_pendapatan){
		//$.getJSON( "http://core.danasyariah.id/borrower/bidang_pekerjaan_online", function(data_pendapatan){
			
        
            $('#txt_bpo_bdn_hukum').prepend('<option selected></option>').select2({
				placeholder: "Pilih Pendapatan",
				allowClear: true,
				data: data_pendapatan,
				//multiple: true,
				width: 300
			});

		});
		
		
		// data pendapatan
        // $.getJSON(link+"/borrower/pendapatan", function(data_pendapatan){
        // // $.getJSON( "http://core.danasyariah.id/borrower/pendapatan", function(data_pendapatan){
			
        
            // $('#txt_revenueB_bdn_hukum').select2({
				// placeholder: "Pilih Pendapatan",
				// allowClear: true,
				// data: data_pendapatan,
				// // multiple: true,
				// width: 300
			// });

		// });
		
		// data jenis kelamin
        $.get(link+"/borrower/jenis_kelamin", function(data_jenis_kelamin){
		//$.get( "http://core.danasyariah.id/borrower/jenis_kelamin", function(data_jenis_kelamin){
			var obj = jQuery.parseJSON( data_jenis_kelamin );
			var length = obj.length;
			var jenisKelaminHTML = "";
			for(var i= 0; i<length; i++){
				jenisKelaminHTML = '<label class="css-control css-control-primary css-radio mr-10 text-dark">'
									+'<input type="radio" class="css-control-input" id="txt_jns_kelamin" name="txt_jns_kelamin" value="'+obj[i].id_jenis_kelamin+'" required>'
									+'<span class="css-control-indicator"></span> '+obj[i].jenis_kelamin+''
								+'</label>';
				$('#divJenisKelamin').append(jenisKelaminHTML);
			}
			
			
		});
		
		// data agama
		$.get(link+"/borrower/agama", function(data_agama){
		//$.get("http://core.danasyariah.id/borrower/agama", function(data_agama){
			var obj = jQuery.parseJSON( data_agama );
			var length = obj.length;
			var agamaHTML = "";
			
			for(var i= 0; i<length; i++){
				//console.log(obj[i].id);
				agamaHTML = '<label class="css-control css-control-primary css-radio mr-10 text-dark">'
								+'<input type="radio" class="css-control-input" id="txt_agama" name="txt_agama" value="'+obj[i].id_agama+'" required>'
								+'<span class="css-control-indicator"></span> '+obj[i].agama+''
							+'</label>';
				$('#divAgama').append(agamaHTML);
			
			}
		});
		
		// data status perkawinan
		$.get(link+"/borrower/status_perkawinan", function(data_status_perkawinan){
        //$.get( "http://core.danasyariah.id/borrower/status_perkawinan", function(data_status_perkawinan){
			var obj = jQuery.parseJSON( data_status_perkawinan );
			var length = obj.length;
			var statusPerkawinanHTML = "";
			
			for(var i= 0; i<length; i++){
				statusPerkawinanHTML = '<label class="css-control css-control-primary css-radio mr-10 text-dark">'
											+'<input type="radio" class="css-control-input" id="txt_sts_nikah_pribadi" name="txt_sts_nikah_pribadi" value="'+obj[i].id+'" required>'
											+'<span class="css-control-indicator"></span> '+obj[i].text+''
										+'</label>';
				$('#divStsPerkawinan').append(statusPerkawinanHTML);
			}
			
			
		});
		
		// data tipe pendanaan
        $.getJSON(link+"/borrower/tipe_pendanaan", function(data_tipe_pendanaan){
        //$.getJSON( "http://core.danasyariah.id/borrower/tipe_pendanaan", function(data_tipe_pendanaan){
			
        
            $('#type_pendanaan_select').prepend('<option selected></option>').select2({
				placeholder: "Pilih Tipe Pendanaan",
				allowClear: true,
				data: data_tipe_pendanaan,
				//multiple: true,
				width: 250
			});

            $('#type_pendanaan_select_bdn_hukum').prepend('<option selected></option>').select2({
				placeholder: "Pilih Tipe Pendanaan",
				allowClear: true,
				data: data_tipe_pendanaan,
				//multiple: true,
				width: 250
			});

		});
		
		// data persyaratan pendanaan pribadi
        $(function() {
            $('#type_pendanaan_select').change(function(){
                var tipe_borrower_val = $("#type_borrower option:selected").val();
                var tipe_borrower_text = $("#type_borrower option:selected").text();
                var tipe_pendanaan = $('#type_pendanaan_select option:selected').val();
                var tipe_pendanaan_text = $('#type_pendanaan_select option:selected').text();
                var tipe_borrower = "";
                if(tipe_borrower_text == "Pribadi - Pegawai"){
                    tipe_borrower = 1;
                    
                }
                if(tipe_borrower_text == "Pribadi - Wirausaha"){
                    tipe_borrower = 3;
                    
                }
                if(tipe_borrower_text == "Perusahaan / Badan Hukum"){
                    tipe_borrower = 2;
                    
                }

                //$("#txt_kota_bdn_hukum").empty().trigger('change'); // set null
                $.getJSON(link+"/borrower/persyaratan_pendanaan/"+tipe_borrower+"/"+tipe_pendanaan, function(data_persyaratan){
                //$.getJSON( "http://core.danasyariah.id/borrower/persyaratan_pendanaan/"+tipe_borrower+"/"+tipe_pendanaan, function(data_persyaratan){
                    $("#txt_judul_pendanaan").text(tipe_pendanaan_text);
                    
                    var html ="";
                    $('#checklist_persyaratan').html('');
                    for (var i = 0, len = data_persyaratan.length; i < len; ++i) {
                        var mandatory = "";
                        var checked   = "";
                        var disabled   = "";
                        if(data_persyaratan[i].persyaratan_mandatory == 1){
                            mandatory += '<span class="text-danger">*</span>';
                            checked   += 'checked';
                            disabled   += 'disabled';
                        }
						
                        html += '<div class="col-6">'
                                    +'<label class="css-control css-control-primary css-radio mr-10 text-dark">'
                                        +'<input type="checkbox" '+disabled+' '+checked+' class="css-control-input" id="txt_persyaratan_pendanaan" name=id="txt_persyaratan_pendanaan" value='+data_persyaratan[i].persyaratan_id+'>'
                                        +'<span class="css-control-indicator"></span> '+data_persyaratan[i].persyaratan_nama+' '
                                        +mandatory
                                    +'</label>'
                                +'</div>';
                    }
                   
                    $('#checklist_persyaratan').append(html);
                });
            });
			
			// data persyaratan pendanaan badan hukum
            $('#type_pendanaan_select_bdn_hukum').change(function(){
                var tipe_borrower_val = $("#type_borrower option:selected").val();
                var tipe_borrower_text = $("#type_borrower option:selected").text();
                var tipe_pendanaan = $('#type_pendanaan_select_bdn_hukum option:selected').val();
                var tipe_pendanaan_text = $('#type_pendanaan_select_bdn_hukum option:selected').text();
                
                var tipe_borrower = "";
                if(tipe_borrower_text == "Pribadi - Pegawai"){
                    tipe_borrower = 1;
                }
                if(tipe_borrower_text == "Pribadi - Wirausaha"){
                    tipe_borrower = 3;
                }
                if(tipe_borrower_text == "Perusahaan / Badan Hukum"){
                    tipe_borrower = 2;
                }
				 //$("#txt_kota_bdn_hukum").empty().trigger('change'); // set null
                $.getJSON(link+"/borrower/persyaratan_pendanaan/"+tipe_borrower+"/"+tipe_pendanaan, function(data_persyaratan){
                //$.getJSON( "http://core.danasyariah.id/borrower/persyaratan_pendanaan/"+tipe_borrower+"/"+tipe_pendanaan, function(data_persyaratan){
                    $("#txt_judul_pendanaan").text(tipe_pendanaan_text);
                    
                    var html ="";
                    $('#checklist_persyaratan').html('');
                    for (var i = 0, len = data_persyaratan.length; i < len; ++i) {
                        var mandatory = "";
                        var checked   = "";
                        var disabled   = "";
                        if(data_persyaratan[i].persyaratan_mandatory == 1){
                            mandatory += '<span class="text-danger">*</span>';
                            checked   += 'checked';
                            disabled   += 'disabled';
                        }
                        html += '<div class="col-6">'
                                    +'<label class="css-control css-control-primary css-radio mr-10 text-dark">'
                                        +'<input type="checkbox" '+disabled+' '+checked+' class="css-control-input" id="txt_persyaratan_pendanaan" name="txt_persyaratan_pendanaan" value='+data_persyaratan[i].persyaratan_id+'>'
                                        +'<span class="css-control-indicator"></span> '+data_persyaratan[i].persyaratan_nama+' '
                                        +mandatory
                                    +'</label>'
                                +'</div>';
                    }
                   
                    $('#checklist_persyaratan').append(html);
                });
                
            });
        });
		
		// check nik pribadi
        var toNIK = false;
        function CheckNik() {
            var nik = $("#txt_no_ktp_pribadi").val() ;
            //var regEx = /^[09]/;

            $("#divNoKTP").removeClass("has-error has-success is-invalid");
            $("#divNoKTP label").remove();
            $("#divNoKTP").prepend('<label class="control-label" for="idPengguna"><i class="fa fa-spin fa-spinner"></i></label>');
            
            if ($("#txt_no_ktp_pribadi").val().length == 16) {
                
                if (toNIK) {
                    clearTimeout(toNIK);
                }
                toNIK = setTimeout(function () {
                    $.get(link+"/borrower/check_nik/"+nik, function( data ) {
                    //$.get("http://core.danasyariah.id/borrower/check_nik/"+nik, function( data ) {
                        $("#divNoKTP label").remove();
                        var obj = jQuery.parseJSON( data );
						
                        if (obj.status == "ada") {
                            $("#divNoKTP").addClass("has-error is-invalid");
                            $("#divNoKTP").prepend('<label style="color:red;" for="txt_no_ktp_pribadi"><i class="fa fa-times-circle-o"></i> NIK Sudah Terdaftar</label>');
                        } else {
                            $("#divNoKTP").addClass("has-success is-valid");
                            $("#divNoKTP").prepend('<label for="txt_no_ktp_pribadi"><i class="fa fa-check"></i> NIK Belum Terdaftarkan</label>');
                        }
                    });
                    
                }, 100);
                
            } else {
                $("#divNoKTP label").remove();
                $("#divNoKTP").addClass("has-error is-invalid");
                $("#divNoKTP").prepend('<label style="color:red;" for="txt_no_ktp_pribadi"><i class="fa fa-times-circle-o"></i> NIK Harus 16 Digit</label>');
                             
            } 
        }
        
		// check nik badan hukum
        var toNIKBDNHUKUM = false;
        function check_nik_badan_hukum() {
            var nik = $("#txt_nik_anda_bdn_hukum").val() ;
            var regex = new RegExp (/^[0-9]*$/);
            $("#divNIKBH").removeClass("has-error has-success is-invalid");
            $("#divNIKBH label").remove();
            $("#divNIKBH").prepend('<label class="control-label" for="txt_nik_anda_bdn_hukum"><i class="fa fa-spin fa-spinner"></i></label>');
            if ($("#txt_nik_anda_bdn_hukum").val().length == 16) {
                
                
                if (toNIKBDNHUKUM) {
                    clearTimeout(toNIKBDNHUKUM);
                }
                toNIKBDNHUKUM = setTimeout(function () {
                    $.get(link+"/borrower/check_nik_bh/"+nik, function( data ) {
                    //$.get("http://core.danasyariah.id/borrower/check_nik_bh/"+nik, function( data ) {
                        $("#divNIKBH label").remove();
                        var obj = jQuery.parseJSON( data );
						
                        if (obj.status == "ada") {
                            $("#divNIKBH").addClass("has-error is-invalid");
                            $("#divNIKBH").prepend('<label style="color:red;" for="txt_nik_anda_bdn_hukum"><i class="fa fa-times-circle-o"></i> NIK Sudah Terdaftar</label>');
                        } else {
                            $("#divNIKBH").addClass("has-success is-valid");
                            $("#divNIKBH").prepend('<label for="txt_nik_anda_bdn_hukum"><i class="fa fa-check"></i> NIK Belum Terdaftarkan</label>');
                        }
                    });
                    
                }, 100);
                    
                
            }else{
				
                $("#divNIKBH label").remove();
                $("#divNIKBH").addClass("has-error is-invalid");
				$("#divNoKTP label").removeClass('is-valid');
                $("#divNIKBH").prepend('<label style="color:red;" for="txt_nik_anda_bdn_hukum"><i class="fa fa-times-circle-o"></i> NIK Harus 16 Digit</label>');
				    
            }
        }
		
		// check no tlp pribadi
        var toTLP_pribadi = false;
        function check_tlp_pribadi() {
            var notlp = $("#txt_notlp_pribadi").val() ;
            var regex = new RegExp (/^[0-9]*$/);
            $("#div_tlp_pribadi").removeClass("has-error has-success is-invalid");
            $("#div_tlp_pribadi label").remove();
            $("#div_tlp_pribadi").prepend('<label class="control-label" for="txt_notlp_pribadi"><i class="fa fa-spin fa-spinner"></i></label>');
            //if ($("#txt_notlp_pribadi").val().length == 13 && ) {
                
                
                if (toTLP_pribadi) {
                    clearTimeout(toTLP_pribadi);
                }
                toTLP_pribadi = setTimeout(function () {
                    $.get(link+"/borrower/check_no_tlp/"+notlp, function( data ) {
                    //$.get("http://core.danasyariah.id/borrower/check_no_tlp/"+notlp, function( data ) {
                        $("#div_tlp_pribadi label").remove();
                        var obj = jQuery.parseJSON( data );
						
                        if (obj.status == "ada") {
                            $("#div_tlp_pribadi").addClass("has-error is-invalid");
                            $("#div_tlp_pribadi").prepend('<label style="color:red;" for="txt_notlp_pribadi"><i class="fa fa-times-circle-o"></i> No TLp Sudah Terdaftar</label>');
                        } else {
                            $("#div_tlp_pribadi").addClass("has-success is-valid");
                            $("#div_tlp_pribadi").prepend('<label for="txt_notlp_pribadi"><i class="fa fa-check"></i> No TLP Belum Terdaftarkan</label>');
                        }
                    });
                    
                }, 50);
                    
                
            //}else{
                //$("#div_tlp_pribadi label").remove();
                //$("#div_tlp_pribadi").addClass("has-error is-invalid");
				//$("#div_tlp_pribadi label").removeClass('is-valid');
                //$("#div_tlp_pribadi").prepend('<label style="color:red;" for="txt_notlp_pribadi"><i class="fa fa-times-circle-o"></i> NIK Harus 16 Digit</label>');
				
				
                    
            //}
        }
		
		// check no tlp pribadi
        var toTLP_bdn_hukum = false;
        function check_tlp_bdn_hukum() {
            var notlp = $("#txt_notlp_anda_bdn_hukum").val() ;
            var regex = new RegExp (/^[0-9]*$/);
            $("#div_tlp_bdn_hukum").removeClass("has-error has-success is-invalid");
            $("#div_tlp_bdn_hukum label").remove();
            $("#div_tlp_bdn_hukum").prepend('<label class="control-label" for="txt_notlp_anda_bdn_hukum"><i class="fa fa-spin fa-spinner"></i></label>');
            //if ($("#txt_notlp_pribadi").val().length == 13 && ) {
                
                
                if (toTLP_pribadi) {
                    clearTimeout(toTLP_pribadi);
                }
                toTLP_pribadi = setTimeout(function () {
                    $.get(link+"/borrower/check_no_tlp/"+notlp, function( data ) {
                    //$.get( "http://core.danasyariah.id/borrower/check_no_tlp/"+notlp, function( data ) {
                        $("#div_tlp_bdn_hukum label").remove();
                        var obj = jQuery.parseJSON( data );
						
                        if (obj.status == "ada") {
                            $("#div_tlp_bdn_hukum").addClass("has-error is-invalid");
                            $("#div_tlp_bdn_hukum").prepend('<label style="color:red;" for="txt_notlp_anda_bdn_hukum"><i class="fa fa-times-circle-o"></i> No TLp Sudah Terdaftar</label>');
                        } else {
                            $("#div_tlp_bdn_hukum").addClass("has-success is-valid");
                            $("#div_tlp_bdn_hukum").prepend('<label for="txt_notlp_anda_bdn_hukum"><i class="fa fa-check"></i> No HP Belum Terdaftarkan</label>');
                        }
                    });
                    
                }, 50);
                    
                
            //}else{
                //$("#div_tlp_pribadi label").remove();
                //$("#div_tlp_pribadi").addClass("has-error is-invalid");
				//$("#div_tlp_pribadi label").removeClass('is-valid');
                //$("#div_tlp_pribadi").prepend('<label style="color:red;" for="txt_notlp_pribadi"><i class="fa fa-times-circle-o"></i> NIK Harus 16 Digit</label>');
				
				
                    
            //}
        }
		
		// check format email
        var clear = false;
        function check_format_email(id,value){
            
            $("div#div_"+id+" label").remove();
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var email = document.getElementById("txt_email_aw_pribadi").value;
            var email_instan1 = email.includes("mailinator");
            var email_instan2 = email.includes("urhen");
            var email_instan3 = email.includes("guerrillamail");
            var email_instan4 = email.includes("maildrop");
            var email_instan5 = email.includes("wemel");
            var email_instan6 = email.includes("mt2015");
            var email_instan7 = email.includes("dispostable");
            var email_instan8 = email.includes("tempr");
            var email_instan9 = email.includes("discard");
            var email_instan10 = email.includes("mailcatch");
            var email_instan11 = email.includes("einroit");
            var email_instan12 = email.includes("mailnesia");
            var email_instan13 = email.includes("yopmail");
            //alert(email);

            if(!regex.test(value)) {

                if (clear) 
                {
                    if (email_instan1 || email_instan2 || email_instan3 || email_instan4 || email_instan5 || email_instan6 || email_instan7 || email_instan8 || email_instan9 || email_instan10 || email_instan11 || email_instan12 || email_instan13) {
                    //alert('Domain Email Anda tidak diizinkan. Silahkan gunakan domain email lain');
                    $('#error_email').html('<b id="emailerror">Domain Email Anda tidak diizinkan. Silahkan gunakan domain email lain</b>');
                    $('#next').attr('disabled',true);

                    }else{
                        $('#emailerror').hide();
                        $('#next').attr('disabled',false);
                        return true; 		
                    }

                    clearTimeout(clear);
                }
                clear = setTimeout(function ()
                {
                    
                    $("div#div_"+id+" label").remove();
                    $("div#div_"+id).addClass("has-error is-invalid");
                    $("div#div_"+id).prepend('<label style="color:red;" for="txt_nik_anda_bdn_hukum"><i class="fa fa-times-circle-o"></i> Format Email Tidak Valid</label>');
                
                 }, 100);
                
            
            }
            else
            {

                $("div#div_"+id).addClass("has-success is-valid");
                $("div#div_"+id).removeClass("is-invalid");
                $("div#div_"+id).prepend('<label for="'+id+'"><i class="fa fa-check"></i> Email Valid</label>');
                        
            }

        }
		
		// check format email
        var dana_dibutuhkan = false;
        function check_dana_dibutuhkan(){
			$("#div_dana_dibutuhkan").removeClass("has-error has-success is-invalid");
            $("#div_dana_dibutuhkan label").remove();
            $("#div_dana_dibutuhkan").prepend('<label class="control-label" for="txt_dana_pendanaan"></label>');
			
            var dana = $("#txt_dana_pendanaan").val();
            if(dana.length < 7) {

                if (dana_dibutuhkan) {
                    clearTimeout(dana_dibutuhkan);
                }
                dana_dibutuhkan = setTimeout(function () {
                    
                    //$("#div_dana_dibutuhkan").remove();
                    $("#div_dana_dibutuhkan").addClass("has-error is-invalid");
                    $("#div_dana_dibutuhkan").prepend('<label style="color:red;" for="txt_dana_pendanaan"><i class="fa fa-times-circle-o"></i> Minimal 1.000.000 (RP)</label>');
                
                 }, 100);
                
            
            }else{
                $("#div_dana_dibutuhkan").addClass("has-success is-valid");
                $("#div_dana_dibutuhkan").removeClass("is-invalid");
                $("#div_dana_dibutuhkan").prepend('<label for="txt_dana_pendanaan"><i class="fa fa-check"></i> Dana Dibutuhkan (RP)</label>');
                        
            }
        }

        // data jenis jaminan
        $.getJSON("{{config('app.clientlink')}}/borrower/jenis_jaminan", function(data_jenis_jaminan){
                $('.jenisjaminan').prepend('<option selected></option>').select2({
                    placeholder: "Pilih Jenis Jaminan",
                    allowClear: true,
                    data: data_jenis_jaminan,
                    //multiple: true,
                    width: 250
                });
        });
        //tambah jaminan
        function add_jaminan() {
            $.getJSON("{{config('app.clientlink')}}/borrower/jenis_jaminan", function(data_jenis_jaminan){
                        $('.jenisjaminan').prepend('<option selected></option>').select2({
                            placeholder: "Pilih Jenis Jaminan",
                            allowClear: true,
                            data: data_jenis_jaminan,
                            //multiple: true,
                            width: 250
                        });
                    });
            var tambahJaminan = 
                 // data jenis jaminan
                '<div class="col-12 mt-3" id="containerJaminan">'
                +'<h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Jaminan Pendanaan</h6>'
                +'<div class="row">'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-namapengurus">Nama Jaminan</label>'
                            +'<input class="form-control" type="text" id="txt_nm_jaminan_pendanaan" name="txt_nm_jaminan_pendanaan[]" placeholder="Nama Jaminan Pendanaan...">'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Nomor Jaminan</label>'
                            +'<input class="form-control" type="text" id="txt_nomor_jaminan_pendanaan" name="txt_nomor_jaminan_pendanaan[]" placeholder="Nomor Jaminan Pendanaan...">'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Jenis Jaminan</label>'
                            +'<select class="form-control jenisjaminan" id="txt_jenis_jaminan_pendanaan" name="txt_jenis_jaminan_pendanaan[]"></select>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<div class="row">'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Nilai Jaminan (Rp)</label>'
                            +'<input class="form-control" type="number" id="txt_nilai_jaminan_pendanaan" name="txt_nilai_jaminan_pendanaan[]" placeholder="Nilai Jaminan Pendanaan...">'
                        +'</div>'
                    +'</div>' 
                    +'<div class="col-md-8">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Detail Jaminan</label>'
                            +'<textarea class="form-control detailjaminan" rows="4" cols="80" id="txt_detail_jaminan_pendanaan" name="txt_detail_jaminan_pendanaan[]"></textarea>'
                        +'</div>'
                    +'</div>'   
                +'</div>'
                +'<button type="button" class="btn btn-rounded btn-danger mb-10 push-right" id="delete_jaminan"> <i class="fa fa-times"></i>  Hapus Jaminan Ini</button><hr>'
            +'</div>';
            
           

            $('#tambahJaminan').append(tambahJaminan);
            
        }
        //delete jaminan
        $(document).on("click", "#delete_jaminan", function() { 
            $(this).parent().remove();
        });
		
		
		
		$(document).on("change","#pic_brw", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);


				$.ajax({
					url : "/borrower/upload_foto_1",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						console.log(data);
						if(data.success){
							alert(data.success);
							$('#url_pic_brw').val(data.url);
							$("#txt_filename_pribadi").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});

		$(document).on("change","#pic_brw_ktp", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);

				$.ajax({
					url : "/borrower/upload_foto_2",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{	
						if(data.success){
							alert(data.success);
							$('#url_pic_brw_ktp').val(data.url);
							$("#txt_filename_ktp_pribadi").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});
		
		$(document).on("change","#pic_brw_dengan_ktp", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);

				$.ajax({
					url : "/borrower/upload_foto_3",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						console.log(data)
						if(data.success){
							alert(data.success);
							$('#url_pic_brw_dengan_ktp').val(data.url);
							$("#txt_filename_brw_ktp_pribadi").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});
		
		$(document).on("change","#pic_brw_npwp", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);

				$.ajax({
					url : "/borrower/upload_foto_4",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						if(data.success){
							alert(data.success);
							$('#url_pic_brw_npwp').val(data.url);
							$("#txt_filename_npwp_pribadi").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});
		
		<!----------------- pic badan hukum ----------------->
		
		$(document).on("change","#pic_brw_bdn_hukum", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);

				$.ajax({
					url : "/borrower/upload_foto_1",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						console.log(data)
						if(data.success){
							alert(data.success);
							$('#url_pic_brw_bdn_hukum').val(data.url);
							$("#txt_filename_bdn_hukum").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});

		$(document).on("change","#pic_brw_ktp_bdn_hukum", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);

				$.ajax({
					url : "/borrower/upload_foto_2",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						console.log(data)
						if(data.success){
							alert(data.success);
							$('#url_pic_brw_ktp_bdn_hukum').val(data.url);
							$("#txt_filename_ktp_bdn_hukum").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});
		
		$(document).on("change","#pic_brw_dengan_ktp_bdn_hukum", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);

				$.ajax({
					url : "/borrower/upload_foto_3",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						console.log(data)
						if(data.success){
							alert(data.success);
							$('#url_pic_brw_dengan_ktp_bdn_hukum').val(data.url);
							$("#txt_filename_brw_ktp_bdn_hukum").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});
		
		$(document).on("change","#pic_brw_npwp_bdn_hukum", function()
		{
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
		
			var uploadFile = $(this);
			var files =!!this.files?this.files:[];
			if(!files.length||!window.FileReader)return;

			if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file

				reader.onloadend = function(){ // set image data as background of div
				  //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
					uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
				}

			var fileUpload = $(this).get(0);
			var filess = fileUpload.files[0];
			var form_data = new FormData();
			form_data.append('file', filess);

				$.ajax({
					url : "/borrower/upload_foto_4",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						if(data.success){
							alert(data.success);
							$('#url_pic_brw_npwp_bdn_hukum').val(data.url);
							$("#txt_filename_npwp_bdn_hukum").text(data.filename);
						}else{
							alert(data.failed);
						}
					}
				});
			}
		});
		
		// validasi karakter aneh
		$('.checkKarakterAneh').on('input', function (event) { 
            this.value = this.value.replace(/[^a-zA-Z ]/g, '');
        });
		
		$('.allowCharacter').on('input', function (event) { 
            this.value = this.value.replace(/[^a-zA-Z0-9.,-/ ]/g, '');
        });

        $('.allowCharacterdate').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9.,-/]/g, '');
        });
		
		// validasi hanya angka
		$('#txt_kd_pos_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_no_ktp_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		$('#txt_npwp_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		$('#txt_npwp_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_nik_aw_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_nik_anda_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_anda_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_aw_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_aw_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_asset_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_dana_pendanaan').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_durasi_pendanaan').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		$('#txt_no_rekening').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		$('#txt_no_rekening_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		$('#txt_notlp_pengurus_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		$('#txt_nik_pengurus_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		$('#txt_kode_pos_aw_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
		
		
		
		
        // start
        // tambah penanggung jawab untuk tipe Badan Hukum
        
        function add_penanggung_jawab() {
            var n = $('div #containerPenanggungJawab').length;
            var tambahPenanggungJawab = 
                '<div class="col-12 mt-3" id="containerPenanggungJawab">'
                +'<div class="row">'
                    +'<div class="col-12">'
                        +'<h6 class="content-heading text-muted font-w600 mt-0 pt-0" style="font-size: 1em;" id="txtPengurus">Pengurus Ke '+(n+1)+'</h6>'
                    +'</div>'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-namapengurus">Nama Pengurus</label>'
                            +'<input class="form-control" type="text" id="txt_nm_pengurus_bdn_hukum" name="txt_nm_pengurus_bdn_hukum" placeholder="Masukkan nama pengurus...">'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-md-5">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">NIK</label>'
                            +'<input class="form-control" type="number" id="txt_nik_pengurus_bdn_hukum" name="txt_nik_pengurus_bdn_hukum" placeholder="Masukkan NIK pengurus...">'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nomorhp">No Telepon / HP</label>'
                            +'<input class="form-control" type="number" id="txt_notlp_pengurus_bdn_hukum" name="txt_notlp_pengurus_bdn_hukum" placeholder="Masukkan nomor telepon">'
                        +'</div>'
                    +'</div> '
                    +'<div class="col-md-5">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-jabatan">Jabatan</label>'
                            +'<input class="form-control" type="text" id="txt_jabatan_pengurus_bdn_hukum" name="txt_jabatan_pengurus_bdn_hukum" placeholder="Masukkan Jabatan Pengurus">'
                        +'</div>'
                    +'</div>'  
                +'</div>'
                +'<button type="button" class="btn btn-rounded btn-danger mb-10 push-right" id="delete_penanggung_jawab"> <i class="fa fa-times"></i>  Hapus Pengurus Ini</button><hr>'
            +'</div>';
            
            $('#tambahPenanggungJawab').append(tambahPenanggungJawab);
            
        }


        $(document).on("click", "#delete_penanggung_jawab", function() { 
            $(this).parent().remove();
        });
        // end
		
		$("#btn_lengkapi_profile").click(function(){
			$("#modal_action_lengkapi_profile").modal('show');
			
		});

        function timerDisableButton(){
            var spn = document.getElementById("count");
            var btn = document.getElementById("kirim_lagi");

            var count = 30;     // Set count
            var timer = null;  // For referencing the timer
            (function countDown(){
              // Display counter and start counting down
              spn.textContent = count;
              
              // Run the function again every second if the count is not zero
              if(count !== 0){
                timer = setTimeout(countDown, 1000);
                count--; // decrease the timer
              } else {
                // Enable the button
                btn.removeAttribute("disabled");
                spn.removeText
              }
            }());
        }

        $('#btn_proses_lengkapi_profile').on('click',function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#kirim_lagi').prop('disabled',true);

            var tipeBrw = $("#type_borrower option:selected").val();
            if (tipeBrw == 'layout-pribadi')
            {
                $('#no_hp').val($('#txt_notlp_pribadi').val());
            }
            else
            {
                $('#no_hp').val($('#txt_notlp_anda_bdn_hukum').val());
            }
            
            noHP = $('#no_hp').val();
            console.log(noHP)
            $.ajax({
                url : "/borrower/kirimOTP/",
                method : "post",
                dataType: 'JSON',
                data: {hp:noHP},
                success:function(data)
                {
                    console.log(data.status)
                }
            });
            timerDisableButton();
        })

        $('#kirim_lagi').on('click',function(){
            $('#kirim_lagi').prop('disabled',true);

            var tipeBrw = $("#type_borrower option:selected").val();
            if (tipeBrw == 'layout-pribadi')
            {
                $('#no_hp').val($('#txt_notlp_pribadi').val());
            }
            else
            {
                $('#no_hp').val($('#txt_notlp_anda_bdn_hukum').val());
            }

            noHP = $('#no_hp').val();
            console.log(noHP)
            $.ajax({
                url : "/borrower/kirimOTP/",
                method : "post",
                dataType: 'JSON',
                data: {hp:noHP},
                success:function(data)
                {
                    console.log(data.status)
                }
            });
            timerDisableButton();
        })

        $('#kode_otp').on('keyup',function(){
            console.log($('#kode_otp').val().length)
            if ($('#kode_otp').val().length == 6)
            {
                $('#kirim_data').removeAttr('disabled');

            }
            else
            {
                $('#kirim_data').prop('disabled',true);
            }
        })
        
        $('#kirim_data').on('click',function(){
            $.ajax({
                url : "/borrower/cekOTP/",
                method : "post",
                dataType: 'JSON',
                data: {otp:$('#kode_otp').val()},
                success:function(data)
                {
                    if (data.status == '00')
                    {
                        console.log(data.status)
                        <!-- ---------------------------------------------- VARIABLE PRIBADI ------------------------------>
                        var type_borrower = $("#type_borrower option:selected").text() ;
                        var txt_nm_pengguna_pribadi = $("#txt_nm_pengguna_pribadi").val() ;
                        var txt_nm_ibu_pribadi = $("#txt_nm_ibu_pribadi").val();
                        var txt_pendidikanT_pribadi = $("#txt_pendidikanT_pribadi option:selected").val();
                        var txt_no_ktp_pribadi = $("#txt_no_ktp_pribadi").val();
                        var txt_npwp_pribadi = $("#txt_npwp_pribadi").val();
                        var txt_notlp_pribadi = $("#txt_notlp_pribadi").val();
                        var txt_tmpt_lahir_pribadi = $("#txt_tmpt_lahir_pribadi").val();
                        var txt_hari_pribadi = $("#txt_hari_pribadi option:selected").val();
                        var txt_bulan_pribadi = $("#txt_bulan_pribadi option:selected").val();
                        var txt_tahun_pribadi = $("#txt_tahun_pribadi option:selected").val();
                        var txt_jns_kelamin = $("input[name=txt_jns_kelamin]:checked").val();
                        var txt_agama = $("input[name=txt_agama]:checked").val();
                        var txt_sts_nikah_pribadi = $("input[name=txt_sts_nikah_pribadi]:checked").val();
                        
                        var txt_nm_aw_pribadi = $("#txt_nm_aw_pribadi").val();
                        var txt_nik_aw_pribadi = $("#txt_nik_aw_pribadi").val();
                        var txt_notlp_aw_pribadi = $("#txt_notlp_aw_pribadi").val();
                        var txt_email_aw_pribadi = $("#txt_email_aw_pribadi").val();
                        var txt_alamat_aw_pribadi = $("#txt_alamat_aw_pribadi").val();
                        var txt_provinsi_aw_pribadi = $("#txt_provinsi_aw_pribadi option:selected").val();
                        var txt_kota_aw_pribadi = $("#txt_kota_aw_pribadi option:selected").val();
                        var txt_kecamatan_aw_pribadi = $("#txt_kecamatan_aw_pribadi").val();
                        var txt_kelurahan_aw_pribadi = $("#txt_kelurahan_aw_pribadi").val();
                        var txt_kode_pos_aw_pribadi = $("#txt_kode_pos_aw_pribadi").val();
                        
                        var txt_provinsi_pribadi = $("#txt_provinsi_pribadi option:selected").val();
                        var txt_kota_pribadi = $("#txt_kota_pribadi option:selected").val();
                        var txt_kd_pos_pribadi = $("#txt_kd_pos_pribadi").val();
                        var txt_alamat_pribadi = $("#txt_alamat_pribadi").val();
                        var txt_kecamatan_pribadi = $("#txt_kecamatan_pribadi").val();
                        var txt_kelurahan_pribadi = $("#txt_kelurahan_pribadi").val();
                        
                        if($('#hide_domisili_pribadi').is(":checked"))  {
                            var txt_alamat_domisili_pribadi = $("#txt_alamat_domisili_pribadi").val();
                            var txt_provinsi_domisili_pribadi = $("#txt_provinsi_domisili_pribadi option:selected").val();
                            var txt_kota_domisili_pribadi = $("#txt_kota_domisili_pribadi option:selected").val();
                            var txt_kd_pos_domisili_pribadi = $("#txt_kd_pos_domisili_pribadi").val();
                            var txt_kecamatan_domisili_pribadi = $("#txt_kecamatan_domisili_pribadi").val();
                            var txt_kelurahan_domisili_pribadi = $("#txt_kelurahan_domisili_pribadi").val();
                        }
                        else{
                            var txt_alamat_domisili_pribadi = $("#txt_alamat_pribadi").val();
                            var txt_provinsi_domisili_pribadi = $("#txt_provinsi_pribadi option:selected").val();
                            var txt_kota_domisili_pribadi = $("#txt_kota_pribadi option:selected").val();
                            var txt_kd_pos_domisili_pribadi = $("#txt_kd_pos_pribadi").val();
                            var txt_kecamatan_domisili_pribadi = $("#txt_kecamatan_pribadi").val();
                            var txt_kelurahan_domisili_pribadi = $("#txt_kelurahan_pribadi").val();
                        }
                        
                        
                        var txt_sts_rmh_pribadi = $("input[name=txt_sts_rmh_pribadi]:checked").val();
                        var txt_pekerjaan_pribadi = $("#txt_pekerjaan_pribadi option:selected").val();
                        var txt_bd_pekerjaan_pribadi = $("#txt_bd_pekerjaan_pribadi option:selected").val();
                        var txt_bd_pekerjaanO_pribadi = $("#txt_bd_pekerjaanO_pribadi option:selected").val();
                        var txt_pengalaman_kerja_pribadi = $("#txt_pengalaman_kerja_pribadi option:selected").val();
                        var txt_pendapatan_bulanan_pribadi = $("#txt_pendapatan_bulanan_pribadi option:selected").val();
                        
                        // foto pribadi
                        var url_pic_brw = $("#url_pic_brw").val();
                        var url_pic_brw_ktp = $("#url_pic_brw_ktp").val();
                        var url_pic_brw_dengan_ktp = $("#url_pic_brw_dengan_ktp").val(); 
                        var url_pic_brw_npwp = $("#url_pic_brw_npwp").val();

                        
                        // rekening perorangan
                        var txt_nm_pemilik = $("#txt_nm_pemilik").val();
                        var txt_no_rekening = $("#txt_no_rekening").val();
                        var txt_bank = $("#txt_bank option:selected").val(); 
                        
                        <!-- ---------------------------------------------- VARIABLE BADAN HUKUM ------------------------------>
                        var txt_nm_bdn_hukum = $("#txt_nm_bdn_hukum").val();
                        var txt_npwp_bdn_hukum = $("#txt_npwp_bdn_hukum").val();
                        var txt_nm_anda_bdn_hukum = $("#txt_nm_anda_bdn_hukum").val();
                        var txt_nik_anda_bdn_hukum = $("#txt_nik_anda_bdn_hukum").val();
                        var txt_notlp_anda_bdn_hukum = $("#txt_notlp_anda_bdn_hukum").val();
                        var txt_jabatan_anda_bdn_hukum = $("#txt_jabatan_anda_bdn_hukum").val();
                        var txt_nm_pengurus_bdn_hukum = $("#txt_nm_pengurus_bdn_hukum").val();
                        var txt_nik_pengurus_bdn_hukum = $("#txt_nik_pengurus_bdn_hukum").val();
                        var txt_notlp_pengurus_bdn_hukum = $("#txt_notlp_pengurus_bdn_hukum").val();
                        var txt_jabatan_pengurus_bdn_hukum = $("#txt_jabatan_pengurus_bdn_hukum").val();
                        
                        // foto badan hukum
                        var url_pic_brw_bdn_hukum = $("#url_pic_brw_bdn_hukum").val();
                        var url_pic_brw_ktp_bdn_hukum = $("#url_pic_brw_ktp_bdn_hukum").val();
                        var url_pic_brw_dengan_ktp_bdn_hukum = $("#url_pic_brw_dengan_ktp_bdn_hukum").val(); 
                        var url_pic_brw_npwp_bdn_hukum = $("#url_pic_brw_npwp_bdn_hukum").val(); 
                        
                        // rekening badan hukum
                        var txt_nm_pemilik_rekening_bdn_hukum = $("#txt_nm_pemilik_rekening_bdn_hukum").val();
                        var txt_no_rekening_bdn_hukum = $("#txt_no_rekening_bdn_hukum").val();
                        var txt_bank_bdn_hukum = $("#txt_bank_bdn_hukum option:selected").val(); 
                        
                        var txt_provinsi_bdn_hukum = $("#txt_provinsi_bdn_hukum option:selected").val();
                        var txt_kota_bdn_hukum = $("#txt_kota_bdn_hukum option:selected").val();
                        var txt_kd_pos_bdn_hukum = $("#txt_kd_pos_bdn_hukum").val();
                        var txt_kecamatan_bdn_hukum = $("#txt_kecamatan_bdn_hukum").val();
                        var txt_kelurahan_bdn_hukum = $("#txt_kelurahan_bdn_hukum").val();
                        var txt_alamat_bdn_hukum = $("#txt_alamat_bdn_hukum").text();
                        
                        var txt_bd_pekerjaan_bdn_hukum = $("#txt_bd_pekerjaan_bdn_hukum option:selected").val();
                        var txt_revenueB_bdn_hukum = $("#txt_revenueB_bdn_hukum option:selected").val();
                        var txt_bpo_bdn_hukum = $("#txt_bpo_bdn_hukum option:selected").val();
                        var txt_asset_bdn_hukum = $("#txt_asset_bdn_hukum").val();
                        
                        //pendanaan;
                        var type_pendanaan_select = $("#type_pendanaan_select option:selected").val();
                        var type_pendanaan_select_bdn_hukum = $("#type_pendanaan_select_bdn_hukum option:selected").val();
                        var txt_nm_pendanaan = $("#txt_nm_pendanaan").val();
                        var txt_jenis_akad_pendanaan = $("#txt_jenis_akad_pendanaan option:selected").val();
                        var txt_dana_pendanaan = $("#txt_dana_pendanaan").val();
                        var estimasi_proyek = $("#txt_estimasi_proyek").val();
                        var txt_estimasi_proyek = estimasi_proyek.split("-").reverse().join("-");
                        var txt_durasi_pendanaan = $("#txt_durasi_pendanaan").val();
                        var txt_pembayaran_pendanaan = $("input[name=txt_pembayaran_pendanaan]:checked").val();
                        var txt_metode_pembayaran_pendanaan = $("input[name=txt_metode_pembayaran_pendanaan]:checked").val();
                        var txt_detail_pendanaan =  $('#txt_detail_pendanaan').val();;

                        //jenis jaminan
                        var jaminan_nama= []; jaminan_nomor= []; jaminan_jenis= []; jaminan_nilai= []; jaminan_detail= [];jaminan_status = [];
                        // jaminan_nama
                        $('input[name="txt_nm_jaminan_pendanaan[]"]').each(function() {
                            jaminan_nama.push(this.value);
                        });

                        // jaminan_nomor
                        $('input[name="txt_nomor_jaminan_pendanaan[]"]').each(function() {
                            jaminan_nomor.push(this.value);
                        });

                        // jaminan_jenis
                        $('.jenisjaminan').each(function() {
                            jaminan_jenis.push(this.value);
                        });
                        // alert(jaminan_jenis);
                        //jaminan_nilai
                        $('input[name="txt_nilai_jaminan_pendanaan[]"]').each(function() {
                            jaminan_nilai.push(this.value);
                        });

                        // jaminan_detail
                        $('.detailjaminan').each(function() {
                            jaminan_detail.push(this.value);
                        });
                        
                        var jaminan = [];
                        for(var u=0;u<jaminan_nama.length;u++){
                            jaminan[u] = [
                                jaminan_nama[u]+"@",
                                "@"+jaminan_nomor[u]+"@",
                                "@"+jaminan_jenis[u]+"@",
                                "@"+jaminan_nilai[u]+"@",
                                "@"+jaminan_detail[u]
                            ];
                        }
                        var jaminan_arr = jaminan.join("^~");
                        // alert(jaminan_arr);
                        
                        // persyaratan
                        var persyaratanList = [];
                        var persyaratanNonList = [];
                        var i = 0;
                        var ii = 0;
                        
                        $("#txt_persyaratan_pendanaan:checked").each(function() {

                            if (this.checked) {
                                persyaratanList.push(this.value);
                                i++;
                            }

                        });
                        var persyaratan_arr = persyaratanList.join(",");
                        
                        $("input#txt_persyaratan_pendanaan:not(:checked)").each(function() {

                            //if (this.checked) {
                                persyaratanNonList.push(this.value);
                                ii++;
                            //}

                        });
                        
                        var persyaratan_non_arr = persyaratanNonList.join("|");
                        
                        var typeBorrower = "";
                        var today = new Date();
                        var birthDate = new Date(txt_tahun_pribadi);
                        var age = today.getFullYear() - birthDate.getFullYear();
                        var m = today.getMonth() - birthDate.getMonth();
                        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                            
                        }
                        
                        if(type_borrower == "Pribadi - Pegawai"){
                            typeBorrower += 1; // perorangan pegawai 
                            // if(age < 17 && txt_sts_nikah_pribadi !== 1){
                                // alert(age + ' Tolak karna belum menikah');
                            // }
                            if(txt_sts_nikah_pribadi != 1 && age < 18){
                                
                                //alert(age + ' Tolak Karna Usia Masi Kecil teru belom nikah');
                                Swal.fire({
                                    position: 'center',
                                    icon: 'failed',
                                    title: 'Maaf proses anda ditolak karna usia anda masih kecil dan belum menikah',
                                    showConfirmButton: false,
                                    timer: 3500
                                })
                                
                            }else{
                                $.ajax({
                                    url: "{{route('borrower.action_lengkapi_profile')}}",
                                    type: "POST",
                                    data:  {"_token": "{{ csrf_token() }}", 'type_borrower':typeBorrower, 'txt_nm_pengguna_pribadi':txt_nm_pengguna_pribadi, 'txt_nm_ibu_pribadi':txt_nm_ibu_pribadi, 'txt_pendidikanT_pribadi':txt_pendidikanT_pribadi, 'txt_no_ktp_pribadi':txt_no_ktp_pribadi, 'txt_npwp_pribadi':txt_npwp_pribadi, 'txt_notlp_pribadi':txt_notlp_pribadi, 'txt_tmpt_lahir_pribadi':txt_tmpt_lahir_pribadi, 'txt_hari_pribadi':txt_hari_pribadi, 'txt_bulan_pribadi':txt_bulan_pribadi, 'txt_tahun_pribadi':txt_tahun_pribadi, 'txt_jns_kelamin':txt_jns_kelamin, 'txt_agama':txt_agama, 'txt_sts_nikah_pribadi':txt_sts_nikah_pribadi,
                                    // ahli waris
                                    'txt_nm_aw_pribadi': txt_nm_aw_pribadi,'txt_nik_aw_pribadi':txt_nik_aw_pribadi, 'txt_notlp_aw_pribadi':txt_notlp_aw_pribadi, 'txt_email_aw_pribadi':txt_email_aw_pribadi,'txt_provinsi_aw_pribadi':txt_provinsi_aw_pribadi, 'txt_kota_aw_pribadi':txt_kota_aw_pribadi,'txt_kecamatan_aw_pribadi':txt_kecamatan_aw_pribadi,'txt_kelurahan_aw_pribadi':txt_kelurahan_aw_pribadi, 'txt_alamat_aw_pribadi':txt_alamat_aw_pribadi, 'txt_kode_pos_aw_pribadi':txt_kode_pos_aw_pribadi,
                                    // alamat ktp
                                    'txt_alamat_pribadi':txt_alamat_pribadi, 'txt_provinsi_pribadi':txt_provinsi_pribadi, 'txt_kota_pribadi':txt_kota_pribadi, 'txt_kd_pos_pribadi':txt_kd_pos_pribadi, 'txt_kecamatan_pribadi':txt_kecamatan_pribadi, 'txt_kelurahan_pribadi':txt_kelurahan_pribadi,
                                    // alamat domisili
                                    'txt_alamat_domisili_pribadi':txt_alamat_domisili_pribadi, 'txt_provinsi_domisili_pribadi':txt_provinsi_domisili_pribadi, 'txt_kota_domisili_pribadi':txt_kota_domisili_pribadi, 'txt_kecamatan_domisili_pribadi':txt_kecamatan_domisili_pribadi,'txt_kelurahan_domisili_pribadi':txt_kelurahan_domisili_pribadi,'txt_kd_pos_domisili_pribadi':txt_kd_pos_domisili_pribadi,

                                    'txt_sts_rmh_pribadi':txt_sts_rmh_pribadi, 'txt_pekerjaan_pribadi':txt_pekerjaan_pribadi, 'txt_bd_pekerjaan_pribadi':txt_bd_pekerjaan_pribadi, 'txt_bd_pekerjaanO_pribadi':txt_bd_pekerjaanO_pribadi, 'txt_pengalaman_kerja_pribadi':txt_pengalaman_kerja_pribadi, 'txt_pendapatan_bulanan_pribadi':txt_pendapatan_bulanan_pribadi, 
                                    // foto
                                    "url_pic_brw":url_pic_brw, "url_pic_brw_ktp" : url_pic_brw_ktp, "url_pic_brw_dengan_ktp":url_pic_brw_dengan_ktp,"url_pic_brw_npwp":url_pic_brw_npwp,
                                    // bank
                                    "txt_nm_pemilik":txt_nm_pemilik, "txt_no_rekening" : txt_no_rekening, "txt_bank":txt_bank,
                                    // pendanaan
                                    'txt_nm_pendanaan':txt_nm_pendanaan, 'txt_jenis_akad_pendanaan':txt_jenis_akad_pendanaan, 'txt_dana_pendanaan':txt_dana_pendanaan, 'txt_estimasi_proyek':txt_estimasi_proyek, 'txt_durasi_pendanaan':txt_durasi_pendanaan, 'txt_pembayaran_pendanaan':txt_pembayaran_pendanaan, 'txt_metode_pembayaran_pendanaan':txt_metode_pembayaran_pendanaan, 'txt_detail_pendanaan':txt_detail_pendanaan, 'type_pendanaan_select':type_pendanaan_select,
                                    //jenis jaminan
                                    'jaminan':jaminan_arr,
                                    // persyaratan
                                    'persyaratan_arr' : persyaratan_arr,
                                    'persyaratan_non_arr' : persyaratan_non_arr
                                    },
                                    
                                    success: function (response) {
                                        var obj = jQuery.parseJSON( response );
                                        if(obj.status == "sukses"){
                                            Swal.fire({
                                              position: 'center',
                                              icon: 'success',
                                              title: 'Proses Berhasil, Kami Akan Segera Menghubungi Anda',
                                              showConfirmButton: false,
                                              timer: 3500
                                            })
                                            
                                            location.href = "/borrower/dashboardPendanaan";
                                        }
                                        
                                    }
                                });
                            }
                            
                            
                        }
                        
                        else if(type_borrower == "Perusahaan / Badan Hukum"){
                            
                            typeBorrower += 2; // Perusahaan Badan Hukum
                            $.ajax({
                                url: "{{route('borrower.action_lengkapi_profile')}}",
                                type: "POST",
                                data:  {"_token": "{{ csrf_token() }}", 'type_borrower':typeBorrower,
                                'txt_nm_bdn_hukum':txt_nm_bdn_hukum,'txt_npwp_bdn_hukum':txt_npwp_bdn_hukum,'txt_nm_anda_bdn_hukum':txt_nm_anda_bdn_hukum,'txt_nik_anda_bdn_hukum':txt_nik_anda_bdn_hukum,
                                'txt_notlp_anda_bdn_hukum':txt_notlp_anda_bdn_hukum,'txt_jabatan_anda_bdn_hukum':txt_jabatan_anda_bdn_hukum,
                                //pengurus
                                'txt_nm_pengurus_bdn_hukum':txt_nm_pengurus_bdn_hukum,'txt_nik_pengurus_bdn_hukum':txt_nik_pengurus_bdn_hukum,'txt_notlp_pengurus_bdn_hukum':txt_notlp_pengurus_bdn_hukum,'txt_jabatan_pengurus_bdn_hukum':txt_jabatan_pengurus_bdn_hukum,
                                
                                'txt_alamat_bdn_hukum':txt_alamat_bdn_hukum,'txt_provinsi_bdn_hukum':txt_provinsi_bdn_hukum,'txt_kota_bdn_hukum':txt_kota_bdn_hukum,'txt_kecamatan_bdn_hukum':txt_kecamatan_bdn_hukum,'txt_kelurahan_bdn_hukum':txt_kelurahan_bdn_hukum,
                                
                                'txt_kd_pos_bdn_hukum':txt_kd_pos_bdn_hukum,'txt_bd_pekerjaan_bdn_hukum':txt_bd_pekerjaan_bdn_hukum,
                                'txt_revenueB_bdn_hukum':txt_revenueB_bdn_hukum,'txt_bpo_bdn_hukum':txt_bpo_bdn_hukum,
                                'txt_asset_bdn_hukum':txt_asset_bdn_hukum,
                                
                                // foto
                                "url_pic_brw_bdn_hukum":url_pic_brw_bdn_hukum, "url_pic_brw_ktp_bdn_hukum" : url_pic_brw_ktp_bdn_hukum, "url_pic_brw_dengan_ktp_bdn_hukum":url_pic_brw_dengan_ktp_bdn_hukum,
                                "url_pic_brw_npwp_bdn_hukum":url_pic_brw_npwp_bdn_hukum,
                                // bank
                                "txt_nm_pemilik_rekening_bdn_hukum":txt_nm_pemilik_rekening_bdn_hukum, "txt_no_rekening_bdn_hukum" : txt_no_rekening_bdn_hukum, "txt_bank_bdn_hukum":txt_bank_bdn_hukum,
                                // pendanaan
                                'type_pendanaan_select_bdn_hukum':type_pendanaan_select_bdn_hukum,'txt_nm_pendanaan':txt_nm_pendanaan, 'txt_jenis_akad_pendanaan':txt_jenis_akad_pendanaan, 'txt_dana_pendanaan':txt_dana_pendanaan, 'txt_estimasi_proyek':txt_estimasi_proyek, 'txt_durasi_pendanaan':txt_durasi_pendanaan, 'txt_pembayaran_pendanaan':txt_pembayaran_pendanaan, 'txt_metode_pembayaran_pendanaan':txt_metode_pembayaran_pendanaan, 'txt_detail_pendanaan':txt_detail_pendanaan,
                                //jenis jaminan
                                'jaminan':jaminan_arr,
                                // persyaratan
                                'persyaratan_arr' : persyaratan_arr,
                                'persyaratan_non_arr' : persyaratan_non_arr
                                },
                                
                                success: function (response) {
                                    
                                    
                                    var obj = jQuery.parseJSON( response );
                                    if(obj.status == "sukses"){
                                        Swal.fire({
                                          position: 'center',
                                          icon: 'success',
                                          title: 'Proses Berhasil, Kami Akan Segera Menghubungi Anda',
                                          showConfirmButton: false,
                                          timer: 3500
                                        })
                                        
                                        location.href = "/borrower/dashboardPendanaan";
                                    }
                                }
                            });
                            
                            
                        }
                        
                        else if(type_borrower == "Pribadi - Wirausaha"){
                            
                            typeBorrower += 3; // perorangan Wirausaha
                            
                            if(txt_sts_nikah_pribadi != 1 && age < 18){
                                
                                //alert(age + ' Tolak Karna Usia Masi Kecil terus belom nikah');
                                Swal.fire({
                                    position: 'center',
                                    icon: 'failed',
                                    title: 'Maaf proses anda ditolak karna usia anda masih kecil dan belum menikah',
                                    showConfirmButton: false,
                                    timer: 3500
                                })
                                
                            }else{
                                $.ajax({
                                    url: "{{route('borrower.action_lengkapi_profile')}}",
                                    type: "POST",
                                    data:  {"_token": "{{ csrf_token() }}", 'type_borrower':typeBorrower, 'txt_nm_pengguna_pribadi':txt_nm_pengguna_pribadi, 'txt_nm_ibu_pribadi':txt_nm_ibu_pribadi, 'txt_pendidikanT_pribadi':txt_pendidikanT_pribadi, 'txt_no_ktp_pribadi':txt_no_ktp_pribadi, 'txt_npwp_pribadi':txt_npwp_pribadi, 'txt_notlp_pribadi':txt_notlp_pribadi, 'txt_tmpt_lahir_pribadi':txt_tmpt_lahir_pribadi, 'txt_hari_pribadi':txt_hari_pribadi, 'txt_bulan_pribadi':txt_bulan_pribadi, 'txt_tahun_pribadi':txt_tahun_pribadi, 'txt_jns_kelamin':txt_jns_kelamin, 'txt_agama':txt_agama, 'txt_sts_nikah_pribadi':txt_sts_nikah_pribadi,
                                    // ahli waris
                                    'txt_nm_aw_pribadi': txt_nm_aw_pribadi,'txt_nik_aw_pribadi':txt_nik_aw_pribadi, 'txt_notlp_aw_pribadi':txt_notlp_aw_pribadi, 'txt_email_aw_pribadi':txt_email_aw_pribadi,'txt_provinsi_aw_pribadi':txt_provinsi_aw_pribadi, 'txt_kota_aw_pribadi':txt_kota_aw_pribadi,'txt_kecamatan_aw_pribadi':txt_kecamatan_aw_pribadi,'txt_kelurahan_aw_pribadi':txt_kelurahan_aw_pribadi, 'txt_alamat_aw_pribadi':txt_alamat_aw_pribadi, 'txt_kode_pos_aw_pribadi':txt_kode_pos_aw_pribadi,
                                    // alamat ktp
                                    'txt_alamat_pribadi':txt_alamat_pribadi, 'txt_provinsi_pribadi':txt_provinsi_pribadi, 'txt_kota_pribadi':txt_kota_pribadi, 'txt_kd_pos_pribadi':txt_kd_pos_pribadi, 'txt_kecamatan_pribadi':txt_kecamatan_pribadi, 'txt_kelurahan_pribadi':txt_kelurahan_pribadi,
                                    // alamat domisili
                                    'txt_alamat_domisili_pribadi':txt_alamat_domisili_pribadi, 'txt_provinsi_domisili_pribadi':txt_provinsi_domisili_pribadi, 'txt_kota_domisili_pribadi':txt_kota_domisili_pribadi, 'txt_kecamatan_domisili_pribadi':txt_kecamatan_domisili_pribadi,'txt_kelurahan_domisili_pribadi':txt_kelurahan_domisili_pribadi,'txt_kd_pos_domisili_pribadi':txt_kd_pos_domisili_pribadi,

                                    'txt_sts_rmh_pribadi':txt_sts_rmh_pribadi, 'txt_pekerjaan_pribadi':txt_pekerjaan_pribadi, 'txt_bd_pekerjaan_pribadi':txt_bd_pekerjaan_pribadi, 'txt_bd_pekerjaanO_pribadi':txt_bd_pekerjaanO_pribadi, 'txt_pengalaman_kerja_pribadi':txt_pengalaman_kerja_pribadi, 'txt_pendapatan_bulanan_pribadi':txt_pendapatan_bulanan_pribadi, 
                                    // foto
                                    "url_pic_brw":url_pic_brw, "url_pic_brw_ktp" : url_pic_brw_ktp, "url_pic_brw_dengan_ktp":url_pic_brw_dengan_ktp,"url_pic_brw_npwp":url_pic_brw_npwp,
                                    // bank
                                    "txt_nm_pemilik":txt_nm_pemilik, "txt_no_rekening" : txt_no_rekening, "txt_bank":txt_bank,
                                    // pendanaan
                                    'txt_nm_pendanaan':txt_nm_pendanaan, 'txt_jenis_akad_pendanaan':txt_jenis_akad_pendanaan, 'txt_dana_pendanaan':txt_dana_pendanaan, 'txt_estimasi_proyek':txt_estimasi_proyek, 'txt_durasi_pendanaan':txt_durasi_pendanaan, 'txt_pembayaran_pendanaan':txt_pembayaran_pendanaan,'txt_metode_pembayaran_pendanaan':txt_metode_pembayaran_pendanaan, 'txt_detail_pendanaan':txt_detail_pendanaan, 'type_pendanaan_select':type_pendanaan_select,
                                    //jenis jaminan
                                    'jaminan':jaminan_arr,
                                    // persyaratan
                                    'persyaratan_arr' : persyaratan_arr,
                                    'persyaratan_non_arr' : persyaratan_non_arr
                                    },
                                    
                                    success: function (response) {
                                        var obj = jQuery.parseJSON( response );
                                        if(obj.status == "sukses"){
                                            Swal.fire({
                                              position: 'center',
                                              icon: 'success',
                                              title: 'Proses Berhasil, Kami Akan Segera Menghubungi Anda',
                                              showConfirmButton: false,
                                              timer: 3500
                                            })
                                            
                                            location.href = "/borrower/dashboardPendanaan";
                                        }
                                        
                                    }
                                });
                            }
                            
                        }
                        $('#otp').modal('show');
                    }
                    else
                    {
                        $('#alertError').css('display','block').text(data.message)
                    }
                    
                }
            });
             
        })
		
		$("#btn_proses_lengkapi_profile").click(function(){
			
		});

      
    </script>
@endsection
    