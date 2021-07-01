@extends('layouts.user.sidebar')

@section('title', 'Penarikan Dana')

@section('content')
<style>
	.dataTables_paginate { 
	   float: right; 
	   text-align: right; 
	}
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
      /* display: none; <- Crashes Chrome on hover */
      -webkit-appearance: none;
      margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
  }

  input[type=number] {
      -moz-appearance:textfield; /* Firefox */
  }
</style>
  <div class="row">
    <div class="col-sm-12">
      <h2>Penarikan Dana</h2>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-12 col-md-4 my-3">
      <div class="card text-center">
        <div class="card-body">
          Saldo Total<br><br>
          <span style="font-size: 2rem;">Rp. {{!empty($unallocated->total_dana)?number_format($unallocated->total_dana,  0, '', '.'):0}}</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 my-3">
        <div class="card text-center">
          <div class="card-body">
            Saldo tidak teralokasi <br> (saldo yang bisa diambil)<br>
            <span style="font-size: 2rem;" >Rp.{{!empty($unallocated->unallocated)?number_format($unallocated->unallocated,  0, '', '.'):0}}</span>
            <input type="hidden" id="unallocated" value="{{!empty($unallocated->unallocated)?$unallocated->unallocated:0}}">
          </div>
        </div>
      </div>
       {{-- <div class="col-12 col-md-4 my-3">
          <div class="card text-center">
            <div class="card-body">
              Saldo Pokok<br>
              <span style="font-size: 2rem;">{{number_format($pendanaan->sum('nominal_awal'))}}</span>
            </div>
          </div>
        </div>  --}}
  </div>
  <div class="row p-3">
    <div class="col-sm-12 my-3 bg-white py-3">
		<div class="section wow fadeInDown delay-02s mt-2" style="background-color: white; box-shadow: 0px 1px 10px 0px grey;">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
			  <li class="nav-item">
				<a class="nav-link active" id="deskripsi-tab" data-toggle="tab" href="#penarikan" role="tab" aria-controls="deskripsi" aria-selected="true">Penarikan Dana</a>
			  </li>
			 
			  <li class="nav-item">
				<a class="nav-link" id="legalitas-tab" data-toggle="tab" href="#histori" role="tab" aria-controls="legalitas" aria-selected="false">Histori Penarikan Dana</a>
			  </li>
			  
			</ul>
			<div class="tab-content" id="myTabContent" >
				<div class="tab-pane fade show active" id="penarikan" role="tabpanel" aria-labelledby="deskripsi-tab" style="overflow-x:auto">
					<div class="col-lg-12 col-sm-12 p-3 float-left">
					<br>
						<h3 class="heading">Penarikan Dana</h3>
						<hr>
						<div id="DivDescription">
							 <div class="row">
								<div class="col-sm-12">
								  <p>Proses penarikan biasanya memakan waktu hingga 5 hari kerja. Biaya Penarikan sebesar Rp6,000.00 akan dipotong dari dana yang Anda tarik untuk setiap penarikan yang Anda buat. </p>
								  <p><b>Pastikan Nomor rekening dan Nama anda Benar</b>  </p>
								</div>
							  </div>

							  <div class="row justify-content-center">
								<div class="col-sm-10">
                    <form action="/user/withdraw_money" method="POST" id="req_penarikan_dana">
                      @csrf
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label text-right">Bank *</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="namaBank" value="{{$master_bank['nama_bank']}}" name="bank" readonly="readonly" required>
                          <span id="error_bank" style="color: red"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label text-right">Atas Nama (sesuai KTP) *</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="namaPemilikRek" value="{{$nama->nama_pemilik_rek }}" name="nama" readonly="readonly" required>
                        <span id="error_pemilikRek"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="noRekBank" class="col-sm-3 col-form-label text-right">Nomor Rekening Bank *</label>
                        <div class="col-sm-9">
                        <input readonly="readonly" type="text" class="form-control" id="noRekBank" value="{{$nama->rekening}}" name="rekening" required>
                        <span id="error_noRek"></span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="jumlah" class="col-sm-3 col-form-label text-right">Jumlah *</label>
                        <div class="col-sm-9">
                        <input type="number" class="form-control" id="jumlah_penarikan" oninput="compareFunction()" value="0" name="nominal" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9 px-3">
                        <div class="row">
                          <div class="col-sm-12 px-3">
                          <table class="table table-sm table-borderless bg-light">
                            <tr>
                            <td>Nilai</td>
                            <td class="text-right">-</td>
                            </tr>
                            <tr>
                            <td><b>Total dana ditarik</b></td>
                            <td class="text-right"><b>Rp. <span id="total"></span></b></td>
                            </tr>
                            <tr>
                            <td></td>
                            <td class="text-right"><p style="color:red" id="constraint_morethan"></p></td>
                            </tr>
                          </table>
                          </div>
                        </div>
                        <button type="button" id="button_withdraw" disabled class="btn btn-block btn-success">Permintaan Penarikan Dana</button>
                        </div>
                        <p style="font-weight: bold;">*) Wajib Diisi</p>
                      </div>
                      </form>
								  <!-- <div class="card">
									<div class="card-body"> -->
									  {{-- <form action="/user/verificationCode" method="POST" id="req_penarikan_dana"> --}}
										{{-- @csrf --}}
										{{-- <input type="hidden" class="form-control" id="idPemilikRek" value="{{$nama->investor_id }}" name="nama" readonly="readonly" required>
										<div class="form-group row">
											<label for="nama" class="col-sm-3 col-form-label text-right">Bank *</label>
											<div class="col-sm-9">
											  <input type="text" class="form-control" id="namaBank" value="{{$master_bank['nama_bank']}}" name="bank" readonly="readonly" required>
											  <span id="error_bank" style="color: red"></span>
											</div>
										</div>
										<div class="form-group row">
										  <label for="nama" class="col-sm-3 col-form-label text-right">Atas Nama (sesuai KTP) *</label>
										  <div class="col-sm-9">
											<input type="text" class="form-control" id="namaPemilikRek" value="{{$nama->nama_pemilik_rek }}" name="nama" readonly="readonly" required>
											<span id="error_pemilikRek"></span>
										  </div>
										</div>
										<div class="form-group row">
										  <label for="noRekBank" class="col-sm-3 col-form-label text-right">Nomor Rekening Bank *</label>
										  <div class="col-sm-9">
											<input readonly="readonly" type="text" class="form-control" id="noRekBank" value="{{$nama->rekening}}" name="rekening" required>
											<span id="error_noRek"></span>
										  </div>
										</div>
										<div class="form-group row">
										  <label for="jumlah" class="col-sm-3 col-form-label text-right">Jumlah *</label>
										  <div class="col-sm-9">
											<input type="number" class="form-control" id="jumlah_penarikan" oninput="compareFunction()" value="0" name="nominal" required>
										  </div>
										</div>
										<div class="row">
										  <div class="col-sm-3"></div>
										  <div class="col-sm-9 px-3">
											<div class="row">
											  <div class="col-sm-12 px-3">
												<table class="table table-sm table-borderless bg-light">
												  <tr>
													<td>Nilai</td>
													<td class="text-right">-</td>
												  </tr>
												  <tr>
													<td><b>Total dana ditarik</b></td>
													<td class="text-right"><b>Rp. <span id="total"></span></b></td>
												  </tr>
												  <tr>
													<td></td>
													<td class="text-right"><p style="color:red" id="constraint_morethan"></p></td>
												  </tr>
												</table>
											  </div>
											</div>
                      <button type="button" id="button_withdraw" disabled class="btn btn-block btn-success">Penarikan Dana</button>
										  </div>
										  <p style="font-weight: bold;">*) Wajib Diisi</p>
										</div> --}}
									  {{-- </form> --}}
									<!-- </div>
								  </div> -->

								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane fade show" id="histori" role="tabpanel" aria-labelledby="deskripsi-tab" style="overflow-x:auto">
					<div class="col-lg-12 col-sm-12 p-3 float-left">
					<br>
						<h3 class="heading">Histori Penarikan Dana</h3>
						<hr>
						<div id="DivDescription">
							<table id="tbl_histori_dana" class="table table-bordered table-hover">
								<thead>
								<tr>
									<th>Jumlah Penarikan</th>
									<th>Tanggal Penarikan</th>
									<th>No Rekening</th>
									<th>Bank Tujuan</th>
									<th>Status</th>
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
   
