@extends('layouts.admin.master')

@section('title', 'Create Syarat Ketentuan')

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Create Syarat Ketentuan</h1>
                </div>
            </div>
        </div>
    </div>

    <form action="{{route('admin.postSyaratKetentuan')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card">
                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card-header"><small> Form  </small><strong>Syarat Ketentuan</strong></div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Writer</label>
                        <input type="text" name="writer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class=" form-control-label">Isi Syarat Ketentuan</label>
                        <textarea id="deskripsi" name="deskripsi"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success btn-block">Submit</button>
        </div>
    </form>

<script src="/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
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