@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Pendana</h1>
                    </div>
                </div>
            </div>
</div>
<div id="overlay">
<div class="cv-spinner">
    <span class="spinner"></span>
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
@elseif(session('exist'))
    <div class="alert alert-danger col-sm-12">
        {{ session('exist') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif(session('changepass'))
    <div class="alert alert-success col-sm-12">
        {{ session('changepass') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif($errors->any())
    <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
    </div>
@endif
    <div class="alert alert-success col-sm-12" id="error_search" style="display: none;">
        Data Kosong Bro!!!!!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="card" id="view_card_search">
        <div class="card-header">
            <strong class="card-title">Pencarian Pendana</strong>
        </div>
        <div class="card-body">
            <form class="form" id="form_search">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Nama</label>
                    <div class="col-8">
                        <input type="text" name="nama" class="form-control" id="nama" autocomplete="off" autofocus>
                        <div id="nama_list"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Akun</label>
                    <div class="col-8">
                        <input type="text" name="username" class="form-control" id="username" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                    <div class="col-8">
                        <input type="email" name="searchEmail" class="form-control" id="searchEmail" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <legend class="col-form-label col-lg-3">Dana Tidak Teralokasi</legend>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="unallocated" id="yes" value="yes">
                        <label class="form-check-label" for="inlineRadio1">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="unallocated" id="no" value="no">
                        <label class="form-check-label" for="inlineRadio1">Tidak</label>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" id="search">Cari</button>
            </form>
        </div>
    </div>

    <div class="card" id="view_card_table" style="display: none;">
        <div class="card-header">
            <strong class="card-title">Data Pendana</strong>
        </div>
        <div class="card-body">
            <table id="table_investor" class="table table-striped table-bordered table-responsive-sm">
                <thead>
                <tr>
                    <th style="display: none;">Id</th>
                    <th>No</th>
                    <th>Nama Pendana</th>
                    <th>Email </th>
                    <th>Akun</th>
                    <th>Jumlah Pendanaan</th>
                    <th>Total Pendanaan</th>
                    <th>Dana tidak teralokasi</th>
                    <th>Informasi Pendana</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- start modal detil investor -->
<div class="modal fade" id="detil" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Detil Pendana : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.investor.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <input type="hidden" name="investor_id" id="investor_id">
                        <input type="hidden" name="tipe_proses" id="tipe_proses">
                        <h3><b>Data Pribadi</b></h3>
                        <hr>
                        <fieldset>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="username" class="font-weight-bold"><i>Akun</i></label>
                                    <input type="text" name="username" class="form-control" value="{{!empty($detil->username) ? $detil->username : ''}}" placeholder="Username">
                                </div>
                               {{--  <div class="form-group col-sm-4">
                                    <label for="password" class="font-weight-bold"><i>Password</i></label>
                                    <input type="password" name="password" class="form-control" value="{{!empty($detil->password) ? $detil->password : ''}}" placeholder="Password">
                                </div> --}}
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="nama" class="font-weight-bold">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{!empty($detil->nama_investor) ? $detil->nama_investor : ''}}" placeholder="Nama">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email" class="font-weight-bold">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{!empty($detil->email) ? $detil->email : ''}}" placeholder="Email" onkeyup="email_filter_validation()" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}"> 
                                    <div>
                                        <span id="error_email" style="color:red;font-size:11px;margin-left:240px"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3">
                                    <label for="tempat_lahir" class="font-weight-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="tanggal_lahir" class="font-weight-bold">Tanggal Lahir</label>
                                    {{-- @php
                                    // bulan
                                    $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
                                    // end bulan
                                    @endphp --}}
                                    <div class="form-row">
                                        <div class="col-sm-3">
                                            <select name="tgl_lahir" class="form-control" id="tgl_lahir">
                                            </select>
                                        </div>
                                        <div class="col-sm-5">
                                            <select name="bln_lahir" class="form-control" id="bln_lahir">
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select name="thn_lahir" class="form-control" id="thn_lahir">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach($master_jenis_kelamin as $b)
                                            <option value="{{ $b->id_jenis_kelamin }}">{{ $b->jenis_kelamin }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                          {{-- </div> --}}
                            <div class="form-row">
                                <div class="form-group col-sm-3">
                                    <label for="jenis_kelamin" class="font-weight-bold">Status Perkawinan</label>
                                    <select name="status_kawin" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach($master_kawin as $kawin)
                                            <option value="{{$kawin->id_kawin}}" {{!empty($detil->status_kawin_investor) && $kawin->id_kawin == $detil->status_kawin_investor ? 'selected=selected' : ''}}>{{$kawin->jenis_kawin}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-3" id="data_perorangan_1">
                                    <label for="no_ktp" class="font-weight-bold">No KTP</label>
                                    <input type="text" name="no_ktp" id="no_ktp" class="form-control" placeholder="No KTP">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="no_npwp" class="font-weight-bold">No NPWP</label>
                                    <input type="text" name="no_npwp" class="form-control" placeholder="No NPWP">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="no_telp" class="font-weight-bold">No Telp / HP</label>
                                    <input type="text" name="no_telp" id="no_telp" onfocusout="checkPhoneNumber(this.value)" class="form-control" placeholder="No Telp / HP, Contoh:08xxxxxxxxxx">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3">
                                    <label for="nama_ibu_kandung" class="font-weight-bold">Nama Ibu Kandung</label>
                                    <input type="text" name="nama_ibu_kandung" id="nama_ibu_kandung" class="form-control" placeholder="Nama Ibu Kandung">
                                </div>
                                <div class="form-group col-sm-3" id="data_perorangan_1">
                                    <label for="pendidikan" class="font-weight-bold">Pendidikan</label>
                                    <select name="pendidikan" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach($master_pendidikan as $pendidikan)
                                            <option value="{{$pendidikan->id_pendidikan}}" {{!empty($detil->pendidikan_investor) && $pendidikan->id_pendidikan == $detil->pendidikan_investor ? 'selected=selected' : ''}}>{{$pendidikan->pendidikan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="pekerjaan" class="font-weight-bold">Pekerjaan</label>
                                    <select name="pekerjaan" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach($master_pekerjaan as $pekerjaan)
                                            <option value="{{$pekerjaan->id_pekerjaan}}" {{!empty($detil->pekerjaan_investor) && $pekerjaan->id_pekerjaan == $detil->pekerjaan_investor ? 'selected=selected' : ''}}>{{$pekerjaan->pekerjaan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="no_telp" class="font-weight-bold">Pendapatan</label>
                                    <select name="pendapatan" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach($master_pendapatan as $pendapatan)
                                            <option value="{{$pendapatan->id_pendapatan}}" {{!empty($detil->pendapatan_investor) && $pendapatan->id_pendapatan == $detil->pendapatan_investor ? 'selected=selected' : ''}}>{{$pendapatan->pendapatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="font-weight-bold">Alamat</label>
                                <textarea name="alamat" class="form-control col-sm-12" rows="3" id="alamat" placeholder="Alamat Lengkap"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-3">
                                    <label for="provinsi" class="font-weight-bold">Provinsi</label>
                                    <select name="provinsi" class="form-control" id="provinsi">
                                        <option value="">--Pilih--</option>
                                        @foreach ($master_provinsi as $data)
                                            <option value={{$data->kode_provinsi}}>{{$data->nama_provinsi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="kota" class="font-weight-bold">Kota</label>
                                    <select name="kota" class="form-control" id="kota">
                                    </select>
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="kode_pos" class="font-weight-bold">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" id="kecamatan" placeholder="Kecamatan">
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="kode_pos" class="font-weight-bold">Kelurahan</label>
                                    <input type="text" name="kelurahan" class="form-control" id="kelurahan" placeholder="Kelurahan">
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="kode_pos" class="font-weight-bold">Kode Pos</label>
                                    <input type="text" name="kode_pos" class="form-control" id="kode_pos" placeholder="Kode Pos">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-2 imgUp">
                                    <label class="font-weight-bold">Foto Diri</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto1">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" name="pic_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                <div class="col-sm-2 imgUp">
                                    <label class="font-weight-bold">Foto KTP</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto2">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" name="pic_ktp_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                    <div class="col-sm-2 imgUp">
                                    <label class="font-weight-bold" style="width: 184px;">Foto Diri dengan KTP</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto3">
                                    </div>
                                    <label class="btn btn-success btn-upload">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                            </div>
                            <p>Format file .jpg, .jpeg, .gif, dan .png</p>
                        </fieldset><br>

                        <h3><b>Data Rekening</b></h3>
                        <hr>
                        <fieldset>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="username" class="font-weight-bold">No. VA</label>
                                    <input type="text" name="va_number" class="form-control" value="{{!empty($detil->va_number) ? $detil->va_number : ''}}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="rekening" class="font-weight-bold">No Rekening</label>
                                    <input type="text" name="rekening" id="rekening" class="form-control" placeholder="No Rekening">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="rekening" class="font-weight-bold">Nama Pemilik Rekening</label>
                                    <input type="text" name="nama_pemilik_rek" class="form-control" placeholder="Nama Pemilik Rekening">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="bank" class="font-weight-bold">Bank</label>
                                    <select name="bank" class="form-control">
                                        <option value="">--Pilih--</option>
                                        @foreach($master_bank as $b)
                                            <option value="{{ $b->kode_bank }}">{{ $b->nama_bank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset><br>
                        <div class="form-group">
                            <div id="pending" style="display: none;">
                                <label for="terkumpul" class=" form-control-label">Tangguhkan Pendana ?</label>
                                <br>
                                <div class="alert alert-danger col-sm-12" id="deactived">
                                    <small>Akun ini telah di aktifkan kembali oleh <b id="namaActived"></b> dengan alasan <b id="keteranganAktif"></b> pada tanggal <b id="tanggalAktif" ></b></small><br>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <input type="radio" id="checked_suspend" name="status" value="suspend"> Tangguhkan <br>
                                <div class="form-group" id="alasan_suspend" style="display:none">
                                    <label for="alasan_suspend" class="font-weight-bold">Alasan Ditangguhkan</label>
                                    <textarea name="alasan_suspend" class="form-control col-sm-10" rows="3"  placeholder="Alasan Ditangguhkan"></textarea>
                                </div>
                            </div>
                            <div id="suspend" style="display: none;">
                                <label for="terkumpul" class=" form-control-label">Aktivasi Pendana ?</label>
                                <br>
                                <div class="alert alert-danger col-sm-12">
                                    <small>Akun ini telah di Tangguhkan oleh <b id="namaSuspended"></b> dengan alasan <b id="keteranganSuspend"></b> pada tanggal <b id="tanggalSuspend" ></b>. Klik tombol aktif jika ingin mengaktifkan kembali.</small><br>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <input type="radio" id="checked_active" name="status" value="active"> Aktif <br>
                                <div class="form-group" id="alasan_active" style="display:none">
                                    <label for="alasan_aktive" class="font-weight-bold">Alasan Diaktifkan</label>
                                    <textarea name="alasan_active" class="form-control col-sm-10" rows="3"  placeholder="Alasan Diaktifkan"></textarea>
                                </div>
                            </div>
                        </div><br>

                        <h3><b>Refferal</b></h3>
                        <hr>
                        <fieldset>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="rekening" class="font-weight-bold">Kode Refferal</label>
                                    <input type="text" name="kode_ref" class="form-control" placeholder="Kode Refferal">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="rekening" class="font-weight-bold">Nama Marketer</label>
                                    <input type="text" name="nama_ref" class="form-control" placeholder="Nama Marketer" disabled="disabled">
                                </div>
                            </div>
                        </fieldset>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="submit_detil">Perbaharui Pendana</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal investor detil -->

<!-- start modal changeStatus -->
<div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Ganti Status Pendana : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.investor.changestatus')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="investor_id" id="investor_id4">
                <div class="form-group">
                    <div id="notfilled">
                        <label for="terkumpul" class=" form-control-label">aktifkan Pendana ?</label>
                        <br>
                        <input type="radio" name="status" value="suspend"> Aktif
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ganti Status</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal changeStatus -->

<!-- start modal changepassword -->
<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Ganti Password Pendana : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.investor.changepassword')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="investor_id" id="investor_id2">
                <input type="text" class="form-control" name="newpassword">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ganti Password</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal changepassword -->

{{-- modal tambahVA --}}
<div class="modal fade" id="tambahVA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Tambah Dana <span id="nama_user"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.addVA')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="input_sebesar" class="col-sm-3 col-form-label">Nominal</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control qty" value="" name="nominal">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="perihal" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" value="" name="perihal">
                    </div>
                </div>
                <input type="hidden" name="investor_id" id="investor_id3">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary">Tambah Dana</button>
            </div>
                </form>
        </div>
    </div>
</div>
{{-- end modal tambahVA --}}

{{-- modal kurangDana --}}
<div class="modal fade" id="kurangDana" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Kurang Dana <span id="nama_user_kurang"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.minusDana')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="input_sebesar" class="col-sm-3 col-form-label">Nominal</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control qty" value="" name="nominal">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="perihal" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" value="" name="perihal">
                    </div>
                </div>
                <input type="hidden" name="investor_id" id="investor_id_kurang">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary">Kurang Dana</button>
            </div>
                </form>
        </div>
    </div>
</div>
{{-- end modal kurangDana --}}
<style>
  .modal-mutasi{
    max-width: 80% !important;
  }
</style>
<div class="modal fade" id="mutasi" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-mutasi" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title" id="scrollmodalLabel">Detil Mutasi <span id="nama_user_mutasi"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="mutasi-search">
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="startDate1">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="startDate1" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="startDate2">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="startDate2" required>
                      </div>
                      <div class="form-group col-md-12 m-2">
                        <button type="submit" class="btn btn-success btn-block" id="search_btn">Cari</button>
                      </div>
                    </div>
                  </div>
              </div>
                <div class="mutasi-body">
                    <table class="table" id="table_list_mutasi">
                      <thead>
                        <tr>
                          <th scope="col">Keterangan</th>
                          <th scope="col">Tanggal</th>
                          <th scope="col">Debit</th>
                          <th scope="col">Kredit</th>
                          <th scope="col">Saldo</th>
                        </tr>
                      </thead>
                      <tbody>
    
                      </tbody>
                    </table>
                <hr>
              </div>    
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div> --}}
        </div>
    </div>
</div>

<!-- mutasi proyek -->
<div class="modal fade" id="modalmutasi_proyek_investor" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-mutasi" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title" id="scrollmodalLabel">Detil Mutasi Proyek Investor<span id="nama_user_mutasi"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mutasi-body">
                    <table class="table" id="table_list_mutasi_proyek_investor">
                      <thead>
                        <tr>
                          <th scope="col">Nama Proyek</th>
                          <th scope="col">Alamat</th>
                          <th scope="col">Tanggal Mulai</th>
                          <th scope="col">Tanggal Pendanaan</th>
                          <th scope="col">Tanggal Selesai</th>
                          <th scope="col">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
    
                      </tbody>
                    </table>
                <hr>
              </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- end mutasi proyek -->

<div class="modal fade" id="detilPendanaan" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-extra" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Detil Proyek <span id="nama_user_detilPendanaan"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-aktif-tab" data-toggle="pill" href="#aktif" role="tab" aria-controls="aktif" aria-selected="true">Proyek Aktif</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-selesai-tab" data-toggle="pill" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false">Proyek Selesai</a>
                  </li>
                </ul>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="aktif" role="tabpanel" aria-labelledby="pills-aktif-tab">
                      <table class="table">
                          <tr>
                            <td >No</td>
                            <td >Nama Proyek</td>
                            <td >Tanggal Mulai Proyek</td>
                            <td >Total Dana</td>
                            <td >Pengguna</td>
                            <td >Tanggal Pendanaan</td>
                            <td >Aksi</td>
                          </tr>
                      </table>
                        {{-- <div class="row">
                            <div class="col">No</div>
                            <div class="col">Nama Proyek</div>
                            <div class="col">Tanggal Mulai</div>
                            <div class="col">Total Dana</div>
                            <div class="col-1">Pengguna</div>
                            <div class="col-2">Tanggal Pendanaan</div>
                            <div class="col">Aksi</div>
                        </div> --}}
                        <hr>
                        <div class="detilPendanaan-body">
                            <div id="detilAktif"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="pills-selesai-tab">
                        <table class="table">
                          <tr>
                            <td >No</td>
                            <td >Nama Proyek</td>
                            <td >Tanggal Selesai Proyek</td>
                            <td >Total Dana</td>
                            <td >Aksi</td>
                          </tr>
                        </table>
                        <hr>
                        <div class="detilPendanaan-body">
                            <div id="detilSelesai"></div>
                        </div>
                    </div>
                </div>  
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div> --}}
        </div>
    </div>
</div>

<div class="modal fade" id="kelolaProyek" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title" id="scrollmodalLabel">Kelola Proyek</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row ml-1 mb-3">
                    <label for="total_dana">Tersedia : </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="total_dana" readonly="readonly">
                    </div>
                </div>
                <div class="row">
                    {{-- <div class="col-1">No</div> --}}
                    <div class="col-3">Nama Proyek</div>
                    <div class="col-1">Bagi Hasil</div>
                    <div class="col-2">Harga Paket</div>
                    <div class="col-2">Terkumpul</div>
                    <div class="col-1">Sisa Waktu</div>
                    <div class="col-3">Aksi</div>
                </div>
            <hr>
                <div class="kelolaProyek-body"></div>    
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div> --}}
        </div>
    </div>
</div>

</div><!-- .content -->
    
    <style>
    .btn-upload
    {
      display:block;
      border-radius:0px;
      box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
      margin-top:-5px;
      width: 200px;
    }
    .imagePreview 
    {
        width: 200px;
        height: 200px;
        background-position: center center;
        background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
        background-color:#fff;
        background-size: cover;
        background-repeat:no-repeat;
        display: inline-block;
        box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
    }
    .imgUp
    {
      margin-bottom:15px;
      margin-right: 85px;
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
  <link rel="stylesheet" href="/css/jquery_step/jquery.steps.css">
  <link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />

  <script src="{{asset('js/sweetalert.js')}}"></script>
  <script src="/js/jquery-3.3.1.min.js"></script>
  <script src="/js/jquery_step/jquery.steps.js"></script>
  <script src="/js/jquery_step/jquery.validate.min.js"></script>

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


    <script type="text/javascript">
        function email_filter_validation()
        {
            var email = document.getElementById("email").value;
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
                $('#submit_detil').attr('disabled',true);

            }else{
                $('#emailerror').hide();
                $('#submit_detil').attr('disabled',false);
                return true; 		
            }
        }
                            
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            var status = document.getElementById("checked_suspend");
            $("#checked_suspend").click(function(){
                if (status.checked == true){
                    $("#alasan_suspend").show();                               
                }
                else {
                    $("#alasan_suspend").hide();                                
                    
                }
            });
        });

        $(document).ready(function(){
            var status = document.getElementById("checked_active");
            $("#checked_active").click(function(){
                if (status.checked == true){
                    $("#alasan_active").show();                               
                }
                else {
                    $("#alasan_active").hide();                                
                    
                }
            });
        });

        function dateDiff(date1,date2)
        {
            dt1 = new Date(date1);
            dt2 = new Date(date2);
            return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
        }

        function numberFormat(num){
            var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
            if(str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for(var j = 0, len = str.length; j < len; j++) {
                if(str[j] != ",") {
                    output.push(str[j]);
                    if(i%3 == 0 && j < (len - 1)) {
                        output.push(",");
                    }
                    i++;
                }
            }
            formatted = output.reverse().join("");
            return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
        };

        // upload
        $(document).on("change",".uploadFile", function()
        {
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
     
            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file
     
                reader.onloadend = function(){ // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
                }
            }
          
        });
        // end upload

        $(document).ready(function() {
            var investorTable;
            
            $('#nama').on('keyup',function(e){
                e.preventDefault();
                var query = $(this).val();
                console.log(query)
                if (query != '')
                {
                    $.ajax({
                        url : "/admin/investor/nama_autocomplete",
                        method : "post",
                        data : {query:query},
                        success:function(data)
                        {
                            $('#nama_list').fadeIn();
                            $('#nama_list').html(data);
                        }
                    });
                }
                else
                {
                    $('#nama_list').fadeOut();
                    $('#nama_list').html();
                }
            })

            $(document).on('click','li',function(){
                $('#nama').val($(this).text());
                $('#nama_list').fadeOut();
            })

            $('#search').on('click',function(e){
                e.preventDefault();
                var name = $.trim($('#nama').val());
                var unallocated = $('input:radio[name="unallocated"]:checked').val();
                var username = $('#username').val();
                var search_email = $('#searchEmail').val();
                console.log(search_email)
                // if (name != '' || unallocated != '' || username != '')
                // {
                    if (name != '')
                    {
                        var dataSearch = {name:name,unallocated:null,username:null,search_email:null};
                    } 
                    else if (username != '')
                    {
                        var dataSearch = {name:null,unallocated:null,username:username,search_email:null};
                    }
                    else if (search_email != '')
                    {
                        var dataSearch = {name:null,unallocated:null,username:null,search_email:search_email};
                    }
                    else if (unallocated != 'undefined')
                    {
                        var dataSearch = {name:null,unallocated:unallocated,username:null,search_email:null};
                    }
                    console.log(dataSearch)
                    $.ajax({
                      url: '/admin/investor/data',
                      method: 'post',
                      dataType: 'json',
                      data : dataSearch,
                      success: function(data){
                        if (data.status == 'Ada')
                        {
                            $('#view_card_search').attr('style','display: none');
                            $('#view_card_table').attr('style','display: block');
                            investorTable = $('#table_investor').DataTable({
                                searching: false,
                                processing: true,
                                // serverSide: true,
                                ajax: {
                                    url: '/admin/investor/data_mutasi_datatables',
                                    type: 'post',
                                    data: dataSearch,
                                    dataSrc: 'data'
                                },
                                paging: true,
                                info: true,
                                lengthChange:false,
                                order: [ 1, 'asc' ],
                                pageLength: 10,
                                columns: [
                                    { data: 'idInvestor'},
                                    { data : null,
                                        render: function (data, type, row, meta) {
                                              //I want to get row index here somehow
                                              return  meta.row+1;
                                        }
                                    },
                                    { data: null,
                                        render:function(data,type,row,meta){
                                            if (row.status == 'notfilled' || row.status == 'Not Active')
                                            {
                                                return '-'
                                            }
                                            else if (row.status == 'active' || row.status == 'pending' || row.status == 'suspend' || row.status == 'reject')
                                            {
                                                return row.nama_investor
                                            }
                                        }
                                    },
                                    { data: 'email'},
                                    { data: 'username'},
                                    { data: null,
                                        render:function(data,type,row,meta){
                                            // return row.total - row.total_log
                                            if (row.total == null)
                                            {
                                                return 0
                                                     +'<button class="btn btn-success float-right tambahVA-btn" data-toggle="modal" data-target="#detilPendanaan" id="detil_pendanaan" value=""><span class="ti-align-justify"></span></button>';
                                            }
                                            else
                                            {
                                                return row.total - row.total_log
                                                    +'<button class="btn btn-success float-right tambahVA-btn" data-toggle="modal" data-target="#detilPendanaan" id="detil_pendanaan" value=""><span class="ti-align-justify"></span></button>';
                                            }
                                        }
                                    },
                                    { data: null,
                                        render:function(data,type,row,meta){
                                            if (row.jumlah_nominal == null)
                                            {
                                                return 0;
                                            }
                                            else
                                            {
                                                return numberFormat(row.jumlah_nominal - row.jumlah_nominal_log);
                                            }
                                        }
                                    },
                                    { data: null,
                                        render:function(data,type,row,meta){
                                            if (row.unallocated == '')
                                            {
                                                return "Don't Have VA";
                                            }
                                            else
                                            {
                                                if (row.unallocated == null)
                                                {
                                                    return 0
                                                    +'<br><br><button class="btn btn-success float-right tambahVA-btn" data-toggle="modal" data-target="#tambahVA" id="tambah_va" value=""><span class="ti-plus"></span></button><br><br>'
                                                    +'<button class="btn btn-success float-right kurangDana-btn" data-toggle="modal" data-target="#kurangDana" id="kurang_dana" value=""><span class="ti-minus"></span></button>';
                                                }
                                                else
                                                {
                                                    return numberFormat(row.unallocated)
                                                    +'<br><br><button class="btn btn-success float-right tambahVA-btn" data-toggle="modal" data-target="#tambahVA" id="tambah_va" value=""><span class="ti-plus"></span></button><br><br>'
                                                    +'<button class="btn btn-success float-right kurangDana-btn" data-toggle="modal" data-target="#kurangDana" id="kurang_dana" value=""><span class="ti-minus"></span></button>';
                                                }
                                            }
                                        }  
                                    },
                                    { data: null,
                                        render:function(data,type,row,meta){
                                            if(row.status == 'notfilled')
                                            {
                                                return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#detil" id="detil_investor">Detil User</button><br><br><button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#change_password" id="password">Change Password</button>';
                                            }
                                            else if(row.status == 'Not Active')
                                            {
                                                return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#change_password" id="password">Change Password</button>';
                                            }
                                            else if(row.status == 'suspend' && row.nama_investor == null)
                                            {
                                                return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#changeStatus" id="change_status">Change Status</button>';
                                            }
                                            else if (row.status == 'active' || row.status == 'pending' || row.status == 'suspend' ||row.status == 'reject')
                                            {
                                                return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#detil" id="detil_investor">Detil User</button><br><br><button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#change_password" id="password">Change Password</button><br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#mutasi" id="mutasi_investor">Riwayat Mutasi</button><br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#modalmutasi_proyek_investor" id="mutasi_proyek_investor" onclick="getIdMutasi('+row['idInvestor']+')">Riwayat Mutasi Proyek Pendana</button><br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#kelolaProyek" id="kelola_proyek">Kelola Proyek</button><!--br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#" id="reg_digisign">Daftar Digital Sign</button><br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#" id="send_digisign">Kirim Dokumen Digital Sign</button><br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#" id="sign_digisign">TTD Digital Sign</button><br><br><button class="btn btn-primary btn-sm active" data-toggle="modal" data-target="#" id="create_doc">Generate Dokumen Digital Sign</button-->';
                                            }
                                        }
                                    },
                                    { data: null,
                                        render:function(data,type,row,meta){
                                            if (row.status == 'notfilled')
                                            {
                                                return '<button class="btn btn-outline-danger btn-sm active" disabled>notfilled</button>';
                                            }
                                            else if(row.status == 'Not Active')
                                            {
                                                return '<button class="btn btn-outline-danger btn-sm active" disabled>not active</button>';
                                            }
                                            else if (row.status == 'pending')
                                            {
                                                return '<button class="btn btn-outline-danger btn-sm active" disabled>Pending</button>';
                                            }
                                            else if (row.status == 'reject')
                                            {
                                                return '<button class="btn btn-outline-danger btn-sm active" disabled>Reject</button>';
                                            }
                                            else if (row.status == 'active')
                                            {
                                                return '<button class="btn btn-outline-success btn-sm active" disabled>active</button>';
                                            }
                                            else if (row.status == 'suspend')
                                            {
                                                return '<button class="btn btn-outline-secondary btn-sm active" disabled>suspend</button>';
                                            }
                                        }
                                    }
                                ],
                                columnDefs: [
                                    { targets: [0], visible: false}
                                ]
                            });
                        }
                        else
                        {
                            $('#error_search').attr('style','display: block');
                        }
                      },
                      error: function(error){
                          alert('Ada Error'+error+' nih');
                      }
                    })
                // }
                // else
                // {
                //     $('#error_search').attr('style','display: block');
                // }
            });

            $('#table_investor tbody').on( 'click', '#detil_investor', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                nama = data.nama_investor;
                username = data.username;
                email = data.email;
                status = data.status;
                $.ajax({
                    url : "/admin/investor/data_detil_investor/"+id,
                    method : "get",
                    success:function(data)
                    {
                        console.log(data.detil_investor)
                        data_all = data.detil_investor;

                        $('#tipe_proses').val('');
                        if (data_all != null)
                        {
                            no_ktp = data_all.no_ktp_investor;
                            no_npwp = data_all.no_npwp_investor;
                            no_telp = data_all.phone_investor;
                            tempat_lahir = data_all.tempat_lahir_investor;
                            tgl_lahir = data_all.tgl_lahir_investor;
                            jenis_kelamin = data_all.jenis_kelamin_investor;
                            alamat = data_all.alamat_investor;
                            provinsi = data_all.provinsi_investor;
                            kota = data_all.kota_investor;
                            kode_pos = data_all.kode_pos_investor;
                            rekening = data_all.rekening;
                            bank = data_all.bank_investor;
                            nama_pemilik_rek = data_all.nama_pemilik_rek;
                            keteranganSuspend = data_all.keteranganSuspend;
                            tanggalSuspend = data_all.tanggalSuspend;
                            namaSuspended = data_all.namaSuspended;
                            namaActived = data_all.namaActived;
                            
                            foto1 = data_all.pic_investor;
                            foto2 = data_all.pic_ktp_investor;
                            foto3 = data_all.pic_user_ktp_investor;

                            kode_ref = data_all.ref_code;
                            nama_marketer = data_all.nama_marketer;
                            va_number = data_all.va_number;
                            status_kawin = data_all.status_kawin_investor;
                            kecamatan = data_all.kecamatan;
                            kelurahan = data_all.kelurahan;
                            nama_ibu_kandung = data_all.nama_ibu_kandung;
                            pendidikan = data_all.pendidikan_investor;
                            pekerjaan = data_all.pekerjaan_investor;
                            pendapatan = data_all.pendapatan_investor;

                            $('#investor_id').val(id);
                            $('input[name=tempat_lahir]').val(tempat_lahir);

                            if (tgl_lahir != null)
                            {
                                data_lahir = tgl_lahir.split("-");
                                console.log(data_lahir[0])
                                $('input[name=tgl_lahir]').val(data_lahir[0]);
                                $('input[name=bln_lahir]').val(data_lahir[1]);
                                $('input[name=thn_lahir]').val(data_lahir[2]);
                            }
                            else
                            {
                                data_lahir = null;
                                $('input[name=tgl_lahir]').val(data_lahir);
                                $('input[name=bln_lahir]').val(data_lahir);
                                $('input[name=thn_lahir]').val(data_lahir);
                            }

                            var option = '<option value="">--Pilih--</option>',
                                select_tgl = document.getElementById('tgl_lahir'),
                                data_tgl_lhr = (data_lahir !== null ? data_lahir[0] : 0);

                            for(i=1;i<=31;i++)
                            {
                                option += '<option value="'+i+'" '+(i == data_tgl_lhr ? "selected" : "")+'>'+i+'</option>';
                            }

                            select_tgl.innerHTML = option;

                            var data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'],
                                option_bln = '<option value="">--Pilih--</option>',
                                data_bln_lhr = (data_lahir !== null ? data_lahir[1] : 0),
                                select_bln = document.getElementById('bln_lahir');

                            for(i=0;i<=11;i++)
                            {
                                option_bln += '<option value="'+(i+1)+'" '+(i == data_bln_lhr-1 ? "selected" : "")+'>'+data_bulan[i]+'</option>';
                            }
                            select_bln.innerHTML = option_bln;

                            // generate tahun
                              var select = document.getElementById('thn_lahir'),
                                  year = new Date().getFullYear(),
                                  html = '<option value="">--Pilih--</option>',
                                  data_awal = (data_lahir !== null ? data_lahir[2] : 0);
                              for(i = year; i >= year-100; i--) {
                                html += '<option value="' + i + '" '+(i == data_awal ? "selected" : "")+'>' + i + '</option>';
                              }
                              select.innerHTML = html;
                            // end generate tahun
                                
                            $('input[name=no_ktp]').val(no_ktp);
                            $('select[name=jenis_kelamin]').val(jenis_kelamin);
                            $('input[name=username]').val(username);
                            $('input[name=email]').val(email);
                            $('input[name=nama]').val(nama);
                            $('input[name=no_npwp]').val(no_npwp);
                            $('input[name=no_telp]').val(no_telp);
                            $('textarea[name=alamat]').val(alamat);
                            $('select[name=provinsi]').val(provinsi);

                            $('#kota').empty();
                            $.ajax({
                                url : "/admin/getKota/"+provinsi,
                                method : "get",
                                success:function(data)
                                {
                                    $.each(data.kota,function(index,value){
                                        if (value.kode_kota == kota)
                                        {
                                            var select = 'selected=selected';
                                        }
                                        $('#kota').append(
                                            '<option value="'+value.kode_kota+'"'+ select+'>'+value.nama_kota+'</option>'
                                        );
                                    })
                                }
                            });
                            // $('select[name=kota]').val(kota);
                            $('input[name=kode_pos]').val(kode_pos);
                            $('input[name=kecamatan]').val(kecamatan);
                            $('input[name=kelurahan]').val(kelurahan);
                            $('input[name=rekening]').val(rekening);
                            $('select[name=bank]').val(bank);
                            $('input[name=nama_ibu_kandung]').val(nama_ibu_kandung);
                            $('select[name=status_kawin]').val(status_kawin);
                            $('select[name=pendidikan]').val(pendidikan);
                            $('select[name=pekerjaan]').val(pekerjaan);
                            $('select[name=pendapatan]').val(pendapatan);
                            $('input[name=nama_pemilik_rek]').val(nama_pemilik_rek);
                            $('#keteranganSuspend').text(keteranganSuspend);
                            $('#tanggalSuspend').text(tanggalSuspend);
                            $('#namaSuspended').text(namaSuspended);
                            if (namaActived == "" || namaActived == null)
                            {
                                $('#deactived').hide();
                            }else{
                                $('#deactived').show();
                                $('#namaActived').text(namaActived);
                                $('#keteranganAktif').text(keteranganSuspend);
                                $('#tanggalAktif').text(tanggalSuspend);
                            }

                            // 
                            // if (foto1 != null){$('input[name=pic_investor]').attr('required',false);}else{$('input[name=pic_investor]').attr('required',true);}
                            // if (foto2 != null){$('input[name=pic_ktp_investor]').attr('required',false);}else{$('input[name=pic_ktp_investor]').attr('required',true);}

                            (foto1 !== '' && foto1 !== null ? $('#foto1').attr('src','{{asset('/storage')}}/'+foto1) : $('#foto1').attr('src',''));
                            (foto2 !== '' && foto2 !== null ? $('#foto2').attr('src','{{asset('/storage')}}/'+foto2) : $('#foto2').attr('src',''));
                            (foto3 !== '' && foto3 !== null ? $('#foto3').attr('src','{{asset('/storage')}}/'+foto3) : $('#foto3').attr('src',''));

                            if (status == 'active' || status == 'pending')
                            {
                                $('#pending').attr('style','display:block');
                                $('#suspend').attr('style','display:none');
                            }
                            else if (status == 'suspend')
                            {
                                $('#suspend').attr('style','display:block');
                                $('#pending').attr('style','display:none');
                            }
                            else 
                            {
                                $('#suspend').attr('style','display:none');
                                $('#pending').attr('style','display:none');
                            }

                            $('#tipe_proses').val('lama');
                            $('input[name=kode_ref]').val(kode_ref);
                            $('input[name=nama_ref]').val(nama_marketer);
                            $('input[name=va_number]').val(va_number);
                        }
                        else
                        {
                            $('#investor_id').val(id);

                            var option = '<option value="">--Pilih--</option>',
                                select_tgl = document.getElementById('tgl_lahir');

                            for(i=1;i<=31;i++)
                            {
                                option += '<option value="'+i+'">'+i+'</option>';
                            }

                            select_tgl.innerHTML = option;

                            var data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'],
                                option_bln = '<option value="">--Pilih--</option>',
                                select_bln = document.getElementById('bln_lahir');

                            for(i=0;i<=11;i++)
                            {
                                option_bln += '<option value="'+(i+1)+'">'+data_bulan[i]+'</option>';
                            }
                            select_bln.innerHTML = option_bln;

                            // generate tahun
                            var select = document.getElementById('thn_lahir'),
                                  year = new Date().getFullYear(),
                                  html = '<option value="">--Pilih--</option>';
                            for(i = year; i >= year-100; i--) {
                                html += '<option value="' + i + '">' + i + '</option>';
                            }
                            select.innerHTML = html;
                            // end generate tahun
                                
                            $('input[name=username]').val(username);
                            $('input[name=email]').val(email);

                            if (status == 'active' || status == 'pending')
                            {
                                $('#pending').attr('style','display:block');
                                $('#suspend').attr('style','display:none');
                            }
                            else if (status == 'suspend')
                            {
                                $('#suspend').attr('style','display:block');
                                $('#pending').attr('style','display:none');
                            }
                            else 
                            {
                                $('#suspend').attr('style','display:none');
                                $('#pending').attr('style','display:none');
                            }

                            $('#tipe_proses').val('baru');
                            $('#submit_detil').text('').text('Insert Investor');
                        }

                    }
                });
            });

            $('#table_investor tbody').on( 'click', '#password', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                
                $('#investor_id2').val(id);
            });

            $('#table_investor tbody').on( 'click', '#change_status', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                
                $('#investor_id4').val(id);
            });

            $('#table_investor tbody').on( 'click', '#tambah_va', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                nama = data.nama_investor;
                console.log(id)
                $('#nama_user').html(nama);
                $('#investor_id3').val(id);
            });

            $('#table_investor tbody').on( 'click', '#kurang_dana', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                nama = data.nama_investor;
                console.log(id)
                $('#nama_user_kurang').html(nama);
                $('#investor_id_kurang').val(id);
            });

            
            $('#table_investor tbody').on( 'click', '#mutasi_investor', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                nama = data.nama_investor;
                console.log(nama)
                $('#nama_user_mutasi').html(nama);


                var table_mutasi = $('#table_list_mutasi').DataTable({
                    "destroy":true,
                    "bSort": false,
                    "searching":false,
                    "paging":false,
                    "lengthChange": true,
                    ajax: {
                        url : "/admin/investor/data_riwayat_mutasi/"+id,
                        method : "get",
                    },
                    
                    "columns" : [
                        {"data" : "Keterangan"},
                        {"data" : "Tanggal"},
                        {"data" : "Debit"},
                        {"data" : "Kredit"},
                        {"data" : "Saldo"},
                    ],
                    "columnDefs": [
                      {
                        "targets": 0,
                        class : 'text-center',
                        //"visible" : false
                      },
                      {
                        "targets": 1,
                        class : 'text-center',
                        "render": function ( data, type, row, meta ) {
                          return row['Tanggal'];
                        }
                        //"visible" : false
                      },
                      {
                        "targets": 2,
                        class : 'text-center',
                        //"visible" : false
                      },
                      {
                        "targets": 3,
                        class : 'text-center',
                        //"visible" : false
                      },
                      {
                        "targets": 4,
                        class : 'text-center',
                        //"visible" : false
                      },
                    ]
                    
                });
                var dt1 = $('#startDate1').val('');
                var dt2 = $('#startDate2').val('');

                $('#search_btn').on('click', function(){

                  var dt1 = $('#startDate1').val();
                  var dt2 = $('#startDate2').val();

                  if(dt1 == '' || dt2 == '')
                  {
                    alert('Tanggal ada yang kosong.')
                  }
                  else
                  {

                    var table_mutasi = $('#table_list_mutasi').DataTable({
                        "destroy":true,
                        "bSort": false,
                        "searching":false,
                        "paging":false,
                        
                        ajax: {
                            url : "/admin/investor/data_riwayat_mutasi_date/"+id+"/"+dt1+"/"+dt2,
                            method : "get",
                        },
                        
                        "columns" : [
                            {"data" : "Keterangan"},
                            {"data" : "Tanggal"},
                            {"data" : "Debit"},
                            {"data" : "Kredit"},
                            {"data" : "Saldo"},
                        ],
                        "columnDefs": [
                          {
                            "targets": 0,
                            class : 'text-center',
                            //"visible" : false
                          },
                          {
                            "targets": 1,
                            class : 'text-center',
                            "render": function ( data, type, row, meta ) {
                              return row['Tanggal'];
                            }
                            //"visible" : false
                          },
                          {
                            "targets": 2,
                            class : 'text-center',
                            //"visible" : false
                          },
                          {
                            "targets": 3,
                            class : 'text-center',
                            //"visible" : false
                          },
                          {
                            "targets": 4,
                            class : 'text-center',
                            //"visible" : false
                          },
                        ]
                        
                    });

                  }
                  


                });

                
            });

            $('#table_investor tbody').on( 'click', '#detil_pendanaan', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                nama = data.nama_investor;
                console.log(nama)
                $('#nama_user_detilPendanaan').html(nama);
                $('#detilPendanaan').find('.tab-content').find('#aktif').find('.detilPendanaan-body').find('#detilAktif').html('');
                $('#detilPendanaan').find('.tab-content').find('#selesai').find('.detilPendanaan-body').find('#detilSelesai').html('');
                $.ajax({
                    url : "/admin/investor/data_detil_pendanaan/"+id,
                    method : "get",
                    success:function(data)
                    {
                        console.log(data.data_selesai)
                        var noAktif = 1, tgl_invest, noSelesai = 1;
                        $.each(data.data,function(index,value){
                            console.log(value.tgl_selesai)
                            tgl_invest = value.tanggal_invest.split(" ")[0].split("-");
                            tgl_mulai = value.tgl_mulai.split(" ")[0].split("-")
                            $('#detilPendanaan').find('.tab-content').find('#aktif').find('.detilPendanaan-body').find('#detilAktif').append(
                                '<form action="{{ route('admin.investor.edit_pendanaan_investor') }}" method="POST">@csrf'+
                                '<table class="table text-left">'+
                                  '<tr>'+
                                      '<td style="width: 50px; word-wrap: break-word">'+ noAktif +'</td>'+
                                      '<td style="width: 210px; word-wrap: break-word">'+ value.nama +'</td>'+
                                      '<td style="width: 120px; word-wrap: break-word">'+ tgl_mulai[2]+'-'+tgl_mulai[1]+'-'+tgl_mulai[0] +'</td>'+
                                      '<td style="width: 200px; word-wrap: break-word">'+ '<input type="text" class="form-control" id="qty_'+value.id+'" name="nominal" value="'+numberFormat(value.total_dana.split(".")[0])+'">'+'</td>'+
                                      '<td style="width: 120px; word-wrap: break-word">'+ value.tipe_user+'</td>'+
                                      '<td style="width: 150px; word-wrap: break-word">'+ tgl_invest[2]+'-'+tgl_invest[1]+'-'+tgl_invest[0]+'</td>'+
                                      '<td style="width: 100px; word-wrap: break-word">'+ 
                                        '<input type="hidden" name="pendanaan_id" value="'+value.id+'">'+
                                        '<button type="submit" class="btn btn-primary btn-sm" id="edit_pendanaan_'+value.id+'">Edit</button>'+
                                      '</td>'+
                                  '</tr>'+
                                '</table>'+
                                '</form>'+
                                //     '<div class="row">'+
                                //     '<form action="{{ route('admin.investor.edit_pendanaan_investor') }}" method="POST">@csrf'+
                                //     '<div class="col-1">'+ noAktif +'</div>'+
                                //     '<div class="col-3">'+ value.nama +'</div>'+
                                //     '<div class="col-3">'+ tgl_selesai[2]+'-'+tgl_selesai[1]+'-'+tgl_selesai[0] +'</div>'+
                                //     '<div class="col-3"><input type="text" class="form-control" id="qty_'+value.id+'" name="nominal" value="'+numberFormat(value.total_dana.split(".")[0])+'"></div>'+
                                //     // '<div ">'+ value.tipe_user +'</div>'+
                                //     // '<div class="col-2"><label >'+ tgl_invest[2]+'-'+tgl_invest[1]+'-'+tgl_invest[0] +'</label></div>'+
                                //     '<div class="col-1">'+
                                //         '<input type="hidden" name="pendanaan_id" value="'+value.id+'">'+
                                //         '<button class="btn btn-primary btn-sm" id="edit_pendanaan_'+value.id+'">Edit</button>'+
                                //     '</div>'+
                                // '</form>'+
                                // '</div>'+
                                '<hr>'
                            );
                        noAktif++

                            $("#qty_"+value.id).on('keyup', function() {
                                // 1
                                var $this = $( this );
                                var input = $this.val();
                                
                                // 2
                                var input = input.replace(/[\D\s\._\-]/g, "");
                                
                                // 3
                                input = input ? parseInt( input, 10 ) : 0;
                                
                                // 4
                                $this.val( function() {
                                    return ( input === 0 ) ? 0 : input.toLocaleString( "en-US" );
                                });
                            })
                        })

                        $.each(data.data_selesai,function(index,value){
                            // tgl_invest = value.tanggal_invest.split(" ")[0].split("-");
                            tgl_selesai = value.tgl_selesai.split(" ")[0].split("-");
                            $('#detilPendanaan').find('.tab-content').find('#selesai').find('.detilPendanaan-body').find('#detilSelesai').append(
                                '<form action="{{ route('admin.investor.edit_pendanaan_selesai_investor') }}" method="POST">@csrf'+
                                '<table class="table text-left">'+
                                  '<tr>'+
                                      '<td style="width: 50px; word-wrap: break-word">'+ noSelesai +'</td>'+
                                      '<td style="width: 180px; word-wrap: break-word">'+ value.nama +'</td>'+
                                      '<td style="width: 120px; word-wrap: break-word">'+ tgl_selesai[2]+'-'+tgl_selesai[1]+'-'+tgl_selesai[0] +'</td>'+
                                      '<td style="width: 200px; word-wrap: break-word">'+ '<input type="text" class="form-control" id="qty_selesai_'+value.id+'" name="nominal_selesai" value="'+numberFormat(value.nominal.split(".")[0])+'">'+'</td>'+
                                      '<td style="width: 100px; word-wrap: break-word">'+ 
                                        '<input type="hidden" name="pendanaan_id" value="'+value.id+'">'+
                                        '<button type="submit" class="btn btn-primary btn-sm" id="edit_pendanaan_'+value.id+'">Edit</button>'+
                                      '</td>'+
                                  '</tr>'+
                                '</table>'+
                                '</form>'+
                                '<hr>'
                            );
                        noSelesai++

                            $("#qty_selesai_"+value.id).on('keyup', function() {
                                // 1
                                var $this = $( this );
                                var input = $this.val();
                                
                                // 2
                                var input = input.replace(/[\D\s\._\-]/g, "");
                                
                                // 3
                                input = input ? parseInt( input, 10 ) : 0;
                                
                                // 4
                                $this.val( function() {
                                    return ( input === 0 ) ? 0 : input.toLocaleString( "en-US" );
                                });
                            })
                        })
                    }
                });
                
            });

            $('#table_investor tbody').on( 'click', '#kelola_proyek', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                // console.log(id)
                $('#kelolaProyek').find('.kelolaProyek-body').html('');
                $.ajax({
                    url : "/admin/investor/data_proyek/"+id,
                    method : "get",
                    success:function(data)
                    {
                        console.log(data.data_total)
                        $('#total_dana').val(numberFormat(data.data_total.unallocated));
                        // var no = 1;
                        $.each(data.data_proyek,function(index,value){
                            var bagi_hasil = value.profit_margin.split(".");
                            var selisih = dateDiff(new Date(),value.tgl_selesai_penggalangan);
                            selisih += 1;
                            $('#kelolaProyek').find('.kelolaProyek-body').append(
                                '<div class="row">'+
                                    '<div class="col-3">'+value.nama+'</div>'+
                                    '<div class="col-1">'+bagi_hasil[0]+'%</div>'+
                                    '<div class="col-2">'+numberFormat(value.harga_paket)+'</div>'+
                                    '<div class="col-2">'+numberFormat(value.terkumpul)+'</div>'+
                                    '<div class="col-1">'+selisih+' hari</div>'+
                                    '<div class="col-3">'+
                                        '<form class="form-inline" action="{{ route('admin.pendanaan') }}" method="POST">@csrf'+
                                        '<input type="hidden" name="investor_id" value="'+data.data_total.investor_id+'">'+
                                        '<input type="hidden" name="proyek_id" value="'+value.id+'">'+
                                        '<input type="hidden" name="tanggal_invest" value="'+new Date().toLocaleDateString("en-US")+'">'+
                                        '<input type="number" class="form-control col-sm-6" name="jumlah_paket" placeholder="Paket">'+
                                        '<button class="btn btn-primary btn-sm ml-1" id="tambah_proyek_'+value.id+'">Tambah</button>'+
                                        '</form>'+
                                    '</div>'+
                                '</div>'+
                                '<hr>'
                            );
                        // no++

                            // $('#tambah_proyek_'+value.id).on('click',function(e){
                            //     e.preventDefault();
                            //     $(this).attr('style','display:none');
                            // });
                        })
                    }
                });
                
            });

            $('#table_investor tbody').on( 'click', '#reg_digisign', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                console.log(id)
                $.ajax({
                    url : "/admin/investor/regDigiSign/"+id,
                    method : "get",
                    beforeSend: function() {
                        $("#overlay").css('display','block');
                    },      
                    success:function(data)
                    {
                        $("#overlay").css('display','none');
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
                                            url : "/admin/investor/callbackDigiSignInvestor/",
                                            method : "post",
                                            data : {user_id:id,provider_id:1,status:dataJSON.JSONFile.notif,step:'register',url:url_notif},
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
                    },
                    error: function(request, status, error)
                    {
                        $("#overlay").css('display','none');
                        alert(status)
                    }                
                });
                
            });

            $('#table_investor tbody').on( 'click', '#send_digisign', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                console.log(id)
                $.ajax({
                    url : "/admin/investor/sendDigiSign/"+id,
                    method : "get",
                    beforeSend: function() {
                        $("#overlay").css('display','block');
                    },
                    success:function(data)
                    {
                        $("#overlay").css('display','none');
                        var dataJSON = JSON.parse(data.status_all);
                        console.log(dataJSON);
                        swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                          function(){
                               investorTable.ajax.reload();
                           }
                        );
                        
                    },
                    error: function(request, status, error)
                    {
                        $("#overlay").css('display','none');
                        alert(status)
                    } 
                });
                
            });

            $('#table_investor tbody').on( 'click', '#sign_digisign', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                console.log(id)
                $.ajax({
                    url : "/admin/investor/signDigiSign/"+id,
                    method : "get",
                    beforeSend: function() {
                        $("#overlay").css('display','block');
                    },
                    success:function(data)
                    {
                        $("#overlay").css('display','none');
                        console.log(data.status_all) 
                    },
                    error: function(request, status, error)
                    {
                        $("#overlay").css('display','none');
                        alert(status)
                    } 
                });
                
            });

            $('#table_investor tbody').on( 'click', '#create_doc', function () {
                var data = investorTable.row( $(this).parents('tr') ).data();
                id = data.idInvestor;
                console.log(id)
                $.ajax({
                    url : "/admin/investor/createDocDigisign/"+id,
                    method : "get",
                    success:function(data)
                    {
                        console.log(data.status)
                        
                    }
                });
                
            });

            $(".qty").on('keyup', function() {
            // $('.qty').keyup(function() {
                // 1
                var $this = $( this );
                var input = $this.val();
                
                // 2
                var input = input.replace(/[\D\s\._\-]+/g, "");
                
                // 3
                input = input ? parseInt( input, 10 ) : 0;
                
                // 4
                $this.val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                } );
            })

            $('#provinsi').on('change',function(e){
                e.preventDefault();
                var kode_provinsi = this.value;
                $('#kota').empty();
                $.ajax({
                    url : "/admin/getKota/"+kode_provinsi,
                    method : "get",
                    success:function(data)
                    {
                        $.each(data.kota,function(index,value){
                            $('#kota').append(
                                '<option value="'+value.kode_kota+'">'+value.nama_kota+'</option>'
                            );
                        })
                    }
                });
            });
        });

        (function($) {
        $.fn.inputFilter = function(inputFilter) {
          return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
            if (inputFilter(this.value)) {
              this.oldValue = this.value;
              this.oldSelectionStart = this.selectionStart;
              this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
              this.value = this.oldValue;
              this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            }
          });
        };
        }(jQuery));

        $("#no_telp").inputFilter(function(value) {
            return /^\d*$/.test(value); });

        $("#no_ktp").inputFilter(function(value) {
            return /^\d*$/.test(value); });

        $("#rekening").inputFilter(function(value) {
            return /^\d*$/.test(value); });

        function checkPhoneNumber(x) {
            $.ajax({
                url :  "/user/checkPhone/"+x,
                method : "get",
                success:function(data)
                {
                  if(data.error){  
                    alert(data.error);
                    $('input[name=no_telp').val('');
                  }else{
                    true;
                  }
                }
            });
        }

        function getIdMutasi(id){
                var table_mutasi = $('#table_list_mutasi_proyek_investor').DataTable({
                    "destroy":true,
                    "bSort": false,
                    "searching":true,
                    "paging":false,
                    "lengthChange": true,
                    ajax: {
                        url : "/admin/investor/data_mutasi_proyek/"+id,
                        method : "get",
                    },
                    
                    "columns" : [
                        {"data" : "nama"},
                        {"data" : "alamat"},
                        {"data" : "tgl_mulai"},
                        {"data" : "tanggal_invest"},
                        {"data" : "tgl_selesai"},
                        {"data" : "aksi"},
                    ],
                    "columnDefs": [
                      {
                        "targets": 0,
                        class : 'text-left',
                        //"visible" : false
                      },
                      {
                        "targets": 1,
                        class : 'text-left',
                        // "render": function ( data, type, row, meta ) {
                        //   return row['nama'];
                        // }
                        //"visible" : false
                      },
                      {
                        "targets": 2,
                        class : 'text-left',
                        //"visible" : false
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
                        "render": function ( data, type, row, meta ) {
                            return '<button class="btn btn-info btn-sm active" onclick="myFunction('+row['pendanaanAktifId']+')" id="klik">Riwayat Mutasi Proyek</button>';
                        }
                        //"visible" : false
                      },
                    ]
                    
                });
        }

        function myFunction(id){

            var html = "";
            var htmladd = "";
            $.ajax({
                url : "/admin/investor/data_detil_mutasi_proyek/"+id,
                method : "get",
                success:function(data){
                    $.each(data.datadetil,function(index,value){
                        htmladd = "<tr><td>"+value.tipe+"</td><td> Rp. "+value.nominal+"</td><td>"+value.created_at+"</td></tr>";
                        html += htmladd;
                    })
                    console.log(html);
                    Swal.fire({
                        html:
                            "<h1>Riwayat Mutasi Proyek</h1><br>" +
                            "<table border='1' align='center' width='95%'><thead><td width='40%'>Riwayat</td><td width='30%'>Nominal</td><td width='30%'>Tanggal</td></thead>"+
                            "<tbody>"+
                            html+
                            "</tbody></table>"
                        
                    })
                }
            });
        }
    </script>
   
@endsection