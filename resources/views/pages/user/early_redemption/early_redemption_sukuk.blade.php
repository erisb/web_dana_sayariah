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
                 <h3>Early Redemption</h3>
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
        
    </div>
    <!--  list sukuk-->
    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="property-box card-new">
                    <img src="/img/logo_st.png" class="" height="50" alt="">
                    <br>
                    <div class="header-title pt-3 pb-3">Nama Produk : ST003</div>                                
                    <form action="/user/early_redemption_konfirmasi">
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">
                                Checklist
                                </th>
                                <th scope="col">Kode Pemesanan</th>
                                <th scope="col">Nominal Pemesanan</th>
                                <th scope="col">Available Redeem</th>
                                <th scope="col">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row">
                                        <input type="checkbox" value="" id="pilih-1">                                                                            
                                </th>
                                <td>KD01</td>
                                <td>Rp. 10.000.000</td>
                                <td>Rp. 10.000.000</td>
                                <td>
                                    <div class="col-lg-12">
                                        <div class="form-group subject">
                                            <input type="number" name="phone" class="form-control" placeholder="Masukkan Jumlah Redemption..." autofocus>
                                        </div>
                                    </div>
                                </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                            <input type="checkbox" value="" id="pilih-1">                                                                            
                                    </th>
                                    <td>KD02</td>
                                    <td>Rp. 10.000.000</td>
                                    <td>Rp. 10.000.000</td>
                                    <td>
                                        <div class="col-lg-12">
                                            <div class="form-group subject">
                                                <input type="number" name="phone" class="form-control" placeholder="Masukkan Jumlah Redemption..." autofocus>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- footer TOTAL -->
                                <tr>
                                    <td colspan="4" class="text-right">TOTAL</td>
                                    <td class="text-right pr-5">Rp. ,00-</td>
                                    
                                </tr>
                            </tbody>
                            </table>
                            <div class="send-btn pt-2">
                                <button type="button" class="btn btn-secondary mr-3" >Reset</button>
                                <button type="submit" class="btn btn-success">Selanjutnya <i class="fa fa-angle-right"></i></button>
                            </div>
                        </form>
                </div>
            </div>
    </div>
        <!--  end list sukuk-->
</div>

@endsection
