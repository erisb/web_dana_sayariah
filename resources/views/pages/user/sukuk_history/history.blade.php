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
                 <h3>History Surat Berharga Negara</h3>
             </div>
             <div class="subtitle">
                  Pilih Produk dan masukkan nominal
             </div>
         </div>
         <!-- col search -->
         <div class="col-lg-8">
        </div>
            <!--  end col search-->
        </div>
        <!--  End Header & Search-->
        
    </div>
    <!--  list sukuk-->
    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="property-box card-new"> 
                    <div class="row pt-3">
                        <div class="col-3 ">                              
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
                        <div class="col-3">                               
                                <div class="form-group">
                                    <select class="selectpicker search-fields form-control" name="Status">
                                        <option>--Jenis Transaksi--</option>
                                        <option>Pemesanan</option>
                                        <option>Pembayaran</option>
                                        <option>Redemption</option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-3">                              
                            <div class="form-group">
                                <input type="text" name="property-title" class="form-control" placeholder="Kode Pemesanan...">                                   
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <button class="btn btn-color btn-block">Search</button>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
    </div>
        <!--  end list sukuk-->
    <!--  list sukuk-->
    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="property-box card-new">
                    <h1 class="header-title mb-3">ST 004</h1>                   
                    <br>     
                    <table class="table">
                        <thead>
                        <tr>

                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><span class="font-weight-bold">SID :</span></td>
                            <td>098070</td>
                        </tr>
                        <tr>
                            <td><span class="font-weight-bold">SRE :</span></td>
                            <td>12312312123</td>
                        </tr>
                        <tr>
                            <td><span class="font-weight-bold">No Rekening :</span></td>
                            <td>19872830123</td>
                        </tr>
                        <tr>
                            <td><span class="font-weight-bold">Produk :</span></td>
                            <td>ST004</td>
                        </tr>
                        <tr>
                            <td><span class="font-weight-bold">Transaksi :</span></td>
                            <td>10099098</td>
                        </tr>
                        </tbody>
                    </table>               
                    <form action="/user/early_redemption_konfirmasi">
                    <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tanggal Redeem</th>
                                <th scope="col">Kode Pemesanan</th>
                                <th scope="col">Kode Redeem</th>
                                <th scope="col">Nominal Redeem</th>
                                <th scope="col">Sisa Redeemable</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>KD01</td>
                                    <td>10/20/2020</td>
                                    <td>RK001</td>
                                    <td>RPK001</td>
                                    <td>Rp. 1.000.000</td>
                                    <td>Rp. 2.000.000</td>
                                    <td>Sukses</td>                                    
                                </tr>
                            </tbody>
                            </table>                        
                        </form>
                </div>
            </div>
    </div>
        <!--  end list sukuk-->
</div>

@endsection
