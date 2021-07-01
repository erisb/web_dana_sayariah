@extends('layouts.user.sidebar')

@section('title', 'User Verification')

@section('content')
<div class="row">
    @if (session('error'))
        <div class="alert alert-danger col-sm-12">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
          <div class="alert alert-success col-sm-12">
              {{ session('success') }}
          </div>
    @endif
    @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
    @endif
</div>
@if(session('confirmationemail'))
  <div class="row">
    <div class="col-sm-12 col-lg-8 mx-auto">
      <?php
        $virtual_account = false
       ?>
      <div class="card bg-dark text-light">
        <div class="card-body text-center">
                  
          <h2 style="color:white">Silahkan Konfirmasi Email pada email yang anda daftarkan </h2>
          <p style="color:white">Silahkan cek folder spam jika email tidak ditemukan</p>
        
        </div>
      </div>
    </div>
  </div>
@elseif(session('waitinglist'))
  <div class="card bg-dark text-light">
    <div class="card-body text-center">
      <h2 style="color:white">Silahkan Tunggu Verifikasi dari Danasyariah</h2>
      <p style="color:white">terimakasih telah bergabung untuk maju bersama kami</p>
    </div>
  </div>

@elseif(session('suspend'))
  <div class="card bg-dark text-light">
    <div class="card-body text-center">
      <h2 style="color:white">Akun anda telah Kami suspend !</h2>
      <p style="color:white">Silahkan hubungi pihak kami untuk aktivasi kembali akun</p>
    </div>
  </div>

