@extends('layouts.admin.master')

@section('title', 'Dashboard Borrower')
	
@section('content')
	
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title">
				<h1>List Pencairan Dana Ke Penerima Pendanaan</h1>
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

			<div class="card">
				<div class="card-header">
					<strong class="card-title">Daftar Pencairan</strong>
				</div>
				<div class="card-body">
					<table id="tblPencairanDana" class="table table-striped table-bordered table-responsive-sm">
						<thead>
							<tr>
								<th>ID Penerima</th>
								<th>Id Proyek</th>
								<th>Pendanaan Nama</th>
								<th>Dana Dibutuhkan</th>
								<!--<th>Metode Pembayaran</th>-->
								<th>Dana Terkumpul</th>
								<!--<th>Status Pendanaan</th>
								<th>Status Dana</th>
								<th>Status Akad</th>
								<th>dana_dicairkan</th>
								<th>brw_norek</th>
								<th>brw_kd_bank</th>-->
								
								<th>Proses</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- start modal detil investor -->
<div class="modal fade" id="list_pendaan" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Daftar Pendanaan </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                    	<div class="table-responsive">
							<table id="TblListPendanaan" class="table table-striped table-bordered table-responsive-sm">
								<thead>
									<tr>
										<th>Pendanaan ID</th>
										<th>ID Penerima</th>
										<th>Nama Pendanaan</th>
										<th>Dana Dibutuhkan</th>
										<th>Estimasi Mulai</th>
										<th>Status</th>
										<th>ID Proyek</th>
										<th>Dokumen</th>
									</tr>
								</thead>
							</table>
						</div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
</div>
<!-- end of modal investor detil -->

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
<!--<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>-->
<script src="{{url('admin/assets/js/lib/select2.full.js')}}"></script>

<script type="text/javascript">
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	function prosesCair(brw_id, id_proyek, dana_dicairkan){
		
		swal({
			title: "Anda Yakin Melakukan Pencairan?",
			text: 'Nominal: Rp.'+ dana_dicairkan,
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Proses",
			cancelButtonText: "Batal",
			closeOnConfirm: true,
			closeOnCancel: true
		},
		function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					"url" : "/admin/borrower/inquiryTransfer",
					"method" : "POST",
					"data" : {"brw_id":brw_id, "id_proyek":id_proyek, "dana_dicairkan":dana_dicairkan},
					success : function(response){
						console.log(response);
						var data_json = jQuery.parseJSON(response);
						if(data_json.status_code == "00"){
							swal({
							  title: "Proses Berhasil",
							  //text: "Your will not be able to recover this imaginary file!",
							  type: "success",
							  showCancelButton: false,
							  confirmButtonClass: "btn-success",
							  closeOnConfirm: false
							},
							function(){
								location.href = "/admin/borrower/ListTableApproveDana";
							});
						}
						
					}
				});
				// $.ajax({
				// 	"url" : "/admin/borrower/prosesCairDana",
				// 	"method" : "POST",
				// 	"data" : {"brw_id":brw_id, "id_proyek":id_proyek},
				// 	success : function(response){
					
				// 		if(response.status == "sukses"){
				// 			swal({
				// 			  title: "Proses Berhasil",
				// 			  //text: "Your will not be able to recover this imaginary file!",
				// 			  type: "success",
				// 			  showCancelButton: false,
				// 			  confirmButtonClass: "btn-success",
				// 			  closeOnConfirm: false
				// 			},
				// 			function(){
				// 			  location.href = "/admin/borrower/ListTableApproveDana";
				// 			});
				// 		}
						
				// 	}
				// });
			}
		});
		
	}
	
	$(document).ready(function(){
		
		
		var tblPencairanDana = $('#tblPencairanDana').DataTable({
		
			processing: true,
			// serverSide: true,
			"ajax" : {
				url : '/admin/borrower/ListApproveDana/',
				type : 'get',
			},
			"columnDefs" :[
			  
			  {
				"targets": 0,
				class : 'text-left',
				"visible" : false,
			  },
			  {
				"targets": 1,
				class : 'text-left',
				style : 'width:150px;',
				"visible" : false
				
			  },
			  {
				"targets": 2,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				
			  },
			  {
				"targets": 3,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				
			  },
			  {
				"targets": 4,
				class : 'text-left',
				style : 'width:150px;',
				//"visible" : false
				
			  },
			  {
				"targets": 5,
				class : 'text-left',
				style : 'width:150px;',
				"render": function ( data, type, row, meta ) {
				 
					
				return '<button type="button" class="btn btn-block btn-primary" onclick="prosesCair(\''+row[0]+'\', \''+row[1]+'\',\' '+row[4]+'\')">Cair</button>';
				}
				
			  }
			]
		});
		
		$('#tableDataBorrower').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				tableDataBorrower.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				//var id = this.id;
				///console.log($(this));
			}
		});
	  });


	 
	


	

  
	

</script>

@endsection