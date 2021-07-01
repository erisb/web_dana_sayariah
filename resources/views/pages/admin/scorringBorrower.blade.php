@extends('layouts.admin.master')

@section('title', 'Dashboard Borrower')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Manage Scoring Pendanaan</h1>
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
              <strong class="card-title">Data All Scorring Pendanaan</strong>
              <button class="btn btn-success float-right" id="draft_penilaian" data-toggle="modal" data-target="#modalDokumen" style="margin-left: 15px;">Dokumen Penilaian</button>
              {{-- <button type="button" class="btn btn-success float-right" data-toggle="modal" id="addNewJenis" data-target=".modelAddJenisPendanaan">Tambah Jenis Pendanaan</button> --}}
          </div>
          <div class="card-body">
              <table id="tablePendanaan" name="uhuy" class="table table-striped table-bordered table-responsive-sm">
                  <thead>
                  <tr>
                      <th>id</th>
                      <th>idPendanaan</th>
                      <th>No</th>
                      <th>Pendanaan</th>
                      <th>Penerima Dana</th>
                      <th>TglLahir</th>
                      <th>KTP</th>
                      <th>Skor Personal</th>
                      <th>Skor Pendanaan</th>
                      <th>Skor Total</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Large modal -->
<div class="modal fade modelAddJenisPendanaan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4>Tambah Jenis Pendanaan</h4>
      </div>
        <div class="modal-body">
            <form action="/admin/borrower/prosess/postNewJenis" method="POST">
              @csrf
              <div class="form-group">
                <label>Jenis Pendanaan</label>
                <input type="text" name="pendanaanJenis" class="form-control" id="addJenisNama" aria-describedby="" placeholder="Jenis Pendanaan">
              </div>
              <div class="form-group">
                <textarea name="pendanaanKeterangan" id="textJenisPendana"></textarea>
              </div>
        </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-primary float-right  ">Kirim</button>
        </form>        
      </div>
    </div>
  </div>
</div>

{{-- Modal dokumen --}}
  <div class="modal fade" id="modalDokumen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5>Dokumen Penilaian</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <div class="modal-body" id="modalBodyDokumen">
            <embed src="{{ url('kategori_resiko_borrower') }}#toolbar=0" style="width:100%; height:500px;"frameborder="0">
        </div>
        {{-- <div class="modal-footer">
          
        </div> --}}
      </div>
    </div>
  </div>
 {{-- Modal dokumen End --}}

 
