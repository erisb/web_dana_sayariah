@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Permohonan Penarikan Dana Pendana</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
        <div class="row">
        <div class="col-md-12">
        @if(session()->has('withdraw_ok'))
            <div class="alert alert-success">
                {{ session()->get('withdraw_ok') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->has('withdraw_fail'))
            <div class="alert alert-danger">
                {{ session()->get('withdraw_fail') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table</strong>
                </div>
                <div class="card-body">
        <table id="table_request" class="table table-striped table-bordered table-responsive-sm">
            <thead>
            <tr>
                <th hidden>Id</th>
                <th hidden>Id Pendana</th>
                <th>No</th>
                <th>Akun</th>
                <th>Atas Nama</th>
                <th>VA</th>
                <th>Nomor Telp</th>
                <th>Nama Pemilik Rekening</th>
                <th>Nomor Rekening</th>
                <th>Nama (E-Collection BNI)</th>
                <th>Bank</th>
                <th>Jumlah</th>
                <th>Tgl</th>
                <th>Opsi</th>
            </tr>
            </thead>
            <tbody>
            {{-- @foreach($requestwithdraw as $req)
            <tr>
                <td>{{$req->investor->username}}</td>
                <td>{{$req->investor->detilInvestor->nama_investor}}</td>
                <td>{{$req->investor->rekeningInvestor->va_number}}</td>
                <td>Rp. {{number_format($req->jumlah, 0, '', '.')}}</td>
                <td>{{$req->no_rekening}}</td>
                <td>{{$req->bank}}</td>
                <td>{{$req->perihal}}</td>
                @if($req->accepted == 0)
                <td>requested</td>
                @else 
                <td>Terbayar</td>
                @endif
                <td>
                    <button class="btn btn-info btn-block" data-toggle="modal" data-target="#{{$req->investor->username}}ok">Konfirmasi</button>
                    <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#{{$req->investor->username}}fail">Tolak </button>
                </td>
            </tr>
            
            @endforeach --}}
            </tbody>
        </table>
                </div>
            </div>
        </div>


        </div>
</div><!-- .content -->

<!-- verify request penarikan -->
<div class="modal fade" id="request_ok" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mediumModalLabel">PERHATIAN !</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Apakah anda <span class="bg-flat-color-1 text-light">menyetujui</span> Penarikan dana ini ?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form name="approve_form" id="approve_form" action="{{route('admin.investor.withdraw.ok')}}" method="POST">
                    @csrf
                    <input type="hidden" name="nominal" id="nominal_ok">
                    <input type="hidden" name="id" id="id_ok">
                    <input type="hidden" name="investor_id" id="investor_id_ok">
                    <button type="submit" name="button_confirm" id="button_confirm" class="btn btn-info">Konfirm</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
<!-- end of verify request penarikan -->

<!-- cancel request penarikan -->
<div class="modal fade" id="request_fail" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mediumModalLabel">PERHATIAN !</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Apakah anda <span class="bg-flat-color-1 text-light">menolak</span> Penarikan dana ini ?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form name="reject_form" id="reject_form" action="{{route('admin.investor.withdraw.fail')}}" method="POST">
                    @csrf
                    <input type="hidden" name="nominal" id="nominal_fail">
                    <input type="hidden" name="id" id="id_fail">
                    <input type="hidden" name="investor_id" id="investor_id_fail">
                    <button type="submit" name="button_reject" id="button_reject" class="btn btn-info">Konfirm</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
<!-- end of cancel request penarikan modal -->


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
          // $('#bootstrap-data-table-export').DataTable();
        
        $("#button_confirm").click(function() {
            $("#approve_form").submit(function (){
                $("#button_confirm").attr("disabled", true);
                return true;
            });
        });

        $("#button_reject").click(function() {
            $("#reject_form").submit(function (){
                $("#button_reject").attr("disabled", true);
                return true;
            });
        });

        var requestTable = $('#table_request').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/investor/data_req',
                dataSrc: 'data_req'
            },
            paging: true,
            info: true,
            lengthChange:false,
            order: [ 2, 'asc' ],
            pageLength: 10,
            columns: [
                { data: 'id'},
                { data: 'investor_id'},
                { data : null,
                  render: function (data, type, row, meta) {
                          //I want to get row index here somehow
                          return  meta.row+1;
                    }
                },
                { data: 'username'},
                { data: 'nama_investor'},
                { data: 'va_number'},
                { data: 'phone_investor'},
                { data: 'nama_pemilik_rek'},
                { data: 'no_rekening'},
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        if (row.nama != row.nama_investor)
                        {
                            return '<p style="color:red;fontWeight: bold">'+row.nama+'</p>';
                        }
                        else
                        {
                            return '<p style="color:green;fontWeight: bold">'+row.nama+'</p>';
                        }
                    }
                },
                { data: 'bank'},
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        if (row.jumlah == null)
                        {
                            return 0;
                        }
                        else
                        {
                            return 'Rp '+numberFormat(row.jumlah);
                        }
                    }
                },
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        var dataTglPenarikan = row.created_at.split(' ');
                        var tgl = dataTglPenarikan[0].split('-')[2];
                        var bln = dataTglPenarikan[0].split('-')[1];
                        var thn = dataTglPenarikan[0].split('-')[0];
                        
                        return tgl+'-'+bln+'-'+thn;
                    }
                },
                // { data: null,
                //     render:function(data,type,row,meta)
                //     {
                //         if (row.accepted == 0)
                //         {
                //             return 'Requested';
                //         }
                //         else
                //         {
                //             return 'Paid';
                //         }
                //     }  
                // },
                { data: null,
                    render:function(data,type,row,meta)
                    {
                        return '<button class="btn btn-info btn-block" data-toggle="modal" data-target="#request_ok" id="ok">Konfirmasi</button>'+
                            '<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#request_fail" id="fail">Tolak</button>';
                    }
                }
            ],
            columnDefs: [
                { targets: [0,1], visible: false}
            ]
        });

        $('#table_request tbody').on( 'click', '#ok', function () {
            var data = requestTable.row( $(this).parents('tr') ).data();
            id = data.id;
            investor_id = data.investor_id;
            jumlah = data.jumlah;
            $('#nominal_ok').val(jumlah);
            $('#id_ok').val(id);
            $('#investor_id_ok').val(investor_id);
        });

        $('#table_request tbody').on( 'click', '#fail', function () {
            var data = requestTable.row( $(this).parents('tr') ).data();
            id = data.id;
            investor_id = data.investor_id;
            jumlah = data.jumlah;
            $('#nominal_fail').val(jumlah);
            $('#id_fail').val(id);
            $('#investor_id_fail').val(investor_id);
        });
    });
    </script>

@endsection