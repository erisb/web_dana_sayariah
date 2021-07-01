@extends('layouts.user.sidebar')

@section('title', 'Beranda')
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@section('content')
<div class="row">
    @if (session('error'))
        <div class="alert alert-danger col-sm-12">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success col-sm-12">
              {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
    @endif
  </div>
  <div id="overlay">
	<div class="cv-spinner">
		<span class="spinner"></span>
	</div>
  </div>
  <div class="row">
    <div class="col-sm-12">
        <h2>Proyek Dipilih</h2>
        @if(session()->has('error_log'))
            <div class="alert alert-danger">
                {{ session()->get('error_log') }}, <a href="{{route('cetakulangsertifikat',['id' => Auth::user()->id])}}" class="badge badge-primary p-2">Cetak kembali sertifikat</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session('error_konfirm'))
          <div class="alert alert-success col-sm-12">
              {{ session('error_konfirm') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
              </button>
          </div>
        @endif
    </div>
  </div>
  <hr>
  
  <div class="row">
    @if(session()->has('msg_success'))
        <div class="alert alert-success" id="sts_sukses_invest">
        	{{ session()->get('msg_success') }}
        </div>
    @elseif(session()->has('msg_error'))
        <div class="alert alert-danger" id="sts_error_invest">
        	{{ session()->get('msg_error') }}
        </div>
    @endif
  </div>
  <!--div class="row my-5">
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard" style="background-color: #DAA520;">
        <div class="card-body" >
          <h5 class="card-title">Total Aset</h5>
          Rp. <span id="total_aset">{{!empty($rekening->total_dana)?number_format($rekening->total_dana,  0, '', '.'):0}}</span>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard" style="background-color: steelblue;">
        <div class="card-body" >
          <h5 class="card-title">Dana Tersedia</h5>
          Rp. <span id="dana_tersedia">{{!empty($rekening->unallocated)?number_format($rekening->unallocated,  0, '', '.'):0}}</span>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard" style="background-color: #f86c6b;">
        <div class="card-body" >
          <h5 class="card-title">Penarikan Dana</h5>
          Rp. <span id="dana_tersedia" class="">{{!empty($penarikan_dana)?number_format($penarikan_dana,  0, '', '.'):0}}</span>
          
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard " style="background-color: limegreen;" data-toggle="modal" data-target="#modalDetilAll" id="allDetilImbal" data-toggle="tooltip" data-placement="bottom" title="Lihat Data Imbal Seluruh !">
        <div class="card-body">
          <h5 class="card-title">Bagi Hasil Diterima</h5>
          Rp. <span id="bunga_diterima">{{!empty($payout)? number_format($payout) : 0}}</span>
        </div>
      </div>
    </div>
  </div-->
<div class="row my-3">
    <div class="col-sm-12 table-responsive-sm">
        <table class="table table-striped table-bordered table-responsive-sm" id="table_proyek">
        	<thead class="bg-dark text-light">
            	<th>id</th>
				<th id="trProyekID">Proyek Id</th>
				<th>Investor Id</th>
				<th>No</th>
				<th>Proyek</th>
				<th>Jumlah Paket</th>
				<th>Total Paket</th>
				<th>Aksi</th>
        	</thead>
        	<tbody></tbody>
     	</table>
    </div>
</div>

<div class="modal fade show" id="modal_confirm_danai" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title" id="txt_title">Proses</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
			<div class="modal-body">
                <div class="col-md-12">
				<!--<center><h4 id="txt_timer_set"></h4></center>-->
				<form method="post" action="{{ route('cart.newAdd') }}" id="form_checkout_invest"> 
					@csrf
					<div class="row">
					<div class="col-md-4" >
						<label>Nama Proyek</label>
						<p id="txt_nm_proyek"></p>
					</div>
					<div class="col-md-4" >
						<label>Jumlah Paket</label>
						<p id="txt_jmlh_paket"></p>
					</div>
					<div class="col-md-4" >
						<label>Total Paket</label>
						<p id="txt_total_paket"></p>
					</div>
					</div>
				</div>
			</div>
				<hr>
				<div class="col-md-12">
					
					<div class="row">
						<div class="col-md-3" style="float:left;">
							<label>No VA</label><br/>
							<label>Total Bayar</label>
						</div>
						<div class="col-md-3" style="float:right;">
							<label id="txt_no_va"></label><br/>
							<label id="txt_total"></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<span style="color:red; font-size:12px;">Catatan : Jika tidak dilakukan pembayaran dalam waktu 2 jam Pembayaran ini akan dihapus secara otomatis dari sistem</span> 
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<input type='hidden' id='txt_investor_id' name='txt_investor_id'>
					<input type='hidden' id='txt_proyek_id' name='txt_proyek_id'>
					
					<div class="form-group">
						<button type="button" id='btn_proses' class="btn btn-success btn-sm">Danai Sekarang</button>
					</div>
				</div>
				</form>
        </div>
    </div>
</div>

<!--
<div class="modal fade show" id="modal_invoice" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title" id="txt_title_show"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
			<div class="modal-body">
                <div class="col-md-12">
				<center><h4 id="txt_timer_set"></h4></center>
				<form method="post" action="{{ route('cart.newAdd') }}" id="form_checkout_invest"> 
					@csrf
					<div class="row">
					<div class="col-md-4" >
						<label>Nama Proyek</label>
						<p id="txt_nm_proyek_show"></p>
					</div>
					<div class="col-md-4" >
						<label>Jumlah Paket</label>
						<p id="txt_jmlh_paket_show"></p>
					</div>
					<div class="col-md-4" >
						<label>Total Paket</label>
						<p id="txt_total_paket_show"></p>
					</div>
					</div>
				</div>
			</div>
				<hr>
				<div class="col-md-12">
					
					<div class="row">
						<div class="col-md-3" style="float:left;">
							<label>No VA</label><br/>
							<label>Total Bayar</label>
						</div>
						<div class="col-md-3" style="float:right;">
							<label id="txt_no_va_show"></label><br/>
							<label id="txt_total_show"></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<span style="color:red; font-size:12px;">Catatan : Jika tidak dilakukan pembayaran dalam waktu 2 jam Pembayaran ini akan dihapus secara otomatis dari sistem</span> 
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<input type='hidden' id='txt_investor_id' name='txt_investor_id'>
					<input type='hidden' id='txt_proyek_id' name='txt_proyek_id'>
					
					
				</div>
				</form>
        </div>
    </div>
</div> -->

{{-- Modal Preview createdocInvestorBorrower --}}
  <div class="modal fade" id="modal_preview_doc" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5>Document Murobahah</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body" id="doc_preview">
            
        </div>
        <div class="modal-footer">
			<input type="hidden" id="txt_proyek_id_2" name="txt_proyek_id_2">
			<input type="hidden" id="txt_investor_id_2" name="txt_investor_id_2">
			<input type="hidden" id="txt_qty_2" name="txt_qty_2">
			<input type="hidden" id="txt_total_2" name="txt_total_2">
			<button type="button" id='btn_proses_danai' class="btn btn-success btn-sm">Setuju</button>
        </div>
      </div>
    </div>
  </div>
 {{-- Modal Aktivasi End --}}


{{-- modal  confirm invest --}}
<div class="modal fade show" id="modal_confirm_invest" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel">
    <div class="modal-dialog modal-md" role="document">
       <div class="modal-content">
			<div class="modal-header mb-3">
				<h5 class="modal-title" id="txt_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-md-12 mb-3">
					<!--form method="post" action="{{ route('cart.add') }}" id="form_checkout_invest"-->
					<form method="post" action="{{ route('cart.newAdd') }}" id="form_checkout_invest"> 
						@csrf
						<div class="col-md-6" style="float:left;">
							<label>Dana Dibutuhkan</label>
							<p id="txt_dana_dbutuhkan">Rp</p>
						</div>
						<div class="col-md-6" style="float:right;">
							<label>Periode / Tenor</label>
							<p id="txt_periode"></p>
						</div>
						<div class="col-md-6" style="float:left;">
							<label>Imbal Hasil / Tahun</label>
							<p id="txt_imbal_hasil"></p>
						</div>
						<div class="col-md-6" style="float:right;">
							<label>Minimum Pendanaan</label>
							<p id="txt_minum_pendanaan"></p>
						</div>
						<div class="col-md-6" style="float:left;">
							<label>Jenis Akad</label>
							<p id="txt_jenis_akad"></p>
						</div>
						<div class="col-md-6" style="float:right;">
							<label> Terima Imbal Hasil </label>
							<p id="txt_terima_imbal_hasil"></p>
						</div>
						</div>
					</div>
					<hr>
					<div class="col-md-12">
						<div class="col-md-6" style="float:left;">
							<label>Total Bayar</label>
						</div>
						<div class="col-md-6" style="float:right;">
							<label id="txt_total"></label>
						</div>	
					</div>
					<div class="modal-footer">
						<input type='hidden' id='txt_id' name='txt_id'>
						<input type='hidden' id='txt_idInvestor' name='txt_idInvestor'>
						<input type='hidden' id='txt_idProyek' name='txt_idProyek'>
						<input type='hidden' id='txt_qty' name='txt_qty'>
						<input type='hidden' id='txt_harga_paket' name='txt_harga_paket'>
						<input type='hidden' id='txt_total_qty' name='txt_total_qty'>
						<div class="col-md-8" style="padding-left:40px;">
						<div class="form-group">
							<!--<button type="button" id='btn_batal_proses' class="btn btn-success btn-sm" data-dismiss="modal">Batal</button>
							<button type="submit" id='btn_proses' class="btn btn-success btn-sm">Proses</button>-->
						</div>
						</div>
					</div>
				</form>
			</div>
    	</div>
    </div>
</div>
{{-- modal end confirm invest --}}

{{-- modal  edit invest --}}
<div class="modal fade show" id="modal_edit_invest" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel">
  <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header mb-3">
          <h5 class="modal-title" id="txt_title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
			<div id='divInvest'>
				<div class="card text-right card_manage_investation m-2">
					<div class="card-body">
						<form action="{{ route('cart.updateSelected') }}"  method="POST">
							{{csrf_field()}}
							<input type="hidden" id="proyekId" name="proyekid">
							<div class="form-group row w-75 mx-auto">
								<label for="qty" class="col-4">Jumlah paket : &nbsp;</label>
								<div class="col-8">
								  <input name="qty" id="jumlah_paket" type="number" min="1" class="form-control qty" autofocus>
								</div>
							</div>
							<div class="form-group row w-75 mx-auto">
									<label for="total" class="col-4">Total : &nbsp;</label>
								<div class="col-8">
								  <input type="text" id="total_paket" disabled name="total" class="form-control total">
								  <input type="hidden" id="total_invest" name="totalInvest" class="form-control total">
								  <input type="hidden" id="harga_paket" class="form-control total">
								</div>
							</div>
							<div class="modal-footer">
								<div class="form-group">
							  <!--<button type="button" id='btn_batal_proses' class="btn btn-success btn-sm" data-dismiss="modal">Batal</button>
							  <button type="submit" id='btn_proses' class="btn btn-success btn-sm">Edit</button>-->
								</div>
							</div>
						</form>
					</div>
				</div> 
			</div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- modal edit invest --}}


  {{-- Modal Aktivasi --}}
  <div class="modal fade" id="modalAktivasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5>Aktivasi DigiSign</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body" id="modalBodyAktivasi">
            
        </div>
        {{-- <div class="modal-footer">
          
        </div> --}}
      </div>
    </div>
  </div>
 {{-- Modal Aktivasi End --}}
 
   {{-- Modal TTD --}}
  <div class="modal fade" id="modalTTD" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5>TTD DigiSign</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body" id="modalBodyTTD">
            
        </div>
        {{-- <div class="modal-footer">
          
        </div> --}}
      </div>
    </div>
  </div>

