@extends('layouts.user.sidebar')

@section('title', 'Kelola Paket Pendanaan')
<style>
	.dataTables_paginate { 
	   float: right; 
	   text-align: right; 
	} 

  .modal-xl{
    max-width: 70% !important;
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
  .modal-dialog{
      min-width: 80%;
  }

  .btn-cancel {
      background-color: #C0392B;
      color: #FFFF;
  }
</style>
@section('content')
<div id="overlay">
<div class="cv-spinner">
    <span class="spinner"></span>
</div>
</div>
  <div class="row">
    <div class="col-lg-12">
      <h2>Kelola Paket Pendanaan Saya</h2>
    </div>
  </div>
  <hr>
  @if (session('success'))
    <div class="alert alert-success col-sm-12">
        {{ session('success') }}
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger col-sm-12">
        {{ session('error') }}
    </div>
  @endif
  <div class="row">
    <div class="col-sm-12">
        <div class="col-sm-12 col-lg-12">
          <div class="card text-center card_dashboard" style="background-color: steelblue;">
            <div class="card-body">
              <h5 class="card-title">Dana Tersedia</h5>
              Rp. <span id="dana_tersedia">{{!empty($rekening->unallocated)?number_format($rekening->unallocated,  0, '', '.'):0}}</span>
            </div>
          </div>
        </div>
        <br><br>
        <br><br>
        <br><br>
      <table id="tbl_investation" class="table table-bordered table-hover">
        <thead class="table-success" style="border-bottom: 2px solid grey;">
          <th>id_proyek</th>
          <th>id_pendana</th>
          <th>id_pendanaan</th>
          <th>Harga Paket</th>
          <th>Nama Proyek</th>
          <th>Dana Masuk</th>
          <th>Tanggal Pendanaan</th>
          <th>Tanggal Mulai Proyek</th>
          <th>Sisa Periode</th>
          <th>Detil Imbal Hasil</th>
          {{-- <th>Akad</th> --}}
          <th>Status</th>
          <!-- <th>Berlangganan</th> -->
        </thead>
		<!--
        <tbody class="manage_investation_rows">
          @foreach ($pendanaan as $pendanaan)
            <tr id='id-{{$pendanaan->id}}'  data-target='#collapse_id-{{$pendanaan->id}}' aria-expanded='false' aria-controls='collapse_id-{{$pendanaan->id}}'>
              <td>{{$pendanaan->proyek->id}}</td>
              <td>{{$pendanaan->proyek->nama}}</td>
              <td>Rp. {{number_format($pendanaan->nominal_awal, 0, '', '.')}}</td>
              <td>{{$pendanaan->tanggal_invest->toDateString()}}</td>
              <td>{{ $pendanaan->proyek->tgl_selesai->diffInDays(Carbon\Carbon::now()->toDateString()) }} days</td>
              <td>Rp. {{number_format(($pendanaan->total_dana-$pendanaan->nominal_awal), 0, '', '.')}}</td>
              <!-- <td>
              @if(  empty($pendanaan->subscribe[0]->id) )
                <button class='btn btn-sm btn-outline-info' data-toggle='modal' data-target='#subscribeModal' data-idval='{{$pendanaan->id}}' >Berlangganan</button>
              @else
                <form method="POST" action="/user/unsubscribe_payout">
                @csrf
                  <input type="hidden" value="{{$pendanaan->id}}" name="pendanaanAktif_id">
                  <button class='btn btn-sm btn-outline-warning' type="submit">Unsubscire</button>
                </form>
              @endif
              </td> -->
			
            <!--</tr>-->
			<!--
            <tr class='border-bottom'>
                <td colspan='8' class='p-0'>
                <div class='collapse' id='collapse_id-{{$pendanaan->id}}'>
                  <div class='card text-center card_manage_investation m-2'>
                    <div class='card-body'>
                      {{-- <hr> --}}
                      <div class='row d-flex justify-content-around'>
                        <button type='button' class='btn btn-sm' data-toggle='modal' data-target='#addPackageModal{{$pendanaan->id}}' {{ $pendanaan->proyek->status != 1 ? 'disabled' : '' }}>Tambah</button>
                        <button type='button' class='btn btn-sm' data-toggle='modal' data-target='#ambilDanaModal{{$pendanaan->id}}'>Ambil</button>
                        <a class='btn btn-sm btn-light' href='package_detail/{{$pendanaan->proyek_id}}'>Detil</a>
                      </div>
                    </div>
                  </div>
                  </div>
                </td> 
              </tr>
              <div class="modal fade" id="addPackageModal{{$pendanaan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-body">
                      <form action="{{route('addActive')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id_pendanaan" value="{{$pendanaan->id}}">
                        <input type="hidden" name="id_proyek" value="{{$pendanaan->proyek_id}}">
                        <div class="form-group row">
                          <label for="input_sebesar" class="col-sm-2 col-form-label">Harga Paket</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="Rp. {{number_format($pendanaan->proyek->harga_paket, 0, '', '.')}}" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="input_sebesar" class="col-sm-2 col-form-label">Jumlah Paket</label>
                          <div class="col-sm-10">
                            <input type="number" min="1" id="qty" class="form-control qty" value="" name="qty" data-val="{{$pendanaan->proyek->harga_paket}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="input_sebesar" class="col-sm-2 col-form-label">Total</label>
                          <div class="col-sm-10">
                            <input type="number" class="form-control total" value="" disabled>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-sm btn-primary">Tambah Paket</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="ambilDanaModal{{$pendanaan->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-body">
                        <form action="{{route('ambilActive')}}" method="POST">
                          @csrf
                          <input type="hidden" name="id" value="{{$pendanaan->id}}">
                          <div class="form-group row">
                            <label for="input_sebesar" class="col-sm-2 col-form-label">Harga Paket</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" value="Rp. {{number_format($pendanaan->proyek->harga_paket, 0, '', '.')}}" disabled>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="input_sebesar" class="col-sm-2 col-form-label">Jumlah Paket</label>
                            <div class="col-sm-10">
                              <input type="number" id="qty" class="form-control qty" min="1" name="qty" data-val="{{$pendanaan->proyek->harga_paket}}">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="input_sebesar" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control total" value="" disabled>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Ambil Dana</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
				-->
          <!--@endforeach
        </tbody>-->
      </table>
    </div>
  </div>
  <br><br>
  <div class="row">
    <div class="col-sm-12 d-flex justify-content-end">
      <a href="{{route('investation_feed')}}" class="btn btn-secondary mr-3">Tambah Paket Pendanaan</a>
    </div>
  </div>



<!-- subscribe modal here  -->
<!-- <div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Berlangganan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p style="color:#2D76DF">*Dengan berlangganan maka keuntungan anda akan tertransfer setiap bulan</p>
          <form action="/user/subscribe_payout" method="POST">
            @csrf
            <input type="hidden" name="pendanaan" id="pendanaan">
            <div class="form-group row">
              <label for="nama" class="col-sm-3 col-form-label text-right">Atas Nama (sesuai KTP)</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="noRekBank" value="{{$detil->nama_investor }}" name="pemilik_rekening" disabled required>
              </div>
            </div>
            <div class="form-group row">
                <label for="nama" class="col-sm-3 col-form-label text-right">Bank</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="noRekBank" value="{{$detil->bank }}" name="bank" readonly required>
                </div>
            </div>
            <div class="form-group row">
              <label for="noRekBank" class="col-sm-3 col-form-label text-right">Nomor Rekening Bank</label>
              <div class="col-sm-9">
                <input readonly type="text" class="form-control" id="noRekBank" value="{{$detil->rekening}}" name="rekening" required>
              </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-block btn-info">Subscribe</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</div> -->

<!-- Modal Tambah Dana -->
<div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
	  <div class="modal-content">
		<div class="modal-body">
		  <form action="{{route('addActive')}}" method="POST">
			@csrf
			
			<input type="hidden" name="id_pendanaan" id="txt_tmbh_modal_id_pendanaan">
            <input type="hidden" name="id_proyek" id="txt_tmbh_modal_id_proyek">
			
			<div class="form-group row">
			  <label for="input_sebesar" class="col-sm-2 col-form-label">Harga Paket</label>
			  <div class="col-sm-10">
				<input type="text" class="form-control" id="txt_tmbh_harga_paket" disabled>
			  </div>
			</div>
			<div class="form-group row">
			  <label for="input_sebesar" class="col-sm-2 col-form-label">Jumlah Paket</label>
			  <div class="col-sm-10">
				<input type="number" min="1" id="qty" class="form-control qty" value="" name="qty">
			  </div>
			</div>
			<div class="form-group row">
			  <label for="input_sebesar" class="col-sm-2 col-form-label">Total</label>
			  <div class="col-sm-10">
				<input type="number" class="form-control total" value="" disabled>
			  </div>
			</div>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
		  <button type="submit" class="btn btn-sm btn-primary">Tambah Paket</button>
		</div>
	  </form>
	  </div>
	</div>
  </div>
  
<!-- Modal Ambil Dana -->
<div class="modal fade" id="ambilDanaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-body">
		<form action="{{route('ambilActive')}}" method="POST">
		  @csrf
		  <input type="hidden" name="id" id="id_pendanaan">
		  <div class="form-group row">
			<label for="input_sebesar" class="col-sm-2 col-form-label">Harga Paket</label>
			<div class="col-sm-10">
			  <input type="text" class="form-control" id="hide_txt_harga_paket" name="hide_txt_harga_paket" disabled>
			  <input type="hidden" class="form-control" id="txt_harga_paket" name="txt_harga_paket">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="input_sebesar" class="col-sm-2 col-form-label">Jumlah Paket</label>
			<div class="col-sm-10"> 
			  <input type="number" id="qty" class="form-control qty" min="1" name="qty">
			</div>
		  </div>
		  <div class="form-group row">
			<label for="input_sebesar" class="col-sm-2 col-form-label">Total</label>
			<div class="col-sm-10">
			  <input type="number" class="form-control total" value="" disabled>
			</div>
		  </div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" class="btn btn-sm btn-primary">Ambil Dana</button>
	  </div>
	</form>
	</div>
  </div>
</div>


<div class="modal" tabindex="-1" role="dialog" aria-labelledby="modelDetilImbal" id="modelDetilImbal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Detil Proyek :</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Nama Proyek</th>
                <th scope="col">Margin Keuntungan</th>
                <th scope="col">Tenor</th>
                <th scope="col">Dana Masuk</th>
                <th scope="col">Prospek Hasil Diterima</th>
              </tr>
            </thead>
            <tbody id="headFieldTable">
              <tr>
                <th id="namaProyek"></th>
                <td id="profitProyek"></td>
                <td id="tenorProyek"></td>
                <td id="danaInvestasi"></td>
                <td id="prospekDiterima"></td>
              </tr>
            </tbody>
          </table>
          <hr class="hr-sm">
          <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Bulan</th>
                  <th scope="col">Tanggal Imbal Hasil</th>
                  <th scope="col">Nominal Imbal Hasil</th>
                  <th scope="col">Status Imbal Hasil</th>
                  <th scope="col">keterangan</th>
                </tr>
              </thead>
              <tbody id='urutan'>
              </tbody>
            </table>
      </div>
    </div>
  </div>
</div>


<link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />
<script src="{{asset('js/sweetalert.js')}}"></script>
<script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script>
	function format (pendanaan_id, id, status) {
		var status;
		
		if(status != 1){
			status = "disabled";
		}else{
			status = "";
		}
		
		return  "<div id='divInvest'>" +
		'<div class="card text-right card_manage_investation m-2">' +
			'<div class="card-body">' +
				//'<form action="{{ route('cart.add') }}"  method="POST" id="formInvest">' +
				//'<input type="hidden" id="txt_proyek_id" name="txt_proyek_id" value="' +pendanaan_id+'">' +
				'<input type="hidden" id="txt_proyek_id" name="txt_proyek_id" value="' +id+'">' +
				
				'<div class="form-group row w-75 mx-auto">' +
					'<button class="btn btn-submit d-block mx-auto" data-toggle="modal" id="btn_tambah" data-target="#addPackageModal" type="button" '+status+'>Tambah</button>' +
					'<button class="btn btn-submit d-block mx-auto" data-toggle="modal" data-target="#ambilDanaModal" onclick="func_ambil_dana('+pendanaan_id+')" type="button">Ambil</button>' +
					'<button class="btn btn-submit d-block mx-auto" id="btn_detail" type="button">Detail</button>' +
				'</div>' +	
			'</div> </div></div>';
		
		
	}
	
	function func_ambil_dana(id){
		
		$('#ambilDanaModal').on('show.bs.modal', function(e) {
			// null
			
		});
	}
	
  $(function() {

    $('#subscribeModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var recipient = button.data('idval') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find("#pendanaan").val(recipient);
    })

    $('.manage_investation_rows td').click(function(e) {
        if (e.target == this) {
            // $(this).hide();
            $($(this).parent().data('target')).collapse('toggle');
        }
    });

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

    $(".qty").on('change keyup', function() {
		// $('.qty').keyup(function() {
			var jumlah = parseInt($(this).val());
			var harga = 1000000;
			//var harga = $(this).data('val');
			//var harga = parseInt($(this).data('val'));
			//console.log(harga);


      if (isNaN(jumlah) || jumlah == 0) {
        $(this).closest('.modal-body').find('.total').val("");
        $(this).closest('.modal-footer').find('button.btn-primary').attr('disabled', true);
      }
      else {
        if (is_alphaDash(jumlah) == true)
        {
            $(this).closest('.modal-body').find('.total').val();
            $(this).closest('.modal-footer').find('button.btn-primary').attr('disabled', true);
        }
        else
        {
            $(this).closest('.modal-body').find('.total').val(jumlah*harga);
            $(this).closest('.modal-footer').find('button.btn-primary').attr('disabled', false);
        }
      }




	})
  });
  
$(document).ready(function(){
	  
		$(document).on("click", "#btn_detail", function(){
			//console.log();
			var proyek_id = $("#txt_proyek_id").val();
			location.href = "package_detail/"+proyek_id+"";
    });
    
    
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    };
		
		/*
		$(document).on("click", "#btn_tambah", function(){
			location.href = "investation_feed";
		});
		*/
		var table_imbal = $('#tbl_investation').DataTable({
			//processing: true,
			//serverSide: false,
			"dom": 'tip',
			"bSort": false,
			
			ajax: {
				url: '/user/list_data_kelola_paket_investasi',
				type: 'get',
			},
			
			"columns" : [
				{ "data" : "id_proyek" },
        { "data" : "id_investor" },
				{ "data" : "id_pendanaan" },
				{ "data" : "Harga Paket" },
				{ "data" : "Nama Proyek" },
				{ "data" : "Dana Masuk" },
				{ "data" : "Tanggal Invest" },
				{ "data" : "Tanggal Mulai" },
				{ "data" : "Sisa Periode" },
				{ "data" : "Bagi Hasil Sudah Diterima" },
        // { "data" : "Akad Murobahah" },
				{ "data" : "status" },
				{ "data" : "profitMargin" },
				{ "data" : "tenorProyek" },
        // { "data" : "statusLog" },
			],
			"columnDefs": [{
  				"targets": 0,
  				class : 'text-center',
  				"visible" : false
  			},
        {
          "targets": 1,
          class : 'text-center',
          "visible" : false
        },
        {
  				"targets": 2,
  				class : 'text-center',
  				// "render": function ( data, type, row, meta ) {
  				// 	return row['Dana Awal'];
  				// }
  				
  				"visible" : false
  			},{
  				"targets": 3,
  				class : 'text-center',
  				"visible" : false
  			},{
  				"targets": 4,
  				class : 'text-center',
  				//"visible" : false
  			},{
  				"targets": 5,
  				class : 'text-center',
  				//"visible" : false
  			},{
  				"targets": 6,
  				class : 'text-center',
  				//"visible" : false
  			},{
  				"targets": 7,
  				class : 'text-center',
  				//"visible" : false
  			},{
  				"targets": 8,
  				class : 'text-center',
  				//"visible" : false
        },
        {
  				"targets": 9,
  				class : 'text-center',
  				"visible" : true,
  				"render": function ( data, type, row, meta ) {
            return '<button type="button" id="btnDetilImbal" data-toggle="modal" data-target="#modelDetilImbal" class="btn btn-primary btn-block">Detil Imbal Hasil</button>';
          }
        },
        // {
        //   "targets": 10,
        //   class : 'text-center',
        //   "visible" : true,
        //   "render": function ( data, type, row, meta ) {
        //     var cekReg = '{{ $cekRegDigiSign }}';

        //     if(cekReg == '')
        //     {
        //         var tombolAkadMurobahah = '<button class="btn sm btn-primary akad-murobahah" id="daftar_akad_murobahah" disabled>Daftar Akad Murobahah</button>';
        //     }
        //     else
        //     {
        //         if (row['statusLog'] != '')
        //         {
        //             if(row['statusLog'] == 'kirim')
        //             {
        //                 var tombolAkadMurobahah = '<button class="btn sm btn-primary akad-murobahah" id="ttd_akad_murobahah" disabled>TTD Akad Murobahah</button>';
        //             }
        //             else
        //             {
        //                 var tombolAkadMurobahah = '<button class="btn sm btn-primary akad-murobahah" id="unduh_akad_murobahah" disabled>Unduh Akad Murobahah</button>';
        //             }
        //         }
        //         else
        //         {
        //             var tombolAkadMurobahah = '<button class="btn sm btn-primary akad-murobahah" id="ttd_akad_murobahah" disabled>TTD Akad Murobahah</button>';
        //         }
        //     }
        //     return (row['status'] == 2 || row['status'] == 3) ? tombolAkadMurobahah : '-';
        //   }
        // },
        {
  				"targets": 10,
  				class : 'text-center',
  				"visible" : false
        },
        {
  				"targets": 11,
  				class : 'text-center',
  				"visible" : false

        },
        {
  				"targets": 12,
  				class : 'text-center',
  				"visible" : false

        },
        // {
        //   "targets": 14,
        //   class : 'text-center',
        //   "visible" : false

        // },
        
			]
    });
    

    $('#tbl_investation tbody').on('click','#btnDetilImbal', function(){
        var data = table_imbal.row( $(this).parents('tr') ).data();
        console.log(data  )
        id = data.id_pendanaan
        id_dana = data['Dana Masuk'] 
        $('#namaProyek').html(data['Nama Proyek'])
        $('#profitProyek').html(data['profitMargin']+'% / Tahun')
        $('#tenorProyek').html(data['tenorProyek']+' Bulan')
        $('#danaInvestasi').html('Rp. '+data['Dana Masuk'])
        $('#urutan').html('')


        $.ajax({
            url: "/user/get_aktif_dana/"+id,
            method: "get",
            success:function(data)
            {
              console.log(data)

                var xx=0;
                // console.log(sum);
                detil_get = data.data;
                prop = data.prop;
                detil = data.item;
                sum = data.datasum;
                if (!$.trim(data.data)){ 
                  $('#headFieldTable').attr('hidden','hidden')
                }
                else
                {
                  $('#headFieldTable').removeAttr('hidden')                  
                }

                var sum_imbal_hasil =  0;
                var i;
                for (i = 0; i < detil_get.length; i++) {
                  sum_imbal_hasil += Number(detil_get[i].imbal_payout);
                }

                var all = parseInt(detil.proposional)+parseInt(detil.sisa_imbal);
                var alli = parseInt(detil.proposional)+parseInt(detil.sisa_imbal);
                var allit = parseInt(detil.proposional)+parseInt(sum_imbal_hasil);
                var allitreal = formatNumber(allit);
                var allitem = allit+parseInt(id_dana);
                var itemreal = formatNumber(parseInt(detil.nominal_awal))
                var dataitem = parseInt(detil.total_dana)+parseInt(detil.sisa_imbal);
                var danapokok = formatNumber(parseInt(detil.total_dana));
                var sisaimbal = formatNumber(parseInt(detil.sisa_imbal));
                var realdataitem = formatNumber(dataitem);
                var marginprofit = detil.sisa_imbal;
                console.log(parseInt(id_dana))

                console.log(detil)
                console.log(detil_get)
                $('#prospekDiterima').html('Rp. '+allitreal)
                //mengambil data untuk proposional
                $("#urutan").append("<tr>");
                $("#urutan").append("<td> Bulan 1</td>");
                $("#urutan").append("<td>Dibayarkan Pada Bulan Pertama</td>");
                $("#urutan").append("<td>Rp. " + formatNumber(parseInt(detil.proposional)) + "</td>");
                    if (prop.status_payout == 1 ){
                        $("#urutan").append("<td> <h5><span class='badge badge-danger'> Proposional Gagal Transfer</span><h5> </td>");
                    }else if (prop.status_payout == 2){
                        $("#urutan").append("<td> <h5><span class='badge badge-success'> Proposional Berhasil Transfer</span><h5> </td>");
                    }else if (prop.status_payout == 3){
                        $("#urutan").append("<td> <h5><span class='badge badge-warning'> Proposional Dalam Proses</span><h5> </td>");
                    }else if (prop.status_payout == 4){
                        $("#urutan").append("<td> <h5><span class='badge badge-success'> Proposional Realokasi</span><h5> </td>");
                    }else{
                        $("#urutan").append("<td> <h5><span class='badge badge-info'> Proposional</span><h5> </td>");
                    }
                $("#urutan").append("</tr>");

                //melooping data bulanan
                var lastkey = detil_get.length-1;
                var lastkey1 = lastkey+1;
                $.each(detil_get,function(index,value){
                    console.log(value.keterangan)
                    xx++
                    if(xx == lastkey){
                      if(marginprofit != 0.00){
                        $("#urutan").append("<hr>");
                        $("#urutan").append("<tr>");
                        $("#urutan").append("<td colspan='2'> Akan dibayarkan setelah masa berakhir Proyek maksimal 7 hari jam kerja </td>");
                        $("#urutan").append("<td>Rp. " + formatNumber(parseInt(value.imbal_payout)) + "</td>");
                        if (value.status_payout == 2){
                          $("#urutan").append("<td> <span class='badge badge-success'>Sisa Imbal Hasil Berhasil di Transfer</span> </td>");
                        }else if (value.status_payout == 4){
                          $("#urutan").append("<td> <span class='badge badge-success'>Sisa Imbal Hasil Berhasil di Realokasi</span> </td>");
                        }else{
                          $("#urutan").append("<td colspan='2'> <h6><span class='badge badge-info'> Sisa Imbal Hasil Akhir </span><h6> </td>");
                        }
                        $("#urutan").append("</tr>");
                      }
                    }else if(xx == lastkey1){
                      $("#urutan").append("<hr>");
                      $("#urutan").append("<tr>");
                      $("#urutan").append("<td colspan='2'> Akan dikembalikan ke dana tersedia setelah masa berakhir proyek maksimal 7 hari jam kerja</td>");
                      $("#urutan").append("<td>Rp. " + formatNumber(parseInt(value.imbal_payout)) + "</td>");
                      if (value.status_payout == 4){
                        $("#urutan").append("<td colspan='2'> <h6><span class='badge badge-success'> Dana Pokok Di Alokasikan ke Dana Tersedia  </span><h6> </td>");
                      }else{
                        $("#urutan").append("<td colspan='2'> <h6><span class='badge badge-info'> Dana Pokok </span><h6> </td>");
                      }
                      $("#urutan").append("</tr>");
                    }else{
                      $("#urutan").append("<tr>");
                      $("#urutan").append("<td> Bulan " + xx + "</td>");
                      //tanggal imbal hasil
                      if(value.status_update >= 1){
                        $("#urutan").append("<td>" + value.tgl_update + " <i>" + value.ket_weekend + "</i></td>");
                      }else{
                        $("#urutan").append("<td style="+(value.status_libur == 1 ? 'background-color:red' : '')+";"+(value.status_libur == 1 ? 'color:white !important;' : '')+">" + value.tanggal_payout + " <i>" + value.ket_weekend + "</i></td>");
                      }
                      // nominal imbal hasil
                      $("#urutan").append("<td>Rp. " + formatNumber(parseInt(value.imbal_payout)) + "</td>");
                      // status imbal hasil
                      if (value.status_payout == 1 ){
                          $("#urutan").append("<td> <h6><span class='badge badge-danger'> Gagal Transfer </span><h6> </td>");
                      }else if (value.status_payout == 2){
                        $("#urutan").append("<td> <span class='badge badge-success'>Berhasil Transfer</span> </td>");
                      }else if (value.status_payout == 3){
                        $("#urutan").append("<td> <span class='badge badge-warning'>Dalam Proses</span> </td>");
                      }else if (value.status_payout == 4){
                        $("#urutan").append("<td> <span class='badge badge-success'>Imbal Hasil Realokasi</span> </td>");
                      }else if (value.status_libur == 1){
                        $("#urutan").append("<td> <span class='badge badge-danger'>Hari Libur</span> </td>");
                      }else if (value.status_libur == 1){
                        $("#urutan").append("<td> <span class='badge badge-danger'>Hari Libur</span> </td>");
                      }else{
                        $("#urutan").append("<td> <span class='badge badge-info'>Proyek berjalan</span> </td>");
                      }
                      // keterangan
                      if(value.keterangan == null || value.keterangan == 'null' || value.keterangan_libur == null || value.keterangan_libur == 'null'){
                        $("#urutan").append("<td> </td>");
                      }else if(value.keterangan != null || value.keterangan != 'null' || value.keterangan_libur != null || value.keterangan_libur != 'null'){
                        $("#urutan").append("<td>" + value.keterangan +" "+ value.keterangan_libur + "</td>");
                      }

                      $("#urutan").append("</tr>");
                    }
                });

                console.log(detil)
            }
        })

    })
		
		$('#tbl_investation tbody').on( 'click', 'tr', function (event) {
				
			if (!$(event.target).is("#daftar_akad_murobahah,#ttd_akad_murobahah,#unduh_akad_murobahah")) {
    		var tr = $(this).closest('tr');
    		var row = table_imbal.row( tr );
    		var length = table_imbal.rows('tr.selected').data().length;
    		var data = table_imbal.row($(this).closest('tr')).data();
    		var id = $(event.target).parent().data('value');
    		
    		if ( $(this).hasClass('selected') ) {
    			
    			$(this).removeClass('selected');
    			row.child.hide();
    			tr.removeClass('shown');
    		}
    		else {
    			
    			//$("#id_pendanaan").val();
    			//$("#hide_txt_harga_paket").val();
    			//$("#txt_harga_paket").val(data['Harga Paket']);
    			//$('#qty').attr("data-val", data['Harga Paket']);
    			
    			table_imbal.$('tr.selected').removeClass('selected');
    			$(this).addClass('selected');
    			row.child( format(data['id_pendanaan'], data['id_proyek'], data['status'])).show();
    			tr.addClass('shown');
    			
    			// modal set text ambil dana
    			$("#id_pendanaan").val(data['id_pendanaan']);
    			$("#hide_txt_harga_paket").val(data['Harga Paket']);
    			$("#txt_harga_paket").val(data['Harga Paket']);
    			//$('#qty').attr("data-val", data['Harga Paket']);
    			
    			// modal set text tambah dana
    			$("#txt_tmbh_modal_id_pendanaan").val(data['id_pendanaan']);
    			$("#txt_tmbh_modal_id_proyek").val(data['id_proyek']);
    			$("#txt_tmbh_harga_paket").val(data['Harga Paket']);
				}
      }
		});

    $('#tbl_investation tbody').on('click','#daftar_akad_murobahah',function(){
        var data = table_imbal.row( $(this).parents('tr') ).data();
        var investor_id = data.id_investor;
        var text = "{{ $teks }}";
        console.log(investor_id)
        swal({
                title: "Informasi",   
                text: text,   
                type: "info",   
                showCancelButton: true,
                cancelButtonClass: 'btn-cancel',
                confirmButtonText: "Setuju",   
                cancelButtonText: "Batal",   
                closeOnConfirm: false,   
                closeOnCancel: true
                },

                function(isConfirm){   
                  if (isConfirm) 
                  {
                        $.ajax({
                            url:'/user/regDigiSign/'+investor_id,
                            method:'get',
                            dataType:'json',
                            beforeSend: function() {
                                $("#overlay").css('display','block');
                                swal.close()
                            },
                            success:function(data)
                            {
                                $("#overlay").css('display','none');
                                var dataJSON = JSON.parse(data.status_all);
                                console.log(dataJSON);
                                if (dataJSON.JSONFile.result == '00')
                                {
                                   if (dataJSON.JSONFile.info)
                                    {
                                      var url_notif = dataJSON.JSONFile.info.split('https://')[1];
                                      $.ajax({
                                          url : "/user/callbackDigiSignInvestor/",
                                          method : "post",
                                          data : {user_id:id_user,provider_id:1,status:dataJSON.JSONFile.notif,step:'register',url:url_notif},
                                          success:function(data)
                                          {
                                              console.log(data.status)
                                              var email = "{{ Auth::user()->email }}"
                                              $.ajax({
                                                  url : "/user/actDigiSign/"+email,
                                                  method : "get",
                                                  success:function(data)
                                                  {
                                                      var dataJSON2 = JSON.parse(data.status_all);
                                                      console.log(dataJSON2)
                                                      if (dataJSON2.JSONFile.result == '00')
                                                      {
                                                          $('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                          $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                          $('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
                                                          $('#linkAktivasi').attr('src',dataJSON2.JSONFile.link)
                                                          $("#modalAktivasi").appendTo('body');
                                                          $('#linkAktivasi').load(function(){
                                                              var myFrame = $("#linkAktivasi").contents().find('body').text();
                                                              console.log(myFrame)
                                                              if (myFrame !== '')
                                                              {
                                                                  $('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
                                                                  $('.modal-backdrop').remove()
                                                                  location.reload(true);
                                                              }
                                                          })
                                                          
                                                      }
                                                      else
                                                      {
                                                          swal({title:"Notifikasi",text:'Aktivasi Gagal',type:"info"},
                                                            function(){
                                                                  swal.close()
                                                             }
                                                          );
                                                      }
                                                  },
                                                  error: function(request, status, error)
                                                  {
                                                      // $("#overlay").css('display','none');
                                                      alert(status)
                                                  }
                                              });
                                          },
                                          error: function(request, status, error)
                                          {
                                              // $("#overlay").css('display','none');
                                              alert(status)
                                          }
                                      });
                                    }
                                    else
                                    {
                                        var regDigiSign = '{{ $cekRegDigiSign}}';
                                        if(regDigiSign == null)
                                        {
                                            swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                               function(){
                                                    swal.close()
                                                    var email = "{{ Auth::user()->email }}"
                                                    $.ajax({
                                                        url : "/user/actDigiSign/"+email,
                                                        method : "get",
                                                        success:function(data)
                                                        {
                                                            var dataJSON2 = JSON.parse(data.status_all);
                                                            console.log(dataJSON2)
                                                            if (dataJSON2.JSONFile.result == '00')
                                                            {
                                                                $('#modalAktivasi').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                                $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                                $('#modalBodyAktivasi').append('<iframe id="linkAktivasi" width="350" height="750"></iframe>');
                                                                $('#linkAktivasi').attr('src',dataJSON2.JSONFile.link)
                                                                $("#modalAktivasi").appendTo('body');
                                                                $('#linkAktivasi').load(function(){
                                                                    var myFrame = $("#linkAktivasi").contents().find('body').text();
                                                                    console.log(myFrame)
                                                                    if (myFrame !== '')
                                                                    {
                                                                        $('#modalAktivasi').modal('show').addClass('modal fade').attr('style','display:none')
                                                                        $('.modal-backdrop').remove()
                                                                        location.reload(true);
                                                                    }
                                                                })
                                                                
                                                            }
                                                            else
                                                            {
                                                                swal({title:"Notifikasi",text:'Aktivasi Gagal',type:"info"},
                                                                  function(){
                                                                        swal.close()
                                                                   }
                                                                );
                                                            }
                                                        },
                                                        error: function(request, status, error)
                                                        {
                                                            // $("#overlay").css('display','none');
                                                            alert(status)
                                                        }
                                                    });
                                                }
                                            );
                                        }
                                        else
                                        {
                                            swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                               function(){
                                                    swal.close()
                                                    var id_user = {{ Auth::user()->id }};
                                                    $.ajax({
                                                        url : "/admin/investor/sendDigiSign/"+id_user,
                                                        method : "get",
                                                        beforeSend: function() {
                                                            $("#overlay").css('display','block');
                                                        },
                                                        success:function(data)
                                                        {
                                                            $("#overlay").css('display','none');
                                                            var dataJSON = JSON.parse(data.status_all);
                                                            if (dataJSON.JSONFile.result == '00')
                                                            {
                                                                $.ajax({
                                                                    url:'/user/signDigiSign/'+id_user,
                                                                    method:'get',
                                                                    dataType:'json',
                                                                    beforeSend: function() {
                                                                        $("#overlay").css('display','block');
                                                                        swal.close()
                                                                    },
                                                                    success:function(data)
                                                                    {
                                                                        $("#overlay").css('display','none');
                                                                        var dataJSON = JSON.parse(data.status_all);
                                                                        console.log(dataJSON);
                                                                        if (dataJSON.JSONFile.result == '00')
                                                                        {
                                                                            $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                                                                            $('.modal-backdrop').addClass('modal-backdrop fade show in')
                                                                            $('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
                                                                            $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                                                                            $("#modalTTD").appendTo('body');
                                                                            $('#linkTTD').load(function(){
                                                                                var myFrame = $("#linkTTD").contents().find('body').text();
                                                                                console.log(myFrame)
                                                                                if (myFrame !== '')
                                                                                {
                                                                                    $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                                                                                    $('.modal-backdrop').remove()
                                                                                    location.reload(true);
                                                                                }
                                                                            })
                                                                        }
                                                                        else
                                                                        {
                                                                            swal({title:"Notifikasi",text:'TTD Gagal',type:"info"},
                                                                              function(){
                                                                                    swal.close()
                                                                               }
                                                                            );
                                                                        }
                                                                    },
                                                                    error: function(request, status, error)
                                                                    {
                                                                        $("#overlay").css('display','none');
                                                                        alert(status)
                                                                    }
                                                                })
                                                            }
                                                            else
                                                            {
                                                                swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                                                  function(){
                                                                       investorTable.ajax.reload();
                                                                   }
                                                                );
                                                            }
                                                            
                                                        },
                                                        error: function(request, status, error)
                                                        {
                                                            $("#overlay").css('display','none');
                                                            alert(status)
                                                        } 
                                                    });
                                                }
                                            );
                                        }
                                   }
                                }
                                else
                                {
                                    swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                      function(){
                                            swal.close()
                                       }
                                    );
                                }
                            },
                            error: function(request, status, error)
                            {
                                $("#overlay").css('display','none');
                                alert(status)
                            }
                        })  
                }
              }
        );
    });

    $('#tbl_investation tbody').on('click','#ttd_akad_murobahah',function(){
          var data = table_imbal.row( $(this).parents('tr') ).data();
          var investor_id = data.investor_id;
          var proyek_id = data.id_proyek;
          $.ajax({
              url:'/user/signDigiSignMurobahah/'+investor_id+'/'+proyek_id,
              method:'get',
              dataType:'json',
              beforeSend: function() {
                  $("#overlay").css('display','block');
                  swal.close()
              },
              success:function(data)
              {
                  $("#overlay").css('display','none');
                  var dataJSON = JSON.parse(data.status_all);
                  console.log(dataJSON);
                  if (dataJSON.JSONFile.result == '00')
                  {
                      $('#modalTTD').modal('show').addClass('modal fade show in').attr('style','display:block')
                      $('.modal-backdrop').addClass('modal-backdrop fade show in')
                      $('#modalBodyTTD').append('<iframe id="linkTTD" width="350" height="750"></iframe>');
                      $('#linkTTD').attr('src',dataJSON.JSONFile.link)
                      $("#modalTTD").appendTo('body');
                      $('#linkTTD').load(function(){
                          var myFrame = $("#linkTTD").contents().find('body').text();
                          console.log(myFrame)
                          if (myFrame !== '')
                          {
                              $('#modalTTD').modal('show').addClass('modal fade').attr('style','display:none')
                              $('.modal-backdrop').remove()
                              location.reload(true);
                          }
                      })
                  }
                  else
                  {
                      swal({title:"Notifikasi",text:'TTD Gagal',type:"info"},
                        function(){
                              swal.close()
                         }
                      );
                  }
              },
              error: function(request, status, error)
              {
                  $("#overlay").css('display','none');
                  alert(status)
              }
          })
    });
	  
    $('#tbl_investation tbody').on('click','#unduh_akad_murobahah',function(){
          var data = table_imbal.row( $(this).parents('tr') ).data();
          var proyek_id = data.id_proyek;
          $.ajax({
            url:'/user/downloadBase64DigiSignMurobahah/',
            method:'post',
            //responseType: "blob",
            data:{proyek_id:proyek_id},
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
	  
});


</script>

@endsection
