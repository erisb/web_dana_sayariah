@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Pendana</h1>
                    </div>
                </div>
            </div>
</div>

            <div class="content mt-3">
                            <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Data Mutasi Pendana</strong>
                                    </div>
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger">
                                            {{ session()->get('error') }}
                                        </div>
                                    @elseif(session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    <div class="card-body">
                            <table id="table_mutasi" class="table table-striped table-bordered table-responsive-sm">
                                <thead>
                                <tr>
                                    <th style="display: none;">Id</th>
                                    <th>No</th>
                                    <th>Nama Pendana</th>
                                    <th>Email</th>
                                    <th>Jumlah Pendanaan</th>
                                    <th>Total Pendanaan</th>
                                    <th>Dana tidak teralokasi</th>
                                    <th>Detil Pendanaan</th>
                                    <th>Riwayat Mutasi</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- @foreach($investor as $investor)
                                <tr>
                                    @if (isset($investor->detilInvestor->nama_investor))
                                    <td>{{$investor->detilInvestor->nama_investor}}</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>{{$investor->email}}</td>
                                    <td>{{$investor->pendanaanAktif->where('investor_id', $investor->id)->where('status', 1)->count()}}</td>
                                    <td>{{number_format($investor->pendanaanAktif->where('investor_id', $investor->id)->where('status', 1)->sum('nominal_awal'))}}</td>
                                    @if (isset($investor->rekeningInvestor->unallocated))
                                    <td>
                                        {{number_format($investor->rekeningInvestor->unallocated)}}
                                        <button class="btn btn-success float-right tambahVA-btn" data-toggle="modal" data-target="#tambahVA" id="" value="{{$investor->detilInvestor}}"><span class="ti-plus"></span></button>
                                    </td>
                                    @else 
                                    <td>Tidak Memiliki VA</td>
                                    @endif
                                    <td class="text-center">
                                        <button class="btn btn-info" data-toggle="modal" data-target="#{{$investor->id}}pendanaan"><span class="ti-list"></span></button>
                                        @if (isset($investor->rekeningInvestor->unallocated))
                                            <button class="btn btn-success" data-toggle="modal" data-target="#{{$investor->id}}tambah"><span class="ti-plus"></span></button>
                                        @else
                                            <button class="btn btn-success" data-toggle="modal" data-target="#{{$investor->id}}tambah" disabled><span class="ti-plus"></span></button>
                                        @endif
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#{{$investor->id}}hapus"><span class="ti-minus"></span></button>
                                    </td>
                                    <td><button class="btn btn-primary btn-block mutasi-btn" data-toggle="modal" data-target="#mutasi" value="{{$investor->mutasiInvestor}}" data-nama="{{$investor->detilInvestor->nama_investor}}">Mutasi</button></td>
                                </tr>
                                @endforeach --}}
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>


            </div>
    </div><!-- .content -->

                    <!-- start modal tambah pendanaan -->
                                {{-- <div class="modal fade" id="{{$investor->id}}tambah" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Tambah pendanaan untuk {{$investor->username}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('admin.pendanaan')}}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Proyek</label>
                                                        <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                                            <select name="proyek_id" id="" class="form-control" size="1" required>
                                                                @foreach ($proyek as $item)
                                                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Harga Paket</label>
                                                        <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                                            <input type="number" class="form-control" placeholder="{{number_format($item->harga_paket)}}" name="harga_paket" required disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Jumlah Paket</label>
                                                        <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                                            <input type="number" class="form-control" name="jumlah_paket" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="user_name" class="col-sm-3 col-lg-2 col-form-label">Tanggal Pendanaan</label>
                                                        <div class="col-sm-9 col-lg-10 ml-3 ml-sm-0">
                                                            <input type="date" class="form-control" name="tanggal_invest" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <input type="hidden" name="investor_id" value="{{$investor->id}}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Tambahkan</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- end of modal tambah pendanaan -->
                                

                                <!-- modal content detil pendanaan -->
                                {{-- <div class="modal fade" id="{{$investor->id}}pendanaan" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Detil pendanaan {{$investor->detilInvestor->nama_investor}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-3">Nama Proyek</div>
                                                    <div class="col-3">Jumlah Pendanaan</div>
                                                    <div class="col-3">Pendapatan Pendana</div>
                                                    <div class="col-3">Tanggal pendanaan</div>
                                                </div>
                                                <hr>
                                                @foreach($investor->pendanaanAktif->where('status', 1) as $pendanaan)
                                                <div class="row">
                                                    <div class="col-3">{{$pendanaan->proyek->nama}}</div>
                                                    <div class="col-3">{{number_format($pendanaan->nominal_awal)}}</div>
                                                    <div class="col-3">{{number_format($pendanaan->total_dana)}}</div>
                                                    <div class="col-3">{{$pendanaan->tanggal_invest->toDateString()}}</div>
                                                </div>
                                                <hr>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- end of modal content detil pendanaan -->

                                {{-- start of modal hapus pendanaan --}}
                                {{-- <div class="modal fade" id="{{$investor->id}}hapus" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Hapus pendanaan {{$investor->detilInvestor->nama_investor}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-3">Nama Proyek</div>
                                                    <div class="col-3">Jumlah Pendanaan</div>    
                                                    <div class="col-3">Tanggal Pendanaan</div>
                                                    <div class="col-3">Hapus</div>
                                                </div>
                                                <hr>
                                                @foreach($investor->pendanaanAktif->where('status', 1) as $pendanaan)
                                                <div class="row">
                                                    <div class="col-3">{{$pendanaan->proyek->nama}}</div>
                                                    <div class="col-3">{{number_format($pendanaan->nominal_awal)}}</div>
                                                    <div class="col-3">{{$pendanaan->tanggal_invest->toDateString()}}</div>
                                                    <form action="{{route('admin.hapusPendanaan')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="pendanaan_id" value="{{$pendanaan->id}}">
                                                        <input type="hidden" name="investor_id" value="{{$investor->id}}">
                                                        <div class="col-3"><button type="submit" class="btn btn-danger"><span class="ti-minus"></span></button></div>
                                                    </form>
                                                </div>
                                                <hr>
                                                @endforeach
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- end of modal hapus pendanaans --}}

                                <!-- modal content detil mutasi -->
                                {{-- <div class="modal fade" id="{{$investor->id}}mutasi" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Detil mutasi {{$investor->detilInvestor->nama_investor}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-3">Nominal</div>
                                                        <div class="col-3">Perihal</div>
                                                        <div class="col-3">Tipe</div>
                                                        <div class="col-3">Tanggal Mutasi</div>
                                                    </div>
                                                    <hr>
                                                    @foreach($investor->mutasiInvestor as $mutasi)
                                                    <div class="row">
                                                        <div class="col-3">{{number_format($mutasi->nominal)}}</div>
                                                        <div class="col-3">{{$mutasi->perihal}}</div>
                                                        <div class="col-3">{{$mutasi->tipe}}</div>
                                                        <div class="col-3">{{$mutasi->created_at}}</div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- end of modal content detil mutasi -->

                                {{-- modal tambah VA --}}
                                {{-- <div class="modal fade" id="{{$investor->id}}tambahVA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollmodalLabel">Tambah Dana VA {{$investor->detilInvestor->nama_investor}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('admin.addVA')}}" method="POST">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="input_sebesar" class="col-sm-3 col-form-label">Nominal</label>
                                                    <div class="col-sm-9">
                                                    <input type="text" class="form-control qty" value="" name="nominal">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="investor_id" value="{{$investor->id}}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-sm btn-primary">Tambah Dana</button>
                                            </div>
                                                </form>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- end modal tambah VA --}}

                    {{-- modal tambahVA --}}
                    <div class="modal fade" id="tambahVA" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollmodalLabel">Tambah Dana VA  <span id="nama_user"></span></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('admin.addVA')}}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="input_sebesar" class="col-sm-3 col-form-label">Nominal</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control qty" value="" name="nominal">
                                        </div>
                                    </div>
                                    <input type="hidden" name="investor_id" id="investor_id">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-primary">Tambah Dana</button>
                                </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    {{-- end modal tambahVA --}}

                    <div class="modal fade" id="mutasi" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollmodalLabel">Detil Mutasi <span id="nama_user_mutasi"></span></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="row">
                                            <div class="col-3">Nominal</div>
                                            <div class="col-3">Perihal</div>
                                            <div class="col-3">Tipe</div>
                                            <div class="col-3">Tanggal Mutasi</div>
                                        </div>
                                        <hr>
                                       
                                        <div class="mutasi-body">
                                            
                                        </div>
                                        <hr>
                             
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>


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
    $(document).ready(function() {
        var mutasiTable = $('#table_mutasi').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/investor/data_mutasi_datatables',
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
                { data: null,
                    render:function(data,type,row,meta){
                        if (row.nama_investor == '')
                        {
                            return '-';
                        }
                        else
                        {
                            return row.nama_investor;
                        }
                    }
                },
                { data: 'email'},
                { data: 'total'},
                { data: null,
                    render:function(data,type,row,meta){
                        return Number(row.jumlah_nominal);
                    }
                },
                { data: null,
                    render:function(data,type,row,meta){
                        if (row.unallocated == '')
                        {
                            return "Don't Have VA";
                        }
                        else
                        {
                            return Number(row.unallocated)
                                +'<button class="btn btn-success float-right tambahVA-btn" data-toggle="modal" data-target="#tambahVA" id="tambah_va" value=""><span class="ti-plus"></span></button>';
                        }
                    }  
                },
                { data: null,
                    render:function(data,type,row,meta){
                        if (row.unallocated == '')
                        {
                            return '<button class="btn btn-info" data-toggle="modal" data-target="#pendanaan"><span class="ti-list"></span></button><br><br>'
                                +'<button class="btn btn-success" data-toggle="modal" data-target="#tambah" disabled><span class="ti-plus"></span></button><br><br>'
                                +'<button class="btn btn-danger" data-toggle="modal" data-target="#hapus"><span class="ti-minus"></span></button><br><br>';
                        }
                        else
                        {
                            return '<button class="btn btn-info" data-toggle="modal" data-target="#pendanaan"><span class="ti-list"></span></button><br><br>'
                                +'<button class="btn btn-success" data-toggle="modal" data-target="#tambah"><span class="ti-plus"></span></button><br><br>'
                                +'<button class="btn btn-danger" data-toggle="modal" data-target="#hapus"><span class="ti-minus"></span></button><br><br>';
                        }
                    }  
                },
                { data: null,
                    render:function(data,type,row,meta){
                        return '<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#mutasi" id="mutasi_investor">Mutasi</button>';
                    }  
                },
            ],
            columnDefs: [
                { targets: [0], visible: false}
            ]
        });

        $('#table_mutasi tbody').on( 'click', '#tambah_va', function () {
            var data = mutasiTable.row( $(this).parents('tr') ).data();
            id = data.id;
            nama = data.nama_investor;
            console.log(id)
            $('#nama_user').html(nama);
            $('#investor_id').val(id);
        });

        $('#table_mutasi tbody').on( 'click', '#mutasi_investor', function () {
            var data = mutasiTable.row( $(this).parents('tr') ).data();
            id = data.id;
            nama = data.nama_investor;
            console.log(nama)
            $('#nama_user_mutasi').html(nama);
            $('#mutasi').find('.mutasi-body').html('');
            $.ajax({
                url : "/admin/investor/data_riwayat_mutasi/"+id,
                method : "get",
                success:function(data)
                {
                    $.each(data.data,function(index,value){
                        console.log(value.perihal)
                        $('#mutasi').find('.mutasi-body').append(
                            '<div class="row">'+
                            '<div class="col-3">'+ value.nominal +'</div>'+
                            '<div class="col-3">'+ value.perihal +'</div>'+
                            '<div class="col-3">'+ value.tipe +'</div>'+
                            '<div class="col-3">'+ value.created_at +'</div>'+
                            '</div>'+
                            '<hr>'
                        );
                    })
                }
            });
            
        });

        $(".qty").on('keyup', function() {
		// $('.qty').keyup(function() {
			// 1
            var $this = $( this );
            var input = $this.val();
            
            // 2
            var input = input.replace(/[\D\s\._\-]+/g, "");
            
            // 3
            input = input ? parseInt( input, 10 ) : 0;
            
            // 4
            $this.val( function() {
                return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
            } );
        })
        
        //modal tambahVA by admin
        // $(".tambahVA-btn").click(function(){
        //     var val = $(this).val();
        //     val = JSON.parse(val);

        //     $("#tambahVA").find('#nama_user').html(val['nama_investor']);
        //     $("#tambahVA").find('.hidden-id').attr('value', val['investor_id']);
        //     // console.log(val);
        // });

        //modal detil mutasi
        $(".mutasi-btn").click(function(){
            var val = $(this).val();
            val = JSON.parse(val);
            var nama = $(this).data().nama;
            
            $('#mutasi').find('#nama_user').html(nama);
            $('#mutasi').find('.mutasi-body').html('');

            for (const index in val) {
                $('#mutasi').find('.mutasi-body').append(
                    '<div class="row">'+
                        '<div class="col-3">'+ val[index].nominal +'</div>'+
                        '<div class="col-3">'+ val[index].perihal +'</div>'+
                        '<div class="col-3">'+ val[index].tipe +'</div>'+
                        '<div class="col-3">'+ val[index].created_at +'</div>'+
                    '</div>'+
                    '<hr>'
                    );
                // console.log(val[index]);
            }           
            
        })
    })

    </script>
    
@endsection