<!-- start modal upload dokumen scoring pendanaan-->
<div class="modal fade" id="myUploadScoring" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Unggah Dokumen Penilaian Pendanaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{route('admin.uploadDokumenScoringPendanaan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <div class="form-row">
                          <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                            <input type="hidden" id="brw_id" name="brw_id">
                            <input type="hidden" id="brw_type" name="brw_type">
                            <input type="hidden" id="pendanaan_id" name="pendanaan_id">
                            <input type="hidden" id="identitas" name="ktp">
                            <div class="row" id="tambahUpload">
                              <label class="font-weight-bold">Nama Dokumen</label>
                              <input type="text" class="col-sm-12 form-control" name="nama_dokumen" placeholder="Nama Dokumen" required="required"/><br/><br/>

                              <label class="font-weight-bold">Unggah File</label>
                              <input type="file" class="form-control" name="file" id="file" placeholder="Type Here"><br/>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal upload dokumen scoring pendanaan-->
<!-- start modal upload dokumen scoring personal-->
<div class="modal fade" id="myUploadScoringPersonal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Unggah Dokumen Penilaian Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{route('admin.uploadDokumenScoringPersonal')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="card-body card-block">
                        <div class="form-row">
                          <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                            <input type="hidden" id="brw_id2" name="brw_id">
                            <input type="hidden" id="brw_type2" name="brw_type">
                            <input type="hidden" id="pendanaan_id2" name="pendanaan_id">
                            <input type="hidden" id="identitas2" name="ktp">
                            <div class="row" id="tambahUpload">
                              <label class="font-weight-bold">Nama Dokumen</label>
                              <input type="text" class="col-sm-12 form-control" name="nama_dokumen" placeholder="Nama Dokumen" required="required"><br/>

                              <label class="font-weight-bold">Unggah File</label>
                              <input type="file" class="form-control" name="file" id="file" placeholder="Type Here"><br/>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end of modal upload dokumen scoring personal-->

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
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <style>
      .btn-cancel {
          background-color: #C0392B;
          color: #FFFF;
      }
      .custom-datatable{
          width: 250px;
          white-space: nowrap !important;
          overflow: hidden !important;
          text-overflow: ellipsis !important;
      }
    </style>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
    
    $(document).on("input", ".allowCharacter", function(){
      this.value = this.value.replace(/[^0-9]/g, '');
    });
    
      
        //$(document).ready(function() {
      
          // var side = 'http://103.28.23.203/admin/borrower';
          var side = '/admin/borrower';
          var table = $('#tablePendanaan').DataTable({
            
            processing: true,
            // serverSide: true,
            ajax : {
              url : side+'/client/tableGetBorrower',
              type : 'get',
            },
            "columns" : [
              {"data" : "id"},
              {"data" : "idPendanaan"},
              {"data" : "no"},
              {"data" : "pendanaanBorrower"},
              {"data" : "namaBorrower"},
              {"data" : "tgl_lahir"}, 
              {"data" : "id"},
              {"data" : "nilaiBorrower"},
              {"data" : "ktp"},
              {"data" : "brw_type"},
          
            ],
            "columnDefs" :[
              {
                "targets": 0,
                class : 'text-left',
                "visible" : false,
              },
              {
                "targets": 1,
                class : 'text-left',
                "visible" : false,
              },
              {
                "targets": 2,
                class : 'text-left',
                // "visible" : false,
              },
              {
                "targets": 3,
                class : 'text-left',
                // "visible" : false,
              },
              {
                "targets": 4,
                class : 'text-left',
                // "visible" : false,
              },
              {
                "targets": 5,
                class : 'text-left',
                // "visible" : false,
              },
              {
                "targets": 6,
                class : 'text-left',
                "visible" : false,
              },
              {
                "targets": 7,
                class : 'text-left',
                style : 'width:150px;',
                //"visible" : false
                "render" : function(data, type, value, meta){
                  var scorebor = "";
                  var namaid = "scorrePersonal_"+value["idPendanaan"];
                  if(value["nilaiBorrower"] != ""){
                    scorebor = value["nilaiBorrower"];
                  }else{
                    scorebor = 0;
                  }
          return '<input type="number" name="scorrePersonal" value='+scorebor+' class="form-control allowCharacter" id='+namaid+' aria-describedby="" required placeholder="Scorre Personal"> <br/> <button class="btn btn-success" data-idbrw ='+value["id"]+' data-idp='+value["idPendanaan"]+' id="btnScore">Nilai</button>&nbsp;<button class="btn btn-info" data-idbrw ='+value["id"]+' data-idp='+value["idPendanaan"]+' data-toggle="modal" data-target="#myUploadScoringPersonal" onclick="getDataBorrower('+value["id"]+','+value["idPendanaan"]+','+value["ktp"]+','+value["brw_type"]+')" title="Unggah Dokumen"><i class="menu-icon fa fa-upload"></i></button>&nbsp;&nbsp;<button class="btn btn-primary" onclick="getDocScoringPersonal('+value["idPendanaan"]+')" title="Unduh Dokumen"><i class="menu-icon fa fa-download"></i></button> ';
          // onclick="btn_score_pefindo('+value["id"]+')"
        //   return '<input type="number" name="" class="form-control allowCharacter" id="scorrePersonal" aria-describedby="" required placeholder="Scorre Personal"> <br/> <button class="btn btn-success" id="btnScore">Score</button>';
          //return '<input type="number" name="" value='+scorebor+' class="form-control allowCharacter" id="scorrePersonal" aria-describedby="" required placeholder="Scorre Personal"> <br/> <button class="btn btn-success" id="btnScore">Score</button>';
                  //return row[6];
                }
              },
              {
                "targets": 8,
                class : 'text-left',
                style : 'width:150px;',
                //"visible" : false
                "render" : function(data, type, value, meta){
          
          return '<input type="number" name="" class="form-control allowCharacter" id="scorePendanaan" aria-describedby="" required placeholder="Score Pendanaan"> <br> <button class="btn btn-info" data-idbrw ='+value["id"]+' data-idp='+value["idPendanaan"]+' id="btnScoreUld" data-toggle="modal" data-target="#myUploadScoring" onclick="getDataBorrower('+value["id"]+','+value["idPendanaan"]+','+value["ktp"]+','+value["brw_type"]+')" title="Unggah Dokumen"><i class="menu-icon fa fa-upload"></i></button>&nbsp;&nbsp;<button class="btn btn-primary" onclick="getDocScoring('+value["idPendanaan"]+')" title="Unduh Dokumen"><i class="menu-icon fa fa-download"></i></button>';
                  //return row[6];
                }
              },
              {
                "targets": 9,
                class : 'text-left',
                "visible" : false,
                "render" : function(data, type, value, meta){
          
          return '<input type="text" readonly class="form-control allowCharacter" id="totalPendanaan" aria-describedby="" placeholder="Scorre Total">';
                  //return row[6];
                }
              },
              {
                "targets": 10,
                class : 'text-left',
                //"visible" : false
                "render" : function(data, type, value, meta){
                  return '<button class="btn btn-success" data-idbrw ='+value["id"]+' data-idp='+value["idPendanaan"]+' data-toggle="modal" data-target="" id="btnApprove" >Setuju Data</button><br><br><button class="btn btn-danger"  id="btnTolakData" data-idbrw ='+value["id"]+' data-idp='+value["idPendanaan"]+'>Tolak Data</button>';
                  //return row[6];
                }
              }
            ]
          });
      
      

          // $('#tablePendanaan tbody').on('focusout','#scorePendanaan , #scorrePersonal', function(){
          //   var data = table.row( $(this).parents('tr') ).data();

          //    if($('#scorrePersonal').val() == '' || $('#scorePendanaan').val() == '')
          //    {
          //       $('#totalPendanaan').val('');
          //    }
          //    else
          //    {
          //     nilai1 = $('#scorrePersonal').val();
          //     nilai2 = $('#scorePendanaan').val();

          //     hasil = parseInt(nilai1) + parseInt(nilai2);
          //     if(isNaN(hasil)){
          //       $('#totalPendanaan').html('0');
          //     }
          //     else{
          //       $('#totalPendanaan').val(hasil);
          //     }
          //    }
          // })
          
      
      
        $('#tablePendanaan tbody').on('click','#btnApprove', function(){
			var idbrw = $(this).data('idbrw');
            var idPendanaan = $(this).data('idp');
            var scorePersonal = $(this).closest("tr").find("#scorrePersonal_"+idPendanaan).val();
            var scorePendanaan = $(this).closest("tr").find("#scorePendanaan").val();
      
			if(scorePendanaan == 0 || scorePersonal == 0){
          
				swal("Gagal", "Proses gagal, Nilai Belum diinput", "error");
				$(this).closest("tr").find("#scorrePersonal_"+idPendanaan).focus();
				$(this).closest("tr").find("#scorePendanaan").focus();
          
			}
			else
			{
				if(scorePendanaan < 250 || scorePendanaan > 900){
            
					swal("Gagal", "Proses gagal, Nilai Pendanaan Kurang Dari 250 atau lebih dari 900", "info");
					$(this).closest("tr").find("#scorePendanaan").focus();
            
				}
				else if(scorePersonal < 250 || scorePersonal > 900){
				
					swal("Gagal", "Proses gagal, Nilai Personal Kurang Dari 250 atau lebih dari 900", "info");
					$(this).closest("tr").find("#scorrePersonal_"+idPendanaan).focus();
			  
				}else{
          
					swal({
						title: "Informasi",   
						text: "Yakin Akan Menyetujui Pendanaan Ini ?",   
						type: "warning",   
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
							url: side+'/prosess/postScorringBorrower',
							method : 'post',
							data : {id:idbrw,idPendanaan:idPendanaan,scorePersonal:scorePersonal,scorePendanaan:scorePendanaan},
							success:function(data)
							{
								console.log(data);
								if(data.data == 'ok')
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
										location.href = "/admin/borrower/client/scorringBorrower";
									});
								}
						
							}
						})
					}
					})
				}
        
			}
      
            
        })

          $('#tablePendanaan tbody').on('click','#btnTolakData', function(){
            var idbrw = $(this).data('idbrw');
            var idPendanaan = $(this).data('idp');
            swal({
                      title: "Informasi",   
                      text: "Yakin Akan Menolak Pendanaan Ini ?",   
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
                          url: side+'/prosess/rejectScorringBorrower',
                          method : 'post',
                          data : {id:idbrw,idPendanaan:idPendanaan},
                          success:function(data)
                          {
                            if(data.data == 'ok')
                            {
                              // var r = confirm('Yakin Akan Menyetujui Pendanaan Ini ?');
                              // if(r == true){
                              //   window.location.reload()
                              // }else{
                              //   alert('Batal Menyetujui Pendanaan');
                              // }
                              swal.close();
                              table.ajax.reload();
                            }
                            // else
                            // {
                            //   alert('Batal Menyetujui Pendanaan');
                            //   window.location.reload()                    
                            // }
                          }
                      })
                  }
                }
              );
          })

          $('#tablePendanaan tbody').on('click','#btnScore', function(){
          // function btn_score_pefindo(id1){
            
            // console.log(table);
              var id1 = $(this).data('idbrw');
              var idp = $(this).data('idp');
            
              console.log(side+'/searchPefindo/'+id1);
              $.ajax({
                  url: side+'/searchPefindo/'+id1,
                  method : 'get',
                  success:function(data1)
                  {
                    console.log(data1);
                    var data = JSON.parse(data1);
                    if(data.status_code == '00')
                    {
                      if(data.num_record>1){
                        
                        var i ;
                        var nilai = [];
                        var ID = [];
                        var pilihan = "<select class='form-control' id='pilihlah' name='pilihlah'>";
                        for (i = 0; i < data.num_record; i++) {
                          nilai[i] = data["detail"][i]["s:Envelope"]["s:Body"]["GetCustomReportResponse"]["GetCustomReportResult"]["a:CIP"]["b:RecordList"]["b:Record"][0]["b:Score"];
                          ID[i] = data.data[i].PefindoId;
                          pilihan += "<option value="+nilai[i]+">PefindoID : "+ID[i]+" - Nilai : "+nilai[i]+"</option>";
                        }
                        pilihan += "</select>";

                        var nilai_score = "";

                        Swal.fire({
                          title:"<b>Pilih Pefindo ID</b>",
                          html: pilihan,
                          type: "info",
                          showCancelButton: true,
                          confirmButtonClass: "btn-danger",
                          confirmButtonText: "Terapkan",
                          cancelButtonText: "Batal",
                          closeOnConfirm: true,
                          closeOnCancel: true
                        }).then((result) => {
                          var nl = $('#pilihlah option:selected').val();
                          var nli = parseInt(nl);
                          $("#scorrePersonal_"+idp).val(nli);
                        });

                      }else if(data.num_record==1){
                        var b = data["detail"]["s:Envelope"]["s:Body"]["GetCustomReportResponse"]["GetCustomReportResult"]["a:CIP"];
                        var d=b["b:RecordList"];
                        var c = d["b:Record"];
                        var nilaiP = data["detail"]["s:Envelope"]["s:Body"]["GetCustomReportResponse"]["GetCustomReportResult"]["a:CIP"]["b:RecordList"]["b:Record"][0]["b:Score"];
                      
                        // notif
                        Swal.fire({
                          title:"<b>Pefindo Biro Kredit ID:"+data.data.PefindoId+"</b>",
                          html: "<strong>Nilai Personal: <u>"+nilaiP+"</u></strong>",
                          type: "info",
                          showCancelButton: true,
                          confirmButtonClass: "btn-danger",
                          confirmButtonText: "Terapkan",
                          cancelButtonText: "Batal",
                          closeOnConfirm: true,
                          closeOnCancel: true
                        }).then((result) => {
                          $("#scorrePersonal_"+idp).val(nilaiP);
                        });
                      }
                      
                    } else {
                      swal("Gagal", "Tidak Ada Pefindo Biro Kredit ID", "error");
                    }
                  },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    console.log('Status: ' + textStatus); console.log('Error: ' + errorThrown); 
                }    
              })
          })

          $('#tablePendanaan tbody').on('click','#btnScoreDld', function(){
          // function btn_score_pefindo(id1){
            
            // console.log(table);
              var id1 = $(this).data('idbrw');
              var idp = $(this).data('idp');
            
              console.log(side+'/searchPefindo/'+id1);
              // $.ajax({
              //     url: side+'/searchPefindo/'+id1,
              //     method : 'get',
              //     success:function(data1)
              //     {
              //       console.log(data1);
              //       var data = JSON.parse(data1);
              //       if(data.status_code == '00')
              //       {
              //         if(data.num_record>1){
                        
              //           var i ;
              //           var nilai = [];
              //           var ID = [];
              //           var pilihan = "<select class='form-control' id='pilihlah' name='pilihlah'>";
              //           for (i = 0; i < data.num_record; i++) {
              //             nilai[i] = data["detail"][i]["s:Envelope"]["s:Body"]["GetCustomReportResponse"]["GetCustomReportResult"]["a:CIP"]["b:RecordList"]["b:Record"][0]["b:Score"];
              //             ID[i] = data.data[i].PefindoId;
              //             pilihan += "<option value="+nilai[i]+">PefindoID : "+ID[i]+" - Nilai : "+nilai[i]+"</option>";
              //           }
              //           pilihan += "</select>";

              //           var nilai_score = "";

              //           Swal.fire({
              //             title:"<b>Pilih Pefindo ID</b>",
              //             html: pilihan,
              //             type: "info",
              //             showCancelButton: true,
              //             confirmButtonClass: "btn-danger",
              //             confirmButtonText: "Terapkan",
              //             cancelButtonText: "Batal",
              //             closeOnConfirm: true,
              //             closeOnCancel: true
              //           }).then((result) => {
              //             var nl = $('#pilihlah option:selected').val();
              //             var nli = parseInt(nl);
              //             $("#scorrePersonal_"+idp).val(nli);
              //           });

              //         }else if(data.num_record==1){
              //           var b = data["detail"]["s:Envelope"]["s:Body"]["GetCustomReportResponse"]["GetCustomReportResult"]["a:CIP"];
              //           var d=b["b:RecordList"];
              //           var c = d["b:Record"];
              //           var nilaiP = data["detail"]["s:Envelope"]["s:Body"]["GetCustomReportResponse"]["GetCustomReportResult"]["a:CIP"]["b:RecordList"]["b:Record"][0]["b:Score"];
                      
              //           // notif
              //           Swal.fire({
              //             title:"<b>Pefindo Biro Kredit ID:"+data.data.PefindoId+"</b>",
              //             html: "<strong>Nilai Personal: <u>"+nilaiP+"</u></strong>",
              //             type: "info",
              //             showCancelButton: true,
              //             confirmButtonClass: "btn-danger",
              //             confirmButtonText: "Terapkan",
              //             cancelButtonText: "Batal",
              //             closeOnConfirm: true,
              //             closeOnCancel: true
              //           }).then((result) => {
              //             $("#scorrePersonal_"+idp).val(nilaiP);
              //           });
              //         }
                      
              //       } else {
              //         swal("Gagal", "Tidak Ada Pefindo Biro Kredit ID", "error");
              //       }
              //     },
              //       error: function(XMLHttpRequest, textStatus, errorThrown) { 
              //       console.log('Status: ' + textStatus); console.log('Error: ' + errorThrown); 
              //   }    
              // })
          })

          
        //})
        
        function getDataBorrower(brw_id,pendanaan_id,ktp,brw_type)
        {
          
          var id_brw = brw_id;
          var brw_type = brw_type;
          var id_pendanaan = pendanaan_id;
          var identitas = ktp;

          //alert(brw_type);
          $('#brw_id').val(id_brw);
          $('#brw_type').val(brw_type);
          $('#pendanaan_id').val(id_pendanaan);
          $('#identitas').val(ktp);

          $('#brw_id2').val(id_brw);
          $('#brw_type2').val(brw_type);
          $('#pendanaan_id2').val(id_pendanaan);
          $('#identitas2').val(ktp)
         
        }

        function getDocScoring(pendanaan_id)
        {
          
          var id_pendanaan = pendanaan_id;

          location.href  = "/admin/getDokumenScoring/"+id_pendanaan;

        }

        function getDocScoringPersonal(pendanaan_id)
        {
          
          var id_pendanaan = pendanaan_id;

          location.href  = "/admin/getDokumenScoringPersonal/"+id_pendanaan;

        }

        getDocScoringPersonal


    </script>

@endsection
