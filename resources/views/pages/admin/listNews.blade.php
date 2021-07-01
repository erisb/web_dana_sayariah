@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Daftar Berita</h1>
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
                                    <th>Penulis</th>
                                    <th>Detil Berita</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($news as $item)
                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->writer}}</td>
                                    <td><button class="btn btn-info btn-block" data-toggle="modal" data-target="#{{$item->id}}">Detil</button></td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit{{$item->id}}">Sunting</button>

                                        <form action="{{Route('admin.deleteNews')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$item->id}}">
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        
                                    </td>
                                </tr>
                                
                                <div class="modal fade" id="{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Detail Berita : {{$item->title}}</h5>
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
                                                            <div class="form-group">
                                                                <label for="nama" class=" form-control-label">Image</label><br>
                                                                <img src="/storage/{{$item->image}}">
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Edit Berita : {{$item->title}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="card-body card-block">
                                                        <form action="{{route('admin.updateNews')}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="nama" class=" form-control-label">Judul</label>
                                                                <input type="text" name="judul" class="form-control" value="{{$item->title}}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama" class=" form-control-label">Penulis</label>
                                                                <input type="text" name="writer" class="form-control" value="{{$item->writer}}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="deskripsi" class=" form-control-label">Isi Berita</label>
                                                                <textarea name="deskripsi">
                                                                    {!!$item->deskripsi!!}
                                                                </textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <div class="col-lg-6">
                                                                        <img src="{{asset('/storage')}}/{{!empty($item->image)?$item->image:''}}" class="img-thumbnail" alt="">
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label for="nama" class=" form-control-label">Gambar Berita</label>
                                                                        <input type="file" name="image" class="form-control" src="{{asset('/storage')}}/{{!empty($item->image)?$item->image:''}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="text" hidden name="id" value="{{$item->id}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Kirim</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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


    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height : "350"
            // forced_root_block: false
        });
    </script>
@endsection