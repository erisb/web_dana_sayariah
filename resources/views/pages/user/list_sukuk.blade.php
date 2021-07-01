@extends('layouts.user.sidebar')

@section('title', 'Pemesanan Surat Berharga Negara')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
          <!-- Header dan Search -->
          <!--  Heading-->
          <div class="col-lg-4">
             <div class="heading">
                 <h3>Pilih Produk Sukuk</h3>
             </div>
             <div class="subtitle">
                  2 Produk tersedia
             </div>
         </div>
         <!-- col search -->
         <div class="col-lg-8">
                <div class="search-area" id="compare-search">
                    <div class="search-area-inner">
                        <div class="search-contents">
                            <form method="GET">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-6">
                                    <div class="form-group">
                                            <select class="selectpicker search-fields form-control" name="Status">
                                                <option>--Pilih Produk--</option>
                                                <option>ST001</option>
                                                <option>ST002</option>
                                                <option>ST003</option>
                                                <option>ST004</option>
                                            </select>
                                        </div>
                                    
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-6 ">
                                        <div class="form-group">
                                            <button class="btn btn-color btn-block">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <!--  end col search-->
        </div>
        <!--  End Header & Search-->
        <!--  list sukuk-->
        <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="property-box card-new">
                      <div class="detail">
                        <ul class="facilities-list clearfix mb-2">
                            <li>
                                <img src="/img/logo_st.png" class="" height="50" alt="">
                            </li>
                            <li>
                              <h1 class="title">
                                  <a href="/sukuk">
                                  <div class="header-title pb-2">ST003</div>
                                    <div class="subtitle text-success">
                                      <i class="fas fa-eye "></i>Lihat Informasi Detail
                                    </div>
                                  </a>
                              </h1>
                            </li>
                           
                          </ul>

                          <hr>
                          <ul class="facilities-list clearfix">
                              <li>
                                  <i class="fas fa-handshake"></i> Akad
                              </li>
                              <li class="text-right">
                                  Wakalah
                              </li>
                              <li>
                                  <i class="fas fa-funnel-dollar"></i> Rate Kupon
                              </li>
                              <li class="text-right">
                                  8.15%
                              </li>
                              <li>
                                  <i class="fas fa-calendar-alt"></i> Periode Pembayaran
                              </li>
                              <li class="text-right">
                                  01 Feb 2019 - 20 Feb 2019
                              </li>
                              <li>
                                  <i class="fas fa-layer-group"></i> Jangka Waktu
                              </li>
                              <li class="text-right">
                                30 Hari
                              </li>
                              <li>
                                  <i class="fas fa-calendar-day"></i> Jatuh Tempo
                              </li>
                              <li class="text-right">
                                  01 Feb 2021
                              </li>
                          </ul>
                      </div>
                      <a href="/user/pesan_sukuk">
                      <div class=" btn btn-success btn-block">
                          <div class=" text-white text-center">PESAN</div>
                      </div>
                      </a>
                  </div>
              </div>

              <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="property-box card-new">
                      <div class="detail">
                        <ul class="facilities-list clearfix mb-2">
                            <li>
                                <img src="/img/logo_st.png" class="" height="50" alt="">
                            </li>
                            <li>
                              <h1 class="title">
                                  <a href="/sukuk">
                                  <div class="header-title pb-2">ST004</div>
                                    <div class="subtitle text-success">
                                      <i class="fas fa-eye "></i>Lihat Informasi Detail
                                    </div>
                                  </a>
                              </h1>
                            </li>
                           
                          </ul>

                          <hr>
                          <ul class="facilities-list clearfix">
                            <li class="title-sukuk-detail">
                                <i class="fas fa-handshake"></i> Akad
                            </li>
                            <li class="text-right">
                                Wakalah
                            </li>
                              <li>
                                  <i class="fas fa-funnel-dollar"></i> Rate Kupon
                              </li>
                              <li class="text-right">
                                  8.15%
                              </li>
                              <li>
                                  <i class="fas fa-calendar-alt"></i> Periode Pemesanan
                              </li>
                              <li class="text-right">
                                  01 Feb 2019 - 20 Feb 2019
                              </li>
                              <li>
                                  <i class="fas fa-layer-group"></i> Jangka Waktu
                              </li>
                              <li class="text-right bold">
                                  30 Hari
                              </li>
                              <li>
                                  <i class="fas fa-calendar-day"></i> Jatuh Tempo
                              </li>
                              <li class="text-right">
                                  01 Feb 2021
                              </li>
                          </ul>
                      </div>
                      <a href="/user/pesan_sukuk">
                      <div class=" btn btn-success btn-block">
                          <div class=" text-white text-center">PESAN</div>
                      </div>
                      </a>
                  </div>
              </div>

              <div class="col-lg-12">
                  <div class="pagination-box hidden-mb-45 text-center">
                      <nav aria-label="Page navigation example">
                          <ul class="pagination">
                              <li class="page-item"><a class="page-link" href="#"><span aria-hidden="true">«</span></a></li>
                              <li class="page-item"><a class="page-link active" href="properties-grid-rightside.html">1</a></li>
                              <li class="page-item"><a class="page-link" href="properties-grid-leftside.html">2</a></li>
                              <li class="page-item"><a class="page-link " href="properties-grid-fullwidth.html">3</a></li>
                              <li class="page-item"><a class="page-link" href="properties-grid-leftside.html"><span aria-hidden="true">»</span></a></li>
                          </ul>
                      </nav>
                  </div>
              </div>
          </div>
          <!--  end list sukuk-->
    </div>
</div>

@endsection
