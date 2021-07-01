@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Filter Ekspor Proyek</h1>
                    </div>
                </div>
            </div>
</div>
@if (session('error_log'))
    <div class="alert alert-danger col-sm-12">
        {{ session('error_log') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="content">
    <div class="col-lg-12">
        <div class="breadcrumbs m-2 p-2">
            <form action="{{route('admin.proyek.get_export_by_proyek')}}" >
                <div class="col-lg-12 m-0 p-0 ">
                    <div class="col-lg-12 m-0 p-0">
                        <div class="form-group m-0 p-0 row">
                                <label class="my-1 ml-3" for="nama_proyek_id">Nama Proyek</label>
                                <div class="col-sm-10">
                                    <select class="custom-select my-1 mr-sm-2" name="id_proyek" id="nama_proyek_id">
                                        <option value="" selected>Choose...</option>
                                        @foreach($data as $d)
                                            <option value="{{$d->id}}">{{$d->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                </div> 
                <div class="col-lg-12 m-0 p-0">
                    <div class="col-lg-6 m-0 p-0 float-left">
                        <div class="form-group row m-0 p-0">
                                <label class="my-1 ml-3" for="tgl_mulai_id">Tanggal Mulai Pendanaan</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tgl_mulai" id="tgl_mulai_id" placeholder="Nama Pendana">
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-6 m-0 p-0 float-left">
                        <div class="form-group row m-0 p-0">
                                <label class="my-1 ml-3" for="tgl_selsai_id">Tanggal Selesai Pendanaan</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tgl_selsai" id="tgl_selsai_id" placeholder="Nama pendana">
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group m-3 mr-5 float-right">
                            <button type="reset" id="export_reset" class="btn btn-danger">Atur Ulang</button>
                            <button type="submit" id="export_submit" class="btn btn-primary">Eksport Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection