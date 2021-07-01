@extends('layouts.user.sidebar')

@section('title', 'Mutasi Pendana')

@section('content')
<style>
	.dataTables_paginate { 
	   float: right; 
	   text-align: right; 
  }
  .dataTables_processing { 
    z-index: 1;
  }
</style>
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
		<div class="col-sm-12">
			<h2>Mutasi Pendana</h2>
		</div>
  </div>
  <hr>
  <div class="if_container">
    <div class="if_table table-responsive-sm">
      <table class="table table-sm table-bordered border-0 display" id="paginated" width="100%">
        <thead>
          {{--  <th>No</th>  --}}
          <th>Keterangan</th>
          <th>Tanggal</th>
          <th>Debit</th>
          <th>Kredit</th>
          <th>Saldo</th>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

    <div class="if_sidebar my-3">
      <div class="if_top mb-3">
        <div class="card border-primary">
          <div class="card-body">
            Total Asset <br>
            Rp. {{number_format($totalDana)}} <br>

          </div>
        </div>
      </div>
      <div class="if_filter">
        <div class="card border-primary">
          <div class="card-header filter_header">
            <span >Pencarian Tanggal</span>
          </div>
          <div class="card-body p-2">
            <div class="form-group">
              <label for="filter1">Tanggal Mulai</label>
              <div class="form-group row">
                <div class="col-12">
                  <input type="date" name="date1"  id="date1" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="filter1">Tanggal Selesai</label>
              <div class="form-group row">
                <div class="col-12">
                  <input type="date" name="date2"  id="date2" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <button  class="btn btn-warning btn-block sbmt-data" id="btn_search" style="color:white;">Cari</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/dataTables.buttons.min.js"></script>
  
  <script>
    $(document).ready(function(){
    
      var table_imbal = $('#paginated').DataTable({
        //processing: true,
            //serverSide: false,
        "bSort": false,
        "paging": true,
        "searching": false,
        ajax: {
          url: '/user/get_list_mutasi_history',
          type: 'get',
        },
        
        "columns" : [
                { "data" : "Keterangan" },
                { "data" : "Tanggal" },
                { "data" : "Debit" },
                { "data" : "Kredit" },
                { "data" : "Saldo" },
                //{ "data" : "Bagi Hasil" }
            ],
        "columnDefs": [{
          "targets": 0,
          class : 'text-center',
          //"visible" : false
        },{
          "targets": 1,
          class : 'text-center',
          "render": function ( data, type, row, meta ) {
            return row['Tanggal'];
          }
          //"visible" : false
        },{
          "targets": 2,
          class : 'text-center',
          //"visible" : false
        }/*,{
          "targets": 3,
          class : 'text-center',
          //"visible" : false
        }*/]
      });

      $("#btn_search").click(function(){

        table_imbal.destroy();			
        var tgl_start = $("#date1").val();
        var tgl_end = $("#date2").val();
        var table_riwayat_param = $('#paginated').DataTable({
          
        "processing": true,
        "serverSide": false,
        "dom": 'tip',
        "bSort": false,
        
        
        "columns" : [
          { "data" : "Keterangan" },
          { "data" : "Tanggal" },
          { "data" : "Debit" },
          { "data" : "Kredit" },
          { "data" : "Saldo" }
        ],
        
        "columnDefs": [{
          "targets": 0,
          class : 'text-left',
          //"visible" : false
        },{
          "targets": 1,
          class : 'text-center',
          //"visible" : false
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
        }]
      });
      table_riwayat_param.ajax.url( "/user/get_params_mutasi_history/"+tgl_start+"/"+tgl_end+"" ).load();
        
      })

    })

    	
  </script>
  
 


@endsection

