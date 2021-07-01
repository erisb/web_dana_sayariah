@extends('layouts.user.sidebar')

@section('title', 'Turorial')

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <h2>Panduan</h2>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-12">
      <div id="accordion">
        <div class="card">
          <div class="card-header" id="headingOne">
            <h5 class="mb-0">
              <button class="btn btn-link text-success" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Bagaimana Cata Tambah Dana ?
              </button>
            </h5>
          </div>

          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
              <p>Cara Tambah Dana ke Akun Danasyariah anda, berikut merupakan langkah cara tambah dana di danasyariah :</p>              
              <ol class="pl-4">
                <li>Pilih : Menu Lainnya</li>
                <li>Pilih : Menu Tambah Dana</li>
                <li>Pilih Bank</li>
                <li>Pilih mode transfer dana ATM / Mobile banking</li>
                <li>Cek Saldo , pilih menu beranda, lihat informasi dana tersedia yang sudah berhasil di tambahkan</li>
                <li>Selesai</li>
              </ol>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
              <button class="btn btn-link text-success collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Bagaimana Cara Mengikuti Pendanaan di danasyariah.id ?
              </button>
            </h5>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
            <p>Cara Mengikuti Pendanaan di Danasyariah , berikut merupakan langkah-langkahnya :</p> 
              <ol class="pl-4">
                <li>Klik menu : Pilih pendanaan</li>
                <li>Pilih salah satu dari daftar proyek, dan klik</li>
                <li>Masukkan jumlah paket minimal 1 paket</li>
                <li>Klik : Danai Sekarang</li>
                <li>Klik : Proses untuk melanjutkan pendanaan</li>
                <li>Tunggu sampai popup akad muncul, bacalah Dengan seksama dan klik <span class="bold"> saya setuju </span> </li>
              </ol>
              <p>Pendanaan Berhasil, jika total dana tersedia tidak mencukupi proses pendanaan akan gagal, 
silahkan tambahkan dana sesuai dengan paket yang akan di ikutkan ke pendanaan anda </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
