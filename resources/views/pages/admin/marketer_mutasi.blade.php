@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Mutasi Wiraniaga</h1>
                    </div>
                </div>
            </div>
</div>

<div class="content mt-3">
    <div class="row">
        <div class="col-md-12">
        @if(session()->has('konfirmasi'))
            <div class="alert alert-success">
                {{ session()->get('konfirmasi') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Mutasi Wiraniaga</strong>
                </div>
                        <div class="card-body">
                            <table id="table_marketer" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th hidden="hidden">Id Marketer</th>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Kode <i>Referal</i></th>
                                    <th>Jumlah Pendana</th>
                                    <th>Total Pendapatan</th>
                                    <th hidden="hidden">Rekening</th>
                                    <th hidden="hidden">Bank</th>
                                    <th>Detil Pendana</th>
                                    <th>Detil Mutasi</th>
                                    <th>Tambah Mutasi</th>
                                </tr>
                                </thead>
                                <tbody>
                               
                                </tbody>
                            </table>

                            <!-- end of table select all -->
                </div>
            </div>
        </div>
    </div>

    <!-- modal create mutasi marketer  -->
    <div class="modal fade" id="tambahmutasi" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mediumModalLabel">Tambah konfirmasi pembayaran Wiraniaga</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.marketer.mutasi.create')}}" method="post">
                    @csrf 
                    <input type="hidden" name="id" id="marketer_id">
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Nama Wiraniaga</label>
                        <input type="text" name="nama" disabled class="form-control" id="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="no_rek" class=" form-control-label">Nomor Rekening</label>
                        <input type="text" name="no_rek" disabled class="form-control" id="rekening" required>
                    </div>
                    <div class="form-group">
                        <label for="bank" class=" form-control-label">Bank</label>
                        <input type="text" name="bank" disabled class="form-control" id="bank" required>
                    </div>
                    <div class="form-group">
                        <label for="bank" class=" form-control-label">Nominal</label>
                        <input type="text" name="nominal" placeholder="Nominal Transfer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="perihal" class=" form-control-label">Perihal</label>
                        <input type="text" name="perihal" placeholder="Perihal" class="form-control" required>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal create mutasi marketer admin -->

    <!-- modal show detil mutasi marketer  -->
    <div class="modal fade" id="detilmutasi" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mediumModalLabel">Detil mutasi <span id="nama_marketer_mutasi"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mutasiMarketerBody">
                    <div class="row">
                        <div class="col-1">No</div>
                        <div class="col-4">Nominal</div>
                        <div class="col-4">Perihal</div>
                        <div class="col-3">Tanggal</div>
                    </div>
                    <hr>   
                    <div class="mutasiMarketerBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal show detil mutasi marketer admin -->

    <!-- modal show detil investor marketer  -->
    <div class="modal fade" id="detilinvestor" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mediumModalLabel">Detil Pendana <span id="nama_marketer_investor"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="investorMarketerBody">
                    <div class="row">
                        <div class="col-1">No</div>
                        <div class="col-4">Nama Pendana</div>
                        <div class="col-4">Email Pendana</div>
                        <div class="col-3">Total Pendanaan</div>
                    </div>
                    <hr>
                    <div class="investorMarketerBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal show detil investor marketer admin -->


</div><!-- .content -->


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


    <script type="text/javascript">
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

    $(document).ready(function() {

        var marketerTable = $('#table_marketer').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/marketer/data_marketer_datatables',
                dataSrc: 'data'
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
                { data: 'nama_lengkap'},
                { data : 'email'},
                { data: 'ref_code'},
                { data: 'jumlah_investor'},
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        if (row.total_nominal == null)
                        {
                            return 'Rp. 0';
                        }
                        else
                        {
                            return 'Rp.'+ numberFormat(row.total_nominal);
                        }
                    }
                },
                {data : 'rekening'},
                {data : 'nama_bank'},
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        return '<button class="btn btn-info" data-toggle="modal" data-target="#detilinvestor" id="investor">Pendana</button>';
                    }
                },
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        return '<button class="btn btn-primary" data-toggle="modal" data-target="#detilmutasi" id="mutasi">Mutasi</button>';
                    }
                },
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        return '<button class="btn btn-success" data-toggle="modal" data-target="#tambahmutasi" id="tambah_mutasi"><span class="ti-plus"></span>';
                    }  
                }
            ],
            columnDefs: [
                { targets: [0,7,8], visible: false}
            ]
        });

        $('#table_marketer tbody').on( 'click', '#tambah_mutasi', function () {
            var data = marketerTable.row( $(this).parents('tr') ).data();
            marketer_id = data.id;
            nama_marketer = data.nama_lengkap;
            rekening = data.rekening;
            bank = data.nama_bank;
            console.log(rekening)
            $('#marketer_id').val(marketer_id)
            $('#nama').val(nama_marketer);
            $('#rekening').val(rekening);
            $('#bank').val(bank);
        });

        $('#table_marketer tbody').on( 'click', '#mutasi', function () {
            var data = marketerTable.row( $(this).parents('tr') ).data();
            marketer_id = data.id;
            nama_marketer = data.nama_lengkap;
            console.log(nama_marketer)
            $('#nama_marketer_mutasi').html(nama_marketer);
            $('#detilmutasi').find('.mutasiMarketerBody').html('');
            $.ajax({
                url : "/admin/marketer/data_mutasi_marketer/"+marketer_id,
                method : "get",
                success:function(data)
                {
                    var no = 1
                    $.each(data.data,function(index,value){
                        console.log(value.perihal)
                        $('#detilmutasi').find('.mutasiMarketerBody').append(
                            '<div class="row">'+
                            '<div class="col-1">'+ no +'</div>'+
                            '<div class="col-4">'+ value.nominal +'</div>'+
                            '<div class="col-4">'+ value.perihal +'</div>'+
                            '<div class="col-4">'+ value.created_at +'</div>'+
                            '</div>'+
                            '<hr>'
                        );
                    no++;
                    })
                }
            });
        });

        $('#table_marketer tbody').on( 'click', '#investor', function () {
            var data = marketerTable.row( $(this).parents('tr') ).data();
            marketer_id = data.id;
            nama_marketer = data.nama_lengkap;
            $('#nama_marketer_investor').html(nama_marketer);
            $('#detilinvestor').find('.investorMarketerBody').html('');
            $.ajax({
                url : "/admin/marketer/data_investor_marketer/"+marketer_id,
                method : "get",
                success:function(data)
                {   
                    var no = 1;
                    $.each(data.data,function(index,value){
                        $('#detilinvestor').find('.investorMarketerBody').append(
                            '<div class="row">'+
                            '<div class="col-1">'+ no +'</div>'+
                            '<div class="col-4">'+ value.nama_investor +'</div>'+
                            '<div class="col-4">'+ value.email +'</div>'+
                            '<div class="col-3">'+ (value.total_invest != null ? numberFormat(value.total_invest) : '0') +'</div>'+
                            '</div>'+
                            '<hr>'
                        );
                    no++;
                    })
                }
            });
        });

    });
    </script>


@endsection