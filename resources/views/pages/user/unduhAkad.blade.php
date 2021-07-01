@extends('layouts.user.sidebar')

@section('title', 'Unduh Akad')

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
        <h2>Unduh Akad</h2>
    </div>
</div>
<hr>
<div class="row p-3">
    <div class="col-sm-12 my-3 bg-white py-3">
		<div class="section wow fadeInDown delay-02s mt-2" style="background-color: white; box-shadow: 0px 1px 10px 0px grey;">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="deskripsi-tab" data-toggle="tab" href="#penarikan" role="tab" aria-controls="deskripsi" aria-selected="true">Akad Wakalah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="legalitas-tab" data-toggle="tab" href="#histori" role="tab" aria-controls="legalitas" aria-selected="false">Akad Murobahah</a>
                </li>
            </ul>
			<div class="tab-content" id="myTabContent" >
				<div class="tab-pane fade show active" id="penarikan" role="tabpanel" aria-labelledby="deskripsi-tab" style="overflow-x:auto">
					<div class="col-lg-12 col-sm-12 p-3 float-left">
						<div id="DivDescription">
							<div class="row">
								<div class="col-sm-12">
                                    <br/>
                                    <button  class="btn btn-warning sbmt-data" id="unduhWakalah" style="color:white;">Unduh Akad</button><br/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade show" id="histori" role="tabpanel" aria-labelledby="deskripsi-tab" style="overflow-x:auto">
					<div class="col-lg-12 col-sm-12 p-3 float-left"><br>
						<div id="DivDescription">
                        <table class="table table-sm table-bordered border-0 display" id="tableMurobahah" width="100%">
                            <thead>
                                <th style="display: none;">Id</th>
                                <th>No</th>
                                <th>Nama Proyek</th>
                                <th>Akad</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="/admin/assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    //alert(id);
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function() {
			var id_user = {{ Auth::user()->id }};
			var murobahahTable = $('#tableMurobahah').DataTable({
				searching: true,
				processing: true,
				// serverSide: true,
				ajax: {
					url: '/user/ListAkadMurobahah/'+id_user,
					dataSrc: 'data'
				},
				paging: true,
				info: true,
				lengthChange:false,
				order: [ 1, 'asc' ],
				pageLength: 5,
				columns: [
					{ data : 'id_log_akad_investor'},
					{ data : null,
					render: function (data, type, row, meta) {
							//I want to get row index here somehow
							return  meta.row+1;
						}
					},
                    //{ data : 'proyek_id'},
					{ data : 'nama_proyek'},
                    { data : null,
                        render:function(data,type,row,meta){
                            return '<button class="btn btn-warning"> Unduh </button>';
                        }
                    },
				],
				columnDefs: [
					{ targets: [0], visible: false}
				]
			});

            
			$('#tableMurobahah').on( 'click', 'tr', function () {
				if ( $(this).hasClass('selected') ) {
					$(this).removeClass('selected');
				}
				else {
					murobahahTable.$('tr.selected').removeClass('selected');
					$(this).addClass('selected');
				}
			});
			$('#tableMurobahah tbody').on( 'click', 'tr', function (event) {
				var tr = $(this).closest('tr');
				var row = murobahahTable.row( tr );
				var length = murobahahTable.rows('tr.selected').data().length;
				var data = murobahahTable.row($(this).closest('tr')).data();
				var id = $(event.target).parent().data('value');
				//console.log(data.path_file);
				var proyek = data.proyek_id;
                
                $.ajax({
                    url:'/user/downloadBase64DigiSignMurobahah/',
                    method:'post',
                    //responseType: "blob",
                    data:{proyek_id:proyek},
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
        
        $('#unduhWakalah').on('click',function(){
        var id_user = {{ Auth::user()->id }};
        //alert(id_user);
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

</script>
@endsection
