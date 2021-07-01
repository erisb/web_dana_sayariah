@extends('layouts.admin.master')

@section('title', 'Dashboard Admin')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Kelola Konten Manajemen Website</h1>
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
                    <strong class="card-title">Data Testimoni Pendana</strong>
                </div>
                <div class="card-body">

                    <!--Master-->    
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Testimoni Pendana</button>

                    <table id="table_testimoni" class="table table-striped table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Pendana</th>
                                <th>Testimoni</th>
                                <!-- <th>Link</th> -->
                                <th>Penerbit</th>
                                <th>Pembaharuan Terakhir</th>
                                <th style="width:60px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- start modal tambah testimoni -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Tambah Testimoni Pendana : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.addTestimoni')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <div class="form-row">
                                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Nama Pendana</label>
                                    <input type="text" class="col-sm-12 form-control" name="nama_pendana" placeholder="Nama Pendana" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Testimoni</label>
                                    <textarea class="col-sm-12 form-control" name="testimoni" placeholder="Isi Testimoni" required="required" cols="30" rows="10"></textarea><br/>

                                    <!-- <label for="foto_diri" class="font-weight-bold">Link Testimoni</label>
                                    <input type="text" class="col-sm-12 form-control" name="link_testimoni" placeholder="Link Testimoni"><br/> -->

                                    <label for="foto_diri" class="font-weight-bold">Unggah Foto</label>
                                    <input type="file" class="form-control" name="foto_pendana" placeholder="Type Here">
                                </div>
                            </div>   
                        </div>
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
    <!-- end of modal tambah testimoni -->

    <!-- start modal ganti testimoni -->
    <div class="modal fade" id="ganti" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Ganti Testimoni Pendana : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.updateTestimoni')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <input type="hidden" name="id" id="id">
                            <div class="form-row">
                                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Edit Foto</label>
                                    <img id="foto1"><br>
                                    <input type="file" class="form-control" id="edit_gambar" name="foto_pendana" placeholder="Type Here"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Nama Pendana</label>
                                    <input type="text" class="col-sm-12 form-control" name="edit_nama" id="edit_nama" placeholder="Nama Pendana" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                    <textarea type="text" class="col-sm-12 form-control" name="edit_content" id="edit_content" placeholder="Edit Deskripsi" cols="30" rows="10" required="required"></textarea><br/>

                                    <!-- <label for="foto_diri" class="font-weight-bold">Link</label>
                                    <input type="text" class="col-sm-12 form-control" name="edit_link" id="edit_link" placeholder="Link"> -->
                                </div>
                            </div>
                        </div>
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
    <!-- end of modal ganti testimoni -->
</div>
<!-- end of content -->
    
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
        var url = "{{asset('/storage')}}";
        //alert (url);
        var testimoniTable = $('#table_testimoni').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/list_testimoni/',
                dataSrc: 'data'
            },
            paging: true,
            info: true,
            lengthChange:false,
            order: [ 1, 'asc' ],
            pageLength: 5,
            columns: [
                { data: 'id'},
                { data : null,
                  render: function (data, type, row, meta) {
                          //I want to get row index here somehow
                          return  meta.row+1;
                    }
                },
                { data : null,
                    render:function(data,type,row,meta){
                        //return '<img src="/img/'+data.gambar +'" height=\"80\">';
                        return '<img src="{{ asset("/storage")}}/'+data.gambar+'">';
                    }
                },
                { data : 'nama'},
                { data : 'content'},
                /*{ data : null,
                    render:function(data,type,row,meta){
                        return '<a target="_blank" href="'+ data.link +'">' + data.link + ' </a>';
                    }
                },*/
                { data : 'author'},
                { data : 'updated_at'},
                { data: null,
                    render:function(data,type,row,meta){
                        
                        return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_testimoni" title="Edit"><i class="fa fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_testimoni" title="Hapus"><i class="fa fa-trash"></button>';
                    }
                }
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });
                    
        $('#table_testimoni tbody').on( 'click', '#ganti_testimoni', function () {
            var data = testimoniTable.row( $(this).parents('tr') ).data();
            id = data.id;
            gambar = data.gambar;
            nama = data.nama;
            content = data.content;
            link = data.link;

            $('#id').val(id);
            //$('#edit_gambar').val(gambar);
            $('#edit_nama').val(nama);
            $('#edit_content').val(content);
            $('#edit_link').val(link);
        });

        $('#table_testimoni tbody').on('click','#hapus_testimoni',function(){
            var data = testimoniTable.row( $(this).parents('tr') ).data();
            id = data.id;
            swal({
                    title: "Konfirmasi",   
                    text: "Mau Di Hapus?",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Ya, hapus data!",   
                    cancelButtonText: "Tidak, batalkan!",   
                    closeOnConfirm: false,   
                    closeOnCancel: false
                    },

                    function(isConfirm){   
                      if (isConfirm) 
                        {
                              $.ajax({
                                url:'deleteTestimoni/'+id,
                                method:'delete',
                                dataType:'json',
                                success:function(data)
                                {
                                    if (data.status == 'Sukses')
                                    {
                                        swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                          function(){ 
                                               testimoniTable.ajax.reload();
                                           }
                                          );
                                    }
                                },
                                error:function(error){
                                    alert('ada error nih!');
                                }
                              })  
                        } 

                      else
                        {     
                          swal("Gagal", "Data anda aman", "error");   
                        }
                    }
            );
        });
    });
</script>
@endsection