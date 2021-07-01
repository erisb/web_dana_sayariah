@extends('layouts.admin.master')

@section('title', 'Broadcast Email')
<link rel="stylesheet" href="/ckeditor/css/samples.css">
<link rel="stylesheet" href="/ckeditor/lib/codemirror/neo.css">

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Broadcast Email</h1>
                </div>
            </div>
        </div>
    </div>

    <form action="{{route('sendBroadcast')}}" method="POST" >
        @csrf
        <div class="col-lg-12">
            <div class="card">
                @if(session()->has('broadcastdone'))
                <div class="alert alert-success">
                    {{ session()->get('broadcastdone') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card-header"><small> Form  </small><strong>Broadcast</strong></div>
                <div class="card-body card-block">
                  <div class="form-group">
                      <label for="nama" class=" form-control-label">Judul</label>
                      {{-- <input type="text" name="list_kirim" class="form-control" required> --}}
                      <select class="form-control" name="list_email" id="" required>
                          <option value="0">Pilih List Kirim</option>
                          @foreach ($data as $item)
                            {{!! $item !!}}                              
                          @endforeach
                      </select>
                  </div>
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Judul</label>
                        <input type="text" name="judul_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class=" form-control-label">Isi Email</label>
                        <textarea id="editor" name="deskripsi"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success btn-block">Broadcast Email</button>
        </div>
    </form>


{{-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> --}}

<script src="/ckeditor/js/ckeditor.js"></script>
{{-- <script src="/ckeditor/js/sample.js"></script> --}}
<script>
  CKEDITOR.replace('editor',{
    removePlugins: 'image2',
  })
  // CKEDITOR.editorConfig = function( config ) {
  //   config.toolbarGroups = [
  //     { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
  //     { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
  //     { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
  //     { name: 'forms', groups: [ 'forms' ] },
  //     '/',
  //     { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
  //     { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
  //     { name: 'links', groups: [ 'links' ] },
  //     { name: 'insert', groups: [ 'insert' ] },
  //     '/',
  //     { name: 'styles', groups: [ 'styles' ] },
  //     { name: 'colors', groups: [ 'colors' ] },
  //     { name: 'tools', groups: [ 'tools' ] },
  //     { name: 'others', groups: [ 'others' ] },
  //     { name: 'about', groups: [ 'about' ] }
  //   ];
  // };
</script>
@endsection