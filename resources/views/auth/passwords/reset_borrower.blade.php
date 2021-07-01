@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection

@section('body')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top: 150px">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if ($status == '01')
                        <div class="alert alert-success" role="alert">
                            Gagal Memperbaharui Kata sandi, Silahkan Coba Lagi !
                        </div>
                    @elseif($status == '02')
                        <div class="alert alert-danger" role="alert">
                            Kata sandi Baru Tidak Sama Dengan Konfirmasi kata sandi !
                        </div>
                    @elseif($status == '03')
                        <div class="alert alert-danger" role="alert">
                            Password Harus Lebih dari 8 Karakter
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kirim.data') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf
                        <input type="hidden" name="aidi" value="{{ $id }}">
                        <input type="hidden" name="email" value="{{ $email }}">


                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Alamat Email</label>

                            <div class="col-md-6">
                                <input name="email" id="email" type="email" class="form-control"  value="{{ $email }}" disabled>
                                <!-- @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Kata sandi Baru</label>

                            <div class="col-md-6">
                                <input id="password-baru" type="password" class="form-control" name="password_baru" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi Kata sandi</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Atur Ulang Kata Sandi') }}
                                </button>
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
