@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection

@section('body')
<div class="sub-banner-2 mt-5 pt-5">
    <div class="container">
        <div class="breadcrumb-area">
            <h1>ATUR ULANG PASSWORD</h1>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <form method="POST" action="" aria-label="{{ __('Login') }}" style="margin:5px">
            @csrf
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label text-md-right">{{ __('email') }}</label>
                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
asd
                    </div>
                   </div>
            </form>
        </div>
    </div>
</div>
@endsection