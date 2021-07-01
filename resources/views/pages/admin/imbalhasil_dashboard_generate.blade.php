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
                <h5 class="modal-title" id="mediumModalLabel">Proses Pembayaran <button class="btn btn-info" id='cetak_payout'>Cetak Payout</button></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                        <div class="row ">
                            <div class="col-lg-3">Bulan Imbal Hasil</div>
                            <div class="col-lg-2">Tanggal Imbal Hasil</div>
                            <div class="col-lg-2">Status</div>
                            <!-- <div class="col-lg-2">Keterangan</div> -->
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
                <button  data-id="0" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j");?></button>
                <button  data-id="1" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j", strtotime( '+1 days' ) );?></button>
                <button  data-id="2" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j", strtotime( '+2 days' ) );?></button>
                <button  data-id="3" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j", strtotime( '+3 days' ) );?></button>
                <button  data-id="4" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j", strtotime( '+4 days' ) );?></button>
                <button  data-id="5" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j", strtotime( '+5 days' ) );?></button>
                <button  data-id="6" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j", strtotime( '+6 days' ) );?></button>
                <button  data-id="7" class="btn btn-secondary payout7harikedepan"><?php echo date("m-j", strtotime( '+7 days' ) );?></button>
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
                    url: '/admin/imbalhasil/imbalhasil_DaftarProyekReady',
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
                            if(row.status_rekap == 1){
                                return '<button class="btn" disabled title="sudah direkap">Rekap</button> <button class="btn btn-info" data-toggle="modal" data-target="#proses_detil" id="view_payout">Daftar Bulan</button>';
                            }else{
                                return '<button class="btn btn-info" class="btn btn-info" id="detil_payout">Rekap</button> <button class="btn" title="lakukan rekap terlebih dahulu !" disabled>Daftar Bulan</button>';
                            }
                            
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
                    url: "/admin/imbalhasil/rekapImbal/"+did,
                    method: 'get',
                    success:function(data)
                    {
                        data = data.data
                        console.log(data)
                        if(data == 1){
                            swal('Berhasil','Rekap Berhasil','success');
                            window.location.reload();
                        }else{
                            swal('Gagal','Rekap Gagal','failed');
                            window.location.reload();
                        }
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
                    url: "/admin/imbalhasil/daftarpayout/"+id,
                    method: 'get',
                    success:function(data)
                    {
                        detil = data.data_payout;
                        console.log(data.bulan1)
                        $('.footer-month').html('');
                        $('.show_payout').html('');
                        
                        $.each(detil, function(index,value){
                            xx++;
                            var title = '';
                            var flag = '';
                            $('.detil_data'+value.id).append('');
                                if(value.keterangan_payout == 2){
                                    title = 'Sisa Imbal Hasil';
                                    flag = '2';
                                }else if(value.keterangan_payout == 3){
                                    title = 'Dana Pokok';
                                    flag = '3';
                                }else{
                                    if(value.tanggal_payout == data.bulan1){
                                        title = 'Bulan 1 + Proposional';
                                    }else{
                                        title = 'Bulan '+xx;
                                    }
                                    flag = '1';
                                }
                                // variabel row
                            var rowlist = '<div class="row">'+
                                        '<div class="col-lg-3">'+ title +'</div>'+
                                        '<div class="col-lg-2" ><input type="hidden" class="date_payout_'+id+'_'+value.id+'" value="'+ value.tanggal_payout +'">'+ value.tanggal_payout +'<br>'+ value.ket_libur+'</div>'+
                                        '<div class="col-lg-2"> ' + '<button class="btn btn-warning" disabled > Pending </button>' + ' </div>'+
                                        '<div class="col-lg-1"> '+ '<a href="#detil_data'+value.id+'" class="btn btn-info" id="detil_month'+id+'_'+value.id+'" data-toggle="collapse"> Daftar Pendana </a>' +'</div>'+

                                        '</div>'+
                                        '<hr>'+
                                        '<div id="detil_data'+value.id+'" style="height:auto;background-color:#EFEEEE;" class="collapse m-1 p-1">'+
                                            '<div class="row ">'+
                                                '<div class="col-lg-2"><b>Nama Pendana</b></div>'+
                                                '<div class="col-lg-2"><b>Tanggal Payout</b></div>'+
                                                '<div class="col-lg-1"><b>Imbal Hasil</b></div>'+
                                                '<div class="col-lg-1"><b>Proposional</b></div>'+
                                                '<div class="col-lg-2"><b>Dana </b></div>'+
                                                '<div class="col-lg-2"><b>Status</b><br>'+
                                                '</div>'+
                                                // '<div class="col-lg-3"><b>Keterangan</b></div>'+
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
                            if(value.status_payout == 1){
                                // tampil modal
                                $('#proses_detil').find('.show_payout').append(rowlist);

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
                                        url: 'payoutpendana',
                                        method : 'post',
                                        dataType: 'json',
                                        data:{data_id:id,date_id:date,flag_id:flag},
                                        success:function(data)
                                        {
                                            item = data.data;
                                            console.log(data.jmlpendana);
                                            var status_id =[];
                                            $('#detil_data'+value.id).find('.list-month').html('');
                                            '<form id="'+data.pendanaan_id+'">'+
                                            $('#detil_data'+value.id).find('.footer-month').html('')
                                             if(flag == '3'){
                                                    pilTrfOrSimpan = '<input type="hidden" class="select" nama="status_note" id="status_note_'+data.pendanaan_id+'" value="3" ><input class="form-control" type="text" placeholder="Dialokasikan Ke Dana Tersedia" disabled>';
                                                }else{
                                                    pilTrfOrSimpan = '<select class="form-control select" nama="status_note" id="status_note_'+data.pendanaan_id+'"><option value="2">Transfer</option><option value="3">Simpan</option></select>';
                                                }
                                            
                                            $.each(item, function(index,data){
                                                var date = new Date(data.tanggal_payout)
                                                var datepay = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
                
                                                $('#detil_data'+value.id).find('.list-month').append(
                                                    '<div class="row mb-3">'+
                                                        '<div class="col-lg-2">'+data.nama_investor+'</div>'+
                                                        '<div class="col-lg-2">'+datepay+'</div>'+
                                                        '<div class="col-lg-1">Rp. '+formatNumber(parseInt(data.imbal_payout))+'</div>'+
                                                        '<div class="col-lg-1">Rp. '+formatNumber(parseInt(data.proposional))+'</div>'+
                                                        '<div class="col-lg-2">Rp. '+formatNumber(parseInt(data.total_dana))+'</div>'+
                                                        '<div class="col-lg-2">'+
                                                        '<div class="form-group">'+pilTrfOrSimpan+
                                                        '</div>'+
                                                        '</div>'+
                                                        // '<div class="col-lg-3"><input id="text_'+data.pendanaan_id+'" name="keterangan_libur" class="form-condaftaraefajsdofdjol text" rows="1"></input></div>'+
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
                                                $('.select').each(function(){
                                                    status_id.push($(this).val());
                                                });
                                                console.log(status_id);

                                                $.ajax({
                                                    url:"kirimimbal",
                                                    method: 'post',
                                                    dataType: 'json',
                                                    data:{data_id:id,date_id:date,status_id:status_id,flag_id:flag,jmlpendana:data.jmlpendana},
                                                    success:function(data)
                                                    {
                                                       if(data.sukses == 1){
                                                            swal('Berhasil','Payout Month Selesai','success');
                                                       }else{
                                                           swal('Gagal Rekap','Payout Month Belum Ter Rekap','failed');
                                                       }
                                                       window.location.reload();
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
                                    '<div class="col-lg-2" ><input type="hidden" class="date_payout_'+id+'_'+value.id+'" value="'+ value.tanggal_payout +'">'+ value.tanggal_payout+'<br>'+ value.ket_libur+'</div>'+
                                    '<div class="col-lg-2">' + '<button class="btn btn-success" disabled > Terbayar </button>' + '</div>'+
                                    '<div class="col-lg-1"> '+ '<a href="#detil_data'+value.id+'" class="btn btn-info" id="detil_month'+id+'_'+value.id+'" data-toggle="collapse"> List Pendana </a>' +'</div>'+
                                    // '<div class="col-lg-1"> '+ '<button class="btn btn-link" id="cetak_data_'+id+'_'+value.id+'" > Cetak Data </button>' +'</div>'+
                                    //'<div class="col-lg-1">' + '<button class="btn btn-danger" id="return_payout_'+id+'_'+value.id+'" > Cancel </button>' + '</div>'+
                                    '</div>'+
                                    '<hr>'+
                                    '<div id="detil_data'+value.id+'" style="height:auto;background-color:#EFEEEE;" class="collapse m-1 p-1">'+

                                    '<div class="row ">'+
                                            '<div class="col-lg-2"><b>Nama Pendana</b></div>'+
                                            '<div class="col-lg-2"><b>Tanggal Payout</b></div>'+
                                            '<div class="col-lg-1"><b>Imbal Hasil</b></div>'+
                                            '<div class="col-lg-1"><b>Proposional</b></div>'+
                                            '<div class="col-lg-2"><b>Dana </b></div>'+
                                            '<div class="col-lg-2"><b>Status</b><br>'+(flag == '3' ? '' :
                                                '<select class="form-control status_note_update" nama="status_note" id="">'+
                                                    '<option style="display:none">--Pilih--</option>'+
                                                    '<option value="2">Transfer</option>'+
                                                    '<option value="3">Simpan</option>'+
                                                '</select>')+
                                            '</div>'+
                                            // '<div class="col-lg-3"><b>Keterangan</b></div>'+
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
                                    window.location='cetak_data_payout/'+id;
                                    console.log(id_date)
                                })

                                

                                $('#detil_month'+id+'_'+value.id).on('click', function(){
                                    var date = $('.date_payout_'+id+'_'+value.id).val();
                                    var data_id = [];

                                    $.ajax({
                                        url: 'payoutpendana',
                                        method : 'post',
                                        dataType: 'json',
                                        data:{data_id:id,date_id:date,flag_id:flag},
                                        success:function(data)
                                        {

                                            item = data.data;
                                            console.log(data.jmlpendana);
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
                                                        '<div class="col-lg-1">Rp. '+formatNumber(parseInt(data.proposional))+'</div>'+
                                                        '<div class="col-lg-2">Rp. '+formatNumber(parseInt(data.total_dana))+'</div>'+
                                                        '<div class="col-lg-2">'+
                                                        '<div class="form-group">'+(flag == '3' ? '<input type="hidden" nama="status_note" id="status_note_'+data.pendanaan_id+'" value="3" ><input class="form-control select" type="text" placeholder="Dialokasikan Ke Dana Tersedia" disabled>':
                                                            '<select class="form-control data select_data" name="status_note"  id="status_note_'+data.pendanaan_id+'">'+
                                                                '<option value="2"  '+(data.status_payout == 2 ? 'selected="selected"' : '')+'>Transfer</option>'+
                                                                '<option value="3"  '+(data.status_payout == 3 ? 'selected="selected"': '')+'>Simpan</option>'+
                                                            '</select>')+
                                                        '</div>'+
                                                        '</div>'+
                                                        //'<div class="col-lg-3"><input id="text_'+data.pendanaan_id+'"  name="keterangan_libur" value="'+data.keterangan+'" class="form-control text_update" '+( data.status_payout == 2 ? 'disabled': '')+' rows="1"></input></div>'+
                                                        //'<div class="col-lg-1"><button id="update_'+id+'_'+data.pendanaan_id+'" '+(data.status_payout == 2 ? 'disabled="disabled"' : '')+' class="btn btn-info float-right mr-5">Perbaharui</button></div>'+
                                                    '</div>'+
                                                    '<hr>'
                                                )
                                                // $('.status_note_update').on('click', function() {
                                                //    var values = $(this).val();
                                                //    $('.select_data').val(values)
                                                //     do whatever you want with 'values'
                                                // });


                                            })
                                            $('#detil_data'+value.id).find('.footer-month').append(
                                                '<div class="row mb-3">'+
                                                    '<div class="col-12"><button id="update'+id+'_'+value.id+'" class="btn btn-info float-right mr-5">Submit</button></div>'+
                                                '</div>'+
                                                '<hr>'
                                            )


                                            $('#update'+id+'_'+value.id).on('click', function(){
                                                $(this).prop('disabled',true);
                                                $('.data').each(function(){
                                                    status_id.push($(this).val());
                                                });
                                                console.log(status_id)

                                                $.ajax({
                                                    url:"updateimbal",
                                                    method: 'post',
                                                    dataType: 'json',
                                                    data:{data_id:id,date_id:date,status_id:status_id,flag_id:flag,jmlpendana:data.jmlpendana},
                                                    success:function(data)
                                                    {
                                                        if(data.sukses == 1){
                                                           swal('Berhasil','Payout Month Selesai','success');
                                                       }else{
                                                           swal('Gagal Rekap','Payout Month Belum Ter Rekap','failed');
                                                       }
                                                       window.location.reload();
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
                            $('#cetak_payout').on('click', function(){
                                    window.location='cetak_payout/'+id;
                                    console.log(id_date)
                            })

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
                            var tgl;
                            switch(value.sisa_tanggal) {
                            case 0:
                                tgl = value.tanggal_payout;
                                remain = 'Kemarin';
                                break;
                            case 1:
                                tgl = value.tanggal_payout;
                                remain = 'Hari ini';
                                break;
                            case 2:
                                tgl = value.tanggal_payout;
                                remain = 'Besok';
                                break;
                            default:
                                tgl = value.tanggal_payout;
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
                            $('#action').text("Cetak Daftar Payout "+tgl);
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
