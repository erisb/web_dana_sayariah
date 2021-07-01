@extends('layouts.marketer.sidebar')

@section('title', 'Dashboard')

@section('content')


  <div class="row my-5">
    <div class="col-sm-12 col-lg-4">
      <div class="card text-center card_dashboard" style="background-color: gold;">
        <div class="card-body">
          <h5 class="card-title">Jumlah Pendana anda</h5>
          <span id="jumlah_investor">{{$jumlah_investor}}</span>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-4">
      <div class="card text-center card_dashboard" style="background-color: steelblue;">
        <div class="card-body">
          <h5 class="card-title">Total Dana yang di transfer</h5>
          Rp. <span id="total_dana">{{number_format($total_dana,  0, '', '.')}}</span>
        </div>
      </div>
    </div>
    <div class="col-sm-12 col-lg-4">
      <div class="card text-center card_dashboard" style="background-color: limegreen;">
        <div class="card-body">
          <h5 class="card-title">Kode referal Anda</h5>
          <span id="kode_referal">{{Auth::user()->username}}</span>
        </div>
      </div>
    </div>
  </div>

<h4>Informasi Rekening Anda</h4>
<hr>
<div class="row my-5">
<div class="col-sm-12 col-lg-12">
      <div class="card text-center card_dashboard" style="background-color: #FF1E1E;">
        <div class="card-body">
          <h5 class="card-title">Informasi Rekening</h5>
          <span id="dana_tersedia">{{Auth::user()->detilMarketer->no_rek}} - </span>
          <span>{{Auth::user()->detilMarketer->nama_lengkap}}</span>
        </div>
      </div>
    </div>
</div>

@endsection