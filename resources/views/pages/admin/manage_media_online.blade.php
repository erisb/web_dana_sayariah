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
                    <strong class="card-title">Data Media Online</strong>
                </div>
                <div class="card-body">  
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Media Online</button>
                    <table id="table_media" class="table table-striped table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>No</th>
                                <th>Gambar</th>
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

    <!-- start modal tambah gambar -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Tambah Media Online : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.addMediaOnline')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="card-body card-block">
                                <div class="form-row">
                                    <div class="col-lg-12">
                                        <label for="foto_diri" class="font-weight-bold">Unggah Gambar</label>
                                        <input type="file" class="form-control" name="gambar" placeholder="Type Here">
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
    <!-- end of modal tambah gambar -->

    <!-- start modal ganti gambar -->
    <div class="modal fade" id="ganti" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Ganti Gambar : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.updateMediaOnline')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <input type="hidden" name="id" id="gambar_id">
                            <div class="form-row">
                                <div class="col-lg-12">
                                    <label for="foto_diri" class="font-weight-bold">Unggah Gambar</label>
                                    <img id="foto1"><br><br>
                                    <input type="file" class="form-control" name="gambar" placeholder="Type Here">
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
    <!-- end of modal ganti gambar -->
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
        var gambarTable = $('#table_media').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/list_media_online/',
                dataSrc: 'data'
            },
            paging: true,
            info: true,
            lengthChange:false,
            order: [ 1, 'asc' ],
            pageLength: 10,
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
                        return '<img src="{{asset("/storage")}}/'+data.gambar+'">';
                        //return '<img src="/img/'+data.gambar +'" height=\"80\" width=\"140\">';
                    }
                },
                { data : 'author'},
                { data : 'updated_at'},
                { data: null,
                    render:function(data,type,row,meta){

                        return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_gambar" title="Edit"><i class="fa fa-edit"></i></button>&nbsp;&nbsp;<button class="btn btn-danger btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_media" title="Hapus"><i class="fa fa-trash"></i></button>';
                    }
                }
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });
                    
        $('#table_media tbody').on( 'click', '#ganti_gambar', function () {
            var data = gambarTable.row( $(this).parents('tr') ).data();
            id = data.id;
            gambar = data.gambar;
            //console.log(gambar)
            $('#gambar_id').val(id);
            tinymce.get('u_ket').setContent(ket);
            $('#foto1').attr('src','{{ asset('/storage')}}/'+gambar);
        });

        $('#table_media tbody').on('click','#hapus_media',function(){
            var data = gambarTable.row( $(this).parents('tr') ).data();
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
                                url:'deleteMediaOnline/'+id,
                                method:'delete',
                                dataType:'json',
                                success:function(data)
                                {
                                    if (data.status == 'Sukses')
                                    {
                                        swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                          function(){ 
                                               gambarTable.ajax.reload();
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
<!--script src="//cdn.tinymce.com/4/tinymce.min.js"></script-->
@endsection