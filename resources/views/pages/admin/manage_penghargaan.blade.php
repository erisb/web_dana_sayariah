@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Penghargaan</h1>
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
            <strong class="card-title">Data Penghargaan</strong>
        </div>
        <div class="card-body">
        <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Penghargaan</button>
        <table id="table_carousel" class="table table-striped table-bordered table-responsive-sm">
            <thead>
            <tr>
                <th style="display: none;">Id</th>
                <th>No</th>
                <th>Titel</th>
                <th>Keterangan</th>
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

<!-- start modal tambah gambar -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Tambah Gambar : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.addPenghargaan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <div class="form-row">
                            <div class="col-lg-12">
                                <label for="foto_diri" class="font-weight-bold">Judul</label>
                                <input type="text" class="form-control" name="title" placeholder="Title">
                            </div>
                            <div class="col-lg-12">
                                <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                               <textarea name="keterangan" id="" class="form-control"  cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="foto_diri" class="font-weight-bold">Unggah Gambar</label>
                                <input type="file" class="form-control" name="gambar" placeholder="Type Here">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Tambah Penghargaan</button>
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
            <form action="{{route('admin.updatePenghargaan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <input type="hidden" name="id" id="gambar_id">
                        <div class="form-row">
                            <div class="col-lg-12">
                                <label for="foto_diri" class="font-weight-bold">Judul</label>
                                <input type="text" class="form-control" id="u_title" name="title" placeholder="Title">
                            </div>
                            <div class="col-lg-12">
                                <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                <textarea name="keterangan" id="u_ket" class="form-control"  cols="30" rows="10"></textarea>
                            </div>
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
                <button type="submit" class="btn btn-primary">Perbaharui Gambar</button>
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
            var gambarTable = $('#table_carousel').DataTable({
                searching: true,
                processing: true,
                // serverSide: true,
                ajax: {
                    url: '/admin/data_penghargaan_datatables/',
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
                    
                    { data :'title'},
                    { data :'keterangan'},
                    { data :'tgl_publish'},
                    { data : null,
                        render:function(data,type,row,meta){
                            
                            return '<img src="{{ asset('/storage')}}/'+row.gambar+'">';
                        }
                    },
                    { data: null,
                        render:function(data,type,row,meta){
                            
                            return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_gambar">Ganti Gambar</button><br><br><button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_gambar">Hapus Gambar</button>';
                        }
                    }
                ],
                columnDefs: [
                    { targets: [0], visible: false}
                ]
            });
                        
            $('#table_carousel tbody').on( 'click', '#ganti_gambar', function () {
                var data = gambarTable.row( $(this).parents('tr') ).data();
                id = data.id;
                title = data.title
                ket = data.keterangan
                gambar = data.gambar;
                console.log(gambar)
                $('#gambar_id').val(id);
                $('#u_title').val(title);
                tinymce.get('u_ket').setContent(ket);
                $('#foto1').attr('src','{{ asset('/storage')}}/'+gambar);
            });

            $('#table_carousel tbody').on('click','#hapus_gambar',function(){
                var data = gambarTable.row( $(this).parents('tr') ).data();
                id = data.id;
                swal({
                        title: "Confirm",   
                        text: "Mau Di Hapus?",   
                        type: "warning",   
                        showCancelButton: true,   
                        confirmButtonColor: "#DD6B55",   
                        confirmButtonText: "Yes, delete it!",   
                        cancelButtonText: "No, cancel please!",   
                        closeOnConfirm: false,   
                        closeOnCancel: false
                        },

                        function(isConfirm){   
                          if (isConfirm) 
                            {
                                  $.ajax({
                                    url:'deletePenghargaan/'+id,
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

<script>
    tinymce.init({
        selector: '#u_ket',
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