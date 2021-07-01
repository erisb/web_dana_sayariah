@extends('layouts.user.sidebar')

@section('title', 'Tambah Dana')

@section('content')
  <div class="row">
    <div class="col-sm-12 col-lg-8 mx-auto">
      <?php
        $virtual_account = false
       ?>
      <div class="card bg-dark text-light">
        <div class="card-body">
          <h2 style="color:white"><img src="/img/logobnisyariah.png" >  Virtual Account {{!empty($rekening->va_number) ? $rekening->va_number : ''}}</h2>
        </div>
      </div>
    </div>
  </div>
  <br>

  <div class="row">
    <div class="col-sm-8">
      <div class="accordion" id="bank_accordion">

         <div class="card">
          <div class="card-header collapsed bg-info" id="headingBCA" data-toggle="collapse" data-target="#collapseBCA" aria-expanded="false" aria-controls="collapseBCA">
            <h5 class="mb-0">
              Bank BNI
            </h5>
          </div>
          <div id="collapseBCA" class="collapse" aria-labelledby="headingOne" data-parent="#bank_accordion">
            <div class="accordion" id="bca_accordion">
              <div class="card">
                <div class="card-header collapsed bg-light" id="headingBCA_ATM" data-toggle="collapse" data-target="#collapseBCA_ATM" aria-expanded="false" aria-controls="collapseBCA_ATM">
                  <h5 class="mb-0">
                    ATM BNI
                  </h5>
                </div>
                <div id="collapseBCA_ATM" class="collapse" aria-labelledby="headingOne" data-parent="#bca_accordion">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12" >
                        <ol class="list_add_funds">
                          <li>Masukkan kartu Anda</li>
                          <li>Pilih Bahasa</li>
                          <li>Masukkan PIN ATM Anda</li>
                          <li>Pilih "Menu Lainnya"</li>
                          <li>Pilih "Transfer"</li>
                          <li>Pilih "Rekening Tabungan"</li>
                          <li>Pilih "Ke Rekening BNI"</li>
                          <li>Masukkan nomor virtual account anda ({{!empty($rekening->va_number) ? $rekening->va_number : ''}})</li>
                          <li>Konfirmasi, apabila telah sesuai, lanjutkan transaksi</li>
                          <li>Transaksi telah selesai</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header collapsed bg-light" id="headingTwo" data-toggle="collapse" data-target="#collapseBRI_B" aria-expanded="false" aria-controls="collapseBCA_ATM">
                  <h5 class="mb-0">
                  Mobile Banking
                  </h5>
                </div>
                <div id="collapseBRI_B" class="collapse" aria-labelledby="headingOne" data-parent="#bca_accordion">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12" >
                        <ol class="list_add_funds">
                          <li>Akses BNI Mobile Banking kemudian masukkan user ID dan password</li>
                          <li>Pilih menu Transfer</li>
                          <li>Pilih "Antar Rekening BNI" kemudian "Input Rekening Baru"</li>
                          <li>Masukkan Rekening Debit dan nomor Virtual Account Tujuan ({{!empty($rekening->va_number) ? $rekening->va_number : ''}})</li>
                          <li>Masukkan nominal transfer sesuai keinginan Anda.</li>
                          <li>Konfirmasi transaksi dan masukkan Password Transaksi</li>
                          <li>Transfer Anda Telah Berhasil</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header collapsed bg-info" id="headingTwo" data-toggle="collapse" data-target="#collapseBRI" aria-expanded="false" aria-controls="collapseBRI">
            <h5 class="mb-0">
              Bank lain
            </h5>
          </div>
          <div id="collapseBRI" class="collapse" aria-labelledby="headingTwo" data-parent="#bank_accordion">
            <div class="accordion" id="bri_accordion">
              <div class="card">
                <div class="card-header collapsed bg-light" id="headingBCA_ATM" data-toggle="collapse" data-target="#collapseBRI_ATM" aria-expanded="false" aria-controls="collapseBCA_ATM">
                  <h5 class="mb-0">
                    ATM Bersama
                  </h5>
                </div>
                <div id="collapseBRI_ATM" class="collapse" aria-labelledby="headingOne" data-parent="#bri_accordion">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12" >
                        <ol class="list_add_funds">
                          <li>Masukkan kartu ke mesin ATM bersama</li>
                          <li>Pilih "Transaksi Lainnya"</li>
                          <li>Pilih menu "Transfer"</li>
                          <li>Pilih "Transfer ke Bank Lain"</li>
                          <li>Masukkan kode bank BNI (009) dan 16 Digit Nomor VA ({{!empty($rekening->va_number) ? $rekening->va_number : ''}}) </li>
                          <li>Masukkan nominal transfer sesuai keinginan Anda.</li>
                          <li>Konfirmasi rincian akan tampil di layar, cek dan tekan 'Ya' untuk melanjutka</li>
                          <li>Transaksi Berhasil</li>
                        </ol>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        


      </div>
    </div>
  </div>


@endsection