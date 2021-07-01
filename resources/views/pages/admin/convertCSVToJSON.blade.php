@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Konversi CSV to JSON</h1>
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
<!-- FORM UNTUK MENG-UPLOAD FILE -->
<div class="col-md-12">
    <div class="card" id="view_card_table">
        <div class="card-header">
            <strong class="card-title">Import Data</strong>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/actConvert') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <input type="file" accept=".csv" name="file" class="form-control {{ $errors->has('file') ? 'is-invalid':'' }}" required>
                    <p class="text-danger">{{ $errors->first('file') }}</p>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger btn-sm">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card" id="view_card_table">
        <div class="card-header">
            <strong class="card-title">Hasil JSON</strong><a href="javascript:void(0);" onclick="myFunction();return false;" title="Copy"><i class="fa fa-clone" style="margin-left: 10px;"></i></a>
        </div>
        <div class="card-body" id="copi">
        @php
            echo json_encode($data_json);
        @endphp
        </div>
    </div>
</div>

</div>
</div>
</div><!-- .content -->

<script type="text/javascript">

    function myFunction() {
      var elm = document.getElementById("copi");
        // for Internet Explorer

        if(document.body.createTextRange) {
            var range = document.body.createTextRange();
            range.moveToElementText(elm);
            range.select();
            document.execCommand("Copy");
        // alert("Copied div content to clipboard");
        }
        else if(window.getSelection) {
        // other browsers

            var selection = window.getSelection();
            var range = document.createRange();
            range.selectNodeContents(elm);
            selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand("Copy");
        // alert("Copied div content to clipboard");
        }
    }
        
</script>
@endsection