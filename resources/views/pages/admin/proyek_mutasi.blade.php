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
					<h1>Mutasi Proyek</h1>
				</div>
			</div>
		</div>
	</div>
	
	<div class="content mt-3">
		<!-- table select all admin -->
		<table id="tbl_mutasi" class="table table-striped table-bordered table-responsive-sm">
			<thead>
				<tr>
					<th>ID Proyek</th>
					<th>Nama Proyek</th>
					<th>Total Dibutuhkan</th>
					<th>Terkumpul</th>
					<th>Terkumpul dari Pendana</th>
					<th>Jumlah Pendana</th>
					<th>Detil Mutasi</th>
					<th>Presentasi Terkumpul</th>
				</tr>
			</thead>
		</table>
	</div><!-- .content -->

	<div class="modal fade" id="modal_detail_mutasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h5 class="modal-title" id="txt_proyek_nama"></h5>
				</div>
				<div class="modal-body">
					<table id="tbl_detail_mutasi" class="table table-striped table-bordered table-responsive-sm">
						<thead>
							<tr>
								<th>Proyek ID</th>
								<th>Pendana ID</th>
								<th>Nama Pendana</th>
								<th>Email Pendana</th>
								<th>Nominal Pendanaan</th>
								<th>Tanggal Pendanaan</th>
								<th>Akad</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="modal-footer">
					<a id="cetak_mutasi" class="btn btn-primary">Cetak Mutasi Proyek</a>
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
		var table_detail_mutasi;
		$(document).ready(function(){
			var table_detail_mutasi = $("#tbl_detail_mutasi").DataTable({
				
				"columns" : [
					{ "data" : "Proyek_id" },
					{ "data" : "Investor_id" },
					{ "data" : "Nama Investor Pendana" },
					{ "data" : "Email Investor Pendana" },
					{ "data" : "Nominal Investasi" },
					{ "data" : "Tanggal Investasi" },
					{ "data" : "Akad" }
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
					},{
						"targets": 3,
						class : 'text-center',
						
					},{
						"targets": 4,
						class : 'text-center',
					
					},{
						"targets": 5,
						class : 'text-center',
					},
					{
						"targets": 6,
						class : 'text-center',
						"render" : function(data, type, value, meta){
							return '<button class="btn btn-info" id="sendDokAkadMurobahah">Kirim Akad Murobahah</button>';
							//return row[6];
						}
					}
				]
			});
			
			table = $('#tbl_mutasi').DataTable({
				processing: false,
				serverSide: false,
				ajax : {
					type : "get",
					url : '/admin/list_mutasi/'
					
				},
				"columns" : [
					{ "data" : "ID Proyek" },
					{ "data" : "Nama Proyek" },
					{ "data" : "Total Dibutuhkan" },
					{ "data" : "Terkumpul" },
					{ "data" : "Terkumpul dari Investor" },
					{ "data" : "Jumlah Investor" },
					{ "data" : "Detail Mutasi" },
					{ "data" : "Presentasi Terkumpul" },
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
						return "RP. " + value['Total Dibutuhkan'];
					}
				},{
					"targets": 3,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return "RP. " + value['Terkumpul'];
					}
				},{
					"targets": 4,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return "RP. " + value['Terkumpul dari Pendana'];
					}
				},{
					"targets": 5,
					class : 'text-center',
				},{
					"targets": 6,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return '<button class="btn btn-info" data-toggle="modal" data-target="#modal_detail_mutasi" onclick="detail_mutasi('+value["ID Proyek"]+')">Detail Mutasi</button>';
						//return row[6];
					}
				},{
					"targets": 7,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['Presentasi Terkumpul'] + "%";
					}
				}]
			});
			
			$("#btn_close_form").on("click", function(){

				$('#tbl_detail_mutasi').dataTable().fnClearTable(); // reset data datatable
				
			})

			$('#tbl_detail_mutasi tbody').on( 'click', '#sendDokAkadMurobahah', function () {
                var data = table_detail_mutasi.row( $(this).parents('tr') ).data();
                id_proyek = data.Proyek_id;
                id_investor = data.Investor_id;
                console.log(id_proyek)
                $.ajax({
                    url : "/admin/proyek/sendDocDigisignRevisi/"+id_proyek+"/"+id_investor,
                    method : "get",
                    beforeSend: function() {
                        $("#overlay").css('display','block');
                    },
                    success:function(data)
                    {
                        $("#overlay").css('display','none');
                        var dataJSON = JSON.parse(data.status_all);
                        console.log(dataJSON);
                        swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                          function(){
                               table_detail_mutasi.ajax.reload();
                           }
                        );
                        
                    },
                    error: function(request, status, error)
                    {
                        $("#overlay").css('display','none');
                        alert(status)
                    } 
                });
                
            });

			// $('#tbl_detail_mutasi tbody').on( 'click', '#createDokAkadMurobahah', function () {
   //              var data = table_detail_mutasi.row( $(this).parents('tr') ).data();
   //              id_proyek = data.Proyek_id;
   //              id_investor = data.Investor_id;
   //              console.log(id_proyek)
   //              $.ajax({
   //                  url : "/admin/proyek/createDocDigisignRevisi/"+id_proyek+"/"+id_investor,
   //                  method : "get",
   //                  success:function(data)
   //                  {
   //                      console.log(data.status)
                        
   //                  }
   //              });
                
   //          });
			
		});
		
		function detail_mutasi(id){
			
			$('#modal_detail_mutasi').on('show.bs.modal', function(e) {
				//var hrefURI = "{{route('admin.proyek.mutasi_investor_proyek',['id' => "'\+id+\'"])}}";
				
				$("#cetak_mutasi").attr('href', '/admin/proyek/mutasi_investor_proyek/'+id+'');
				var table_detail_mutasi = $("#tbl_detail_mutasi").DataTable();
				table_detail_mutasi.ajax.url( "/admin/list_detail_mutasi/"+id+"" ).load();
				
			});
		}
    </script>

@endsection