<!-- Modal Ambil Dana -->
{{-- modal otp --}}
<div class="modal fade " id="modalOtp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Silahkan masukan kode OTP.</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
	  <div class="modal-body">
      <div class="from-group p-3">
          <input class="form-control form-control-lg" type="number" id="otp_code" placeholder="Kode OTP" max="6">
      </div>
		</div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
		<button type="submit" id="button_send_otp" class="btn btn-sm btn-primary">Kirim OTP</button>
	  </div>
	</div>
  </div>
</div>





<script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>


function compareFunction() {
    var jumlah_function = document.getElementById("jumlah_penarikan").value;
    var unallocated = parseInt(document.getElementById("unallocated").value);

    total_penarikan = parseInt(jumlah_function);
    var	number_string = total_penarikan.toString(),
        sisa 	= number_string.length % 3,
        rupiah 	= number_string.substr(0, sisa),
        ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
          
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    document.getElementById("total").innerHTML = rupiah;
    
    if( jumlah_function < 100000 ){
      document.getElementById("constraint_morethan").innerHTML = "Penarikan minimum 100.000 ";
      document.getElementById("button_withdraw").disabled = true;
    }
    else if( jumlah_function > unallocated ){
      document.getElementById("constraint_morethan").innerHTML = "Penarikan melebihi dana tersedia !";
      document.getElementById("button_withdraw").disabled = true;
    }
    else{
      document.getElementById("constraint_morethan").innerHTML = "";
      document.getElementById("button_withdraw").disabled = false;
    }
}
$(document).ready(function(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	var table = $('#tbl_histori_dana').DataTable({
		//"dom": 'tip',
		//"bSort": false,
		//serverSide : true,
		//dom : 'Bftrip',
		processing: true,
        serverSide: false,
		ajax: {
			type :"GET",
			url: "/user/histori_penarikan_dana/",
			//url: "/user/histori_penarikan_dana/"+$('#investor_id').val()+"",
		},
		"columns" : [
            { "data" : "Jumlah Penarikan" },
            { "data" : "Tanggal Penarikan" },
            { "data" : "No Rekening" },
            { "data" : "Bank Tujuan" },
            { "data" : "Status" },
            //{ "data" : "Bagi Hasil" }
        ],
		"columnDefs": [{
			"targets": 0,
			class : 'text-center',
			//"visible" : true
		},{
			"targets": 1,
			class : 'text-center',
			//"visible" : true
		},{
			"targets": 2,
			class : 'text-center',
			//"visible" : false
		},{
			"targets": 3,
			class : 'text-center',
			//"visible" : false
		},{
			"targets": 4,
			class : 'text-center',
			//"visible" : false
			/*"render" : function(data, type, row, meta){
				var statusText;
				if(row[4] == 1){
					statusText = "sukses";
				}
				else if(row[4] == 2){
					statusText = "gagal";
				}
				
				return row[4];
			}
			*/
		}]
	});
	
	
	$('#button_withdraw').on('click',function(e){
    $(this).prop('disabled', true);
		e.preventDefault();
		var bank,nama_rek,no_rek;
		bank = $("#namaBank").val();
		nama_rek = $("#namaPemilikRek").val();
		no_rek = $("#noRekBank").val();
    id = $('#idPemilikRek').val();
    modalotp = $('#modalOtp');
    
		if (bank == 0)
		{
			$('#error_bank').html('Nama Bank Wajib Diisi');
		}
		if (nama_rek == 0)
		{
			$('#error_pemilikRek').html('Nama Pemilik Rekening Wajib Diisi');
		}
		if (no_rek == 0)
		{
			$('#error_noRek').html('No Rekening Wajib Diisi');
		}
		if (bank != 0 && nama_rek != 0 && no_rek != 0)
		{
			$('#req_penarikan_dana').submit();
    }
    

		// $.ajax({
		// 	url: "/user/verificationCode/"+id,
		// 	method: "get",
		// 	success:function(data)
		// 	{
    //       if(data.success == true)
    //       {
    //         $('#modalOtp').addClass('show').modal('show');            
    //       }
    //       if(data.success == false)
    //       {
    //         alert(data.message);
    //       }
		// 	}
		// });
  });

  // $('#button_send_otp').on('click', function(){
  //   id = $('#idPemilikRek').val();
  //   otp = $('#otp_code').val();
  //   dana = $('#jumlah_penarikan').val();
  //   console.log(dana) 
  //   $.ajax({
  //     url: "/user/sendVerifikasi/"+id+"/"+otp+"/"+dana,
  //     method: "get",
  //     success:function(data)
  //     {
  //       console.log(data);
  //       if(data.success == true)
  //       {
  //         alert(data.message);
  //         $('#modalOtp').attr('style','display:none;');    
  //         location.reload();
  //       }
  //       if(data.success == false)
  //       { 
  //         alert(data.message);
  //       }

  //     }
  //   });
  // });
  
	
});

</script>
@endsection
