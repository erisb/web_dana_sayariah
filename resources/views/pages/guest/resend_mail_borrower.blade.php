@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection
@section('style')
<style>
    /* .golden_text h1, .golden_text p, .golden_text h3, .golden_text h5, .golden_text i, .golden_text a{
        color:#F1C411 !important;
    } */

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
    <div class="container pt-5">
        <div class="team-wrapper pt-5">
                    {{-- <img class="pb-3 img-responsive img-forgot" src="/img/logo.png" alt="Pendanaan Halal"> --}}
                    <i class="fas fa-envelope-open-text text-success fa-3x text-center"></i>
                    <hr>
                        <h3>Selamat, Anda sudah berhasil registrasi.</h3>
                        <h6 class="pb-4">Silahkan cek email anda untuk melakukan aktivasi akun anda. <br>
                        Jika email aktivasi akun belum terkirim, silahkan anda klik tombol re-send.
                        </h6>
                        <form action="{{route('resend.borrower')}}" method="post">
                            @csrf
                            {{-- <a href="{{url('resendMailPostborrower')}}/{{session('email')}}" class="btn-md mt-5 btn-danaSyariah text-white">Resend</a> --}}
                            <input type="hidden" name="email" id="email" value="{{session('email')}}">
                            <button type="submit" class="btn-md mt-5 btn-danaSyariah text-white">Resend</button>
                        </form>	

                    {{-- <form action="{{route('resend',[ 'email' => Session::get('email')])}}" method="post">
                        @csrf
                        <input type="text" name="" id="" disabled value="{{Session::get('email')}}">
                        <button type="submit" class="btn btn-success">Resend Link</button>
                    </form> --}}
        </div>
    </div>
    <br><br><br><br>
</div>
<style type="text/css">
    .button {
            display: inline-block;
            width: 90px;
            height: 35px;
            background: #28a745;
            padding: 5px;
            text-align: center;
            border-radius: 5px;
            color: white;
            font-weight: bold;
    }
</style>
@endsection