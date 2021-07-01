@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Verifikasi Pembayaran</h1>
                    </div>
                </div>
            </div>
            
</div>
            <div class="content mt-3">
                
                            <div class="row">
                            <div class="col-md-12">
                            @if(session()->has('delete'))
                                <div class="alert alert-success">
                                    {{ session()->get('delete') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            {{-- @elseif(session()->has('verif_failed'))
                                <div class="alert alert-danger">
                                    {{ session()->get('verif_failed') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> --}}
                            @endif
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Data Pendanaan</strong>
                                    </div>
                                    <div class="card-body">
                                        <table id="" class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Nama Penerima Pendanaan</th>
                                                <th>Nama Pendanaan</th>
                                                <th>Tipe Pendanaan</th>
                                                <th>Dana Pokok</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($dataPendanaan as $row)
                                            <tr>
                                                <td width=20%>{{$row->nama}}</td>
                                                <td>{{$row->pendanaan_nama}}</td>
                                                <td>{{$row->pendanaan_tipe}}</td>
                                                <td>{{$row->pendanaan_dana_dibutuhkan}}</td>
                                                <td>{{$row->brw_id}}</td>
                                            </tr>
                                            @endforeach
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

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height : "350"
            // forced_root_block: false
        });
        $(document).ready(function(){
			$('#tbl_pendanaan_cair').DataTable({
				processing: false,
				serverSide: false,
				ajax : {
					type : "get",
					url : '/admin/pendanaanVerifikasiPembayaran'
					
				},
				"columns" : [
					{ "data" : "brw_id" },
					{ "data" : "pendanaan_nama" },
					{ "data" : "pendanaan_tipe" },
					{ "data" : "pendanaan_dana_dibutuhkan" },
					{ "data" : "Aksi" }
				],
				"columnDefs": [{
					"targets": 0,
					class : 'text-center',
                    "render" : function(data, type, value, meta){
						return value['brw_id'];
					}
				},{
					"targets": 1,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['pendanaan_nama'];
					}
				},{
					"targets": 2,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['pendanaan_tipe'];
					}
				},{
					"targets": 3,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['pendanaan_dana_dibutuhkan'];
					}
				},{
					"targets": 4,
					class : 'text-center',
					"render" : function(data, type, value, meta){
						return value['pendanaan_dana_dibutuhkan'];
					}
				}]
			});
			
			$("#tbl_pendanaan_cair").on("click", function(){

				$('#tbl_detail_mutasi').dataTable().fnClearTable(); // reset data datatable
				
			})

			// $('#tbl_pendanaan_cair tbody').on( 'click', '#sendDokAkadMurobahah', function () {
            //     var data = table_detail_mutasi.row( $(this).parents('tr') ).data();
            //     id_proyek = data.Proyek_id;
            //     id_investor = data.Investor_id;
            //     console.log(id_proyek)
            //     $.ajax({
            //         url : "/admin/proyek/sendDocDigisignRevisi/"+id_proyek+"/"+id_investor,
            //         method : "get",
            //         beforeSend: function() {
            //             $("#overlay").css('display','block');
            //         },
            //         success:function(data)
            //         {
            //             $("#overlay").css('display','none');
            //             var dataJSON = JSON.parse(data.status_all);
            //             console.log(dataJSON);
            //             swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
            //               function(){
            //                    table_detail_mutasi.ajax.reload();
            //                }
            //             );
                        
            //         },
            //         error: function(request, status, error)
            //         {
            //             $("#overlay").css('display','none');
            //             alert(status)
            //         } 
            //     });
                
            // });

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
    </script>
@endsection