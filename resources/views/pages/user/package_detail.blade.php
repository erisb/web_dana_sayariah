@extends('layouts.user.sidebar')

@section('title', 'Detil Lengkap Paket')

@section('content')
<style>
	.tab-card {
  border:1px solid #eee;
}

.tab-card-header {
  background:none;
}
/* Default mode */
.tab-card-header > .nav-tabs {
  border: none;
  margin: 0px;
}
.tab-card-header > .nav-tabs > li {
  margin-right: 2px;
}
.tab-card-header > .nav-tabs > li > a {
  border: 0;
  border-bottom:2px solid transparent;
  margin-right: 0;
  color: #28a745;
  padding: 2px 15px;
}

.tab-card-header > .nav-tabs > li > a.show {
    border-bottom:2px solid #007bff;
    color: #007bff;
}
.tab-card-header > .nav-tabs > li > a:hover {
    color: #007bff;
}

.tab-card-header > .tab-content {
  padding-bottom: 0;
}
</style>
 <div class="row">
   <div class="col-sm-12">
     <h2>Detil Lengkap Paket</h2>
   </div>
 </div>
 <hr>
 <br>
 <div class="row">
   <div class="col-sm-12">
     <div class="card">
       <div class="card-body">
         <h4>Detil Proyek</h4>
         <div class="card mt-3">
           <div class="card-body">
             <div class="row">
				<input type="hidden" id="txt_idDeskripsi" value="{{$proyek->id_deskripsi}}">
				<input type="hidden" id="txt_idLegalitas" value="{{$proyek->id_legalitas}}">
				<input type="hidden" id="txt_idPemilikProyek" value="{{$proyek->id_pemilik}}">
               <div class="col-sm-3">Nama Proyek</div>
               <div class="col-sm-9">{{$proyek->nama}}</div>
             </div>
             <div class="row">
                <div class="col-sm-3">Alamat Proyek</div>
                <div class="col-sm-9">{!!$proyek->alamat!!}</div>
              </div>
             <div class="row">
               <div class="col-sm-3">Deskripsi</div>
               <div class="col-sm-9">{!!$proyek->deskripsi!!}</div>
             </div>
             <div class="row">
               <div class="col-sm-12 p-3 table-responsive-sm">
                 <table class="table table-sm table-borderless border table-striped text-center">
                   <thead class="table-primary">
                    <th colspan=2 class="">Detil Proyek</th>
                   </thead>
                   <tbody>
                     <tr>
                       <td>Dana Dibutuhkan</td>
                       <td>Rp. {{number_format($proyek->total_need,  2, ',', '.')}}</td>
                     </tr>
                     <tr>
                        <td>Periode</td>
                        <td>{{$proyek->tenor_waktu}} Bulan</td>
                      </tr>
                      <tr>
                        <td>Imbal Hasil Syariah</td>
                        <td>{{number_format($proyek->profit_margin, 0, '', '')}} %</td>
                      </tr>
                      <tr>
                        <td>Harga Paket</td>
                        <td>Rp. {{number_format($proyek->harga_paket,  2, ',', '.')}}</td>
                      </tr>
                      <tr>
                        <td>Akad</td>
                        <td>{{$proyek->akad}}</td>
                      </tr>
                      <tr>
                        <td>Pengembalian Pokok</td>
                        <td>Bulanan</td>
                      </tr>
                      <tr>
                        <td>Total Terkumpul</td>
                        <td>{{number_format(($proyek->terkumpul+$data_pendana->sum('nominal_awal'))/$proyek->total_need*100, 2, '.', '')}}%</td>
                      </tr>
                   </tbody>
                 </table>
               </div>
             </div>
           </div>
         </div>
		 <div class="section wow fadeInDown delay-02s mt-2" style="background-color: white; box-shadow: 0px 1px 10px 0px grey;">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item">
					<a class="nav-link active" id="deskripsi-tab" data-toggle="tab" href="#deskripsi" role="tab" aria-controls="deskripsi" aria-selected="true">Over View</a>
				  </li>
				 
				  <li class="nav-item">
					<a class="nav-link" id="legalitas-tab" data-toggle="tab" href="#legalitas" role="tab" aria-controls="legalitas" aria-selected="false">Legalitas</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="pemilik-tab" data-toggle="tab" href="#pemilik" role="tab" aria-controls="pemilik" aria-selected="false">Pemilik Proyek</a>
				  </li>
				  
				</ul>
				<div class="tab-content" id="myTabContent" >
					<div class="tab-pane fade show active" id="deskripsi" role="tabpanel" aria-labelledby="deskripsi-tab" style="overflow-x:auto">
						<div class="col-lg-12 col-sm-12 p-3 float-left">
						<br>
							<h3 class="heading">Property Description</h3>
							<hr>
							<div id="DivDescription">
								
							</div>
						</div>
					</div>

                    <div class="tab-pane fade" id="legalitas" role="tabpanel" aria-labelledby="legalitas-tab">
                        
						<div class="col-lg-12 col-sm-12 p-3">
							<br>
								<h3 class="heading">Legalitas</h3>
							<hr>
							<div id="DivLegalitas">
								
							</div>
						</div>
                    </div>
					<div class="tab-pane fade" id="pemilik" role="tabpanel" aria-labelledby="pemilik-tab">
					
						<div class="col-lg-12 col-sm-12  p-3">
							<br>
								<h3 class="heading">Pemilik Proyek</h3>
							<hr>
							<div id="DivPemilikProyek">
								
							</div>
						</div>
					</div>
                    
                </div>
            </div>
       </div>
	    
	</div>
   </div>
 </div>
 
 <br>
 <?php
   //$progress = 1;
   //$total = 4;
  ?>