@elseif(session('datareject'))
  <div class="row">
    <div class="col-sm-12 col-lg-8 mx-auto">
      <div class="card bg-dark text-light">
        <div class="card-body text-center">
          <h2 style="color:white">Data Anda Gagal di Verifikasi.<br>Silahkan isikan data diri anda dengan data yang benar dan asli :</h2>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-sm-12 col-lg-12 ">
      <form action="{{route('updateUserReject')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3><b>Data Pribadi</b></h3>
            <hr>
            <fieldset>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="nama" class="font-weight-bold">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{!empty(session('detil')->nama_investor) ? session('detil')->nama_investor : ''}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="tempat_lahir" class="font-weight-bold">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" value="{{!empty(session('detil')->tempat_lahir_investor) ? session('detil')->tempat_lahir_investor : ''}}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="tanggal_lahir" class="font-weight-bold">Tanggal Lahir</label>
                        @php
                        $data_tgl = !empty(session('detil')->tgl_lahir_investor) ? explode("-",session('detil')->tgl_lahir_investor) : '';
                        // tgl
                        $cek_tgl = 0;
                        if(strlen($data_tgl[0])  == 2)
                        {
                          if($data_tgl[0][0] == 0)
                          {
                            $cek_tgl = $data_tgl[0][1];
                          }
                          else
                          {
                            $cek_tgl = $data_tgl[0];
                          }
                        }
                        else
                        {
                            $cek_tgl = $data_tgl[0];
                        }
                        // end tgl
                        // bulan
                          $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
                          $cek_bln = 0;
                          if(strlen($data_tgl[1]) == 2)
                          {
                            if($data_tgl[1][0] == 0)
                            {
                              $cek_bln = $data_tgl[1][1];
                            }
                            else
                            {
                              $cek_bln = $data_tgl[1];
                            }
                          }
                          else
                          {
                             $cek_bln = $data_tgl[1];
                          }
                          // echo $data_tgl[2];die;
                        // end bulan
                        @endphp
                        <div class="form-row">
                            <div class="col-sm-3">
                                <select name="tgl_lahir" class="form-control">
                                <option value="">--Pilih--</option>
                                @for($i=1;$i<=31;$i++)
                                    <option value={{$i}} {{$i == $cek_tgl ? 'selected' : ''}}>{{$i}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select name="bln_lahir" class="form-control">
                                <option value="">--Pilih--</option>
                                @for($i=0;$i<=11;$i++)
                                    <option value="{{$i+1}}" {{$i == $cek_bln-1 ? 'selected' : ''}}>{{$data_bulan[$i]}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="thn_lahir" class="form-control" id="thn_lahir_reject">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">--Pilih--</option>
                            @foreach (session('master_jenis_kelamin') as $b)
                                <option value="{{$b->id_jenis_kelamin}}" {{!empty(session('detil')->jenis_kelamin_investor) && $b->id_jenis_kelamin == session('detil')->jenis_kelamin_investor ? 'selected=selected' : ''}}>{{$b->jenis_kelamin}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
              {{-- </div> --}}
                <div class="form-row">
                    <div class="form-group col-sm-3" id="data_perorangan_1">
                        <label for="no_ktp" class="font-weight-bold">No KTP</label>
                        <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="{{!empty(session('detil')->no_ktp_investor) ? session('detil')->no_ktp_investor : ''}}" placeholder="No KTP">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="no_npwp" class="font-weight-bold">No NPWP</label>
                        <input type="text" name="no_npwp" class="form-control" value="{{!empty(session('detil')->no_npwp_investor) ? session('detil')->no_npwp_investor : ''}}" placeholder="No NPWP">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="no_telp" class="font-weight-bold">No HP</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control" value="{{!empty(session('detil')->phone_investor) ? session('detil')->phone_investor : ''}}" placeholder="No Telp / HP" readonly="readonly">
                    </div>
                </div>
                <div class="form-group">
                    <label for="alamat" class="font-weight-bold">Alamat</label>
                    <textarea name="alamat" class="form-control col-sm-10" rows="3" id="alamat" placeholder="Alamat Lengkap">{{!empty(session('detil')->alamat_investor) ? session('detil')->alamat_investor : ''}}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="provinsi" class="font-weight-bold">Provinsi</label>
                        <select name="provinsi" class="form-control" id="provinsi">
                            <option value="">--Pilih--</option>
                            @foreach (session('master_provinsi') as $data)
                                <option value={{$data->kode_provinsi}} {{!empty(session('detil')->provinsi_investor) && $data->kode_provinsi == session('detil')->provinsi_investor ? 'selected' : ''}}>{{$data->nama_provinsi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="kota" class="font-weight-bold">Kota</label>
                        <input type="hidden" name="kota_hidden" class="form-control" id="kota_hidden" value="{{!empty(session('detil')->kota_investor) ? session('detil')->kota_investor : ''}}">
                        <select name="kota" class="form-control" id="kota">
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="kode_pos" class="font-weight-bold">Kode Pos</label>
                        <input type="text" name="kode_pos" class="form-control" id="kode_pos" value="{{!empty(session('detil')->kode_pos_investor) ? session('detil')->kode_pos_investor : ''}}" placeholder="Kode Pos">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-2 imgUp">
                        <label class="font-weight-bold">Foto Diri</label>
                        <img class="imagePreview" src="{{asset('/storage')}}/{{session('detil')->pic_investor}}">
                        <label class="btn btn-primary">Unggah<input type="file" name="pic_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                        </label>
                    </div>
                    <div class="col-sm-2 imgUp">
                        <label class="font-weight-bold">Foto KTP</label>
                        <img class="imagePreview" src="{{asset('/storage')}}/{{session('detil')->pic_ktp_investor}}">
                        <label class="btn btn-primary">Unggah<input type="file" name="pic_ktp_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                        </label>
                    </div>
                    <div class="col-sm-2 imgUp">
                        <label class="font-weight-bold" style="width: 204px;">Foto Diri dengan KTP</label>
                        <img class="imagePreview" src="{{asset('/storage')}}/{{session('detil')->pic_user_ktp_investor}}">
                        <label class="btn btn-primary">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                        </label>
                    </div>
                </div>
                <p>Format file .jpg, .jpeg, .gif, dan .png</p>
            </fieldset>
            <br>
            <h3><b>Data Rekening</b></h3>
            <hr>
            <fieldset>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="rekening" class="font-weight-bold">No Rekening</label>
                        <input type="text" name="rekening" id="rekening" class="form-control" value="{{!empty(session('detil')->rekening) ? session('detil')->rekening : ''}}" placeholder="No Rekening">
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="rekening" class="font-weight-bold">Nama Pemilik Rekening</label>
                      <input type="text" name="nama_pemilik_rek" class="form-control" placeholder="Nama Pemilik Rekening" value="{{!empty(session('detil')->nama_pemilik_rek) ? session('detil')->nama_pemilik_rek : ''}}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="bank" class="font-weight-bold">Bank</label>
                        <select name="bank" class="form-control">
                            <option value="">--Pilih--</option>
                            @foreach(session('master_bank') as $b)
                                <option value="{{ $b->kode_bank }}" {{!empty(session('detil')->bank_investor) && $b->kode_bank == session('detil')->bank_investor ? 'selected' : ''}}>{{ $b->nama_bank }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- <p><b>*) Wajib Diisi</b></p> --}}
            </fieldset>
            <div class="float-right">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
  </div>
  <script type="text/javascript">
    // generate tahun
    var select2 = document.getElementById('thn_lahir_reject'),
      year2 = new Date().getFullYear(),
      html2 = '<option value="">--Pilih--</option>',
      data_awal = {{session('data_thn')}};
      console.log(data_awal)
      for(i = year2; i >= year2-100; i--) {
        html2 += '<option value="' + i + '" '+(i == data_awal ? "selected" : "")+'>' + i + '</option>';
      }
      select2.innerHTML = html2;
    // end generate tahun

    var provinsi = $('#provinsi option:selected').val();
    $.ajax({
        url : "/getKota/"+provinsi,
        method : "get",
        success:function(data)
        {
            $.each(data.kota,function(index,value){
                if (value.kode_kota == $('#kota_hidden').val())
                {
                    var select = 'selected=selected';
                }
                $('#kota').append(
                    '<option value="'+value.kode_kota+'"'+ select+'>'+value.nama_kota+'</option>'
                );
            })
        }
    });
  </script>
@elseif(session('dataverification'))
  <div class="row">
    <div class="col-sm-12 col-lg-8 mx-auto">
      <div class="card bg-dark text-light">
        <div class="card-body text-center">
          <h2 style="color:white">Silahkan isikan data diri anda dengan data yang benar dan asli :</h2>
        
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-sm-12 col-lg-12 ">
        <!-- <form action="{{route('firstUpdateProfile')}}" method="POST" enctype="multipart/form-data" id="example-advanced-form"> -->
        <form id="example-advanced-form">
            @csrf
        <div id="demo">
          <div class="step-app">

            <ul class="step-steps">
              <li><a href="#tab1"><span class="number">1</span> Data Diri</a></li>
              <li><a href="#tab2"><span class="number">2</span> Data Rekening</a></li>
            </ul>

            <div class="step-content">
              <div class="step-tab-panel" id="tab1">
                {{-- <h3>Data Diri</h3> --}}
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="nama" class="font-weight-bold">Nama *</label>
                        <input type="text" name="nama" class="form-control required" placeholder="Nama" value="{{ old('nama') }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="tempat_lahir" class="font-weight-bold">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" class="form-control required" placeholder="Tempat Lahir" value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="tanggal_lahir" class="font-weight-bold">Tanggal Lahir *</label>
                        @php
                        // bulan
                        $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
                        // end bulan
                        @endphp
                        <div class="form-row">
                            <div class="col-sm-3">
                                <select name="tgl_lahir" class="form-control required">
                                <option value="">--Pilih--</option>
                                @for($i=1;$i<=31;$i++)
                                    <option value={{$i}} {{ old('tgl_lahir') == $i ? 'selected' : '' }}>{{$i}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select name="bln_lahir" class="form-control required">
                                <option value="">--Pilih--</option>
                                @for($i=0;$i<=11;$i++)
                                    <option value="{{$i+1}}" {{ old('bln_lahir') == $i+1 ? 'selected' : '' }}>{{$data_bulan[$i]}}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select name="thn_lahir" class="form-control required" id="thn_lahir">
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group col-sm-2">
                        <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" class="form-control required">
                            <option value="">--Pilih--</option>
                            @foreach (session('master_jenis_kelamin') as $b)
                                <option value="{{$b->id_jenis_kelamin}}" {{ old('jenis_kelamin') == $b->id_jenis_kelamin ? 'selected' : '' }}>{{$b->jenis_kelamin}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                </div>
              {{-- </div> --}}
                <div class="form-row">
                  <div class="form-group col-sm-3">
                    <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="form-control required">
                        <option value="">--Pilih--</option>
                        @foreach (session('master_jenis_kelamin') as $b)
                            <option value="{{$b->id_jenis_kelamin}}" {{ old('jenis_kelamin') == $b->id_jenis_kelamin ? 'selected' : '' }}>{{$b->jenis_kelamin}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label for="status_kawin" class="font-weight-bold">Status Perkawinan *</label>
                    <select name="status_kawin" class="form-control required">
                      <option value="">--Pilih--</option>
                        @foreach (session('master_kawin') as $b)
                            <option value="{{$b->id_kawin}}" {{ old('jenis_kawin') == $b->id_kawin ? 'selected' : '' }}>{{$b->jenis_kawin}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3" id="data_perorangan_1">
                      <label for="no_ktp" class="font-weight-bold">No KTP *</label>
                      <input type="text" name="no_ktp" id="no_ktp" class="form-control required" placeholder="No KTP" value="{{ old('no_ktp') }}">
                  </div>
                  {{-- <div class="form-group col-sm-3">
                      <label for="no_npwp" class="font-weight-bold">No NPWP</label>
                      <input type="text" name="no_npwp" class="form-control" placeholder="No NPWP" value="{{ old('no_npwp') }}">
                  </div> --}}
                  <div class="form-group col-sm-3">
                      <label for="no_telp" class="font-weight-bold">No HP *</label>
                      <input type="text" name="no_telp" id="no_telp" onfocusout="checkPhoneNumber(this.value)" class="form-control required" placeholder="Contoh:08xxxxxxxxxx" value="{{ old('no_telp') }}">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-sm-3">
                    <label for="nama_ibu_kandung" class="font-weight-bold">Nama Ibu Kandung *</label>
                    <input type="text" name="nama_ibu_kandung" id="nama_ibu_kandung" class="form-control required" placeholder="Nama Ibu Kandung" value="{{ old('nama_ibu_kandung') }}">
                  </div>
                  <div class="form-group col-sm-3">
                    <label for="pendidikan" class="font-weight-bold">Pendidikan *</label>
                    <select name="pendidikan" class="form-control required">
                      <option value="">--Pilih--</option>
                        @foreach (session('master_pendidikan') as $b)
                            <option value="{{$b->id_pendidikan}}" {{ old('pendidikan') == $b->id_pendidikan ? 'selected' : '' }}>{{$b->pendidikan}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3" id="data_perorangan_1">
                      <label for="Pekerjaan" class="font-weight-bold">Pekerjaan *</label>
                      <select name="pekerjaan" class="form-control required">
                        <option value="">--Pilih--</option>
                          @foreach (session('master_pekerjaan') as $b)
                              <option value="{{$b->id_pekerjaan}}" {{ old('pekerjaan') == $b->id_pekerjaan ? 'selected' : '' }}>{{$b->pekerjaan}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group col-sm-3">
                      <label for="Pendapatan" class="font-weight-bold">Pendapatan *</label>
                      <select name="pendapatan" class="form-control required">
                        <option value="">--Pilih--</option>
                          @foreach (session('master_pendapatan') as $b)
                              <option value="{{$b->id_pendapatan}}" {{ old('pendapatan') == $b->id_pendapatan ? 'selected' : '' }}>{{$b->pendapatan}}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
                <div class="form-group">
                    <label for="alamat" class="font-weight-bold">Alamat *</label>
                    <textarea name="alamat" class="form-control col-sm-10 required" rows="3" id="alamat" placeholder="Alamat Lengkap">{{ old('alamat') }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="provinsi" class="font-weight-bold">Provinsi *</label>
                        <select name="provinsi" class="form-control required" id="provinsi">
                            <option value="">--Pilih--</option>
                            @foreach (session('master_provinsi') as $data)
                                <option value={{$data->kode_provinsi}} {{ old('provinsi') == $data->kode_provinsi ? 'selected' : ''}}>{{$data->nama_provinsi}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="kota" class="font-weight-bold">Kota</label>
                        <select name="kota" class="form-control" id="kota">
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="kecamatan" class="font-weight-bold">Kecamatan *</label>
                        <input type="text" name="kecamatan" class="form-control required" id="kecamatan" placeholder="Kecamatan" value="{{ old('kecamatan') }}">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="kelurahan" class="font-weight-bold">Kelurahan *</label>
                        <input type="text" name="kelurahan" class="form-control required" id="kelurahan" placeholder="Kelurahan" value="{{ old('kelurahan') }}">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="kode_pos" class="font-weight-bold">Kode Pos *</label>
                        <input type="text" name="kode_pos" class="form-control required" id="kode_pos" placeholder="Kode Pos" value="{{ old('kode_pos') }}">
                    </div>
                </div>
				        {{-- <div class="form-group col-sm-4 ml-2">
                  <input class="form-check-input" type="checkbox" id="id_check_poto"> &nbsp;
                  <label class="font-weight-bold" for="defaultCheck1"> Unggah Poto (Optional)</label>
                </div> --}}
                <div class="form-row ml-3" id="divHidePoto">
                  <div class="col-sm-2 imgUp">
                    <div id="upload_diri">
                      <label class="font-weight-bold">Foto Diri *</label>
                      <img class="imagePreview" id="preview-1">
                      <!--label class="btn btn-primary">Upload<input type="file" name="pic_investor" id="pic_investor" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                      </label-->
                      <div id="camera_diri">
                        <label class="btn btn-primary">Kamera</label>
                      </div><br/>
                      <div id="tampil_error_diri">
                      </div>
                    </div>
                  </div>
                  <div id="take_camera_diri" style="display: none;">
                    <div class="col-sm-4 imgUp">
                      <label class="font-weight-bold">Foto Diri *</label>
                      <div class="col-md-6">
                        <img id="user-guide" src="{{URL::to('assets/img/user-guide.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 185px; top: 22px;">
                        <div id="my_camera">
                        </div>
                        <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot()">
                        <input type="hidden" id="user_val" value="0">
                        <input type="hidden" name="image_foto" id="user" class="image-tag"><br/>
                        <!--div id="base_upload_diri">
                          <label class="btn btn-primary">Upload</label>
                        </div-->
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Hasil</label>
                        <div id="results"></div>
                      </div><br/>
                    </div>
                  </div>

                  <div class="col-sm-2 imgUp">
                    <div id="upload_ktp">
                      <label class="font-weight-bold">Foto KTP *</label>
                      <img class="imagePreview" id="preview-2">
                      <!--label class="btn btn-primary">Upload<input type="file" name="pic_ktp_investor" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_ktp_investor">
                      </label-->
                      <div id="camera_ktp">
                        <label class="btn btn-primary">Kamera</label>
                      </div><br/>
                      <div id="tampil_error_ktp">
                      </div>
                    </div>
                  </div>
                  <div id="take_camera_ktp" style="display: none;">
                    <div class="col-sm-4 imgUp">
                      <label class="font-weight-bold">Foto KTP *</label>
                      <div class="col-md-6">
                      <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 155px; top: 22px;">
                        <div id="my_camera2"></div>
                        <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot2()">
                        <input type="hidden" id="ktp_val" value="0">
                        <input type="hidden" name="image_ktp" id="ktp" class="image-tag"><br/>
                        <!--div id="base_upload_ktp">
                          <label class="btn btn-primary">Upload</label>
                        </div-->
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Hasil</label>
                        <div id="results2"></div>
                      </div><br/>
                    </div>
                  </div>

                  <div class="col-sm-2 imgUp">
                    <div id="upload_ktp_diri">
                      <label class="font-weight-bold" style="width: 204px;">Foto Diri dengan KTP *</label>
                      <img class="imagePreview" id="preview-3">
                      <!--label class="btn btn-primary">Upload<input type="file" name="pic_user_ktp_investor" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_user_ktp_investor">
                      </label-->
                      <div id="camera_ktp_diri">
                        <label class="btn btn-primary">Kamera</label>
                      </div><br/>
                      <div id="tampil_error_ktp_diri">
                      </div>
                    </div>
                  </div>
                  <!--  </div> -->
                  <div id="take_camera_ktp_diri" style="display: none;">
                    <div class="col-sm-9 imgUp">
                      <label class="font-weight-bold">Foto Diri dengan KTP *</label>
                      <div class="col-md-6">
                        <img id="user-guide" src="{{URL::to('assets/img/guide-diridanktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 170px; top: 22px;">
                        <div id="my_camera3"></div>
                        <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot3()">
                        <input type="hidden" id="user_ktp_val" value="0">
                        <input type="hidden" name="image_user_ktp" id="user_ktp" class="image-tag"><br/>
                        <!--div id="base_upload_ktp_diri">
                          <label class="btn btn-primary">Upload</label>
                        </div-->
                      </div>
                      <div class="col-md-6">
                        <label class="font-weight-bold">Hasil</label>
                        <div id="results3"></div>
                      </div><br>
                    </div>
                  </div>
                </div>
                <p>Format file .jpg, .jpeg, .gif, dan .png</p>
                <div class="form-group col-sm-4 ml-2">
                  <input class="form-check-input" type="checkbox" name="npwp_check" id="npwp_check">
                  <label class="font-weight-bold" for="defaultCheck1">Saya Punya NPWP</label>
                </div>
                <div class="form-group" id="show_npwp" style="display: none;">
                    <input type="text" name="no_npwp" class="form-control" placeholder="No NPWP" value="{{ old('no_npwp') }}">
                </div>
                <p><b>*) Wajib Diisi</b></p>
              </div>
              <div class="step-tab-panel" id="tab2">
                {{-- <h3>Data Rekening</h3> --}}
                <div class="form-row">
                  <div class="form-group col-sm-4">
                      <label for="rekening" class="font-weight-bold">No Rekening *</label>
                      <input type="text" name="rekening" id="rekening" class="form-control required" placeholder="No Rekening" value="{{ old('rekening') }}">
                  </div>
                  <div class="form-group col-sm-4">
                      <label for="rekening" class="font-weight-bold">Nama Pemilik Rekening *</label>
                      <input type="text" name="nama_pemilik_rek" id="nama_pemilik_rek" class="form-control required" placeholder="Nama Pemilik Rekening" value="{{ old('nama_pemilik_rek') }}">
                  </div>
                  <div class="form-group col-sm-4">
                      <label for="bank" class="font-weight-bold">Bank *</label>
                      <select name="bank" class="form-control required" id="bank">
                          <option value="">--Pilih--</option>
                          @foreach(session('master_bank') as $b)
                              <option value="{{ $b->kode_bank }}" {{ old('bank') == $b->kode_bank ? 'selected' : '' }}>{{ $b->nama_bank }}</option>
                          @endforeach
                      </select>
                  </div>
                </div>
                <p><b>*) Wajib Diisi</b></p>
              </div>
              
            </div>

            <div class="step-footer float-right">
              <button data-direction="prev" class="step-btn">Sebelumnya</button>
              <button data-direction="next" class="step-btn">Lanjut</button>
              <button data-direction="finish" class="step-btn" id="selesai">Selesai</button>
            </div>

          </div>
        </div>
      
        </form>
    </div>
  </div>
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
                  <button type="button" class="btn btn-sm btn-info" id="kirim_lagi">Kirim Lagi <span id="count"></span></button>
                  <button type="button" class="btn btn-sm btn-success" id="kirim_data" disabled>Kirim</button>
              </div>
                  </form>
          </div>
      </div>
  </div>
  {{-- end modal OTP --}}
  <link rel="stylesheet" href="{{ asset('/css/jquery_step/new/jquery-steps.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/jquery_step/new/style.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> -->
  <script>
    $(document).ready(function(){
      $("#camera_diri").click(function(){
        $("#take_camera_diri").fadeIn();
        $("#take_camera_diri").css( { "margin-left" : "-290px"} );
        $("#upload_diri").fadeOut();;
      });
    });
    $(document).ready(function(){
      $("#base_upload_diri").click(function(){
        $("#take_camera_diri").fadeOut();
        $("#upload_diri").fadeIn();
      });
    });

    $(document).ready(function(){
      $("#camera_ktp").click(function(){
        $("#take_camera_ktp").fadeIn();
        $("#take_camera_ktp").css( { "margin-left" : "-290px"} );
        $("#upload_ktp").fadeOut();;
      });
    });
    $(document).ready(function(){
      $("#base_upload_ktp").click(function(){
        $("#take_camera_ktp").fadeOut();
        $("#upload_ktp").fadeIn();
      });
    });

    $(document).ready(function(){
      $("#camera_ktp_diri").click(function(){
        $("#take_camera_ktp_diri").fadeIn();
        $("#take_camera_ktp_diri").css( { "margin-left" : "-290px"} );
        $("#upload_ktp_diri").fadeOut();
      });
    });
    $(document).ready(function(){
      $("#base_upload_ktp_diri").click(function(){
        $("#take_camera_ktp_diri").fadeOut();
        $("#upload_ktp_diri").fadeIn();
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
  
    Webcam.attach( '#my_camera' );

    function take_snapshot()
    {
     
        Webcam.snap( function(data_uri) {
		        document.getElementById('user').value = data_uri;
            document.getElementById('user_val').value = '1';
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
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
  
    Webcam.attach( '#my_camera2' );

    function take_snapshot2()
    {
      
      Webcam.snap( function(data_uri) {
          document.getElementById('ktp').value = data_uri;
          document.getElementById('ktp_val').value = '1';
          document.getElementById('results2').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
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
  
    Webcam.attach( '#my_camera3' );

    function take_snapshot3()
    {
        
      Webcam.snap( function(data_uri) {
          document.getElementById('user_ktp').value = data_uri;
          document.getElementById('user_ktp_val').value = '1';
          document.getElementById('results3').innerHTML = '<img src="'+data_uri+'" style="width:200px;height:160px;"/>';
      } );

    }
</script>
<style>
    #tab1{
       height: 900px;
       overflow-y: auto;
       overflow-x: hidden;
    }
    /* width */
    ::-webkit-scrollbar {
      width: 10px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #888; 
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
  </style>
  <script src="{{ asset('/js/jquery_step/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('/js/jquery_step/new/jquery-steps.js') }}"></script>
  <script type="text/javascript">

    var frmInfo = $('#example-advanced-form');
    var frmInfoValidator = frmInfo.validate();
    
    $('#demo').steps({
      onChange: function (currentIndex, newIndex, stepDirection) {
        function cekValueHiddenUser(){
            var el = $('#user_val').val();
            console.log(el)
            if (el == '0')
            {
               return 'kosong';
            }
            else
            {
                return el;
            }
        }

        function cekValueHiddenKtp(){
            var el = $('#ktp_val').val();
            console.log(el)
            if (el == '0')
            {
               return 'kosong';
            }
            else
            {
                return el;
            }
        }

        function cekValueHiddenUserKtp(){
            var el = $('#user_ktp_val').val();
            console.log(el)
            if (el == '0')
            {
               return 'kosong';
            }
            else
            {
                return el;
            }
        }

        var valueHiddenUser = cekValueHiddenUser();
        var valueHiddenKtp = cekValueHiddenKtp();
        var valueHiddenUserKtp = cekValueHiddenUserKtp();
        console.log('onChange', currentIndex, newIndex, stepDirection);
        // tab1
        // if (currentIndex === 3) {
          // if (valueHiddenUser !== 'kosong')
          // {
          //     return true;
          // }
          
          if (stepDirection === 'forward') {
              var valid = frmInfo.valid();
              // console.log(valid)
              if (valueHiddenUser == 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp == 'kosong' && valid == true)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser != 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp == 'kosong' && valid == true)
              {
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser != 'kosong' && valueHiddenKtp != 'kosong' && valueHiddenUserKtp == 'kosong' && valid == true)
              {
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser == 'kosong' && valueHiddenKtp != 'kosong' && valueHiddenUserKtp == 'kosong' && valid == true)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser == 'kosong' && valueHiddenKtp != 'kosong' && valueHiddenUserKtp != 'kosong' && valid == true)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser == 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp != 'kosong' && valid == true)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser != 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp != 'kosong' && valid == true)
              {
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser == 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp == 'kosong' && valid == false)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser == 'kosong' && valueHiddenKtp != 'kosong' && valueHiddenUserKtp == 'kosong' && valid == false)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser == 'kosong' && valueHiddenKtp != 'kosong' && valueHiddenUserKtp != 'kosong' && valid == false)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser == 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp != 'kosong' && valid == false)
              {
                  $('#tampil_error_diri').empty().append('<label id="error_label_user" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser != 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp == 'kosong' && valid == false)
              {
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser != 'kosong' && valueHiddenKtp != 'kosong' && valueHiddenUserKtp == 'kosong' && valid == false)
              {
                  $('#tampil_error_ktp_diri').empty().append('<label id="error_label_ktp_diri" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              if (valueHiddenUser != 'kosong' && valueHiddenKtp != 'kosong' && valueHiddenUserKtp != 'kosong' && valid == false)
              {
                  return false;
              }
              if (valueHiddenUser != 'kosong' && valueHiddenKtp == 'kosong' && valueHiddenUserKtp != 'kosong' && valid == false)
              {
                  $('#tampil_error_ktp').empty().append('<label id="error_label_ktp" style="color:red;">Harus Diisi</label>')
                  return false;
              }
              else
              {
                  return true;
              }
          }
          if (stepDirection === 'backward') {
            frmInfoValidator.resetForm();
          }
        // }

        // tab2
        // if (currentIndex === 1) {
        //   if (stepDirection === 'forward') {
        //     var valid = frmInfo.valid();
        //     return valid;
        //   }
        //   if (stepDirection === 'backward') {
        //     frmInfoValidator.resetForm();
        //   }
        // }

        // tab3
        // if (currentIndex === 4) {
        //   if (stepDirection === 'forward') {
        //     var valid = frmMobile.valid();
        //     return valid;
        //   }
        //   if (stepDirection === 'backward') {
        //     frmMobileValidator.resetForm();
        //   }
        // }

        return true;

      },
      onFinish: function () {
        // alert('Wizard Completed');
        //frmInfo.submit();
        var rek = $('#rekening').val();
        var pemilik_rek = $('#nama_pemilik_rek').val();
        var bank = $('#bank option:selected').val();
        if (rek != '' && pemilik_rek != '' && bank != '')
        {
            $('#selesai').attr('data-toggle','modal').attr('data-target','#otp');
            return true;
        }
      }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // generate tahun
      var select = document.getElementById('thn_lahir'),
          year = new Date().getFullYear(),
          html = '<option value="">--Pilih--</option>',
          data_old = {{ old('thn_lahir') !== null ? old('thn_lahir') : 0 }};
      for(i = year; i >= year-100; i--) {
        html += '<option value="' + i + '" '+(data_old !== 0 && data_old == i ? "selected" : "")+'>' + i + '</option>';
      }
      select.innerHTML = html;
    // end generate tahun

    var provinsi = ($('#provinsi option:selected').val() !== '' ? $('#provinsi option:selected').val() : 0),
        url = ($('#provinsi option:selected').val() !== '' ? '/getKota/'+provinsi : ''),
        kota = "{{ old('kota') !== null ? old('kota') : '' }}";
    console.log(provinsi+' '+url)
    $.ajax({
        url : url,
        method : "get",
        success:function(data)
        {
            $.each(data.kota,function(index,value){
                if (value.kode_kota == kota)
                {
                    var select = 'selected=selected';
                }
                else
                {
                    var select = '';
                }
                $('#kota').append(
                    '<option value="'+value.kode_kota+'"'+ select+'>'+value.nama_kota+'</option>'
                );
            })
        }
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

    $(document).ready(function() {
		$('#id_check_poto').on('click',function(){
          if($(this).is(':checked'))
          {
              $('#divHidePoto').fadeIn();
              // alert('checked')
          }
          else
          {
              $('#divHidePoto').fadeOut();
          }
      })
      $('#npwp_check').on('click',function(){
          if($(this).is(':checked'))
          {
              $('#show_npwp').fadeIn();
              // alert('checked')
          }
          else
          {
              $('#show_npwp').fadeOut();
          }
      })
    })

    $('#preview-1').on('click',function(){
        $('#file-1').trigger('click');
    })

    $('#preview-2').on('click',function(){
        $('#file-2').trigger('click');
    })

    $('#preview-3').on('click',function(){
        $('#file-3').trigger('click');
    })

    $('#selesai').on('click',function(){
        $('#kirim_lagi').prop('disabled',true);
        $('#no_hp').val($('#no_telp').val());
        noHP = $('#no_hp').val();
        console.log(noHP)
        $.ajax({
            url : "/user/kirimOTP/",
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
        $('#no_hp').val($('#no_telp').val());
        noHP = $('#no_hp').val();
        console.log(noHP)
        $.ajax({
            url : "/user/kirimOTP/",
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
            url : "/user/cekOTP/",
            method : "post",
            dataType: 'JSON',
            data: {otp:$('#kode_otp').val()},
            success:function(data)
            {
                if (data.status == '00')
                {
                    console.log(data.status)
                    $('#example-advanced-form').attr('action','{{route('firstUpdateProfile')}}').attr('method','POST').attr('enctype','multipart/form-data');
                    $('#example-advanced-form').submit();
                    $('#otp').modal('show');
                }
                else
                {
                    $('#alertError').css('display','block').text(data.message)
                }
                
            }
        });
         
    })
    
  </script>
@endif

<style>
    .btn-primary
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
</style>

<script src="/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

    // upload
    // $(document).on("change",".uploadFile", function()
    // {
    //     var uploadFile = $(this);
    //     var files = !!this.files ? this.files : [];
    //     if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
    //     if (/^image/.test( files[0].type)){ // only image file
    //         var reader = new FileReader(); // instance of the FileReader
    //         reader.readAsDataURL(files[0]); // read the local file
 
    //         reader.onloadend = function(){ // set image data as background of div
    //             //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
    //         uploadFile.closest(".imgUp").find('.imagePreview').attr("src", this.result);
    //         }
    //     }
      
    // });
    // end upload

  $(document).on("change","#pic_investor", function()
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
      console.log(filess);

      $.ajax({
              url : "/user/new_upload1",
              method : "post",
              dataType: 'JSON',
              data: form_data,
              contentType: false,
              processData: false,
              success:function(data)
              {
                  console.log(data)
                  if(data.success){
                    alert(data.success);
                  }else{
                    alert(data.failed);
                  }
              }
          });
        }
    });

    $(document).on("change","#pic_ktp_investor", function()
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
      console.log(filess);

      $.ajax({
              url : "/user/new_upload2",
              method : "post",
              dataType: 'JSON',
              data: form_data,
              contentType: false,
              processData: false,
              success:function(data)
              {
                  console.log(data)
                  if(data.success){
                    alert(data.success);
                  }else{
                    alert(data.failed);
                  }
              }
          });
        }
    });

    $(document).on("change","#pic_user_ktp_investor", function()
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
      console.log(filess);

      $.ajax({
              url : "/user/new_upload3",
              method : "post",
              dataType: 'JSON',
              data: form_data,
              contentType: false,
              processData: false,
              success:function(data)
              {
                  console.log(data)
                  if(data.success){
                    alert(data.success);
                  }else{
                    alert(data.failed);
                  }
              }
          });
        }
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

  $('#provinsi').on('change',function(e){
      e.preventDefault();
      var kode_provinsi = this.value;
      console.log(kode_provinsi)
      $('#kota').empty();
      $.ajax({
          url : "/getKota/"+kode_provinsi,
          method : "get",
          dataType: 'JSON',
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
</script>


@endsection