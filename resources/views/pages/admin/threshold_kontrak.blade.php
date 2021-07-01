@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Threshold Kontrak</h1>
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
            <strong class="card-title">Data Threshold Kontrak</strong>
        </div>
        <div class="card-body">
        <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Threshold</button>
        <table id="table_threshold" class="table table-striped table-bordered table-responsive-sm">
            <thead>
            <tr>
                <th style="display: none;">Id</th>
                <th>No</th>
                <th>Threshold Kontrak</th>
                <th>Tipe</th>
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

<!-- start modal tambah gambar -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Tambah Threshold : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.addThreshold')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <div class="form-row">
                            <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                <label for="foto_diri" class="font-weight-bold">Threshold Kontrak</label>
                                <input type="text" class="col-sm-6 form-control" name="threshold" placeholder="Threshold Kontrak" required="required">
                                <label for="foto_diri" class="font-weight-bold">Tipe</label>
                                <select name="tipe" class="col-sm-6 form-control" id="tipe" required="required">
                                    <option value="">--Pilih--</option>
                                    <option value='1'>Pendana</option>
                                    <option value='2'>Penerima</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Tambah Threshold</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal tambah gambar -->

<!-- start modal ganti gambar -->
<div class="modal fade" id="ganti" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Ganti Threshold : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.updateThreshold')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <input type="hidden" name="id_threshold" id="id_threshold">
                        <div class="form-row">
                            <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                <label for="foto_diri" class="font-weight-bold">Threshold Kontrak</label>
                                <input type="text" class="col-sm-6 form-control" name="edit_threshold" id="edit_threshold" placeholder="Threshold Kontrak" required="required">
                                <label for="foto_diri" class="font-weight-bold">Tipe</label>
                                <select class="col-sm-6 form-control" name="edit_tipe" id="edit_tipe" required="required">
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Perbaharui Threshold</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal ganti gambar -->

</div><!-- .content -->
    
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
            var thresholdTable = $('#table_threshold').DataTable({
                searching: true,
                processing: true,
                // serverSide: true,
                ajax: {
                    url: '/admin/list_threshold/',
                    dataSrc: 'data'
                },
                paging: true,
                info: true,
                lengthChange:false,
                order: [ 1, 'asc' ],
                pageLength: 5,
                columns: [
                    { data: 'id_threshold'},
                    { data : null,
                      render: function (data, type, row, meta) {
                              //I want to get row index here somehow
                              return  meta.row+1;
                        }
                    },
                    { data : 'threshold_kontrak'},
                    { data : null,
                      render: function (data, type, row, meta) {
                                if (row.tipe == 1)
                                {
                                    return 'Pendana';
                                }
                                else
                                {
                                    return 'Penerima Pendanaan';
                                }
                                
                        }
                    },
                    { data: null,
                        render:function(data,type,row,meta){
                            
                            return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_threshold">Ganti Threshold</button><br><br><button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_threshold">Hapus Threshold</button>';
                        }
                    }
                ],
                columnDefs: [
                    { targets: [0], visible: false}
                ]
            });
                        
            $('#table_threshold tbody').on( 'click', '#ganti_threshold', function () {
                var data = thresholdTable.row( $(this).parents('tr') ).data();
                id = data.id_threshold;
                threshold = data.threshold_kontrak;
                tipe = data.tipe;

                var select_tipe = document.getElementById('edit_tipe'),
                    option = '<option value="">--Pilih--</option>';

                for(i=1;i<=2;i++)
                {
                    option += '<option value="'+i+'" '+(i == tipe ? "selected" : "")+'>'+(i == 1 ? 'Pendana' : 'Penerima Pendanaan')+'</option>';
                }

                $('#id_threshold').val(id);
                $('#edit_threshold').val(threshold);
                select_tipe.innerHTML = option;
            });

            $('#table_threshold tbody').on('click','#hapus_threshold',function(){
                var data = thresholdTable.row( $(this).parents('tr') ).data();
                id = data.id_threshold;
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
                                    url:'deleteThreshold/'+id,
                                    method:'delete',
                                    dataType:'json',
                                    success:function(data)
                                    {
                                        if (data.status == 'Sukses')
                                        {
                                            swal({title:"Berhasil",text:"Data berhasil di hapus",type:"success"},
                                              function(){ 
                                                   thresholdTable.ajax.reload();
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