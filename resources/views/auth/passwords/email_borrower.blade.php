@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection

@section('body')
<style>
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


<div class="container pt-5">
    <div class="row justify-content-center pt-4">
        <div class="col-8 pb-4">
        <h2 class="text-center pt-5">Lupa Kata sandi</h2>
        </div>
        <div class="col-md-8">
            <div class="team-wrapper ">
                <img class="pb-3 img-responsive img-forgot" src="/img/forgotpassword.png" alt="Pendanaan Halal">
                
                <div class="card-body">
                    @if ($status == '00')
                        <div class="alert alert-success" role="alert">
                            Email Berhasil dikirim
                        </div>
                    @elseif($status == '01')
                        <div class="alert alert-danger" role="alert">
                            Email Gagal dikirim
                        </div>
                    @elseif($status == '03')
                        <div class="alert alert-danger" role="alert">
                            Email Tidak Terdaftar
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kirim.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12 ">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Masukkan Alamat Email Anda..." value="{{ old('email') }}" required autofocus>
                                
                                <!-- @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        {{-- <strong>{{ $errors->first('email') }} Email Tidak Terdaftar</strong> --}}
                                        <strong>Email Tidak Terdaftar</strong> 
                                    </span>
                                @endif -->
                            </div>
                            <div class="col-md-12 pt-4 ">
                                <button type="submit" class="btn btn-success btn-block btn-danaSyariah">
                                    {{ __('Atur Ulang Kata Sandi') }}
                                </button>
                            </div>
                            <div class="col-12 pt-4">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    *Link Atur ulang kata sandi akan di kirimkan ke email anda.
                                </small>
                                <small id="passwordHelpBlock" class="form-text text-muted pt-4">
                                    <a href="/"> <i class="fas fa-arrow-left pr-2"></i> Kembali ke halaman Beranda</a>
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br><br><br><br>
@endsection
