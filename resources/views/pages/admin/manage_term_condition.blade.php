@extends('layouts.admin.master')

@section('title', 'Dashboard Admin')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Manage Content Management System (CMS)</h1>
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
                    <strong class="card-title">Data Term & Condition</strong>
                </div>
                <div class="card-body">
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Term & Condition</button>
                    <table id="table_termcondition" class="table table-striped table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>No</th>
                                <!-- <th>Title</th> -->
                                <th>Deskripsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- start modal tambah term & condition -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Tambah Term & Condition : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.addTermCondition')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <div class="form-row">
                                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Title</label>
                                    <input type="text" class="col-sm-12 form-control allowCharacter" name="title" placeholder="Title" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                    <textarea name="deskripsi"></textarea>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah Term & Condition</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of modal tambah term & condition -->

    <!-- start modal ganti term & condition -->
    <div class="modal fade" id="ganti" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Ganti Term & Condition : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.updateTermCondition')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <input type="hidden" name="id" id="id">
                            <div class="form-row">
                                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Title</label>
                                    <input type="text" class="col-sm-6 form-control" name="edit_title" id="edit_title" placeholder="Title" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                    <textarea name="edit_deskripsi" id="edit_deskripsi" placeholder="Deskripsi"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Term & Condition</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of modal ganti term & condition -->
</div>
<!-- .content -->
    
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
    
    $('.allowCharacter').on('input', function (event) { 
            this.value = this.value.replace(/[^a-zA-Z0-9.,-/ ]/g, '');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var termconditionTable = $('#table_termcondition').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/list_termcondition/',
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
                //{ data : 'title'},
                { data : null,
                    render:function(data,type,row,meta){
                        
                        return '<iframe src="#" scrolling="no" height="500px" width="1000px"></iframe>';
                    }
                },
                { data: null,
                    render:function(data,type,row,meta){
                        
                        return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_termcondition" title="Edit"><i class="fa fa-edit"></i></button><br><br><button class="btn btn-danger btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_termcondition" title="Hapus"><i class="fa fa-trash"></button>';
                    }
                }
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });
                    
        $('#table_termcondition tbody').on( 'click', '#ganti_termcondition', function () {
            var data = termconditionTable.row( $(this).parents('tr') ).data();
            id = data.id;
            title = data.title;
            content = data.content;

            $('#id').val(id);
            $('#edit_title').val(title);
            $('#edit_deskripsi').val(content);
        });

        $('#table_termcondition tbody').on('click','#hapus_termcondition',function(){
            var data = termconditionTable.row( $(this).parents('tr') ).data();
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
                                url:'deleteTermCondition/'+id,
                                method:'delete',
                                dataType:'json',
                                success:function(data)
                                {
                                    if (data.status == 'Sukses')
                                    {
                                        swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                          function(){ 
                                               termconditionTable.ajax.reload();
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

    $('#edit_deskripsi').html('');
    if (deskripsi != null){
        tinymce.get('textarea_deskripsi').setContent(deskripsi);
    }
    else{
        tinymce.get('textarea_deskripsi').setContent("");
    }
</script>
@endsection