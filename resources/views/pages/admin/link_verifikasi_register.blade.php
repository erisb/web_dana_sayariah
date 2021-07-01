@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Tautan Verifikasi Pendaftaran</h1>
                    </div>
                </div>
            </div>
</div>


<div class="content mt-3">
    <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Data Pendana</strong>
            </div>
            <div class="card-body">
                <table id="table_investor" class="table table-striped table-bordered table-responsive-sm">
                    <thead>
                    <tr>
                        <th hidden="hidden">Id</th>
                        <th>No</th>
                        <th>Akun</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th hidden="hidden">Email Verif</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div><!-- .content -->

<!-- modal edit user -->
<div class="modal fade" id="linkRegister" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="scrollmodalLabel">Tautan Verifikasi daftar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <!-- body modal -->
                        <div class="col-lg-12">
                            <div class="form-group">
                                <input type="text" name="link" class="form-control" id="link" readonly="readonly">
                            </div>
                        </div>
                        <!-- end of body modal -->
                </div>
                <div class="modal-footer">                                              
                </div>
        </div>
    </div>
</div>

<!-- end of modal edit user -->

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
        var investorTable = $('#table_investor').DataTable({
            searching: true,
            processing: true,
            // serverSide: true,
            ajax: {
                url: '/admin/data_link_investor/',
                dataSrc: 'data'
            },
            paging: true,
            info: true,
            lengthChange:false,
            order: [ 1, 'asc' ],
            pageLength: 10,
            columns: [
                { data : 'id'},
                { data : null,
                  render: function (data, type, row, meta) {
                          //I want to get row index here somehow
                          return  meta.row+1;
                    }
                },
                { data: 'username'},
                { data: 'email'},
                { data: 'status'},
                { data: 'email_verif'},
                { data: null,
                    render:function(data,type,row,meta){
                        return '<button class="btn btn-info" data-toggle="modal" data-target="#linkRegister" id="show_link">Link Verifikasi</button><br><br>';
                    }
                },

            ],
            columnDefs: [
                { targets: [0,5], visible: false}
            ]
        });

        $('#table_investor tbody').on( 'click', '#show_link', function () {
            var data = investorTable.row( $(this).parents('tr') ).data();
            username = data.username;
            email_verif = data.email_verif;
            url = '{{ config('app.url') }}'+'/user/confirm-email';
            link = url+'/'+email_verif;
            $('#link').val(link);
        });
        
    });
</script>

@endsection