<!--
  <div class="row">
    <div class="col sm-12">
      <div class="card">
        <div class="card-body">
          <h4>Progres Proyek</h4>
          <br>
          <table class="table table-sm table-borderless border table-striped text-center tabe-responsive-sm">
                   <thead class="table-primary">
                    <th colspan=1 class="">Tanggal</th>
                    <th colspan=1>Detil Proyek</th>
                   </thead>
                   <tbody>
                   @foreach ($proyek->progressProyek as $progress)
                      
                     <tr id="{{$progress->id}}" data-desc="{{$progress->deskripsi}}" data-img="{{$progress->pic}}">
                      <td>{{$progress->tanggal}}</td>
                      <td><button class="btn btn-info" data-toggle="modal" data-target="#modalDetail">detil</button></td>
                     </tr>

                    @endforeach
                   </tbody>
                 </table>
          <br>
          <div class="row">
            <div class="col-sm-12">
              <div class="progress">
                <?php
                  //$val = ($proyek->terkumpul/$proyek->total_need)*100;
                  //echo "<div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='$val' aria-valuemin='0' aria-valuemax='100' style='width: $val%''></div>";
                 ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>-->
  <br>
  <!-- <div class="row">
    <div class="col sm-12">
      <div class="card">
        <div class="card-body">
          <h4>Riwayat Transaksi</h4>
          <div class="card">
            <div class="card-body">
              <table class="table table-sm table-borderless">
                <thead style="border-bottom:2px solid grey;">
                  <th>...</th>
                  <th>...</th>
                  <th>...</th>
                </thead>
                <tbody>
                  <?php
				  /*
                    for ($i = 0; $i < 3 ; $i++) {
                      echo "<tr>
                        <td>---</td>
                        <td>---</td>
                        <td>---</td>
                      </tr>";
                    };
					*/
                   ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->

<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalDetailLabel">Detil Proyek</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body w-100">
				<div id="modal_desc"></div>
				<img src="" alt="" id="modal_pic" class="rounded w-50 mx-auto d-block">
			</div>
		</div>
	</div>
</div>

<script>

	$(document).ready(function(){
		// Tab Over View
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		
		var txtOverView = $("#txt_idDeskripsi").val();
		var txtlegalitas = $("#txt_idLegalitas").val();
		var txtPemilikProyek = $("#txt_idPemilikProyek").val();
		
		// get Description
		$.ajax({

			type:'GET',
			url:'/user/getOverView_proyek/'+txtOverView,
			success:function(data){
				//console.log(data[0]['deskripsi']);
				$("#DivDescription").html(data[0]['deskripsi']);
			}

		});
		
		// get Legalitas
		$.ajax({

			type:'GET',
			url:'/user/getLegalitas_proyek/'+txtlegalitas,
			success:function(data){
				$("#DivLegalitas").html(data[0]['deskripsi_legalitas']);
			}

		});
		
		// get Pemilik Proyek
		$.ajax({

			type:'GET',
			url:'/user/getPemilik_proyek/'+txtPemilikProyek,
			success:function(data){
				//console.log(data[0]['deskripsi']);
				$("#DivPemilikProyek").html(data[0]['deskripsi_pemilik']);
			}

		});
		
		$('#modalDetail').on('show.bs.modal', function (event) {
		
			// var button = $(event.relatedTarget) // Button that triggered the modal
			var proyek = $(event.relatedTarget).closest('tr');
			var desc = proyek.data('desc');
			var img = proyek.data('img'); // Extract info from data-* attributes
			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			console.log(desc);
			console.log(img);
			
			
			var modal = $(this);

			// modal.find('.modal-title').text('New message to ' + recipient)
			// modal.find('.modal-body input').val(recipient)
			modal.find('#modal_desc').html(desc);
			modal.find('#modal_pic').attr('src', '/storage/'+img);

		});
	});
	
//   $('#modalDetail').on('show.bs.modal', function (event) {

//     // var button = $(event.relatedTarget) // Button that triggered the modal
//     var proyek = $(event.relatedTarget).closest('tr');
//     var desc = proyek.data('desc');
//     var img = proyek.data('img'); // Extract info from data-* attributes
//     // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//     // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//     console.log(desc);
//     console.log(img);


//     var modal = $(this);

//     // modal.find('.modal-title').text('New message to ' + recipient)
//     // modal.find('.modal-body input').val(recipient)
//     modal.find('#modal_desc').html(desc);
//     modal.find('#modal_pic').attr('src', '/storage/'+img);

//   })

</script>

@endsection
