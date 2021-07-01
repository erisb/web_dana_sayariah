@extends('layouts.admin.master')

@section('title', 'Panel Admin')
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}
@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Buat Proyek Baru</h1>
            </div>
        </div>
    </div>
    <div class="alert alert-warning alert-dismissible fade show" style="display:none" id="data_error">
        <strong>Tanggal</strong>melebihi tanggal sekarang. 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
    <div class="alert alert-warning alert-dismissible fade show" style="display:none" id="date_error">
        <strong>Tanggal Selesai</strong> melebihi <strong>Tanggal Mulai</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
</div>

            <form action="{{route('admin.proyek.create.post')}}" method="POST" enctype="multipart/form-data">
                 @csrf
                    <div class="col-lg-12">
                        <div class="card">
                          <div class="card-header"><small> Form  </small><strong>Proyek</strong></div>
                          <div class="card-body card-block">
                            {{-- START FORM NAME UNTIL GEOCODE --}}
                            <div class="col-lg-12 p-0 m-0">
                                <div class="card-body card-block">
                                    <div class="form-group p-1 m-0">
                                        <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Nama Proyek</i></div>
                                                </div>
                                            <input type="text" name="nama" placeholder="Nama proyek" class="form-control" required>
                                        </div>
                                        {{-- <label for="nama" class=" form-control-label">Nama</label>
                                        <input type="text" name="nama" placeholder="Nama proyek" class="form-control" required> --}}
                                    </div>
                                    <div class="form-group p-1 m-0 mt-3 col-lg-6 float-left">
                                        <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Alamat Proyek</i></div>
                                                </div>
                                            <input type="text" name="alamat" placeholder="Alamat Proyek" class="form-control" required>
                                        </div>
                                        {{-- <label for="alamat" class=" form-control-label">Alamat</label>
                                        <input type="text" name="alamat" placeholder="Alamat Proyek" class="form-control" required> --}}
                                    </div>
                                    <div class="form-group p-1 m-0 mt-3 col-lg-6 float-right">
                                        <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i>Geocode</i> Proyek</div>
                                                </div>
                                            <input type="text" name="geocode" placeholder="Geocode alamat proyek" class="form-control" required>
                                        </div>

                                        {{-- <label for="geocode" class=" form-control-label"><i>Geocode</i></label>
                                        <input type="text" name="geocode" placeholder="Geocode alamat proyek" class="form-control" required> --}}
                                    </div>             
                                </div>
                            </div>
                            {{-- END OF NAME UNTIL GEOCODE --}}
                            <div class="col-lg-12 p-0 m-0">
                                <div class="card-body card-block">                                
                                    <div class="form-group p-1 m-0 col-lg-6 float-left">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Akad</i></div>
                                            </div>
                                                <select name="akad" class="form-control" id="" required>
                                                    <option value="" class="form-control"> -- Akad -- </option>
                                                    <option value="1" class="form-control">Murabahah</option>
                                                    <option value="2" class="form-control">Mudharabah</option>
                                                </select>
                                        </div>

                                        {{-- <label for="akad" class=" form-control-label">Akad</label>
                                        <select name="akad" class="form-control" id="" required>
                                            <option value="" class="form-control"> None </option>
                                            <option value="1" class="form-control">Murabahah</option>
                                            <option value="2" class="form-control">Mudharabah</option>
                                        </select> --}}
                                    </div>
                                    <div class="form-group p-1 m-0 col-lg-6 float-right">
                                        <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Margin Keuntungan</i></div>
                                                </div>
                                            <input type="number" name="profit_margin" placeholder="Profit Margin" required class="form-control">
                                        </div>
                                        {{-- <label for="profit_margin" class=" form-control-label">Margin Keuntungan %</label>
                                        
                                        <input type="number" name="profit_margin" placeholder="Presentase profit pendana pertahun" required class="form-control"> --}}
                                    </div>
                                </div>
                            </div>

                            {{-- START FORM DANA DIBUTUHKAN UNTIL HRAGA PAKET --}}
                            <div class="col-lg-12">
                                <div class="form-group p-1 m-0 mt-3 col-lg-6  float-left">
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Dana Dibutuhkan</i></div>
                                            </div>
                                        <input type="number" name="total_need" placeholder="Dana dibutuhkan" class="form-control" required>
                                    </div>

                                    {{-- <label for="total_need" class=" form-control-label">Dana Dibutuhkan</label>
                                    <input type="number" name="total_need" placeholder="Total Pendanaan" class="form-control" required> --}}
                                </div>
                                <div class="form-group p-1 m-0 mt-3 col-lg-6  float-right">
                                    <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Harga Paket</i></div>
                                            </div>
                                        <input type="number" name="harga_paket" placeholder="Harga Paket" class="form-control" required>
                                    </div>

                                    {{-- <label for="harga_paket" class=" form-control-label">Harga Paket</label>
                                    <input type="number" name="harga_paket" placeholder="Harga Paket" class="form-control" required> --}}
                                </div>
                            </div>
                             {{--END FORM DANA DIBUTUHKAN UNTIL HARGA PAKET  --}}

                            <div class="col-lg-12 p-4">
                                <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Initial</i></div>
                                        </div>
                                    <input type="number" name="terkumpul"class="form-control" placeholder="Initial / Terkumpul" required>
                                </div>
                                {{-- <div class="form-group p-3">
                                    <label for="terkumpul" class=" form-control-label">Total pendanaan Initial</label>
                                    <input type="number" name="terkumpul" value=0 class="form-control" required>
                                </div> --}}
                            </div>

                             {{-- START FORM START PENGGALANGAN  --}}
                            <div class="col-lg-12 mt-2">
                                <div class="form-group p-1 m-0 col-lg-5 float-left">
                                    <label for="tgl_mulai_penggalangan" class=" form-control-label">Tanggal Mulai Penggalangan Dana</label>
                                    <input type="date" name="tgl_mulai_penggalangan" id="penggalangan_mulai" value="{{Carbon\Carbon::now()->toDateString()}}" class="form-control" required>
                                </div>
                                <div class="form-group p-1 m-0 col-lg-5 float-left">
                                    <label for="tgl_selesai_penggalangan" class=" form-control-label">Tanggal Selesai Penggalangan Dana</label>
                                    <input type="date" name="tgl_selesai_penggalangan" id="penggalangan_selesai" placeholder="" class="form-control" required>
                                </div> 
                                <div class="form-group p-1 m-0 col-lg-2 float-right">
                                    <label for="tgl_selesai_penggalangan" class=" form-control-label">Jumlah Hari</label>
                                    <input type="text" id="jumlah" placeholder="" class="form-control" readonly>
                                </div> 
                            </div>
                            {{-- END FORM START PENGGALANGAN SELSAI --}}
                            {{-- START FORM START PROYEK --}}
                            <div class="col-lg-12">
                                <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                                    <label for="tgl_mulai_penggalangan" class=" form-control-label">Tanggal Mulai Proyek</label>
                                    <input type="date" name="tgl_mulai" id="id_start_proyek" class="form-control" required>
                                    {{-- <label for="tgl_mulai" class=" form-control-label">Tanggal mulai proyek</label>
                                    <input type="date" name="tgl_mulai" placeholder="Tanggal mulai proyek" class="form-control" required> --}}
                                </div>
                                <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                                    <label for="tgl_mulai_penggalangan" class=" form-control-label">Tanggal Selesai Proyek</label>
                                    <input type="date" name="tgl_selesai" id="id_end_proyek" class="form-control" required>
                                    {{-- <label for="tgl_selesai" class=" form-control-label">Tanggal selesai proyek</label> 
                                    <input type="date" name="tgl_selesai" placeholder="Tanggal selesai proyek" class="form-control" required> --}}
                                </div>
                                
                                <div class="form-group p-1 m-0 mt-3 col-lg-2 float-right">
                                    <label for="tgl_selesai_penggalangan" class=" form-control-label">Tenor Proyek</label>
                                    <input type="text" id="jumlah_tenor" name="tenor_waktu" class="form-control" readonly>
                                </div> 
                            </div>
                            {{-- START FORM END PROYEK --}}
                            {{-- START FORM ADDITIONAL --}}
                            <div class="col-lg-12">
                                <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                                    <label for="waktu_bagi_hasil" class=" form-control-label">Waktu Bagi hasil : </label>
                                    <select name="waktu_bagi" class="form-control" id="" required>
                                        <option value="" class="form-control"> None </option>
                                        <option value="1" class="form-control"> Bulan </option>
                                        <option value="2" class="form-control"> Akhir Proyek</option>
                                    </select>
                                </div>
                                <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                                    <label for="embed_picture" class=" form-control-label">Embed Picture :</label>
                                    <select name="embed_picture" class="form-control" id="" required>
                                        <option value="" class="form-control"> None </option>
                                        <option value="1" class="form-control"> Normal </option>
                                        <option value="/Badge/Premium.png" class="form-control"> Premium Deal </option>
                                    </select>
                                </div>
                                
                                <div class="form-group p-1 m-0 mt-3 col-lg-2 float-right">
                                    <label for="iklan" class=" form-control-label">Tampilkan Iklan :</label>
                                    <br>
                                    <label for="terkumpul" class=" form-control-label"><input type="radio" name="status_tampil" value="2" checked class="form-control">Ya</label>
                                    &nbsp;
                                    <label for="terkumpul" class=" form-control-label"><input type="radio" name="status_tampil" value="1" class="form-control">Tidak</label>
                                </div> 
                            </div>
                            {{-- END FORM ADDITIONAL --}}
                            {{-- <div class="col-lg-5 col-sm-12">
                                <div class="form-group">
                                    <label for="terkumpul" class=" form-control-label">Waktu Bagi hasil : </label>
                                        <select name="waktu_bagi" class="form-control" id="" required>
                                            <option value="" class="form-control"> None </option>
                                            <option value="1" class="form-control"> Bulan </option>
                                            <option value="2" class="form-control"> Akhir Proyek</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-12">
                                <div class="form-group">
                                    <label  class=" form-control-label">Embed Picture :</label>
                                    <select name="embed_picture" class="form-control" id="" required>
                                            <option value="" class="form-control"> None </option>
                                            <option value="1" class="form-control"> Normal </option>
                                            <option value="/Badge/Premium.png" class="form-control"> Premium Deal </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-12 float-right">
                                <div class="form-group">
                                    <label for="terkumpul" class=" form-control-label">Tampilkan Iklan :</label>
                                    <br>
                                    <label for="terkumpul" class=" form-control-label"><input type="radio" name="status_tampil" value="2" checked class="form-control">Ya</label>
                                    &nbsp;
                                    <label for="terkumpul" class=" form-control-label"><input type="radio" name="status_tampil" value="1" class="form-control">Tidak</label>
                                        
                                </div>
                            </div> --}}

                            <style>
                                .nav-pills .nav-link.active, .nav-pills .show > .nav-link{
                                    background-color: green;
                                    color: white;
                                    border-radius:5px;
                                }
                            </style>
                            <div class="col-12">
                            
                            <div id="exTab1" class="container-fluid"> 
                                    <ul class="nav nav-pills " id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-deskripsi-tab" data-toggle="pill" href="#deskripsi" role="tab" aria-controls="pills-deskripsi" aria-selected="true">Deskripsi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-pemilik-projec-tab" data-toggle="pill" href="#pemilik-projec" role="tab" aria-controls="pills-pemilik-projec" aria-selected="false">Pemilik Proyek</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-legalitas-tab" data-toggle="pill" href="#legalitas" role="tab" aria-controls="pills-legalitas" aria-selected="false">Legalitas</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="pills-simulasi-tab" data-toggle="pill" href="#simulasi" role="tab" aria-controls="pills-simulasi" aria-selected="false">Simulasi</a>
                                    </li> --}}
                                    </ul>
                                    
                                <div class="tab-content mt-2">
                                    <div class="tab-pane active" id="deskripsi">
                                        <div class="form-group">
                                            <textarea name="deskripsi" ></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pemilik-projec">
                                        <div class="form-group">
                                            <textarea name="pemilik_projec"></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="legalitas">
                                        <div class="form-group">
                                            <textarea name="legalitas"></textarea>
                                        </div>
                                    </div>
                                    {{-- <div class="tab-pane" id="simulasi">
                                        <div class="form-group">
                                            <textarea name="simulasi"></textarea>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>
                    </div>
    
    
                      {{-- <div class="col-lg-6">
                        <div class="card">
                          <div class="card-header"><strong>Pemilik Paket</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group">
                                    <label for="nama" class=" form-control-label">Nama</label>
                                    <input type="text" name="namapemilik" placeholder="Nama pemilik proyek" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class=" form-control-label">Email</label>
                                    <input type="email" name="emailpemilik" placeholder="Email pemilik proyek" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class=" form-control-label">Telephone</label>
                                    <input type="number" name="phonepemilik" placeholder="Telephone pemilik proyek" class="form-control" required>
                                </div>                      
                            </div>
                        </div>
                      </div> --}}
    
                      <div class="col-lg-12 col-sm-12">
                        <div class="card">
                          <div class="card-header"><strong>Gambar Proyek</strong></div>
                          <div class="card-body card-block">
                            {{-- <div class="form-group">
                                <label for="dokumen" class=" form-control-label">Dokumen Terkait</label>
                                <input type="file" name="dokumen_terkait_pemilik" class="form-control" required>
                            </div>   --}}
                            <div class="form-group">
                                <label for="gambar350x233" class=" form-control-label">Thumbnail Profile Proyek 350x233</label>
                                <input type="file" name="gambar_utama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="gambar730x486" class=" form-control-label">Slider Profile Proyek 730x486 (multiple)</label>
                                <input type="file" name="gambar[]" class="form-control" multiple required>
                            </div>
                            
                          </div>
                        </div>
                      </div>
    
                      <hr>
                      <div class="col-lg-12 mb-5">
                        <button type="submit" class="btn btn-success btn-block">submit</button>
                      </div>
                  
            </form>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
        $(document).ready( function(){

            function monthDiff(dt1, dt2) {
                return dt2.getMonth() - dt1.getMonth() + 
                    (12 * (dt2.getFullYear() - dt1.getFullYear()))
            }

             // $('#jumlah_tenor').val('')
             $('#id_start_proyek,#id_end_proyek').on('focusout', function(){
                var id_start = $('#id_start_proyek').val();
                console.log(id_start)
                var id_end = $('#id_end_proyek').val();
                dt1 = new Date(id_start);
                dt2 = new Date(id_end);
                
                if(dt2 <= dt1)
                {
                    alert('Tanggal Selesai harus melebihi Tanggal Mulai');
                    $('#jumlah_tenor').val('');
                }
                else
                {
                    result = monthDiff(dt1, dt2);
                    if(isNaN(result))
                    {
                      $('#jumlah_tenor').val('0');
                    }
                    else
                    {
                      $('#jumlah_tenor').val(result);
                      console.log(result);
                    }
                }
            });

            // $('#jumlah').val('');
            $('#penggalangan_selesai,#penggalangan_mulai').on('focusout', function(){
                // alert('teh')
                var date1 = new Date($('#penggalangan_mulai').val());
                var date2 = new Date($('#penggalangan_selesai').val());
                if ( date2 < date1){
                    alert('Tanggal Penggalangan Selesai harus melebihi Tanggal Penggalangan Mulai');
                    $('#jumlah').val('');
                }
                else
                {
                    var timeDiff = Math.abs(date1.getTime() - date2.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    var count = diffDays+1;
                    $('#jumlah').val(count);
                    console.log(diffDays)
                }
            });
        });
</script>        

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        height: 300,
        theme: 'modern',
        skin:'lightgray',
        plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        image_advtab: true,
        file_picker_callback: function(callback, value, meta) {
        if (meta.filetype == 'image') {
            $('#upload').trigger('click');
            $('#upload').on('change', function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                callback(e.target.result, {
                alt: ''
                });
            };
            reader.readAsDataURL(file);
            });
        }
        },
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
</script>

@endsection