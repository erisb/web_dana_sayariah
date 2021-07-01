@component('component.modal_login')
    @slot('modal_id') loginModalInvestor @endslot
    @slot('modal_title') 
    
        Login
    
    @endslot

    @slot('modal_content')
        <div class="panel-heading">
            <div class="row">
                <div class="col-12">
                <ul class=" nav nav-pills nav-fill">
                    <li class="nav-item">
                    <a href="#" class="nav-link active" id="login-form-link">Masuk Pendana</a>
                    </li>
                
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="register-form-link">Daftar Pendana</a>
                    </li>
                </ul>
                </div>
            </div>
            <hr>
        </div>
        <div id="login-form">
        @if(Session::has('reg_sukses'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('reg_sukses') }}
        </div>
        @elseif(Session::has('status_sukses'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_sukses') }}
        </div>
        @elseif(Session::has('status_kosong'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_kosong') }}
        </div>
        @elseif(Session::has('status_max_login'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_max_login') }}
        </div>
        @elseif(Session::has('status_email'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_email') }}
        </div>
        @endif
        <!-- social button hidden sementara-->
        <!--div class="row no-gutters mb-3">
            <div class="col-lg-12 text-center">
                <p class="text-center">Login dengan Akun:</p> 
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/google') }}" data-toggle="tooltip" data-placement="top" title="" class="width-80 circle bg_google btn btn-link text-success">
                    <i class="fab fa-google  text-white pt-1 "></i> <span class="text-white"> Google</span>
                </a>
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/facebook') }}" data-toggle="tooltip" data-placement="top" title="" class="width-80 circle bg_facebook btn btn-link text-success">
                    <i class="fab fa-facebook text-white pt-1 "></i> <span class="text-white"> Facebook </span>
                </a>
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/linkedin') }}" data-toggle="tooltip" data-placement="top" title="" class="width-80 circle bg_linkedin btn btn-link text-success">
                    <i class="fab fa-linkedin text-white pt-1"></i> <span class="text-white">LinkedIn</span>
                </a>
            </div>
            <div class="col-lg-12 text-center mt-3">
                <p class="text-center">Atau</p> 
            </div>
        </div-->
        <!-- end social media button -->
        <!-- <p>Please enter your user name and password to login</p> -->
        <form method="POST" action="{{route ('login')}}" aria-label="{{ __('Login') }}">
            @csrf

            <div class="form-group row">
                <div class="col-12 ">
                        <label for="username_register" class="col-form-label text-left"><span style="font-style: italic;">{{ __('Username') }} *</span></label>
                        <input id="username_login" type="text" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Type <i>Username</i>..." required >

                        @if ($errors->has('usernameLog'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('usernameLog') }}</strong>
                            </span>
                        @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="username_register" class="col-form-label text-left">{{ __('Password') }} *</label>
                    <input id="password_login" type="password" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                    @if ($errors->has('usernameLog'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('usernameLog') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-12 text-left mb-3">
                        <a style="font-size: .8rem; font-weight: 600;" href="{{route('password.request')}}">{{ __('Forgot Your Password?') }}</a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12 mt-2 mb-2">
                        <button type="submit" class="btn btn-md btn-block btn-danaSyariah text-white">LOGIN</button>
                    </div>
                    <!-- <div class="col-lg-12 col-md-12 col-xs-12">
                        <a class="btn btn-md btn-block text-success pt-3" data-toggle="modal" data-dismiss="modal" data-target="#registerModal"> <span class="text-dark"> Belum Registrasi ? </span> Klik Disini</a>
                    </div>    -->
                </div>   
            </div>
            
        </form>
        </div>
        <!-- Register Tab -->
        
        <form  id="register-form" method="POST" action="{{route ('register')}}" aria-label="{{ __('Register') }}" style="display: none;">
        @if(Session::has('status_email'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_email') }}
        </div>
        @endif
            @csrf
            <!-- social button hidden sementara-->
            <!--div class="row no-gutters mb-3">
                <div class="col-lg-12 text-center">
                    <p class="text-center">Register dengan Akun:</p> 
                </div>
                <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                    <a href="{{ url('/user/redirect/google') }}" data-toggle="tooltip" data-placement="top" class="width-80 circle bg_google btn btn-link text-success">
                        <i class="fab fa-google  text-white pt-1 "></i> <span class="text-white"> Google</span>
                    </a>
                </div>
                <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                    <a href="{{ url('/user/redirect/facebook') }}" data-toggle="tooltip" data-placement="top" class="width-80 circle bg_facebook btn btn-link text-success">
                        <i class="fab fa-facebook text-white pt-1 "></i>  <span class="text-white"> Facebook </span>
                    </a>
                </div>
                <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                    <a href="{{ url('/user/redirect/linkedin') }}" data-toggle="tooltip" data-placement="top" class="width-80 circle bg_linkedin btn btn-link text-success">
                        <i class="fab fa-linkedin text-white pt-1"></i> <span class="text-white">  LinkedIn </span>
                    </a>
                </div>
                <div class="col-lg-12 text-center mt-3">
                    <p class="text-center">Atau</p> 
                </div>
            </div-->
        <!-- end social media button -->
            <div class="row">
                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="username_register" class="col-12 col-form-label text-left">{{ __('Username') }} *</label>

                    <div class="col-12">
                        <input id="username_register" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Type username..." value="{{ old('username') }}" required>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                {{-- <strong>{{ $errors->first('username') }}</strong> --}}
                                <strong>Username Sudah Terdaftar</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="email" class="col-12 col-form-label text-left">{{ __('E-Mail Address') }} *</label>

                    <div class="col-12">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Type Email Address..." value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                {{-- <strong>{{ $errors->first('email') }}</strong> --}}
                                <strong>Email Sudah Terdaftar</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="password_register" class="col-12 col-form-label text-left">{{ __('Password') }} *</label>

                    <div class="col-12">
                        <input id="password_register" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Ketik kata sandi..." required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                {{-- <strong>{{ $errors->first('password') }}</strong> --}}
                                <strong>Kata Sandi Min 6 Karakter</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="password-confirm" class="col-12 col-form-label text-left">{{ __('Confirm Password') }} *</label>

                    <div class="col-12">
                        <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="ulangi ketik kata sandi..." required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                {{-- <strong>{{ $errors->first('password') }}</strong> --}}
                                <strong>Kata sandi Tidak Sama</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-lg-12">
                <!--
                <div class="form-group row">
                    <label class="col-12 col-form-label text-left">{{ __('Referal Code') }} (Optional)</label>

                    <div class="col-12">
                        <input type="text" class="form-control" name="ref_number" placeholder="Type Reveral code (optional)...">
                    </div>
                </div>
                -->
                </div>
            
                <div class="col-lg-12">
                    <div class="form-group row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" onchange="term_check()" id="agreed_term" >
                                <span>Agree with term and Condition <a href="{{ url('perjanjian') }}" target="_blank">Lebih lanjut...</a></span>
                            </div>
                    </div>
                    <div>
                            <button type="submit" id="button_register" disabled class="tn btn-md btn-block btn-danaSyariah text-white">Daftar</button>
                            <!-- <a type="button"  class="btn btn-md btn-block text-success" data-toggle="modal" data-dismiss="modal" data-target="#loginModal"> <span class="text-dark">Sudah Punya Akun ? </span> Klik Disini</a> -->
                    </div>
                </div>
            </div>
        </form>
        
        <style>
                .btn-danaSyariah.disabled, .btn-danaSyariah:disabled {
                color: #fff;
                background-color: #6c757d !important;
                border-color: #6c757d !important;
                background: #02775b;
                background-image: linear-gradient(45deg,#6c757d,#6c757d);
                background-image: -webkit-linear-gradient(45deg,#6c757d,#6c757d);
            } 
            .panel-heading a{
                color: #000;
                font-size: 18px;
            }
            .panel-heading a.active{
                color: #029f5b;
                font-size: 18px;
                font-weight: bold;
            }
            .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
                color: #fff;
                background: #02775b;
                background-image: linear-gradient(45deg,#317a12,#02775b);
                background-image: -webkit-linear-gradient(45deg,#317a12,#02775b);
                transition: all .4s ease;
            }
            .forgot-box {
                border-radius: 8px;
                background: inherit;
                padding: 20px;
                }
        </style>
        <script>
            function term_check(){
                var status = document.getElementById("agreed_term");

                if (status.checked == true){
                    document.getElementById("button_register").disabled = false;                                
                }
                else {
                    document.getElementById("button_register").disabled = true;                                
                    
                }

            }
        </script>
        <script>
            function readterm(){
                document.getElementById("button_register").disabled = false;   
                $("#loginModalInvestor").modal('show');
                $("#ModalTermCondition").modal('hide');            
            }
        </script>
                    
    @endslot

@endcomponent

@component('component.modal_login')
    @slot('modal_id') loginModalBorrower @endslot
    @slot('modal_title') 
    
        Login
    
    @endslot

    @slot('modal_content')
        <div class="panel-heading">
            <div class="row">
                <div class="col-12">
                <ul class=" nav nav-pills nav-fill">
                    <li class="nav-item">
                    <a href="#" class="nav-link active" id="login-form-link2">Login Penerima Dana</a>
                    </li>
                
                    <li class="nav-item">
                        <a href="#" class="nav-link" id="register-form-link2">Register Penerima Dana</a>
                    </li>
                </ul>
                </div>
            </div>
            <hr>
        </div>
        <div id="login-form2">
        @if(Session::has('reg_sukses'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('reg_sukses') }}
        </div>
        @elseif(Session::has('status_sukses'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_sukses') }}
        </div>
        @elseif(Session::has('status_kosong'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_kosong') }}
        </div>
        @elseif(Session::has('status_max_login'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_max_login') }}
        </div>
		 @elseif(Session::has('status_password'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_password') }}
        </div>
        @elseif(Session::has('status_email'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_email') }}
        </div>
		@elseif(Session::has('status_suspend'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('status_suspend') }}
        </div>
        @endif
        <!-- social button -->
        <!-- hidden sementara -->
        <!-- <div class="row no-gutters mb-3"> -->
            <!-- <div class="col-lg-12 text-center">
                <p class="text-center">Login dengan Akun:</p> 
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/google') }}" data-toggle="tooltip" data-placement="top" title="" class="width-80 circle bg_google btn btn-link text-success">
                    <i class="fab fa-google  text-white pt-1 "></i> <span class="text-white"> Google</span>
                </a>
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/facebook') }}" data-toggle="tooltip" data-placement="top" title="" class="width-80 circle bg_facebook btn btn-link text-success">
                    <i class="fab fa-facebook text-white pt-1 "></i> <span class="text-white"> Facebook </span>
                </a>
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/linkedin') }}" data-toggle="tooltip" data-placement="top" title="" class="width-80 circle bg_linkedin btn btn-link text-success">
                    <i class="fab fa-linkedin text-white pt-1"></i> <span class="text-white">LinkedIn</span>
                </a>
            </div>
            <div class="col-lg-12 text-center mt-3">
                <p class="text-center">Atau</p> 
            </div>
        </div> -->
        <!-- end social media button -->
        <!-- <p>Please enter your user name and password to login</p> -->
        <form method="POST" action="{{route ('borrower.login')}}" aria-label="{{ __('Login') }}">
            @csrf

            <div class="form-group row">
            <input type="hidden" id="type_users" name="type_users" value="borrower">
                <div class="col-12 ">
                        <label for="username_register" class="col-form-label text-left">{{ __('Username') }} *</label>
                        <input id="username_login" type="text" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Type Username..." required >

                        @if ($errors->has('usernameLog'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('usernameLog') }}</strong>
                            </span>
                        @endif
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="username_register" class="col-form-label text-left">{{ __('Password') }} *</label>
                    <input id="password_login" type="password" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                    @if ($errors->has('usernameLog'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('usernameLog') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-12 text-left mb-3">
                        <a style="font-size: .8rem; font-weight: 600;" href="{{route('password_borrower.request')}}">{{ __('Forgot Your Password?') }}</a>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12 mt-2 mb-2">
                        <button type="submit" class="btn btn-md btn-block btn-danaSyariah text-white">LOGIN</button>
                    </div>
                    <!-- <div class="col-lg-12 col-md-12 col-xs-12">
                        <a class="btn btn-md btn-block text-success pt-3" data-toggle="modal" data-dismiss="modal" data-target="#registerModal"> <span class="text-dark"> Belum Registrasi ? </span> Klik Disini</a>
                    </div>    -->
                </div>   
            </div>
            
        </form>
        </div>
        <!-- Register Tab -->
        
        <form  id="register-form2" method="POST" action="{{route ('borrower.register')}}" aria-label="{{ __('Register') }}" style="display: none;">
        @if(Session::has('brw_status_username'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('brw_status_username') }}
        </div>
		@elseif(Session::has('brw_status_email'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('brw_status_email') }}
        </div>
		@elseif(Session::has('brw_status_password'))
        <div class="alert alert-warning alert-dismissable fade show" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            {{ Session::get('brw_status_password') }}
        </div>
        @endif
            @csrf
        <!-- social button hidden sementara-->
        <!--div class="row no-gutters mb-3">
            <div class="col-lg-12 text-center">
                <p class="text-center">Register dengan Akun:</p> 
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/google') }}" data-toggle="tooltip" data-placement="top" class="width-80 circle bg_google btn btn-link text-success">
                    <i class="fab fa-google  text-white pt-1 "></i> <span class="text-white"> Google</span>
                </a>
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/facebook') }}" data-toggle="tooltip" data-placement="top" class="width-80 circle bg_facebook btn btn-link text-success">
                    <i class="fab fa-facebook text-white pt-1 "></i>  <span class="text-white"> Facebook </span>
                </a>
            </div>
            <div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                <a href="{{ url('/user/redirect/linkedin') }}" data-toggle="tooltip" data-placement="top" class="width-80 circle bg_linkedin btn btn-link text-success">
                    <i class="fab fa-linkedin text-white pt-1"></i> <span class="text-white">  LinkedIn </span>
                </a>
            </div>
            <div class="col-lg-12 text-center mt-3">
                <p class="text-center">Atau</p> 
            </div>
        </div-->
        <!-- end social media button -->
            <div class="row">
                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="username_register" class="col-12 col-form-label text-left">{{ __('Username') }} *</label>

                    <div class="col-12">
                        <input id="username_register" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Type username..." value="{{ old('username') }}" required>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="email" class="col-12 col-form-label text-left">{{ __('E-Mail Address') }} *</label>

                    <div class="col-12">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Type Email Address..." value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="password_register" class="col-12 col-form-label text-left">{{ __('Password') }} *</label>

                    <div class="col-12">
                        <input id="password_register" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Type password..." required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                </div>

                <div class="col-lg-6">
                <div class="form-group row">
                    <label for="password-confirm" class="col-12 col-form-label text-left">{{ __('Confirm Password') }} *</label>

                    <div class="col-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Type Password Again..." required>
                    </div>
                </div>
                </div>

                <div class="col-lg-12">
                <!--
                <div class="form-group row">
                    <label class="col-12 col-form-label text-left">{{ __('Referal Code') }} (Optional)</label>

                    <div class="col-12">
                        <input type="text" class="form-control" name="ref_number" placeholder="Type Reveral code (optional)...">
                    </div>
                </div>
                -->
                </div>
            
                <div class="col-lg-12">
                    <!--div class="form-group row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" onchange="term_check2()" id="agreed_term2" >
                            <span>Agree with term and Condition <a href="{{ url('perjanjian') }}" target="_blank">Read More...</a></span>
                        </div>
                    </div-->
                    <div class="form-group row" id="checkterm">
                        <div class="form-check">
                            <!-- <input class="form-check-input" type="checkbox" onchange="readterm()" id="agreed_term" > -->
                            <a class="btn" href="#" data-toggle="modal" data-target="#ModalTermCondition2">Klik disini untuk baca syarat dan ketentuan</a>
                        </div>
                    </div>
                    <div>
                        <button type="submit" id="button_register2" disabled class="tn btn-md btn-block btn-danaSyariah text-white">Daftar</button>
                        <!-- <a type="button"  class="btn btn-md btn-block text-success" data-toggle="modal" data-dismiss="modal" data-target="#loginModal"> <span class="text-dark">Sudah Punya Akun ? </span> Klik Disini</a> -->
                    </div>
                </div>
            </div>
        </form>
		
        <style>
                .btn-danaSyariah.disabled, .btn-danaSyariah:disabled {
                color: #fff;
                background-color: #6c757d !important;
                border-color: #6c757d !important;
                background: #02775b;
                background-image: linear-gradient(45deg,#6c757d,#6c757d);
                background-image: -webkit-linear-gradient(45deg,#6c757d,#6c757d);
            } 
            .panel-heading a{
                color: #000;
                font-size: 18px;
            }
            .panel-heading a.active{
                color: #029f5b;
                font-size: 18px;
                font-weight: bold;
            }
            .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
                color: #fff;
                background: #02775b;
                background-image: linear-gradient(45deg,#317a12,#02775b);
                background-image: -webkit-linear-gradient(45deg,#317a12,#02775b);
                transition: all .4s ease;
            }
            .forgot-box {
                border-radius: 8px;
                background: inherit;
                padding: 20px;
                }
        </style>
        <script>
			
            function term_check2(){
                var status = document.getElementById("agreed_term2");

                if (status.checked == true){
                    document.getElementById("button_register2").disabled = false;                                
                }
                else {
                    document.getElementById("button_register2").disabled = true;                                
                    
                }

            }
			
        </script>
        <script>
            function readterm2()
            {
                document.getElementById("button_register2").disabled = false;   
                $("#loginModalBorrower").modal('show');
                $("#ModalTermCondition2").modal('hide');          
            }
        </script>
                    
    @endslot

@endcomponent