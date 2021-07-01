@extends('layouts.user.sidebar')

@section('title', 'Pilih Pendanaan')

@section('content')
<style>
	.dataTables_paginate { 
	   float: right; 
	   text-align: right; 
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

<div id="overlay">
  <div class="cv-spinner">
      <span class="spinner"></span>
  </div>
  </div>
  <div class="row">
	{{-- 
	@if (session('error'))
    <div class="alert alert-success col-sm-12">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
	@endif
	 --}}
  
	@if(session()->has('msg_success'))
		<div class="alert alert-success" id="sts_sukses_invest">
			{{ session()->get('msg_success') }}
		</div>
	@elseif(session()->has('msg_error'))
		<div class="alert alert-danger" id="sts_error_invest">
			{{ session()->get('msg_error') }}
		</div>
	@endif
		<div class="col-sm-12">
			<h2>Pendanaan</h2>
		</div>
  </div>
  <hr>
  <div class="if_container">
    <div class="if_table table-responsive-sm">
      <table class="table table-sm table-bordered border-0 display" id="paginated" width="100%">
        <thead>
          <th>Status</th>
          <th>Proyek</th>
          <th>Bagi Hasil</th>
          <th>Harga Paket</th>
          <th>Terkumpul</th>
          <th>Sisa Waktu</th>
		  <th>Dana Dibutuhkan</th>
          <th>Periode</th>
          <th>Jenis Akad</th>
          <th>Imbal Hasil</th>
		  <th>ID Proyek</th>

        </thead>
        <tbody>
          @foreach($proyek as $proyek)
	          <tr id="id_{{$proyek->id}}" data-toggle='collapse' data-target="#collapse_id{{$proyek->id}}" class="table-success align-middle show_details" data-value="{{$proyek->id}}">
	            <td class="text-center"><i class="fas fa-check-circle fa-lg"></i><br><small>Penggalangan</small></td>

	            <td class="align-middle">{{ $proyek->nama }}</td>
	            <td class="align-middle">{{ $proyek->profit_margin }}%</td>
	            <td class="align-middle" data-val="{{$proyek->harga_paket}}">Rp. {{ isset($proyek->harga_paket)?number_format($proyek->harga_paket,  0, '', '.'):0 }}</td>
	            @if($proyek->total_need > 0)
	                <td class="align-middle">{{number_format(($proyek->terkumpul+$proyek->pendanaanAktif->where('proyek_id',$proyek->id)->where('status', 1)->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '')}} %</td>
	            @else
	                <td class="align-middle">0.00 %</td>
	            @endif
	            <td class="align-middle">{!! date_diff(date_create(Carbon\Carbon::now()->format('Y-m-d')),date_create(Carbon\Carbon::parse($proyek->tgl_selesai_penggalangan)->format('Y-m-d')))->format('%d')!!} hari</td>
				<td class="align-middle">{{ number_format($proyek->total_need,  0, '', '.')}}</td>
				<td class="align-middle">{{ $proyek->tenor_waktu }}</td>
				<td class="align-middle">{{ $proyek->akad }}</td>
				<td class="align-middle">{{ $proyek->waktu_bagi }}</td>
				<td>{{ $proyek->id }}</td>
	          </tr>
          @endforeach


        </tbody>
      </table>
    </div>

    <div class="if_sidebar my-3">
      <div class="if_top mb-3">
        <div class="card border-primary">
          <div class="card-body">
            Tersedia <br> Rp. {{!empty($total) ? number_format($total->unallocated,2, '.', ',') : '0'}}
          </div>
        </div>
      </div>
      <div class="if_filter">
        <div class="card border-primary">
          <div class="card-header filter_header">
            <span style="font-style: italic;">Filter</span>
          </div>
          <div class="card-body p-2">
            <div class="form-group">
              <label for="filter1">Cari Proyek</label>
              <div class="form-group row">
                <div class="col-12">
                  <input type="text" name="cari_proyek" id="cari_proyek" class="form-control form-control-sm">
                  <span class="if_filter_clear">&times;</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Rentang Harga</label><br>
              <div class="form-group row my-0">
                <label for="min" class="col-3 col-form-label text-nowrap">Min </label>
                <div class="col-9">
                  <input type="text" id="min" name="min" class="form-control form-control-sm">
                  <span class="if_filter_clear">&times;</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="max" class="col-3 col-form-label text-nowrap">Maks &nbsp;</label>
                <div class="col-9">
                  <input type="text" id="max" name="max" class="form-control form-control-sm">
                  <span class="if_filter_clear">&times;</span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="">Jumlah Baris</label>
              <select class="form-control form-control-sm" id="table_length">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
              </select>
            </div>
			
			<!--

            <div class="form-group">
              <label for="">filter#2</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                <label class="form-check-label" for="gridRadios1">
                  First radio
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                <label class="form-check-label" for="gridRadios2">
                  Second radio
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="">filter#3</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck1">
                <label class="form-check-label" for="gridCheck1">
                  Example checkbox 1
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck2">
                <label class="form-check-label" for="gridCheck2">
                  Example checkbox 2
                </label>
              </div>
            </div>
            <div class="form-group">
              <label for="">filter#4</label>
              <select class="form-control form-control-sm">
                <option>Option1</option>
                <option>Option2</option>
                <option>Option3</option>
              </select>
            </div>
            <div class="form-group">
              <label for="formControlRange">filter#5</label>
              <input type="range" class="form-control-range" id="formControlRange">
            </div> -->

          </div>

        </div>
      </div>
    </div>
  </div>
  
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
				{{-- <form method="post" action="{{ route('cart.add') }}" id="form_checkout_invest"> --}}
				<form id="form_checkout_invest">
				{{-- <form method="post" action="{{ route('cart.addSelected') }}" id="form_checkout_invest"> --}}
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
					
					<input type='hidden' id='txt_idProyek' name='txt_idProyek'>
					<input type='hidden' id='txt_qty' name='txt_qty'>
					<input type='hidden' id='txt_total_qty' name='txt_total_qty'>
					
				<div class="col-md-8" style="padding-left:40px;">
					<div class="form-group">
						<button type="button" id='btn_batal_proses' class="btn btn-success btn-sm" data-dismiss="modal">Batal</button>
						<button type="button" id='btn_proses' class="btn btn-success btn-sm">Proses</button>
					</div>
				</div>
            </div>
				</form>
        </div>
    </div>
</div>
  
  {{-- 
  
  @if (session('success'))
  <div id="successModal" class="modal fade" role="dialog" style="opacity: 1 !important;">
    <div class="modal-dialog modal-dialog-centered">

      <div class="modal-content">

        <div class="modal-body text-center">
            <i class="far fa-check-circle fa-5x" style="color:green;"></i>
            <p>Berhasil ditambah ke keranjang pendanaan!</p>
            <hr>
            <p>Ingin Memilih Proyek Lagi?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Tambah Proyek</button>
          <a href="/user/cart" class="btn btn-light btn-sm">Ke Keranjang</a>
        </div>
      </div>

    </div>
  </div>
  @endif
   --}}
   

  <script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/dataTables.buttons.min.js"></script>


   
<!-- start modal no telp -->
<div class="modal fade" id="modal_konfirm_photo" tabindex="1" role="dialog" data-show="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Maaf anda belum mengunggah photo anda : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('user.konfirm.telp')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
				
                
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_upload" class="btn btn-primary">Unggah Sekarang</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal no telp -->

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
 {{-- Modal TTD End --}}

{{-- Modal Akad Murobahah --}}
<div id="modalAkadMurobahah"  class="modal fade show" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Akad Murobahah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="agree">
            @csrf
                <div class="modal-body" id="modalBodyMurobahah">
                	<input type='hidden' id='idProyek' name='idProyek'>
                    {{-- <iframe src="{{ url('perjanjian') }}" scrolling="yes" width="100%" height="500" id="iprem"></iframe> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="setujuMurobahah">Saya Setuju</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal SP3 End --}}
  
	<script>
		
		function format (id ) {
			// `d` is the original data object for the row
			 return  "<div id='divInvest'>" +
            '<div class="card text-right card_manage_investation m-2">' +
							'<div class="card-body">' +
								//'<form action="{{ route('cart.add') }}"  method="POST" id="formInvest">' +
									// '{{csrf_field()}}' +
									'<input type="hidden" id="proyekid" name="proyekid" value="' +id+'">' +
									'<div class="form-group row w-75 mx-auto">' +
										'<label for="qty" class="col-4">Jumlah paket : &nbsp;</label>' +
                    '<div class="col-8">' +
                      '<input name="qty" id="qty" type="number" min="1" class="form-control qty" autofocus>' +
                    '</div>' +

									'</div>' +
									'<div class="form-group row w-75 mx-auto">' +
										'<label for="total" class="col-4">Total : &nbsp;</label>' +
                    '<div class="col-8">' +
                      '<input type="text" id="total" disabled name="total" class="form-control total">' +
                      '<input type="hidden" id="totalInvest" name="totalInvest" class="form-control total">' +
                    '</div>' +
                  '</div><hr>' +
				  
				// master
				'<button disabled class="btn btn-submit d-block mx-auto" id="btnConfirm" onclick="openModal()" type="button">Danai Sekarang</button>' +
				'</div> </div></div>';

				// Request OJK
				// '<button disabled class="btn btn-submit d-block mx-auto" id="btnConfirm" onclick="openModal()" type="button">Pilih Proyek</button>' +
				// '</div> </div></div>'
             
			 //"</div>";
		}
		
		
		//$(document).ready(function(){
			
			
			var totalInvest;
			
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			var table = $('#paginated').DataTable({
				
				"dom": 'tip',
				"bSort": false,
				//"lengthChange" : false,
				//"ordering": false,
				//"info":     false
				
				"columnDefs": [{
					"targets": 0
				},{
					"targets": 1
				},{
					"targets": 2
				},{
					"targets": 3
				},{
					"targets": 4
				},{
					"targets": 5
				},{
					"targets": 6,
					"visible": false
				},{
					"targets": 7,
					"visible": false
				},{
					"targets": 8,
					"visible": false
				},{
					"targets": 9,
					"visible": false 
				},{
					"targets": 10,
					"visible": false 
				}]
			});
			
			$('#paginated tbody').on( 'click', 'tr', function (event) {
				
				
				var tr = $(this).closest('tr');
				var row = table.row( tr );
				var length = table.rows('tr.selected').data().length;
				var data = table.row($(this).closest('tr')).data();
				var id = $(event.target).parent().data('value');
				
				if ( $(this).hasClass('selected') ) {
					
					$(this).removeClass('selected');
					row.child.hide();
					tr.removeClass('shown');
				}
				
				else {
					
					table.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
					row.child( format(id) ).show();
					tr.addClass('shown');
					
					$("#txt_idProyek").val(data[10]);
					$("#txt_title").html("<b> Nama Proyek : "+data[1]+"</b>");
					$("#txt_dana_dbutuhkan").html("<b>"+data[6]+"</b>");
					$("#txt_periode").html("<b>"+data[7]+" bulan </b>");
					$("#txt_imbal_hasil").html("<b>"+data[2]+"</b>");
					$("#txt_minum_pendanaan").html("<b>"+data[3]+"</b>");
					
					var txtAkad;
					if(data[8] == 1){
						txtAkad = 'Murabahah';
					}
					else if(data[8] == 2){
						txtAkad = 'Mudharabah';
					}
					
					var txtImbalHasil;
					if(data[9] == 1){
						txtImbalHasil = 'Tiap Bulan';
					}
					else if(data[9] == 2){
						txtImbalHasil = 'Akhir Proyek';
					}
					
					$("#txt_jenis_akad").html("<b>"+txtAkad+"</b>");
					$("#txt_terima_imbal_hasil").html("<b>"+txtImbalHasil+"</b>");
					$("#idProyek").val(data[10]);
					
				}  
			});
			
			$('#cari_proyek').on('keyup',function(){
				table.search($(this).val()).draw();
			});

			$('#min, #max').keyup( function() {
				table.draw();
			});

			$('#table_length').change(function() {
				table.page.len( $(this).val() ).draw();
			})

			$('.if_filter_clear').click(function() {
				$(this).prev('input').val("");
				table.search("").draw();
			})
			
			function is_alphaDash(str)
			{
			 	regexp = /-/g;
			  
		        if (regexp.test(str))
		          {
		            return true;
		          }
		        else
		          {
		            return false;
		          }
			}
			
			$(document).on('change keyup','.qty', function() {
			// $('.qty').keyup(function() {
				var jumlah = parseInt($(this).val());
				var harga = 1000000;
				
				$('#txt_qty').val();
				$('#txt_total_qty').val();
				
				if (isNaN(jumlah) || jumlah == 0) {
				  $(this).closest('#divInvest').find('#total').val("");
				  $(this).closest('#divInvest').find('button').attr('disabled', true);
				}
				else {
					console.log(is_alphaDash(jumlah));
					if (is_alphaDash(jumlah) == true)
					{
						$(this).closest('#divInvest').find('#totalInvest').val();
						$(this).closest('#divInvest').find('button').attr('disabled', true);
					}
					else
					{
						var total = jumlah*harga;
						totalInvest = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						$(this).closest('#divInvest').find('#total').val(totalInvest);
						$(this).closest('#divInvest').find('#totalInvest').val(totalInvest);
						$(this).closest('#divInvest').find('button').attr('disabled', false);
					}
					
					$('#txt_qty').val($(this).val());
					$('#txt_total_qty').val(totalInvest);
					
				}

			});

			// --------------- PROSES SEBELOM OJK -----------------
			$("#btn_proses").one("click", function(){
				$('#modal_confirm_invest').modal('hide')
		        var id_proyek = $("#idProyek").val();
		        var user_id = {{ Auth::user()->id }};
		        $.ajax({
		          url:'/user/createDocInvestorBorrower/'+user_id+'/'+id_proyek,
		          method:'get',
		          beforeSend: function(jqXHR,settings) {
			          $("#overlay").css('display','block');
			      },
		          success: function (response) {
		          		$('#overlay').css('display','none')
		                if (response.status == 'Berhasil')
		                {
		                    $('#modalAkadMurobahah').modal('show')
		                    $('.modal-backdrop').addClass('modal-backdrop fade show in')
		                    $('#modalBodyMurobahah').append('<iframe id="linkMurobahah" scrolling="yes" width="100%" height="500" id="iprem"></iframe>');
		                    $('#linkMurobahah').attr('src',"{{ url('viewMurobahah') }}/"+user_id)
		                }
		                else
		                {
		                    alert(response.status)
		                }

		          },
		          error: function(request, status, error)
		          {
		              $('#overlay').css('display','none')
		              alert(status)
		          }
		        });
				// $("#form_checkout_invest").submit();
				// $(this).attr("disabled", "disabled");
			})
			//  --------------- FINISH -----------------

			$('#setujuMurobahah').one('click',function(){
		        $('#form_checkout_invest').attr('method','post').attr('action','{{ route('cart.add') }}');
		        $("#form_checkout_invest").submit();
		        // location.reload(true)
		    })
				
			$(document).on('click','#btnConfirm', function() {
				// $.ajax({

				// 	type:'GET',
				// 	url:'/user/check_photo/',
				// 	success:function(data){
				// 		if(data.pic_investor == "" || data.pic_investor == null){
				// 			//$('#modal_konfirm_photo').modal('show');
				// 			var r = confirm("Maaf, Anda Belum Melengkapi Poto Anda, Klik Ok untuk melengkapi poto anda");
				// 			if (r == true) {
				// 				location.href = "../user/manage_profile"; 
				// 			} else {
								
				// 			}
							 
				// 		}
				// 		else if(data.pic_ktp_investor == "" || data.pic_ktp_investor == null){
				// 			var r = confirm("Maaf, Anda Belum Melengkapi Poto Anda, Klik Ok untuk melengkapi poto anda");
				// 			if (r == true) {
				// 				location.href = "../user/manage_profile"; 
				// 			} else {
								
				// 			}
							
				// 		}
				// 		else if(data.pic_user_ktp_investor == "" || data.pic_user_ktp_investor == null){
				// 			var r = confirm("Maaf, Anda Belum Melengkapi Poto Anda, Klik Ok untuk melengkapi poto anda");
				// 			if (r == true) {
				// 				location.href = "../user/manage_profile"; 
				// 			} else {
								
				// 			}
							
				// 		}
				// 		else{
				// 			$('#modal_confirm_invest').modal('show');
				// 			$("#txt_total").html("<b></b>"); // set null total bayar
							
				// 			var data = table.row().data();
				// 			var name = $('#divInvest').find('#totalInvest').val();
							
				// 			$("#txt_total").html("<b>"+name+"</b>"); 
				// 		}
				// 		//$("#DivLegalitas").html(data[0]['deskripsi_legalitas']);
				// 	}
				// });
					
				
				$('#modal_confirm_invest').modal('show');
				$("#txt_total").html("<b></b>"); // set null total bayar
				
				var data = table.row().data();
				var name = $('#divInvest').find('#totalInvest').val();
				
				$("#txt_total").html("<b>"+name+"</b>"); 
				
				
			});
			
		//});
		
		function openModal(){
			$('#modal_konfirm_photo').modal();
		}  

	/********************* 	
		REQUEST OJK 
		check akad wakalah dan ttd kontrak proyek
	*********************/

	// $(document).on("click", "#btn_proses", function(){
		
	// 	var txt_total 		= $("#txt_total").text();
	// 	var txt_proyek_id 	= $("#txt_idProyek").val();
	// 	var qty 			= $('#txt_qty').val();
	// 	var id_user 		= {{ Auth::user()->id }};

	// 	$('#modal_confirm_invest').modal('hide')

	// 		$.ajax({
	// 			url:'/user/checkStatusUser/'+txt_proyek_id+'/'+qty,
	// 			method:'get',
	// 			dataType:'json',
	// 			beforeSend: function() {
	// 						$("#overlay").css('display','block');
	// 						swal.close()
	// 					},
	// 			success:function(data){
	// 				if(data.status=='sudah_ttd'){
	// 					$.ajax({
	// 						url:'/user/checkStatusUserInvest/'+txt_proyek_id+'/'+qty,
	// 						method:'get',
	// 						dataType:'json',
	// 						beforeSend: function() {
	// 									$("#overlay").css('display','block');
	// 									swal.close()
	// 								},
	// 						success:function(data){
	// 							console.log(data);
	// 							if(data.status == 'gagal_dana'){
	// 								swal("Gagal", data.keterangan, "error");
	// 								$("#overlay").css('display','none');
	// 							}else if(data.status == 'belum_ttd'){
	// 								swal("Gagal", data.keterangan, "error");
	// 								$("#overlay").css('display','none');
	// 							}else if(data.status == 'lanjut_pendanaan'){
	// 								$.ajax({
	// 									url: '/user/add_pendanaan_new/',
	// 									method : "post",
	// 									data : {"id_proyek":txt_proyek_id, "qty":qty, "investor_id":id_user},
	// 									beforeSend: function(jqXHR,settings) {
	// 										$("#overlay").css('display','block');
	// 									},
	// 									success:function(data)
	// 									{
	// 										$('#overlay').css('display','none')
	// 										console.log(data);
	// 										if(data.status == 'success'){
	// 											swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 											function(){
	// 												location.reload();
	// 											}
	// 										);
	// 										}else{
	// 											swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 											function(){
	// 												location.reload();
	// 											}
	// 										);
	// 										}
	// 									}
	// 								})
	// 							}else{
	// 								swal("Gagal", data.keterangan, "error");
	// 								$("#overlay").css('display','none');
	// 							}
	// 						}
	// 					})
	// 				}else{
	// 					$.ajax({
	// 						url:'/user/regDigiSign/'+id_user,
	// 						method:'get',
	// 						dataType:'json',
	// 					beforeSend: function() {
	// 						$("#overlay").css('display','block');
	// 						swal.close()
	// 					},
	// 					success:function(data)
	// 					{
	// 						$("#overlay").css('display','none');
	// 						var dataJSON = JSON.parse(data.status_all);
	// 						console.log(dataJSON + "regDigisign");
	// 						if (dataJSON.JSONFile.result == '00')
	// 						{
	// 							if (dataJSON.JSONFile.info)
	// 							{
	// 								var url_notif = dataJSON.JSONFile.info.split('https://')[1];
	// 								$.ajax({
	// 									url : "/user/callbackDigiSignInvestor/",
	// 									method : "post",
	// 									data : {user_id:id_user,provider_id:1,status:dataJSON.JSONFile.notif,step:'register',url:url_notif},
	// 									success:function(data)
	// 									{
	// 										console.log(data.status + "callbackDigiSignInvestor");
	// 										var email = "{{ Auth::user()->email }}"
	// 										$.ajax({
	// 											url : "/user/actDigiSign/"+email,
	// 											method : "get",
	// 											success:function(data)
	// 											{
	// 												var dataJSON2 = JSON.parse(data.status_all);
	// 												console.log(dataJSON2 + "actDigiSign");
	// 												if (dataJSON2.JSONFile.result == '00')
	// 												{
	// 													$('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
	// 													$('.modal-backdrop').addClass('modal-backdrop fade show in')
	// 													$('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
	// 													$('#linkAktivasi').attr('src',dataJSON2.JSONFile.link);
	// 													$("#modalAktivasi").appendTo('body');
	// 													$('#linkAktivasi').load(function(){
	// 														var myFrame = $("#linkAktivasi").contents().find('body').text();
	// 														console.log(myFrame)
	// 														if (myFrame == 'Sukses')
	// 														{
	// 															$('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
	// 															$('.modal-backdrop').remove()
	// 															// location.reload(true);
	// 															$.ajax({
	// 																url : "/borrower/sendDigiSignMurobahahBorrower/"+txt_proyek_id+'/'+id_user,
	// 																method : "get",
	// 																beforeSend: function() {
	// 																	$("#overlay").css('display','block');
	// 																},
	// 																success:function(data)
	// 																{
	// 																	$("#overlay").css('display','none');
	// 																	var dataJSON = JSON.parse(data.status_all);
	// 																	if (dataJSON.JSONFile.result == '00')
	// 																	{
	// 																		$.ajax({
	// 																			url:'/user/signDigiSignMurobahah/'+id_user+'/'+txt_proyek_id,
	// 																			method:'get',
	// 																			dataType:'json',
	// 																			beforeSend: function() {
	// 																				$("#overlay").css('display','block');
	// 																				swal.close()
	// 																			},
	// 																			success:function(data)
	// 																			{
	// 																				$("#overlay").css('display','none');
	// 																				var dataJSON = JSON.parse(data.status_all);
	// 																				console.log(dataJSON);
	// 																				if (dataJSON.JSONFile.result == '00')
	// 																				{
	// 																					$('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
	// 																					$('.modal-backdrop').addClass('modal-backdrop fade show in')
	// 																					$('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
	// 																					$('#linkTTD').attr('src',dataJSON.JSONFile.link)
	// 																					$("#modalTTD").appendTo('body');
	// 																					$('#linkTTD').load(function(){
	// 																						var myFrame = $("#linkTTD").contents().find('body').text();
	// 																						console.log(myFrame)
	// 																						if (myFrame == 'Sukses')
	// 																							{
	// 																								$.ajax({
	// 																									url:'/user/checkStatusUserInvest/'+txt_proyek_id+'/'+qty,
	// 																									method:'get',
	// 																									dataType:'json',
	// 																									beforeSend: function() {
	// 																												$("#overlay").css('display','block');
	// 																												swal.close()
	// 																											},
	// 																									success:function(data){
	// 																										console.log(data);
	// 																										if(data.status == 'gagal_dana'){
	// 																											swal("Gagal", data.keterangan, "error");
	// 																											$("#overlay").css('display','none');
	// 																										}else if(data.status == 'belum_ttd'){
	// 																											swal("Gagal", data.keterangan, "error");
	// 																											$("#overlay").css('display','none');
	// 																										}else if(data.status == 'lanjut_pendanaan'){
	// 																											$.ajax({
	// 																												url: '/user/add_pendanaan_new/',
	// 																												method : "post",
	// 																												data : {"id_proyek":txt_proyek_id, "qty":qty, "investor_id":id_user},
	// 																												beforeSend: function(jqXHR,settings) {
	// 																													$("#overlay").css('display','block');
	// 																												},
	// 																												success:function(data)
	// 																												{
	// 																													$('#overlay').css('display','none')
	// 																													console.log(data);
	// 																													if(data.status == 'success'){
	// 																														swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 																														function(){
	// 																															location.reload();
	// 																														}
	// 																													);
	// 																													}else{
	// 																														swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 																														function(){
	// 																															location.reload();
	// 																														}
	// 																													);
	// 																													}
	// 																												}
	// 																											})
	// 																										}else{
	// 																											swal("Gagal", data.keterangan, "error");
	// 																											$("#overlay").css('display','none');
	// 																										}
	// 																									}
	// 																								})
	// 																								$('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
	// 																								$('.modal-backdrop').remove()
	// 																								// location.reload(true);
	// 																							}else{
	// 																								swal({title:"Notifikasi",text:'Pendanaan Gagal, Silahkan dicoba beberapa saat lagi',type:"info"}
	// 																								);
	// 																							}
	// 																					})
	// 																				}
	// 																				else
	// 																				{
	// 																					swal({title:"Notifikasi",text:'TTD Gagal',type:"info"},
	// 																						function(){
	// 																							swal.close()
	// 																						}
	// 																					);
	// 																				}
	// 																			},
	// 																			error: function(request, status, error)
	// 																			{
	// 																				$("#overlay").css('display','none');
	// 																				alert(status)
	// 																			}
	// 																		})
	// 																	}
	// 																	else
	// 																	{
	// 																		swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
	// 																			function(){
	// 																				investorTable.ajax.reload();
	// 																			}
	// 																		);
	// 																	}
																		
	// 																},
	// 																error: function(request, status, error)
	// 																{
	// 																	$("#overlay").css('display','none');
	// 																	alert(status)
	// 																} 
	// 															});
	// 														}else{
	// 															swal({title:"Notifikasi",text:'Proses Aktivasi Gagal',type:"info"}
	// 															);
	// 														}
	// 													})
														
	// 												}
	// 												else
	// 												{
	// 													swal({title:"Notifikasi",text:'Aktivasi Gagal',type:"info"},
	// 													function(){
	// 															swal.close()
	// 													}
	// 													);
	// 												}
	// 											},
	// 											error: function(request, status, error)
	// 											{
	// 												// $("#overlay").css('display','none');
	// 												alert(status)
	// 											}
	// 										});
	// 									},
	// 									error: function(request, status, error)
	// 									{
	// 										// $("#overlay").css('display','none');
	// 										alert(status)
	// 									}
	// 								});
	// 							}
	// 							else if(dataJSON.JSONFile.notif == 'Anda sudah terdaftar sebelumnya, silahkan gunakan layanan Digisign')
	// 							{
	// 								swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
	// 											function(){
	// 												swal.close()
	// 												var id_user = {{ Auth::user()->id }}
	// 													id_proyek = $('#txt_idProyek').val()
	// 												$.ajax({
	// 													url : "/borrower/sendDigiSignMurobahahBorrower/"+txt_proyek_id+'/'+id_user,
	// 													method : "get",
	// 													beforeSend: function() {
	// 														$("#overlay").css('display','block');
	// 													},
	// 													success:function(data)
	// 													{
	// 														$("#overlay").css('display','none');
	// 														var dataJSON = JSON.parse(data.status_all);
	// 														if (dataJSON.JSONFile.result == '00')
	// 														{
	// 															$.ajax({
	// 																url:'/user/signDigiSignMurobahah/'+id_user+'/'+txt_proyek_id,
	// 																method:'get',
	// 																dataType:'json',
	// 																beforeSend: function() {
	// 																	$("#overlay").css('display','block');
	// 																	swal.close()
	// 																},
	// 																success:function(data)
	// 																{
	// 																	$("#overlay").css('display','none');
	// 																	var dataJSON = JSON.parse(data.status_all);
	// 																	console.log(dataJSON);
	// 																	if (dataJSON.JSONFile.result == '00')
	// 																	{
	// 																		$('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
	// 																		$('.modal-backdrop').addClass('modal-backdrop fade show in')
	// 																		$('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
	// 																		$('#linkTTD').attr('src',dataJSON.JSONFile.link)
	// 																		$("#modalTTD").appendTo('body');
	// 																		$('#linkTTD').load(function(){
	// 																			var myFrame = $("#linkTTD").contents().find('body').text();
	// 																			console.log(myFrame)
	// 																			if (myFrame == 'Sukses')
	// 																				{
	// 																					$.ajax({
	// 																						url:'/user/checkStatusUserInvest/'+txt_proyek_id+'/'+qty,
	// 																						method:'get',
	// 																						dataType:'json',
	// 																						beforeSend: function() {
	// 																									$("#overlay").css('display','block');
	// 																									swal.close()
	// 																								},
	// 																						success:function(data){
	// 																							console.log(data);
	// 																							if(data.status == 'gagal_dana'){
	// 																								swal("Gagal", data.keterangan, "error");
	// 																								$("#overlay").css('display','none');
	// 																							}else if(data.status == 'belum_ttd'){
	// 																								swal("Gagal", data.keterangan, "error");
	// 																								$("#overlay").css('display','none');
	// 																							}else if(data.status == 'lanjut_pendanaan'){
	// 																								$.ajax({
	// 																									url: '/user/add_pendanaan_new/',
	// 																									method : "post",
	// 																									data : {"id_proyek":txt_proyek_id, "qty":qty, "investor_id":id_user},
	// 																									beforeSend: function(jqXHR,settings) {
	// 																										$("#overlay").css('display','block');
	// 																									},
	// 																									success:function(data)
	// 																									{
	// 																										$('#overlay').css('display','none')
	// 																										console.log(data);
	// 																										if(data.status == 'success'){
	// 																											swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 																											function(){
	// 																												location.reload();
	// 																											}
	// 																										);
	// 																										}else{
	// 																											swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 																											function(){
	// 																												location.reload();
	// 																											}
	// 																										);
	// 																										}
	// 																									}
	// 																								})
	// 																							}else{
	// 																								swal("Gagal", data.keterangan, "error");
	// 																								$("#overlay").css('display','none');
	// 																							}
	// 																						}
	// 																					})
	// 																					$('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
	// 																					$('.modal-backdrop').remove()
	// 																					// location.reload(true);
	// 																				}else{
	// 																					swal({title:"Notifikasi",text:'Pendanaan Gagal, Silahkan dicoba beberapa saat lagi',type:"info"}
	// 																					);
	// 																				}
	// 																		})
	// 																	}
	// 																	else
	// 																	{
	// 																		swal({title:"Notifikasi",text:'TTD Gagal',type:"info"},
	// 																			function(){
	// 																				swal.close()
	// 																			}
	// 																		);
	// 																	}
	// 																},
	// 																error: function(request, status, error)
	// 																{
	// 																	$("#overlay").css('display','none');
	// 																	alert(status)
	// 																}
	// 															})
	// 														}
	// 														else
	// 														{
	// 															swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
	// 																function(){
	// 																	investorTable.ajax.reload();
	// 																}
	// 															);
	// 														}
															
	// 													},
	// 													error: function(request, status, error)
	// 													{
	// 														$("#overlay").css('display','none');
	// 														alert(status)
	// 													} 
	// 												});
	// 											}
	// 										);
	// 							}	
	// 							else
	// 							{
	// 								$.ajax({
	// 									url:'/user/cekRegDigiSign/'+id_user,
	// 									method:'get',
	// 									dataType:'json',
	// 									beforeSend: function() {
	// 										$("#overlay").css('display','block');
	// 										swal.close()
	// 									},
	// 									success:function(data)
	// 									{
	// 										console.log(data.cekRegDigiSign);
	// 										if(data.cekRegDigiSign == 'belum_aktivasi')
	// 										{
	// 											swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
	// 												function(){
	// 													swal.close()
	// 													var email = "{{ Auth::user()->email }}"
	// 													$.ajax({
	// 														url : "/user/actDigiSign/"+email,
	// 														method : "get",
	// 														success:function(data)
	// 														{
	// 															console.log(data + "actDigiSign 2");
	// 															var dataJSON2 = JSON.parse(data.status_all);
																
	// 															if (dataJSON2.JSONFile.result == '00')
	// 															{
	// 																$('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
	// 																$('.modal-backdrop').addClass('modal-backdrop fade show in')
	// 																$('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
																	
	// 																<!-- PROSES SEND DOCUMENT -->
	// 																	$.ajax({
	// 																		url : "/borrower/sendDigiSignMurobahahBorrower/"+txt_proyek_id+"/"+id_user,
	// 																		method : "get",
	// 																		success:function(data){
	// 																			var dataJSON_document = JSON.parse(data.status_all);
	// 																			if (dataJSON_document.JSONFile.result == '00'){
																					
	// 																				$.ajax({
	// 																				url : "/user/cart/signDigiSignMurobahah/"+id_user+"/"+txt_proyek_id,
	// 																				method : "get",
	// 																				success:function(data){
	// 																					var dataJSON_document = JSON.parse(data.status_all);
	// 																					console.log(dataJSON_document);
	// 																					if (dataJSON_document.JSONFile.result == '00'){
	// 																						link = dataJSON_document.JSONFile.link;
	// 																						console.log(link);
																							
	// 																						$('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
	// 																						$('.modal-backdrop').addClass('modal-backdrop fade show in')
	// 																						$('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
	// 																						$('#linkAktivasi').attr('src',dataJSON_document.JSONFile.link);
	// 																						$("#modalAktivasi").appendTo('body');
	// 																						$('#linkAktivasi').load(function(){
	// 																							var myFrame = $("#linkAktivasi").contents().find('body').text();
	// 																							console.log(myFrame);
	// 																							if (myFrame !== '')
	// 																							{
	// 																								$('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
	// 																								$('.modal-backdrop').remove()
	// 																								location.reload(true);
	// 																							}
	// 																						})
	// 																					}
	// 																				}
																				
																					
	// 																			})
																					
	// 																			}
																				
																				
	// 																		}
																		
																			
	// 																	})
																	
	// 																$('#linkAktivasi').attr('src',dataJSON2.JSONFile.link)
	// 																$("#modalAktivasi").appendTo('body');
	// 																$('#linkAktivasi').load(function(){
	// 																	var myFrame = $("#linkAktivasi").contents().find('body').text();
	// 																	console.log(myFrame)
	// 																	if (myFrame !== '')
	// 																	{
	// 																		$('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
	// 																		$('.modal-backdrop').remove()
	// 																		location.reload(true);
	// 																	}
	// 																})
																	
	// 															}
	// 															else
	// 															{
	// 																swal({title:"Notifikasi",text:'Aktivasi Gagal',type:"info"},
	// 																	function(){
	// 																		swal.close()
	// 																	}
	// 																);
	// 															}
	// 														},
	// 														error: function(request, status, error)
	// 														{
	// 															// $("#overlay").css('display','none');
	// 															alert(status)
	// 														}
	// 													});
	// 												}
	// 											);
	// 										}
	// 										else
	// 										{
	// 											swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
	// 												function(){
	// 													swal.close()
	// 													var id_user = {{ Auth::user()->id }};
	// 													$.ajax({
	// 														url : "/admin/investor/sendDigiSign/"+id_user,
	// 														method : "get",
	// 														beforeSend: function() {
	// 															$("#overlay").css('display','block');
	// 														},
	// 														success:function(data)
	// 														{
	// 															$("#overlay").css('display','none');
	// 															var dataJSON = JSON.parse(data.status_all);
	// 															if (dataJSON.JSONFile.result == '00')
	// 															{
	// 																$.ajax({
	// 																	url:'/user/signDigiSign/'+id_user,
	// 																	method:'get',
	// 																	dataType:'json',
	// 																	beforeSend: function() {
	// 																		$("#overlay").css('display','block');
	// 																		swal.close()
	// 																	},
	// 																	success:function(data)
	// 																	{
	// 																		$("#overlay").css('display','none');
	// 																		var dataJSON = JSON.parse(data.status_all);
	// 																		console.log(dataJSON);
	// 																		if (dataJSON.JSONFile.result == '00')
	// 																		{
	// 																			$('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
	// 																			$('.modal-backdrop').addClass('modal-backdrop fade show in')
	// 																			$('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
	// 																			$('#linkTTD').attr('src',dataJSON.JSONFile.link)
	// 																			$("#modalTTD").appendTo('body');
	// 																			$('#linkTTD').load(function(){
	// 																				var myFrame = $("#linkTTD").contents().find('body').text();
	// 																				console.log(myFrame)
	// 																				if (myFrame == 'Sukses')
	// 																				{
	// 																					$.ajax({
	// 																						url:'/user/checkStatusUserInvest/'+txt_proyek_id+'/'+qty,
	// 																						method:'get',
	// 																						dataType:'json',
	// 																						beforeSend: function() {
	// 																									$("#overlay").css('display','block');
	// 																									swal.close()
	// 																								},
	// 																						success:function(data){
	// 																							console.log(data);
	// 																							if(data.status == 'gagal_dana'){
	// 																								swal("Gagal", data.keterangan, "error");
	// 																								$("#overlay").css('display','none');
	// 																							}else if(data.status == 'belum_ttd'){
	// 																								swal("Gagal", data.keterangan, "error");
	// 																								$("#overlay").css('display','none');
	// 																							}else if(data.status == 'lanjut_pendanaan'){
	// 																								$.ajax({
	// 																									url: '/user/add_pendanaan_new/',
	// 																									method : "post",
	// 																									data : {"id_proyek":txt_proyek_id, "qty":qty, "investor_id":id_user},
	// 																									beforeSend: function(jqXHR,settings) {
	// 																										$("#overlay").css('display','block');
	// 																									},
	// 																									success:function(data)
	// 																									{
	// 																										$('#overlay').css('display','none')
	// 																										console.log(data);
	// 																										if(data.status == 'success'){
	// 																											swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 																											function(){
	// 																												location.reload();
	// 																											}
	// 																										);
	// 																										}else{
	// 																											swal({title:"Notifikasi",text:data.keterangan,type:"info"},
	// 																											function(){
	// 																												location.reload();
	// 																											}
	// 																										);
	// 																										}
	// 																									}
	// 																								})
	// 																							}else{
	// 																								swal("Gagal", data.keterangan, "error");
	// 																								$("#overlay").css('display','none');
	// 																							}
	// 																						}
	// 																					})
	// 																					$('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
	// 																					$('.modal-backdrop').remove()
	// 																					// location.reload(true);
	// 																				}else{
	// 																					swal({title:"Notifikasi",text:'Pendanaan Gagal, Silahkan dicoba beberapa saat lagi',type:"info"}
	// 																					);
	// 																				}
	// 																			})
	// 																		}
	// 																		else
	// 																		{
	// 																			swal({title:"Notifikasi",text:'TTD Gagal',type:"info"},
	// 																				function(){
	// 																					swal.close()
	// 																				}
	// 																			);
	// 																		}
	// 																	},
	// 																	error: function(request, status, error)
	// 																	{
	// 																		$("#overlay").css('display','none');
	// 																		alert(status)
	// 																	}
	// 																})
	// 															}
	// 															else
	// 															{
	// 																swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
	// 																	function(){
	// 																		investorTable.ajax.reload();
	// 																	}
	// 																);
	// 															}
																
	// 														},
	// 														error: function(request, status, error)
	// 														{
	// 															$("#overlay").css('display','none');
	// 															alert(status)
	// 														} 
	// 													});
	// 												}
	// 											);
	// 										}
	// 									}
	// 								})
	// 							}
	// 						}
	// 						else
	// 						{
	// 							swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
	// 								function(){
	// 									swal.close()
	// 								}
	// 							);
	// 						}
	// 					},
	// 					error: function(request, status, error)
	// 					{
	// 						$("#overlay").css('display','none');
	// 						alert(status)
	// 					}
	// 				})
	// 				}
	// 			}
	// 		})
	// });

	//---------------- FINISH REQUEST OJK -------------------- 
	

	</script>
  
 


@endsection