<link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />

<script src="{{asset('js/sweetalert.js')}}"></script>
<script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.buttons.min.js"></script>

<style>
    .modal-dialog{
      min-width: 80%;
    }

    .btn-cancel {
        background-color: #C0392B;
        color: #FFFF;
    }
</style>
@endsection
@section('script')
<script>
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function formatNumber(num) {
		return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	};
	
	function lanjut_proses(proyek_id, investor_id, paket, total){
		
		$('#modal_preview_doc').modal('show').addClass('modal fade show in').attr('style','display:block')
		$('#doc_preview').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
		$('.modal-backdrop').addClass('modal-backdrop fade show in')
		$('#linkAktivasi').attr('src','{{URL("storage/app/public/akad_template/BNI eCollection-API.v1.9.2.pdf")}}');
		//$('#linkAktivasi').attr('src',dataJSON.file);
		$("#modal_preview_doc").appendTo('body');
		$('#linkAktivasi').load(function(){
			var myFrame = $("#linkAktivasi").contents().find('body').text();
			console.log(myFrame);
			// if (myFrame !== '')
			// {
				// $('#modal_preview_doc').modal('show').addClass('modal fade').attr('style','display:none')
				// $('.modal-backdrop').remove()
				// location.reload(true);
			// }
			$("#txt_proyek_id_2").val(proyek_id);
			$("#txt_investor_id_2").val(investor_id);
			$("#txt_qty_2").val(paket);
			$("#txt_total_2").val(total);
		});
		
		// $.ajax({
			// url: "/user/createDocInvestorBorrower/"+proyek_id+"/"+investor_id,
			// type: "GET",
			// beforeSend: function() {
				// $("#overlay").css('display','block');
				// swal.close()
			// },
			// success:function(data)
			// {
				// var dataJSON = JSON.parse(data);
				// if(dataJSON.status == "Berhasil"){
					// $('#modal_preview_doc').modal('show').addClass('modal fade show in').attr('style','display:block')
					// $('#doc_preview').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
					// $('.modal-backdrop').addClass('modal-backdrop fade show in')
					// $('#linkAktivasi').attr('src','{{URL("storage/app/public/akad_template/BNI eCollection-API.v1.9.2.pdf")}}');
					// //$('#linkAktivasi').attr('src',dataJSON.file);
					// $("#modal_preview_doc").appendTo('body');
					// $('#linkAktivasi').load(function(){
						// var myFrame = $("#linkAktivasi").contents().find('body').text();
						// console.log(myFrame)
						// // if (myFrame !== '')
						// // {
							// // $('#modal_preview_doc').modal('show').addClass('modal fade').attr('style','display:none')
							// // $('.modal-backdrop').remove()
							// // location.reload(true);
						// // }
					// })
				// }
				
			// }
		// });
		
	};
	// lanjut proses atau create invoice
	// function lanjut_proses(){
		
		// var table = $('#table_proyek').DataTable().rows('tr.selected').data(); // get row datatables
		// var table_list_proyek = $('#table_list_proyek').DataTable({
			// paging: false,
			// info: false,
			// lengthChange:false,
			// searching: false,
			// "columns" : [
				// {"data" : "Proyek"},
				// {"data" : "Jumlah Paket"},
				// {"data" : "Total Paket"}
			// ]
		// });
		// var row = table.length;
		
		// // kalo belom memilih
		// if(row == 0){
			
			// swal("Error", "Anda Belum Memilih List Proyek", "error");
			
		// }
		
		// else if(table[0].status == 1){
			
			// // validasi check proyek didanai
			// swal({
				// title: "Informasi",   
				// text: "Maaf Proyek Sedang Didanai",   
				// type: "info",   
				// showCancelButton: false,
				// showConfirmButton: true,
				// cancelButtonClass: 'btn-cancel',
				// confirmButtonText: "ok",  
				// closeOnConfirm: true,   
				// closeOnCancel: true
				
			// },
			// function(isConfirm){
				// if (isConfirm) {
					// location.href = "";
				// }
			// });
			
			
		// }else{
			
			// //proses create invoice			
			// swal({
				// title: "Informasi",   
				// text: "Anda Yakin Ingin Lanjut Proses Danai ?",   
				// type: "warning",   
				// showCancelButton: true,
				// cancelButtonClass: 'btn-cancel',
				// confirmButtonText: "Setuju",   
				// cancelButtonText: "Batal",   
				// closeOnConfirm: true,   
				// closeOnCancel: true,
				// showConfirmButton: true
			// },
			// function(isConfirm){   
				// if (isConfirm) 
				// {
					// $("#modal_confirm_danai").modal("show");
					// var total_proyek = 0; 
					// var proyek_id_arr = [];
					// var ii = 0;
					// var date_expired = "";
					
                    // $.each(table, function( index, value ) {
						// table_list_proyek.row.add({
							// "Proyek":       	value.nama_proyek,
							// "Jumlah Paket":   	value.qty,
							// "Total Paket":    	value.total_price
						// }).draw();
						// total_proyek += parseInt(value.total_price, 10); // set sum total proyek
						
						// proyek_id_arr.push(value.proyek_id); // tampung proyek id
						// ii++;
						
					// });
					
					// var proyek_array = proyek_id_arr.join("|"); //parsing data proyek id
					
					
					// // create invoice & update status proyek
					// $.ajax({
						// url: "{{route('cart.create_invoice')}}",
                        // type: "POST",
						// data : {"_token": "{{ csrf_token() }}", "proyek_id":proyek_array, "total_danai":total_proyek},
						
						// success:function(data)
						// {
							// date_expired = data.expired_date.split("-");
							// $("#txt_no_va").text(data.no_va);
							
						// }
					// });
					
					// //console.log(date_expired);
					// $("#txt_total").text(total_proyek);
					// var timer2 = "1:60:60";
					// var interval = setInterval(function() {


						// var timer = timer2.split(':');
						// //by parsing integer, I avoid all extra string processing
						// var hours = parseInt(timer[0], 10);
						// var minutes = parseInt(timer[1], 10);
						// var seconds = parseInt(timer[2], 10);
						// --seconds;
						// minutes = (seconds < 0) ? --minutes : minutes;
						// if (minutes < 0) 
							// hours = 0;
							// //clearInterval(interval);
							// seconds = (seconds < 0) ? 59 : seconds;
							// seconds = (seconds < 10) ? '0' + seconds : seconds;
							// minutes = (minutes < 0) ? 59 : minutes;
							// minutes = (minutes < 10) ? '0' + minutes : minutes;
							// hours = (hours < 0) ? 59 : hours;
							// hours = (hours < 10) ? '0' + hours : hours;
							// //minutes = (minutes < 10) ?  minutes : minutes;
							// $('#txt_timer_set').text("Danai Sebelum " + hours + ':' + minutes + ':' + seconds);
							// timer2 = hours + ':' + minutes + ':' + seconds;
					// }, 1000);
					
					
					
				// }else{
					
					// location.href = "";
					
				// }
			// });
		// }
	// }

	/******************* REQUEST OJK OPEN MODAL ******************/
	// function lanjut_proses(){
		
		// var data = $('#table_proyek').DataTable().rows('tr.selected').data(); // get row datatables
		// var row = data.length;
		// // kalo belom memilih
		// if(row == 0){
			
			// swal("Error", "Anda Belum Memilih List Proyek", "error");
			
		// }
		// else{
			// swal({
				// title: "Informasi",   
				// text: "Anda Yakin Ingin Lanjut Proses Danai ?",   
				// type: "warning",   
				// showCancelButton: true,
				// cancelButtonClass: 'btn-cancel',
				// confirmButtonText: "Setuju",   
				// cancelButtonText: "Batal",   
				// closeOnConfirm: true,   
				// closeOnCancel: true,
				// showConfirmButton: true
			// },
			// function(isConfirm){   
				// if (isConfirm) {
					
					// $("#modal_confirm_danai").modal("show");
					// $("#txt_nm_proyek").text(data[0].nama_proyek);
					// $("#txt_jmlh_paket").text(data[0].qty);
					// $("#txt_total_paket").text(data[0].total_price);
					// $("#txt_no_va").text("-");
					// $("#txt_total").text(data[0].total_price);
					// $("#txt_investor_id").val(data[0].investor_id);
					// $("#txt_proyek_id").val(data[0].proyek_id);
					// // var timer2 = "1:60:60";
					// // var interval = setInterval(function() {


						// // var timer = timer2.split(':');
						// // var hours = parseInt(timer[0], 10);
						// // var minutes = parseInt(timer[1], 10);
						// // var seconds = parseInt(timer[2], 10);
						// // --seconds;
						// // minutes = (seconds < 0) ? --minutes : minutes;
						// // if (minutes < 0) 
							// // hours = 0;
							// // //clearInterval(interval);
							// // seconds = (seconds < 0) ? 59 : seconds;
							// // seconds = (seconds < 10) ? '0' + seconds : seconds;
							// // minutes = (minutes < 0) ? 59 : minutes;
							// // minutes = (minutes < 10) ? '0' + minutes : minutes;
							// // hours = (hours < 0) ? 59 : hours;
							// // hours = (hours < 10) ? '0' + hours : hours;
							// // //minutes = (minutes < 10) ?  minutes : minutes;
							// // $('#txt_timer_set').text("Danai Sebelum " + hours + ':' + minutes + ':' + seconds);
							// // timer2 = hours + ':' + minutes + ':' + seconds;
					// // }, 1000);
				// }
			// });
		// }
		
	// }
	
	// show invoice
	function show_invoice(invoice_id, amount ){
		$("#modal_invoice").modal("show");
		
		$("#txt_title_show").text("Invoice ID : " + invoice_id);
		$("#txt_nm_proyek_show").text(invoice_id);
		$("#txt_jmlh_paket_show").text(invoice_id);
		$("#txt_total_paket_show").text(invoice_id);
		$("#txt_no_va_show").text(invoice_id);
		$("#txt_total_show").text(amount);
		
	}
	
	function delete_pendanaan(id_proyek){
		swal({
			title: "Informasi",   
            text: "Yakin Akan Menghapus Proyek Ini?",   
            type: "warning",   
            showCancelButton: true,
            cancelButtonClass: 'btn-cancel',
            confirmButtonText: "Setuju",   
            cancelButtonText: "Batal",   
            closeOnConfirm: true,   
            closeOnCancel: true
        },
        function(isConfirm){   
            if (isConfirm) 
            {
				$.ajax({
					url: '/user/delete_select_proyek/'+id_proyek,
					method : 'get',
					//data : {"id_proyek":id_proyek},
					success:function(data)
					{
						if(data.status == 'ok')
						{
							swal({
								title: "Proses Berhasil",
								//text: "Your will not be able to recover this imaginary file!",
								type: "success",
								showCancelButton: false,
								confirmButtonClass: "btn-success",
								closeOnConfirm: false
							},
							function(){
								location.href = "/user/selected_proyek";
							});
						}
					}
				})
            }
        });
	}
	
	/********************* 	
	REQUEST OJK 
	check akad wakalah dan ttd kontrak proyek
	*********************/
	
	// hide dulu sementara
	// $(document).on("click", "#btn_proses", function(){
		
		// var txt_total 		= $("#txt_total").text();
		// var txt_proyek_id 	= $("#txt_proyek_id").val();
		// var txt_investor_id = $("#txt_investor_id").val();
		// var id_user = {{ Auth::user()->id }};
		// $("#modal_confirm_danai").modal("hide");
		
		// $.ajax({
			  // url:'/user/regDigiSign/'+id_user,
			  // method:'get',
			  // dataType:'json',
			  // beforeSend: function() {
				  // $("#overlay").css('display','block');
				  // swal.close()
			  // },
			  // success:function(data)
			  // {
				  // $("#overlay").css('display','none');
				  // var dataJSON = JSON.parse(data.status_all);
				  // console.log(dataJSON + "regDigisign");
				  // if (dataJSON.JSONFile.result == '00')
				  // {
					 // if (dataJSON.JSONFile.info)
					  // {
						// var url_notif = dataJSON.JSONFile.info.split('https://')[1];
						// $.ajax({
							// url : "/user/callbackDigiSignInvestor/",
							// method : "post",
							// data : {user_id:id_user,provider_id:1,status:dataJSON.JSONFile.notif,step:'register',url:url_notif},
							// success:function(data)
							// {
								// console.log(data.status + "callbackDigiSignInvestor");
								// var email = "{{ Auth::user()->email }}"
								// $.ajax({
									// url : "/user/actDigiSign/"+email,
									// method : "get",
									// success:function(data)
									// {
										// var dataJSON2 = JSON.parse(data.status_all);
										// console.log(dataJSON2 + "actDigiSign");
										// if (dataJSON2.JSONFile.result == '00')
										// {
											// $('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
											// $('.modal-backdrop').addClass('modal-backdrop fade show in')
											// $('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
											// $('#linkAktivasi').attr('src',dataJSON2.JSONFile.link);
											// $("#modalAktivasi").appendTo('body');
											// $('#linkAktivasi').load(function(){
												// var myFrame = $("#linkAktivasi").contents().find('body').text();
												// console.log(myFrame)
												// if (myFrame !== '')
												// {
													// $('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
													// $('.modal-backdrop').remove()
													// location.reload(true);
												// }
											// })
											
										// }
										// else
										// {
											// swal({title:"Notifikasi",text:'Aktivasi Gagal',type:"info"},
											  // function(){
													// swal.close()
											   // }
											// );
										// }
									// },
									// error: function(request, status, error)
									// {
										// // $("#overlay").css('display','none');
										// alert(status)
									// }
								// });
							// },
							// error: function(request, status, error)
							// {
								// // $("#overlay").css('display','none');
								// alert(status)
							// }
						// });
					  // }
					  // else if(dataJSON.JSONFile.notif == 'Anda sudah terdaftar sebelumnya, silahkan gunakan layanan Digisign')
					  // {
						// swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
									 // function(){
										  // swal.close()
										  // var id_user = {{ Auth::user()->id }}
											// id_proyek = $('#txt_idProyek').val()
										  // $.ajax({
											  // url : "/borrower/sendDigiSignMurobahahBorrower/"+txt_proyek_id+'/'+id_user,
											  // method : "get",
											  // beforeSend: function() {
												  // $("#overlay").css('display','block');
											  // },
											  // success:function(data)
											  // {
												  // $("#overlay").css('display','none');
												  // var dataJSON = JSON.parse(data.status_all);
												  // if (dataJSON.JSONFile.result == '00')
												  // {
													  // $.ajax({
														  // url:'/user/signDigiSignMurobahah/'+id_user+'/'+txt_proyek_id,
														  // method:'get',
														  // dataType:'json',
														  // beforeSend: function() {
															  // $("#overlay").css('display','block');
															  // swal.close()
														  // },
														  // success:function(data)
														  // {
															  // $("#overlay").css('display','none');
															  // var dataJSON = JSON.parse(data.status_all);
															  // console.log(dataJSON);
															  // if (dataJSON.JSONFile.result == '00')
															  // {
																  // $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
																  // $('.modal-backdrop').addClass('modal-backdrop fade show in')
																  // $('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
																  // $('#linkTTD').attr('src',dataJSON.JSONFile.link)
																  // $("#modalTTD").appendTo('body');
																  // $('#linkTTD').load(function(){
																	  // var myFrame = $("#linkTTD").contents().find('body').text();
																	  // console.log(myFrame)
																	  // if (myFrame !== '')
																	  // {
																		  // $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
																		  // $('.modal-backdrop').remove()
																		  // location.reload(true);
																	  // }
																  // })
															  // }
															  // else
															  // {
																  // swal({title:"Notifikasi",text:'TTD Gagal',type:"info"},
																	// function(){
																		  // swal.close()
																	 // }
																  // );
															  // }
														  // },
														  // error: function(request, status, error)
														  // {
															  // $("#overlay").css('display','none');
															  // alert(status)
														  // }
													  // })
												  // }
												  // else
												  // {
													  // swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
														// function(){
															 // investorTable.ajax.reload();
														 // }
													  // );
												  // }
												  
											  // },
											  // error: function(request, status, error)
											  // {
												  // $("#overlay").css('display','none');
												  // alert(status)
											  // } 
										  // });
									  // }
								  // );
