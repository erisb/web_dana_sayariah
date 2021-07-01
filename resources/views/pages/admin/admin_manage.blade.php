@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Users</h1>
                    </div>
                </div>
            </div>
</div>

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
@elseif(session()->has('editdone'))
    <div class="alert alert-success">
        {{ session()->get('editdone') }}
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
<div class="content mt-3">
    <div class="row">
    <div class="col-md-12">
    @if($cekUser->name == 'Administrator') 
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-role-tab" data-toggle="pill" href="#role_user" role="tab" aria-controls="role_user" aria-selected="true">Kelola Peran</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#users" role="tab" aria-controls="users" aria-selected="false">Kelola Pengguna</a>
          </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">
            <!--Manage Users-->
            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="pills-users-tab">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Pengguna</strong>
                </div>
                <div class="card-body">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createModal">Tambah Pengguna</button>
                        <!-- modal create admin -->
                        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="scrollmodalLabel">Tambah Admin</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('admin.create')}}" method="POST">
                                    @csrf
                                        <div class="modal-body">
                                            <!-- body modal -->
                                                <div class="col-lg-12">
                                                    <div class="row form-group">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="firstname" class=" form-control-label">Name Depan</label>
                                                                <input type="text" name="firstname" placeholder="Admin first name" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="lastname" class=" form-control-label">Name Belakang</label>
                                                                <input type="text" name="lastname" placeholder="Admin last name" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                        <div class="form-group">
                                                            <label for="email" class=" form-control-label">Email</label>
                                                            <input type="email" name="email" placeholder="Admin email" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="address" class=" form-control-label">Alamat</label>
                                                            <input type="text" name="address" placeholder="Admin address" class="form-control" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="password" class=" form-control-label">Password</label>
                                                            <input type="password" name="password" placeholder="Admin password" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="role" class="font-weight-bold">Peran</label>
                                                            <select name="role" class="form-control" id="role">
                                                                <option value="">--Pilih--</option>
                                                                @foreach ($role as $data)
                                                                    <option value={{$data->id}}>{{$data->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                                <!-- end of body modal -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">HAsilkan</button>                                                
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- end of modal create admin -->
                            <hr>

                    <!-- table select all admin -->
                    <table id="table_users" class="table table-striped table-bordered table-responsive-sm">
                        <thead>
                        <tr>
                            <th hidden="hidden">Id</th>
                            <th hidden="hidden">Id Role</th>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                <!-- end of table select all -->
                </div>
            </div>
            </div>

            <!--Manage Role-->
            <div class="tab-pane fade show active" id="role_user" role="tabpanel" aria-labelledby="pills-role-tab">
                <div class="col-md-4">
                    <div class="card" id="view_card_table">
                        <div class="card-header">
                            <strong class="card-title">Tambah Peran</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.add_role') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="role" class="font-weight-bold">Peran</label>
                                    <input type="text" name="role" class="form-control" required>
                                </div>
                                <h6>Daftar Menu</h6>
                                <hr>
                                @foreach($menuItem as $data_menu)
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="dataMenu[]" id="inlineCheckbox{{$data_menu->id}}" value="{{ $data_menu->id }}">
                                      <label class="form-check-label" for="inlineCheckbox1">{{ $data_menu->label }}</label>
                                    </div>
                                @endforeach
                                <div class="form-group mt-2">
                                    <button class="btn btn-danger btn-sm" id="save">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card" id="view_card_table">
                        <div class="card-header">
                            <strong class="card-title">Data Peran</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-responsive-sm" id="table_role">
                                    <thead>
                                        <tr>
                                            <th hidden="hidden">Id</th>
                                            <th hidden="hidden">Id Role</th>
                                            <th>No</th>
                                            <th>Peran</th>
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
            </div>
        </div>
    @else
        <div class="col-md">
            <div class="card" id="view_card_table">
                <div class="card-header">
                    <strong class="card-title">Ubah Password</strong>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.changepass')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="password" class=" form-control-label">Password Baru</label>
                            <input type="password" name="password" placeholder="New Admin password" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <input type="hidden" name="id_user" value="{{ $cekUser->id }}">
                            <button class="btn btn-danger btn-sm" id="save">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    </div>
    </div>
</div><!-- .content -->

<!-- modal edit user -->
<div class="modal fade" id="editUsers" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="scrollmodalLabel">Sunting Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.edit')}}" method="POST">
            @csrf
                <div class="modal-body">
                    <!-- body modal -->
                        <div class="col-lg-12">
                            <div class="row form-group">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="firstname" class=" form-control-label">Name Depan</label>
                                        <input type="text" name="firstname" placeholder="Admin first name" class="form-control" id="firstname" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="lastname" class=" form-control-label">Name Belakang</label>
                                        <input type="text" name="lastname" placeholder="Admin last name" class="form-control" id="lastname" required>
                                    </div>
                                </div>
                            </div>
                            
                                <div class="form-group">
                                    <label for="email" class=" form-control-label">Email</label>
                                    <input type="email" name="email" placeholder="Admin email" class="form-control" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="font-weight-bold">Peran</label>
                                    <select name="role" class="form-control" id="userRoleEdit">
                                    </select>
                                </div>
                        </div>
                        <input type="hidden" name="id_user" id="id_user">
                        <!-- end of body modal -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Sunting</button>                                                
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end of modal edit user -->

<!-- modal for change password -->
<div class="modal fade" id="password" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodalLabel">Ubah password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.changepass')}}" method="POST">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password" class=" form-control-label">Password Baru</label>
                        <input type="password" name="password" placeholder="New Admin password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    
                        <input type="hidden" name="id_user" id="id_user_pass">
                        <button type="submit" class="btn btn-warning">Ubah password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of change password modal -->

{{-- modal Edit Role --}}
<div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Sunting Peran/h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.edit_role')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="input_sebesar" class="col-sm-3 col-form-label">Peran</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" value="" name="role_edit" id="role_edit">
                    </div>
                </div>
                <h6>Daftar Menu</h6>
                <hr>
                @foreach($menuItem as $data_menu)
                    <div class="form-check edit">
                      <input class="form-check-input" type="checkbox" name="dataMenuEdit[]" id="inlineCheckboxEdit{{$data_menu->id}}" value="{{ $data_menu->id }}">
                      <label class="form-check-label" for="inlineCheckboxEdit1">{{ $data_menu->label }}</label>
                    </div>
                @endforeach
                <input type="hidden" name="role_id" id="role_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary">Sunting</button>
            </div>
                </form>
        </div>
    </div>
</div>
{{-- end modal Edit Role --}}

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
        var usersTable = $('#table_users').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/data_users_datatables/',
                dataSrc: 'data'
            },
            paging: true,
            info: true,
            lengthChange:false,
            // order: [ 1, 'asc' ],
            pageLength: 10,
            columns: [
                { data : 'id'},
                { data : 'role'},
                { data : null,
                  render: function (data, type, row, meta) {
                          //I want to get row index here somehow
                          return  meta.row+1;
                    }
                },
                { data : null,
                    render:function(data,type,row,meta){
                        return row.firstname+' '+row.lastname;
                    }
                },
                { data: 'email'},
                { data: 'name'},
                { data: null,
                    render:function(data,type,row,meta){
                        return '<button class="btn btn-info" data-toggle="modal" data-target="#editUsers" id="ubah_users">Edit Users</button><br><br>'
                              +'<button class="btn btn-warning" data-toggle="modal" data-target="#password" id="ganti_pass">Ubah password</button><br><br>'
                              +'<button class="btn btn-danger" id="hapus_users">Hapus</button>';
                    }
                },

            ],
            columnDefs: [
                { targets: [0,1], visible: false}
            ]
        });
        $('#table_users tbody').on( 'click', '#ubah_users', function () {
            var data = usersTable.row( $(this).parents('tr') ).data();
            id_user = data.id;
            id_role = data.role;
            firstname = data.firstname;
            lastname = data.lastname;
            email = data.email;
            $('#id_user').val(id_user);
            $('#firstname').val(firstname);
            $('#lastname').val(lastname);
            $('#email').val(email);
            $('#userRoleEdit').empty();
            $.ajax({
                url : "/admin/data_role_datatables/",
                method : "get",
                success:function(data)
                {
                    $.each(data.data,function(index,value){
                        if (value.id == id_role)
                        {
                            var select = 'selected=selected';
                        }
                        $('#userRoleEdit').append('<option value="'+value.id+'"'+ select+'>'+value.name+'</option>');
                    })
                    
                }
            });
        });
        $('#table_users tbody').on( 'click', '#ganti_pass', function () {
            var data = usersTable.row( $(this).parents('tr') ).data();
            id_user = data.id;
            $('#id_user_pass').val(id_user);
        });
        $('#table_users tbody').on('click','#hapus_users',function(){
            var data = usersTable.row( $(this).parents('tr') ).data();
            id_user = data.id;
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
                                url:'deleteUser/'+id_user,
                                method:'delete',
                                dataType:'json',
                                success:function(data)
                                {
                                    if (data.status == 'Sukses')
                                    {
                                        swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                          function(){ 
                                               usersTable.ajax.reload();
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



        var roleTable = $('#table_role').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/data_role_datatables/',
                dataSrc: 'data'
            },
            paging: true,
            info: true,
            lengthChange:false,
            // order: [ 1, 'asc' ],
            pageLength: 10,
            columns: [
                { data : 'id'},
                { data : null,
                  render: function (data, type, row, meta) {
                          //I want to get row index here somehow
                          return  meta.row+1;
                    }
                },
                { data : 'name'},
                { data: null,
                    render:function(data,type,row,meta){
                        return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#editRole" style="margin-right: 10px" id="btnEdit">Edit</button>'
                              +'<button class="btn btn-danger btn-sm active" id="btnDelete">Delete</button>';
                    }
                },
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });
        $('#table_role tbody').on( 'click', '#btnEdit', function () {
            var data = roleTable.row( $(this).parents('tr') ).data();
            id_role = data.id;
            role_edit = data.name
            $('#role_id').val(id_role);
            $('#role_edit').val(role_edit);
            $.ajax({
                url : "/admin/editMenu/"+id_role,
                method : "get",
                success:function(data)
                {
                    
                    console.log(data.dataElse.length)
                    if (data.dataElse.length != 0)
                    {
                        $.each(data.dataElse,function(index,value){
                            $('#inlineCheckboxEdit'+value.id).prop('checked',false);
                        })
                    }
                    $.each(data.data,function(index,value){
                        $('#inlineCheckboxEdit'+value.id_menu).prop('checked',true);
                    })
                    
                }
            });
        });
        $('#table_role tbody').on('click','#btnDelete',function(){
            var data = roleTable.row( $(this).parents('tr') ).data();
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
                                url:'deleteRole/'+id,
                                method:'delete',
                                dataType:'json',
                                success:function(data)
                                {
                                    if (data.status == 'Sukses')
                                    {
                                        swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                          function(){ 
                                               roleTable.ajax.reload();
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

@endsection