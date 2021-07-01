@extends('layouts.user.sidebar')

@section('title', 'Pilih Investasi')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12">
                <div class="my-address contact-2 widget">
                    <img src="/img/logo_st.png" class="mb-5 pl-3" height="50" alt=""><br>
                    <h3 class="header-title pb-3 pl-3">Aplikasi Pemesanan Surat Berharga Negara</h3>
                    <form action="/user/verifikasi_pesan_sukuk" method="GET" enctype="multipart/form-data">
                        <div class="r ow">
                          <div class="col-lg-12 ">
                            <table class="table">
                              <thead>
                                <tr>

                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><span class="font-weight-bold">Kuota Nasional </span></td>
                                  <td>: Rp 1.000.000.000,-</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Kuota Investor </span></td>
                                  <td>: RP. 3.000.000,-</td>
                                </tr>
                                <tr>
                                  <td><span class="font-weight-bold">Minimal Pemesanan </span></td>
                                  <td>: Rp. 1.000.000,-</td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                            <div class="col-lg-12 pt-4 ">
                                <div class="form-group subject">
                                    <label>Nominal Pemesanan</label>
                                    <input type="text" name="phone" class="form-control" placeholder="Masukkan jumlah IDR pemesanan..." autofocus>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="send-btn pt-2">
                                <a href="/user/list_sukuk" class="btn  btn-md btn-message bg-secondary text-white mr-4"><i class="fas fa-angle-left"></i> Batal </a>
                                <a class="btn btn-color btn-md btn-message text-white" data-toggle="modal" data-target="#modalPin">Selanjutnya <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi PIN</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/user/verifikasi_pesan_sukuk">
        <div class="modal-body">
          <div class="col-lg-12 pt-4 ">
              <div class="form-group subject">
                  <label>Masukkan Pin</label>
                  <input type="number" name="phone" class="form-control" placeholder="Masukkan PIN Anda..." autofocus>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Selanjutnya <i class="fa fa-angle-right"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
