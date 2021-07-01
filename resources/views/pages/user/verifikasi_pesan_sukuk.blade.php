@extends('layouts.user.sidebar')

@section('title', 'Pilih Investasi')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-7 col-sm-12">
                <div class="my-address contact-2 widget card-new">
                  <img src="/img/logo_st.png" class="mb-5 pl-3" height="50" alt=""><br>
                    <h3 class="header-title pb-3 pl-3">Verifikasi Penerimaan Negara</h3>
                    <p class="pl-3">Anda akan melakukan pemesanan Surat Berharga Negara.</p>
                    <form action="/user/payment_sukuk" method="GET" enctype="multipart/form-data">
                        <div>
                          <div class="col-lg-12 ">
                            <h6 class="header-title">Data Pemesanan</h6>
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
                          <p>Sebelum melakukan proses pemesanan, Investor SBN Ritel disarankan
                            membaca dengan teliti dan memahami isi memorandum informasi SBN ritel
                            secara elektronik. DIsamping itu Investor SBN Ritel dapat memeriksa
                            kembali dengan kebenaran dan validasi data Single Investor Identify (SID),
                            rekening dana dan rekening surat berharga (efek).
                          </p>
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="data-benar" checked>
                                <label class="form-check-label" for="data-benar">
                                    Saya telah membaca dan memahami isi <a href="#" class="text-primary"> Memorandum Informasi (Wajib di-klik)</a>
                                </label>
                            </div>
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="data-unggah-benar">
                                <label class="form-check-label" for="data-unggah-benar">
                                Saya telah membaca dan memahami isi <a href="#" class="text-primary"> Syarat dan Ketentuan (Wajib di-klik)</a>
                                </label>
                            </div>

                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="pembuatan-id">
                                <label class="form-check-label" for="pembuatan-id">
                                    Saya setuju bahwa pemesanan yang telah disubmit tidak dapat diubah/dibatalkan
                                    dan jika tidak dilakukan pembayaran dalam periode tertentu setelah menerima kode billing maka secara otomatis
                                    batal/menjadi kadaluarsa dan kuota investor akan dikembalikan pada H+2
                                </label>
                            </div>
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="mengerti">
                                <label class="form-check-label" for="mengerti">
                                    Saya telah menyampaikan data pemesanan dengan benar dan lengkap
                                </label>
                            </div>
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="mengerti">
                                <label class="form-check-label" for="mengerti">
                                    Saya setuju untuk menguasakan dana investasi pada sukuk tabungan dan seluruh hak terkait Aset SBSN Sukuk 
                                    Tabungan dan seluruh hak terkait Aset SBSN Sukuk Tabungan Kepada Perusahaan Penerbit SBSN Indonesia
                                    sebagai Wali Amanat untuk kegiatan investasi yang menghasilkan keuntungan 
                                    (Untuk Sukuk Tabungan, dalam hal telah menjadi pemegang atau pemilik Sukuk Tabungan)
                                </label>
                            </div>
                            <div class="">                    
                                <label class="form-check-label pt-2" for="mengerti">                                
                                 <b> Apabila Anda setuju, silahkan tekan 'Konfirmasi'</b></p>
                                </label>
                            </div>
                        </div>
                        <div class="send-btn pt-3">
                            <a href="/user/pesan_sukuk"class="btn  btn-md btn-secondary"><i class="fa fa-angle-left"></i> Back</a>
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
