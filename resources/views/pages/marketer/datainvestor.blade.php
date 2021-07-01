@extends('layouts.marketer.sidebar')

@section('title', 'Dashboard')

@section('content')

<h4>Data Investor yang memakai Kode Referal Anda ({{Auth::user()->username}})</h4>
<hr>
<table class="table border border-secondary">
        <thead class="bg-dark text-light">
          <th>Akun Pendana</th>
          <th>Email Pendana</th>
          <th>Kode Referal</th>
        </thead>
        <tbody>
          @foreach ($data_investor as $data_investor)
            <tr>
            <td>{{$data_investor->username}}</td>
            <td>{{$data_investor->email}}</td>
            <td>{{$data_investor->ref_number}}</td>
            </tr>
              
          @endforeach
        </tbody>
      </table>

@endsection