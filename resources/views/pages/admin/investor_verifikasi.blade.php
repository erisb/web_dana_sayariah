@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Verifikasi Pendaftaran Pendana</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="#">Kelola Pendana</a></li>
                    <li class="active">Verifikasi Pendana</li>
                </ol>
            </div>
        </div>
    </div>
</div>
            <div class="content mt-3">
                
                            <div class="row">
                            <div class="col-md-12">
                            @if(session()->has('verif_ok'))
                                <div class="alert alert-success">
                                    {{ session()->get('verif_ok') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @elseif(session()->has('verif_failed'))
                                <div class="alert alert-danger">
                                    {{ session()->get('verif_failed') }}
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
                                        <strong class="card-title">Data Pendana</strong>
                                    </div>
                                    <div class="card-body">
                            <table id="table_verifikasi" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th hidden>ID </th>
                                    <th>No </th>
                                    <th>Nama</th>
                                    <th>Email </th>
                                    <th>Akun</th>
                                    <th>Informasi Pendana</th>
                                    <th>Aksi</th>
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
<div class="modal fade" id="detil_investor" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
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
                        <h3><b>Data Pribadi</b></h3>
                        <hr>
                        <fieldset>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="username" class="font-weight-bold">Akun</label>
                                    <input type="text" name="username" class="form-control" value="{{!empty($detil->username) ? $detil->username : ''}}" placeholder="Username">
                                </div>
                               {{--  <div class="form-group col-sm-4">
                                    <label for="password" class="font-weight-bold">Kata Sandi</label>
                                    <input type="password" name="password" class="form-control" value="{{!empty($detil->password) ? $detil->password : ''}}" placeholder="Password">
                                </div> --}}
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="nama" class="font-weight-bold">Nama</label>
                                    <input type="text" name="nama" class="form-control" value="{{!empty($detil->nama_investor) ? $detil->nama_investor : ''}}" placeholder="Nama">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="email" class="font-weight-bold"><i>Email</i></label>
                                    <input type="email" name="email" class="form-control" value="{{!empty($detil->email) ? $detil->email : ''}}" placeholder="Email">
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
                                <div class="form-group col-sm-2">
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
                            <div class="form-group">
                                <label for="alamat" class="font-weight-bold">Alamat</label>
                                <textarea name="alamat" class="form-control col-sm-10" rows="3" id="alamat" placeholder="Alamat Lengkap"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    <label for="provinsi" class="font-weight-bold">Provinsi</label>
                                    <select name="provinsi" class="form-control" id="provinsi">
                                        <option value="">--Pilih--</option>
                                        @foreach ($master_provinsi as $data)
                                            <option value={{$data->kode_provinsi}}>{{$data->nama_provinsi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="kota" class="font-weight-bold">Kota</label>
                                    <select name="kota" class="form-control" id="kota">
                                    </select>
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
                                    <label class="btn btn-success">Unggah<input type="file" name="pic_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                <div class="col-sm-2 imgUp">
                                    <label class="font-weight-bold">Foto KTP</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto2">
                                    </div>
                                    <label class="btn btn-success">Unggah<input type="file" name="pic_ktp_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                                    <div class="col-sm-2 imgUp">
                                    <label class="font-weight-bold" style="width: 184px;">Foto Diri dengan KTP</label>
                                    <div style="width: 200px;">
                                        <img class="imagePreview" id="foto3">
                                    </div>
                                    <label class="btn btn-success">Unggah<input type="file" name="pic_user_ktp_investor" class="uploadFile img" style="width: 0px;height: 0px;overflow: hidden;" accept=".jpg, .jpeg, .png,.bmp">
                                    </label>
                                </div>
                            </div>
                            <p>Format file .jpg, .jpeg, .gif, dan .png</p>
                        </fieldset><br>

                        <h3><b>Data Rekening</b></h3>
                        <hr>
                        <fieldset>
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
                        </fieldset>
                        <div class="form-group">
                            <div id="pending" style="display: none;">
                                <label for="terkumpul" class=" form-control-label">Tangguhkan Pendana ?</label>
                                <br>
                                <input type="radio" name="status" value="suspend"> Ditangguhkan
                            </div>
                            <div id="suspend" style="display: none;">
                                <label for="terkumpul" class=" form-control-label">Aktivasi Pendana ?</label>
                                <br>
                                <input type="radio" name="status" value="active"> Aktif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Perbaharui Pendana</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal investor detil -->

</div><!-- .content -->
    
    <style>
    .btn-success
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
  <link rel="stylesheet" href="/css/jquery_step/jquery.steps.css">
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

            // $('#bootstrap-data-table-export').DataTable();
            var verifikasiTable = $('#table_verifikasi').DataTable({
                searching: true,
                processing: true,
                // serverSide: true,
                ajax: {
                    url: '/admin/investor/data_verifikasi_datatables',
                    dataSrc: 'data'
                },
                paging: true,
                info: true,
                lengthChange:false,
                order: [ 0, 'desc' ],
                pageLength: 10,
                columns: [
                    { data: 'id'},
                    { data : null,
                      render: function (data, type, row, meta) {
                              //I want to get row index here somehow
                              return  meta.row+1;
                        }
                    },
                    { data: 'nama_investor'},
                    { data: 'email'},
                    { data: 'username'},
                    { data: null,
                        render:function(data,type,row,meta)
                        {
                            return '<button class="btn btn-info btn-block"  data-toggle="modal" data-target="#detil_investor" id="detil">Detil User</button>';
                        }
                    },
                    { data: null,
                        render:function(data,type,row,meta){
                            return '<form action="{{Route('admin.investor.verif.ok')}}" method="POST">@csrf'
                                    +'<input type="hidden" name="username" value="'+data.username+'">'
                                    +'<button type="submit" class="btn btn-success">Verifikasi</button>'
                                    +'</form>'
                                        
                                    +'<form action="{{Route('admin.investor.verif.fail')}}" method="POST">@csrf'
                                    +'<input type="hidden" name="username" value="'+data.username+'">'
                                    +'<button type="submit" class="btn btn-danger">Tolak</button>'
                                    +'</form>';
                        }  
                    }
                ],
                columnDefs: [
                    { targets: [0], visible: false}
                ]
            });

            $('#table_verifikasi tbody').on( 'click', '#detil', function () {
                var data = verifikasiTable.row( $(this).parents('tr') ).data();
                id = data.id;
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
                        
                        foto1 = data_all.pic_investor;
                        foto2 = data_all.pic_ktp_investor;
                        foto3 = data_all.pic_user_ktp_investor;

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
                        $('input[name=rekening]').val(rekening);
                        $('select[name=bank]').val(bank);
                        $('input[name=nama_pemilik_rek]').val(nama_pemilik_rek);
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
                    }
                });
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
    </script>
@endsection