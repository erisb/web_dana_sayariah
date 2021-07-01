@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Data <i>E-Collection</i> BNI</h1>
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
@endif    
<!-- FORM UNTUK MENG-UPLOAD FILE -->
<div class="col-md-4">
    <div class="card" id="view_card_table">
        <div class="card-header">
            <strong class="card-title">Import Data</strong>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/import') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <input type="file" accept=".csv" name="file" class="form-control {{ $errors->has('file') ? 'is-invalid':'' }}" required>
                    <p class="text-danger">{{ $errors->first('file') }}</p>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger btn-sm">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- TABLE UNTUK MELIHAT DATA YANG SUDAH DISIMPAN -->
<div class="col-md-8">
    <div class="card" id="view_card_table">
        <div class="card-header">
            <strong class="card-title"><i>E-Collection</i> BNI</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-responsive-sm" id="table_ecoll">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>VA</th>
                            <th>Tgl Pembayaran</th>
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
            var gambarTable = $('#table_ecoll').DataTable({
                searching: true,
                processing: true,
                // serverSide: true,
                ajax: {
                    url: '/admin/data_ecoll_datatables/',
                    dataSrc: 'data'
                },
                paging: true,
                info: true,
                lengthChange:false,
                // order: [ 1, 'asc' ],
                pageLength: 10,
                columns: [
                    { data : null,
                      render: function (data, type, row, meta) {
                              //I want to get row index here somehow
                              return  meta.row+1;
                        }
                    },
                    { data : 'nama'},
                    { data : 'no_va'},
                    { data : 'tgl_payment'},
                ],
            });
        });
    </script>
@endsection