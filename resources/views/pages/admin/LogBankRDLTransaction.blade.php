@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Log Transaksi Bank RDL</h1>
                    </div>
                </div>
            </div>
</div>
<div class="content mt-3">
<div class="row">
<div class="col-md-12">
 
    
    <div class="card" id="view_card_table">
        <div class="card-header">
            <strong class="card-title">Data Log Transaksi Bank RDL</strong>
        </div>
        <div class="card-body">
         
        <table id="table_audit" class="table table-striped table-bordered table-responsive-sm">
            <thead>
            <tr>
                <th style="display: none;">Id</th>
                <th>No</th>
                <th>Kode Bank RDL</th>
                <th>Kategori</th>
                <th>Request</th>
                <th>Response</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>No.Ref Bank</th>
                <th>Timestamp</th>
                
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
                processing: false,
                serverSide: false,
                // serverSide: true,
                ajax: {
                    url: '/admin/list_RDLBank_transaction/',
                    dataSrc: 'data'
                },
                "columns" : [
					{ "data" : "id" },
					{ "data" : "bank_rdl_code" },
					{ "data" : "category" },
					{ "data" : "request_content" },
					{ "data" : "request_response" },
					{ "data" : "nominal_transaction" },
                    { "data" : "status" },
                    { "data" : "bank_reference" },
					{ "data" : "created_at" },
				],
				"columnDefs": [{
					"targets": 0,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						
						return value['id'];
					}
				},{
					"targets": 1,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['bank_rdl_code'];
					}
				},{
					"targets": 2,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['category'];
					}
				},{
					"targets": 3,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['request_content'];
					}
				},{
					"targets": 4,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['request_response'];
					}
				},{
					"targets": 5,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['nominal_transaction'];
					}
				},{
					"targets": 6,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['status'];
					}
				},{
					"targets": 7,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['bank_reference'];
					}
				},{
					"targets": 8,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['created_at'];
					}
				},
				]
            });
        });
    </script>
@endsection