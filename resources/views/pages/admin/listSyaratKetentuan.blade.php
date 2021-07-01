@extends('layouts.admin.master')

@section('title', 'Dashboard Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>List Syarat dan Ketentuan</h1>
                    </div>
                </div>
            </div>
            
</div>
            <div class="content mt-3">
                
                            <div class="row">
                            <div class="col-md-12">
                            @if(session()->has('delete'))
                                <div class="alert alert-success">
                                    {{ session()->get('delete') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            {{-- @elseif(session()->has('verif_failed'))
                                <div class="alert alert-danger">
                                    {{ session()->get('verif_failed') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> --}}
                            @endif
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Data Table</strong>
                                    </div>
                                    <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Writer</th>
                                    <th>Syarat dan Ketentuan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($term_condition as $item)
                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->writer}}</td>
                                    <td><button class="btn btn-info btn-block" data-toggle="modal" data-target="#{{$item->id}}">Detil</button></td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit{{$item->id}}">Edit</button>

                                        <form action="{{Route('admin.deleteSyaratKetentuan')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        
                                    </td>
                                </tr>
                                
                                <div class="modal fade" id="{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Detil Syarat dan Ketentuan : {{$item->title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="card-body card-block">
                                                            <div class="form-group">
                                                                <label for="nama" class=" form-control-label">Deskripsi</label>
                                                                <p>{!!$item->deskripsi!!}</p>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Edit Syarat dan Ketentuan : {{$item->title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="card-body card-block">
                                                        <form action="{{route('admin.updateSyaratKetentuan')}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="nama" class=" form-control-label">Judul</label>
                                                                <input type="text" name="judul" class="form-control" value="{{$item->title}}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama" class=" form-control-label">Writer</label>
                                                                <input type="text" name="writer" class="form-control" value="{{$item->writer}}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="deskripsi" class=" form-control-label">Isi Syarat dan Ketentuan</label>
                                                                <textarea id= "deskripsi" name="deskripsi">
                                                                    {!!$item->deskripsi!!}
                                                                </textarea>
                                                            </div>
                                                            <input type="text" hidden name="id" value="{{$item->id}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                                        </form> 
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                </tbody>
                            </table>
                                    </div>
                                </div>
                            </div>


                            </div>
                    </div><!-- .content -->



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


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#deskripsi',
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