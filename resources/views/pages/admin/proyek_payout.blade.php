@extends('layouts.admin.master')

@section('title', 'Panel Admin')
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Imbal Hasil</h1>
                    </div>
                </div>
            </div>
</div>

<div class="content mt-3">
        @if(session()->has('progressadd'))
            <div class="alert alert-danger">
                {{ session()->get('progressadd') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->has('updatedone'))
            <div class="alert alert-success">
                {{ session()->get('updatedone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->has('createdone'))
            <div class="alert alert-info">
                {{ session()->get('createdone') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
							<button id="generate_harilibur" class="btn btn-success" data-target="#tambah" style="margin-left: 15px;">Hasilkan Hari Libur</button>
							<button data-id="0" class="btn btn-warning payout7harikedepan" data-target="#modalpayout7harikedepan" data-toggle="modal" style="margin-left: 15px;">Payout dalam Seminggu</button>
							<!-- <a href="cetak_payout_mingguan"><button>Cetak Payout dalam Seminggu</button></a> -->
                            
                            <!-- table select all admin -->
                            <table id="proyek_data" class="table table-striped table-bordered table-responsive-sm">
                                <thead>
                                <tr>
                                    <th style="display: none;">Id</th>
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tenor Waktu</th>
                                    <th>Jumlah Pendana</th>
                                    <th>Aksi Pembayaran</th>
                                    {{-- <th>Kemajuan</th> --}}
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <!-- end of table select all -->
    </div><!-- .content -->



<style>
    .modal-xl {
        max-width: 95% !important;
      }
</style>


<div class="modal fade" id="view_detil" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Daftar Pendana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row ">
                            <div class="col-lg-2">Nama</div>
                            <div class="col-lg-2">Nama Rek</div>
                            <div class="col-lg-2">Bank Rek</div>
                            <div class="col-lg-1">Nomer Rek</div>
                            <div class="col-lg-2">Tanggal Pendanaan</div>
                            <div class="col-lg-2">Jumlah Pendanaan</div>
                            <div class="col-lg-1">Detil</div>

                        </div>
                        <hr>
                        <div class="detil_payout p-1">
                        </div>

            </div>
            <div class="modal-footer footer_payout">
            </div>
        </div>
    </div>
</div>





<!-- start modal show payout -->
<div class="modal fade" id="proses_detil" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Proses Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row ">
                            <div class="col-lg-3">Bulan Imbal Hasil</div>
                            <div class="col-lg-2">Tanggal Imbal Hasil</div>
                            <div class="col-lg-2">Status</div>
                            <div class="col-lg-2">Keterangan</div>
                            <div class="col-lg-1">Detil</div>
                            {{--  <div class="col-lg-1">Aksi</div>  --}}
                        </div>
                        <hr>
                        <div class="show_payout p-1"></div>
                        <div class="payout_footer p-1"></div>
            </div>
            {{-- <div class="modal-footer payout_footer"> --}}
            </div>
        </div>
    </div>
</div>
<!-- end modal show payout -->

<!-- start modal payout terdekat -->
<div class="modal fade" id="modalpayout7harikedepan" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Payout Minggu Ini <button id="action" class="btn btn-primary btn-sm">Kemarin</button></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-warning" disabled>Sorting Payout</button>
                <button  data-id="0" class="btn btn-secondary payout7harikedepan">Kemarin</button>
                <button  data-id="1" class="btn btn-secondary payout7harikedepan">Hari Ini</button>
                <button  data-id="2" class="btn btn-secondary payout7harikedepan">Besok</button>
                <button  data-id="3" class="btn btn-secondary payout7harikedepan">+2 Hari</button>
                <button  data-id="4" class="btn btn-secondary payout7harikedepan">+3 Hari</button>
                <button  data-id="5" class="btn btn-secondary payout7harikedepan">+4 Hari</button>
                <button  data-id="6" class="btn btn-secondary payout7harikedepan">+5 Hari</button>
                <button  data-id="7" class="btn btn-secondary payout7harikedepan">+6 Hari</button>
            </div>
            <hr>
                        <div class="row ">
                            <div class="col-lg-1">No</div>
                            <div class="col-lg-4">Nama Proyek</div>
                            <div class="col-lg-4">Tanggal Payout Terdekat</div>
                            <div class="col-lg-3">Hari Pembayaran</div>
                            {{-- <div class="col-lg-2">Detil</div> --}}
                        </div>
                        <hr>
                        <div class="show_p7hk p-1"></div>
                        <!-- <div class="payout_footer p-1"></div> -->
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- end modal payout terdekat -->





    <!-- 2. GOOGLE JQUERY JS v3.2.1  JS !-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

    <script src="/tinymce/js/tinymce/tinymce.min.js"></script>
    <script src="/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
    {{-- <script src="//cdn.ckeditor.com/4.11.2/full/ckeditor.js"></script>
    <script>
            CKEDITOR.replaceAll(textarea, function(){
                    extraPlugins = 'uploadimage';
                    extraPlugins: 'easyimage';
            });

    </script> --}}
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready( function(){

                $('#jumlah').val('');
                $('#penggalangan_mulai,#penggalangan_selesai').on('keypress keydown keyup change', function(){
                    // alert('teh')
                    var date1 = new Date($('#penggalangan_mulai').val());
                    var date2 = new Date($('#penggalangan_selesai').val());
                    if ( date2 < date1){
                        $('#data_error').attr('style','display:block');
                        $('#jumlah').val('');
                    }
                    else
                    {
                    var timeDiff = Math.abs(date1.getTime() - date2.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    $('#jumlah').val(diffDays);
                    console.log(diffDays)
                    }
                });
            });
    </script>
    <script type="text/javascript">

        $(document).ready(function() {

           var proyekTable = $('#proyek_data').DataTable({
                searching: true,
                processing: true,
                "order": [[1,"asc" ]],
                ajax: {
                    url: '/admin/proyek/admin_get_manage_imbal',
                    dataSrc: 'data'
                },
                paging: true,
                info:true,
                lengthChange:false,
                pageLength:10,
                columns: [
                    {data: 'id'},
                    { data : null,
                        render: function (data, type, row, meta) {
                              //I want to get row index here somehow
                              return  meta.row+1;
                        }
                    },
                    {data: 'nama'},
                    {data: 'tgl_mulai'},
                    {data: 'tenor_waktu'},
                    // {data: 'terkumpul', render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'total'},
                    // {data: null,
                    //     render:function(data,type,row,meta){
                    //         return '<button class="btn btn-info " data-toggle="modal" data-target="#proyek_detil" id="detil_proyek">Detil</button>';

                    //     }
                    // },
                    {data:null,
                        render:function(data,type,row,meta){
                            return '<button class="btn btn-info" class="btn btn-info" data-toggle="modal" data-target="#view_detil" id="detil_payout">Rekap</button> <button class="btn btn-info" data-toggle="modal" data-target="#proses_detil" id="view_payout">Daftar Bulan</button>';
                            // <button class="btn btn-warning" id="generate">Generate</button>' test;
                        }
                    },
                    // {data: null,
                    //     render:function(data,type,row,meta){
                    //         return '<button class="btn btn-primary" data-toggle="modal" data-target="#progress_show" id="detil_progress"><span class="ti-list"></span></button>'
                    //               +'<button class="btn btn-success" data-toggle="modal" data-target="#progress_create" id="creat_progress"><span class="ti-plus"></span></button>';
                    //     }
                    // },
                    {data: null,
                        render:function(data,type,row,meta){
                            if ( row.status == 1 ) {
                                return '<p style="color:green">Active</p>';
                            }
                            else if ( row.status == 2 ) {
                                return '<p style="color:grey">Closed</p>';
                            }
                            else if ( row.status == 3 ) {
                                return '<p style="color:red">Full</p>';
                            }
                            else
                            {
                                return '<p style="color:red">-</p>';
                            }

                        }
                    },

                ],
                columnDefs: [
                    { targets: [0], visible: false}
                ]
            })
            var id;

            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
            };


            // view

            $('#proyek_data tbody').on('click','#generate', function(){
                var data = proyekTable.row($(this).parents('tr')).data();
                $(this).prop('disabled',true);
                did = data.id;
                $.ajax({
                    url : "manage_payout/"+did,
                    method : "post",
                    success:function(data)
                    {
                        if(data.Success)
                        {
                            swal('Berhasil','Kembali Dana Selesai','success');
                             window.location.reload();

                        }
                    }
                })

            })

            $("#proyek_data tbody").on('click','#detil_payout', function(){
                var data = proyekTable.row($(this).parents('tr')).data();
                did = data.id;

                var data_id;
                var user_id;
                var investor = [];
                var data_investasi = [];
                $.ajax({
                    url: "/admin/proyek/detil_payout/"+did,
                    method: 'get',
                    success:function(data)
                    {
                        data = data.data
                        console.log(data)
                        // if(data.create){
                        //     alert('Generate Creat New');
                        // }
                        $('.detil_payout').html('');
                        $.each(data, function(index,value){
                            var date = new Date(value.tanggal_invest)
                            // var date2 = new Date(value.created_at)
                            var datereal =  date.getDate() + '/' + (date.getMonth() + 1) + '/' +  date.getFullYear()
                            var databefore = parseInt(value.total_dana)+parseInt(value.nominal);
                            user_id = value.id
                            pid = value.id
                            // var datereal2 = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear()
                            $('#view_detil').find('.detil_payout').append(
                                '<div class="row mb-2">'+
                                    '<div  hidden>'+value.id+'</div>'+
                                    '<div class="col-2">'+value.nama_investor+'</div>'+
                                    '<div class="col-2">'+value.nama_pemilik_rek+'</div>'+
                                    '<div class="col-2">'+value.nama_bank+'</div>'+
                                    '<div class="col-1">'+value.rekening+'</div>'+
                                    '<div class="col-2">'+datereal+'</div>'+
                                    '<div class="col-2">Rp. '+formatNumber(parseInt(value.total_dana))+'</div>'+
                                    '<div class="col-1"><a href="#user_payout_'+value.id+'" id="detil_user_'+value.id+'" class="btn btn-primary" data-toggle="collapse">Detil</a>'+

                                '</div>'+
                                '<hr>'+
                                    '<div id="user_payout_'+value.id+'" style="height:300px;background-color:#EFEEEE;" class="collapse col-12"><div class="list">'+
                                    '</div></div>'+
                                '<hr>'
                            )

                            $('.footer_payout').html(" ");
                            $('.footer_payout').append(
                                '<div class="col-12">'+
                                    '<div class="col-6 float-left"></div>'+
                                    '<div class="col-6 float-right">'+
                                            '<div class="col-lg-2 float-right"><button id="" data-dismiss="modal" class="btn btn-info float-right">Close</button></div>'+
                                    '</div>'+
                                '</div>'
                            )

                            investor.push(value.investor_id)
                            data_investasi.push(value.total_dana)


                            $('.detil_payout').on('click','#detil_user_'+value.id, function(){
                                $.ajax({
                                    url :'detil_payout_user/'+value.id,
                                    method:'get',
                                    dataType: 'json',
                                    success:function(data)
                                    {
                                        item = data.data
                                        sum = data.sum
                                        console.log(sum)
                                        $('#user_payout_'+value.id+'').find('.list').html('')
                                        $('#user_payout_'+value.id+'').find('.list').append(
                                            '<div class="row mb-1">'+
                                                    //'<div class="col-lg-2">Total Dana</div>'+
                                                    '<div class="col-lg-2">Total Dana Invest</div>'+
                                                    '<div class="col-lg-2">Total Jumlah Imbal Hasil</div>'+
                                                    '<div class="col-lg-2">Total Proposional</div>'+
                                                    '<div class="col-lg-2">Total Sisa Imbal</div>'+

                                            '</div>'+
                                            '<div class="row mb-3">'+
                                                //'<div class="col-2">Rp. '+formatNumber(parseInt(item.total_dana))+'</div>'+
                                                '<div class="col-2">Rp. '+formatNumber(parseInt(item.total_dana))+'</div>'+
                                                '<div class="col-2">Rp. '+formatNumber(parseInt(sum))+'</div>'+
                                                '<div class="col-2">Rp. '+formatNumber(parseInt(item.proposional))+'</div>'+
                                                '<div class="col-2">Rp. '+formatNumber(parseInt(item.sisa_imbal))+'</div>'+
                                            '</div>'
                                        )
                                    }
                                })
                            })
                        });

                    }
                });

            });

            // proses bayar
            $('#proyek_data tbody').on('click', '#view_payout',function(){
                var data = proyekTable.row($(this).parents('tr')).data();
                id = data.id;

                var data_id =[];
                var date_id ;
                var pendanaan_id = [];


                var xx=0;
                $.ajax({
                    url: "/admin/proyek/manage_detil_payout/"+id,
                    method: 'get',
                    success:function(data)
                    {
                        detil = data.data_payout;
                        console.log(data)
                        $('.footer-month').html('');
                        $('.show_payout').html('');
                        var pjg = detil.length-1;//sih
                        var pnjg = pjg+1;//dp
                        // console.log(pjg);
                        $.each(detil, function(index,value){
                            xx++;
                            var title = '';
                            var flag = '';
                            $('.detil_data'+value.id).append('');
                                if(xx == pjg){
                                    title = 'Sisa Imbal Hasil';
                                    flag = 'sih';
                                }else if(xx == pnjg){
                                    title = 'Dana Pokok';
                                    flag = 'dp';
                                }else{
                                    title = 'Bulan '+xx;
                                }
                                // variabel row
                            var rowlist = '<div class="row">'+
                                        '<div class="col-lg-3">'+ title +'</div>'+
                                        '<div class="col-lg-2" ><input type="hidden" class="date_payout_'+id+'_'+value.id+'" value="'+ value.tanggal_payout +'">'+ value.tanggal_payout +'<br>'+ value.ket_weekend+'</div>'+
                                        '<div class="col-lg-2"> ' + '<button class="btn btn-warning" disabled > Pending </button>' + ' </div>'+
                                        '<div class="col-lg-2"><input id="libur_ket_'+id+'_'+value.id+'" name="keterangan_libur" placeholder="Keterangan Libur" value="'+(value.keterangan_libur != null ? value.keterangan_libur : '')+'"  class="form-control " rows="1"></input>' + '<button class="btn btn-primary float-right form-control" id="libur_'+id+'_'+value.id+'"> Submit </button>' +'</div>'+
                                        '<div class="col-lg-1"> '+ '<a href="#detil_data'+value.id+'" class="btn btn-info" id="detil_month'+id+'_'+value.id+'" data-toggle="collapse"> Daftar Pendana </a>' +'</div>'+

                                        '</div>'+
                                        '<hr>'+
                                        '<div id="detil_data'+value.id+'" style="height:auto;background-color:#EFEEEE;" class="collapse m-1 p-1">'+
                                            '<div class="row ">'+
                                                '<div class="col-lg-2"><b>Nama Pendana</b></div>'+
                                                '<div class="col-lg-2"><b>Tanggal Payout</b></div>'+
                                                '<div class="col-lg-1"><b>Imbal Hasil</b></div>'+
                                                '<div class="col-lg-2"><b>Dana </b></div>'+
                                                '<div class="col-lg-2"><b>Status</b><br>'+
                                                '</div>'+
                                                '<div class="col-lg-3"><b>Keterangan</b></div>'+
                                            '</div>'+
                                        '<hr>'+
                                        '<hr>'+
                                            '<div class="list-month p-2">'+
                                            '</div>'+
                                            '<div class="footer-month p-2">'+
                                            '</div>'+
                                        '</div>'+
                                        '<hr>';
                            // pengecekan status
                            var pilTrfOrSimpan = '';
                            if(value.status_payout == 5){
                                if(xx == pjg){//sih
                                    // if(value.imbal_payout == 0){
                                    //     $('#proses_detil').find('.show_payout').append('');
                                    // }else{
                                        $('#proses_detil').find('.show_payout').append(rowlist);
                                    // }
                                }else if(xx == pnjg){//dp
                                    $('#proses_detil').find('.show_payout').append(rowlist);
                                }else{
                                    $('#proses_detil').find('.show_payout').append(rowlist);
                                }
                                    
                                $('#libur_'+id+'_'+value.id).on('click', function(){
                                    $(this).prop('disabled',true);
                                    var ket_libur = $('#libur_ket_'+id+'_'+value.id).val();
                                    var date_ket = value.tanggal_payout;
                                    console.log(ket_libur)
                                    $.ajax({
                                        url:'keterangan_libur',
                                        method: 'post',
                                        dataType: 'json',
                                        data:{id:id, ket_libur:ket_libur,date_ket:date_ket},
                                        success:function(data)
                                        {
                                            if(data.sukses)
                                            {
                                                alert('Libur Telah Tiba.');
                                            }
                                        }
                                    })
                                    pendanaan_id.push(value.pendanaan_id)

                                })

                                $('#detil_month'+id+'_'+value.id).on('click', function(){
                                    var date = $('.date_payout_'+id+'_'+value.id).val();
                                    console.log(flag);
                                    $.ajax({
                                        url: 'detil_month_payout',
                                        method : 'post',
                                        dataType: 'json',
                                        data:{data_id:id,date_id:date,flag_id:flag},
                                        success:function(data)
                                        {
                                            item = data.data

                                            var ket_id =[];
                                            var status_id =[];
                                            $('#detil_data'+value.id).find('.list-month').html('');
                                            '<form id="'+data.pendanaan_id+'">'+
                                            $('#detil_data'+value.id).find('.footer-month').html('')
                                             if(flag == 'sih'){
                                                    pilTrfOrSimpan = '<select class="form-control select" nama="status_note" id="status_note_'+data.pendanaan_id+'"><option value="2">Transfer</option><option value="4">Simpan</option></select>';
                                                }else if(flag == 'dp'){
                                                    pilTrfOrSimpan = '<input type="hidden" nama="status_note" id="status_note_'+data.pendanaan_id+'" value="4" ><input class="form-control select" type="text" placeholder="Dialokasikan Ke Dana Tersedia" disabled>';
                                                }else{
                                                    pilTrfOrSimpan = '<select class="form-control select" nama="status_note" id="status_note_'+data.pendanaan_id+'"><option value="2">Transfer</option><option value="4">Simpan</option></select>';
                                                }
                                            $.each(item, function(index,data){
                                                var date = new Date(data.tanggal_payout)
                                                var datepay = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
                                                $('#detil_data'+value.id).find('.list-month').append(
                                                    '<div class="row mb-3">'+
                                                        '<div class="col-lg-2">'+data.nama_investor+'</div>'+
                                                        '<div class="col-lg-2">'+datepay+'</div>'+
                                                        '<div class="col-lg-1">Rp. '+formatNumber(parseInt(data.imbal_payout))+'</div>'+
                                                        '<div class="col-lg-2">Rp. '+formatNumber(parseInt(data.total_dana))+'</div>'+
                                                        '<div class="col-lg-2">'+
                                                        '<div class="form-group">'+
                                                        pilTrfOrSimpan+
                                                            // '<select class="form-control select" nama="status_note" id="status_note_'+data.pendanaan_id+'">'+
                                                                //'<option>None</option>'+
                                                                    //'<option value="5">Proyek Berjalan</option>'+
                                                                    // '<option value="3">Dalam Proses</option>'+
                                                                    // '<option value="2">Transfer</option>'+
                                                                    // '<option value="4">Simpan</option>'+
                                                                    //'<option value="1">Failed</option>'+
                                                            // '</select>'+
                                                        '</div>'+
                                                        '</div>'+
                                                        '<div class="col-lg-3"><input id="text_'+data.pendanaan_id+'" name="keterangan_libur" class="form-condaftaraefajsdofdjol text" rows="1"></input></div>'+
                                                    '</div>'+
                                                    '<hr>'
                                                )
                                            })
                                            
                                            $('.status_note').on('change', function() {
                                                var values = $(this).val();
                                                $('.select').val(values)
                                                // do whatever you want with 'values'
                                            });
                                            $('#detil_data'+value.id).find('.footer-month').append(
                                                '<div class="row mb-3">'+
                                                    '<div class="col-12"><button id="submit_'+id+'_'+value.id+'" class="btn btn-info float-right mr-5">Submit</button></div>'+
                                                '</div>'+
                                                '<hr>'
                                            )

                                            $('#submit_'+id+'_'+value.id).on('click', function(){
                                                $(this).prop('disabled',true);
                                                $('.text').each(function(){
                                                    ket_id.push($(this).val());
                                                });
                                                $('.select').each(function(){
                                                    status_id.push($(this).val());
                                                });
                                                console.log(status_id)

                                                $.ajax({
                                                    url:"kirim_imbal_hasil",
                                                    method: 'post',
                                                    dataType: 'json',
                                                    data:{data_id:id,date_id:date,ket_id:ket_id,status_id:status_id,flag_id:flag},
                                                    success:function(data)
                                                    {
                                                       if(data.sukses == 'Sukses'){
                                                           swal('Berhasil','Payout Month Selesai','success');
                                                            window.location.reload();
                                                       }
                                                    }
                                                })
                                            })
                                        }
                                    })

                                });
                            }

                            else
                            {
                                $('#proses_detil').find('.show_payout').append(
                                    '<div class="row">'+
                                    '<div class="col-lg-3">'+ title +'</div>'+
                                    '<div class="col-lg-2" ><input type="hidden" class="date_payout_'+id+'_'+value.id+'" value="'+ value.tanggal_payout +'">'+ value.tanggal_payout+'<br>'+ value.ket_weekend+'</div>'+
                                    '<div class="col-lg-2">' + '<button class="btn btn-success" disabled > Terbayar </button>' + '</div>'+
                                    '<div class="col-lg-2"></div>'+
                                    '<div class="col-lg-1"> '+ '<a href="#detil_data'+value.id+'" class="btn btn-info" id="detil_month'+id+'_'+value.id+'" data-toggle="collapse"> List Pendana </a>' +'</div>'+
                                    '<div class="col-lg-1"> '+ '<button class="btn btn-link" id="cetak_data_'+id+'_'+value.id+'" > Cetak Data </button>' +'</div>'+
                                    //'<div class="col-lg-1">' + '<button class="btn btn-danger" id="return_payout_'+id+'_'+value.id+'" > Cancel </button>' + '</div>'+
                                    '</div>'+
                                    '<hr>'+
                                    '<div id="detil_data'+value.id+'" style="height:auto;background-color:#EFEEEE;" class="collapse m-1 p-1">'+

                                    '<div class="row ">'+
                                            '<div class="col-lg-2"><b>Nama Pendana</b></div>'+
                                            '<div class="col-lg-2"><b>Tanggal Payout</b></div>'+
                                            '<div class="col-lg-1"><b>Imbal Hasil</b></div>'+
                                            '<div class="col-lg-2"><b>Dana </b></div>'+
                                            '<div class="col-lg-2"><b>Status</b><br>'+(flag == 'dp' ? '' :
                                                '<select class="form-control status_note_update" nama="status_note" id="">'+
                                                    //'<option>None</option>'+
                                                    //'<option value="5">Proyek Berjalan</option>'+
                                                    // '<option value="3">Dalam Proses</option>'+
                                                    '<option value="2">Transfer</option>'+
                                                    '<option value="4">Simpan</option>'+
                                                    // '<option value="1">Gagal Transfer</option>'+
                                                '</select>')+
                                            '</div>'+
                                            '<div class="col-lg-3"><b>Keterangan</b></div>'+
                                    '</div>'+
                                    '<hr>'+
                                    '<hr>'+
                                    '<div class="list-month p-2">'+
                                    '</div>'+
                                    '<div class="footer-month p-2">'+
                                    '</div>'+
                                    '</div>'+
                                    '<hr>'
                                );

                                $('.status_note_update').on('change', function() {
                                    var values = $(this).val();
                                    $('.select_data').val(values)
                                    // do whatever you want with 'values'
                                });

                                $('#cetak_data_'+id+'_'+value.id).on('click', function(){
                                    $(this).prop('disabled',true);
                                    var date = $('.date_payout_'+id+'_'+value.id).val();
                                    var id_date = value.id;
                                    console.log(id_date)
                                    $.ajax
                                    (
                                        {
                                            url: 'cetak_data_payout',
                                            method:'post',
                                            dataType:'json',
                                            data: {id_date:id_date,date:date},
                                            success:function(data)
                                            {

                                            }
                                        }
                                    )
                                })

                                $('#detil_month'+id+'_'+value.id).on('click', function(){
                                    var date = $('.date_payout_'+id+'_'+value.id).val();
                                    var data_id = [];

                                    $.ajax({
                                        url: 'detil_month_payout',
                                        method : 'post',
                                        dataType: 'json',
                                        data:{data_id:id,date_id:date,flag_id:flag},
                                        success:function(data)
                                        {

                                            item = data.data
                                            var ket_id=[];
                                            var status_id=[];
                                            console.log(item)
                                            $('#detil_data'+value.id).find('.list-month').html('');
                                            $('#detil_data'+value.id).find('.footer-month').html('');
                                            $('.select').html()
                                            $.each(item, function(index,data){
                                                var dana_id = data.pendanaan_id;
                                                var date = new Date(data.tanggal_payout)
                                                var datepay = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear()
                                                var time = data.tanggal_payout;
                                                //console.log(value.pendanaan_id)

                                                $('#detil_data'+value.id).find('.list-month').append(
                                                    '<div class="row mb-3">'+
                                                        '<div class="col-lg-2">'+data.nama_investor+'</div>'+
                                                        '<div class="col-lg-2">'+datepay+'</div>'+
                                                        '<div class="col-lg-1">Rp. '+formatNumber(parseInt(data.imbal_payout))+'</div>'+
                                                        '<div class="col-lg-2">Rp. '+formatNumber(parseInt(data.total_dana))+'</div>'+
                                                        '<div class="col-lg-2">'+
                                                        '<div class="form-group">'+(flag == 'dp' ? '<input type="hidden" nama="status_note" id="status_note_'+data.pendanaan_id+'" value="4" ><input class="form-control select" type="text" placeholder="Dialokasikan Ke Dana Tersedia" disabled>':
                                                            '<select class="form-control data select_data" name="status_note"  id="status_note_'+data.pendanaan_id+'">'+
                                                                // '+(data.status_payout == 2 || data.status_payout == 4 ? '-': 'select_data')+'
                                                                // '+( data.status_payout == 2 || data.status_payout == 4  ? 'disabled': '')+'
                                                                //'<option>None</option>'+

                                                                //'<option value="5"  '+(data.status_payout == 5 ? 'selected="selected"' : '')+'>Proyek Berjalan</option>'+
                                                                // '<option value="3"  '+(data.status_payout == 3 ? 'selected="selected""' : '')+'>Dalam Proses</option>'+
                                                                '<option value="2"  '+(data.status_payout == 2 ? 'selected="selected"' : '')+'>Transfer</option>'+
                                                                '<option value="4"  '+(data.status_payout == 4 ? 'selected="selected"': '')+'>Simpan</option>'+
                                                                // '<option value="1"  '+(data.status_payout == 1 ? 'selected="selected""' : '')+'>Gagal Transfer</option>'+

                                                                //'<option value="5" '+(data.status_payout == 5 ? 'selected="selected"' : '')+'>Proses</option>'+
                                                                //'<option value="1" '+(data.status_payout == 1 ? 'selected="selected"' : '')+'>Failed</option>'+
                                                                //'<option value="2" '+(data.status_payout == 2 ? 'selected="selected"' : '')+'>Success</option>'+
                                                            '</select>')+
                                                        '</div>'+
                                                        '</div>'+
                                                        '<div class="col-lg-3"><input id="text_'+data.pendanaan_id+'"  name="keterangan_libur" value="'+data.keterangan+'" class="form-control text_update" '+( data.status_payout == 2 ? 'disabled': '')+' rows="1"></input></div>'+
                                                        //'<div class="col-lg-1"><button id="update_'+id+'_'+data.pendanaan_id+'" '+(data.status_payout == 2 ? 'disabled="disabled"' : '')+' class="btn btn-info float-right mr-5">Perbaharui</button></div>'+
                                                    '</div>'+
                                                    '<hr>'
                                                )
                                                //$('.status_note_update').on('click', function() {
                                                  //  var values = $(this).val();
                                                   // $('.select_data').val(values)
                                                    // do whatever you want with 'values'
                                                //});


                                            })
                                            $('#detil_data'+value.id).find('.footer-month').append(
                                                '<div class="row mb-3">'+
                                                    '<div class="col-12"><button id="update'+id+'_'+value.id+'" class="btn btn-info float-right mr-5">Submit</button></div>'+
                                                '</div>'+
                                                '<hr>'
                                            )


                                            $('#update'+id+'_'+value.id).on('click', function(){
                                                $(this).prop('disabled',true);
                                                $('.text_update').each(function(){
                                                    ket_id.push($(this).val());
                                                });
                                                $('.data').each(function(){
                                                    status_id.push($(this).val());
                                                });
                                                console.log(status_id)

                                                $.ajax({
                                                    url:"update_imbal_hasil",
                                                    method: 'post',
                                                    dataType: 'json',
                                                    data:{data_id:id,date_id:date,ket_id:ket_id,status_id:status_id,flag_id:flag},
                                                    success:function(data)
                                                    {
                                                       if(data.sukses == 'Sukses'){
                                                           swal('Berhasil','Payout Month Selesai','success');
                                                            window.location.reload();
                                                       }
                                                    }
                                                })
                                            })

                                        }
                                    })

                                });



                                //$('#return_payout_'+id+'_'+value.id).on('click', function(){
                                //
                                //    var date = $('.date_payout_'+id+'_'+value.id).val()
                                //   $.ajax({
                                //        url:"change_status_return",
                                //        method: 'post',
                                //        dataType: 'json',
                                //        data:{data_id:id,date_id:date},
                                //        success:function(data)
                                //        {
                                //           if(data.sukses = 'Sukses'){
                                //               swal('Berhasil','Payout Cancel Selesai','cancel');
                                //                window.location.reload();
                                //           }
                                //        }
                                //    })
                                //})
                            }

                        });




                    }
                });



            });


			$('#generate_harilibur').on( 'click', function () {

				$.ajax({
					url:"hari_libur",
					method:'post',
					dataType:'json',
					success:function(data)
					{
						console.log(data);
						if (data.status == 'Sukses')
						{
							alert('Sukses Generate');
						}
					},
					error:function(error){
						alert('ada error nih!');
					}
				  })
            });

            $('.payout7harikedepan').on('click', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "payout7tdk/"+id,
                    method: 'get',
                    success:function(data)
                    {
                        detil = data.payoutseven;
                        $('.show_p7hk').html('');
                        var no = 1;
                        $.each(detil, function(index,value){
                            var remain;
                            switch(value.sisa_tanggal) {
                            case 0:
                                remain = 'Kemarin';
                                break;
                            case 1:
                                remain = 'Hari Ini';
                                break;
                            case 2:
                                remain = 'Besok';
                                break;
                            default:
                                remain = value.sisa_tanggal-1+' Hari Lagi';
                            }
                            
                            var rowlist = '<div class="row">'+
                                        '<div class="col-lg-1">'+ no++ +'</div>'+
                                        '<div class="col-lg-4" >'+ value.nama +'</div>'+
                                        '<div class="col-lg-4" >'+ value.tanggal_payout +'</div>'+
                                        '<div class="col-lg-3" >'+ remain +'</div>'+
                                        // '<div class="col-lg-2" >'+ detil +'</div>'+

                                        '</div>';
                            
                            $('#modalpayout7harikedepan').find('.show_p7hk').append(rowlist);
                            $('#action').text("Cetak Daftar Payout "+remain);
                            $("#action").attr("data-id",value.sisa_tanggal);
                        });
                    }
                });
                
            });

            $('#action').on('click', function(){
                var id = $(this).attr('data-id');
                window.location='cetak_payout_mingguan/'+id;
                // $.ajax({
                //     url: "cetak_payout_mingguan/"+id,
                //     method: 'get',
                //     success:function(data)
                //     {
                //         alert('sukses');
                //     }
                // });
            });

        });
    </script>


@endsection
