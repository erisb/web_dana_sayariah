@extends('layouts.user.sidebar')

@section('title', 'Surat Berharga Negara')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12 card-new">
                <div class="my-address contact-2 widget">
                    <h3 class="header-title pb-5">Registrasi SID/SRE </h3>
                    <span class=" text-secondary" style="font-size: 16px; font-weight: bold">Status : Dalam Proses Pendaftaran (2 Hari Kerja)</span>
                    <h6 class="pb-2">Terima Kasih data anda akan kami proses ke Kustodian Danamon. <br> Pembentukan nomor Single Investor
                        Identity (SID) dan Sub Rekening Efek (SRE) membutuhkan waktu maksimal 2 (hari) kerja
                    </h6>   
                        <div class="alert alert-success" role="alert">
                        <i class="fa fa-envelope"></i> Notifikasi aktivasi akan kami kirim ke email Anda.
                        </div>
                        <h6>
                        Anda dapat melanjutkan proses pemesanan setelah proses registrasi selesai.
                        </h6>

                </div>
                <form action="/user/list_sukuk" method="GET" enctype="multipart/form-data">
                    <div class=" pt-5">                       
                            <button type="submit"  class="btn btn-color btn-md btn-message text-white btn-block" >Ok</button>                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi-->

@endsection
