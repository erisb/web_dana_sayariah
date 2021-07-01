@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Audit Trail</h1>
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
            <strong class="card-title">Data Audit Trail</strong>
        </div>
        <div class="card-body">
        <!-- <button class="btn btn-success" data-toggle="modal" data-target="#tambah" style="margin-left: 15px;">Tambah Threshold</button> -->
        <table id="table_audit" class="table table-striped table-bordered table-responsive-sm">
            <thead>
            <tr>
                <th style="display: none;">Id</th>
                <th>No</th>
                <th>Nama</th>
                <th>Menu</th>
                <th>Deskripsi</th>
                <th>Pembaharuan Terakhir</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

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
            var thresholdTable = $('#table_audit').DataTable({
                searching: true,
                processing: true,
                // serverSide: true,
                ajax: {
                    url: '/admin/list_audit_trail/',
                    dataSrc: 'data'
                },
                paging: true,
                info: true,
                lengthChange:false,
                order: [ 1, 'asc' ],
                pageLength: 5,
                columns: [
                    { data: 'id_log_audit_trail'},
                    { data : null,
                      render: function (data, type, row, meta) {
                              //I want to get row index here somehow
                              return  meta.row+1;
                        }
                    },
                    { data : 'fullname'},
                    { data : 'menu'},
                    { data : 'description'},
                    { data : 'updated_at'},
                    /*{ data: null,
                        render:function(data,type,row,meta){
                            
                            return '<button class="btn btn-info btn-sm active" data-toggle="modal" data-target="#ganti" id="ganti_threshold">Ganti Threshold</button><br><br><button class="btn btn-warning btn-sm active" data-toggle="modal" data-target="#change_password" id="hapus_threshold">Hapus Threshold</button>';
                        }
                    }*/
                ],
                columnDefs: [
                    { targets: [0], visible: false}
                ]
            });
        });
    </script>
@endsection