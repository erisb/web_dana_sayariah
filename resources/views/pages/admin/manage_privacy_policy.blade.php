@extends('layouts.admin.master')

@section('title', 'Dashboard Admin')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Konten Manajemen Website</h1>
            </div>
        </div>
    </div>
</div>
<div class="content mt-3">
    <div class="row">
        <div class="col-md-12">
            <!--@if (session('error'))
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
            @endif -->
    
            <div class="card" id="view_card_table">
                <div class="card-header">
                    <strong class="card-title">Data Kebijakan</strong>
                </div>
                <div class="card-body">

                <!--Master-->    
                <!--button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Testimoni Pendana</button-->

                <button class="btn btn-success" data-toggle="modal" data-target="#tambah">Tambah Data</button><br/><br/>
                <table id="table_privacy" class="table table-striped table-bordered table-responsive-sm">
                    <thead>
                        <tr>
                            <th style="display: none;">Id</th>
                            <th>No</th>
                            <th>Nama</th>
                            <th>File</th>
                            <th>Penerbit</th>
                            <th>Publish</th>
                            <th>Pembaharuan Terakhir</th>
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

<!-- start modal tambah privacy -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Tambah Data </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.addPrivacy')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <div class="form-row">
                            <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                <label for="foto_diri" class="font-weight-bold">Nama</label>
                                <input type="text" class="col-sm-12 form-control" name="title" placeholder="Nama" required="required"><br/>

                                <label for="foto_diri" class="font-weight-bold">Unggah File</label>
                                <input type="file" class="form-control" name="file" placeholder="Type Here"><br/>

                                <label for="foto_diri" class="font-weight-bold">Publish</label>
                                <select class="form-control" name="publish" required="required">
                                    <option selected="true" disabled="disabled">Pilih</option>
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option>
                                </select>
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
<!-- end of modal tambah privacy -->

<!-- start modal ganti privacy -->
<div class="modal fade" id="ganti" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Edit Data </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.updatePrivacy')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <input type="hidden" name="id" id="id">
                        <div class="form-row">
                            <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                <label class="font-weight-bold">Nama</label>
                                <input type="text" class="col-sm-12 form-control" id="edit_title" name="title" placeholder="Nama" required="required"><br/>

                                <label class="font-weight-bold">Unggah File</label>
                                <input type="file" class="form-control" name="file" id="edit_file" placeholder="Type Here"><br/>

                                <label class="font-weight-bold">Publish</label>
                                <select class="form-control" id="edit_publish" name="publish" required="required">
                                    <option selected="true" disabled="disabled">Pilih </option>
                                    <option value="1">Ya</option>
                                    <option value="2">Tidak</option>
                                </select>
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
<!-- end of modal ganti privacy -->

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
            var privacyTable = $('#table_privacy').DataTable({
                searching: true,
                processing: true,
                // serverSide: true,
                ajax: {
                    url: '/admin/list_privacy/',
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
                    { data : 'title'},
                    { data : null,
                        render:function(data,type,row,meta){
                            return '<a target="_blank" href="{{ asset("/storage")}}/'+ data.file +'">' + data.file + ' </a>';
                        }
                    },
                    { data : 'author'},
                    { data : null,
                      render: function (data, type, row, meta) {
                                if (row.publish == 1)
                                {
                                    return '<span class="btn btn-info">Ya</span>';
                                }
                                else
                                {
                                    return '<span class="btn btn-danger">Tidak</span>';
                                }
                                
                        }
                    },
                    { data : 'updated_at'},
                    { data: null,
                        render:function(data,type,row,meta){
                            
                            return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_privacy" title="Edit"><i class="fa fa-edit"></i></button><br><br><button class="btn btn-danger btn-sm active" data-toggle="modal" data-target="#privacy" id="hapus_privacy" title="Hapus"><i class="fa fa-trash"></button>';
                        }
                    }
                ],
                columnDefs: [
                    { targets: [0], visible: false}
                ]
            });
                        
            $('#table_privacy tbody').on( 'click', '#ganti_privacy', function () {
                var data = privacyTable.row( $(this).parents('tr') ).data();
                id = data.id;
                title = data.title;
                file = data.file;
                publish = data.publish;

                $('#id').val(id);
                $('#edit_title').val(title);
                $('#edit_file').val(file);
                $('#edit_publish').val(publish);
            });

            $('#table_privacy tbody').on('click','#hapus_privacy',function(){
                var data = privacyTable.row( $(this).parents('tr') ).data();
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
                                    url:'deletePrivacy/'+id,
                                    method:'delete',
                                    dataType:'json',
                                    success:function(data)
                                    {
                                        if (data.status == 'Sukses')
                                        {
                                            swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                              function(){ 
                                                privacyTable.ajax.reload();
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