@extends('layouts.admin.master')

@section('title', 'Create List Email')

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Create List</h1>
                </div>
            </div>
        </div>
    </div>

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
            <div class="card-header"><small> Form  </small><strong>Create Group List</strong></div>
            <div class="card-body card-block">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Subscribe</a>
                  </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                      <form action="/admin/messagging/listNew" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="nama" class=" form-control-label">Nama Group List</label>
                            <input type="text" name="list_kirim" class="form-control" id="name_group" placeholder="Nama Group List" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Submit Group List</button>
                        </div>
                      </form>
                  </div>
                  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <form action="/admin/messagging/createList" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="nama" class=" form-control-label">List Group Email</label>
                            {{-- <input type="text" name="list_kirim" class="form-control" required> --}}
                            <select class="form-control" name="id_list" id="select_id" required>
                                <option value="">Pilih Group List</option>
                                @foreach ($data as $item)
                                  {{!! $item !!}}                              
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama" class=" form-control-label">Nominal Data</label>
                            {{-- <input type="text" name="list_kirim" class="form-control" required> --}}
                            <select class="form-control" name="nominal_id" id="select_nominal" required>
                                <option value="">Pilih Group List</option>
                                <option value="1">Aktif User</option>
                                <option value="2">Tidak Aktif</option>
                                <option value="3">Test </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">Submit Group List</button>
                        </div>
                      </form>
                  </div>
                </div>
            </div>
        </div>
    </div>

{{--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script> --}}


<script>
    // tinymce.init({
    //     selector: 'textarea',
    //     // forced_root_block: false
    // });

$(document).ready(function(){
  $('#pills-home-tab').on('click', function(){
    $('#name_group').val('')
    $('#select_id').val('')
    $('#select_nominal').val('')
  });
  $('#pills-profile-tab').on('click', function(){
    $('#name_group').val('')
    $('#select_id').val('')
    $('#select_nominal').val('')
  });
});
</script>
@endsection