@extends('layouts.admin.master')

@section('title', 'Berita admin')

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Create News</h1>
                </div>
            </div>
        </div>
    </div>

    <form action="{{route('admin.postNews')}}" method="POST" enctype="multipart/form-data">
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
                <div class="card-header"><small> Form  </small><strong>Berita</strong></div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Judul</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Penulis</label>
                        <input type="text" name="writer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class=" form-control-label">Isi News</label>
                        <textarea name="deskripsi"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Gambar Berita</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success btn-block">Kirim</button>
        </div>
    </form>


<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        // forced_root_block: false
    });
</script>
@endsection