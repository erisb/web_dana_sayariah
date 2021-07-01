@extends('layouts.admin.master')

@section('title', 'Dashboard Borrower')
	
@section('content')
<script src="{{url('admin/assets/js/lib/select2.full.js')}}"></script>
	
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>Manage Jenis Pendanaan</h1>
			</div>
		</div>
	</div>
</div>
<div class="content mt-3">
	<div class="row">
		<div class="col-md-12">
			@if (session('error'))
				<div class="alert alert-danger col-sm-12">
					{{ session('error') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@elseif (session('success'))
				<div class="alert alert-success col-sm-12">
					{{ session('success') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@elseif(session('updated'))
				<div class="alert alert-success col-sm-12">
					{{ session('updated') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif

			<div class="card">
				<div class="card-header">
					<strong class="card-title">Data Penerima Pendanaan</strong>
				</div>
				<div class="card-body">
					<table id="tblDataBorrower" class="table table-striped table-bordered table-responsive-sm">
						<thead>
							<tr>
								<th>id</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Akun</th>
								<th>Informasi Penerima</th>
								<th>Status</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Large modal -->

<!-- start modal list dokumen borrower -->
<div class="modal fade" id="myDokumen" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Data Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                    	<div class="table-responsive">
							<table id="tableDokumenBrw" class="table table-striped table-bordered table-responsive-sm">
								<thead>
									<tr>
										<th style="display: none;">Id</th>
										<th>No</th>
										<th>BRW ID</th>
										<th>Nama Dokumen</th>
										<th>File Dokumen</th>
										<th>Tanggal Unggah Dokumen</th>
										<th>Penyunting Dokumen</th>
									</tr>
								</thead>
							</table>
						</div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
<!-- end of modal list dokumen borrower -->

<!-- start modal upload dokumen -->
<div class="modal fade" id="myUpload" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Unggah Dokumen </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.uploadDokumen')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <div class="form-row">
							<div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
								<input type="hidden" id="txt_brw_type" name="brw_type">
								<input type="hidden" id="txt_brw_id" name="brw_id[]">
								<input type="hidden" id="txt_brw_id" name="id_brw">
								<input type="hidden" id="ktp" name="ktp">
								<input type="hidden" id="txt_nm_bdn_hukum" name="nama_bdn_hukum">
								<input type="hidden" id="txt_nik_bdn_hukum" name="ktp_bdn_hukum">
								<div class="row" id="tambahUpload">
									<label class="font-weight-bold">Nama Dokumen</label>
									<select class="form-control" id="dokumens" name="dokumen[]"></select><br/><br/>

									<label class="font-weight-bold" style="margin-top:10px">Unggah File</label>
									<input type="file" class="form-control" name="file[]" id="file" placeholder="Type Here"><br/>
								</div>
							</div>
						</div>
                    </div>
                </div>
				<div class="col-12">
					<button type="button" class="btn btn-rounded btn-primary btn-dsi min-width-200 mb-10 push-right" onclick="add_upload()">Tambah Upload File</button>
				</div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal upload dokumen -->

<!-- start modal detil investor -->
<div class="modal fade" id="detail_borrower" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel"> Detail Penerima Pendanaan :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
						<h3 class="title_borrower"></h3>
						<hr>
						<div id="divIndividu">
							<input type="hidden" id="txt_brw_id" name="txt_brw_id">
							<input type="hidden" id="txt_brw_type" name="txt_brw_type">
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-6">
										<label for="username" class="font-weight-bold">Akun</label>
										<input type="text" readonly id="txt_username_individu" name="txt_username_individu" class="form-control" value="" placeholder="Username">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-sm-4" id="data_perorangan_1">
										<label for="no_ktp" class="font-weight-bold">Nama Pengguna</label>
										<input type="text" name="txt_nm_individu" id="txt_nm_individu" class="form-control" placeholder="Nama Pengguna">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nama Ibu Kandung</label>
										<input type="text" name="txt_nm_ibu_individu" id="txt_nm_ibu_individu" class="form-control" placeholder="Nama Ibu Kandung">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_telp" class="font-weight-bold">Pendidikan Terakhir</label>
										<select id="txt_pendidikan_pribadi" name="txt_pendidikan_pribadi" class="form-control">
											
										</select>
									</div>
								</div>
							 
								<div class="form-row">
									<div class="form-group col-sm-4" id="data_perorangan_1">
										<label for="no_ktp" class="font-weight-bold">No KTP</label>
										<input type="text" name="txt_no_ktp_individu" id="txt_no_ktp_individu" class="form-control" placeholder="No KTP">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">No NPWP</label>
										<input type="text" id="txt_no_npwp_individu" name="txt_no_npwp_individu" class="form-control" placeholder="No NPWP">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_telp" class="font-weight-bold">No Telp / HP</label>
										<input type="text" name="txt_no_telp_individu" id="txt_no_telp_individu" class="form-control" placeholder="No Telp / HP, Contoh:08xxxxxxxxxx">
									</div>
								</div>
								
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="provinsi" class="font-weight-bold">Tempat Lahir</label>
										<input type="text" name="txt_tmpt_lahir_individu" id="txt_tmpt_lahir_individu" class="form-control" placeholder="Tempat Lahir">
								   </div>
									
									<div class="col-sm-2">
										<label for="provinsi" class="font-weight-bold">Hari</label>
										<select name="txt_tgl_lahir" class="form-control" id="txt_tgl_lahir">
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
									
									<div class="col-sm-4">
										<label for="provinsi" class="font-weight-bold">Bulan</label>
										<select name="txt_bln_lahir" class="form-control" id="txt_bln_lahir">
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
									
									<div class="col-sm-2">
										<label for="provinsi" class="font-weight-bold">Tahun</label>
										<select name="txt_thn_lahir" class="form-control" id="txt_thn_lahir"></select>
									</div>
									
									
								</div>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="provinsi" class="font-weight-bold">Jenis Kelamin</label>
										<select name="txt_jns_kelamin" class="form-control" id="txt_jns_kelamin"></select>
								   </div>
									
									<div class="col-sm-4">
										<label for="provinsi" class="font-weight-bold">Agama</label>
										<select name="txt_agama" class="form-control" id="txt_agama"></select>
									</div>
									<div class="col-sm-4">
										<label for="provinsi" class="font-weight-bold">Status Perkawinan</label>
										<select name="txt_sts_nikah" class="form-control" id="txt_sts_nikah"></select>
									</div>
								</div>
							</fieldset><br>
							
							<h3> Ahli Waris </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nama Ahli Waris</label>
										<input type="text" id="txt_nm_aw" name="txt_nm_ahli_waris" class="form-control" placeholder="Nama Ahli Waris">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nik Ahli Waris</label>
										<input type="text" id="txt_nik_aw" name="txt_nik_aw" class="form-control" placeholder="NIK Ahli Waris">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">No HP Ahli Waris</label>
										<input type="text" id="txt_no_hp_aw" name="txt_no_hp_aw" class="form-control" placeholder="No HP Ali Waris">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Email</label>
										<input type="text" id="txt_email_aw" name="txt_email_aw" class="form-control" placeholder="Email" onkeyup="email_filter_validation()" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}">
										<div>
                                        	<span id="error_email" style="color:red;font-size:11px;"></span>
                                    	</div>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Alamat Sesuai KTP</label>
										<input type="text" id="txt_alamat_aw" name="txt_alamat_aw" class="form-control" placeholder="Alamat">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Provinsi</label>
										<select name="txt_provinsi_aw" class="form-control" id="txt_provinsi_aw"></select>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kota</label>
										<select name="txt_kota_aw" class="form-control" id="txt_kota_aw"></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kecamatan</label>
										<input type="text" id="txt_kecamatan_aw" name="txt_kecamatan_aw" class="form-control" placeholder="Kecamatan">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kelurahaan</label>
										<input type="text" id="txt_kelurahan_aw" name="txt_kelurahan_aw" class="form-control" placeholder="Kelurahaan">
									</div>
									<div class="form-group col-sm-3">
										<label for="no_npwp" class="font-weight-bold">Kode Pos</label>
										<input type="text" name="txt_kd_pos_aw" id="txt_kd_pos_aw" class="form-control" placeholder="Kode Pos">
									</div>
								</div>
							</fieldset><br/>
							
							<h3> Informasi Tempat Tinggal </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Alamat Sesuai KTP</label>
										<input type="text" id="txt_alamat_individu" name="txt_alamat_individu" class="form-control" placeholder="alamat">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Provinsi</label>
										<select name="txt_provinsi_individu" class="form-control" id="txt_provinsi_individu"></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kota</label>
										<select name="txt_kota_individu" class="form-control" id="txt_kota_individu"></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kecamatan</label>
										<input type="text" id="txt_kecamatan_individu" name="txt_kecamatan_individu" class="form-control" placeholder="Kecamatan">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kelurahaan</label>
										<input type="text" id="txt_kelurahan_individu" name="txt_kelurahan_individu" class="form-control" placeholder="kelurahan">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kode Pos</label>
										<input type="text" id="txt_kd_pos_individu" name="txt_kd_pos_individu" class="form-control" placeholder="Kode Pos">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Status Kepemilikan Rumah</label>
										<select name="txt_pemilik_rumah" class="form-control" id="txt_pemilik_rumah">
											<option value="1">Milik Pribadi</option>
											<option value="2">Sewa / Kontrak</option>
										</select>
									</div>
								</div>
							</fieldset>
							
							<h3> Domisili Berbeda Dengan KTP </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Alamat Sesuai KTP</label>
										<input type="text" id="txt_alamat_domisili_individu" name="txt_alamat_domisili_individu" class="form-control" placeholder="Alamat Domisili Berbeda Dengan KTP">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Provinsi</label>
										<select id="txt_provinsi_domisili_individu" name="txt_provinsi_domisili_individu" class="form-control" ></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kota</label>
										<select id="txt_kota_domisili_individu" name="txt_kota_domisili_individu" class="form-control" ></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kecamatan</label>
										<input type="text" id="txt_kecamatan_domisili_individu" name="txt_kecamatan_domisili_individu" class="form-control" placeholder="Kecamatan">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kelurahaan</label>
										<input type="text" id="txt_kelurahan_domisili_individu" name="txt_kelurahan_domisili_individu" class="form-control" placeholder="Kelurahan">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kode Pos</label>
										<input type="text" id="txt_kd_pos_domisili_individu" name="txt_kd_pos_domisili_individu" class="form-control" placeholder="Kode Pos">
									</div>
								</div>
							</fieldset>
							<h3> Poto </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Foto Anda</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto1">
                                    </div>
                                    <label class="btn btn-success btn-upload">Upload<input type="file" id="pic_brw" name="pic_brw" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Foto KTP Anda</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto2">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" id="pic_brw_ktp" name="pic_brw_ktp" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="font-weight-bold" style="width: 184px;">Foto Anda dengan KTP</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto3">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" id="pic_brw_dengan_ktp" name="pic_brw_dengan_ktp" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
								<div class="col-sm-6">
                                    <label class="font-weight-bold" style="width: 184px;">Foto NPWP ANDA</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto4">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" id="pic_brw_npwp" name="pic_brw_npwp" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                            </div>
                            <p>Format file .jpg, .jpeg, .gif, dan .png</p>
							</fieldset>
							<h3> Informasi Rekening </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nama Pemilik Rekening</label>
										<input type="text" id="txt_nm_pemilik_individu" name="txt_nm_pemilik_individu" class="form-control" placeholder="Nama Pemilik">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">No Rekening</label>
										<input type="text" id="txt_no_rek_individu" name="txt_no_rek_individu" class="form-control" placeholder="No Rekening">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Bank</label>
										<select id="txt_bank_individu" name="txt_bank_individu" class="form-control"></select>
									</div>
								</div>
							</fieldset>
							<h3> Informasi Lain Lain </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Pekerjaan</label>
										<select id="txt_pekerjaan_individu" name="txt_pekerjaan_individu" class="form-control"></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Bidang Pekerjaan</label>
										<select id="txt_bidang_pekerjaan_individu" name="txt_bidang_pekerjaan_individu" class="form-control"></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Bidang Pekerjaan Online</label>
										<select id="txt_bidang_online_individu" name="txt_bidang_online_individu" class="form-control"></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Pengalaman Kerja</label>
										<select id="txt_pengalaman_individu" name="txt_pengalaman_individu" class="form-control"></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Pendapatan Bulanan</label>
										<select id="txt_pendapatan_bulan_individu" name="txt_pendapatan_bulan_individu" class="form-control"></select>
									</div>
								</div>
							</fieldset>
						</div>
						
						<!------------------------------------ PERUSAHAAAN ----------------------------------------------->
						<div id="divPerusahaan" style="display:none;">
						
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-6">
										<label for="username" class="font-weight-bold">Akun</label>
										<input type="text" readonly id="txt_username_bdn_hukum" name="txt_username_bdn_hukum" class="form-control" value="" placeholder="Username">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nama Badan Hukum</label>
										<input type="text" id="txt_nm_bdn_hukum" name="txt_nm_bdn_hukum" class="form-control" placeholder="Nama Pengurus">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nomor NPWP</label>
										<input type="text" id="txt_npwp_bdn_hukum" name="txt_npwp_bdn_hukum" class="form-control" placeholder="No NPWP">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nama Anda</label>
										<input type="text" id="txt_nm_anda_bdn_hukum" name="txt_nm_anda_bdn_hukum" class="form-control" placeholder="Nama Anda">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">NIK</label>
										<input type="text" id="txt_nik_bdn_hukum" name="txt_nik_bdn_hukum" class="form-control" placeholder="NIK">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">NO HP ANDA</label>
										<input type="text" id="txt_no_hp_bdn_hukum" name="txt_no_hp_bdn_hukum" class="form-control" placeholder="No HP Anda">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Jabatan</label>
										<input type="text" id="txt_jabatan_bdn_hukum" name="txt_jabatan_bdn_hukum" class="form-control" placeholder="Jabatan">
									</div>
								</div>
							</fieldset>
							
							<h3> Informasi Pengurus </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">Nama Pengurus</label>
										<input type="text" id="txt_nm_pengurus" name="txt_nm_pengurus" class="form-control" placeholder="Nama Pengurus">
									</div>
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">NIK Pengurus</label>
										<input type="text"  id="txt_nik_pengurus" name="txt_nik_pengurus" class="form-control" placeholder="NIK Pengurus">
									</div>
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">No Tlp / HP</label>
										<input type="text"  id="txt_no_hp_pengurus" name="txt_no_hp_pengurus" class="form-control" placeholder="No HP">
									</div>
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">Jabatan</label>
										<input type="text"  id="txt_jabatan_pengurus" name="txt_jabatan_pengurus" class="form-control" placeholder="Jabatan">
									</div>
								</div>
							</fieldset>
							
							<h3> Poto </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Foto Anda</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto1">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" id="pic_brw" name="pic_brw" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Foto KTP Anda</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto2">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" id="pic_brw_ktp" name="pic_brw_ktp" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="font-weight-bold" style="width: 184px;">Foto Anda dengan KTP</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto3">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" id="pic_brw_dengan_ktp" name="pic_brw_dengan_ktp" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
								<div class="col-sm-6">
                                    <label class="font-weight-bold" style="width: 184px;">Foto NPWP ANDA</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto4">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" id="pic_brw_npwp" name="pic_brw_npwp" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                            </div>
                            <p>Format file .jpg, .jpeg, .gif, dan .png</p>
							</fieldset>
							
							<h3> Informasi Rekening </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Nama Pemilik Rekening</label>
										<input type="text" id="txt_nm_pemilik_bdn_hukum" name="txt_nm_pemilik_bdn_hukum" class="form-control" placeholder="Nama Pemilik">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">No Rekening</label>
										<input type="text" id="txt_no_rek_bdn_hukum" name="txt_no_rek_bdn_hukum" class="form-control" placeholder="No Rekening">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Bank</label>
										<select id="txt_bank_bdn_hukum" name="txt_bank_bdn_hukum" class="form-control"></select>
									</div>
								</div>
							</fieldset>
							
							<h3> Informasi Lokasi Kantor </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Alamat Lengkap</label>
										<input type="text" id="txt_alamat_bdn_hukum" name="txt_alamat_bdn_hukum" class="form-control" placeholder="Alamat Kantor">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Provinsi</label>
										<select id="txt_provinsi_bdn_hukum" name="txt_provinsi_bdn_hukum" class="form-control" ></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kota</label>
										<select id="txt_kota_bdn_hukum" name="txt_kota_bdn_hukum" class="form-control" ></select>
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kecamatan</label>
										<input type="text" id="txt_kecamatan_bdn_hukum" name="txt_kecamatan_bdn_hukum" class="form-control" placeholder="Kecamatan">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kelurahaan</label>
										<input type="text" id="txt_kelurahan_bdn_hukum" name="txt_kelurahan_bdn_hukum" class="form-control" placeholder="Kelurahan">
									</div>
									<div class="form-group col-sm-4">
										<label for="no_npwp" class="font-weight-bold">Kode Pos</label>
										<input type="text" id="txt_kd_pos_bdn_hukum" name="txt_kd_pos_bdn_hukum" class="form-control" placeholder="Kode Pos">
									</div>
								</div>
							</fieldset>
							
							<h3> Informasi Lain Lain </h3>
							<hr/>
							<fieldset>
								<div class="form-row">
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">Bidang Pekerjaan</label>
										<select id="txt_bidang_pekerjaan_bdn_hukum" name="txt_bidang_pekerjaan_bdn_hukum" class="form-control"></select>
									</div>
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">Pendapatan Bulanan</label>
										<select id="txt_revenue_bulanan_bdn_hukum" name="txt_revenue_bulanan_bdn_hukum" class="form-control"></select>
									</div>
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">Bidang Pekerjaan Online</label>
										<select id="txt_bidang_online_bdn_hukum" name="txt_bidang_online_bdn_hukum" class="form-control"></select>
									</div>
									<div class="form-group col-sm-6">
										<label for="no_npwp" class="font-weight-bold">Total Aset</label>
										<input type="text" id="txt_total_asset_bdn_hukum" name="txt_total_asset_bdn_hukum" class="form-control">
									</div>
									
								</div>
							</fieldset>
						</div>
                    </div>
                </div>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="btn_update_borrower">Perbaharui</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
        </div>
		
    </div>
</div>
<!-- end of modal investor detil -->

<!-- start modal detil investor -->
<div class="modal fade" id="list_pendaan" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Daftar Pendanaan </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                    	<div class="table-responsive">
							<table id="TblListPendanaan" class="table table-striped table-bordered table-responsive-sm">
								<thead>
									<tr>
										<th>Pendanaan ID</th>
										<th>ID Penerima</th>
										<th>Tipe Penerima</th>
										<th>Nama Pendanaan</th>
										<th>Dana Dibutuhkan</th>
										<th>Estimasi Mulai</th>
										<th>Status</th>
										<th>ID Proyek</th>
										<th>Dokumen</th>
									</tr>
								</thead>
							</table>
						</div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
<!-- end of modal investor detil -->




<link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />

<script src="{{asset('js/sweetalert.js')}}"></script>
<script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="/admin/assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="/admin/assets/js/lib/data-table/jszip.min.js"></script>
<script src="/admin/assets/js/lib/data-table/pdfmake.min.js"></script>
<script src="/admin/assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="/admin/assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="/admin/assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="/admin/assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="/admin/assets/js/lib/data-table/datatables-init.js"></script>
<!--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>-->


<script type="text/javascript">
function email_filter_validation()
{
	var email = document.getElementById("txt_email_aw").value;
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
	if (email_instan1 || email_instan2 || email_instan3 || email_instan4 || email_instan5 || email_instan6 || email_instan7 || email_instan8 || email_instan9 || email_instan10 || email_instan11 || email_instan12 || email_instan13) {
		//alert('Domain Email Anda tidak diizinkan. Silahkan gunakan domain email lain');
		$('#error_email').html('<b id="emailerror">Domain Email Anda tidak diizinkan.Silahkan gunakan domain email lain</b>');
        $('#btn_update_borrower').attr('disabled',true);

	}else{
		$('#emailerror').hide();
        $('#btn_update_borrower').attr('disabled',false);
		return true; 		
	}
}

function add_upload() 
{
            
	var tambahUpload = 
	'<div class="col-sm-9 col-lg-10 ml-3 ml-sm-0" style="margin-top:20px;float:left" id="tambah">'
		+'<label class="font-weight-bold">Nama Dokumen</label>'
		+'<select class="form-control dokumens2" id="dokumens2" name="dokumen[]"></select><br/>'
		+'<label class="font-weight-bold">Unggah File</label>'
		+'<input type="file" class="form-control" name="file[]" id="file" placeholder="Type Here"><br/>'
		+'<button type="button" class="btn btn-rounded btn-danger mb-10 push-right" id="delete_upload"> <i class="fa fa-times"></i>  Hapus Upload File Ini</button><hr>'
	+'</div>'

	$('#tambahUpload').append(tambahUpload);
	
	
	$.getJSON("{{config('app.clientlink')}}/borrower/dokumen_borrower/", function(dokumen_borrower){
		for(var i = 0; i<dokumen_borrower.length; i++){
			$('.dokumens2').append($('<option>', { 
				value: dokumen_borrower[i].id,
				text : dokumen_borrower[i].text
			}));
		}
	});
	
}

//delete upload
$(document).on("click", "#delete_upload", function() { 
	$(this).parent().remove();
});
		
	var side = '/admin/borrower';
	
	function func_list_pendanaan(id){
		$('#TblListPendanaan').DataTable().clear();
		$('#TblListPendanaan').DataTable().destroy();
		var TblListPendanaan = $('#TblListPendanaan').DataTable({
			
			"columnDefs" :[
			  
			  {
				"targets": 0,
				class : 'text-left',
				"visible" : false
			  },
			  {
				"targets": 1,
				class : 'text-left',
				"visible" : false
			  },
			  {
				"targets": 2,
				class : 'text-left',
				"visible" : false
			  },
			  {
				"targets": 3,
				class : 'text-left',
				//"visible" : false
				
			  },
			  {
				"targets": 4,
				class : 'text-left',
				//"visible" : false
				
			  },
			  {
				"targets": 5,
				class : 'text-left',
				//"visible" : false
				
			  },{
				"targets": 6,
				class : 'text-left',
				//"visible" : false
				
			  },{
				"targets": 7,
				class : 'text-left',
				"visible" : false
				
			  }
			  ,{
				"targets": 8,
				class : 'text-left',
				//"visible" : false
				"render": function ( data, type, row, meta ) {
				  return '<div class="row" style="margin: 0px 0px 7px 0px;"><button type="button" class="btn btn-info" onclick="btn_register_digital_sign('+row[1]+', '+row[0]+')">Daftar Digital Sign</button> </div> <div class="row" style="margin: 0px 0px 7px 0px;"><button type="button" class="btn btn-block btn-primary" onclick="btn_send_digital_sign('+row[1]+', '+row[7]+')">Kirim Dokumen Digital Sign</button> </div> <div class="row" style="margin: 0px 0px 7px 0px;"><button class="btn btn-block btn-warning" type="button" onclick="btn_sign_digital_sign('+row[1]+', '+row[0]+')">TTD Digital Sign</button> </div> <div class="row" style="margin: 0px 0px 7px 0px;"><button type="button" class="btn btn-block btn-success" onclick="btn_create_doc_digital_sign('+row[1]+', '+row[2]+', '+row[7]+')">Generate Dokumen Digital Sign</button></div>';
				}
				
			  }]
		});
		
		TblListPendanaan.ajax.url('/admin/borrower/list_pendanaan_borrower/'+id).load();
	}
	
	function btn_register_digital_sign(brw_id, pendanaan_id){
		$.ajax({
			url : "/admin/borrower/regDigiSignborrower/"+brw_id,
			method : "get",
			success:function(data)
			{
				var dataJSON = JSON.parse(data.status_all);
				console.log(dataJSON);
				swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
				  function(){
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
									}
								});
								window.open(dataJSON.JSONFile.info,'_blank');
							}
						}
				   }
				);
				
			}
		});
	}
	
	function btn_send_digital_sign(brw_id, id_proyek){
		
		$.ajax({
			url : "/admin/borrower/sendDigiSign/"+brw_id+"/"+id_proyek,
			method : "get",
			success:function(data)
			{
				var dataJSON = JSON.parse(data.status_all);
				console.log(dataJSON);
				swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
				  function(){
					   location.href = "";
				   }
				);
				
			}
		});
	}
	
	function btn_sign_digital_sign(brw_id, pendanaan_id){
		$.ajax({
			url : "/admin/borrower/signDigiSign/"+brw_id,
			method : "get",
			success:function(data)
			{
				console.log(data.status_all)
				
			}
		});
	}
	
	function btn_create_doc_digital_sign(brw_id,brw_type,id_proyek){
		if (brw_type == 2)
		{
			$.ajax({
				url : "/admin/borrower/createDocDigisignBorrowerPerusahaan/"+brw_id+"/"+id_proyek,
				method : "get",
				success:function(data)
				{
					console.log(data.status)
					
				}
			});
		}
		else
		{
			$.ajax({
				url : "/admin/borrower/createDocDigisignBorrowerIndividu/"+brw_id+"/"+id_proyek,
				method : "get",
				success:function(data)
				{
					console.log(data.status)
					
				}
			});
		}
		
	}
	
	function btn_detail_borrower(borrower_id){
		
		var pendidikan_terakhir = "";
		var jenis_kelamin = "";
		var agama = "";
		var nikah = "";
		var provinsi = "";
		var kota = "";
		var provinsi_individu = "";
		var kota_individu = "";
		var provinsi_domisili = "";
		var kota_domisili = "";
		var bank = "";
		var pekerjaan = "";
		var bidang_pekerjaan = "";
		var bidang_online = "";
		var pengalaman = "";
		var pendapatan = "";
		var b_pekerjaan_bdn_hukum = "";
		var revenue_bdn_hukum = "";
		var bidang_online_bdn_hukum = "";
		var provinsi_bdn_hukum = "";
		var kota_bdn_hukum = "";
		var ktp = "";
		
		$.ajax({
			url  : side+"/client/getDetailsBorrower/"+borrower_id,
			type : "GET"
		}).done(function(data) {
			var obj = jQuery.parseJSON(data);
			var brw_type 			= obj.data.brw_type;
			
			
			pendidikan_terakhir 	= obj.data.pendidikan_terakhir;
			agama 					= obj.data.agama;
			nikah 					= obj.data.status_kawin;
			foto1				= obj.data.brw_pic;
			foto2				= obj.data.brw_pic_ktp;
			foto3				= obj.data.brw_pic_user_ktp;
			foto4				= obj.data.brw_pic_npwp;
			brw_id				= obj.data.brw_id;
			ktp				    = obj.data.ktp;
			
			provinsi_individu 		= obj.data.provinsi; // individu
			kota_individu 			= obj.data.kota; // individu
			provinsi_domisili 		= obj.data.domisili_provinsi; // domisili provinsi individu
			kota_domisili 			= obj.data.domisili_kota; // domisili kota individu
			bank 					= obj.data_rekening.brw_kd_bank; // domisili kota individu
			pekerjaan 				= obj.data.pekerjaan; // data pekerjaan
			bidang_pekerjaan 		= obj.data.bidang_pekerjaan; // data bidang pekerjaan
			bidang_online 			= obj.data.bidang_online; // data pekerjaan
			pengalaman 				= obj.data.pengalaman_pekerjaan; // data pekerjaan
			pendapatan 				= obj.data.pendapatan; // data pekerjaan
			b_pekerjaan_bdn_hukum 	= obj.data.bidang_perusahaan; // data pekerjaan
			revenue_bdn_hukum 		= obj.data.pendapatan; // data pekerjaan
			bidang_online_bdn_hukum = obj.data.bidang_online; // data pekerjaan
			provinsi_bdn_hukum 		= obj.data.provinsi; // data pekerjaan
			kota_bdn_hukum 			= obj.data.kota; // data pekerjaan
			bank_bdn_hukum 			= obj.data_rekening.brw_kd_bank; // data bank
			

			$.getJSON("{{config('app.clientlink')}}/borrower/dokumen_borrower/", function(dokumen_borrower){
				for(var i = 0; i<dokumen_borrower.length; i++){
                    $('#dokumens').append($('<option>', { 
                        value: dokumen_borrower[i].id,
                        text : dokumen_borrower[i].text
                    }));
                }
			});

			
			//set text label borrower individu atau badan hukum
			var brw_type_value = "";
			if(brw_type == 1 || brw_type == 3){
				provinsi 		= obj.data_aw.provinsi; // ahli waris
				kota 			= obj.data_aw.kota; // ahli waris
				// brw_type_value += "Individu"; 
				$("#divPerusahaan").hide();
				$("#divIndividu").show();
				
				$("#txt_brw_id").val(brw_id);
				$("#txt_brw_type").val(obj.data.brw_type);
				
				// (foto1 !== '' && foto1 !== null ? $('#foto1').attr('src','{{asset("/storage")}}/'+foto1) : $('#foto1').attr('src',''));
				// (foto2 !== '' && foto2 !== null ? $('#foto2').attr('src','{{asset("/storage")}}/'+foto2) : $('#foto2').attr('src',''));
				// (foto3 !== '' && foto3 !== null ? $('#foto3').attr('src','{{asset("/storage")}}/'+foto3) : $('#foto3').attr('src',''));
				// (foto4 !== '' && foto4 !== null ? $('#foto4').attr('src','{{asset("/storage")}}/'+foto4) : $('#foto4').attr('src',''));
				
				$('#txt_username_individu').val(obj.data.username);
				$('#txt_nm_individu').val(obj.data.nama);
				$('#txt_nm_ibu_individu').val(obj.data.nm_ibu);
				$('#txt_no_ktp_individu').val(obj.data.ktp);
				$('#txt_no_npwp_individu').val(obj.data.npwp);
				$('#txt_no_telp_individu').val(obj.data.no_tlp);
				$('#txt_tmpt_lahir_individu').val(obj.data.tempat_lahir);
				$("#ktp").val(obj.data.ktp);
				
				// split tanggal  lahir
				split_tgl_lahir = obj.data.tgl_lahir.split('-');
				$("#txt_tgl_lahir option[value="+split_tgl_lahir[2]+"]").attr('selected', 'selected');
				$("#txt_bln_lahir option[value="+split_tgl_lahir[1]+"]").attr('selected', 'selected');
				$("#txt_thn_lahir option[value="+split_tgl_lahir[0]+"]").attr('selected', 'selected');
				
				$('#txt_nm_aw').val(obj.data_aw.nama_ahli_waris);
				$('#txt_nik_aw').val(obj.data_aw.nik);
				$('#txt_no_hp_aw').val(obj.data_aw.no_tlp);
				$('#txt_email_aw').val(obj.data_aw.email);
				$('#txt_alamat_aw').val(obj.data_aw.alamat);
				$('#txt_kecamatan_aw').val(obj.data_aw.kecamatan);
				$('#txt_kelurahan_aw').val(obj.data_aw.kelurahan);
				$('#txt_kd_pos_aw').val(obj.data_aw.kd_pos);
				$('#txt_alamat_individu').val(obj.data.alamat);
				$('#txt_kecamatan_individu').val(obj.data.kecamatan);
				$('#txt_kelurahan_individu').val(obj.data.kelurahan);
				$('#txt_kd_pos_individu').val(obj.data.kode_pos);
				$('#txt_pemilik_rumah option[value='+obj.data.status_rumah+']').attr('selected', 'selected');
				$('#txt_alamat_domisili_individu').val(obj.data.domisili_alamat);
				$('#txt_kecamatan_domisili_individu').val(obj.data.domisili_kecamatan);
				$('#txt_kelurahan_domisili_individu').val(obj.data.domisili_kelurahan);
				$('#txt_kd_pos_domisili_individu').val(obj.data.domisili_kd_pos);
				$('#txt_nm_pemilik_individu').val(obj.data_rekening.brw_nm_pemilik);
				$('#txt_no_rek_individu').val(obj.data_rekening.brw_norek);
				
				$.getJSON("/admin/borrower/data_pendidikan/", function(data_pendidikan){
			
					for(var i = 0; i<data_pendidikan.length; i++){
						
						$('#txt_pendidikan_pribadi').append($('<option>', { 
							value: data_pendidikan[i].id,
							text : data_pendidikan[i].text
							
						}));
					}
					$("#txt_pendidikan_pribadi option[value="+pendidikan_terakhir+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_jenis_kelamin/", function(data_jenis_kelamin){
			
					for(var i = 0; i<data_jenis_kelamin.length; i++){
						
						$('#txt_jns_kelamin').append($('<option>', { 
							value: data_jenis_kelamin[i].id,
							text : data_jenis_kelamin[i].text
							
						}));
					}
					$("#txt_jns_kelamin option[value="+obj.data.jns_kelamin+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_agama/", function(data_agama){
			
					for(var i = 0; i<data_agama.length; i++){
						
						$('#txt_agama').append($('<option>', { 
							value: data_agama[i].id,
							text : data_agama[i].text
							
						}));
					}
					$("#txt_agama option[value="+agama+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_nikah/", function(data_status_perkawinan){
			
					for(var i = 0; i<data_status_perkawinan.length; i++){
						
						$('#txt_sts_nikah').append($('<option>', { 
							value: data_status_perkawinan[i].id,
							text : data_status_perkawinan[i].text
							
						}));
					}
					$("#txt_sts_nikah option[value="+nikah+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_provinsi/", function(data_provinsi){
			
					for(var i = 0; i<data_provinsi.length; i++){
						
						$('#txt_provinsi_aw').append($('<option>', { 
							value: data_provinsi[i].id,
							text : data_provinsi[i].text
							
						}));
					}
					$("#txt_provinsi_aw option[value="+provinsi+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_kota/"+kota+"", function(data_kota){
			
					for(var i = 0; i<data_kota.length; i++){
						
						$('#txt_kota_aw').append($('<option>', { 
							value: data_kota[i].id,
							text : data_kota[i].text
							
						}));
					}
					$("#txt_kota_aw option[value="+kota+"]").attr('selected', 'selected');
					
				});
				
				// data provinsi ahli waris change
				$(function() {
					$('#txt_provinsi_aw').change(function(){
						var provinsi = $('#txt_provinsi_aw option:selected').val();
						
						$("#txt_kota_aw").empty().trigger('change'); // set null
						$.getJSON("/admin/borrower/ganti_kota/"+provinsi, function(data_kota){
						//$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
					
							for(var i = 0; i<data_kota.length; i++){
						
								$('#txt_kota_aw').append($('<option>', { 
									value: data_kota[i].id,
									text : data_kota[i].text
									
								}));
							}
						});
					});
				});
				
				$.getJSON("/admin/borrower/data_provinsi/", function(data_provinsi){
			
					for(var i = 0; i<data_provinsi.length; i++){
						
						$('#txt_provinsi_individu').append($('<option>', { 
							value: data_provinsi[i].id,
							text : data_provinsi[i].text
							
						}));
					}
					$("#txt_provinsi_individu option[value="+provinsi_individu+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_kota/"+kota+"", function(data_kota){
					for(var i = 0; i<data_kota.length; i++){
						
						$('#txt_kota_individu').append($('<option>', { 
							value: data_kota[i].id,
							text : data_kota[i].text
							
						}));
					}
					$("#txt_kota_individu option[value="+kota+"]").attr('selected', 'selected');
					
				});
				

				$(function() {
					$('#txt_provinsi_individu').change(function(){
						var provinsi = $('#txt_provinsi_individu option:selected').val();
						
						$("#txt_kota_individu").empty().trigger('change'); // set null
						$.getJSON("/admin/borrower/ganti_kota/"+provinsi, function(data_kota){
						//$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
					
							for(var i = 0; i<data_kota.length; i++){
						
								$('#txt_kota_individu').append($('<option>', { 
									value: data_kota[i].id,
									text : data_kota[i].text
									
								}));
							}
						});
					});
				});
				
				// domisili
				$.getJSON("/admin/borrower/data_provinsi/", function(data_provinsi){
			
					for(var i = 0; i<data_provinsi.length; i++){
						
						$('#txt_provinsi_domisili_individu').append($('<option>', { 
							value: data_provinsi[i].id,
							text : data_provinsi[i].text
							
						}));
					}
					$("#txt_provinsi_domisili_individu option[value="+provinsi_domisili+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_kota/"+kota_domisili+"", function(data_kota){
			
					for(var i = 0; i<data_kota.length; i++){
						
						$('#txt_kota_domisili_individu').append($('<option>', { 
							value: data_kota[i].id,
							text : data_kota[i].text
							
						}));
					}
					$("#txt_kota_domisili_individu option[value="+kota_domisili+"]").attr('selected', 'selected');
					
				});
				
				
				$(function() {
					$('#txt_provinsi_domisili_individu').change(function(){
						var provinsi = $('#txt_provinsi_domisili_individu option:selected').val();
						
						$("#txt_kota_domisili_individu").empty().trigger('change'); // set null
						$.getJSON("/admin/borrower/ganti_kota/"+provinsi, function(data_kota){
						//$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
					
							for(var i = 0; i<data_kota.length; i++){
						
								$('#txt_kota_domisili_individu').append($('<option>', { 
									value: data_kota[i].id,
									text : data_kota[i].text
									
								}));
							}
						});
					});
				});
				
				$.getJSON("/admin/borrower/data_bank/", function(data_bank){
			
					for(var i = 0; i<data_bank.length; i++){
						
						$('#txt_bank_individu').append($('<option>', { 
							value: data_bank[i].id,
							text : data_bank[i].text
							
						}));
					}
					$("#txt_bank_individu option[value="+bank+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_pekerjaan/", function(data_pekerjaan){
			
					for(var i = 0; i<data_pekerjaan.length; i++){
						
						$('#txt_pekerjaan_individu').append($('<option>', { 
							value: data_pekerjaan[i].id,
							text : data_pekerjaan[i].text
							
						}));
					}
					$("#txt_pekerjaan_individu option[value="+pekerjaan+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_bidang_pekerjaan/", function(data_bidang_pekerjaan){
			
					for(var i = 0; i<data_bidang_pekerjaan.length; i++){
						
						$('#txt_bidang_pekerjaan_individu').append($('<option>', { 
							value: data_bidang_pekerjaan[i].id,
							text : data_bidang_pekerjaan[i].text
							
						}));
					}
					$("#txt_bidang_pekerjaan_individu option[value="+bidang_pekerjaan+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_bidang_online/", function(data_bidang_online){
			
					for(var i = 0; i<data_bidang_online.length; i++){
						
						$('#txt_bidang_online_individu').append($('<option>', { 
							value: data_bidang_online[i].id,
							text : data_bidang_online[i].text
							
						}));
					}
					$("#txt_bidang_online_individu option[value="+bidang_online+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_pengalaman/", function(data_pengalaman){
			
					for(var i = 0; i<data_pengalaman.length; i++){
						
						$('#txt_pengalaman_individu').append($('<option>', { 
							value: data_pengalaman[i].id,
							text : data_pengalaman[i].text
							
						}));
					}
					$("#txt_pengalaman_individu option[value="+pengalaman+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_pendapatan/", function(data_pendapatan){
			
					for(var i = 0; i<data_pendapatan.length; i++){
						
						$('#txt_pendapatan_bulan_individu').append($('<option>', { 
							value: data_pendapatan[i].id,
							text : data_pendapatan[i].text
							
						}));
					}
					$("#txt_pendapatan_bulan_individu option[value="+pendapatan+"]").attr('selected', 'selected');
					
				});

				
			}
			else{
				
				brw_type_value += "Badan Hukum"; 
				
				$("#divIndividu").hide();
				$("#divPerusahaan").show();
				
				$("#txt_brw_id").val(brw_id);
				$("#txt_brw_type").val(obj.data.brw_type);
				
				$("#txt_username_bdn_hukum").val(obj.data.username);
				$("#txt_nm_bdn_hukum").val(obj.data.nm_bdn_hukum);
				$("#txt_npwp_bdn_hukum").val(obj.data.npwp);
				$("#txt_nm_anda_bdn_hukum").val(obj.data.nama);
				$("#txt_nik_bdn_hukum").val(obj.data.ktp);
				$("#txt_no_hp_bdn_hukum").val(obj.data.no_tlp);
				$("#txt_jabatan_bdn_hukum").val(obj.data.jabatan);
				$("#txt_nm_pengurus").val(obj.data_pengurus.nm_pengurus);
				$("#txt_nik_pengurus").val(obj.data_pengurus.nik_pengurus);
				$("#txt_no_hp_pengurus").val(obj.data_pengurus.no_tlp);
				$("#txt_jabatan_pengurus").val(obj.data_pengurus.jabatan);
				
				$("#txt_nm_pemilik_bdn_hukum").val(obj.data_rekening.brw_nm_pemilik);
				$("#txt_no_rek_bdn_hukum").val(obj.data_rekening.brw_norek);
				
				
				$("#txt_alamat_bdn_hukum").val(obj.data.alamat);
				$("#txt_kecamatan_bdn_hukum").val(obj.data.kecamatan);
				$("#txt_kelurahan_bdn_hukum").val(obj.data.kelurahan);
				$("#txt_kd_pos_bdn_hukum").val(obj.data.kode_pos);
				$("#txt_total_asset_bdn_hukum").val(obj.data.total_aset);
				
				//
				$.getJSON("/admin/borrower/data_bank/", function(data_bank){
			
					for(var i = 0; i<data_bank.length; i++){
						
						$('#txt_bank_bdn_hukum').append($('<option>', { 
							value: data_bank[i].id,
							text : data_bank[i].text
							
						}));
					}
					$("#txt_bank_bdn_hukum option[value="+bank_bdn_hukum+"]").attr('selected', 'selected');
					
				});
				
				// provinsi badan hukum
				$.getJSON("/admin/borrower/data_provinsi/", function(data_provinsi){
			
					for(var i = 0; i<data_provinsi.length; i++){
						
						$('#txt_provinsi_bdn_hukum').append($('<option>', { 
							value: data_provinsi[i].id,
							text : data_provinsi[i].text
							
						}));
					}
					$("#txt_provinsi_bdn_hukum option[value="+provinsi_bdn_hukum+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_kota/"+kota_bdn_hukum+"", function(data_kota){
			
					for(var i = 0; i<data_kota.length; i++){
						
						$('#txt_kota_bdn_hukum').append($('<option>', { 
							value: data_kota[i].id,
							text : data_kota[i].text
							
						}));
					}
					$("#txt_kota_bdn_hukum option[value="+kota_bdn_hukum+"]").attr('selected', 'selected');
					
				});
				
				
				$(function() {
					$('#txt_provinsi_bdn_hukum').change(function(){
						var provinsi = $('#txt_provinsi_bdn_hukum option:selected').val();
						
						$("#txt_kota_bdn_hukum").empty().trigger('change'); // set null
						$.getJSON("/admin/borrower/ganti_kota/"+provinsi, function(data_kota){
						//$.getJSON( "http://core.danasyariah.id/borrower/data_kota/"+provinsi, function(data_kota){
					
							for(var i = 0; i<data_kota.length; i++){
						
								$('#txt_kota_bdn_hukum').append($('<option>', { 
									value: data_kota[i].id,
									text : data_kota[i].text
									
								}));
							}
						});
					});
				});
				
				
				
				$.getJSON("/admin/borrower/data_pekerjaan/", function(data_pekerjaan){
			
					for(var i = 0; i<data_pekerjaan.length; i++){
						
						$('#txt_bidang_pekerjaan_bdn_hukum').append($('<option>', { 
							value: data_pekerjaan[i].id,
							text : data_pekerjaan[i].text
							
						}));
					}
					$("#txt_bidang_pekerjaan_bdn_hukum option[value="+b_pekerjaan_bdn_hukum+"]").attr('selected', 'selected');
					
				});
				
				$.getJSON("/admin/borrower/data_pendapatan/", function(data_pendapatan){
			
					for(var i = 0; i<data_pendapatan.length; i++){
						
						$('#txt_revenue_bulanan_bdn_hukum').append($('<option>', { 
							value: data_pendapatan[i].id,
							text : data_pendapatan[i].text
							
						}));
					}
					$("#txt_revenue_bulanan_bdn_hukum option[value="+revenue_bdn_hukum+"]").attr('selected', 'selected');
					
				});
				
				
				$.getJSON("/admin/borrower/data_bidang_online/", function(data_bidang_online){
			
					for(var i = 0; i<data_bidang_online.length; i++){
						
						$('#txt_bidang_online_bdn_hukum').append($('<option>', { 
							value: data_bidang_online[i].id,
							text : data_bidang_online[i].text
							
						}));
					}
					$("#txt_bidang_online_bdn_hukum option[value="+bidang_online_bdn_hukum+"]").attr('selected', 'selected');
					
				});
				
			}
			
			$('.title_borrower').text('Data' + brw_type_value);
			
			
			  
		});
		
		
		
	}
	
	
	// proses update borrower
	$(document).on("click","#btn_update_borrower", function(){
		swal({
			title: "Anda Yakin?",
			text: "Anda Yakin Ingin Memproses Edit Penerima Dana Ini ?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Proses",
			cancelButtonText: "Batal",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
				
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});
					
				var brw_id 		= $("#txt_brw_id").val(); 
				var brw_type 	= $("#txt_brw_type").val();
		
				/***************** PRIBADI ******************/
				
				var txt_nm_individu 				= $("#txt_nm_individu").val();
				var txt_nm_ibu_individu 			= $("#txt_nm_ibu_individu").val();
				var txt_pendidikan_pribadi 			= $("#txt_pendidikan_pribadi option:selected").val();
				var txt_no_ktp_individu 			= $("#txt_no_ktp_individu").val();
				var txt_no_npwp_individu 			= $("#txt_no_npwp_individu").val();
				var txt_no_telp_individu 			= $("#txt_no_telp_individu").val();
				var txt_tmpt_lahir_individu 		= $("#txt_tmpt_lahir_individu").val();
				var txt_tgl_lahir 					= $("#txt_tgl_lahir option:selected").val();
				var txt_bln_lahir 					= $("#txt_bln_lahir option:selected").val();
				var txt_thn_lahir 					= $("#txt_thn_lahir option:selected").val();
				var txt_jns_kelamin 				= $("#txt_thn_lahir option:selected").val();
				var txt_agama 						= $("#txt_agama option:selected").val();
				var txt_sts_nikah 					= $("#txt_sts_nikah option:selected").val();
				var txt_pemilik_rumah 				= $("#txt_pemilik_rumah option:selected").val();
				// alamat tinggal
				var txt_alamat_individu 			= $("#txt_alamat_individu").val();
				var txt_provinsi_individu 			= $("#txt_provinsi_individu option:selected").val();
				var txt_kota_individu 				= $("#txt_kota_individu option:selected").val();
				var txt_kecamatan_individu 			= $("#txt_kecamatan_individu").val();
				var txt_kelurahan_individu 			= $("#txt_kelurahan_individu").val();
				var txt_kd_pos_individu 			= $("#txt_kd_pos_individu").val();
				// domisili
				var txt_alamat_domisili_individu 	= $("#txt_alamat_domisili_individu").val();
				var txt_provinsi_domisili_individu 	= $("#txt_provinsi_domisili_individu option:selected").val();
				var txt_kota_domisili_individu 		= $("#txt_kota_domisili_individu option:selected").val();
				var txt_kecamatan_domisili_individu = $("#txt_kecamatan_domisili_individu").val();
				var txt_kelurahan_domisili_individu = $("#txt_kelurahan_domisili_individu").val();
				var txt_kd_pos_domisili_individu	= $("#txt_kd_pos_domisili_individu").val();
				// ahli waris
				var txt_nm_aw 						= $("#txt_nm_aw").val();
				var txt_nik_aw 						= $("#txt_nik_aw").val();
				var txt_no_hp_aw 					= $("#txt_no_hp_aw").val();
				var txt_email_aw 					= $("#txt_email_aw").val();
				var txt_alamat_aw 					= $("#txt_alamat_aw").val();
				var txt_provinsi_aw 				= $("#txt_provinsi_aw option:selected").val();
				var txt_kota_aw 					= $("#txt_kota_aw option:selected").val();
				var txt_kecamatan_aw 				= $("#txt_kecamatan_aw").val();
				var txt_kelurahan_aw 				= $("#txt_kelurahan_aw").val();
				var txt_kd_pos_aw 					= $("#txt_kd_pos_aw").val();
				// rekening
				var txt_nm_pemilik_individu 		= $("#txt_nm_pemilik_individu").val(); 
				var txt_no_rek_individu 			= $("#txt_no_rek_individu").val(); 
				var txt_bank_individu 				= $("#txt_bank_individu option:selected").val();
				// informasi lain lain
				var txt_pekerjaan_individu 			= $("#txt_pekerjaan_individu option:selected").val();
				var txt_bidang_pekerjaan_individu 	= $("#txt_bidang_pekerjaan_individu option:selected").val();
				var txt_bidang_online_individu 		= $("#txt_bidang_online_individu option:selected").val();
				var txt_pengalaman_individu 		= $("#txt_pengalaman_individu option:selected").val();
				var txt_pendapatan_bulan_individu 	= $("#txt_pendapatan_bulan_individu option:selected").val();
				
				
				// /***************** BADAN HUKUM ******************/
				var txt_nm_bdn_hukum = $("#txt_nm_bdn_hukum").val(); 
				var txt_npwp_bdn_hukum = $("#txt_npwp_bdn_hukum").val(); 
				var txt_nm_anda_bdn_hukum = $("#txt_nm_anda_bdn_hukum").val(); 
				var txt_nik_bdn_hukum = $("#txt_nik_bdn_hukum").val(); 
				var txt_no_hp_bdn_hukum = $("#txt_no_hp_bdn_hukum").val(); 
				var txt_jabatan_bdn_hukum = $("#txt_jabatan_bdn_hukum").val(); 
				//pengurus
				var txt_nm_pengurus = $("#txt_nm_pengurus").val(); 
				var txt_nik_pengurus = $("#txt_nik_pengurus").val(); 
				var txt_no_hp_pengurus = $("#txt_no_hp_pengurus").val(); 
				var txt_jabatan_pengurus = $("#txt_jabatan_pengurus").val(); 
				// norek
				var txt_nm_pemilik_bdn_hukum = $("#txt_nm_pemilik_bdn_hukum").val(); 
				var txt_no_rek_bdn_hukum = $("#txt_no_rek_bdn_hukum").val();  
				var txt_bank_bdn_hukum 	= $("#txt_bank_bdn_hukum option:selected").val();
				// alamat
				var txt_alamat_bdn_hukum = $("#txt_alamat_bdn_hukum").val();  
				var txt_provinsi_bdn_hukum 	= $("#txt_provinsi_bdn_hukum option:selected").val();
				var txt_kota_bdn_hukum 	= $("#txt_kota_bdn_hukum option:selected").val();
				var txt_kecamatan_bdn_hukum = $("#txt_kecamatan_bdn_hukum").val();  
				var txt_kelurahan_bdn_hukum = $("#txt_kelurahan_bdn_hukum").val();  
				var txt_kelurahan_bdn_hukum = $("#txt_kelurahan_bdn_hukum").val();  
				var txt_kd_pos_bdn_hukum = $("#txt_kd_pos_bdn_hukum").val();  
				// lain lain 
				var txt_bidang_pekerjaan_bdn_hukum = $("#txt_bidang_pekerjaan_bdn_hukum option:selected").val();  
				var txt_revenue_bulanan_bdn_hukum = $("#txt_revenue_bulanan_bdn_hukum option:selected").val();  
				var txt_bidang_online_bdn_hukum = $("#txt_bidang_online_bdn_hukum option:selected").val();  
				var txt_total_asset_bdn_hukum = $("#txt_total_asset_bdn_hukum").val(); 
				
				if(brw_type == 1 || brw_type == 3){
					// PROSES PRIBADI
					
					$.ajax({
						url: "/admin/borrower/update_borrower",
						type: "POST",
						data:  { 
						'type_borrower':brw_type,'brw_id':brw_id,
						'txt_nm_individu':txt_nm_individu, 'txt_nm_ibu_individu':txt_nm_ibu_individu, 'txt_pendidikan_pribadi':txt_pendidikan_pribadi, 'txt_no_ktp_individu':txt_no_ktp_individu, 
						'txt_no_npwp_individu':txt_no_npwp_individu, 'txt_no_telp_individu':txt_no_telp_individu, 'txt_tmpt_lahir_individu':txt_tmpt_lahir_individu, 
						'txt_tgl_lahir':txt_tgl_lahir, 'txt_bln_lahir':txt_bln_lahir, 'txt_thn_lahir':txt_thn_lahir, 'txt_jns_kelamin':txt_jns_kelamin, 'txt_agama':txt_agama, 'txt_sts_nikah':txt_sts_nikah,
						// alamat ktp
						'txt_alamat_individu':txt_alamat_individu, 'txt_provinsi_individu':txt_provinsi_individu, 'txt_kota_individu':txt_kota_individu, 'txt_kecamatan_individu':txt_kecamatan_individu,  'txt_kelurahan_individu':txt_kelurahan_individu, 'txt_kd_pos_individu':txt_kd_pos_individu, 'txt_pemilik_rumah':txt_pemilik_rumah,
						// alamat domisili
						'txt_alamat_domisili_individu':txt_alamat_domisili_individu, 'txt_provinsi_domisili_individu':txt_provinsi_domisili_individu, 'txt_kota_domisili_individu':txt_kota_domisili_individu, 'txt_kecamatan_domisili_individu':txt_kecamatan_domisili_individu,'txt_kelurahan_domisili_individu':txt_kelurahan_domisili_individu,'txt_kd_pos_domisili_individu':txt_kd_pos_domisili_individu,
						// 
						'txt_pekerjaan_individu':txt_pekerjaan_individu, 'txt_bidang_pekerjaan_individu':txt_bidang_pekerjaan_individu, 'txt_bidang_online_individu':txt_bidang_online_individu, 'txt_pengalaman_individu':txt_pengalaman_individu, 'txt_pendapatan_bulan_individu':txt_pendapatan_bulan_individu,
						// ahli waris
						'txt_nm_aw': txt_nm_aw,'txt_nik_aw':txt_nik_aw, 'txt_no_hp_aw':txt_no_hp_aw, 'txt_email_aw':txt_email_aw,'txt_alamat_aw':txt_alamat_aw, 'txt_provinsi_aw':txt_provinsi_aw,'txt_kota_aw':txt_kota_aw,'txt_kecamatan_aw':txt_kecamatan_aw, 'txt_kelurahan_aw':txt_kelurahan_aw, 'txt_kd_pos_aw':txt_kd_pos_aw,
						// // foto
						// "url_pic_brw":url_pic_brw, "url_pic_brw_ktp" : url_pic_brw_ktp, "url_pic_brw_dengan_ktp":url_pic_brw_dengan_ktp,"url_pic_brw_npwp":url_pic_brw_npwp,
						// bank
						"txt_nm_pemilik_individu":txt_nm_pemilik_individu, "txt_no_rek_individu" : txt_no_rek_individu, "txt_bank_individu":txt_bank_individu,
						},
						
						success:function(response){
							
							if(response == "sukses"){
								
								swal({
								  title: "Proses Berhasil",
								  //text: "Your will not be able to recover this imaginary file!",
								  type: "success",
								  showCancelButton: false,
								  confirmButtonClass: "btn-success",
								  closeOnConfirm: false
								},
								function(){
								  location.href = "/admin/borrower/listBorrower";
								});
								
							}
							
						}
					});
				}else{
					
					// PROSES BADAN HUKUM
					$.ajax({
						url: "/admin/borrower/update_borrower",
						type: "POST",
						data:  {'type_borrower':brw_type,'brw_id':brw_id,
						'txt_nm_bdn_hukum':txt_nm_bdn_hukum,'txt_npwp_bdn_hukum':txt_npwp_bdn_hukum,'txt_nm_anda_bdn_hukum':txt_nm_anda_bdn_hukum,'txt_nik_bdn_hukum':txt_nik_bdn_hukum,
						'txt_no_hp_bdn_hukum':txt_no_hp_bdn_hukum,'txt_jabatan_bdn_hukum':txt_jabatan_bdn_hukum,
						//alamat
						'txt_alamat_bdn_hukum':txt_alamat_bdn_hukum,'txt_provinsi_bdn_hukum':txt_provinsi_bdn_hukum,'txt_kota_bdn_hukum':txt_kota_bdn_hukum,'txt_kecamatan_bdn_hukum':txt_kecamatan_bdn_hukum,'txt_kelurahan_bdn_hukum':txt_kelurahan_bdn_hukum, 'txt_kd_pos_bdn_hukum':txt_kd_pos_bdn_hukum,
						//pengurus
						'txt_nm_pengurus':txt_nm_pengurus,'txt_nik_pengurus':txt_nik_pengurus,'txt_no_hp_pengurus':txt_no_hp_pengurus,'txt_jabatan_pengurus':txt_jabatan_pengurus,
						// bank
						"txt_nm_pemilik_bdn_hukum":txt_nm_pemilik_bdn_hukum, "txt_no_rek_bdn_hukum" : txt_no_rek_bdn_hukum, "txt_bank_bdn_hukum":txt_bank_bdn_hukum,
						// lain - lain
						'txt_bidang_pekerjaan_bdn_hukum':txt_bidang_pekerjaan_bdn_hukum,'txt_revenue_bulanan_bdn_hukum':txt_revenue_bulanan_bdn_hukum,'txt_bidang_online_bdn_hukum':txt_bidang_online_bdn_hukum,'txt_total_asset_bdn_hukum':txt_total_asset_bdn_hukum
						
						// foto
						// "url_pic_brw_bdn_hukum":url_pic_brw_bdn_hukum, "url_pic_brw_ktp_bdn_hukum" : url_pic_brw_ktp_bdn_hukum, "url_pic_brw_dengan_ktp_bdn_hukum":url_pic_brw_dengan_ktp_bdn_hukum,
						// "url_pic_brw_npwp_bdn_hukum":url_pic_brw_npwp_bdn_hukum,
						
						},
					
						success: function (response) {
							if(response == "sukses"){
								
								swal({
								  title: "Proses Berhasil",
								  //text: "Your will not be able to recover this imaginary file!",
								  type: "success",
								  showCancelButton: false,
								  confirmButtonClass: "btn-success",
								  closeOnConfirm: false
								},
								function(){
								  location.href = "/admin/borrower/listBorrower";
								});
								
							}
							
							
						}
					
					});
					
					
				}
			}
		});
	});
	
	
	
	$(document).ready(function(){
		
	
		
		// set tahun lahir
        var thn = document.getElementById('txt_thn_lahir');
        var minOffset = 17; maxOffset = 100; // Change to whatever you want
        var thisYear = new Date().getFullYear();
        var html_thn = '<option value="">--Pilih--</option>';
        for (i = new Date().getFullYear(); i > 1900; i--)
        {
            html_thn += '<option value='+i+'>'+i+'</option>';
        }
		
        thn.innerHTML = html_thn;
		
		
		var link = "{{config('app.clientlink')}}";
		
		$(document).on("change","#pic_brw", function()
		{
		
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
					url : "/admin/borrower/edit_poto_1/",
					method : "POST",
					dataType: 'JSON',
					data: form_data,
					contentType: false,
					processData: false,
					success:function(data)
					{
						console.log(data);
						// if(data.success){
							// alert(data.success);
							// $('#url_pic_brw').val(data.url);
							// $("#txt_filename_pribadi").text(data.filename);
						// }else{
							// alert(data.failed);
						// }
					}
				});
			}
		});

		
		
		var tableDataBorrower = $('#tblDataBorrower').DataTable({
		
			processing: true,
			// serverSide: true,
			"ajax" : {
				url : side+'/client/data_borrower',
				type : 'get',
			},
			"columns" : [
				{"data" : "borrower_id"},
				{"data" : "nama"},
				{"data" : "email"},
				{"data" : "username"},
				{"data" : "Informasi Borrower"},
				{"data" : "status"}
			],
			"columnDefs" :[
			  
			  {
				"targets": 0,
				class : 'text-left',
				"visible" : false,
			  },
			  {
				"targets": 1,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				
			  },
			  {
				"targets": 2,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				
			  },
			  {
				"targets": 3,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				
			  },
			  {
				"targets": 4,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				"render": function ( data, type, row, meta ) {
				  return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#detail_borrower" onclick="btn_detail_borrower('+row['borrower_id']+')">Detail Penerima Dana</button><br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#list_pendaan" onclick="func_list_pendanaan('+row["borrower_id"]+')">List Pendanaan</button><br><br><button class="btn btn-success btn-sm active" data-toggle="modal" data-target="#myDokumen" onclick="getIdborrower('+row['borrower_id']+')">List Dokumen</button><br><br><button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#myUpload" onclick="btn_detail_borrower('+row['borrower_id']+')">Upload Dokumen</button>';
				  //return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#detail_borrower" onclick="btn_detail_borrower('+row['borrower_id']+')">Detail Borrower</button> <button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#list_pendaan" onclick="func_list_pendanaan('+row["borrower_id"]+')">List Pendanaan</button>';
				}
				
			  },
			  {
				"targets": 5,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				
			  }
			  
			  
			]
		});
		
		$('#tableDataBorrower').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tableDataBorrower.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				//var id = this.id;
				///console.log($(this));
			}
		});
	  });
</script>

<script type="text/javascript">
	
	function getIdborrower(id)
	{
		//alert(id);
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function() {
			
			var dokumenTable = $('#tableDokumenBrw').DataTable({
				searching: true,
				processing: true,
				// serverSide: true,
				ajax: {
					url: '/admin/ListDokumen/'+id,
					dataSrc: 'data'
				},
				paging: true,
				info: true,
				lengthChange:false,
				order: [ 1, 'asc' ],
				pageLength: 5,
				columns: [
					{ data: 'id_dokumen'},
					{ data : null,
					render: function (data, type, row, meta) {
							//I want to get row index here somehow
							return  meta.row+1;
						}
					},
					{ data : 'brw_id'},
					{ data : 'jenis_dokumen'},
					{ data : 'nama_dokumen'},
					//{ data : 'path_file'},
					/*{ data : null,
						render:function(data,type,row,meta)
						{
							//return '<button class="btn btn-default" onclick="getDokumenss('+String(data["path_file"])+')">' + data.path_file + ' </button>';
						}
					},*/
					{ data : 'created_at'},
					{ data : 'author'}
				],
				columnDefs: [
					{ targets: [0], visible: false}
				]
			});

			$('#tableDokumenBrw').on( 'click', 'tr', function () {
				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					dokumenTable.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
			$('#tableDokumenBrw tbody').on( 'click', 'tr', function (event) {
				var tr = $(this).closest('tr');
				var row = dokumenTable.row( tr );
				var length = dokumenTable.rows('tr.selected').data().length;
				var data = dokumenTable.row($(this).closest('tr')).data();
				var id = $(event.target).parent().data('value');
				//console.log(data.path_file);
				var id = data.path_file;
				location.href  = "/admin/getDokumen/"+id;
			});
		});
	}
    
	
</script>

@endsection