@extends('layouts.marketer.sidebar')

@section('title', 'Dashboard')

@section('content')

<h4>Data Konfirmasi Transfer oleh Admin Danasyariah</h4>
<hr>

<table class="table border border-secondary">
        <thead class="bg-dark text-light">
          <th>Nominal Transfer</th>
          <th>Perihal</th>
          <th>Tanggal</th>
        </thead>
        <tbody>
          @foreach ($mutasi as $mutasi)
            <tr>
            <td>Rp.{{number_format($mutasi->nominal)}}</td>
            <td>{{$mutasi->perihal}}</td>
            <td>{{$mutasi->created_at}}</td>
            </tr>
              
          @endforeach
        </tbody>
      </table>

@endsection