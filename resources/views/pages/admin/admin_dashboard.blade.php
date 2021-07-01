@extends('layouts.admin.master')

@section('title', 'Panel Admin')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Panel Kendali</h1>
                    </div>
                </div>
            </div>
</div>

        <div class="content mt-3">

                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-1">
                            <div class="card-body pb-0">
                                <h3 class="mb-0">
                                    <span class="count">{{$jumlah_investor}}</span>
                                </h3>
                                <p class="text-light">Total Pendana</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card text-white bg-flat-color-2">
                            <div class="card-body pb-0">
                                <h3 class="mb-0">
                                    <span class="count">{{number_format($total_dana)}}</span>
                                </h3>
                                <p class="text-light">Total Dana Dialokasikan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card text-white bg-flat-color-2">
                            <div class="card-body pb-0">
                                <h3 class="mb-0">
                                    <span class="count">{{number_format($terkumpul)}}</span>
                                </h3>
                                <p class="text-light">Total Dana Terkumpul</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-3">
                            <div class="card-body pb-0">
                                <h3 class="mb-0">
                                    <span class="count">{{$jumlah_proyek}}</span>
                                </h3>
                                <p class="text-light">Total Proyek</p>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-flat-color-4">
                            <div class="card-body pb-0">
                                <h3 class="mb-0">
                                    <span class="count">{{$jumlah_marketer}}</span>
                                </h3>
                                <p class="text-light">Total Wiraniaga</p>
                            </div>
                        </div>
                    </div>
                -->



        </div>
@endsection