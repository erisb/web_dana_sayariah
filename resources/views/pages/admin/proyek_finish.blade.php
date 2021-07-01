@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Proyek Selesai</h1>
                    </div>
                </div>
            </div>
</div>
<div class="alert alert-success col-sm-12" id="error_search" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="content mt-3">
    <!-- table select all admin -->
    <button data-id="1" class="btn btn-warning finish7harikedepan" data-target="#modalfinish7harikedepan" data-toggle="modal" style="margin-left: 15px;">Projek Selesai dalam Seminggu</button>
    <table id="table_proyek" class="table table-striped table-bordered table-responsive-sm">
        <thead>
        <tr>
            <th hidden>ID Proyek</th>
            <th>No</th>
            <th>Nama Proyek</th>
            <th>Dana Dibutuhkan</th>
            <th>Terkumpul</th>
            <th>Tgl Selesai</th>
            <th>Jumlah Pendana</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>                
        </tbody>
    </table>

    <!-- end of table select all -->
    <div class="modal fade" id="modal_dana_kembali" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollmodalLabel">Daftar Pendana</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-2">No</div>
                            <div class="col-4">Nama Pendana</div>
                            <div class="col-3">Nominal Pendanaan</div>
                            <div class="col-3">Tanggal Pendanaan</div>
                        </div>
                        <hr>
                        <div class="danaKembali-body"></div>
                </div>
                <div class="modal-footer">
                    {{-- <button class="btn btn-primary" id="kembali_act">Kembalikan Dana</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> --}}
                </div>
            </div>
        </div>
    </div>
