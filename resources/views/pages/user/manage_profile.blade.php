@extends('layouts.user.sidebar')

@section('title', 'Data Identitas')

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
    {{-- <div class="col-lg-12">
      <h2>Data Identitas</h2>
    </div> --}}
  </div>
  {{-- <hr> --}}
  <div class="row">
  <div class="col-sm-12 col-lg-12 ">
  <form method="POST" action="{{route('updateUser')}}" enctype="multipart/form-data">
      @csrf
      <h3><b>Data Pribadi</b></h3>
      <hr>
      <fieldset>
          <div class="form-row">
              <div class="form-group col-sm-6">
                  <label for="username" class="font-weight-bold">Akun</label>
                  <input type="text" name="username" class="form-control" value="{{!empty($detil->username) ? $detil->username : ''}}" placeholder="Username" disabled="disabled">
              </div>
              <!-- <div class="form-group col-sm-4">
                  <label for="password" class="font-weight-bold">Kata Sandi</label>
                  <input type="password" name="password" class="form-control" placeholder="New Password">
              </div> -->
          </div>
          <div class="form-row">
              <div class="form-group col-sm-6">
                  <label for="nama" class="font-weight-bold">Nama</label>
                  <input type="text" name="nama" class="form-control" value="{{!empty($detil->nama_investor) ? $detil->nama_investor : ''}}" placeholder="Nama" required>
              </div>
              <div class="form-group col-sm-4">
                  <label for="email" class="font-weight-bold"><i>Email</i></label>
                  <input type="email" name="email" class="form-control" value="{{!empty($detil->email) ? $detil->email : ''}}" placeholder="Email" disabled="disabled">
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-sm-2">
                  <label for="tempat_lahir" class="font-weight-bold">Tempat Lahir</label>
                  <input type="text" name="tempat_lahir" class="form-control" value="{{!empty($detil->tempat_lahir_investor) ? $detil->tempat_lahir_investor : ''}}" placeholder="Tempat Lahir">
              </div>
              <div class="form-group col-sm-6">
                  <label for="tanggal_lahir" class="font-weight-bold">Tanggal Lahir</label>
                  @php
                    $data_tgl = !empty($detil->tgl_lahir_investor) ? explode("-",$detil->tgl_lahir_investor) : null;
                    // tgl
                    $cek_tgl = 0;
                    if($data_tgl !== null && $data_tgl !== '')
                    {
                      if($data_tgl[0] !== null && $data_tgl[0] !== '')
                      {
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
                      }
                      else
                      {
                        $cek_tgl = 0;
                      }
                    }
                    else
                    {
                        $cek_tgl = 0;
                    }
                    // end tgl
                    // bulan
                      $data_bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
                      $cek_bln = 0;
                      if($data_tgl !== null && $data_tgl !== '')
                      {
                        if($data_tgl[1] !== null && $data_tgl[1] !== '')
                        {
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
                        }
                        else
                        {
                          $cek_bln = 0;
                        }
                      }
                      else
                      {
                          $cek_bln = 0;
                      }
                      // echo $cek_bln;die;
                    // end bulan
                  @endphp
                  <div class="form-row">
                      <div class="col-sm-3">
                          <select name="tgl_lahir" class="form-control">
                            <option value="">--Pilih--</option>
                            @for($i=1;$i<=31;$i++)
                              <option value="{{$i}}" {{$i == $cek_tgl ? 'selected' : ''}}>{{$i}}</option>
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
                          <select name="thn_lahir" class="form-control" id="thn_lahir">
                          </select>
                      </div>
                  </div>
              </div>
              <div class="form-group col-sm-2">
                  <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-control">
                      <option value="0">--Pilih--</option>
                      @foreach ($master_jenis_kelamin as $b)
                          <option value="{{$b->id_jenis_kelamin}}" {{!empty($detil->jenis_kelamin_investor) && $b->id_jenis_kelamin == $detil->jenis_kelamin_investor ? 'selected=selected' : ''}}>{{$b->jenis_kelamin}}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          {{-- </div> --}}
          <div class="form-row">
              <div class="form-group col-sm-3">
                  <label for="status_kawin" class="font-weight-bold">Status Perkawinan</label>
                  <select name="status_kawin" class="form-control" required>
                      <option value="0">--Pilih--</option>
                      @foreach ($master_kawin as $kawin)
                          <option value="{{$kawin->id_kawin}}" {{!empty($detil->status_kawin_investor) && $kawin->id_kawin == $detil->status_kawin_investor ? 'selected=selected' : ''}}>{{$kawin->jenis_kawin}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="form-group col-sm-3" id="data_perorangan_1">
                  <label for="no_ktp" class="font-weight-bold">No KTP</label>
                  <input type="text" name="no_ktp" class="form-control" value="{{!empty($detil->no_ktp_investor) ? $detil->no_ktp_investor : ''}}" placeholder="No KTP">
              </div>
              <div class="form-group col-sm-2">
                  <label for="no_npwp" class="font-weight-bold">No NPWP</label>
                  <input type="text" name="no_npwp" class="form-control" value="{{!empty($detil->no_npwp_investor) ? $detil->no_npwp_investor : ''}}" placeholder="No NPWP">
              </div>
              <div class="form-group col-sm-2">
                  <label for="no_telp" class="font-weight-bold">No Telp / HP</label>
                  <input type="text" name="no_telp" class="form-control" value="{{!empty($detil->phone_investor) ? $detil->phone_investor : ''}}" placeholder="No Telp / HP" readonly="readonly" required>
              </div>
          </div>
          <div class="form-row">
            <div class="form-group col-sm-3">
                <label for="ibu_kandung" class="font-weight-bold">Nama Ibu Kandung</label>
                <input type="text" name="nama_ibu_kandung" class="form-control" value="{{!empty($detil->nama_ibu_kandung) ? $detil->nama_ibu_kandung : ''}}" placeholder="Nama Ibu Kandung" required>
            </div>
            <div class="form-group col-sm-2">
                <label for="pendidikan" class="font-weight-bold">Pendidikan</label>
                <select name="pendidikan" class="form-control" id="pendidikan">
                    <option value="0">--Pilih--</option>
                    @foreach ($master_pendidikan as $data)
                        <option value="{{$data->id_pendidikan}}" {{!empty($detil->pendidikan_investor) && $data->id_pendidikan == $detil->pendidikan_investor ? 'selected' : ''}}>{{$data->pendidikan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label for="pekerjaan" class="font-weight-bold">Pekerjaan</label>
                <select name="pekerjaan" class="form-control" id="pekerjaan">
                    <option value="0">--Pilih--</option>
                    @foreach ($master_pekerjaan as $data)
                        <option value="{{$data->id_pekerjaan}}" {{!empty($detil->pekerjaan_investor) && $data->id_pekerjaan == $detil->pekerjaan_investor ? 'selected' : ''}}>{{$data->pekerjaan}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-3">
                <label for="pendapatan" class="font-weight-bold">Pendapatan</label>
                <select name="pendapatan" class="form-control" id="pendapatan">
                    <option value="0">--Pilih--</option>
                    @foreach ($master_pendapatan as $data)
                        <option value="{{$data->id_pendapatan}}" {{!empty($detil->pendapatan_investor) && $data->id_pendapatan == $detil->pendapatan_investor ? 'selected' : ''}}>{{$data->pendapatan}}</option>
                    @endforeach
                </select>
            </div>
          </div>
          <div class="form-group">
              <label for="alamat" class="font-weight-bold">Alamat</label>
              <textarea name="alamat" class="form-control col-sm-10" rows="3" id="alamat" placeholder="Alamat Lengkap">{{!empty($detil->alamat_investor) ? $detil->alamat_investor : ''}}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-sm-3">
                <label for="provinsi" class="font-weight-bold">Provinsi</label>
                <select name="provinsi" class="form-control" id="provinsi">
                    <option value="0">--Pilih--</option>
                    @foreach ($master_provinsi as $data)
                        <option value="{{$data->kode_provinsi}}" {{!empty($detil->provinsi_investor) && $data->kode_provinsi == $detil->provinsi_investor ? 'selected' : ''}}>{{$data->nama_provinsi}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label for="kota" class="font-weight-bold">Kota</label>
                <input type="hidden" name="kota_hidden" class="form-control" id="kota_hidden" value="{{!empty($detil->kota_investor) ? $detil->kota_investor : ''}}">
                <select name="kota" class="form-control" id="kota">
                    {{-- <option value="0">--Pilih--</option> --}}
                </select>
            </div>
            <div class="form-group col-sm-2">
                <label for="kode_pos" class="font-weight-bold">Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control" id="kecamatan" value="{{!empty($detil->kecamatan) ? $detil->kecamatan : ''}}" placeholder="Kecamatan">
            </div>
            <div class="form-group col-sm-2">
                <label for="kode_pos" class="font-weight-bold">Kelurahan</label>
                <input type="text" name="kelurahan" class="form-control" id="kelurahan" value="{{!empty($detil->kelurahan) ? $detil->kelurahan : ''}}" placeholder="Kelurahan">
            </div>
            <div class="form-group col-sm-1">
                <label for="kode_pos" class="font-weight-bold">Kode Pos</label>
                <input type="text" name="kode_pos" class="form-control" id="kode_pos" value="{{!empty($detil->kode_pos_investor) ? $detil->kode_pos_investor : ''}}" placeholder="Kode Pos">
            </div>
          </div>
          <div class="form-row">
              <div class="col-sm-2 imgUp">
                <div id="foto_diri">
                  <label class="font-weight-bold">Foto Diri</label>
                  <img class="imagePreview" src="{{ !empty($detil->pic_investor) !== null ? asset('/storage').'/'.$detil->pic_investor : ''}}">
                  <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_investor"> -->
                  <div id="camera_foto_diri">
                    <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                  </div>
                </div>
              </div>
              <!-- <div id="take_camera_foto_diri" style="display: none;">
                <div class="col-sm-6 imgUp">
                  <label class="font-weight-bold">Foto Diri</label>
                  <div class="col-md-6">
                    <div id="results_foto_diri"></div>
                  </div><br/>
                  <div class="col-md-9">
                    <div id="my_camera_foto"></div>
                    <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_diri()">
                    <input type="hidden" name="image_foto_diri" id="user_foto_diri" class="image-tag"><br/>
                    <div id="cancel_foto_diri">
                      <label class="btn btn-primary">Batal</label>
                    </div>
                  </div>
                </div>
              </div> -->
              <div id="take_camera_foto_diri" style="display: none;">
                <div class="col-sm-6 imgUp">
                  <label class="font-weight-bold">Foto Diri</label>
                  <div class="col-md-6">
                    <img id="user-guide" src="{{URL::to('assets/img/user-guide.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 185px; top: 22px;">
                    <div id="my_camera_foto">
                    </div>
                    <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_diri()">
                    <input type="hidden" name="image_foto_diri" id="user_foto_diri" class="image-tag"><br/>
                  </div>
                  <div class="col-md-6">
                    <label class="font-weight-bold">Hasil</label>
                    <div id="results_foto_diri"></div>
                  </div><br/>
                </div>
              </div>

              <div class="col-sm-2 imgUp">
                <div id="foto_ktp">
                  <label class="font-weight-bold">Foto KTP</label>
                  <img class="imagePreview" src="{{$detil->pic_ktp_investor !== null ? asset('/storage').'/'.$detil->pic_ktp_investor : ''}}">
                  <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_ktp_investor"> -->
                  <div id="camera_foto_ktp">
                    <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                  </div>
                </div>
              </div>
              <!-- <div id="take_camera_foto_ktp" style="display: none;">
                <div class="col-sm-6 imgUp">
                  <label class="font-weight-bold">Foto KTP</label>
                  <div class="col-md-6">
                    <div id="results_foto_ktp"></div>
                  </div><br/>
                  <div class="col-md-6">
                    <div id="my_camera_ktp"></div>
                    <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp()">
                    <input type="hidden" name="image_foto_ktp" id="user_foto_ktp" class="image-tag"><br/>
                    <div id="cancel_foto_ktp">
                      <label class="btn btn-primary">Batal</label>
                    </div>
                  </div>
                </div>
              </div> -->
              <div id="take_camera_foto_ktp" style="display: none;">
                <div class="col-sm-6 imgUp">
                  <label class="font-weight-bold">Foto KTP</label>
                  <div class="col-md-6">
                  <img id="user-guide" src="{{URL::to('assets/img/guide-ktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 155px; top: 22px;">
                    <div id="my_camera_ktp"></div>
                    <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp()">
                    <input type="hidden" name="image_foto_ktp" id="user_foto_ktp" class="image-tag"><br/>
                  </div>
                  <div class="col-md-6">
                    <label class="font-weight-bold">Hasil</label>
                    <div id="results_foto_ktp"></div>
                  </div><br/>
                </div>
              </div>

              <div class="col-sm-2 imgUp">
                <div id="foto_ktp_diri"> 
                  <label class="font-weight-bold" style="width: 204px;">Foto Diri dengan KTP</label>
                  <img class="imagePreview" src="{{$detil->pic_user_ktp_investor !== null ? asset('/storage').'/'.$detil->pic_user_ktp_investor : ''}}">
                  <!-- <label class="btn btn-primary">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" value="Unggah Photo" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp" id="pic_user_ktp_investor"> -->
                  <div id="camera_foto_ktp_diri">
                    <label class="btn btn-primary"><i class="fa fa-camera"></i> Ubah Foto</label>
                  </div>
                </div>
              </div>
              <!-- <div id="take_camera_foto_ktp_diri" style="display: none;">
                <div class="col-sm-9 imgUp">
                  <label class="font-weight-bold">Foto Diri dengan KTP</label>
                  <div class="col-md-6">
                    <div id="results_foto_ktp_diri"></div>
                  </div><br/>
                  <div class="col-md-6">
                    <div id="my_camera_ktp_diri"></div>
                    <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_diri()">
                    <input type="hidden" name="image_foto_ktp_diri" id="user_foto_ktp_diri" class="image-tag"><br/>
                    <div id="cancel_foto_ktp_diri">
                      <label class="btn btn-primary">Batal</label>
                    </div>
                  </div>
                </div>
              </div> -->
              <div id="take_camera_foto_ktp_diri" style="display: none;">
                <div class="col-sm-9 imgUp">
                  <label class="font-weight-bold">Foto Diri dengan KTP</label> 
                  <div class="col-md-6">
                    <img id="user-guide" src="{{URL::to('assets/img/guide-diridanktp.png')}}" alt="guide" style="position: absolute; z-index: 9999;  width: 200px; height: 170px; top: 22px;">
                    <div id="my_camera_ktp_diri"></div>
                    <input class="btn btn-primary" type="button" value="Ambil Foto" onClick="take_snapshot_foto_ktp_diri()">
                    <input type="hidden" name="image_foto_ktp_diri" id="user_foto_ktp_diri" class="image-tag"><br/>
                  </div>
                  <div class="col-md-6">
                    <label class="font-weight-bold">Hasil</label>
                    <div id="results_foto_ktp_diri"></div>
                  </div><br>
                </div>
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
                  <input type="text" name="rekening" class="form-control" value="{{!empty($detil->rekening) ? $detil->rekening : ''}}" placeholder="No Rekening" readonly="readonly" title="Silahkan menghubungi admin jika ingin mengganti data ini">
              </div>
              <div class="form-group col-sm-4">
                <label for="rekening" class="font-weight-bold">Nama Pemilik Rekening</label>
                <input type="text" name="nama_pemilik_rek" class="form-control" placeholder="Nama Pemilik Rekening" value="{{!empty($detil->nama_pemilik_rek) ? $detil->nama_pemilik_rek : ''}}" readonly="readonly" title="Silahkan menghubungi admin jika ingin mengganti data ini">
              </div>
              <div class="form-group col-sm-4">
                  <label for="bank" class="font-weight-bold">Bank</label>
                  <select name="bank" class="form-control">
                      <option value="0">--Pilih--</option>
                      @foreach($master_bank as $b)
                          <option value="{{ $b->kode_bank }}" {{!empty($detil->bank_investor) && $b->kode_bank == $detil->bank_investor ? 'selected' : ''}}>{{ $b->nama_bank }}</option>
                      @endforeach
                  </select>
              </div>
          </div>
      </fieldset>
      <div class="float-right">
          <button type="submit" class="btn btn-success">Simpan</button>
      </div>
  </form>
</div>
</div>
  
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
      margin-right: 70px;
    }
  </style>
  <link rel="stylesheet" href="/css/jquery_step/jquery.steps.css">
  
  <script src="/js/jquery-3.3.1.min.js"></script>
  <script src="/js/jquery_step/jquery.steps.js"></script>
  <script src="/js/jquery_step/jquery.validate.min.js"></script>
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
        } );

    }
  </script>
  <script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // upload
    $(document).on("change","#pic_user_ktp_investor", function()
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
            var fileUpload = $(this).get(0);
            var filess = fileUpload.files[0];
            var form_data = new FormData();
            form_data.append('file', filess);
            console.log(filess);
            
            $.ajax({
                url : "/user/edit_upload3",
                method : "post",
                dataType: 'JSON',
                data: form_data,
                contentType: false,
                processData: false,
                success:function(data)
                {
                    console.log(data)
                    if(data.Sukses){
                      alert(data.Sukses);
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
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
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
                url : "/user/edit_upload2",
                method : "post",
                dataType: 'JSON',
                data: form_data,
                contentType: false,
                processData: false,
                success:function(data)
                {
                    console.log(data)
                    if(data.Sukses){
                      alert(data.Sukses);
                    }else{
                      alert(data.failed);
                    }
                }
            });
        }
    });
    $(document).on("change","#pic_investor", function()
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
            var fileUpload = $(this).get(0);
            var filess = fileUpload.files[0];
            var form_data = new FormData();
            form_data.append('file', filess);
            console.log(filess);
            
            $.ajax({
                url : "/user/edit_upload1",
                method : "post",
                dataType: 'JSON',
                data: form_data,
                contentType: false,
                processData: false,
                success:function(data)
                {
                  console.log(data)
                  if(data.Sukses){
                    alert(data.Sukses);
                  }else{
                    alert(data.failed);
                  }
                }
            });
        }
    });
    // end upload
    

    $(document).ready(function() {

      // generate tahun
      var select = document.getElementById('thn_lahir'),
          year = new Date().getFullYear(),
          html = '<option value="">--Pilih--</option>',
          data_awal = {{$data_tgl[2] !== null && $data_tgl[2] !== '' ? $data_tgl[2] : 0}};
      for(i = year; i >= year-100; i--) {
        html += '<option value="' + i + '" '+(i == data_awal ? "selected" : "")+'>' + i + '</option>';
      }
      select.innerHTML = html;
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
    });

  </script>
@endsection
