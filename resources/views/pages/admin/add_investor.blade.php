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
    
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Tambah Pendana</strong>
        </div>
        <div class="card-body">
            <form action="{{route('admin.investor.create')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <legend class="col-form-label col-sm-3 font-weight-bold">Tipe Pengguna</legend>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipe_pengguna" id="perorangan" value="1" checked="checked" required>
                    <label class="form-check-label" for="perorangan">Perorangan</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipe_pengguna" id="badan_hukum" value="2" required>
                    <label class="form-check-label" for="badan_hukum">Badan Hukum</label>
                </div>
            </div>

            
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="username" class="font-weight-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="form-group col-sm-4">
                    <label for="password" class="font-weight-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-6">
                    <label for="nama" class="font-weight-bold">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="email" class="font-weight-bold">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
            </div>
            <div id="data_badan_hukum" style="display: none;">
                <div class="form-group">
                    <label for="jenis_badan_hukum" class="font-weight-bold">Jenis Badan Hukum</label>
                    <select name="jenis_badan_hukum" class="form-control col-sm-10">
                            <option value="0">--Pilih--</option>
                            @foreach($master_badan_hukum as $b)
                                <option value={{ $b->id_badan_hukum }}>{{ $b->badan_hukum }}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div id="data_perorangan" style="display: none;">
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="tempat_lahir" class="font-weight-bold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
                    </div>
                    <div class="form-group col-sm-5">
                        <label for="tanggal_lahir" class="font-weight-bold">Tanggal Lahir</label>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <input type="number" name="tgl_lahir" class="form-control" placeholder="Tgl">
                            </div>
                            <div class="col-sm-4">
                                <input type="number" name="bln_lahir" class="form-control" placeholder="Bln">
                            </div>
                            <div class="col-sm-4">
                                <input type="number" name="thn_lahir" class="form-control" placeholder="Thn">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="0">--Pilih--</option>
                            @foreach ($master_jenis_kelamin as $b)
                                <option value="{{$b->id_jenis_kelamin}}">{{$b->jenis_kelamin}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-3" id="data_perorangan_1" style="display: none;">
                    <label for="no_ktp" class="font-weight-bold">No KTP</label>
                    <input type="text" name="no_ktp" class="form-control" placeholder="No KTP">
                </div>
                <div class="form-group col-sm-3">
                    <label for="no_npwp" class="font-weight-bold">No NPWP</label>
                    <input type="text" name="no_npwp" class="form-control" placeholder="No NPWP">
                </div>
                <div class="form-group col-sm-3">
                    <label for="no_telp" class="font-weight-bold">No Telp / HP</label>
                    <input type="text" name="no_telp" class="form-control" placeholder="No Telp / HP" required>
                </div>
            </div>
            <div class="form-group">
                <label for="alamat" class="font-weight-bold">Alamat</label>
                <textarea name="alamat" class="form-control col-sm-10" rows="3" id="alamat" placeholder="Alamat Lengkap"></textarea>
            </div>
            {{-- <div class="form-group">
                <label for="negara" class="font-weight-bold">Negara</label>
                <select name="negara" class="form-control col-sm-5" required>
                    <option value="0">--Pilih--</option>
                </select>
            </div> --}}
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="provinsi" class="font-weight-bold">Provinsi</label>
                    <select name="provinsi" class="form-control" id="provinsi">
                        <option value="0">--Pilih--</option>
                        @foreach ($master_provinsi as $data)
                            <option value={{$data->kode_provinsi}}>{{$data->nama_provinsi}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="kota" class="font-weight-bold">Kota</label>
                    <select name="kota" class="form-control" id="kota">
                        {{-- <option value="0">--Pilih--</option> --}}
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label for="kode_pos" class="font-weight-bold">Kode Pos</label>
                    <input type="text" name="kode_pos" class="form-control" id="kode_pos" placeholder="Kode Pos">
                </div>
            </div>
            <div id="data_perorangan_2" style="display: none;">
                <div class="form-group">
                    <label for="pemilik_rumah" class="font-weight-bold">Status Kepemilikan Rumah</label>
                    <select name="pemilik_rumah" class="form-control col-sm-5">
                        <option value="0">--Pilih--</option>
                        @foreach($master_kepemilikan_rumah as $b)
                            <option value="{{ $b->id_kepemilikan_rumah }}">{{ $b->kepemilikan_rumah }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="data_perorangan_3" style="display: none;">
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="agama" class="font-weight-bold">Agama</label>
                        <select name="agama" class="form-control">
                            <option value="0">--Pilih--</option>
                            @foreach($master_agama as $b)
                                <option value="{{ $b->id_agama }}">{{ $b->agama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="kawin" class="font-weight-bold">Status Perkawinan</label>
                        <select name="kawin" class="form-control" id="kawin">
                            <option value="0">--Pilih--</option>
                            @foreach($master_kawin as $b)
                                <option value="{{ $b->id_kawin }}">{{ $b->jenis_kawin }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <fieldset class="scheduler-border" id="pasangan" style="display: none;">
                <legend class="scheduler-border legend-title">Data Pasangan</legend>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="nama" class="font-weight-bold">Nama</label>
                            <input type="text" name="nama_pasangan" class="form-control" placeholder="Nama">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input type="email" name="email_pasangan" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="tempat_lahir" class="font-weight-bold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir_pasangan" class="form-control" placeholder="Tempat Lahir">
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="tanggal_lahir" class="font-weight-bold">Tanggal Lahir</label>
                            <div class="form-row">
                                <div class="col-sm-4">
                                    <input type="number" name="tgl_lahir_pasangan" class="form-control" placeholder="Tgl">
                                </div>
                                <div class="col-sm-4">
                                    <input type="number" name="bln_lahir_pasangan" class="form-control" placeholder="Bln">
                                </div>
                                <div class="col-sm-4">
                                    <input type="number" name="thn_lahir_pasangan" class="form-control" placeholder="Thn">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin</label>
                            <select name="jenis_kelamin_pasangan" class="form-control">
                                <option value="0">--Pilih--</option>
                                @foreach($master_jenis_kelamin as $b)
                                    <option value="{{ $b->id_jenis_kelamin }}">{{ $b->jenis_kelamin }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="no_ktp" class="font-weight-bold">No KTP</label>
                            <input type="text" name="no_ktp_pasangan" class="form-control" placeholder="No KTP">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="no_npwp" class="font-weight-bold">No NPWP</label>
                            <input type="text" name="no_npwp_pasangan" class="form-control" placeholder="No NPWP">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="no_telp" class="font-weight-bold">No Telp / HP</label>
                            <input type="text" name="no_telp_pasangan" class="form-control" placeholder="No Telp / HP">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="font-weight-bold">Alamat</label>
                        <textarea name="alamat_pasangan" class="form-control col-sm-10" rows="3" id="alamat_pasangan" placeholder="Alama Lengkap"></textarea>
                    </div>
                   {{--  <div class="form-group">
                        <label for="negara_pasangan" class="font-weight-bold">Negara</label>
                        <select name="negara_pasangan" class="form-control col-sm-5" required>
                            <option value="0">--Pilih--</option>
                        </select>
                    </div> --}}
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="provinsi" class="font-weight-bold">Provinsi</label>
                            <select name="provinsi_pasangan" class="form-control" id="provinsi_pasangan">
                                <option value="0">--Pilih--</option>
                                @foreach ($master_provinsi as $data)
                                    <option value={{$data->kode_provinsi}}>{{$data->nama_provinsi}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="kota" class="font-weight-bold">Kota</label>
                            <select name="kota_pasangan" class="form-control" id="kota_pasangan">
                                {{-- <option value="0">--Pilih--</option> --}}
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="kode_pos" class="font-weight-bold">Kode Pos</label>
                            <input type="text" name="kode_pos_pasangan" class="form-control" id="kode_pos_pasangan" placeholder="Kode Pos">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="agama" class="font-weight-bold">Agama</label>
                            <select name="agama_pasangan" class="form-control">
                                <option value="0">--Pilih--</option>
                                @foreach($master_agama as $b)
                                    <option value="{{ $b->id_agama }}">{{ $b->agama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="pekerjaan" class="font-weight-bold">Pekerjaan</label>
                            <select name="pekerjaan_pasangan" class="form-control">
                                <option value="0">--Pilih--</option>
                                @foreach($master_pekerjaan as $b)
                                    <option value="{{ $b->id_pekerjaan }}">{{ $b->pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="bidang_pekerjaan" class="font-weight-bold">Bidang Pekerjaan</label>
                            <select name="bidang_pekerjaan_pasangan" class="form-control">
                                <option value="0">--Pilih--</option>
                                @foreach($master_bidang_pekerjaan as $b)
                                    <option value="{{ $b->kode_bidang_pekerjaan }}">{{ $b->bidang_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="pekerjaan_online" class="font-weight-bold">Pekerjaan Online</label>
                            <select name="pekerjaan_online_pasangan" class="form-control">
                                <option value="0">--Pilih--</option>
                                @foreach($master_online as $b)
                                    <option value="{{ $b->id_online }}">{{ $b->tipe_online }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pendapatan" class="font-weight-bold">Pendapatan</label>
                        <select name="pendapatan_pasangan" class="form-control col-sm-5">
                            <option value="0">--Pilih--</option>
                            @foreach($master_pendapatan as $b)
                                <option value="{{ $b->id_pendapatan }}">{{ $b->pendapatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="pengalaman" class="font-weight-bold">Pengalaman Kerja</label>
                            <select name="pengalaman_pasangan" class="form-control">
                                <option value="0">--Pilih--</option>
                                @foreach($master_pengalaman_kerja as $b)
                                    <option value="{{ $b->id_pengalaman_kerja }}">{{ $b->pengalaman_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="pendidikan" class="font-weight-bold">Pendidikan</label>
                            <select name="pendidikan_pasangan" class="form-control">
                                <option value="0">--Pilih--</option>
                                @foreach($master_pendidikan as $b)
                                    <option value="{{ $b->id_pendidikan }}">{{ $b->pendidikan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="rekening" class="font-weight-bold">Rekening</label>
                            <input type="text" name="rekening" class="form-control" placeholder="Rekening" required>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="bank" class="font-weight-bold">Bank</label>
                            <input type="text" name="bank" class="form-control" placeholder="Bank" required>
                        </div>
                    </div> --}}
                    <div class="float-right">
                        <button type="button" class="btn btn-success" id="hide_pasangan">Sembunyikan</button>
                    </div>
            </fieldset>

            <div class="form-row">
                <div class="form-group col-sm-3" id="data_perorangan_4" style="display: none;">
                    <label for="pekerjaan" class="font-weight-bold">Pekerjaan</label>
                    <select name="pekerjaan" class="form-control">
                        <option value="0">--Pilih--</option>
                        @foreach($master_pekerjaan as $b)
                            <option value="{{ $b->id_pekerjaan }}">{{ $b->pekerjaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="bidang_pekerjaan" class="font-weight-bold">Bidang Pekerjaan</label>
                    <select name="bidang_pekerjaan" class="form-control">
                        <option value="0">--Pilih--</option>
                        @foreach($master_bidang_pekerjaan as $b)
                            <option value="{{ $b->kode_bidang_pekerjaan }}">{{ $b->bidang_pekerjaan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="pekerjaan_online" class="font-weight-bold">Pekerjaan Online</label>
                    <select name="pekerjaan_online" class="form-control">
                        <option value="0">--Pilih--</option>
                        @foreach($master_online as $b)
                            <option value="{{ $b->id_online }}">{{ $b->tipe_online }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="pendapatan" class="font-weight-bold">Pendapatan</label>
                    <select name="pendapatan" class="form-control">
                        <option value="0">--Pilih--</option>
                        @foreach($master_pendapatan as $b)
                            <option value="{{ $b->id_pendapatan }}">{{ $b->pendapatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4" id="data_badan_hukum_1" style="display: none;">
                    <label for="asset" class="font-weight-bold">Total Asset</label>
                    <select name="asset" class="form-control">
                        <option value="0">--Pilih--</option>
                        @foreach($master_asset as $b)
                            <option value="{{ $b->id_asset }}">{{ $b->asset }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="form-group">
                <label for="pendapatan" class="font-weight-bold">Pendapatan</label>
                <select name="pendapatan" class="form-control col-sm-5">
                    <option value="0">--Pilih--</option>
                    @foreach($master_pendapatan as $b)
                        <option value="{{ $b->id_pendapatan }}">{{ $b->pendapatan }}</option>
                    @endforeach
                </select>
            </div> --}}
            <div id="data_perorangan_5" style="display: none;">
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="pengalaman" class="font-weight-bold">Pengalaman Kerja</label>
                        <select name="pengalaman" class="form-control">
                            <option value="0">--Pilih--</option>    
                            @foreach($master_pengalaman_kerja as $b)
                                <option value="{{ $b->id_pengalaman_kerja }}">{{ $b->pengalaman_kerja }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pendidikan" class="font-weight-bold">Pendidikan</label>
                        <select name="pendidikan" class="form-control">
                            <option value="0">--Pilih--</option>
                            @foreach($master_pendidikan as $b)
                                <option value="{{ $b->id_pendidikan }}">{{ $b->pendidikan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="rekening" class="font-weight-bold">No Rekening</label>
                    <input type="text" name="rekening" class="form-control" placeholder="No Rekening">
                </div>
                <div class="form-group col-sm-4">
                    <label for="bank" class="font-weight-bold">Bank</label>
                    <select name="bank" class="form-control">
                        <option value="0">--Pilih--</option>
                        @foreach($master_bank as $b)
                            <option value="{{ $b->kode_bank }}">{{ $b->nama_bank }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="data_badan_hukum_2" style="display: none;">
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="nama_perwakilan" class="font-weight-bold">Nama Perwakilan</label>
                        <input type="text" name="nama_perwakilan" class="form-control" placeholder="Perwakilan">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="no_ktp_perwakilan" class="font-weight-bold">No KTP Perwakilan</label>
                         <input type="text" name="no_ktp_perwakilan" class="form-control" placeholder="No KTP Perwakilan">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                    <label for="foto_diri" class="font-weight-bold">Foto Diri</label>
                    <input type="file" class="form-control" name="pic_investor" placeholder="Type Here" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                    <label for="foto_ktp" class="font-weight-bold">Foto KTP</label>
                    <input type="file" class="form-control" name="pic_ktp_investor" placeholder="Type Here" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                    <label for="foto_diri_ktp" class="font-weight-bold">Foto Diri Dengan KTP</label>
                    <input type="file" class="form-control" name="pic_user_ktp_investor" placeholder="Type Here">
                </div>
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            {{-- </div> --}}
                {{-- <div class="row form-group">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="username" class=" form-control-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email" class=" form-control-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>
                        
                <div class="form-group">
                    <label for="password" class=" form-control-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Nama (sesuai KTP)</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="text" class="form-control" name="nama_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">No KTP</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="number" class="form-control" name="no_ktp_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">No NPWP <br> * jika ada</label>         
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="number" class="form-control" name="no_npwp_investor" placeholder="Type Here">
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Nomor Telephone</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="number" class="form-control" name="phone_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Nama Pasangan/keluarga</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="string" class="form-control" name="pasangan_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Nomor Pasangan/keluarga</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="number" class="form-control" name="pasangan_phone" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Pekerjaan</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="string" class="form-control" name="job_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Alamat</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="string" class="form-control" name="alamat_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Rekening</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="number" class="form-control" name="rekening" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Bank</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="string" class="form-control" name="bank" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Foto Diri</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="file" class="form-control" name="pic_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Foto KTP</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="file" class="form-control" name="pic_ktp_investor" placeholder="Type Here" required>
                    </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                    <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Foto Diri memegang KTP</label>
                    <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                        <input type="file" class="form-control" name="pic_user_ktp_investor" placeholder="Type Here" required>
                    </div>
                </div> --}}
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Buat</button>                        
                </div> --}}
            </form>
        </div>
    </div>
</div>
</div>
</div>

<!-- modal data pasangan -->
    <div class="modal fade" id="pasanganModal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="scrollmodalLabel">Tambah Pendana</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success" id="add_pasangan">Tambah</button>
            </div>
            </form>
        </div>
    </div>
    </div>
    <!-- end of modal data pasangan -->
</div><!-- .content -->
<style>
    fieldset.scheduler-border {
        border: 1px groove #ddd !important;
        border-radius: 5px;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow:  0px 0px 0px 0px #000;
                box-shadow:  0px 0px 0px 0px #000;
        background-color: #b9b4b9;
    }

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border: 5px black!important;
        border-radius: 5px;
        background-color: white;
        /*border-bottom:none;*/
        border-radius: 5px;
    }
</style>

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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // $('input[type=radio][name=tipe_pengguna]').change(function(e) {
            // e.preventDefault();
            var tipe_pengguna = $('input[type=radio][name=tipe_pengguna]:checked').val();
            // console.log(this.value)
            console.log(tipe_pengguna)
            if (tipe_pengguna == 1) {
                $('#data_perorangan').attr('style','display: block;');
                $('#data_perorangan_1').attr('style','display: block;');
                $('#data_perorangan_2').attr('style','display: block;');
                $('#data_perorangan_3').attr('style','display: block;');
                $('#data_perorangan_4').attr('style','display: block;');
                $('#data_perorangan_5').attr('style','display: block;');
                $('#data_badan_hukum').attr('style','display: none;');
                $('#data_badan_hukum_1').attr('style','display: none;');
                $('#data_badan_hukum_2').attr('style','display: none;');
            }
            else if (tipe_pengguna == 2) {
                $('#data_perorangan').attr('style','display: none;');
                $('#data_perorangan_1').attr('style','display: none;');
                $('#data_perorangan_2').attr('style','display: none;');
                $('#data_perorangan_3').attr('style','display: none;');
                $('#data_perorangan_4').attr('style','display: none;');
                $('#data_perorangan_5').attr('style','display: none;');
                $('#data_badan_hukum').attr('style','display: block;');
                $('#data_badan_hukum_1').attr('style','display: block;');
                $('#data_badan_hukum_2').attr('style','display: block;');
            }
        // });

        $('input[type=radio][name=tipe_pengguna]').change(function(e) {
          e.preventDefault();
          console.log(this.value)
          if (this.value == 1) {
              $('#data_perorangan').attr('style','display: block;');
              $('#data_perorangan_1').attr('style','display: block;');
              $('#data_perorangan_2').attr('style','display: block;');
              $('#data_perorangan_3').attr('style','display: block;');
              $('#data_perorangan_4').attr('style','display: block;');
              $('#data_perorangan_5').attr('style','display: block;');
              $('#data_badan_hukum').attr('style','display: none;');
              $('#data_badan_hukum_1').attr('style','display: none;');
              $('#data_badan_hukum_2').attr('style','display: none;');
          }
          else if (this.value == 2) {
              $('#data_perorangan').attr('style','display: none;');
              $('#data_perorangan_1').attr('style','display: none;');
              $('#data_perorangan_2').attr('style','display: none;');
              $('#data_perorangan_3').attr('style','display: none;');
              $('#data_perorangan_4').attr('style','display: none;');
              $('#data_perorangan_5').attr('style','display: none;');
              $('#data_badan_hukum').attr('style','display: block;');
              $('#data_badan_hukum_1').attr('style','display: block;');
              $('#data_badan_hukum_2').attr('style','display: block;');
          }
        });

        $('#kawin').change(function(e){
            e.preventDefault();
            console.log(this.value)
            if (this.value == '1')
            {
                $('#pasangan').attr('style','display:block;');
                $('#alamat_pasangan').val($('#alamat').val());
                $('#provinsi_pasangan').val($('#provinsi').val());
                
                $('#kota_pasangan').empty();
                $.ajax({
                    url : "/admin/getKota/"+$('#provinsi_pasangan').val(),
                    method : "get",
                    success:function(data)
                    {
                        $.each(data.kota,function(index,value){
                            if (value.kode_kota == $('#kota').val())
                            {
                                var select = "selected";
                            }
                            $('#kota_pasangan').append(
                                '<option value="'+value.kode_kota+'" '+select+'>'+value.nama_kota+'</option>'
                            );
                        })
                    }
                });
                $('#kode_pos_pasangan').val($('#kode_pos').val());
            }
            else
            {
                $('#pasangan').attr('style','display:none;');
            }
        });

        $('#hide_pasangan').on('click',function(e){
            e.preventDefault();
            $('#pasangan').attr('style','display: none;');
        });

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

        // $('#provinsi_badan_hukum').on('change',function(e){
        //     e.preventDefault();
        //     var kode_provinsi = this.value;
        //     $('#kota_badan_hukum').empty();
        //     $.ajax({
        //         url : "/admin/getKota/"+kode_provinsi,
        //         method : "get",
        //         success:function(data)
        //         {
        //             $.each(data.kota,function(index,value){
        //                 $('#kota_badan_hukum').append(
        //                     '<option value="'+value.kode_kota+'">'+value.nama_kota+'</option>'
        //                 );
        //             })
        //         }
        //     });
        // });

        $('#provinsi_pasangan').on('change',function(e){
            e.preventDefault();
            var kode_provinsi = this.value;
            $('#kota_pasangan').empty();
            $.ajax({
                url : "/admin/getKota/"+kode_provinsi,
                method : "get",
                success:function(data)
                {
                    $.each(data.kota,function(index,value){
                        $('#kota_pasangan').append(
                            '<option value="'+value.kode_kota+'">'+value.nama_kota+'</option>'
                        );
                    })
                }
            });
        });
    });
</script>
@endsection