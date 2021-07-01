@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div id="overlay">
<div class="cv-spinner">
    <span class="spinner"></span>
</div>
</div>
	<div class="breadcrumbs">
		<div class="col-sm-4">
			<div class="page-header float-left">
				<div class="page-title">
					<h1>Transfer Dana</h1>
				</div>
			</div>
		</div>
	</div>

	@if (session('success'))
          <div class="alert alert-success col-sm-12">
              {{ session('success') }}
          </div>
      @endif
	
	<div class="content mt-3">
		<!-- table select all admin -->
		<table id="tbl_list" class="table table-striped table-bordered table-responsive-sm">
			<thead>
				<tr>
					<th>ID Proyek</th>
					<th>Nama Proyek</th>
					<th>Total Dibutuhkan</th>
					<th>Tanggal Mulai Penggalangan</th>
					<th>Tanggal Selesai Penggalangan</th>
					<th>Status Proyek</th>
					<th>Detil Tarik Dana</th>
				</tr>
			</thead>
		</table>
	</div><!-- .content -->

	<div class="modal fade" id="modal_detail_tarik" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title" id="txt_proyek_nama"></h5>
				</div>
				<div class="modal-body">
					<table id="tbl_detail_tarik" class="table table-striped table-bordered table-responsive-sm">
						<thead>
							<tr>
								<th>Proyek ID</th>
								<th>Pendana ID</th>
								<th>Nama Pendana</th>
								<th>Email Pendana</th>
								<th>Total Pendanaan</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="modal-footer">
					<a id="tarik_dana_investor" class="btn btn-primary">Transfer Dana Pendana</a>
					<button type="button" id="btn_close_form" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<!--<button type="button" id="btn_close_form" class="btn btn-secondary" data-dismiss="modal">Cancel</button>-->
				</div>
			</div>
		</div>
	</div>
	<style>
	  .dataTables_paginate { 
	     float: right; 
	     text-align: right; 
	  }
	  #allDetilImbal:hover{
	    background-color: forestgreen !important;
	  }
	  #overlay{   
	      position: fixed;
	      top: 0;
	      left: 0;
	      z-index: 900;
	      width: 100%;
	      height:100%;
	      display: none;
	      background: rgba(0,0,0,0.6);
	  }
	  .cv-spinner {
	      height: 100%;
	      display: flex;
	      justify-content: center;
	      align-items: center;  
	  }
	  .spinner {
	      width: 40px;
	      height: 40px;
	      border: 4px #ddd solid;
	      border-top: 4px #2e93e6 solid;
	      border-radius: 50%;
	      animation: sp-anime 0.8s infinite linear;
	  }
	  @keyframes sp-anime {
	      100% { 
	          transform: rotate(360deg); 
	      }
	  }
	  .is-hide{
	      display:none;
	  }
	</style>
	<link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />
	<script src="/js/jquery-3.3.1.min.js"></script>
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

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
		
        tinymce.init({
            selector: 'textarea'
        });
		
		var table;
		var table_detail_tarik;
		$(document).ready(function(){
			var table_detail_tarik = $("#tbl_detail_tarik").DataTable({
				
				"columns" : [
					{ "data" : "Proyek_id" },
					{ "data" : "Investor_id" },
					{ "data" : "Nama Investor Pendana" },
					{ "data" : "Email Pendana" },
					{ "data" : "Total Pendanaan" }
				],
				"columnDefs": [
					{
						"targets": 0,
						class : 'text-center',
						'visible': false
					},
					{
						"targets": 1,
						class : 'text-center',
						'visible': false
					},
					{
						"targets": 2,
						class : 'text-center',
					},
					{
						"targets": 3,
						class : 'text-center',
					},
					{
						"targets": 4,
						class : 'text-center',
					}
				]
			});
			
			table = $('#tbl_list').DataTable({
				processing: false,
				serverSide: false,
				ajax : {
					type : "get",
					url : '/admin/list_transfer_dana_investor/'
					
				},
				"columns" : [
					{ "data" : "ID Proyek" },
					{ "data" : "Nama Proyek" },
					{ "data" : "Total Dibutuhkan" },
					{ "data" : "Tanggal Mulai Penggalangan" },
					{ "data" : "Tanggal Selesai Penggalangan" },
					{ "data" : "Status Proyek" },
					{ "data" : "Detil Tarik Dana" },
				],
				"columnDefs": [{
					"targets": 0,
					class : 'text-center',
				},{
					"targets": 1,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						
						return value['Nama Proyek'];
					}
				},{
					"targets": 2,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['Total Dibutuhkan'];
					}
				},{
					"targets": 3,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['Tanggal Mulai Penggalangan'];
					}
				},{
					"targets": 4,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['Tanggal Selesai Penggalangan'];
					}
				},{
					"targets": 5,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['Status Proyek'];
					}
				},{
					"targets": 6,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return '<button class="btn btn-info" data-toggle="modal" data-target="#modal_detail_tarik" onclick="detail_tarik('+value["Detil Tarik Dana"]+')">List Transfer Dana</button>';
						//return row[6];
					}
				},
				]
			});
			
			$("#btn_close_form").on("click", function(){

				$('#tbl_detail_tarik').dataTable().fnClearTable(); // reset data datatable
				
			})
			
		});
		
		function detail_tarik(id){
			console.log(id);
			$('#modal_detail_tarik').on('show.bs.modal', function(e) {
				//var hrefURI = "{{route('admin.proyek.mutasi_investor_proyek',['id' => "'\+id+\'"])}}";
				$("#tarik_dana_investor").attr('href', '/admin/transfer_dana/'+id+'');
				var table_detail_tarik = $("#tbl_detail_tarik").DataTable();
				table_detail_tarik.ajax.url( "/admin/list_detail_investor/"+id+"" ).load();
				
			});
		}
    </script>

@endsection