@extends('layouts.admin.master')

@section('title', 'Panel Admin')
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}
<!-- end modal show progrss -->
{{-- <style>
    .modal-xl {
        max-width: 60% !important;
      }
</style> --}}

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-12">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Proyek</h1>
                    </div>
                </div>
                <div class="page-header float-right">
                    <div class="page-title">
                        <h1><a href="{{route('admin.proyek.download')}}" class="btn btn-success btn-block"> Ekspor Excel</a></h1>
                    </div>
                </div>
            </div>
</div>

<div class="content mt-3">
        @if(session()->has('progressadd'))
            <div class="alert alert-danger">
                {{ session()->get('progressadd') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->has('updatedone'))
            <div class="alert alert-success">
                {{ session()->get('updatedone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->has('createdone'))
            <div class="alert alert-info">
                {{ session()->get('createdone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <table id="proyek_data" class="table table-striped table-bordered table-responsive-sm">
            <thead>
            <tr>
                <th style="display: none;">Id</th>
                <th>No</th>
                <th>Nama Proyek</th>
                <th>Dibutuhkan</th>
                <th>Dana Awal</th>
                <th>Detil</th>
                {{-- <th>Pembayaran</th> --}}
                <th>Progres</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

<!-- start of modal detil -->

<div class="modal fade" id="proyek_detil" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Detil </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{route('admin.proyek.update.post')}}" method="POST"  enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id_proyek" name="id" >
                <input type="hidden" id="status_id" name="status_id" >
                {{-- START FORM NAME UNTIL GEOCODE --}}
                <div class="col-lg-12 p-0 m-0">
                    <div class="card-body card-block">
                        <div class="form-group p-1 m-0">
                            <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Nama Proyek</i></div>
                                    </div>
                                <input type="text" name="nama" id="nama_proyek" placeholder="Nama proyek" class="form-control" required>
                            </div>
                            {{-- <label for="nama" class=" form-control-label">Nama</label>
                            <input type="text" name="nama" placeholder="Nama proyek" class="form-control" required> --}}
                        </div>
                        <div class="form-group p-1 m-0 mt-3 col-lg-6 float-left">
                            <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Alamat Proyek</i></div>
                                    </div>
                                <input type="text" name="alamat" id="alamat_proyek"  placeholder="Alamat Proyek" class="form-control" required>
                            </div>
                            {{-- <label for="alamat" class=" form-control-label">Alamat</label>
                            <input type="text" name="alamat" placeholder="Alamat Proyek" class="form-control" required> --}}
                        </div>
                        <div class="form-group p-1 m-0 mt-3 col-lg-6 float-right">
                            <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i>Geocode</i> Proyek</div>
                                    </div>
                                <input type="text" name="geocode" id="geocode_proyek" placeholder="Geocode alamat proyek" class="form-control" required>
                            </div>

                            {{-- <label for="geocode" class=" form-control-label"><i>Geocode</i></label>
                            <input type="text" name="geocode" placeholder="Geocode alamat proyek" class="form-control" required> --}}
                        </div>                      
                    </div>
                </div>
                {{-- END OF NAME UNTIL GEOCODE --}}

                {{-- START FORM AKAD UNTIL TANGGAL SELSAI PROYEK --}}
                <div class="col-lg-12 p-0 m-0">
                    <div class="card-body card-block">         
                        <div class="form-group p-1 m-0 col-lg-6 float-left">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Akad</i></div>
                                </div>
                                    <select name="akad" class="form-control" id="id_akad" required>
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
                                        <div class="input-group-text">Margin Keuntungan %</i></div>
                                    </div>
                                <input type="number" name="profit_margin" id="profit_margin" placeholder="Profit Margin" required class="form-control">
                            </div>
                            {{-- <label for="profit_margin" class=" form-control-label">Margin Keuntungan %</label>
                            
                            <input type="number" name="profit_margin" placeholder="Presentase profit pendana pertahun" required class="form-control"> --}}
                        </div>
                    </div>
                </div>
                {{-- END FORM AKAD UNTIL TANGGAL SELSAI --}}

                {{-- START FORM DANA DIBUTUHKAN UNTIL HRAGA PAKET --}}
                <div class="col-lg-12">
                    <div class="form-group p-1 m-0 mt-3 col-lg-6  float-left">
                        <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Dana Dibutuhkan RP</i></div>
                                </div>
                            <input type="number" name="total_need" id="total_need" placeholder="Dana dibutuhkan" class="form-control" required>
                        </div>

                        {{-- <label for="total_need" class=" form-control-label">Dana Dibutuhkan</label>
                        <input type="number" name="total_need" placeholder="Total Pendanaan" class="form-control" required> --}}
                    </div>
                    <div class="form-group p-1 m-0 mt-3 col-lg-6  float-right">
                        <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Harga Paket RP</i></div>
                                </div>
                            <input type="number" name="harga_paket" id="harga_paket" placeholder="Harga Paket" class="form-control" required>
                        </div>

                        {{-- <label for="harga_paket" class=" form-control-label">Harga Paket</label>
                        <input type="number" name="harga_paket" placeholder="Harga Paket" class="form-control" required> --}}
                    </div>
                </div>

                {{--END FORM DANA DIBUTUHKAN UNTIL HARGA PAKET  --}}
                <div class="col-lg-12 p-4">
                    <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Dana Awal RP</i></div>
                            </div>
                        <input type="number" name="terkumpul" id="terkumpul" class="form-control" placeholder="Initial / Terkumpul" required>
                    </div>
                    {{-- <div class="form-group p-3">
                        <label for="terkumpul" class=" form-control-label">Total pendanaan Awal</label>
                        <input type="number" name="terkumpul" value=0 class="form-control" required>
                    </div> --}}
                </div>
                {{-- START FORM START PENGGALANGAN  --}}
                <div class="col-lg-12 mt-2">
                    <div class="form-group p-1 m-0 col-lg-5 float-left">
                        <label for="tgl_mulai_penggalangan" class=" form-control-label">Tanggal Mulai Penggalangan Dana</label>
                        <input type="date" name="tgl_mulai_penggalangan" id="penggalangan_mulai" class="form-control" >
                    </div>
                    <div class="form-group p-1 m-0 col-lg-5 float-left">
                        <label for="tgl_selesai_penggalangan" class=" form-control-label">Tanggal Selesai Penggalangan Dana</label>
                        <input type="date" name="tgl_selesai_penggalangan" id="penggalangan_selesai" placeholder="" class="form-control" required>
                    </div>
                    <div class="form-group p-1 m-0 col-lg-2 float-left">
                        <label for="tgl_selesai_penggalangan" class=" form-control-label">Jumlah Hari</label>
                        <input type="text" id="jumlah" placeholder="" class="form-control" readonly >
                    </div>  
                </div>   
                {{-- END FORM START PENGGALANGAN SELSAI --}}
                <div class="col-lg-12">
                    <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                        <label for="tgl_mulai_penggalangan" class=" form-control-label">Tanggal Mulai Proyek</label>
                        <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control" required>
                    </div>
                    <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                        <label for="tgl_mulai_penggalangan" class=" form-control-label">Tanggal Selesai Proyek</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control" required>
                    </div>
                    
                    <div class="form-group p-1 m-0 mt-3 col-lg-2 float-right">
                        <label for="tgl_mulai_penggalangan" class=" form-control-label">Tenor Proyek</label>
                        <!--<input type="text" id="id_tenor" name="tenor_waktu" class="form-control" >-->
                        <input type="text" id="id_tenor" name="tenor_waktu" class="form-control" readonly >
                    </div> 
                </div>

                <div class="col-lg-12">
                    <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                        <label for="tgl_mulai_penggalangan" class=" form-control-label">Waktu Bagi hasil : </label>
                        <select name="waktu_bagi" class="form-control" id="id_hasil">
                            <option value="1" class="form-control" > Bulan </option>
                            <option value="2" class="form-control" > Akhir Proyek</option>
                        </select>
                    </div>
                    <div class="form-group p-1 m-0 mt-3 col-lg-5 float-left">
                        <label for="tgl_mulai_penggalangan" class=" form-control-label">Embed Picture :</label>
                        <select name="embed_picture" class="form-control" id="id_embed">
                            <option value="1" class="form-control"> Normal </option>
                            <option value="/Badge/Premium.png" class="form-control"> Premium Deal </option>
                        </select>
                    </div>
                    
                    <div class="form-group p-1 m-0 mt-3 col-lg-2 float-right">
                        <label for="tgl_mulai_penggalangan" class=" form-control-label">Tampilkan Iklan :</label>
                        <br>
                        <label for="terkumpul" class=" form-control-label status_view"><input type="radio" name="status_tampil" value="2" id="1_tampil"  class="form-control">Ya</label>
                        &nbsp;
                        <label for="terkumpul" class=" form-control-label status_view"><input type="radio" name="status_tampil" value="1" id="2_tampil"  class="form-control">Tidak</label>
                    </div> 
                </div>

				
                {{-- 
				
				<div class="col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label for="terkumpul" class=" form-control-label">Waktu Bagi hasil : </label>
                            <select name="waktu_bagi" class="form-control" id="id_hasil">
                                    <option value="1" class="form-control" > Bulan </option>
                                    <option value="2" class="form-control" > Akhir Proyek</option>
                            </select>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div class="form-group">
                        <label  class=" form-control-label">Embed Picture :</label>
                        <select name="embed_picture" class="form-control" id="id_embed">
                            <option value="1" class="form-control"> Normal </option>
                            <option value="/Badge/Premium.png" class="form-control"> Premium Deal </option>
                        </select>
                    </div>
                </div>

                
                <div class="col-lg-3 col-sm-12 float-right">
                    <div class="form-group">
                        <label for="terkumpul" class=" form-control-label">Tampilkan Iklan :</label>
                        <br>
                        <label for="terkumpul" class=" form-control-label status_view"><input type="radio" name="status_tampil" value="2" id="1_tampil"  class="form-control">Ya</label>
                        &nbsp;
                        <label for="terkumpul" class=" form-control-label status_view"><input type="radio" name="status_tampil" value="1" id="2_tampil"  class="form-control">Tidak</label>
                    </div>
                    
                </div> --}}
                <style>
                .nav-pills .nav-link.active, .nav-pills .show > .nav-link{
                    background-color: green;
                    color: white;
                    border-radius:5px;
                }
                </style>
                <div class="col-12" id="tab_">
                    
                    <div id="exTab" class="container-fluid">  
                            <ul class="nav nav-pills " id="tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="deskripsi-tab" data-toggle="tab" href="#deskripsi" role="tab" aria-controls="deskripsi" aria-selected="true">Deskripsi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pemilik-projec-tab" data-toggle="tab" href="#pemilik-projec" role="tab" aria-controls="pemilik-projec" aria-selected="false">Pemilik Proyek</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="legalitas-tab" data-toggle="tab" href="#legalitas" role="tab" aria-controls="legalitas" aria-selected="false">Legalitas</a>
                            </li>
                            <li class="nav-item">
                                {{-- <a class="nav-link" id="simulasi-tab" data-toggle="tab" href="#simulasi" role="tab" aria-controls="simulasi" aria-selected="false">Simulasi</a> --}}
                            </li>
                            </ul>
                        <div class="tab-content mt-2">
                            <div class="tab-pane show active " id="deskripsi">
                                <div class="form-group">
                                    <input type="hidden" id="id_deskripsi" name="id_deskripsi" >
                                    <textarea id='textarea_deskripsi' name="deskripsi"></textarea>
                                </div>
                            </div>
                            <div class="tab-pane" id="pemilik-projec">
                                <div class="form-group">
                                    <input type="hidden" id="id_pemilik" name="id_pemilik" >
                                    <textarea id='textarea_pemilik' name="pemilik_projec"></textarea>
                                </div>
                            </div>
                            <div class="tab-pane" id="legalitas">
                                <div class="form-group">
                                    <input type="hidden" id="id_legalitas" name="id_legalitas" value="">
                                    <textarea  id="textarea_legalitas" name="legalitas"></textarea>
                                </div>
                            </div>
                            {{-- <div class="tab-pane" id="simulasi">
                                <div class="form-group">
                                    <input type="hidden" id="id_simulasi" name="id_simulasi" value="">
                                    <textarea id='textarea_simulasi' name="simulasi"></textarea>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
        
                {{-- <div class="col-lg-6">
                    <div class="card">
                    <div class="card-header"><small> Detil  </small><strong>Pemilik Paket</strong></div>
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="nama" class=" form-control-label">Nama</label>
                                <input type="text" name="namapemilik" id="nama_pemilik" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class=" form-control-label">email</label>
                                <input type="email" name="emailpemilik" id="email_pemilik" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="phone" class=" form-control-label">Telephone</label>
                                <input type="number" name="phonepemilik" id="phone_pemilik" class="form-control" required>
                            </div>                      
                        </div>
                    </div>
                </div> --}}
        
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header"><strong>Gambar Proyek</strong></div>
                        <div class="card-body card-block">
                            {{-- <div class="form-group">
                                <label for="dokumen" class=" form-control-label">Dokumen Terkait</label>
                                <input type="file"  name="dokumen_terkait_pemilik" class="form-control file_changeable">
                            </div>   --}}
                            <div class="form-group">
                                <label for="gambar350x233" class=" form-control-label">Thumbnail Profile Proyek 350x233</label>
                                <input type="file"  name="gambar_utama" class="form-control file_changeable" >
                            </div>
                            <div class="form-group">
                                <label for="gambar730x486" class=" form-control-label">Slider Profile Proyek 730x486 (multiple)</label>
                                <input type="file"  name="gambar[]" class="form-control file_changeable" multiple >
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-lg-12">
                        <div class="card">
                        <div class="card-header"><small> Detil  </small><strong>Gambar</strong></div>
                            <div class="card-body card-block">
                                <div class="from-group">
                                    <label for="Saved Images" class=" form-control-label">Gambar Tersimpan</label>
                                    <ul class="list-group"id="gambar_proyek">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    
                </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >Ubah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
        </div>
    </form>
    </div>
</div>
<!-- end of modal detil -->

<!-- start modal show progress -->
<div class="modal fade" id="progress_show" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Detil Progres</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row">
                            <div class="col-1">ID</div>
                            <div class="col-2">Tanggal</div>
                            <div class="col-3">Deskripsi</div>
                            <div class="col-3">Gambar</div>
                        </div>
                        <hr>
                        <div class="show_progress"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal show progrss -->
<style>
    .modal-xl {
        max-width: 90% !important;
      }
</style>
<!-- start modal show payout -->
{{-- <div class="modal fade" id="view_payout_detil" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Detil Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row ">
                            <div class="col-lg-4">Bulan Imbal Hasil</div>
                            <div class="col-lg-3">Tanggal Imbal Hasil</div>
                            <div class="col-lg-3">Status</div>
                            <div class="col-lg-1">Aksi</div>
                        </div>
                        <hr>
                        <div class="show_payout p-1"></div>
            </div>
            <div class="modal-footer payout_footer">
            </div>
        </div>
    </div>
</div> --}}
<!-- end modal show payout -->

    <!-- start of modal create progress -->
<div class="modal fade" id="progress_create" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Tambah Progress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="{{route('admin.proyek.progress.post')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12">
                        <div class="card">
                        <div class="card-body card-block">
                                <input type="hidden" name="id_proyek_progress" id="id_proyek_progress" class="form-control">
                            <div class="form-group">
                                <label for="nama" class=" form-control-label">tanggal</label>
                                <input type="date" name="tanggal" class="form-control " required>
                            </div>
                            <div class="form-group">
                                <label for="gambar730x486" class=" form-control-label">Gambar 730x486 (recomend)</label>
                                <input type="file" name="gambar" class="form-control" multiple required>
                            </div>
                            <div class="form-group">
                                <textarea id="progress_textarea" name="deskripsi_progres"></textarea>
                            </div>
                            
                        </div>
                    </div>
                </div>
            
    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambahkan progres</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- end of modal create progress -->
    


    <!-- 2. GOOGLE JQUERY JS v3.2.1  JS !-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
    <script src="/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
    {{-- <script src="//cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>
    <script>
            CKEDITOR.replaceAll(textarea, function(){
                    extraPlugins = 'uploadimage';
                    extraPlugins: 'easyimage';
            });
            
    </script> --}}
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
	
    <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    </script>    
    <script type="text/javascript">
    
        $(document).ready(function() {
        
           var proyekTable = $('#proyek_data').DataTable({
                searching: true,
                processing: true,
                ajax: {
                    url: '/admin/proyek/manage_proyek',
                    dataSrc: 'data'
                },
                paging: true,
                info:true,
                lengthChange:false,
                pageLength:10,
                columns: [
                    
                    {data: 'id'},             
                    {data: 'nama'},
                    {data: 'total_need', render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'terkumpul', render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: null, 
                        render:function(data,type,row,meta){
                            return '<button class="btn btn-info " data-toggle="modal" data-target="#proyek_detil" id="detil_proyek">Detil</button>';
                            
                        }
                    },
                    // {data:null,
                    //     render:function(data,type,row,meta){
                    //         return '<button class="btn btn-info" id="detil_payout">Generate</button> <button class="btn btn-info" data-toggle="modal" data-target="#view_payout_detil" id="view_payout">View Payout</button>';
                    //     }
                    // },
                    {data: null, 
                        render:function(data,type,row,meta){
                            return '<button class="btn btn-primary" data-toggle="modal" data-target="#progress_show" id="detil_progress"><span class="ti-list"></span></button>'
                                  +'<button class="btn btn-success" data-toggle="modal" data-target="#progress_create" id="creat_progress"><span class="ti-plus"></span></button>';
                        }
                    },
                    {data: null,
                        render:function(data,type,row,meta){
                            if ( row.status == 1 ) {
                                return '<p style="color:green">Active</p>';
                            }
                            else if ( row.status == 2 ) {
                                return '<p style="color:grey">Closed</p>';
                            }
                            else if ( row.status == 3 ) {
                                return '<p style="color:red">Full</p>';
                            }
                            else if ( row.status == 4 ) {
                                return '<p style="color:red">Finish</p>';
                            }
                            else
                            {
                                return '<p style="color:red">-</p>';
                            }

                        }
                    },

                ],
            })
            var id;
			
			$(document).on("click", "#detil_proyek", function(){
			
			
				var data = proyekTable.row( $(this).parents('tr') ).data();
				var id = data.id;
				var tgl_selesai = "";
				 $.ajax({
                    url: "/admin/proyek/manage_detil_proyek/"+id,
                    method: "get",
                    success:function(data,value)
                    {
						console.log(data);
						detail_proyek = data.data_proyek;
                        detail_gambar = data.data_gambar;
						
						status = detail_proyek.status;
						waktu_bagi = detail_proyek.waktu_bagi;
                        id_deskripsi = detail_proyek.id_deskripsi;
						deskripsi = detail_proyek.deskripsi;
                        deskripsi_legalitas = detail_proyek.deskripsi_legalitas;
                        deskripsi_pemilik = detail_proyek.deskripsi_pemilik;
                        deskripsi_simulasi = detail_proyek.deskripsi_simulasi;

                        status_tampil = detail_proyek.status_tampil;
                        waktu_bagi = detail_proyek.waktu_bagi;
                        tenor_waktu = detail_proyek.tenor_waktu;
                        embed_picture = detail_proyek.embed_picture;
                        nama_pemilik = detail_proyek.nama_pemilik;
                        email_pemilik = detail_proyek.email_pemilik;
                        phone_pemilik = detail_proyek.phone_pemilik;
						
						$('#id_proyek').val(id); // id proyek
						$('#status_id').val(status); // status proyek
						
						// nama proyek
						$("#nama_proyek").val(detail_proyek.nama);
						// alamat proyek
						$("#alamat_proyek").val(detail_proyek.alamat);
						// googlemaps
						$("#geocode_proyek").val(detail_proyek.geocode);
						
						if (detail_proyek.akad == 1) {
                            document.getElementById('id_akad').value = 1;
                        }else {
                            document.getElementById('id_akad').value = 2;
                        }
						
						// profit margin
						$("#profit_margin").val(detail_proyek.profit_margin);
						// total dibutuhkan
						$("#total_need").val(detail_proyek.total_need);
						// harga paket
						$("#harga_paket").val(detail_proyek.harga_paket);
						//dana terkumnpul
						$("#terkumpul").val(detail_proyek.terkumpul);
						
						// Tanggal mulai penggalangan
						var tgl_mulai_p = detail_proyek.tgl_mulai_penggalangan;
                        var tgl_selesai_p = detail_proyek.tgl_selesai_penggalangan; 
						$('#penggalangan_mulai').val(tgl_mulai_p);
						$('#penggalangan_selesai').val(tgl_selesai_p);
						
						// set jumlah hari masa penggalangan dana
						var timeDiffClick = Math.abs(new Date(tgl_mulai_p).getTime() - new Date(tgl_selesai_p).getTime());
						var diffDaysClick = Math.ceil(timeDiffClick / (1000 * 3600 * 24));
                        var resultDaysClick = diffDaysClick + 1;
                      
						$('#jumlah').val(resultDaysClick); // result hari masa penggalangan
						
						// validasi masa penggalangan dana
						$('#penggalangan_mulai,#penggalangan_selesai').on('focusout', function(){
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
                                var resultDays = diffDays;
                                $('#jumlah').val(resultDays); // jumlah hari
                            }
                        });
						
						// tanggal mulai proyek
						var tgl_mulai = detail_proyek.tgl_mulai;
						var tgl_data_mulai = tgl_mulai.split(" ");
						var tgl_data_mulai_split = tgl_data_mulai[0].split("-");
						
						// split tanggal mulai
						var tgl_mulai_thn = tgl_data_mulai_split[0];
						var tgl_mulai_bln = tgl_data_mulai_split[1];
						var tgl_mulai_tgl = tgl_data_mulai_split[2];
						
						// tanggal selesai proyek
						tgl_selesai = detail_proyek.tgl_selesai;
						
						var dateSrt 		= new Date(tgl_mulai_thn, tgl_mulai_bln, tgl_mulai_tgl);
						var currentDay 		= dateSrt.getDate();
						var currentMonth 	= dateSrt.getMonth() + tenor_waktu;
						
						
						
						var twoDigitMonth 	= ((dateSrt.getMonth().length+1) == 1)? (dateSrt.getMonth()+tenor_waktu) : '' + (dateSrt.getMonth()+tenor_waktu);
						var currentDate 	= dateSrt.getDate() + "/" + twoDigitMonth + "/" + dateSrt.getFullYear();
						
						//dateSrt.setMonth(currentMonth + tenor_waktu, currentDay);
						
						
						
						
						if(tgl_selesai == null){
							
							tgl_selesai = ""
							$('#tgl_selesai').val(dateSrt.getDate() + "/" + twoDigitMonth + "/" + dateSrt.getFullYear());
							
						}else{
							
							
							var tgl_data_selesai = tgl_selesai.split(" ");
							$('#tgl_selesai').val(tgl_data_selesai[0]);
							
						}
						
						
						$('#tgl_mulai').val(tgl_data_mulai[0]);
 
						
						// set jumlah bulan tanggal mulai proyek dan tanggal selesai proyek
						function monthDiff(dt1, dt2) {
                            return dt2.getMonth() - dt1.getMonth() + 
                                (12 * (dt2.getFullYear() - dt1.getFullYear()))
                        }
						
						
						//var txtDay = $.datepicker.formatDate('dd-mm-yy', dateSrt);
						//alert(dateSrt.setMonth(currentMonth + tenor_waktu, currentDay));
						
						//$("#tgl_selesai").val(dateSrt);
						
						$('#id_tenor').val(tenor_waktu); // set tenor
						$('#tgl_mulai,#tgl_selesai').on('focusout', function(){
							
                            var id_start = $('#tgl_mulai').val();
							var id_end = $('#tgl_selesai').val();
                               
							if(id_end <= id_start)
							{
								alert('Tanggal Selesai harus melebihi Tanggal Mulai');
								$('#id_tenor').val(tenor_waktu); // set tenor
							}
							else
							{
								dt1 = new Date(id_start);
								dt2 = new Date(id_end);
								result = monthDiff(dt1, dt2);
			   
								$('#id_tenor').val(result);
			   
							}

                        });
						
						if(status_tampil == 2)
                        {
                            $('#1_tampil').attr('checked',true)
                        }
                        else if (status_tampil == 1)
                        {
                            $('#2_tampil').attr('checked',true)
                        }
                        else
                        {

                        }
						
						if ( waktu_bagi == 1)
                        {
                            document.getElementById('id_hasil').value = 1;
                        }
                        else
                        {
                            document.getElementById('id_hasil').value = 2;
                        }
						
						$("#id_deskripsi").val(id_deskripsi);
						$('#textarea_deskripsi').html('');
                        if (deskripsi != null){
                            tinymce.get('textarea_deskripsi').setContent(deskripsi);
                        }
                        else{
                            tinymce.get('textarea_deskripsi').setContent("");
                        }
						$('#deskripsi_pemilik').html('');
						if (deskripsi_pemilik != null){
							tinymce.get('textarea_pemilik').setContent(deskripsi_pemilik);
						}
						else{
							tinymce.get('textarea_pemilik').setContent("");
						}
						$('#deskripsi_legalitas').html('');
						if (deskripsi_legalitas != null){
							tinymce.get('textarea_legalitas').setContent(deskripsi_legalitas);
						}
						else{
							tinymce.get('textarea_legalitas').setContent("");
						}

						
						// detail gambar
						$('#gambar_proyek').html('');
                        console.log(detail_gambar)
                        $.each(detail_gambar,function(index,value){
                            $('#gambar_proyek').append(
                                '<li class="list-group-item"> <img src="{{asset("/storage")}}/'+value.gambar+'" style="width:100px; height:100px;" class="rounded float-left p-0 ml-3 m-3" alt="gambar"> '+value.gambar+' <a href="{{url("admin/proyek/deletegambar")}}/'+value.id+'"><b>X</b></a></li>'
                            );
                        });
					}
				 });
				
			});
			
			
			/*
			$('#proyek_data tbody').on('click', '#detil_proyek', function(){
                
                var data = proyekTable.row( $(this).parents('tr') ).data();
                id = data.id;
                nama = data.nama;
                akad = data.akad;
                id_deskripsi = data.id_deskripsi;
                id_legalitas = data.id_legalitas;
                id_pemilik = data.id_pemilik;
                id_simulasi = data.id_simulasi;
                $.ajax({
                    url: "/admin/proyek/manage_detil_proyek/"+id,
                    method: "get",
                    success:function(data,value)
                    {
                        
                        //console.log(data.data_proyek)
                        detil_proyek = data.data_proyek;
                        detil_gambar = data.data_gambar;
                        
                        // alamat = detil_proyek.status
                        alamat = detil_proyek.alamat
                        geocode = detil_proyek.geocode
                        profit_margin = detil_proyek.profit_margin
                        total_need = detil_proyek.total_need
                        harga_paket = detil_proyek.harga_paket
                        tgl_mulai = detil_proyek.tgl_mulai
                        tgl_selesai = detil_proyek.tgl_selesai
                        terkumpul = detil_proyek.terkumpul


                        tgl_mulai_p = detil_proyek.tgl_mulai_penggalangan
                        tgl_selesai_p = detil_proyek.tgl_selesai_penggalangan 
                        // console.log(tgl_mulai_p
                        deskripsi = detil_proyek.deskripsi
                        deskripsi_legalitas = detil_proyek.deskripsi_legalitas
                        deskripsi_pemilik = detil_proyek.deskripsi_pemilik
                        deskripsi_simulasi = detil_proyek.deskripsi_simulasi

                        status = detil_proyek.status
                        status_tampil = detil_proyek.status_tampil
                        waktu_bagi = detil_proyek.waktu_bagi
                        tenor_waktu = detil_proyek.tenor_waktu
                        embed_picture = detil_proyek.embed_picture
                        nama_pemilik = detil_proyek.nama_pemilik
                        email_pemilik = detil_proyek.email_pemilik
                        phone_pemilik = detil_proyek.phone_pemilik

                        // images = detil_gambar.gambar
                        // var x = render;
                        //$('#status_id').val(status)
                        if(status_tampil == 2)
                        {
                            $('#1_tampil').attr('checked',true)
                        }
                        else if (status_tampil == 1)
                        {
                            $('#2_tampil').attr('checked',true)
                        }
                        else
                        {

                        }
                        //$(".status_view:checked").val(status_tampil)
                        // start detil proyek
                        $('#id_proyek').val(id);
                        $('#nama_proyek').val(nama);
                        $('#alamat_proyek').val(alamat);
                        $('#geocode_proyek').val(geocode);
                        $('#total_need').val(total_need);
                        $('#harga_paket').val(harga_paket);

                        if (akad == 1) {
                            document.getElementById('id_akad').value = 1;
                        }else {
                            document.getElementById('id_akad').value = 2;
                        }
                        // if (value.akad == 1){
                        //     var select = "selected=selected";
                        //     $('#id_murabahah').attr('style','display:block').prop(select);
                        //     $('#id_mudharabah').attr('style','display:none');
                        //     $('#id_akad_null').attr('style','display:none');
                            
                        // }
                        // else if (value.akad == 2){
                        //     var select = "selected=selected";
                        //     $('#id_mudharabah').attr('style','display:block').prop(select);
                        //     $('#id_murabahah').attr('style','display:none');
                        //     $('#id_akad_null').attr('style','display:none');
                        // }
                        // else{
                        //     $('#id_akad_null').attr('style','display:block');
                        //     $('#id_murabahah').attr('style','display:none');
                        //     $('#id_mudharabah').attr('style','display:none');
                        // }
                        $('#profit_margin').val(profit_margin);
                        tgl_data_mulai = tgl_mulai.split(" ");
                        $('#tgl_mulai').val(tgl_data_mulai[0]);
                        tgl_data_selsai = tgl_selesai.split(" ");
                        $('#tgl_selesai').val(tgl_data_selsai[0]);


                        $('#total_need').val(total_need);
                        $('#terkumpul').val(terkumpul);

                        var m_proyek = $('#tgl_mulai').val(tgl_data_mulai[0]);

                        //console.log(tgl_data_mulai[0])
                        //function monthDiff(d1, d2) {
                        //    var months;
                        //    months = (d2.getFullYear() - d1.getFullYear()) * 12;
                        //    months -= d1.getMonth() + 1;
                        //    months += d2.getMonth();
                        //    return months <= 0 ? 0 : months;
                        //}

                        function monthDiff(dt1, dt2) {
                            return dt2.getMonth() - dt1.getMonth() + 
                                (12 * (dt2.getFullYear() - dt1.getFullYear()))
                        }

                        $('#tgl_mulai,#tgl_selesai').on('focusout', function(){
                               var id_start = $('#tgl_mulai').val();
                               var id_end = $('#tgl_selesai').val();
                               
                               if(id_end <= id_start)
                               {
                                   alert('Tanggal Selesai harus melebihi Tanggal Mulai');
                                   $('#id_tenor').val('');
                               }
                               else
                               {
                                    dt1 = new Date(id_start);
                                    dt2 = new Date(id_end);
                                    result = monthDiff(dt1, dt2);
                   
                                    $('#id_tenor').val(result);
                   
                                    console.log(result);
                               }

                        });

                        $('#penggalangan_mulai').val(tgl_mulai_p);
                        $('#penggalangan_selesai').val(tgl_selesai_p);
                        var timeDiffClick = Math.abs(new Date(tgl_mulai_p).getTime() - new Date(tgl_selesai_p).getTime());
                        var diffDaysClick = Math.ceil(timeDiffClick / (1000 * 3600 * 24));
                        var resultDaysClick = diffDaysClick + 1;
                        $('#jumlah').val(resultDaysClick);

                        $('#penggalangan_mulai,#penggalangan_selesai').on('focusout', function(){
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
                                var resultDays = diffDays + 1;
                                $('#jumlah').val(resultDays);
                            }
                        });
                            
                        if ( waktu_bagi == 1)
                        {
                            document.getElementById('id_hasil').value = 1;                        
                        }
                        else
                        {
                            document.getElementById('id_hasil').value = 2;
                        }
                        // if (waktu_bagi == 1){
                        //     $('#id_bulan').attr('style','display:block');
                        //     $('#id_akhir').attr('style','display:none');
                        //     $('#id_waktu_bagi').attr('style','display:none');
                        // } 
                        // else if( waktu_bagi = 2) {
                        //     $('#id_bulan').attr('style','display:none');
                        //     $('#id_akhir').attr('style','display:block');
                        //     $('#id_waktu_bagi').attr('style','display:none');
                        // }
                        // else {
                        //     $('#id_bulan').attr('style','display:none');
                        //     $('#id_akhir').attr('style','display:none');
                        //     $('#id_waktu_bagi').attr('style','display:block');
                        // }
                        
                        if(tenor_waktu != null){
                            $('#id_tenor').val(tenor_waktu);
                        }
                        else{
                            $('#id_tenor').val('');
                        }

                            if(id_embed != null ){
                                $('#id_embed').val(embed_picture);
                            }
                            else{
                                $('#id_embed').val('');                            
                            }

                        // start tabnav
                        if (id_deskripsi != null){
                            $('#id_deskripsi').val(id_deskripsi);
                        }else{
                            $('#id_deskripsi').val('');
                        }

                            if (id_pemilik != null){
                                $('#id_pemilik').val(id_pemilik);
                            }else{
                                $('#id_pemilik').val('');
                            }

                                if (id_legalitas != null){
                                    $('#id_legalitas').val(id_legalitas);
                                }else{
                                    $('#id_legalitas').val('');
                                }

                                    if (id_simulasi != null){
                                        $('#id_simulasi').val(id_simulasi);
                                    }else{
                                        $('#id_simulasi').val('');
                                    }
                        
                        //  start textarea nav tabs
                        $('#textarea_deskripsi').html('');
                        if (deskripsi != null){
                            tinymce.get('textarea_deskripsi').setContent(deskripsi);
                        }
                        else{
                            tinymce.get('textarea_deskripsi').setContent("");
                        }
                            $('#deskripsi_pemilik').html('');
                            if (deskripsi_pemilik != null){
                                tinymce.get('textarea_pemilik').setContent(deskripsi_pemilik);
                            }
                            else{
                                tinymce.get('textarea_pemilik').setContent("");
                            }
                                $('#deskripsi_legalitas').html('');
                                if (deskripsi_legalitas != null){
                                    tinymce.get('textarea_legalitas').setContent(deskripsi_legalitas);
                                }
                                else{
                                    tinymce.get('textarea_legalitas').setContent("");
                                }

                                
                                    // $('#textarea_simulasi').html('');
                                    // if (deskripsi_simulasi != null){
                                    //     tinymce.get('textarea_simulasi').setContent(deskripsi_simulasi);
                                    // }
                                    // else{
                                    //     tinymce.get('textarea_simulasi').setContent("");
                                    // }


                        // if ( nama_pemilik != null){
                        //     $('#nama_pemilik').val(nama_pemilik);
                        // }
                        // else
                        // {
                        //     $('#nama_pemilik').val('');
                        // }

                        //         if (email_pemilik != null){
                        //             $('#email_pemilik').val(email_pemilik);
                        //         }
                        //         else
                        //         {
                        //             $('#email_pemilik').val('');
                        //         }

                        //                 if (phone_pemilik != null){
                        //                     $('#phone_pemilik').val(phone_pemilik);
                        //                 }
                        //                 else
                        //                 {
                        //                     $('#phone_pemilik').val('');
                        //                 }

                        $('#gambar_proyek').html('');
                        console.log(detil_gambar)
                        $.each(detil_gambar,function(index,value){
                            $('#gambar_proyek').append(
                                '<li class="list-group-item"> <img src="{{asset("/storage")}}/'+value.gambar+'" style="width:100px; height:100px;" class="rounded float-left p-0 ml-3 m-3" alt="gambar"> '+value.gambar+' <a href="{{url("admin/proyek/deletegambar")}}/'+value.id+'"><b>X</b></a></li>'
                            );
                        });
                    }
                });

            });
			*/
			
            $('#proyek_data tbody').on('click', '#detil_progress', function(){
                var data = proyekTable.row( $(this).parents('tr') ).data();
                id = data.id;
                console.log(id)
                $.ajax({
                    url: "/admin/proyek/manage_progres_proyek/"+id,
                    method: "get",
                    success:function(data)
                    {
                        detil_progress = data.data_progress;
                        console.log(detil_progress)
                        $('.show_progress').html('');
                        $.each(detil_progress,function(index,value){
                            $('#progress_show').find('.show_progress').append(
                                '<div class="row">'+
                                '<div class="col-1">'+ value.proyek_id +'</div>'+
                                '<div class="col-2">'+ value.tanggal +'</div>'+
                                '<div class="col-3">'+ value.deskripsi +'</div>'+
                                '<div class="col-3"> <img src="{{asset("/storage")}}/'+ value.pic +'" style="width:100px; height:100px;" class="rounded float-left p-0 ml-3 m-3" alt="gambar"></div>'+
                                '</div>'+
                                '<hr>'
                            );
                        });
                        
                    }
                });

            });

            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            };

          

            $('#proyek_data tbody').on('click', '#creat_progress', function(){
                var data = proyekTable.row( $(this).parents('tr') ).data();
                id = data.id
                console.log(id)
                $('#id_proyek_progress').val(id);
            })
            
            

        });
    </script>

    <script>
        tinymce.init({
            selector: '#textarea_deskripsi',
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
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
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

    <script>
        tinymce.init({
            selector: '#textarea_pemilik',
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
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
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

    <script>
        tinymce.init({
            selector: '#textarea_legalitas',
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
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
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

    {{-- <script>
        tinymce.init({
            selector: '#textarea_simulasi',
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
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script> --}}

<script>
        tinymce.init({
            selector: '#progress_textarea',
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
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
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