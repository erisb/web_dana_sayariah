@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Wiraniaga</h1>
                    </div>
                </div>
            </div>
</div>

<div class="content mt-3">
    <div class="row">
        <div class="col-md-12">
        @if(session()->has('deletedone'))
            <div class="alert alert-danger">
                {{ session()->get('deletedone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('createdone'))
            <div class="alert alert-success">
                {{ session()->get('createdone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('changepassdone'))
            <div class="alert alert-info">
                {{ session()->get('changepassdone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('exists'))
            <div class="alert alert-danger">
                {{ session()->get('exists') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('updatedone'))
            <div class="alert alert-success">
                {{ session()->get('updatedone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Wiraniaga</strong>
                </div>
                                <div class="card-body">
                                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Tambah Wiraniaga</button>

                                    <!-- modal create admin -->
                                    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="scrollmodalLabel">Tambah Wiraniaga</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('admin.marketer.create')}}" method="POST">
                                            @csrf
                                                <div class="modal-body">
                                                    <!-- body modal -->
                                                        <div class="col-lg-12">
                                                            <div class="row form-group">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="username" class=" form-control-label">username</label>
                                                                        <input type="text" name="username" placeholder="Marketer username" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="email" class=" form-control-label">email</label>
                                                                        <input type="email" name="email" placeholder="Marketer email" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                                <div class="form-group">
                                                                    <label for="password" class=" form-control-label">Password</label>
                                                                    <input type="password" name="password" placeholder="Marketer password" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email" class=" form-control-label">Kode Referal auto generate</label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nama" class=" form-control-label">Nama Lengkap</label>
                                                                    <input type="text" name="nama_lengkap" placeholder="Nama lengkap Marketer" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="alamat" class=" form-control-label">Alamat</label>
                                                                    <input type="text" name="alamat" placeholder="Alamat Marketer" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="phone" class=" form-control-label">Telephone</label>
                                                                    <input type="number" name="phone" placeholder="Alamat Marketer" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="no_rek" class=" form-control-label">Nomor Rekening</label>
                                                                    <input type="number" name="no_rek" placeholder="Nomor rekening Marketer" class="form-control" required>
                                                                </div>
                                                                <div class="form-group>
                                                                    <label for="bank" class="font-weight-bold">Bank</label>
                                                                    <select name="bank" class="form-control">
                                                                        <option value="">--Pilih--</option>
                                                                        @foreach($master_bank as $b)
                                                                            <option value="{{ $b->kode_bank }}">{{ $b->nama_bank }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                        </div>
                                                        <!-- end of body modal -->
                                                </div><br><br><br>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Hasilkan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- end of modal create admin -->
                                    <hr>

                            <!-- table select all admin -->
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Id Marketer</th>
                                    <th>Akun</th>
                                    <th>Email</th>
                                    <th>Kode <i>Referal</i></th>
                                    <th>Detil</th>
                                    <th>Option</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($marketers as $marketer)
                                <tr>
                                   {{--  @php
                                        if ($marketer->dataBank)
                                        echo $marketer->dataBank->nama_bank;
                                        else
                                        echo 'kosong';
                                    @endphp --}}
                                    <td>{{$marketer->id}}</td>
                                    <td>{{$marketer->username}}</td>
                                    <td>{{$marketer->email}}</td>
                                    <td>{{$marketer->ref_code}}</td>
                                    <td><button class="btn btn-info" data-toggle="modal" data-target="#{{$marketer->id}}detil">Detil</button></td>
                                    <td>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#{{$marketer->id}}">Hapus</button>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#{{$marketer->id}}password">Ubah password</button>
                                    </td>
                                </tr>

                                <!-- modal detil marketer -->
                                <div class="modal fade" id="{{$marketer->id}}detil" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="mediumModalLabel">Detil {{$marketer->email}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('admin.marketer.update')}}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                        <div class="col-lg-12">
                                                            <div class="row form-group">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="username" class=" form-control-label">Username</label>
                                                                        <input type="text" name="username" value="{{$marketer->username}}" disabled class="form-control" required>
                                                                        <input type="hidden" value="{{$marketer->id}}" name="id">
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label for="email" class=" form-control-label">email</label>
                                                                        <input type="email" name="email" value="{{$marketer->email}}" disabled class="form-control" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                <div class="form-group">
                                                                    <label for="nama" class=" form-control-label">Nama Lengkap</label>
                                                                    <input type="text" name="nama_lengkap" value="{{$marketer->detilMarketer->nama_lengkap}}" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="alamat" class=" form-control-label">Alamat</label>
                                                                    <input type="text" name="alamat" value="{{$marketer->detilMarketer->alamat}}" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="phone" class=" form-control-label">Telephone</label>
                                                                    <input type="number" name="phone" value="{{$marketer->detilMarketer->phone}}" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="no_rek" class=" form-control-label">Nomor Rekening</label>
                                                                    <input type="number" name="no_rek" value="{{$marketer->detilMarketer->no_rek}}" class="form-control" required>
                                                                </div>
                                                                <div class="form-group>
                                                                    <label for="bank" class="font-weight-bold">Bank</label>
                                                                    <select name="bank" class="form-control">
                                                                        <option value="">--Pilih--</option>
                                                                        @foreach($master_bank as $b)
                                                                            <option value="{{ $b->kode_bank }}" {{isset($marketer->detilMarketer->bank) && ($marketer->detilMarketer->bank == $b->kode_bank) ? 'selected="selected"' : ''}}isset()>{{ $b->nama_bank }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                        </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">Perbaharui</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of modal detil marketer -->

                                <!-- modal delete marketer  -->
                                <div class="modal fade" id="{{$marketer->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="mediumModalLabel">PERHATIAN !</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>Apakah anda benar ingin menghapus Wiraniaga <span class="bg-flat-color-2 text-light">{{$marketer->email}}</span> ?</h6>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{route('admin.marketer.delete')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$marketer->id}}">
                                                    <button type="submit" class="btn btn-danger">Konfirmasi</button>
                                                </form>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of modal marketer admin -->

                                <!-- modal for change password -->
                                <div class="modal fade" id="{{$marketer->id}}password" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="smallmodalLabel">Ubah password {{$marketer->email}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('admin.marketer.changepass')}}" method="POST">
                                            @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                                    <label for="password" class=" form-control-label">Password Baru</label>
                                                                    <input type="password" name="password" placeholder="new Admin password" class="form-control" required>
                                                                </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    
                                                        <input type="hidden" name="admin_email" value="{{$marketer->id}}">
                                                        <button type="submit" class="btn btn-warning">Ubah password</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of change password modal -->

                                @endforeach
                                </tbody>
                            </table>

                            <!-- end of table select all -->
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
@endsection