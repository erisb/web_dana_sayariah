@extends('layouts.user.sidebar')

@section('title', 'Pilih Investasi')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-7 col-sm-12">
                <div class="my-address contact-2 widget card-new">
                  <img src="/img/logo_st.png" class="mb-5 pl-3" height="50" alt=""><br>
                    <h3 class="header-title pb-3 pl-3">Verifikasi Early Redemption</h3>
                    <p class="pl-3">Anda akan melakukan early redemption Surat Berharga Negara.</p>
                    <form action="/user/early_redemption_sukses" method="GET" enctype="multipart/form-data">
                        <div>
                          <div class="col-lg-12 ">
                            <!-- <h6 class="header-title">Data Pemesanan</h6> -->
                            <table class="table">
                              <thead>
                                <tr>

                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><span class="font-weight-bold">SID </span></td>
                                  <td>: IDD0612E4131433</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">SRE </span></td>
                                  <td>: BBKP2A19900501</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Nomor Rekening </span></td>
                                  <td>: 098097807</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Jumlah IDR </span></td>
                                  <td>: IDR 100,000,000.00</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Terbilang </span></td>
                                  <td>: Seratus Juta poin nol nol</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Email </span></td>
                                  <td>: dani.akbarr@gmail.com</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                        <div class="pt-5">                          
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="data-benar" checked>
                                <label class="form-check-label" for="data-benar">
                                    Saya menyaratkan telah menyampaikan data early redemption dengan benar dan lengkap
                                </label>
                            </div>
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="data-unggah-benar">
                                <label class="form-check-label" for="data-unggah-benar">
                                Pengajuan redemption yang telah disubmit tidak dapat diubah/dibatalkan
                                </label>
                            </div>                            
                            <div class="">                    
                                <label class="form-check-label pt-2" for="mengerti">                                
                                 <b> Apabila Anda setuju, silahkan tekan 'Konfirmasi'</b></p>
                                </label>
                            </div>
                        </div>
                        <div class="send-btn pt-3">
                            <a href="/user/early_redemption_sukuk"class="btn  btn-md btn-secondary"><i class="fa fa-angle-left"></i> Back</a>
                            <button type="submit" class="btn btn-color btn-md btn-message ml-4"><i class="fa fa-check"></i> Konfirmasi</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
