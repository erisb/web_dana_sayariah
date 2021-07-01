@extends('layouts.admin.master')

@section('title', 'Dashboard Borrower')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Penerima Pendanaan</h1>
                    </div>
                </div>
            </div>
</div>
<div class="content mt-3">
<div class="row">
<div class="col-md-12">
@if (session('error'))
    <div class="alert alert-danger col-sm-12">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
@elseif (session('success'))
    <div class="alert alert-success col-sm-12">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
    <div class="alert alert-success col-sm-12" id="error_search" style="display: none;">
        Data Kosong Bro!!!!!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="card" id="view_card_search">
        <div class="card-header">
            <strong class="card-title">Pendarian Penerima Pendanaan</strong>
        </div>
        <div class="card-body">
            <form class="form" id="form_search">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label form-control-label">NIK</label>
                    <div class="col-8">
                        <input type="text" name="nik" class="form-control" id="nik" autocomplete="off" autofocus>
                        <div id="nama_list"></div>
                    </div>
                </div>
                <button class="btn btn-primary" type="button" id="search">Cari</button>
            </form>
        </div>
    </div>
</div>
</div>

</div><!-- .content -->
    
<link rel="stylesheet" href="/css/jquery_step/jquery.steps.css">
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/jquery_step/jquery.steps.js"></script>
<script src="/js/jquery_step/jquery.validate.min.js"></script>

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
        $('#search').on('click',function(e){
            var ktp = $('#nik').val();
            $.ajax({
                url : "/admin/borrower/search",
                method : "post",
                data : {ktp:ktp},
                success:function(data)
                {
                    alert(JSON.parse(data).status)
                }
            });
        });
    });
</script>
@endsection