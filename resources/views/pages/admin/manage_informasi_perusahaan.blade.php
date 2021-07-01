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
                    <strong class="card-title">Data Informasi Perusahaan</strong>
                </div>
                <div class="card-body">
                    <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Informasi Perusahaan</button>
                    <table id="table_company" class="table table-striped table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th style="display: none;">Id</th>
                                <th>No</th>
                                <th>Nama Perusahaan</th>
                                <th>Deskripsi</th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>WhatsApp</th>
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

    <!-- start modal tambah perusahaan -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Tambah Perusahaan : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.addCompany')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <div class="form-row" id="tambahwhatsapp">
                                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Nama Perusahaan</label>
                                    <input type="text" class="col-sm-12 form-control" name="nama_perusahaan" placeholder="Nama Perusahaan" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                    <textarea class="col-sm-12 form-control" name="deskripsi" placeholder="Deskripsi" required="required" cols="30" rows="5"></textarea><br/>

                                    <label for="foto_diri" class="font-weight-bold">Alamat</label>
                                    <textarea type="text" class="col-sm-12 form-control" name="alamat" placeholder="Alamat" required="required" cols="30" rows="3"></textarea><br/>

                                    <label for="foto_diri" class="font-weight-bold">Email</label>
                                    <input type="text" class="col-sm-12 form-control" name="email" placeholder="Email" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Phone</label>
                                    <input type="text" class="col-sm-12 form-control" name="phone" placeholder="Phone" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">WhatsApp</label>
                                    <input type="text" class="col-sm-12 form-control" name="whatsapp[]" placeholder="whatsapp" required="required"><br/>
                                </div>
                            </div>   
                        </div>
                        <div class="col-12">
					        <button type="button" class="btn btn-rounded btn-primary btn-dsi min-width-200 mb-10 push-right" onclick="add_whatsapp()">Tambah WhatsApp</button>
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
    <!-- end of modal tambah perusahaan -->

    <!-- start modal ganti perusahaan -->
    <div class="modal fade" id="ganti" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Ganti Informasi Perusahaan : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.updateCompany')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card-body card-block">
                            <input type="hidden" name="id" id="id">
                            <div class="form-row">
                                <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                    <label for="foto_diri" class="font-weight-bold">Nama Perusahaan</label>
                                    <input type="text" class="col-sm-12 form-control" id="edit_nama_perusahaan" name="edit_nama_perusahaan" placeholder="Nama Perusahaan" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Deskripsi</label>
                                    <textarea class="col-sm-12 form-control" id="edit_deskripsi" name="edit_deskripsi" placeholder="Deskripsi" required="required" cols="30" rows="5"></textarea><br/>

                                    <label for="foto_diri" class="font-weight-bold">Alamat</label>
                                    <textarea type="text" class="col-sm-12 form-control" id="edit_alamat" name="edit_alamat" placeholder="Alamat" required="required" cols="30" rows="3"></textarea><br/>

                                    <label for="foto_diri" class="font-weight-bold">Email</label>
                                    <input type="text" class="col-sm-12 form-control" id="edit_email" name="edit_email" placeholder="Email" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">Phone</label>
                                    <input type="text" class="col-sm-12 form-control" id="edit_phone" name="edit_phone" placeholder="Phone" required="required"><br/>

                                    <label for="foto_diri" class="font-weight-bold">WhatsApp</label>
                                    <input type="text" class="col-sm-12 form-control" id="edit_handphone" name="edit_handphone" placeholder="whatsapp" required="required">
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
    <!-- end of modal ganti perusahaan -->
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
<script>
    function add_whatsapp() 
    {
                
        var tambahwhatsapp = 
        '<div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">'
            +'<label for="foto_diri" class="font-weight-bold">WhatsApp</label>'
            +'<input type="text" class="col-sm-12 form-control" name="whatsapp[]" placeholder="whatsapp" required="required"><br>'
            +'<button type="button" class="btn btn-rounded btn-danger mb-10 push-right" id="delete_whatsapp"> <i class="fa fa-times"></i>  Hapus Upload File Ini</button><hr>'
        +'</div>';
        
        $('#tambahwhatsapp').append(tambahwhatsapp);
        
    }

    $(document).on("click", "#delete_whatsapp", function() { 
        $(this).parent().remove();
    });
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var companyTable = $('#table_company').DataTable({
            searching: true,
            processing: true,
            //serverSide: true,
            ajax: {
                url: '/admin/list_company/',
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
                { data : 'nama'},
                { data : 'content'},
                { data : 'alamat'},
                { data : 'email'},
                { data : 'phone'},
                { data : 'handphone'},
                { data : 'author'},
                { data: null,
                    render:function(data,type,row,meta){

                        return '<button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_company" title><i class="fa fa-edit"></i></button><br><br><button class="btn btn-danger btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_company" title="Hapus"><i class="fa fa-trash"></i></button>';
                    }
                }
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });
                    
        $('#table_company tbody').on( 'click', '#ganti_company', function () {
            var data = companyTable.row( $(this).parents('tr') ).data();
            id = data.id;
            nama = data.nama;
            content = data.content;
            alamat = data.alamat;
            email = data.email;
            phone = data.phone;
            handphone = data.handphone;

            $('#id').val(id);
            $('#edit_nama_perusahaan').val(nama);
            $('#edit_deskripsi').val(content);
            $('#edit_alamat').val(alamat);
            $('#edit_email').val(email);
            $('#edit_phone').val(phone);
            $('#edit_handphone').val(handphone);
        });

        $('#table_company tbody').on('click','#hapus_company',function(){
            var data = companyTable.row( $(this).parents('tr') ).data();
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
                                url:'deleteCompany/'+id,
                                method:'delete',
                                dataType:'json',
                                success:function(data)
                                {
                                    if (data.status == 'Sukses')
                                    {
                                        swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                          function(){ 
                                               companyTable.ajax.reload();
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