</div><!-- .content -->
<!-- start modal finish terdekat -->
<div class="modal fade" id="modalfinish7harikedepan" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Payout Minggu Ini</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-warning" disabled>Projek Selesai</button>
                <button  data-id="0" class="btn btn-secondary finish7harikedepan">Kemarin</button>
                <button  data-id="1" class="btn btn-secondary finish7harikedepan">Hari Ini</button>
                <button  data-id="2" class="btn btn-secondary finish7harikedepan">Besok</button>
                <button  data-id="3" class="btn btn-secondary finish7harikedepan">+2 Hari</button>
                <button  data-id="4" class="btn btn-secondary finish7harikedepan">+3 Hari</button>
                <button  data-id="5" class="btn btn-secondary finish7harikedepan">+4 Hari</button>
                <button  data-id="6" class="btn btn-secondary finish7harikedepan">+5 Hari</button>
                <button  data-id="7" class="btn btn-secondary finish7harikedepan">+6 Hari</button>
            </div>
            <hr>
                        <div class="row ">
                            <div class="col-lg-1">No</div>
                            <div class="col-lg-4">Nama Proyek</div>
                            <div class="col-lg-4">Tanggal Projek Selesai</div>
                            <div class="col-lg-3">Hari Selesai</div>
                            {{-- <div class="col-lg-2">Detil</div> --}}
                        </div>
                        <hr>
                        <div class="show_f7hk p-1"></div>
                        <!-- <div class="payout_footer p-1"></div> -->
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- end modal payout terdekat -->

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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function numberFormat(num){
            var str = num.toString().replace("$", ""), parts = false, output = [], i = 1, formatted = null;
            if(str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for(var j = 0, len = str.length; j < len; j++) {
                if(str[j] != ",") {
                    output.push(str[j]);
                    if(i%3 == 0 && j < (len - 1)) {
                        output.push(",");
                    }
                    i++;
                }
            }
            formatted = output.reverse().join("");
            return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
        };
        var status_dana_kembali;
        var proyekTable = $('#table_proyek').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/proyek/get_finish_proyek_datatables',
                dataSrc: 'data_proyek'
            },
            paging: true,
            info: true,
            lengthChange:false,
            order: [ 1, 'asc' ],
            pageLength: 10,
            columns: [
                { data: 'id'},
                { data : null,
                  render: function (data, type, row, meta) {
                          //I want to get row index here somehow
                          return  meta.row+1;
                    }
                },
                { data: 'nama'},
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        if (row.total_need == null)
                        {
                            return 0;
                        }
                        else
                        {
                            return numberFormat(row.total_need);
                        }
                    }
                },
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        if (row.terkumpul == null)
                        {
                            return 0;
                        }
                        else
                        {
                            return numberFormat(row.terkumpul);
                        }
                    }
                },
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        var date_awal = row.tgl_selesai.split(" ")[0].split("-");
                        return date_awal[2]+"-"+date_awal[1]+"-"+date_awal[0];
                    }
                },
                { data: 'jumlah_investor'},
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        return '<button class="btn btn-info btn-block" data-toggle="modal" data-target="#modal_dana_kembali" id="list_investor">Daftar Pendana</button>';
                    }
                },
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });

        $('#table_proyek tbody').on( 'click', '#list_investor', function () {
            // $('.modal-backdrop').show();
            var data = proyekTable.row( $(this).parents('tr') ).data();
            id = data.id;
            nama_poryek = data.nama;
            // console.log(id)
            $('#modal_dana_kembali').find('.danaKembali-body').html('');
            $('.modal-footer').html('')
            $.ajax({
                url : "/admin/proyek/get_data_list_investor/"+id,
                method : "get",
                success:function(data)
                {
                    var no = 1,
                        data_investor = [],
                        data_investasi = [];
                    $.each(data.data_investor,function(index,value){
                        var invest_date = value.tanggal_invest.split(" ")[0].split("-");
                        $('#modal_dana_kembali').find('.danaKembali-body').append(
                            '<div class="row">'+
                            '<div class="col-2">'+no+'</div>'+
                            '<div class="col-4">'+value.nama_investor+'</div>'+
                            '<div class="col-3">'+numberFormat(value.total_dana)+'</div>'+
                            '<div class="col-3">'+invest_date[2]+"-"+invest_date[1]+"-"+invest_date[0]+'</div>'+
                            '<hr>'
                        );
                        data_investor.push(value.investor_id);
                        data_investasi.push(value.total_dana);
                    no++;
                    })
                    $('.modal-footer').append(
                    '<button class="btn btn-primary" id="kembali_act_'+id+'" '+(data.log_kembali_dana != 0 ? 'disabled=disabled' : '')+'>Kembalikan Dana</button>'+
                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>')
                    console.log(data_investor)
                    $('#kembali_act_'+id).on('click',function(){
                        $.ajax({
                            url : "/admin/proyek/dana_kembali",
                            method : "post",
                            dataType: 'json',
                            data:{investor:data_investor,dana:data_investasi,id_proyek:id},
                            success:function(data)
                            {
                                $("[data-dismiss=modal]").trigger({ type: "click" });
                                $('#error_search').attr('style','display:block').append('Pengembalian Dana Berhasil.')
                            },
                            error:function(error)
                            {
                                alert('Maaf, Ada kesalahan.')
                            }
                        });
                    })
                }
            });
            
        });

        $('.finish7harikedepan').on('click', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "finish7tdk/"+id,
                    method: 'get',
                    success:function(data)
                    {
                        detil = data.finishseven;
                        $('.show_f7hk').html('');
                        var no = 1;
                        $.each(detil, function(index,value){
                            var remain;
                            switch(value.sisa_tanggal) {
                            case -1:
                                remain = 'kemarin';
                                break;
                            case 0:
                                remain = 'Hari Ini';
                                break;
                            case 1:
                                remain = 'Besok';
                                break;
                            default:
                                remain = value.sisa_tanggal+' Hari Lagi';
                            }
                            
                            var rowlist = '<div class="row">'+
                                        '<div class="col-lg-1">'+ no++ +'</div>'+
                                        '<div class="col-lg-4" >'+ value.nama +'</div>'+
                                        '<div class="col-lg-4" >'+ value.tgl_selesai +'</div>'+
                                        '<div class="col-lg-3" >'+ remain +'</div>'+
                                        // '<div class="col-lg-2" >'+ detil +'</div>'+

                                        '</div>';
                            
                            $('#modalfinish7harikedepan').find('.show_f7hk').append(rowlist);

                        });
                    }
                });
            });

    </script>

@endsection