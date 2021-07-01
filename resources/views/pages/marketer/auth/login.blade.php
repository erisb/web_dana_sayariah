@extends('layouts.admin.masterguest')

@section('title', 'Marketer Login')

@section('content')

<body class="bg-dark">
<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="/">
                        <img src="/img/danasyariahlogo.png" alt="danasyariah">
                    </a>
                </div>
                <div class="login-form">
                <h4>Masuk sebagai Marketing</h4><hr>
                    <form id="sign_in_adm" method="POST" action="{{ route('marketer.login.submit') }}">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Email marketing" required autofocus>
                            @if ($errors->has('email'))
                            <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="rememberme" class="filled-in chk-col-pink"> Remember Me
                            </label>

                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection