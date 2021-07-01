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
                    <strong class="card-title">Data Disclaimer</strong>
                </div>
                <div class="card-body">
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Disclaimer</button>
                    <table id="table_disclaimer" class="table table-striped table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>No</th>
                                <th>Deskripsi</th>
                                <th>Penerbit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- start modal tambah disclaimer -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Tambah Disclaimer : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.addDisclaimer')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <div class="form-row">
                                <div class="col-sm-12 col-lg-12 ml-12 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                    <textarea name="deskripsi"></textarea>
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
    <!-- end of modal tambah disclaimer -->

    <!-- start modal ganti disclaimer -->
    <div class="modal fade" id="ganti" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Ganti Disclaimer : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.updateDisclaimer')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <input type="hidden" name="id" id="id">
                            <div class="form-row">
                                <div class="col-sm-12 col-lg-12 ml-12 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                    <textarea id="edit_deskripsi" name="edit_deskripsi"></textarea>
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
    <!-- end of modal ganti disclaimer -->
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
        var disclaimerTable = $('#table_disclaimer').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/list_disclaimer/',
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
                { data : 'content'},
                { data : 'author'},
                { data: null,
                    render:function(data,type,row,meta){
                        
                        return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_disclaimer" title="Edit"><i class="fa fa-edit"></i></button><br><br><button class="btn btn-danger btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_disclaimer" title="Hapus"><i class="fa fa-trash"></i></button>';
                    }
                }
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });
                    
        $('#table_disclaimer tbody').on( 'click', '#ganti_disclaimer', function () {
            var data = disclaimerTable.row( $(this).parents('tr') ).data();
            var id = data.id;
            var content = data.content;
            //alert(content);

            $('#id').val(id);
            $("#edit_deskripsi").val(content);
            tinymce.get('edit_deskripsi').setContent(content);

        });

        $('#table_disclaimer tbody').on('click','#hapus_disclaimer',function(){
            var data = disclaimerTable.row( $(this).parents('tr') ).data();
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
                                url:'deleteDisclaimer/'+id,
                                method:'delete',
                                dataType:'json',
                                success:function(data)
                                {
                                    if (data.status == 'Sukses')
                                    {
                                        swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                          function(){ 
                                               disclaimerTable.ajax.reload();
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