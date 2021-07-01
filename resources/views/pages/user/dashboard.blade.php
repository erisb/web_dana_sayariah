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
  .bg-gradient-hijau{
    background: rgb(47,122,21);
    background: -moz-linear-gradient(51deg, rgba(47,122,21,1) 0%, rgba(6,119,87,1) 100%);
    background: -webkit-linear-gradient(51deg, rgba(47,122,21,1) 0%, rgba(6,119,87,1) 100%);
    background: linear-gradient(51deg, rgba(47,122,21,1) 0%, rgba(6,119,87,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#2f7a15",endColorstr="#067757",GradientType=1);
  }
  .bg-gradient-hijau-2{
    background: rgb(21,122,89);
    background: -moz-linear-gradient(51deg, rgba(21,122,89,1) 0%, rgba(6,95,119,1) 100%);
    background: -webkit-linear-gradient(51deg, rgba(21,122,89,1) 0%, rgba(6,95,119,1) 100%);
    background: linear-gradient(51deg, rgba(21,122,89,1) 0%, rgba(6,95,119,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#157a59",endColorstr="#065f77",GradientType=1);
  }
  .bg-gradient-blue{
    background: rgb(21,85,122);
    background: -moz-linear-gradient(51deg, rgba(21,85,122,1) 0%, rgba(6,55,119,1) 100%);
    background: -webkit-linear-gradient(51deg, rgba(21,85,122,1) 0%, rgba(6,55,119,1) 100%);
    background: linear-gradient(51deg, rgba(21,85,122,1) 0%, rgba(6,55,119,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#15557a",endColorstr="#063777",GradientType=1);
  }
</style>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
    <div class="col-8">
      <h2>Beranda</h2>
    </div>
    <div class="col-4">
      @if (isset($rekening->total_dana))
          @if ($rekening->total_dana < 1000000)
            <a href="#" onclick="swal('Sertifikat','Dana Aset Kurang dari Rp. 1.000.000,- ','error')" class="btn btn-danger" disabled>E - Sertifikat</a>
          @else
                <a href="{{route('cekSertifikat',['id' => Auth::user()->id])}}" target="_blank" class="btn btn-success">E - Sertifikat</a>
          @endif
        @else
          <a href="#" onclick="swal('Sertifikat','Dana Aset Kosong','error')" class="btn btn-danger" disabled>E - Sertifikat</a>
        @endif

        {{-- @if ($showKontrak == 'buka' || $cekRegDigiSign == null)
          <button id="kontrak" class="btn btn-success">Akad Wakalah Bil Ujroh</button>
        @elseif ($showKontrak == 'ttd_akhir')
          <button id="kontrak_ttd_akhir" class="btn btn-success">TTD Akad Wakalah Bil Ujroh</button>
        @elseif ($showKontrak == 'ttd_awal')
          <button id="kontrak_ttd_awal" class="btn btn-success">TTD Akad Wakalah Bil Ujroh</button>
        @elseif ($showKontrak == 'unduh')
          <button id="kontrak_unduh_base64" class="btn btn-success">Unduh Akad Wakalah Bil Ujroh</button> 
        @endif --}}
         @php
              echo $showKontrak == 'buka' ? '<button id="unduh_wakalah" class="btn btn-success">Unduh Akad Wakalah</button>' : '';
         @endphp
        <!-- alert -->
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

  <div class="row">
    <div class="col-12">
      <!-- alert -->
      <div id="infoSelamatDatang" class="card shadow rounded mb-3 mt-4 pb-3" style="border-color:#F3FFE4; background-color:#F3FFE4; z-index: 1;">
      <img src="/assets/img/logo-path.gif" style="position: absolute; right: 70px; z-index: -1; opacity: 0.4;" />
        <div class="card-body" style="">    
          <a href="#" onclick="myFunction()"><i class="fa fa-times fa-1x text-secondary" style="right: 40px; position: absolute;"></i></a> 
          <h5 class="card-title bold pt-4 ">Selamat Anda sudah terdaftar sebagai pendana di danasyariah.id </h5>          
          <p class="card-text pt-3 pb-3">Satu langkah lagi untuk menjadi pendana aktif di danasyariah.id yaitu dengan ikut serta di salah satu pendanaan aktif.</p>
          <a href="tutorial" class="text-link pt-4 pb-4 bold underline" style="font-size: .8em;">Lihat Panduan Disini ></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row my-5">
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard rounded bg-gradient-hijau" >
        <div class="card-body" >
          <h5 class="card-title">Total Aset</h5>
          Rp. <span id="total_aset">{{!empty($rekening->total_dana)?number_format($rekening->total_dana,  0, '', '.'):0}}</span>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard rounded bg-gradient-hijau" >
        <div class="card-body" >
          <h5 class="card-title">Dana Tersedia</h5>
          Rp. <span id="dana_tersedia">{{!empty($rekening->unallocated)?number_format($rekening->unallocated,  0, '', '.'):0}}</span>
        </div>
      </div>
    </div>
    <!-- <div class="col-sm-12 col-lg-2">
      <div class="card text-center card_dashboard " style="background-color: limegreen;">
        <div class="card-body">
          <h5 class="card-title">Dana Teralokasi</h5>
          Rp. <span id="bunga_diterima">{{-- !empty($dana_teralokasi)? number_format($dana_teralokasi) : 0 --}}</span>
        </div>
      </div>
    </div> -->
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard rounded rounded bg-gradient-hijau-2" style="background-color: #f86c6b;">
        <div class="card-body" >
          <h5 class="card-title">Penarikan Dana</h5>
          Rp. <span id="dana_tersedia" class="">{{!empty($penarikan_dana)?number_format($penarikan_dana,  0, '', '.'):0}}</span>
          
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-3">
      <div class="card text-center card_dashboard rounded rounded bg-gradient-blue" style="background-color: limegreen;" data-toggle="modal" data-target="#modalDetilAll" id="allDetilImbal" data-toggle="tooltip" data-placement="bottom" title="Lihat Data Imbal Seluruh !">
        <div class="card-body">
          <h5 class="card-title">Bagi Hasil Diterima</h5>
          Rp. <span id="bunga_diterima">{{!empty($payout)? number_format($payout) : 0}}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row my-3">
    <div class="col-sm-12 table-responsive-sm">
      <table class="table border border-secondary" id="table_imbal">
        <thead class="bg-dark text-light">
          <th hidden>id_auth</th>
          <th hidden>id_aktif</th>
          <th hidden>id_tenor</th>
          <th hidden>id_margin</th>
          <th hidden>dana_pro_ok</th>
          <th>Proyek</th>
          <th>Dana Awal</th>
          <th>Tanggal Pendanaan</th>
          <th>Tanggal Mulai Proyek</th>
          <th>Bagi hasil</th>
          {{-- <th>Akad</th> --}}
        </thead>
        <tbody>
          @if(!empty($pendanaan_aktif))
            @foreach ($pendanaan_aktif as $i )
              <tr>
              <td id="id_auth" hidden>{{Auth::user()->id}}</td>
              <!--<td id="id_auth" hidden>{{Auth::user()->id}}</td>-->
              <td id="id_aktif" hidden>{{$i->id}}</td>
              <td id="id_tenor" hidden>{{$i->proyek->tenor_waktu}} Bulan</td>
              <td id="id_margin" hidden>{{number_format($i->proyek->profit_margin,0,'','.')}}% / Tahun</td>
              <td id="dana_pro_ok" hidden>{{$i->nominal_awal}}</td>
              <td id="nama_pro">{{$i->proyek->nama}}</td>
              <td id="dana_pro">Rp. {{number_format($i->nominal_awal,  0, '', '.')}}</td>
              <td id="tgl_pro">{{Carbon\Carbon::parse($i->tanggal_invest)->format('d-m-Y')}}</td>
              <td id="tgl_pro2">{{Carbon\Carbon::parse($i->proyek->tgl_mulai)->format('d-m-Y')}}</td>
              <td class="text-center"><button class="btn sm btn-primary payout_detil_id" data-toggle="modal" data-target="#payout_detil" id="payout_detil_id">Detil Imbal Hasil</button></td>
              {{-- <td class="text-center">
                @php 
                if($cekRegDigiSign == null)
                {
                    $tombolAkadMurobahah = '<button class="btn sm btn-primary akad-murobahah" id="akad_murobahah" disabled>Daftar Akad Murobahah</button>';
                }
                else
                {
                    if($i->status_log != '')
                    {
                        if($i->status_log == 'kirim')
                        {
                            $tombolAkadMurobahah = '<button class="btn sm btn-primary ttd-akad-murobahah" id="ttd_akad_murobahah" onclick="btn_sign_digital_sign('.Auth::user()->id.', '.$i->proyek_id.')" disabled>TTD Akad Murobahah</button>';
                        }
                        else
                        {
                            $tombolAkadMurobahah = '<button class="btn sm btn-primary unduh-akad-murobahah" id="unduh_akad_murobahah" onclick="btn_download_digital_sign('.$i->proyek_id.')" disabled>Unduh Akad Murobahah</button>';
                        }
                    }
                    else
                    {
                        $tombolAkadMurobahah = '<button class="btn sm btn-primary ttd-akad-murobahah" id="ttd_akad_murobahah" disabled>TTD Akad Murobahah</button>';
                    } 
                }
                echo ($i->proyek->status == 2 || $i->proyek->status == 3) ? $tombolAkadMurobahah : '-';
                @endphp
              </td> --}}
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
  <div class="row my-3 mb-5">
    <div class="col-sm-12 d-flex justify-content-around">
      <a href="{{route('add_funds')}}" class="btn btn-secondary">Tambah Dana</a>
      <a href="/user/manage_investation" class="btn btn-secondary">Lihat Proyek Saya</a>
    </div>
  </div>

  <h3><b>Proyek Yang Pernah Didanai</b></h3>
  <div class="row my-3">
    <div class="col-sm-12 table-responsive-sm">
      <table class="table border border-secondary" id="table_didanai">
        <thead class="bg-dark text-light">
      <th>Proyek</th>
      <th>Dana Awal</th>
      <th>Tanggal Pendanaan</th>
      <!--<th>Bagi hasil</th>-->
        </thead>
    <!--
        <tbody>
          {{-- @foreach ($pendanaan_aktif_past as $item_past) --}}
            {{-- @if($item_past->proyek_id !== null) --}}
              <tr>
              {{-- <td >{{$item_past->proyek->nama}}</td> --}}
              {{-- <td >Rp. {{number_format($item_past->jumlah_pendanaan,  0, '', '.')}}</td> --}}
              {{-- <td>{{$item_past->tanggal_invest->toDateString()}}</td> --}}
              <td>-</td>
              </tr>
            {{-- @else --}}
            {{-- @endif --}}
          {{-- @endforeach --}}
        </tbody>
    -->
      </table>
    </div>
  </div>
  <div class="row my-5">
    <div class="col-sm-12 px-0" style="max-width:100%  ">
      <div id="chartContainer"></div>
    </div>
  </div>

  {{-- modal  start detil --}}
  <div class="modal fade modal-detil-imbal" id="payout_detil" tabindex="-1" role="dialog" aria-labelledby="payout_detil" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <input type="hidden" id="id_val_pay">
          <div class="modal-header">
          <h3>Detil Imbal Hasil: </h3>
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
                  <th scope="col">Jumlah Pendanaan</th>
                  <th scope="col">Prospek Hasil Diterima</th>
                </tr>
              </thead>
              <tbody>
                  <tr>
                    <td id="td_nama"></td>
                    <td id="td_margin"></td>
                    <td id="td_tenor"></td>
                    <td id="td_dana"></td>
                    <td id="td_terima"></td>
                  </tr>
              </tbody>
            </table>

            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Bulan</th>
                  <th scope="col">Tanggal Imbal Hasil</th>
                  <th scope="col">Nominal Imbal Hasil</th>
                  <th scope="col">Status Imbal Hasil</th>
                  <th scope="col">Keterangan.</th>
                </tr>
              </thead>

                <tbody id="urutan"></tbody>

            </table>
        </div>
      </div>
    </div>
  </div>
  {{-- modal end --}}

  {{-- Modal Detil Imbal All --}}
  <div class="modal fade bd-example-modal-lg" id="modalDetilAll" tabindex="-1" role="dialog" aria-labelledby="modalDetilAll" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5>Imbal Hasil Seluruh Proyek </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>

        <div class="modal-body">
            <table class="table" id='tableDataAll'>
              <thead class="thead-dark" >
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama Proyek</th>
                  <th scope="col">Tanggal Mulai Proyek</th>
                  <th scope="col">Tanggal Pendanaan</th>
                  <th scope="col">Dana Masuk</th>
                  <th scope="col">Imbal Hasil Diterima</th>
                </tr>
              </thead>

                <tbody></tbody>

            </table>
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>
  {{-- Modal Detil Imbal All End --}}

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

 {{-- Modal Wakalah --}}
  <div id="modalWakalah"  class="modal fade in" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="scrollmodalLabel">Wakalah Bil Ujroh</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body" id="modalBodyWakalah">
              </div>
          </div>
      </div>
  </div>
  {{-- Modal Wakalah End --}}

  <link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />
  <script src="/js/jquery-3.3.1.min.js"></script>
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
  function myFunction() {
    var x = document.getElementById("infoSelamatDatang");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  };


$(document).ready( function(){
  /**/
  var table_imbal = $('#table_imbal').DataTable({
    "dom": 'tip',
    "bSort": false,
    "paging":   false,
    "ordering": false,
    "info":     false,
    
    //"ajax": {
      //url: "/list_history_dana",
    //},
    "columnDefs": [{
      "targets": 0,
      class : 'text-center',
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
      "visible" : false
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
    }]
  });
  
  var table_imbal = $('#table_didanai').DataTable({
    //processing: true,
        //serverSide: false,
    "bSort": false,
    ajax: {
      url: '/user/list_history_didanai',
      type: 'get',
    },
    
    "columns" : [
            { "data" : "Proyek" },
            { "data" : "Dana Awal" },
            { "data" : "Tanggal Invest" },
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
        return row['Dana Awal'];
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

    $(this).closest('tr').find('#id_tenor').text('');
    $(this).closest('tr').find('#id_aktif').text('');
    $(this).closest('tr').find('#id_margin').text('');
    $(this).closest('tr').find('#nama_pro').text('');
    $(this).closest('tr').find('#dana_pro').text('');
    $(this).closest('tr').find('#tgl_pro').text('');

  
  $('.payout_detil_id').on('click', function(){
    var id_tenor = $(this).closest('tr').find('#id_tenor').text();
    var id_data = $(this).closest('tr').find('#id_aktif').text();
    var id_margin = $(this).closest('tr').find('#id_margin').text();
    var id_nama = $(this).closest('tr').find('#nama_pro').text();
    var id_dana = $(this).closest('tr').find('#dana_pro_ok').text();
    var id_tgl = $(this).closest('tr').find('#tgl_pro').text();
    console.log(id_data)
    $('#td_nama').html('')
    $('#td_margin').html('')
    $('#td_tenor').html('')
    $('#td_dana').html('')
    $('#td_terima').html('')
    $("#urutan").html(" ");


    $.ajax({
        url: "/user/get_aktif_dana/"+id_data,
        method: "get",
        success:function(data)
        {

            var xx=0;
            detil_get = data.data;
            prop = data.prop;
            detil = data.item;
            sum = data.datasum;

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
            $('#td_nama').html(id_nama);
            $('#td_margin').html(id_margin)
            $('#td_tenor').html(id_tenor)
            $('#td_dana').html(itemreal)
            $('#td_terima').html(allitreal)

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

            // if(marginprofit != 0.00){
            //     //sisa imbal hasil
            //     $("#urutan").append("<hr>");
            //     $("#urutan").append("<tr>");
            //     $("#urutan").append("<td colspan='2'> Akan dibayarkan setelah masa berakhir Proyek maksimal 7 hari jam kerja </td>");
            //     $("#urutan").append("<td>Rp. " + sisaimbal + "</td>");
            //     $("#urutan").append("<td colspan='2'> <h6><span class='badge badge-info'> Sisa Imbal Hasil Akhir </span><h6> </td>");
            //     $("#urutan").append("</tr>");
            // }
            //     //  dana pokok
            //     $("#urutan").append("<hr>");
            //     $("#urutan").append("<tr>");
            //     $("#urutan").append("<td colspan='2'> Akan dikembalikan ke dana tersedia setelah masa berakhir proyek maksimal 7 hari jam kerja</td>");
            //     $("#urutan").append("<td>Rp. " + danapokok + "</td>");
            //     $("#urutan").append("<td colspan='2'> <h6><span class='badge badge-info'> Dana Pokok </span><h6> </td>");
            //     $("#urutan").append("</tr>");
        }
    })
  })
  

  $('#allDetilImbal').on('click', function(){
    var allDetilTable = $('#tableDataAll').DataTable({
    "bSort": false,
    "destroy": true,
      ajax : {
        url : '/user/getTableDetil',
        type : 'get',
      },
      
      "columns" : [
                {"data" : "no" },
                {"data" : "namaProyek" },
                {"data" : "tglMulai" },
                {"data" : "tglInvest" },
                {"data" : "totalDana" },
                {"data" : "total" },
            ],
        // "columnDefs": [
        // {
        //   "targets": 1,
        //   class : 'text-center',
        //   "render": function ( data, type, row, meta ) {
        //     return row['Tanggal'];
        //   }
        //   //"visible" : false
        // },{
        //   "targets": 3,
        //   class : 'text-center',
        //   //"visible" : false
        // }]
    })
  })

  $('#kontrak').on('click',function(){
      var id_user = {{ Auth::user()->id }};
      var text = "{{ $teks }}";
      console.log(id_user)
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
                          url:'/user/regDigiSign/'+id_user,
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
                                                    if (dataJSON2.hasOwnProperty('JSONFile'))
                                                    {
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
                                                            swal({title:"Notifikasi",text:dataJSON2.JSONFile.notif,type:"info"},
                                                              function(){
                                                                    swal.close()
                                                               }
                                                            );
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if (dataJSON2.result == '14')
                                                        {
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
                                                                    else
                                                                    {
                                                                        swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                                                          function(){
                                                                               location.reload(true);
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
                                                        else
                                                        {
                                                            swal({title:"Notifikasi",text:dataJSON2.notif,type:"info"},
                                                              function(){
                                                                    swal.close()
                                                               }
                                                            );
                                                        }
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
                                      if(regDigiSign == '')
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
                                                          if (dataJSON2.hasOwnProperty('JSONFile'))
                                                          {
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
                                                                  swal({title:"Notifikasi",text:dataJSON2.JSONFile.notif,type:"info"},
                                                                    function(){
                                                                          swal.close()
                                                                     }
                                                                  );
                                                              }
                                                          }
                                                          else
                                                          {
                                                              if (dataJSON2.result == '14')
                                                              {
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
                                                                          else
                                                                          {
                                                                              swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                                                                function(){
                                                                                     location.reload(true);
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
                                                              else
                                                              {
                                                                  swal({title:"Notifikasi",text:dataJSON2.notif,type:"info"},
                                                                    function(){
                                                                          swal.close()
                                                                     }
                                                                  );
                                                              }
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
                                                          else
                                                          {
                                                              swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                                                function(){
                                                                     location.reload(true);
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
                              else if(dataJSON.JSONFile.result == '12')
                              {
                                  swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                                    function(){
                                          swal.close()
                                     }
                                  );
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

  $('#kontrak_ttd_awal').on('click',function(){
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
              else
              {
                  swal({title:"Notifikasi",text:dataJSON.JSONFile.notif,type:"info"},
                    function(){
                         location.reload(true);
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
              
  });

  $('#kontrak_ttd_akhir').on('click',function(){
      var id_user = {{ Auth::user()->id }};
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
  });


  $('#kontrak_unduh').on('click',function(){
      var id_user = {{ Auth::user()->id }};
      console.log(id_user)
      $.ajax({
          url:'/user/downloadDigiSign/',
          method:'post',
          //responseType: "blob",
          data:{id:id_user},
          beforeSend: function(jqXHR,settings) {
              $("#overlay").css('display','block');
          },
          success: function (response) {
              $('#overlay').css('display','none')
              var dataBersih = response.FileContent
              console.log(response)
              var newData = b64toBlob(dataBersih,'',512)
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

  $('#kontrak_unduh_base64').on('click',function(){
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

  $('.akad-murobahah').on('click',function(){
      $('#kontrak').trigger('click');
  });

  $('#modalDetilAll .close,#payout_detil .close,#modalAktivasi .close,#modalTTD .close,#modalWakalah .close').on('click',function(){
      location.reload(true);
  })

});

$('#unduh_wakalah').on('click',function(){
    var user_id = {{ Auth::user()->id }}
    $.ajax({
      url:'/user/generateWakalah/'+user_id,
      method:'get',
      beforeSend: function(jqXHR,settings) {
          $("#overlay").css('display','block');
      },
      success: function (response) {
            $('#overlay').css('display','none')
            // data = JSON.parse(response)
            if (response.status == 'Berhasil')
            {
                
                $('#modalWakalah').modal('show').addClass('modal fade show in').attr('style','display:block')
                $('.modal-backdrop').addClass('modal-backdrop fade show in')
                $('#modalBodyWakalah').append('<iframe id="linkWakalah" scrolling="yes" width="100%" height="500" id="iprem"></iframe>');
                $('#linkWakalah').attr('src',"{{ url('viewWakalah') }}/"+user_id)
                $("#modalWakalah").appendTo('body');
            }
            else
            {
                alert(response.status)
            }

      },
      error: function(request, status, error)
      {
          $("#overlay").css('display','none');
          alert(status)
      }
    });
})

function btn_sign_digital_sign(user_id, proyek_id){
  $.ajax({
      url:'/user/signDigiSignMurobahah/'+user_id+'/'+proyek_id,
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

function btn_download_digital_sign(proyek_id){
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
}

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

<script>
function ser() {
  alert("Tambah Dana kembali");
}
</script>

<script defer>
  window.onload = function () {
    var datapoints = [];
    var options = {
      title: {
        text: ""
      },
      data: [{
        type: "pie",
        percentFormatString: "#0.##",
        startAngle: 45,
        showInLegend: "true",
        legendText: "{label}",
        indexLabel: "{label} ({y})",
        yValueFormatString:"#.##%",
        dataPoints: datapoints,
        }]
      };
    var response = $.get('/user/chart')
      .done((data)=>{
        data = JSON.parse(data);
        const rekening = (data.rekening !== null ? data.rekening : 0);
        var unallocated = parseInt(rekening.unallocated);
        var pendanaan = data.pendanaan;

        pendanaan = pendanaan.map((x) =>{
          return {
            'investasi' : x.proyek.nama,
            'nominal' : parseInt(x.jumlah_pendanaan),
          };
        }).reverse();
        // console.log(pendanaan);
        for(let i = 0; i < pendanaan.length; i++){
          points = {
            y : pendanaan[i].nominal/parseInt(rekening.total_dana),
            label : pendanaan[i].investasi
          };
          datapoints.push(points);
        }
        datapoints.push({y : parseInt(unallocated)/rekening.total_dana, label: 'Dana Tersedia'})
        // console.log(datapoints);
        $('#chartContainer').CanvasJSChart(options);
      });


  }
</script>
@endsection