// }	
					  // else
					  // {
						// $.ajax({
							// url:'/user/cekRegDigiSign/'+id_user,
							// method:'get',
							// dataType:'json',
							// beforeSend: function() {
								// $("#overlay").css('display','block');
								// swal.close()
							// },
							// success:function(data)
							// {
							// console.log(data + "cekRegDigisin");
							// if(data == '')
							  // {
								  // swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
									 // function(){
										  // swal.close()
										  // var email = "{{ Auth::user()->email }}"
										  // $.ajax({
											  // url : "/user/actDigiSign/"+email,
											  // method : "get",
											  // success:function(data)
											  // {
												 // console.log(data + "actDigiSign 2");
												  // var dataJSON2 = JSON.parse(data.status_all);
												  
												  // if (dataJSON2.JSONFile.result == '00')
												  // {
													  // $('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
													  // $('.modal-backdrop').addClass('modal-backdrop fade show in')
													  // $('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
													  
													  // <!-- PROSES SEND DOCUMENT -->
														// $.ajax({
															// url : "/borrower/sendDigiSignMurobahahInvestor/"+txt_proyek_id+"/"+id_user,
															// method : "get",
															// success:function(data){
																// var dataJSON_document = JSON.parse(data.status_all);
																// if (dataJSON_document.JSONFile.result == '00'){
																	
																	// $.ajax({
																	// url : "/user/cart/signDigiSignMurobahah/"+id_user+"/"+txt_proyek_id,
																	// method : "get",
																	// success:function(data){
																		// var dataJSON_document = JSON.parse(data.status_all);
																		// console.log(dataJSON_document);
																		// if (dataJSON_document.JSONFile.result == '00'){
																			// link = dataJSON_document.JSONFile.link;
																			// console.log(link);
																			
																			// $('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
																			// $('.modal-backdrop').addClass('modal-backdrop fade show in')
																			// $('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
																			// $('#linkAktivasi').attr('src',dataJSON_document.JSONFile.link);
																			// $("#modalAktivasi").appendTo('body');
																			// $('#linkAktivasi').load(function(){
																				// var myFrame = $("#linkAktivasi").contents().find('body').text();
																				// console.log(myFrame);
																				// if (myFrame !== '')
																				// {
																					// $('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
																					// $('.modal-backdrop').remove()
																					// location.reload(true);
																				// }
																			// })
																		// }
																	// }
																
																	  
																// })
																	
																// }
																
																
															// }
														
															  
														// })
													  
													  // $('#linkAktivasi').attr('src',dataJSON2.JSONFile.link)
													  // $("#modalAktivasi").appendTo('body');
													  // $('#linkAktivasi').load(function(){
														  // var myFrame = $("#linkAktivasi").contents().find('body').text();
														  // console.log(myFrame)
														  // if (myFrame !== '')
														  // {
															  // $('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
															  // $('.modal-backdrop').remove()
															  // location.reload(true);
														  // }
													  // })
													  
												  // }
												  // else
												  // {
													  // swal({title:"Notifikasi",text:'Aktivasi Gagal',type:"info"},
														// function(){
															  // swal.close()
														 // }
													  // );
												  // }
											  // },
											  // error: function(request, status, error)
											  // {
												  // // $("#overlay").css('display','none');
												  // alert(status)
											  // }
										  // });
									  // }
								  // );
							  // }
							  // else
							  // {
								  // swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
									 // function(){
										  // swal.close()
										  // var id_user = {{ Auth::user()->id }};
										  // $.ajax({
											  // url : "/admin/investor/sendDigiSign/"+id_user,
											  // method : "get",
											  // beforeSend: function() {
												  // $("#overlay").css('display','block');
											  // },
											  // success:function(data)
											  // {
												  // $("#overlay").css('display','none');
												  // var dataJSON = JSON.parse(data.status_all);
												  // if (dataJSON.JSONFile.result == '00')
												  // {
													  // $.ajax({
														  // url:'/user/signDigiSign/'+id_user,
														  // method:'get',
														  // dataType:'json',
														  // beforeSend: function() {
															  // $("#overlay").css('display','block');
															  // swal.close()
														  // },
														  // success:function(data)
														  // {
															  // $("#overlay").css('display','none');
															  // var dataJSON = JSON.parse(data.status_all);
															  // console.log(dataJSON);
															  // if (dataJSON.JSONFile.result == '00')
															  // {
																  // $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
																  // $('.modal-backdrop').addClass('modal-backdrop fade show in')
																  // $('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
																  // $('#linkTTD').attr('src',dataJSON.JSONFile.link)
																  // $("#modalTTD").appendTo('body');
																  // $('#linkTTD').load(function(){
																	  // var myFrame = $("#linkTTD").contents().find('body').text();
																	  // console.log(myFrame)
																	  // if (myFrame !== '')
																	  // {
																		  // $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
																		  // $('.modal-backdrop').remove()
																		  // location.reload(true);
																	  // }
																  // })
															  // }
															  // else
															  // {
																  // swal({title:"Notifikasi",text:'TTD Gagal',type:"info"},
																	// function(){
																		  // swal.close()
																	 // }
																  // );
															  // }
														  // },
														  // error: function(request, status, error)
														  // {
															  // $("#overlay").css('display','none');
															  // alert(status)
														  // }
													  // })
												  // }
												  // else
												  // {
													  // swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
														// function(){
															 // investorTable.ajax.reload();
														 // }
													  // );
												  // }
												  
											  // },
											  // error: function(request, status, error)
											  // {
												  // $("#overlay").css('display','none');
												  // alert(status)
											  // } 
										  // });
									  // }
								  // );
							  // }
							// }
						// })
					// }
				  // }
				  // else
				  // {
					  // swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
						// function(){
							  // swal.close()
						 // }
					  // );
				  // }
			  // },
			  // error: function(request, status, error)
			  // {
				  // $("#overlay").css('display','none');
				  // alert(status)
			  // }
		  // })
	// });
	
	$(document).on("click", "#btn_proses_danai", function(){
		
		
		var proyek_id 	= $("#txt_proyek_id_2").val();
		var investor_id = $("#txt_investor_id_2").val();
		var qty 		= $("#txt_qty_2").val();
		var total 		= $("#txt_total_2").val();
		
		swal({
			title: "Informasi",   
			text: "Anda Yakin Ingin Lanjut Proses Danai ?",   
			type: "warning",   
			showCancelButton: true,
			cancelButtonClass: 'btn-cancel',
			confirmButtonText: "Setuju",   
			cancelButtonText: "Batal",   
			closeOnConfirm: true,   
			closeOnCancel: true,
			showConfirmButton: true
		},
			function(isConfirm){   
				if (isConfirm) {
					$.ajax({
						url 	: "{{route('cart.add')}}",
						method 	: "post",
						data 	: {'proyek_id':proyek_id, 'investor_id':investor_id, 'qty':qty, 'total':total},
						beforeSend: function(jqXHR,settings) {
							$("#overlay").css('display','block');
						},
						success: function (response) {
							var data = jQuery.parseJSON(response);
							
							// jika VA kosong di table rekening investor
							if(data.status == "gagal_va"){
								swal({
									title: data.keterangan,
									//text: "Your will not be able to recover this imaginary file!",
									type: "info",
									showCancelButton: false,
									confirmButtonClass: "btn-success",
									closeOnConfirm: false
								},
								function(){
									location.href = "";
								});
								
							}
							
							// dana tidak cukup
							else if(data.status == "gagal_dana"){
								swal({
									title: data.keterangan,
									//text: "Your will not be able to recover this imaginary file!",
									type: "info",
									showCancelButton: false,
									confirmButtonClass: "btn-success",
									closeOnConfirm: false
								},
								function(){
									location.href = "";
								});
							}
							
							// dana tersedia kurang
							else if(data.status == "gagal_dana_tersedia"){
								swal({
									title: data.keterangan,
									//text: "Your will not be able to recover this imaginary file!",
									type: "info",
									showCancelButton: false,
									confirmButtonClass: "btn-success",
									closeOnConfirm: false
								},
								function(){
									location.href = "";
								});v
							}
							
							// proses pendanaan berhasil
							else if(data.status == "sukses_dana"){
								swal({
									title: data.keterangan,
									//text: "Your will not be able to recover this imaginary file!",
									type: "success",
									showCancelButton: false,
									confirmButtonClass: "btn-success",
									closeOnConfirm: false
								},
								function(){
									location.href = "";
								});
							}
							
							// proyek sudah selesai
							else if(data.status == "gagal_dana_proyek_selesai"){
								swal({
									title: data.keterangan,
									//text: "Your will not be able to recover this imaginary file!",
									type: "info",
									showCancelButton: false,
									confirmButtonClass: "btn-success",
									closeOnConfirm: false
								},
								function(){
									location.href = "";
								});
							}
							
							// dana penggalangan penuh
							else if(data.status == "gagal_dana_penuh"){
								swal({
									title: data.keterangan,
									//text: "Your will not be able to recover this imaginary file!",
									type: "info",
									showCancelButton: false,
									confirmButtonClass: "btn-success",
									closeOnConfirm: false
								},
								function(){
									location.href = "";
								});
							}
							
							// Proyek Sudah Penuh & Penggalangan Dana Proyek Sudah Selesai
							else if(data.status == "gagal_dana_penuh_selesai"){
								swal({
									title: data.keterangan,
									//text: "Your will not be able to recover this imaginary file!",
									type: "info",
									showCancelButton: false,
									confirmButtonClass: "btn-success",
									closeOnConfirm: false
								},
								function(){
									location.href = "";
								});
							}
						}
						
					});
				}
		});
	});
	
	$(document).on('click','#kontrak_unduh_base64',function(){
	//$('#kontrak_unduh_base64').on('click',function(){
		
      var id_user = {{ Auth::user()->id }};
      console.log(id_user)
      $.ajax({
          url:'/user/downloadBase64DigiSign/',
          method:'post',
          //responseType: "blob",
          data:{id:id_user},
          beforeSend: function(jqXHR,settings) {
              $("#overlay").css('display','block');
          },
          success: function (response) {
              $('#overlay').css('display','none')
              var dataBersih = JSON.parse(response.status_all)
              console.log(dataBersih.JSONFile)
              var newData = b64toBlob(dataBersih.JSONFile.file,'',512)
              var blob = new Blob([newData], {type: "application/pdf"});
              var link = document.createElement("a");
              link.href = window.URL.createObjectURL(blob);
              link.download = "Akad Wakalah Bil Ujroh.pdf";
              link.click();
              //console.log(response)
          },
          error: function(request, status, error)
          {
              $("#overlay").css('display','none');
              alert(status)
          }
      })  
              
  });
  
  function b64toBlob(b64Data, contentType, sliceSize) {
    contentType = contentType || '';
    sliceSize = sliceSize || 512;

    var byteCharacters = atob(b64Data);
    var byteArrays = [];

    for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    var blob = new Blob(byteArrays, {type: contentType});
    return blob;
	}
	
	
    var TableProyek = $('#table_proyek').DataTable({
		searching: true,
		processing: true,
		// serverSide: true,
		ajax: {
			url: '/user/SelectedProyek/',
			dataSrc: 'data'
		},
		paging: true,
		info: true,
		lengthChange:false,
		order: [ 1, 'asc' ],
		pageLength: 10,
		// dom: 'Bfrtip',
		// buttons: [
        
            // {
				// text:      '<button class=\"btn\" id="lanjut_proses" style=\"background:#FBA51B\">Lanjut Proses</button>',
				// titleAttr: 'Delete',
				// className : 'bDelete',
				// enabled:true,
				// action: function ( e, dt, node, config ) {
					// lanjut_proses();
				// }
            // }
			
         // ] ,
		columns: [
			{ 
				data: 'id'
			},
			{ 
				data: 'Proyek ID',
				render: function (data, type, row, meta) {
						return  row.proyek_id;
				}
			},
			{ 
				data: 'Investor Id',
				render: function (data, type, row, meta) {
						return  row.investor_id;
				}

			},
			{ data : null,
				render: function (data, type, row, meta) {
						return  meta.row+1;
				}
			},
			
			{ data: 'nama_proyek'},
			{ data: 'qty'},
			{ data: 'total_price',render: $.fn.dataTable.render.number(",", ".", 0, 'Rp. ')},
			{ data: null,
				  
				render:function(data,type,row,meta,full){
					var id = data.id;
					var investor_id = data.investor_id;
					var proyek = data.proyek_id; 
					var nama_proyek = data.nama_proyek;
					
					var status = data.status;
					var paket = data.qty;
					var total = data.total_price;
					var expired = data.exp_date;
					var invoice_id = data.invoice_id;
					var amount = data.amount;
					
					var path = nama_proyek;
					var path2 = path.replace(/\\/g, "/");
					
					//var countDownDate = new Date(expired).getTime();
					
					// Update the count down every 1 second
					// var x = setInterval(function() 
					// {

					  // // Get today's date and time
					  // var now = new Date().getTime();
						
					  // // Find the distance between now and the count down date
					  // var distance = countDownDate - now;
						
					  // // Time calculations for days, hours, minutes and seconds
					  // //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					   // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						// var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					  // var seconds = Math.floor((distance % (1000 * 60)) / 1000);
					  
					  // // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					  // // var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					  // // var seconds = Math.floor((distance % (1000 * 60)) / 1000);
						
					  // // Output the result in an element with id="demo"
					  
						// document.getElementById("timer").innerHTML = hours + " : "+ minutes + " : " + seconds + "  ";
					  
						
					  // // If the count down is over, write some text 
					  // if (distance < 0) {
						// clearInterval(x);
					  
						  // document.getElementById("timer").innerHTML = "EXPIRED";
						
					  // }
					// }, 1000);
					var html = "";
					
					if(status == 1){
						
						html = '<button class="btn btn-warning" data-id='+invoice_id+' data-toggle="modal" data-target="#" onclick="show_invoice('+invoice_id+', '+amount+', '+nama_proyek+', '+paket+', '+total+')" id="btnEdit" title="Edit Paket"><i class="fas fa-file-signature"></i> Lihat Invoice</button> <button class="btn btn-warning" data-id='+invoice_id+' data-toggle="modal" data-target="#" id="kontrak_unduh_base64" title="Unduh Murobahah"><i class="fas fa-file-signature"></i> Unduh Akad</button>';
					}else{
						
						html = ' <button class=\"btn\" onclick="lanjut_proses('+proyek+','+investor_id+','+paket+','+total+')" id="lanjut_proses" style=\"background:#FBA51B\">Lanjut Proses</button> <button class="btn btn-warning" data-id='+id+' data-proyek='+proyek+' data-toggle="modal" data-target="#" id="btnEdit" title="Edit Paket"><i class="fas fa-file-signature"></i> Edit Paket</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="delete_pendanaan('+proyek+')" class="btn btn-danger">X</button>';
					}
					return html;
					
					
					//return '<button class="btn btn-warning" data-id='+id+' data-proyek='+proyek+' data-toggle="modal" data-target="#" id="btnEdit" title="Edit Paket"><i class="fas fa-file-signature"></i> Edit Paket</button>&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="delete_pendanaan('+proyek+')" class="btn btn-danger">X</button>';
					//return '<button class="btn btn-primary" data-id='+id+' data-proyek='+proyek+' data-toggle="modal" data-target="#" id="btnConfirm" title="Danai Sekarang"> Danai Sekarang </button>&nbsp;&nbsp;<button class="btn btn-warning" data-id='+id+' data-proyek='+proyek+' data-toggle="modal" data-target="#" id="btnEdit" title="Edit Paket"><i class="fas fa-file-signature"></i> Edit Paket</button>&nbsp;&nbsp;<button class="btn btn-danger"disabled><span id="timer">Exp ' + data.exp_date + '</span></button>';

					// if (status == 1)
					// {
					  // return '<button class="btn btn-primary" data-id='+id+' data-proyek='+proyek+' data-toggle="modal" data-target="#" id="btnConfirm" title="Danai Sekarang"> Danai Sekarang</button>';
					// }else if(status == 2){
					  // return '<button class="btn btn-danger" title="Proses" ><i class="fa fa-sync-alt fa-spin"></i> Proses Topup <span id="timer"></span></button>';
					// }else if(status == 3){
					  // return '<button class="btn btn-success" title="Sukses" ><i class="fa fa-check"></i> Pendanaan Sukses</button>';
					// } 
				  
				}
			}
		],columnDefs: [
			{ targets: [0], visible: false},
			{ targets: [1], visible: false},
			{ targets: [2], visible: false},
		]
		
    });
	
	// $("#table_proyek tbody").on('click','#lanjut_proses',function(){
		 // // get the current row
		
		// var currentRow=$(this).closest("tr"); 
         
        // var proyek_id 		= currentRow.find("td:eq(1)").text(); // get current row 1st TD value
        // var investor_id 	= currentRow.find("td:eq(2)").text(); // get current row 2nd TD
        // var proyek_nama		= currentRow.find("td:eq(3)").text(); // get current row 3rd TD
        // var proyek_qty		= currentRow.find("td:eq(4)").text(); // get current row 3rd TD
        // var proyek_total	= currentRow.find("td:eq(5)").text(); // get current row 3rd TD
         
         // alert(proyek_id);
    // });
	
	
	

    // $('#table_proyek tbody').on('click','#btnConfirm', function(){
        // var id = $(this).data("id");
        // var proyek = $(this).data("proyek");
        // $.ajax({
          // type: "POST",
          // url: '/user/ProyekDetail/',
          // dataType: 'JSON',
          // dataSrc:'',
          // data:{"_token": "{{ csrf_token() }}","id" : id,"proyek": proyek},
          // success: function(data){
            // var nama_proyek = data[0].nama;
            // var dana_dibutuhkan = data[0].total_need;
            // var periode = data[0].tenor_waktu;
            // var imbal_hasil = data[0].profit_margin;
            // var minimum_pendanaan = data[0].harga_paket;
            // var jenis_akad = data[0].akad;
            // var terima_imbal_hasil = data[0].waktu_bagi;
            // var jumlah_paket = data[0].qty;
            // var total_bayar = data[0].total_price;
            // var idProyek  = data[0].proyek_id;
            // var idInvestor  = data[0].investor_id;
            // var id  = data[0].kode;

            // //var jenis_akad;
            // if(data[0].akad == 1){
              // var jenis_akad = 'Murabahah';
            // }
            // else if(data[0].akad == 2){
              // var jenis_akad = 'Mudharabah';
            // }
            
            // //var terima_imbal_hasil;
            // if(data[0].waktu_bagi == 1){
              // var terima_imbal_hasil = 'Tiap Bulan';
            // }
            // else if(data[0].waktu_bagi == 2){
              // var terima_imbal_hasil = 'Akhir Proyek';
            // }

            // $("#txt_id").val(id);
            // $("#txt_idInvestor").val(idInvestor);
            // $("#txt_idProyek").val(idProyek);
            // $("#txt_qty").val(jumlah_paket);
            // $("#txt_harga_paket").val(minimum_pendanaan);
            // $("#txt_total_qty").val(total_bayar);
            // $("#txt_title").html("<b>"+nama_proyek+"</b>");
            // $("#txt_dana_dbutuhkan").html("<b>"+formatNumber(parseInt(dana_dibutuhkan))+"</b>");
            // $("#txt_periode").html("<b>"+periode+" Bulan</b>");
            // $("#txt_imbal_hasil").html("<b>"+imbal_hasil+" %</b>");
            // $("#txt_minum_pendanaan").html("<b>"+formatNumber(parseInt(minimum_pendanaan))+"</b>");
            // $("#txt_jenis_akad").html("<b>"+jenis_akad+"</b>");
            // $("#txt_terima_imbal_hasil").html("<b>"+terima_imbal_hasil+"</b>");
            // $("#txt_total").html("<b>"+formatNumber(parseInt(total_bayar))+"</b>");
            // $('#modal_confirm_invest').modal('show');
          // }
      // });
    // });

    $('#table_proyek tbody').on('click','#btnEdit', function(){
		var id = $(this).data("id");
		var proyek = $(this).data("proyek");
		//alert(total);die;
		$.ajax({
			type: "POST",
			url: '/user/ProyekDetail/',
			dataType: 'JSON',
			dataSrc:'',
			data:{"_token": "{{ csrf_token() }}","id" : id,"proyek": proyek},
			success: function(data){
				var qty = data[0].qty;
				var total = data[0].total_price;
				var harga = data[0].harga_paket;
				var id = data[0].kode;

				$("#jumlah_paket").val(qty);
				$("#total_paket").val(total);
				$("#harga_paket").val(harga);
				$("#proyekId").val(id);
				
				$('#modal_edit_invest').modal('show');

			}
		});
    });

    $(document).on('change keyup','.qty', function() {
		var qty =  $("#jumlah_paket").val();
        var harga =  $("#harga_paket").val();
        var summary = parseInt(qty)*parseInt(harga);
        $("#total_paket").val(summary);
        $("#total_invest").val(summary);
	});
	
	// $('#table_proyek tbody').on( 'click', 'tr', function () {
        // if ( $(this).hasClass('selected') ) {
            // $(this).removeClass('selected');
        // }
        // else {
            // TableProyek.$('tr.selected').removeClass('selected');
            // $(this).addClass('selected');
        // }
    // } );
	
	

</script>

@endsection
