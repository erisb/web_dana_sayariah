@extends('layouts.borrower.master')

@section('title', 'Edit Penerima Dana')

@section('content')
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div id="detect-screen" class="content-full-right">
            <div class="container">
                
                <div class="row">
                    <div id="col" class="col-12 col-md-12 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: 0em;" >Ubah Profil</h1>                    
                        </span>
                    </div>
                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-md-12 mt-5 pt-5">
                        <div class="row">
                            
                            <div class="col-12 col-md-12">
                                <!-- Progress Wizard 2 -->
                                <div class="js-wizard-simple block">
                                    <!-- Step Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-progress2-step1" data-toggle="tab">Ubah Profil</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-progress2-step2" data-toggle="tab">Ganti Kata Sandi</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" href="#wizard-progress2-step3" data-toggle="tab">Pengaturan Lain-lain</a>
                                        </li> -->
                                    </ul>
                                    <!-- END Step Tabs -->
                                    <!-- Form -->
                                    <form action="#" method="post">
                                        <!-- Steps Content -->
                                        <div class="block-content block-content-full tab-content" style="min-height: 274px;">
                                            <!-- Step 1 -->
                                            <div class="tab-pane active" id="wizard-progress2-step1" role="tabpanel">
                                                <!-- Pribadi -->
                                                <!-- <div class="dsiBgGreen mb-30" style="border-radius: 20px;">
                                                    <div class="bg-black-op-25" style="border-radius: 20px;">
                                                        <div class="content content-top content-full text-left p-20 pt-30" >
                                                            <h6 class="no-paddingTop font-w400 text-primary-light" style=" margin-block-end: 0em;" >DSI Member : </h6>                                    
                                                            <h6 class="no-paddingTop font-w400 text-primary-light float-right" style="fmargin-block-end: 0em;" > Lokasi : Jakarta Selatan</h6>                               
                                                            <h1 class="h3 text-white font-w700 mb-10">
                                                                Dani Akbar - <span class="badge badge-light"> Aktif </span> 
                                                            </h1>
                                                            
                                                            <hr style="border-color: #064F35;">
                                                            <p class="font-size-sm font-w600 mb-0">
                                                                <i class="fa fa-star mt-5 text-light" style="font-size: 1em;"></i>
                                                                <i class="fa fa-star mt-5 text-light" style="font-size: 1em;"></i>
                                                                <i class="fa fa-star mt-5 text-light" style="font-size: 1em;"></i>
                                                                <i class="fa fa-star-half-full mt-5 text-light" style="font-size: 1em;"></i>
                                                                <i class="fa fa-star-o mt-5 text-light" style="font-size: 1em;"></i>
                                                                <small class="text-light"> | Awesome Partner</small>
                                                            </p>
                                                            <p class="float-right text-primary-light font-w600">Member ID : X33321A12344</p>
                                                            <h2 class="h5 text-white-op">
                                                                Member with <a class="text-primary-light link-effect" href="/all_pendanaan_borrower">39 Project</a>
                                                            </h2>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- satuBaris -->
                                                <input type="hidden" id="id" value="{{$id}}">
                                                <input type="hidden" id="brw_type" value={{$brw_type}}>  
                                                <hr class="pb-5">
                                                <div id="layout-pribadi" class="layout" >
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Nama Pengguna</label>
                                                                            <input class="form-control" type="text" id="nama" name="wizard-progress2-namapengguna" placeholder="Masukkan Nama Anda...">  
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-ibukandung">Nama Ibu Kandung</label>
                                                                            <input class="form-control" type="text" id="ibukandung" name="ibukandung" placeholder="Masukkan Nama Ibu Kandung Anda...">  
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-pendidikanterakhir">Pendidikan Terakhir</label>
                                                                        <select class="form-control col-6" id="pendidikan_terakhir" name="pendidikan_terakhir">
                                                                            <!-- <option value="0">Pilih Pendidikan</option>
                                                                            <option value="1">SMP</option>
                                                                            <option value="2">SMA</option>
                                                                            <option value="2">Sarjana (S1)</option>
                                                                            <option value="2">Magister (S2)</option>
                                                                            <option value="2">Doctor (S3)</option> -->
                                                                        </select>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Nomor Kartu Tanda Penduduk (KTP)</label>
                                                                        <input class="form-control" type="number" id="ktp" name="wizard-progress2-ktp" placeholder="Masukkan nomor KTP">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Nomor NPWP</label>
                                                                        <input class="form-control " type="number" id="npwp" name="npwp" placeholder="Masukkan nomor NPWP">  
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-telepon">Nomor Telepon</label>
                                                                        <input class="form-control " type="number" id="telepon" name="telepon" placeholder="Masukkan nomor Telepon">  
                                                                    </div>
                                                                </div>   
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-tempatlahir">Tempat Lahir</label>
                                                                        <input class="form-control" type="text" id="tempat_lahir" name="wizard-progress2-tempatlahir" placeholder="Masukkan tempat lahir">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                    <div class="form-group col-12 col-md-4">
                                                                        <label for="wizard-progress2-npwp">Hari</label>
                                                                        <select class="form-control" id="tgl_lahir_hari" name="tgl_lahir_hari">
                                                                            <option value="0">Pilih hari</option>
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
                                                                        <label for="wizard-progress2-npwp">Bulan</label>
                                                                        <select class="form-control" id="tgl_lahir_bulan" name="tgl_lahir_bulan">
                                                                            <option value="0">Pilih Bulan</option>
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
                                                                        <label for="wizard-progress2-npwp">Tahun</label>
                                                                        <select class="form-control" id="tgl_lahir_tahun" name="tgl_lahir_tahun"></select>
                                                                    </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Jenis Kelamin</label>
                                                                        <div class="col-12">
                                                                            <select class="form-control" id="jns_kelamin" name="jns_kelamin">
                                                                                <option value="0">Pilih Jenis Kelamin</option>
                                                                                <option value="2">Perempuan</option>
                                                                                <option value="1">Laki-laki</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Agama</label>
                                                                        <div class="col-12">
                                                                            <select class="form-control" id="agama" name="agama"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Status Perkawinan</label>
                                                                        <div class="col-12">
                                                                            <select class="form-control" id="status_kawin" name="status_kawin"></select>
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
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Provinsi</label>
                                                                                <select class="form-control" id="provinsi" name="provinsi">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota">Kota</label>
                                                                                <select class="form-control" id="kota" name="kota"></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kecamatan">Kecamatan</label>
                                                                                <input class="form-control" type="text" id="kecamatan" name="kecamatan" placeholder="Masukkan Kecamatan">  
                                                                            </div>
                                                                        </div> <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kelurahan">Kelurahan</label>
                                                                                <input class="form-control" type="text" id="kelurahan" name="kelurahan" placeholder="Masukkan Kelurahan">  
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kode_pos">Kode Pos</label>
                                                                                <input class="form-control" type="number" id="kode_pos" name="kode_pos" placeholder="Masukkan kode Pos">  
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris --> 
                                                                        <div class="col-md-9">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-alamat">Alamat Lengkap</label>
                                                                                <textarea class="form-control form-control-lg" id="alamat" name="alamat" rows="6" placeholder="Masukkan alamat lengkap Anda.."></textarea>
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="col-12">Status Kepemilikan Rumah</label>
                                                                                <div class="col-12">
                                                                                    <select class="form-control" id="status_rumah" name="status_rumah">
                                                                                        <option value="0">Pilih Status Rumah</option>
                                                                                        <option value="1">Milik Pribadi</option>
                                                                                        <option value="2">Kontrak / Sewa</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Ahli Waris</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namaahliwaris">Nama Ahli Waris</label>
                                                                                <input class="form-control" type="text" id="namaahliwaris" name="namaahliwaris" placeholder="Masukkan Nama Ahli Waris">  
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-nikahliwaris">NIK Ahli Waris</label>
                                                                                <input class="form-control" type="text" id="nikahliwaris" name="nikahliwaris" placeholder="Masukkan NIK Ahli waris">  
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-nohpahliwaris">No Hp Ahli Waris</label>
                                                                                <input class="form-control" type="number" id="nohpahliwaris" name="nohpahliwaris" placeholder="Masukkan No Hp">  
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris --> 
                                                                        <div class="col-md-9">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-alamatahliwaris">Alamat Sesuai KTP</label>
                                                                                <textarea class="form-control form-control-lg" id="alamatahliwaris" name="alamatahliwaris" rows="6" placeholder="Masukkan alamat lengkap Anda.."></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-provinsiahliwaris">Provinsi</label>
                                                                                <select class="form-control" id="provinsiahliwaris" name="provinsiahliwaris"></select>  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kotaahliswaris">Kota</label>
                                                                                <select class="form-control" id="kotaahliwaris" name="kotaahliwaris"></select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kecamatanahliwaris">Kecamatan</label>
                                                                                <input class="form-control" type="text" id="kecamatanahliwaris" name="kecamatanahliwaris" placeholder="Masukkan Kecamatan">  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kelurahanahliawaris">Kelurahan</label>
                                                                                <input class="form-control" type="text" id="kelurahanahliwaris" name="kelurahanahliwaris" placeholder="Masukkan Kelurahan">  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kodeposahliawaris">Kode Pos</label>
                                                                                <input class="form-control" type="number" id="kodeposahliwaris" name="kodeposahliwaris" placeholder="Masukkan kode Pos">  
                                                                            </div>
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->

                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Foto Diri</h6>
                                                            <div class="form-row">
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_diri">
                                                                        <label class="font-weight-bold">Foto Diri</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic) !== null ? asset('/storage').'/'.$brw_pic : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_investor"> -->
                                                                        <div id="camera_foto_diri">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- OLD start Source code -->
                                                                <!-- <div id="take_camera_foto_diri" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_diri"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-9">
                                                                            <div id="my_camera_foto"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_diri()">
                                                                            <input type="hidden" name="image_foto_diri" id="user_foto_diri" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw" id="url_pic_brw">
                                                                            <input type="hidden" name="brw_pic" id="brw_pic" value="{{$brw_pic}}">
                                                                            <div id="cancel_foto_diri">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <!-- OLD end Source code -->
                                                                <div id="take_camera_foto_diri" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/user-guide.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 185px; top: 22px;">
                                                                            <div id="my_camera_foto"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_diri()">
                                                                            <input type="hidden" name="image_foto_diri" id="user_foto_diri" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw" id="url_pic_brw">
                                                                            <input type="hidden" name="brw_pic" id="brw_pic" value="{{$brw_pic}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_diri"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_ktp">
                                                                        <label class="font-weight-bold">Foto KTP</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic_ktp) !== null ? asset('/storage').'/'.$brw_pic_ktp : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_ktp_investor"> -->
                                                                        <div id="camera_foto_ktp">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- OLD Start Source code -->
                                                                <!-- <div id="take_camera_foto_ktp" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto KTP</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_ktp"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-6">
                                                                            <div id="my_camera_ktp"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp()">
                                                                            <input type="hidden" name="image_foto_ktp" id="user_foto_ktp" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_ktp" id="url_pic_brw_ktp">
                                                                            <input type="hidden" name="brw_pic_ktp" id="brw_pic_ktp" value="{{$brw_pic_ktp}}">
                                                                            <div id="cancel_foto_ktp">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <!-- OLD End Source code -->
                                                                <div id="take_camera_foto_ktp" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto KTP</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                            <div id="my_camera_ktp"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp()">
                                                                            <input type="hidden" name="image_foto_ktp" id="user_foto_ktp" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_ktp" id="url_pic_brw_ktp">
                                                                            <input type="hidden" name="brw_pic_ktp" id="brw_pic_ktp" value="{{$brw_pic_ktp}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_ktp"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_ktp_diri"> 
                                                                        <label class="font-weight-bold" style="width: 204px;">Foto Diri dengan KTP</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic_user_ktp) !== null ? asset('/storage').'/'.$brw_pic_user_ktp : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_user_ktp_investor"> -->
                                                                        <div id="camera_foto_ktp_diri">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- OLD Start Source code -->
                                                                <!-- <div id="take_camera_foto_ktp_diri" style="display: none;">
                                                                    <div class="col-sm-9 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri dengan KTP</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_ktp_diri"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-9">
                                                                            <div id="my_camera_ktp_diri"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_diri()">
                                                                            <input type="hidden" name="image_foto_ktp_diri" id="user_foto_ktp_diri" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_dengan_ktp" id="url_pic_brw_dengan_ktp">
                                                                            <input type="hidden" name="brw_pic_user_ktp" id="brw_pic_user_ktp" value="{{$brw_pic_user_ktp}}">
                                                                            <div id="cancel_foto_ktp_diri">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <!-- OLD End Source code -->
                                                                <div id="take_camera_foto_ktp_diri" style="display: none;">
                                                                    <div class="col-sm-9 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri dengan KTP</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/guide-diridanktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                            <div id="my_camera_ktp_diri"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_diri()">
                                                                            <input type="hidden" name="image_foto_ktp_diri" id="user_foto_ktp_diri" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_dengan_ktp" id="url_pic_brw_dengan_ktp">
                                                                            <input type="hidden" name="brw_pic_user_ktp" id="brw_pic_user_ktp" value="{{$brw_pic_user_ktp}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_ktp_diri"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_npwp"> 
                                                                        <label class="font-weight-bold" style="width: 204px;">Foto NPWP</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic_npwp) !== null ? asset('/storage').'/'.$brw_pic_npwp : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_user_ktp_investor"> -->
                                                                        <div id="camera_foto_npwp">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div id="take_camera_foto_npwp" style="display: none;">
                                                                    <div class="col-sm-9 imgUp">
                                                                        <label class="font-weight-bold">Foto NPWP</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_npwp"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-6">
                                                                            <div id="my_camera_npwp"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_npwp()">
                                                                            <input type="hidden" name="image_foto_npwp" id="user_foto_npwp" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_npwp" id="url_pic_brw_npwp">
                                                                            <input type="hidden" name="brw_pic_npwp" id="brw_pic_npwp" value="{{$brw_pic_npwp}}">
                                                                            <div id="cancel_foto_npwp">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <div id="take_camera_foto_npwp" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto NPWP</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                            <div id="my_camera_npwp"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_npwp()">
                                                                            <input type="hidden" name="image_foto_npwp" id="user_foto_npwp" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_npwp" id="url_pic_brw_npwp">
                                                                            <input type="hidden" name="brw_pic_npwp" id="brw_pic_npwp" value="{{$brw_pic_npwp}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_npwp"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p>Format file .jpg, .jpeg, .gif, dan .png</p>


                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Rekening</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapemilikrekening">Nama Pemilik Rekening</label>
                                                                                <input class="form-control" type="text" id="namapemilikrekening" name="namapemilikrekening" placeholder="Masukkan Nama Pemilik Rekening">  
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-norekening">No Rekening</label>
                                                                                <input class="form-control" type="number" id="norekening" name="norekening" placeholder="Masukkan No Rekening">  
                                                                            </div>
                                                                        </div>  
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-bank">Bank</label>
                                                                                <select class="form-control" id="bank" name="bank"></select>  
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
                                                                                <label for="wizard-progress2-pekerjaan">Pekerjaan</label>
                                                                                <select class="form-control" id="pekerjaan" name="pekerjaan">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-bidang_pekerjaan">Bidang Pekerjaan</label>
                                                                                    <select class="form-control" id="bidang_pekerjaan" name="bidang_pekerjaan">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-bidang_online">Bidang Pekerjaan Online</label>
                                                                                <select class="form-control" id="bidang_online" name="bidang_online"></select>
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris -->  
                                                                    </div>
                                                                    <div class="row mb-20">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-pengalamankerja">Pengalaman Kerja</label>
                                                                                <select class="form-control" id="pengalaman_kerja" name="pengalaman_kerja">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-pendapatan_bulanan">Pendapatan Bulanan</label>
                                                                                <select class="form-control" id="pendapatan_bulanan" name="pendapatan_bulanan">
                                                                                </select>
                                                                            </div>
                                                                        </div> 
                                                                        <!-- satuBaris -->  
                                                                        <div class="col-md-12">
                                                                            <div class="float-right">
                                                                            <button type="button" class="btn btn-rounded btn-big btn-noborder btn-success min-width-150 mt-20 mb-20" id="btnsubmitpribadi"><span class="p-5">Simpan</span></button>
                                                                            </div>
                                                                        </div>   
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Badan Hukum -->
                                                <div id="layout-badanhukum" class="layout">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namabadanhukum">Nama Badan Hukum</label>
                                                                            <input class="form-control" type="text" id="nm_bdn_hukum" name="wizard-progress2-namabadanhukum" placeholder="Masukkan Nama Perusahaan anda...">  
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-npwp">Nomor NPWP</label>
                                                                        <input class="form-control" type="text" id="npwp_bdn_hukum" name="wizard-progress2-npwp" placeholder="Masukkan nomor NPWP">  
                                                                    </div>
                                                                </div>  
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-nama_pendaftar">Nama Pendaftar</label>
                                                                        <input class="form-control" type="text" id="nama_pendaftar" name="nama_pendaftar" placeholder="Masukkan Nama Pendaftar">  
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-nikPendaftar">NIK</label>
                                                                        <input class="form-control" type="text" id="nikPendaftar" name="nikPendaftar" placeholder="Masukkan NIK">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-hpPendaftar">No Handphone</label>
                                                                        <input class="form-control" type="number" id="hpPendaftar" name="hpPendaftar" placeholder="Masukkan No Handphone">  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-jabatanPendaftar">Jabatan</label>
                                                                        <input class="form-control" type="text" id="jabatanPendaftar" name="jabatanPendaftar" placeholder="Masukkan Jabatan">  
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
                                                                                                <input class="form-control" type="text" id="namapengurus" name="namapengurus" placeholder="Masukkan nama pengurus...">  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nikpengurus">NIK</label>
                                                                                                <input class="form-control" type="text" id="nikpengurus" name="nikpengurus" placeholder="Masukkan NIK pengurus...">  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-teleponpengurus">No Telepon / HP</label>
                                                                                                <input class="form-control" type="number" id="teleponpengurus" name="teleponpengurus" placeholder="Masukkan nomor telepon">  
                                                                                            </div>
                                                                                        </div> 
                                                                                        <div class="col-md-5">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-jabatanpengurus">Jabatan</label>
                                                                                                <input class="form-control" type="text" id="jabatanpengurus" name="jabatanpengurus" placeholder="Masukkan Jabatan Pengurus">  
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                 
                                                                            </div>
                                                                        </div>
                                                                        <!-- new row -->
                                                                        <!-- <div class="col-12">
                                                                            <button type="button" class="btn btn-rounded btn-primary btn-dsi min-width-200 mb-10 push-right" onclick="add_penanggung_jawab()">Tambah Pengurus</button>
                                                                        </div> -->
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->

                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Foto Diri</h6>
                                                            <div class="form-row">
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_diri_bdn_hukum">
                                                                        <label class="font-weight-bold">Foto Diri</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic) !== null ? asset('/storage').'/'.$brw_pic : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_investor"> -->
                                                                        <div id="camera_foto_diri_bdn_hukum">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- OLD Start Source code -->
                                                                <!-- <div id="take_camera_foto_diri_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_diri_bdn_hukum"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-9">
                                                                            <div id="my_camera_foto_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_diri_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_diri_bdn_hukum" id="user_foto_diri_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_bdn_hukum" id="url_pic_brw_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic" id="brw_pic" value="{{$brw_pic}}">
                                                                            <div id="cancel_foto_diri_bdn_hukum">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <!-- OLD End Start Source code -->
                                                                <div id="take_camera_foto_diri_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/user-guide.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 185px; top: 22px;">
                                                                            <div id="my_camera_foto_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_diri_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_diri_bdn_hukum" id="user_foto_diri_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_bdn_hukum" id="url_pic_brw_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic_bdn_hukum" id="brw_pic_bdn_hukum" value="{{$brw_pic}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_diri_bdn_hukum"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_ktp_bdn_hukum">
                                                                        <label class="font-weight-bold">Foto KTP</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic_ktp) !== null ? asset('/storage').'/'.$brw_pic_ktp : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_ktp_investor"> -->
                                                                        <div id="camera_foto_ktp_bdn_hukum">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- OLD Start Source Code -->
                                                                <!-- <div id="take_camera_foto_ktp_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto KTP</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_ktp_bdn_hukum"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-6">
                                                                            <div id="my_camera_ktp_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_ktp_bdn_hukum" id="user_foto_ktp_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_ktp_bdn_hukum" id="url_pic_brw_ktp_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic_ktp" id="brw_pic_ktp" value="{{$brw_pic_ktp}}">
                                                                            <div id="cancel_foto_ktp_bdn_hukum">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <!-- OLD End Source Code -->
                                                                <div id="take_camera_foto_ktp_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-6 imgUp">
                                                                        <label class="font-weight-bold">Foto KTP</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                            <div id="my_camera_ktp_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_ktp_bdn_hukum" id="user_foto_ktp_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_ktp_bdn_hukum" id="url_pic_brw_ktp_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic_ktp_bdn_hukum" id="brw_pic_ktp_bdn_hukum" value="{{$brw_pic_ktp}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_ktp_bdn_hukum"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_ktp_diri_bdn_hukum"> 
                                                                        <label class="font-weight-bold" style="width: 204px;">Foto Diri dengan KTP</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic_user_ktp) !== null ? asset('/storage').'/'.$brw_pic_user_ktp : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_user_ktp_investor"> -->
                                                                        <div id="camera_foto_ktp_diri_bdn_hukum">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- OLD Start Source Code -->
                                                                <!-- <div id="take_camera_foto_ktp_diri_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-9 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri dengan KTP</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_ktp_diri_bdn_hukum"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-9">
                                                                            <div id="my_camera_ktp_diri_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_diri_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_ktp_diri_bdn_hukum" id="user_foto_ktp_diri_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_dengan_ktp_bdn_hukum" id="url_pic_brw_dengan_ktp_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic_user_ktp" id="brw_pic_user_ktp" value="{{$brw_pic_user_ktp}}">
                                                                            <div id="cancel_foto_ktp_diri_bdn_hukum">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <!-- OLD End Source Code -->
                                                                <div id="take_camera_foto_ktp_diri_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-9 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri dengan KTP</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/guide-diridanktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                            <div id="my_camera_ktp_diri_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_diri_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_ktp_diri_bdn_hukum" id="user_foto_ktp_diri_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_dengan_ktp_bdn_hukum" id="url_pic_brw_dengan_ktp_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic_user_ktp_bdn_hukum" id="brw_pic_user_ktp_bdn_hukum" value="{{$brw_pic_user_ktp}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_ktp_diri_bdn_hukum"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 imgUp">
                                                                    <div id="foto_npwp_bdn_hukum"> 
                                                                        <label class="font-weight-bold" style="width: 204px;">Foto NPWP</label>
                                                                        <img class="imagePreview" src="{{ !empty($brw_pic_npwp) !== null ? asset('/storage').'/'.$brw_pic_npwp : ''}}">
                                                                        <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_user_ktp_investor"> -->
                                                                        <div id="camera_foto_npwp_bdn_hukum">
                                                                            <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div id="take_camera_foto_npwp_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-9 imgUp">
                                                                        <label class="font-weight-bold">Foto NPWP</label>
                                                                        <div class="col-md-6">
                                                                            <div id="results_foto_npwp_bdn_hukum"></div>
                                                                        </div><br/>
                                                                        <div class="col-md-6">
                                                                            <div id="my_camera_npwp_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_npwp_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_npwp_bdn_hukum" id="user_foto_npwp_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_npwp_bdn_hukum" id="url_pic_brw_npwp_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic_npwp" id="brw_pic_npwp" value="{{$brw_pic_npwp}}">
                                                                            <div id="cancel_foto_npwp_bdn_hukum">
                                                                                <label class="btn btn-danger" style="width:100px;margin-left:0px">Batal</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <div id="take_camera_foto_npwp_bdn_hukum" style="display: none;">
                                                                    <div class="col-sm-9 imgUp">
                                                                        <label class="font-weight-bold">Foto Diri dengan KTP</label>
                                                                        <div class="col-md-6">
                                                                            <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 150px; top: 22px;">
                                                                            <div id="my_camera_npwp_bdn_hukum"></div>
                                                                            <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_npwp_bdn_hukum()">
                                                                            <input type="hidden" name="image_foto_npwp_bdn_hukum" id="user_foto_npwp_bdn_hukum" class="image-tag"><br/><br/>
                                                                            <input type="hidden" name="url_pic_brw_npwp_bdn_hukum" id="url_pic_brw_npwp_bdn_hukum">
                                                                            <input type="hidden" name="brw_pic_npwp_bdn_hukum" id="brw_pic_npwp_bdn_hukum" value="{{$brw_pic_npwp}}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="font-weight-bold">Hasil</label>
                                                                            <div id="results_foto_npwp_bdn_hukum"></div>
                                                                        </div><br/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p>Format file .jpg, .jpeg, .gif, dan .png</p>

                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Rekening</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapemilikrekening_bdnhkm">Nama Pemilik Rekening</label>
                                                                                <input class="form-control" type="text" id="namapemilikrekening_bdnhkm" name="namapemilikrekening_bdnhkm" placeholder="Masukkan Nama Pemilik Rekening">  
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-norekening_bdnhkm">No Rekening</label>
                                                                                <input class="form-control" type="number" id="norekening_bdnhkm" name="norekening_bdnhkm" placeholder="Masukkan No Rekening">  
                                                                            </div>
                                                                        </div>  
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-bank">Bank</label>
                                                                                <select class="form-control" id="bank_bdnhkm" name="bank_bdnhkm"></select>  
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Informasi Lokasi Kantor</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <!-- satuBaris -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-provinsi_bdn_hukum">Provinsi</label>
                                                                                    <select class="form-control" id="provinsi_bdn_hukum" name="provinsi_bdn_hukum">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kota_bdn_hukum">Kota</label>
                                                                                    <select class="form-control" id="kota_bdn_hukum" name="kota_bdn_hukum">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kecamatan_bdn_hukum">Kecamatan</label>
                                                                                <input class="form-control" type="text" id="kecamatan_bdn_hukum" name="kecamatan_bdn_hukum" placeholder="Masukkan Kecamatan">  
                                                                            </div>
                                                                        </div> 
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kelurahan_bdn_hukum">Kelurahan</label>
                                                                                    <input class="form-control" type="text" id="kelurahan_bdn_hukum" name="kelurahan_bdn_hukum" placeholder="Masukkan Kelurahan">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-kodepos_bdn_hukum">Kode Pos</label>
                                                                                <input class="form-control" type="number" id="kodepos_bdn_hukum" name="kodepos_bdn_hukum" placeholder="Masukkan kode Pos">  
                                                                            </div>
                                                                        </div>  
                                                                        <!-- satuBaris --> 
                                                                        <div class="col-md-9">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-alamat_bdn_hukum">Alamat Lengkap</label>
                                                                                <textarea class="form-control form-control-lg" id="alamat_bdn_hukum" name="alamat_bdn_hukum" rows="6" placeholder="Masukkan alamat lengkap Anda.."></textarea>
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
                                                                                <select class="form-control" id="bidang_pekerjaan_bdn_hukum" name="bidang_pekerjaan_bdn_hukum">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-namapengguna">Bidang Pekerjaan Online</label>
                                                                                <select class="form-control" id="bidang_online_bdn_hukum" name="bidang_online_bdn_hukum">
                                                                                </select> 
                                                                            </div>
                                                                        </div>  
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-revenue">Revenue Bulanan</label>
                                                                                <select class="form-control" id="pendapatan_bdn_hukum" name="pendapatan_bdn_hukum">
                                                                                </select> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="wizard-progress2-aset">Total Aset</label>
                                                                                <input class="form-control" type="number" id="total_aset" name="total_aset" placeholder="Masukkan Total aset">  
                                                                            </div>
                                                                        </div>
                                                                        <!-- satuBaris -->      
                                                                        <div class="col-md-12">
                                                                            <div class="float-right">
                                                                            <button type="button" id='btnSubmitBdnHukum' class="btn btn-rounded btn-big btn-noborder btn-success min-width-150 mt-20 mb-20"><span class="p-5">Simpan</span></button>
                                                                            </div>
                                                                        </div>                                                                    
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Step 1 -->
                                            <!-- <form action="{{ route('ubah.proses') }}" method="POST"> 
                                            @csrf -->
                                            <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <!-- notif  -->
                                                        <div class="alert alert-success text-center p-10 h5 text-success" id="notifg" role="alert">
                                                            Kata Sandi Gagal di Ganti
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    <!-- notif -->
                                                        <div class="form-group">
                                                            <label for="install-admin-email">Kata Sandi Lama</label>
                                                            <input type="hidden" id="id" value="{{$id}}">
                                                            <input type="password" id="passwordlama" class="form-control form-control-lg" placeholder="Kata Sandi lama...">
                                                        </div>
                                                        <hr>
                                                        <div class="form-group mb-30">
                                                            <label for="side-overlay-profile-password">Kata Sandi Baru</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control notallowCharacter" id="side-overlay-profile-password" name="side-overlay-profile-password" placeholder="Kata Sandi Baru.." disabled>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-asterisk"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-15">
                                                            <label for="side-overlay-profile-password-confirm">Konfirmasi Sandi Baru <span id='message'></span></label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" id="side-overlay-profile-password-confirm" name="side-overlay-profile-password-confirm" placeholder="Konfirmasi Kata Sandi.." disabled>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">
                                                                        <i class="fa fa-asterisk"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                        <div class="float-right">
                                                            <button type="button" class="btn btn-rounded btn-big btn-noborder btn-success min-width-150 mt-20 mb-20" id="btnsubmitpwd" disabled><span class="p-5">Simpan</span></button>
                                                        </div> 
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <!-- </form> -->
                                        </div>   
                                        
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script>
        $(document).ready(function(){
        $("#camera_foto_diri").click(function(){
            $("#take_camera_foto_diri").fadeIn();
            $("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
            $("#foto_diri").fadeOut();;
        });
        });

        $(document).ready(function(){
        $("#cancel_foto_diri").click(function(){
            $("#my_camera_foto").fadeIn();
            //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
            //$("#foto_diri").fadeOut();;
        });
        });

        $(document).ready(function(){
        $("#camera_foto_ktp").click(function(){
            $("#take_camera_foto_ktp").fadeIn();
            $("#take_camera_foto_ktp").css( { "margin-left" : "-290px"} );
            $("#foto_ktp").fadeOut();;
        });
        });

        $(document).ready(function(){
        $("#cancel_foto_ktp").click(function(){
            $("#my_camera_ktp").fadeIn();
            //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
            //$("#foto_diri").fadeOut();;
        });
        });

        $(document).ready(function(){
        $("#camera_foto_ktp_diri").click(function(){
            $("#take_camera_foto_ktp_diri").fadeIn();
            $("#take_camera_foto_ktp_diri").css( { "margin-left" : "-290px"} );
            $("#foto_ktp_diri").fadeOut();;
        });
        });

        $(document).ready(function(){
        $("#cancel_foto_ktp_diri").click(function(){
            $("#my_camera_ktp_diri").fadeIn();
            //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
            //$("#foto_diri").fadeOut();;
        });
        });

        $(document).ready(function(){
        $("#camera_foto_npwp").click(function(){
            $("#take_camera_foto_npwp").fadeIn();
            $("#take_camera_foto_npwp").css( { "margin-left" : "-290px"} );
            $("#foto_npwp").fadeOut();;
        });
        });

        $(document).ready(function(){
        $("#cancel_foto_npwp").click(function(){
            $("#my_camera_npwp").fadeIn();
            //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
            //$("#foto_diri").fadeOut();;
        });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#camera_foto_diri_bdn_hukum").click(function(){
                $("#take_camera_foto_diri_bdn_hukum").fadeIn();
                $("#take_camera_foto_diri_bdn_hukum").css( { "margin-left" : "-290px"} );
                $("#foto_diri_bdn_hukum").fadeOut();;
            });
        });

        $(document).ready(function(){
            $("#cancel_foto_diri_bdn_hukum").click(function(){
                $("#my_camera_foto_bdn_hukum").fadeIn();
                //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
                //$("#foto_diri").fadeOut();;
            });
        });

        $(document).ready(function(){
            $("#camera_foto_ktp_bdn_hukum").click(function(){
                $("#take_camera_foto_ktp_bdn_hukum").fadeIn();
                $("#take_camera_foto_ktp_bdn_hukum").css( { "margin-left" : "-290px"} );
                $("#foto_ktp_bdn_hukum").fadeOut();;
            });
        });

        $(document).ready(function(){
            $("#cancel_foto_ktp_bdn_hukum").click(function(){
                $("#my_camera_ktp_bdn_hukum").fadeIn();
                //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
                //$("#foto_diri").fadeOut();;
            });
        });

        $(document).ready(function(){
            $("#camera_foto_ktp_diri_bdn_hukum").click(function(){
                $("#take_camera_foto_ktp_diri_bdn_hukum").fadeIn();
                $("#take_camera_foto_ktp_diri_bdn_hukum").css( { "margin-left" : "-290px"} );
                $("#foto_ktp_diri_bdn_hukum").fadeOut();;
            });
        });

        $(document).ready(function(){
            $("#cancel_foto_ktp_diri_bdn_hukum").click(function(){
                $("#my_camera_ktp_diri_bdn_hukum").fadeIn();
                //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
                //$("#foto_diri").fadeOut();;
            });
        });

        $(document).ready(function(){
            $("#camera_foto_npwp_bdn_hukum").click(function(){
                $("#take_camera_foto_npwp_bdn_hukum").fadeIn();
                $("#take_camera_foto_npwp_bdn_hukum").css( { "margin-left" : "-290px"} );
                $("#foto_npwp_bdn_hukum").fadeOut();;
            });
        });

        $(document).ready(function(){
            $("#cancel_foto_npwp_bdn_hukum").click(function(){
                $("#my_camera_npwp_bdn_hukum").fadeIn();
                //$("#take_camera_foto_diri").css( { "margin-left" : "-290px"} );
                //$("#foto_diri").fadeOut();;
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
    
        Webcam.attach( '#my_camera_foto' );

        function take_snapshot_foto_diri()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_diri').value = data_uri;
                document.getElementById('results_foto_diri').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_foto").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var foto = data_uri;
                //var brw_pic = $("#brw_pic").val();
                $.ajax({

                    url : "/borrower/update_webcam_1",
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
    
        Webcam.attach( '#my_camera_ktp' );

        function take_snapshot_foto_ktp()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_ktp').value = data_uri;
                document.getElementById('results_foto_ktp').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_ktp").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp = data_uri;
                $.ajax({

                    url : "/borrower/update_webcam_2",
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
    
        Webcam.attach( '#my_camera_ktp_diri' );

        function take_snapshot_foto_ktp_diri()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_ktp_diri').value = data_uri;
                document.getElementById('results_foto_ktp_diri').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_ktp_diri").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp_diri = data_uri;
                $.ajax({

                    url : "/borrower/update_webcam_3",
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
    
        Webcam.attach( '#my_camera_npwp' );

        function take_snapshot_foto_npwp()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_npwp').value = data_uri;
                document.getElementById('results_foto_npwp').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_npwp").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var npwp = data_uri;
                $.ajax({

                    url : "/borrower/update_webcam_4",
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
        Webcam.set({
            width: 200,
            height: 200,
            image_format: 'jpg',
            jpeg_quality: 90
        });
    
        Webcam.attach( '#my_camera_foto_bdn_hukum' );

        function take_snapshot_foto_diri_bdn_hukum()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_diri_bdn_hukum').value = data_uri;
                document.getElementById('results_foto_diri_bdn_hukum').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_foto_bdn_hukum").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var foto = data_uri;
                //var brw_pic = $("#brw_pic").val();
                $.ajax({

                    url : "/borrower/update_webcam_1_bdn_hukum",
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
            image_format: 'jpg',
            jpeg_quality: 90
        });
    
        Webcam.attach( '#my_camera_ktp_bdn_hukum' );

        function take_snapshot_foto_ktp_bdn_hukum()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_ktp_bdn_hukum').value = data_uri;
                document.getElementById('results_foto_ktp_bdn_hukum').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_ktp_bdn_hukum").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp = data_uri;
                $.ajax({

                    url : "/borrower/update_webcam_2_bdn_hukum",
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
            image_format: 'jpg',
            jpeg_quality: 90
        });
    
        Webcam.attach( '#my_camera_ktp_diri_bdn_hukum' );

        function take_snapshot_foto_ktp_diri_bdn_hukum()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_ktp_diri_bdn_hukum').value = data_uri;
                document.getElementById('results_foto_ktp_diri_bdn_hukum').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_ktp_diri_bdn_hukum").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var ktp_diri = data_uri;
                $.ajax({

                    url : "/borrower/update_webcam_3_bdn_hukum",
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
            image_format: 'jpg',
            jpeg_quality: 90
        });
    
        Webcam.attach( '#my_camera_npwp_bdn_hukum' );

        function take_snapshot_foto_npwp_bdn_hukum()
        {
        
            Webcam.snap( function(data_uri) {
                document.getElementById('user_foto_npwp_bdn_hukum').value = data_uri;
                document.getElementById('results_foto_npwp_bdn_hukum').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
                //$("#my_camera_npwp_bdn_hukum").hide();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var npwp = data_uri;
                $.ajax({

                    url : "/borrower/update_webcam_4_bdn_hukum",
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
							$('#url_pic_brw_npwp_bdn_hukum').val(data.url);
						}else{
							alert(data.failed);
						}
                        
                    }
                });
            } );

        }
    </script>
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

        $(document).ready(function(){
            var id = '{{$id}}';
            var brw_type = '{{$brw_type}}';
            var nama = '{{$nama}}';
            var nm_bdn_hukum = "{{$nm_bdn_hukum}}";
            var jabatan = "{{$jabatan}}";
            var nm_ibu = "{{$nm_ibu}}";
            var ktp = "{{$ktp}}";
            var npwp = "{{$npwp}}";
            var tgl_lahir = "{{$tgl_lahir}}";
            var no_tlp = "{{$no_tlp}}";
            var jns_kelamin = "{{$jns_kelamin}}";
            var status_kawin = "{{$status_kawin}}";
            var status_rumah = "{{$status_rumah}}";
            var alamat = "{{$alamat}}";
            var domisili_alamat = "{{$domisili_alamat}}";
            var domisili_provinsi = "{{$domisili_provinsi}}";
            var domisili_kota = "{{$domisili_kota}}";
            var domisili_kecamatan = "{{$domisili_kecamatan}}";
            var domisili_kelurahan = "{{$domisili_kelurahan}}";
            var domisili_kd_pos = "{{$domisili_kd_pos}}";
            var provinsi = "{{$provinsi}}";
            var kota = "{{$kota}}";
            var kecamatan = "{{$kecamatan}}";
            var kelurahan = "{{$kelurahan}}";
            var kode_pos = "{{$kode_pos}}";
            var agama = "{{$agama}}";
            var tempat_lahir = "{{$tempat_lahir}}";
            var pendidikan_terakhir = "{{$pendidikan_terakhir}}";
            var pekerjaan = "{{$pekerjaan}}";
            var bidang_perusahaan = "{{$bidang_perusahaan}}";
            var bidang_pekerjaan = "{{$bidang_pekerjaan}}";
            var bidang_online = "{{$bidang_online}}";
            var pengalaman_pekerjaan = "{{$pengalaman_pekerjaan}}";
            var pendapatan = "{{$pendapatan}}";
            var total_aset = "{{$total_aset}}";
            var kewarganegaraan = "{{$kewarganegaraan}}";
            var brw_online = "{{$brw_online}}";
            var brw_pic = "{{$brw_pic}}";
            var brw_pic_ktp = "{{$brw_pic_ktp}}";
            var brw_pic_user_ktp= "{{$brw_pic_user_ktp}}";
            var brw_pic_npwp = "{{$brw_pic_npwp}}";
            
            //ahliwaris
            var nama_ahli_waris = "{{$nama_ahli_waris}}";
            var nik_ahli_waris = "{{$nik_ahli_waris}}";
            var no_tlp_ahli_waris = "{{$no_tlp_ahli_waris}}";
            var email_ahli_waris = "{{$email_ahli_waris}}";
            var provinsi_ahli_waris = "{{$provinsi_ahli_waris}}";
            var kota_ahli_waris = "{{$kota_ahli_waris}}";
            var kecamatan_ahli_waris = "{{$kecamatan_ahli_waris}}";
            var kelurahan_ahli_waris = "{{$kelurahan_ahli_waris}}";
            var kd_pos_ahli_waris = "{{$kd_pos_ahli_waris}}";
            var alamat_ahli_waris = "{{$alamat_ahli_waris}}";

            //rekening
            var brw_norek = "{{$brw_norek}}";
            var brw_nm_pemilik = "{{$brw_nm_pemilik}}";
            var brw_kd_bank = "{{$brw_kd_bank}}";

            //pengurus
            var nm_pengurus = "{{$nm_pengurus}}";
            var nik_pengurus = "{{$nik_pengurus}}";
            var no_tlppengurus = "{{$no_tlppengurus}}";
            var jabatanpengurus = "{{$jabatanpengurus}}";


            //rekening start
            $('#norekening').val(brw_norek);
            $('#namapemilikrekening').val(brw_nm_pemilik);
            $.getJSON("/admin/borrower/data_bank/", function(data_bank){
                for(var i = 0; i<data_bank.length; i++){
                    $('#bank').append($('<option>', { 
                        value: data_bank[i].id,
                        text : data_bank[i].text
                    }));
                }
                $("#bank option[value="+brw_kd_bank+"]").attr('selected', 'selected');
            });
            //end rekening

            //rekening_bdnhkm
            $('#norekening_bdnhkm').val(brw_norek);
            $('#namapemilikrekening_bdnhkm').val(brw_nm_pemilik);
            $.getJSON("/admin/borrower/data_bank/", function(data_bank){
                for(var i = 0; i<data_bank.length; i++){
                    $('#bank_bdnhkm').append($('<option>', { 
                        value: data_bank[i].id,
                        text : data_bank[i].text
                    }));
                }
                $("#bank_bdnhkm option[value="+brw_kd_bank+"]").attr('selected', 'selected');
            });
            //end rekening brw

            //start ahli waris
            
            $('#namaahliwaris').val(nama_ahli_waris);
            $('#nikahliwaris').val(nik_ahli_waris);
            $('#nohpahliwaris').val(no_tlp_ahli_waris);
            $('#alamatahliwaris').text(alamat_ahli_waris);
            $.getJSON("/borrower/data_kota/"+provinsi_ahli_waris+"", function(data_kota){
                for(var i = 0; i<data_kota.length; i++){
                    $('#kotaahliwaris').append($('<option>', { 
                        value: data_kota[i].id,
                        text : data_kota[i].text
                    }));
                }
                $("#kotaahliwaris option[value="+kota_ahli_waris+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_provinsi/", function(data_provinsi){
                for(var i = 0; i<data_provinsi.length; i++){
                    $('#provinsiahliwaris').append($('<option>', { 
                        value: data_provinsi[i].id,
                        text : data_provinsi[i].text
                    }));
                }
                $("#provinsiahliwaris option[value="+provinsi_ahli_waris+"]").attr('selected', 'selected');
            });

            $(function() {
					$('#provinsiahliwaris').change(function(){
						var provinsi_ahli_waris = $('#provinsiahliwaris option:selected').val();
						
						$("#kotaahliwaris").empty().trigger('change'); // set null
						$.getJSON("/borrower/data_kota/"+provinsi_ahli_waris, function(data_kota){
						//$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
					
							for(var i = 0; i<data_kota.length; i++){
						
								$('#kotaahliwaris').append($('<option>', { 
									value: data_kota[i].id,
									text : data_kota[i].text
									
								}));
							}
						});
					});
				});
                $('#kecamatanahliwaris').val(kecamatan_ahli_waris);
                $('#kelurahanahliwaris').val(kelurahan_ahli_waris);
                $('#kodeposahliwaris').val(kd_pos_ahli_waris);

            //end ahli waris

            if(brw_type == '2'){
                $("#layout-pribadi").attr('style',"display: none");
            }else{
                $("#layout-badanhukum").attr('style',"display: none");
            }
            $('#nama').val(nama);

            $.getJSON("/borrower/data_pendidikan/", function(data_pendidikan){
                for(var i = 0; i<data_pendidikan.length; i++){
                    $('#pendidikan_terakhir').append($('<option>', { 
                        value: data_pendidikan[i].id,
                        text : data_pendidikan[i].text
                    }));
                }
                $("#pendidikan_terakhir option[value="+pendidikan_terakhir+"]").attr('selected', 'selected');
            });

            
            $('#ibukandung').val(nm_ibu);
            $('#ktp').val(ktp);
            $('#npwp').val(npwp);
            $('#telepon').val(no_tlp);
            $('#tempat_lahir').val(tempat_lahir);

            // set tahun lahir
            var thn = document.getElementById('tgl_lahir_tahun');
            var minOffset = 17; maxOffset = 100; // Change to whatever you want
            var thisYear = new Date().getFullYear();
            var html_thn = '<option value="">Pilih Tahun</option>';
            for (i = new Date().getFullYear(); i > 1900; i--)
            {
                html_thn += '<option value='+i+'>'+i+'</option>';
            }
            thn.innerHTML = html_thn;
            split_tgl_lahir = tgl_lahir.split('-');
			$("#tgl_lahir_hari option[value="+split_tgl_lahir[0]+"]").attr('selected', 'selected');
			$("#tgl_lahir_bulan option[value="+split_tgl_lahir[1]+"]").attr('selected', 'selected');
			$("#tgl_lahir_tahun option[value="+split_tgl_lahir[2]+"]").attr('selected', 'selected');

			$("#jns_kelamin option[value="+jns_kelamin+"]").attr('selected', 'selected');

            $.getJSON("/borrower/agama/", function(data_agama){
                for(var i = 0; i<data_agama.length; i++){
                    $('#agama').append($('<option>', { 
                        value: data_agama[i].id_agama,
                        text : data_agama[i].agama
                    }));
                }
                $("#agama option[value="+agama+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/status_perkawinan/", function(data_status_perkawinan){
                for(var i = 0; i<data_status_perkawinan.length; i++){
                    $('#status_kawin').append($('<option>', { 
                        value: data_status_perkawinan[i].id,
                        text : data_status_perkawinan[i].text
                        
                    }));
                }
                $("#status_kawin option[value="+status_kawin+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_kota/"+provinsi+"", function(data_kota){
                for(var i = 0; i<data_kota.length; i++){
                    $('#kota').append($('<option>', { 
                        value: data_kota[i].id,
                        text : data_kota[i].text
                    }));
                }
                $("#kota option[value="+kota+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_provinsi/", function(data_provinsi){
                for(var i = 0; i<data_provinsi.length; i++){
                    $('#provinsi').append($('<option>', { 
                        value: data_provinsi[i].id,
                        text : data_provinsi[i].text
                    }));
                }
                $("#provinsi option[value="+provinsi+"]").attr('selected', 'selected');
            });

            $(function() {
					$('#provinsi').change(function(){
						var provinsi = $('#provinsi option:selected').val();
						
						$("#kota").empty().trigger('change'); // set null
						$.getJSON("/borrower/data_kota/"+provinsi, function(data_kota){
						//$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
					
							for(var i = 0; i<data_kota.length; i++){
						
								$('#kota').append($('<option>', { 
									value: data_kota[i].id,
									text : data_kota[i].text
									
								}));
							}
						});
					});
				});
            
                
            $('#kecamatan').val(kecamatan);
            $('#kelurahan').val(kelurahan);
            $('#kode_pos').val(kode_pos);
            $('#alamat').text(alamat);
            $("#status_rumah option[value="+status_rumah+"]").attr('selected', 'selected');

            $.getJSON("/borrower/data_pekerjaan/", function(data_pekerjaan){
                for(var i = 0; i<data_pekerjaan.length; i++){
                    $('#pekerjaan').append($('<option>', { 
                        value: data_pekerjaan[i].id,
                        text : data_pekerjaan[i].text   
                    }));
                }
                $("#pekerjaan option[value="+pekerjaan+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_bidang_pekerjaan/", function(data_bidang_pekerjaan){
                for(var i = 0; i<data_bidang_pekerjaan.length; i++){
                    $('#bidang_pekerjaan').append($('<option>', { 
                        value: data_bidang_pekerjaan[i].id,
                        text : data_bidang_pekerjaan[i].text
                        
                    }));
                }
                $("#bidang_pekerjaan option[value="+bidang_pekerjaan+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/bidang_pekerjaan_online/", function(data_bidang_online){
                for(var i = 0; i<data_bidang_online.length; i++){
                    $('#bidang_online').append($('<option>', { 
                        value: data_bidang_online[i].id,
                        text : data_bidang_online[i].text 
                    }));
                }
                $("#bidang_online option[value="+bidang_online+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_pengalaman_pekerjaan/", function(data_pengalaman){
                for(var i = 0; i<data_pengalaman.length; i++){
                    $('#pengalaman_kerja').append($('<option>', { 
                        value: data_pengalaman[i].id,
                        text : data_pengalaman[i].text 
                    }));
                }
                $("#pengalaman_kerja option[value="+pengalaman_pekerjaan+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_pendapatan/", function(data_pendapatan){
                for(var i = 0; i<data_pendapatan.length; i++){  
                    $('#pendapatan_bulanan').append($('<option>', { 
                        value: data_pendapatan[i].id,
                        text : data_pendapatan[i].text 
                    }));
                }
                $("#pendapatan_bulanan option[value="+pendapatan+"]").attr('selected', 'selected');
            });

            $('#nm_bdn_hukum').val(nm_bdn_hukum);
            $('#nama_pendaftar').val(nama);
            $('#nikPendaftar').val(ktp);
            $('#hpPendaftar').val(no_tlp);
            $('#jabatanPendaftar').val(jabatan);
            $('#npwp_bdn_hukum').val(npwp);

            //pengurus
            $('#namapengurus').val(nm_pengurus);
            $('#nikpengurus').val(nik_pengurus);
            $('#teleponpengurus').val(no_tlppengurus);
            $('#jabatanpengurus').val(jabatanpengurus);
            //end pengurus

            
            
            $.getJSON("/borrower/data_kota/"+provinsi+"", function(data_kota){
                for(var i = 0; i<data_kota.length; i++){
                    $('#kota_bdn_hukum').append($('<option>', { 
                        value: data_kota[i].id,
                        text : data_kota[i].text
                    }));
                }
                $("#kota_bdn_hukum option[value="+kota+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_provinsi/", function(data_provinsi){
                for(var i = 0; i<data_provinsi.length; i++){
                    $('#provinsi_bdn_hukum').append($('<option>', { 
                        value: data_provinsi[i].id,
                        text : data_provinsi[i].text
                    }));
                }
                $("#provinsi_bdn_hukum option[value="+provinsi+"]").attr('selected', 'selected');
            });

            $(function() {
					$('#provinsi_bdn_hukum').change(function(){
						var provinsi = $('#provinsi_bdn_hukum option:selected').val();
						
						$("#kota_bdn_hukum").empty().trigger('change'); // set null
						$.getJSON("/borrower/data_kota/"+provinsi, function(data_kota){
						//$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
					
							for(var i = 0; i<data_kota.length; i++){
						
								$('#kota_bdn_hukum').append($('<option>', { 
									value: data_kota[i].id,
									text : data_kota[i].text
									
								}));
							}
						});
					});
				});
            
            $('#kecamatan_bdn_hukum').val(kecamatan);
            $('#kelurahan_bdn_hukum').val(kelurahan);
            $('#kodepos_bdn_hukum').val(kode_pos);
            $('#alamat_bdn_hukum').text(alamat);

            $.getJSON("/borrower/data_bidang_pekerjaan/", function(data_bidang_pekerjaan){
                for(var i = 0; i<data_bidang_pekerjaan.length; i++){
                    $('#bidang_pekerjaan_bdn_hukum').append($('<option>', { 
                        value: data_bidang_pekerjaan[i].id,
                        text : data_bidang_pekerjaan[i].text
                        
                    }));
                }
                $("#bidang_pekerjaan_bdn_hukum option[value="+bidang_pekerjaan+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/bidang_pekerjaan_online/", function(data_bidang_online){
                for(var i = 0; i<data_bidang_online.length; i++){
                    $('#bidang_online_bdn_hukum').append($('<option>', { 
                        value: data_bidang_online[i].id,
                        text : data_bidang_online[i].text 
                    }));
                }
                $("#bidang_online_bdn_hukum option[value="+bidang_online+"]").attr('selected', 'selected');
            });

            $.getJSON("/borrower/data_pendapatan/", function(data_pendapatan){
                for(var i = 0; i<data_pendapatan.length; i++){  
                    $('#pendapatan_bdn_hukum').append($('<option>', { 
                        value: data_pendapatan[i].id,
                        text : data_pendapatan[i].text 
                    }));
                }
                $("#pendapatan_bdn_hukum option[value="+pendapatan+"]").attr('selected', 'selected');
            });

            $('#total_aset').val(total_aset);
            
            $("#notifg").hide();
            $("#passwordlama").on('change', function postinput(){
            var matchvalue = $(this).val();
            var id = $("#id").val();
            $.ajax
                ({ 
                    url: '/borrower/cek_password',
                    method: 'post',
                    data: {"_token": "{{ csrf_token() }}","id" : id,"matchvalue": matchvalue},
                    success : function(response){
                        if(response.status == 'beda'){
                            document.getElementById("passwordlama").focus();
                            document.getElementById("passwordlama").style.border = "solid 1px red";
                            // alert('Password yang Anda Masukan Salah !');
                            Swal.fire({
                              position: 'center',
                              icon: 'success',
                              title: 'Password yang Anda Masukan Salah !',
                              showConfirmButton: false,
                              timer: 3000
                            })
                        }else{
                            document.getElementById("passwordlama").style.border = "";
                            $("#side-overlay-profile-password").removeAttr('disabled');
                            $("#side-overlay-profile-password-confirm").removeAttr('disabled');
                        }
                    } 
                });
            });
            // alert(matchvalue);

            $("#btnsubmitpwd").on('click', function postinput(){
                var newpwd = $('#side-overlay-profile-password-confirm').val();
                var newpwdconfirm = $('#side-overlay-profile-password').val();
                if(newpwdconfirm != newpwd){
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Kata Sandi dan Konfirmasi Kata Sandi Tidak Sesuai..',
                                showConfirmButton: false,
                                timer: 5000
                                })
                                $('#btnsubmitpwd').attr('disabled', true);
                }else{

                    var id = $("#id").val();
                    $.ajax
                        ({ 
                            url: '{{ route('ubah.proses') }}',
                            method: 'POST',
                            data: {"_token": "{{ csrf_token() }}","id" : id,"newpwd": newpwd},
                            success : function(response){
                                if(response.status == '00'){
                                    Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Ubah Password Berhasil, Silahkan Login Kembali..',
                                    showConfirmButton: false,
                                    timer: 5000
                                    })

                                    location.href = "/borrower/logout";
                                }else{
                                    $("#notifg").show();
                                    $("#passwordlama").val('');
                                    $("#side-overlay-profile-password").val('');
                                    $("#side-overlay-profile-password-confirm").val('');
                                    $("#side-overlay-profile-password").attr('disabled',true);
                                    $("#side-overlay-profile-password-confirm").attr('disabled',true);
                                }
                            } 
                        });
                }
            });

            $("#btnSubmitBdnHukum").on('click', function postinput(){
                swal.fire({
                    text: "Anda Yakin akan Mengubah data Profile Badan Hukum ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Proses",
                    cancelButtonText: "Batal",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }).then((result) => {
                if (result.value) {
                        var brw_id 		= $('#id').val(); 
                        var brw_type 	= $('#brw_type').val();
                
                        /***************** BADAN HUKUM ******************/
                        
                        var nm_bdn_hukum 				    = $("#nm_bdn_hukum").val();
                        var npwp_bdn_hukum 			        = $("#npwp_bdn_hukum").val();
                        var nama_pendaftar 			        = $("#nama_pendaftar").val();
                        var nikPendaftar 			        = $("#nikPendaftar").val();
                        var hpPendaftar 			        = $("#hpPendaftar").val();
                        var jabatanPendaftar 				= $("#jabatanPendaftar").val();

                        var namapengurus 				    = $("#namapengurus").val();
                        var nikpengurus 				    = $("#nikpengurus").val();
                        var teleponpengurus 				= $("#teleponpengurus").val();
                        var jabatanpengurus 				= $("#jabatanpengurus").val();

                        var namapemilikrekening_bdnhkm 		= $("#namapemilikrekening_bdnhkm").val();
                        var norekening_bdnhkm 				= $("#norekening_bdnhkm").val();
                        var bank_bdnhkm 				    = $("#bank_bdnhkm option:selected").val();

                        var provinsi_bdn_hukum 				= $("#provinsi_bdn_hukum option:selected").val();
                        var kota_bdn_hukum 				    = $("#kota_bdn_hukum option:selected").val();
                        var kecamatan_bdn_hukum 			= $("#kecamatan_bdn_hukum").val();
                        var kelurahan_bdn_hukum 			= $("#kelurahan_bdn_hukum").val();
                        var kodepos_bdn_hukum 				= $("#kodepos_bdn_hukum").val();
                        var alamat_bdn_hukum 				= $("#alamat_bdn_hukum").val();

                        var bidang_pekerjaan_bdn_hukum 	    = $("#bidang_pekerjaan_bdn_hukum option:selected").val();
                        var bidang_online_bdn_hukum 		= $("#bidang_online_bdn_hukum option:selected").val();
                        var pendapatan_bdn_hukum 			= $("#pendapatan_bdn_hukum option:selected").val();
                        var total_aset 				        = $("#total_aset").val();

                        // Foto Badan Hukum
                        var exist_url_pic_brw_bdn_hukum     = $("#url_pic_brw_bdn_hukum").val();

                        if (exist_url_pic_brw_bdn_hukum == "" || exist_url_pic_brw_bdn_hukum == null)
                        {
                            var url_pic_brw_bdn_hukum       = $("#brw_pic_bdn_hukum").val();
                        }else{
                            var url_pic_brw_bdn_hukum       = $("#url_pic_brw_bdn_hukum").val();
                        }
                       
                        var exist_url_pic_brw_ktp_bdn_hukum = $("#url_pic_brw_ktp_bdn_hukum").val();
                        if (exist_url_pic_brw_ktp_bdn_hukum == "" || exist_url_pic_brw_ktp_bdn_hukum == null)
                        {
                            var url_pic_brw_ktp_bdn_hukum   = $("#brw_pic_ktp_bdn_hukum").val();
                        }else{
                            var url_pic_brw_ktp_bdn_hukum   = $("#url_pic_brw_ktp_bdn_hukum").val();
                        }
                        
                        var exist_url_pic_brw_dengan_ktp_bdn_hukum = $("#url_pic_brw_dengan_ktp_bdn_hukum").val();
                        if (exist_url_pic_brw_dengan_ktp_bdn_hukum == "" || exist_url_pic_brw_dengan_ktp_bdn_hukum == null)
                        {
                            var url_pic_brw_dengan_ktp_bdn_hukum   = $("#brw_pic_user_ktp_bdn_hukum").val();
                        }else{
                            var url_pic_brw_dengan_ktp_bdn_hukum   = $("#url_pic_brw_dengan_ktp_bdn_hukum").val();
                        }

                        var exist_url_pic_brw_npwp_bdn_hukum = $("#url_pic_brw_npwp_bdn_hukum").val();
                        if (exist_url_pic_brw_npwp_bdn_hukum == "" || exist_url_pic_brw_npwp_bdn_hukum == null)
                        {
                            var url_pic_brw_npwp_bdn_hukum   = $("#brw_pic_npwp_bdn_hukum").val();
                        }else{
                            var url_pic_brw_npwp_bdn_hukum   = $("#url_pic_brw_npwp_bdn_hukum").val();
                        }

                        $.ajax({
                                url: "/borrower/proses_updateprofile",
                                type: "POST",
                                data:  { "_token": "{{ csrf_token() }}",'type_borrower':brw_type,'brw_id':brw_id,
                                'nm_bdn_hukum':nm_bdn_hukum,
                                'npwp_bdn_hukum':npwp_bdn_hukum,
                                'nama_pendaftar':nama_pendaftar,
                                'nikPendaftar':nikPendaftar,
                                'hpPendaftar':hpPendaftar,
                                'jabatanPendaftar':jabatanPendaftar,

                                'namapengurus':namapengurus,
                                'nikpengurus':nikpengurus,
                                'teleponpengurus':teleponpengurus,
                                'jabatanpengurus':jabatanpengurus,

                                'namapemilikrekening_bdnhkm':namapemilikrekening_bdnhkm,
                                'norekening_bdnhkm':norekening_bdnhkm,
                                'bank_bdnhkm':bank_bdnhkm,

                                'provinsi_bdn_hukum':provinsi_bdn_hukum,
                                'kota_bdn_hukum':kota_bdn_hukum,
                                'kecamatan_bdn_hukum':kecamatan_bdn_hukum,
                                'kelurahan_bdn_hukum':kelurahan_bdn_hukum,
                                'kodepos_bdn_hukum':kodepos_bdn_hukum,
                                'alamat_bdn_hukum':alamat_bdn_hukum,

                                'bidang_pekerjaan_bdn_hukum':bidang_pekerjaan_bdn_hukum,
                                'bidang_online_bdn_hukum':bidang_online_bdn_hukum,
                                'pendapatan_bdn_hukum':pendapatan_bdn_hukum,
                                'total_aset':total_aset,

        
                                'url_pic_brw':url_pic_brw_bdn_hukum,
                                'url_pic_brw_ktp' : url_pic_brw_ktp_bdn_hukum,
                                'url_pic_brw_dengan_ktp':url_pic_brw_dengan_ktp_bdn_hukum,
                                'url_pic_brw_npwp':url_pic_brw_npwp_bdn_hukum,
                                
                                },
                                
                                success:function(response){
                                    
                                    if(response == "sukses"){
                                        
                                        swal.fire({
                                            title: "Proses Update Berhasil",
                                            //text: "Your will not be able to recover this imaginary file!",
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonClass: "btn-success",
                                            closeOnConfirm: false
                                        }).then((result) => {
                                            location.href = "/borrower/dashboardPendanaan";
                                        });
                                        
                                    }
                                    
                                }
                            });

                }
                });
            });
            
            $("#btnsubmitpribadi").on('click', function postinput(){
                swal.fire({
                    text: "Anda Yakin akan Mengubah Data Profile ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Proses",
                    cancelButtonText: "Batal",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }).then((result) => {
                if (result.value) {
                        // $.ajaxSetup({
                        //     headers: {
                        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //     }
                        // });
                        var brw_id 		= $('#id').val(); 
                        var brw_type 	= $('#brw_type').val();
                
                        /***************** PRIBADI ******************/
                        
                        var nama 				            = $("#nama").val();
                        var ibukandung                      = $("#ibukandung").val();
                        var pendidikan_terakhir 			= $("#pendidikan_terakhir option:selected").val();
                        var ktp 			                = $("#ktp").val();
                        var npwp 			                = $("#npwp").val();
                        var no_tlp                          = $("#telepon").val();
                        var tempat_lahir 			        = $("#tempat_lahir").val();
                        var tgl_lahir_hari 					= $("#tgl_lahir_hari option:selected").val();
                        var tgl_lahir_bulan 				= $("#tgl_lahir_bulan option:selected").val();
                        var tgl_lahir_tahun 				= $("#tgl_lahir_tahun option:selected").val();
                        var jns_kelamin 			    	= $("#jns_kelamin option:selected").val();
                        var agama 						    = $("#agama option:selected").val();
                        var status_kawin 					= $("#status_kawin option:selected").val();
                        // alamat tinggal
                        var provinsi 	            		= $("#provinsi option:selected").val();
                        var kota 				            = $("#kota option:selected").val();
                        var kecamatan                       = $("#kecamatan").val();
                        var kelurahan                       = $("#kelurahan").val();
                        var alamat 			                = $("#alamat").val();
                        var kode_pos 			            = $("#kode_pos").val();   
                        var status_rumah 				    = $("#status_rumah option:selected").val();

                        //ahli waris
                        var namaahliwaris 				    = $("#namaahliwaris").val();
                        var nikahliwaris 				    = $("#nikahliwaris").val();
                        var nohpahliwaris 				    = $("#nohpahliwaris").val();
                        var alamatahliwaris 				= $("#alamatahliwaris").val();
                        var provinsiahliwaris 				= $("#provinsiahliwaris option:selected").val();
                        var kotaahliwaris 				    = $("#kotaahliwaris option:selected").val();
                        var kecamatanahliwaris 				= $("#kecamatanahliwaris").val();
                        var kelurahanahliwaris 				= $("#kelurahanahliwaris").val();
                        var kodeposahliwaris 				= $("#kodeposahliwaris").val();

                        // rekening
                        var namapemilikrekening 		    = $("#namapemilikrekening").val(); 
                        var norekening 			            = $("#norekening").val(); 
                        var bank 				            = $("#bank option:selected").val();
                        
                        // informasi lain lain
                        var pekerjaan 			            = $("#pekerjaan option:selected").val();
                        var bidang_pekerjaan 	            = $("#bidang_pekerjaan option:selected").val();
                        var bidang_online 		            = $("#bidang_online option:selected").val();
                        var pengalaman_kerja 		        = $("#pengalaman_kerja option:selected").val();
                        var pendapatan_bulanan 	            = $("#pendapatan_bulanan option:selected").val();

                        // foto pribadi
                        var exist_url_pic_brw               = $("#url_pic_brw").val();

                        if (exist_url_pic_brw == "" || exist_url_pic_brw == null)
                        {
                            var url_pic_brw                 = $("#brw_pic").val();
                        }else{
                            var url_pic_brw                 = $("#url_pic_brw").val();
                        }
                       
                        var exist_url_pic_brw_ktp           = $("#url_pic_brw_ktp").val();
                        if (exist_url_pic_brw_ktp == "" || exist_url_pic_brw_ktp == null)
                        {
                            var url_pic_brw_ktp             = $("#brw_pic_ktp").val();
                        }else{
                            var url_pic_brw_ktp             = $("#url_pic_brw_ktp").val();
                        }
                        
                        var exist_url_pic_brw_dengan_ktp    = $("#url_pic_brw_dengan_ktp").val();
                        if (exist_url_pic_brw_dengan_ktp == "" || exist_url_pic_brw_dengan_ktp == null)
                        {
                            var url_pic_brw_dengan_ktp      = $("#brw_pic_user_ktp").val();
                        }else{
                            var url_pic_brw_dengan_ktp      = $("#url_pic_brw_dengan_ktp").val();
                        }

                        var exist_url_pic_brw_npwp          = $("#url_pic_brw_npwp").val();
                        if (exist_url_pic_brw_npwp == "" || exist_url_pic_brw_npwp == null)
                        {
                            var url_pic_brw_npwp            = $("#brw_pic_npwp").val();
                        }else{
                            var url_pic_brw_npwp            = $("#url_pic_brw_npwp").val();
                        }
                        
                        $.ajax({
                                url: "/borrower/proses_updateprofile",
                                type: "POST",
                                data:  { "_token": "{{ csrf_token() }}",'type_borrower':brw_type,'brw_id':brw_id,'nama':nama, 'ibukandung':ibukandung,'pendidikan_terakhir':pendidikan_terakhir,'ktp':ktp, 'npwp':npwp, 'no_tlp':no_tlp,
                        
                                'tempat_lahir':tempat_lahir, 'tgl_lahir_hari':tgl_lahir_hari, 'tgl_lahir_bulan':tgl_lahir_bulan, 'tgl_lahir_tahun':tgl_lahir_tahun, 'jns_kelamin':jns_kelamin, 'agama':agama,'status_kawin':status_kawin,
                                // alamat ktp
                                'provinsi':provinsi,'kota':kota,'alamat':alamat, 'kode_pos':kode_pos, 'status_rumah':status_rumah, 'kecamatan':kecamatan,'kelurahan': kelurahan,

                                //ahliwaris
                                'namaahliwaris':namaahliwaris,'nikahliwaris':nikahliwaris,'nohpahliwaris':nohpahliwaris,'alamatahliwaris':alamatahliwaris,'provinsiahliwaris':provinsiahliwaris,'kotaahliwaris':kotaahliwaris,'kecamatanahliwaris':kecamatanahliwaris,'kelurahanahliwaris':kelurahanahliwaris,'kodeposahliwaris':kodeposahliwaris,
                            
                                // pekerjaan
                                'pekerjaan':pekerjaan, 'bidang_pekerjaan':bidang_pekerjaan, 'bidang_online':bidang_online, 'pengalaman_kerja':pengalaman_kerja, 'pendapatan_bulanan':pendapatan_bulanan,
                                
                                // rekening
                                'namapemilikrekening':namapemilikrekening,'norekening':norekening,'bank':bank,
                                // foto
                                "url_pic_brw":url_pic_brw, "url_pic_brw_ktp" : url_pic_brw_ktp, "url_pic_brw_dengan_ktp":url_pic_brw_dengan_ktp,"url_pic_brw_npwp":url_pic_brw_npwp,
                                // bank
                                // "txt_nm_pemilik_individu":txt_nm_pemilik_individu, "txt_no_rek_individu" : txt_no_rek_individu, "txt_bank_individu":txt_bank_individu,
                                },
                                
                                success:function(response){
                                    
                                    if(response == "sukses"){
                                        
                                        swal.fire({
                                            title: "Proses Update Berhasil",
                                            //text: "Your will not be able to recover this imaginary file!",
                                            type: "success",
                                            showCancelButton: false,
                                            confirmButtonClass: "btn-success",
                                            closeOnConfirm: false
                                        }).then((result) => {
                                            location.href = "/borrower/dashboardPendanaan";
                                        });
                                        
                                    }
                                    
                                }
                            });

                }
                });
            });
        }); 

        // end
        $('.notallowCharacter').on('input', function (event) { 
            this.value = this.value.replace(/ /g, '');
        });

        // var uhuy = 0;
        $('#side-overlay-profile-password, #side-overlay-profile-password-confirm').on('keyup', function () {
        if ($('#side-overlay-profile-password').val() == $('#side-overlay-profile-password-confirm').val()) {
            if(($('#side-overlay-profile-password').val() != "" || $('#side-overlay-profile-password-confirm').val() != "")){
                $('#message').html(' - Sesuai').css('color', 'green'); 
                $('#btnsubmitpwd').attr('disabled', false);
            }
        } else 
            $('#message').html(' - Tidak Sesuai').css('color', 'red');
        });

    </script>
@endsection