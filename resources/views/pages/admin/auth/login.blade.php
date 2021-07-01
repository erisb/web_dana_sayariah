@extends('layouts.admin.masterguest')

@section('title', 'Login Admin')

@section('content')

<body class="bg-dsi-gradient" >
<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="/">
                        <img src="/img/logoOnly.png" height="70" alt="danasyariah">
                    </a>
                </div>
                <div class="login-form">
                    <p>Login</p>
                    <form id="sign_in_adm" method="POST" action="{{ route('admin.login.submit') }}">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                            @if ($errors->has('email'))
                            <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="rememberme" class="filled-in chk-col-pink"> Remember Me
                            </label>                           

                        </div>
                        <button type="submit" class="btn btn-success btn-round mb-3 mt-3">Sign in</button>                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection