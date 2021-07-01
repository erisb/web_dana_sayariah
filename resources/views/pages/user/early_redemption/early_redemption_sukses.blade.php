@extends('layouts.user.sidebar')

@section('title', 'Pilih Investasi')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <div class="my-address contact-2 widget card-new">
                    <img src="/img/logo_st.png" class="mb-5 pl-3" height="50" alt=""><br>
                    <h3 class="header-title pb-3 pl-3">Early Redemption Surat Berharga Negara</h3>                    
                    <form action="/user/history_sukuk" method="GET" enctype="multipart/form-data">
                        <div >
                          <div class="col-lg-12 ">
                            <div class="title">
                                <p>Alhamdulillah, transaksi early redemption Anda
                                telah berhasil dengan informasi sebagai berikut :</p>                              
                            </div>
                            <table class="table">
                              <thead>
                                <tr>

                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><span class="font-weight-bold">Waktu Transaksi :</span></td>
                                  <td>10/8/2018  5:05:00 PM</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Kode Pemesanan :</span></td>
                                  <td>12312312123</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Kode Redeem :</span></td>
                                  <td>19872830123</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Total Redemption :</span></td>
                                  <td>Rp 1.000.000.000,-</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                            <div class="col-lg-12">
                                <div class="send-btn">
                                    <button type="submit" class="btn btn-color btn-md btn-message btn-block">Ok</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
