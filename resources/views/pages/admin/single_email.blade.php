@extends('layouts.admin.master')

@section('title', 'Kirim SurEl')

@section('content')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Kirim SurEl</h1>
            </div>
        </div>
    </div>
</div>

@if(session()->has('singlemail'))
<div class="alert alert-success">
    {{ session()->get('singlemail') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


 <div class="col-lg-12">
    <div class="card" id="view_card_search">
        <div class="card-header">
            <strong class="card-title">Cari Pendana</strong>
        </div>
        <div class="card-body">
            <form class="form" id="form_search">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">Nama</label>
                    <div class="col-8">
                        <input type="text" name="nama" class="form-control" id="nama" autocomplete="off" autofocus>
                        <div id="nama_list"></div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" id="search">Cari</button>
            </form>
        </div>
    </div>

    
        <form action="{{route('sendMail')}}" method="POST" >
        @csrf
            <div class="card" id="view_card_table" style="display: none;">
                <div class="card-header"><small> Form  </small><strong>Daftar Pendana</strong></div>
                <div class="card-body card-block">
                    <table id="table_email" class="table table-striped table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th hidden>ID</th>
                                <th>No</th>
                                <th>SurEl</th>
                                <th>Akun</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Kirim SurEl</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($user as $item)
                            <tr>
                                <td>{{$item->email}}</td>
                                <td>{{$item->username}}</td>
                                @if (isset($item->detilInvestor->nama_investor))
                                <td>{{$item->detilInvestor->nama_investor}}</td>
                                @else
                                <td> - </td>
                                @endif
                                <td>{{$item->status}}</td>
                                <td><input type="checkbox" name="checked[]" class="form-control" value="{{$item->id}}"></td>
                            </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card" id="view_card_form" style="display: none;">
                <div class="card-header"><small> Form  </small><strong>Isi SurEl</strong></div>
                <div class="card-body card-block">
                    <div class="form-group">
                        <label for="nama" class=" form-control-label">Judul</label>
                        <input type="text" name="judul_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi" class=" form-control-label">Isi SurEl</label>
                        <textarea name="deskripsi"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-success btn-block" id="view_button" style="display: none;">Kirim SurEl</button>
        </form>
</div>


<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea',
        // forced_root_block: false
    });
</script>

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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        // $('#bootstrap-data-table-export').DataTable();
        $('#search').on('click',function(e){
            e.preventDefault();
            var name_email = $.trim($('#nama').val());
            if (name_email != '')
            {
                var dataSearch = {name_email:name_email};
            } 
            console.log(dataSearch)
            $.ajax({
              url: '/admin/investor/data',
              method: 'post',
              dataType: 'json',
              data : dataSearch,
              success: function(data){
                if (data.status == 'Ada')
                {
                    $('#view_card_search').attr('style','display: none');
                    $('#view_card_table').attr('style','display: block');
                    $('#view_card_form').attr('style','display: block');
                    $('#view_button').attr('style','display: block');
                    var emailTable = $('#table_email').DataTable({
                        searching: true,
                        processing: true,
                        // serverSide: true,
                        ajax: {
                            url: '/admin/messagging/data_email_datatables',
                            type: 'post',
                            data: dataSearch,
                            dataSrc: 'data_email'
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
                            { data: 'email'},
                            { data: 'username'},
                            { data: null,
                                render:function(data,type,row,meta)
                                {
                                    if (row.nama_investor != null)
                                    {
                                        return row.nama_investor;
                                    }
                                    else
                                    {
                                        return '-';
                                    }
                                }
                            },
                            { data: 'status'},
                            { data: null,
                                render:function(data,type,row,meta)
                                {
                                    return '<input type="checkbox" name="checked[]" class="form-control" value="'+row.id+'">';
                                }  
                            }
                        ],
                        columnDefs: [
                            { targets: [0], visible: false}
                        ]
                    });
                }
                else
                {
                    $('#error_search').attr('style','display: block');
                }
              },
              error: function(error){
                  alert('Ada Error'+error+' nih');
              }
            })
        });

        
    });
</script>
@endsection