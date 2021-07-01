@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Versi Mobile</h1>
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
    
    <div class="card" id="view_card_table">
        <div class="card-header">
            <strong class="card-title">Data Versi Mobile</strong>
            <button class="btn btn-success float-right" data-toggle="modal" data-target="#modalAddVersion" style="margin-left: 15px;">Tambah Versi Mobile</button>
        </div>
        <div class="card-body">
        <table id="tableVersion" class="table table-striped table-bordered table-responsive-sm">
            <thead>
            <tr>
                <th>No</th>
                <th>id</th>
                <th>Kode Versi</th>
                <th>Versi</th>
                <th>Tanggal</th>
                <th>Gambar</th>
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
<!-- The Modal Add Version -->
<div class="modal" id="modalAddVersion">
  <div class="modal-dialog modal-xl modal-custom">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Modal Tambah Versi</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="/admin/postVersionMobile" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="">Versi</label>
              <input type="text" class="form-control" id="" placeholder="Version" name="version">
            </div>
            <div class="form-group col-lg-6">
              <label for="">Kode Versi</label>
              <input type="number" class="form-control" id="" placeholder="Kode Version" name="version_code">
            </div>
            {{-- <div class="form-group col-lg-6">
              <label for="">Tanggal Publish Versi</label>
              <input type="date" class="form-control" id="" name="created_date">
            </div> --}}
          </div>
          <div class="form-row">
            <div class="form-group col-lg-12">
              <label for="">Dokumen Gambar Publikasi</label>
              <input type="file" class="form-control" id="" name="location">
            </div>
          </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Tambah</button>
      </form>
      </div>

    </div>
  </div>
</div>


<!-- The Modal Edit Version -->
<div class="modal" id="modalDetilVersion">
    <div class="modal-dialog modal-xl modal-custom">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title">Modal Tambah Versi</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
          <form action="/admin/editVersionMobile" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="">Versi</label>
                <input type="hidden" id="idVersi" name="idVersion">
                <input type="text" class="form-control" id="version" placeholder="Version" name="editVersion">
              </div>
              <div class="form-group col-lg-6">
                <label for="">Kode Versi</label>
                <input type="number" class="form-control" id="kodeVersion" placeholder="Kode Version" name="editVersion_code">
              </div>
              {{-- <div class="form-group col-lg-6">
                <label for="">Tanggal Publikasi Versi</label>
                <input type="date" class="form-control" id="tglVersion" name="editCreated_date">
              </div> --}}
            </div>
            <div class="form-row">
              <div class="form-group col-lg-6">
                <label for="">Gambar Sekarang </label>
                <div id="gmbrNow">

                </div>
              </div>
              <div class="form-group col-lg-6">
                <label for="">Dokumen Gambar Publikasi</label>
                <input type="file" class="form-control" id="editGmbr" name="editLocation">
              </div>
            </div>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Ubah Versi</button>
        </form>
        </div>
  
      </div>
    </div>
  </div>

</div><!-- .content -->

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


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
          var versionTable = $('#tableVersion').DataTable({
            "bSort": false,
            "paging": true,
            "searching": true,
            ajax: {
              url : '/admin/tableManageVersion',
              type : 'get',
            },
            
            "columns" : [
                { "data" : "no" },
                { "data" : "id" },
                { "data" : "versionMobile" },
                { "data" : "kodeVersionMobile" },
                { "data" : "tanggalMobile" },
                { "data" : "gambarMobile" },
              ],
            
            "columnDefs" : [
              {
                "targets": 1,
                class : 'text-left',
                "visible" : false
                
              },
              {
                "targets": 5,
                class : 'text-left',
                "visible" : false
                
              },
              {
                "targets": 6,
                class : 'text-left',
                //"visible" : false
                "render" : function(data, type, value, meta){
                  return '<button class="btn btn-info" data-toggle="modal" data-target="#modalDetilVersion" id="detilVersion" >Detil Versi</button> <br> <br>'+
                         '<button class="btn btn-danger"  id="deleteVersion" >Hapus Versi</button>';
                  //return row[6];
                }
              }
            ],
          });

          
          $('#tableVersion tbody').on('click','#detilVersion', function(){
            var data = versionTable.row( $(this).parents('tr') ).data();
            $('#gmbrNow').html('')
            console.log(data)
            tgl = data.tanggalMobile;
            tglVersionNow = tgl.split(" ");
            $('#idVersi').val(data.id)
            $('#kodeVersion').val(data.versionMobile)
            $('#version').val(data.kodeVersionMobile)
            $('#tglVersion').val(tglVersionNow[0])
            $('#gmbrNow').append('<img src="/storage/'+data.gambarMobile +'">')
          })

          $('#tableVersion tbody').on('click', '#deleteVersion', function(){
              var data = versionTable.row( $(this).parents('tr') ).data();
              console.log(data)
              id = data.id;
              $.ajax({
                url : '/admin/deleteVersion/'+id,
                method : 'get',
                success:function(data)
                {
                  if(data.data == 'sukses')
                  {
                    alert('File Version Dihapus');
                    location.reload()
                  }
                  else
                  {
                    alert('File Gagal Bos');                  
                  }
                }
              })
          })
        });


    </script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

@endsection