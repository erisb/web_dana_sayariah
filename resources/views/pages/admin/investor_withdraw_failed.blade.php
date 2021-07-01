@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Penarikan Dana Pendana Gagal</h1>
                    </div>
                </div>
            </div>
</div>

            <div class="content mt-3">
                            <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Data Table</strong>
                                    </div>
                                    <div class="card-body">
                            <table id="table_fail" class="table table-striped table-bordered table-responsive-sm">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Akun</th>
                                    <th>Email</th>
                                    <th>Jumlah</th>
                                    <th>Nomor Rekening</th>
                                    <th>Bank</th>
                                    <th>Tanggal</th>
                                    <th>Perihal</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- @foreach($requestwithdraw as $req)
                                <tr>
                                    <td>{{$req->investor->username}}</td>
                                    <td>{{$req->investor->email}}</td>
                                    <td>Rp. {{number_format($req->jumlah, 0, '', '.')}}</td>
                                    <td>{{$req->no_rekening}}</td>
                                    <td>{{$req->bank}}</td>
                                    <td>{{$req->perihal}}</td>
                                    <td><button class="btn btn-danger btn-outline-block" disabled>Gagal</button></td>
                                </tr>
                                
                                @endforeach --}}
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
          // $('#bootstrap-data-table-export').DataTable();

            var failTable = $('#table_fail').DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/admin/investor/data_fail',
                    dataSrc: 'data_fail',
                    dataType: 'json',
                    type: 'POST',
                    data:{ _token: '{{csrf_token()}}'}
                },
                paging: true,
                // info: true,
                // lengthChange:false,
                order: [ 2, 'asc' ],
                pageLength: 10,
                columns: [
                    { data : null,
                      render: function (data, type, row, meta) {
                              //I want to get row index here somehow
                              return  meta.row+1;
                        }
                    },
                    { data: 'username'},
                    { data: 'email'},
                    { data: 'jumlah'},
                    { data: 'no_rekening'},
                    { data: 'bank'},
                    { data: 'updated_at'},
                    { data: 'perihal'},
                    { data: null,
                        render:function(data,type,row,meta)
                        {
                            return '<button class="btn btn-danger btn-outline-block" disabled>Gagal</button>';
                        }
                    }
                ]
            });
        });
    </script>

@endsection