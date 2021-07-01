@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection
@section('style')
<style>
    /* .golden_text h1, .golden_text p, .golden_text h3, .golden_text h5, .golden_text i, .golden_text a{
        color:#F1C411 !important;
    } */
    .pt{
        padding-top: 5rem!important;
    }

    .white_text h1, .white_text i, .white_text h5 {
        color: #FFF !important;
    }

    .img-forgot{
        width: 60%;
    }
    @media only screen and (max-width: 600px) {
        .img-forgot{
            width: 100%;
        }
    }
    @media only screen and (max-width: 768px) {
        .img-forgot{
            width: 80%;
        }
    }
</style>
@endsection


@section('body')
<div class="sub-banner-2 pt-5">
    <div class="container pt">
        <div class="team-wrapper pt-5">
        <img class="pb-3 img-responsive img-forgot" src="/img/forgotpassword.png" alt="Pendanaan Halal">
            <h1>419</h1>
            <h3>Maaf, sesi login anda sudah habis. Silahkan login kembali</h3>
            <small id="passwordHelpBlock" class="form-text text-muted pt-4">
                <a href="/"> <i class="fas fa-arrow-left pr-2"></i> Kembali ke halaman Home </a>
            </small>
        </div>
    </div>
    <br><br><br><br>
</div>
@endsection