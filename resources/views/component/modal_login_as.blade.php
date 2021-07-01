<style>
.login100-more {
    min-width: 50%;
    min-height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 1;
    border-radius: 10px 0 0 10px;
}
.login100-more::before {
    content: "";
    display: block;
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0,0,0,.3);
    background-image: linear-gradient(45deg,rgb(49, 122, 18, 0.8),rgb(2, 119, 91, 0.9));
    background-image: -webkit-linear-gradient(45deg,rgb(49, 122, 18, 0.8),rgb(2, 119, 91, 0.9));
    transition: all .4s ease;
    
}
.logo-render{
    width: 80px;
    height: auto;
    -ms-flex: none;
    -webkit-flex: none;
    flex: none;
    opacity: 0.8;
    margin-right: 50%;
    margin-left: auto;
}

.modal-bodyagre{
  height: 250px;
  overflow-y: auto;
}
</style>
<div id="{{$modal_id}}" class="modal fade in modal_scroll" role="dialog" >
  <div class="modal-dialog modal-lg modal-dialog-centered ">
  @include('includes.login_register')
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        
        <div class="row no-gutters">   
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="login100-more" style="background-image: url('img/bg-login.jpg');">
                <div class="d-flex ">
                  <div class="p-2 mx-auto text-white p-5 pt-2">
                    <img class="logo-render" src="/img/logo_only_white.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="content-form-box forgot-box ">

                    <div class=" container-fluid ">
                        <div>
                            <h5>Hi, Kawan..</h5>
                            <p>Silahkan Pilih Sebagai:</p>
                            <hr>
                          <button type="button" class="close ml-5 mr-5 pr-2 mt-3 text-dark" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"><i class="lni-close size-sm"></i> </span>
                          </button>
                        </div>
                    </div>

                    <div class="container-fluid">                    
						 <div class="panel-heading">
							<div class="row">
								<div class="col-12">
								<ul class=" nav nav-pills nav-fill">
									<li class="nav-item">
									<a href="#" data-toggle="modal" data-target="#modal_login_investor" data-dismiss="modal" aria-label="Close" class="nav-link active" >PENDANA</a>
									<!--<a href="#" data-toggle="modal" data-target="#loginModalInvestor" class="nav-link active" id="login-form-link">INVESTOR</a>-->
									</li>
								
									<li class="nav-item">
										<a href="#" data-toggle="modal" data-target="#modal_login_borrower" data-dismiss="modal" aria-label="Close" class="nav-link">PENERIMA PENDANAAN</a>
										<!--<a href="#" data-toggle="modal" data-target="#loginModalBorrower" class="nav-link" id="register-form-link">BORROWER</a>-->
									</li>
								</ul>
								</div>
							</div>
							<hr>
						</div>    
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal_login_investor" class="modal fade in modal_scroll" role="dialog" >
  <div class="modal-dialog modal-lg modal-dialog-centered ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        
        <div class="row no-gutters">   
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="login100-more" style="background-image: url('img/bg-login.jpg');">
                <div class="d-flex ">
                  <div class="p-2 mx-auto text-white p-5 pt-2">
                    <img class="logo-render" src="/img/logo_only_white.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="content-form-box forgot-box ">

                    <div class=" container-fluid ">
                        <div>
                            <h5>Hai, Kawan..</h5>
                            <p>Silahkan lengkapi data untuk melanjutkan.</p>
                            <hr>
                          <button type="button" class="close ml-5 mr-5 pr-2 mt-3 text-dark" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"><i class="lni-close size-sm"></i> </span>
                          </button>
                        </div>
                    </div>

                    <div class="container-fluid">                    
						<div class="panel-heading">
						<div class="row">
							<div class="col-12">
							<ul class=" nav nav-pills nav-fill">
								<li class="nav-item">
								<a href="#" class="nav-link active" id="login-form-link">Masuk Sebagai Pendana</a>
								</li>
							
								<li class="nav-item">
									<a href="#" class="nav-link" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#modal_register_investor" id="register-form-link">Daftar Menjadi Pendana</a>
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
						<!-- <div class="row no-gutters mb-3">
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
						</div> -->
						<!-- end social media button -->
						<!-- <p>Please enter your user name and password to login</p> -->
						<form method="POST" action="{{route ('login')}}" aria-label="{{ __('Login') }}">
							@csrf

							<div class="form-group row">
								<div class="col-12 ">
										<label for="username_register" class="col-form-label text-left">
											<!--<span style="font-style: italic;">{{ __('Username') }} *</span>-->
											Akun *
										</label>
										<input id="username_login" type="text" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Ketik Akun Anda..." required >

										@if ($errors->has('usernameLog'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('usernameLog') }}</strong>
											</span>
										@endif
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12">
									<label for="username_register" class="col-form-label text-left">
										<!--<span style="font-style: italic;">{{ __('Password') }} *</span>-->
										Kata Sandi *
									</label>
									<input id="password_login" type="password" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="password" placeholder="Kata Sandi..." required>

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
										<a style="font-size: .8rem; font-weight: 600;" href="{{route('password.request')}}"><!--{{ __('Forgot Your Password?') }}-->Lupa Kata Sandi</a>
									</div>
									<div class="col-lg-12 col-md-12 col-xs-12 mt-2 mb-2">
										<button type="submit" class="btn btn-md btn-block btn-danaSyariah text-white">MASUK</button>
									</div>
									<!-- <div class="col-lg-12 col-md-12 col-xs-12">
										<a class="btn btn-md btn-block text-success pt-3" data-toggle="modal" data-dismiss="modal" data-target="#registerModal"> <span class="text-dark"> Belum Registrasi ? </span> Klik Disini</a>
									</div>    -->
								</div>   
							</div>
							
						</form>
						</div>
						
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
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal_register_investor" class="modal fade in modal_scroll" role="dialog" >
  <div class="modal-dialog modal-lg modal-dialog-centered ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        
        <div class="row no-gutters">   
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="login100-more" style="background-image: url('img/bg-login.jpg');">
                <div class="d-flex ">
                  <div class="p-2 mx-auto text-white p-5 pt-2">
                    <img class="logo-render" src="/img/logo_only_white.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="content-form-box forgot-box ">

                    <div class=" container-fluid ">
                        <div>
                            <h5>Hi, Kawan Pendana..</h5>
                            <p>Silahkan lengkapi data untuk melanjutkan.</p>
                            <hr>
                          <button type="button" class="close ml-5 mr-5 pr-2 mt-3 text-dark" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"><i class="lni-close size-sm"></i> </span>
                          </button>
                        </div>
                    </div>

                    <div class="container-fluid">                    
						<div class="panel-heading">
						<div class="row">
							<div class="col-12">
							<ul class=" nav nav-pills nav-fill">
								<li class="nav-item">
								<a href="#" class="nav-link" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#modal_login_investor" id="login-form-link">Masuk Sebagai Pendana</a>
								</li>
							
								<li class="nav-item">
									<a href="#" class="nav-link active"  data-toggle="modal" data-target="#modal_register_investor" id="register-form-link">Daftar Sebagai Pendana</a>
								</li>
							</ul>
							</div>
						</div>
						<hr>
					</div>
						
						<!-- Register Tab -->
        
						<form  id="register-form" method="POST" action="{{route ('register')}}" aria-label="{{ __('Register') }}">
						@if(Session::has('status_email'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('status_email') }}
						</div>
						@endif
							@csrf
							<!-- social button -->
						{{-- <div class="row no-gutters mb-3">
							<div class="col-lg-12 text-center">
								<p class="text-center">Daftar dengan Akun:</p> 
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
						</div> --}}
						<!-- end social media button -->
							<div class="row">
								<div class="col-lg-6">
								<div class="form-group row">
									<label for="username_register" class="col-12 col-form-label text-left">
										<!--<span style="font-style: italic;">{{ __('Username') }} *</span>-->
										Akun *
									</label>

									<div class="col-12">
										<input id="username_register" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Ketik Akun Anda..." value="{{ old('username') }}" required>
										
										@if ($errors->has('username'))
											<span class="invalid-feedback" role="alert">
												{{-- <strong>{{ $errors->first('username') }}</strong> --}}
												<strong>Akun Sudah Terdaftar</strong>
											</span>
										@endif
									</div>
								</div>
								</div>

								<div class="col-lg-6">
								<div class="form-group row">
									<label for="email" class="col-12 col-form-label text-left">
										<!--<span style="font-style: italic;">{{ __('E-Mail Address') }} *</span>-->
										<span style="font-style: italic;">E-Mail *</span>
									</label>

									<div class="col-12">
										<input id="email_investor" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Ketik alamat email..." value="{{ old('email') }}"  pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" required>
										@if ($errors->has('email'))
											<span class="invalid-feedback" role="alert">
												{{-- <strong>{{ $errors->first('email') }}</strong> --}}
												<strong>Email Sudah Terdaftar</strong>
											</span>
										@endif
									</div>
									<div>
										<span id="error_email" style="color:red;font-size:11px;margin-left:15px"></span>
									</div>
								</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group row">
										<label for="password_register" class="col-12 col-form-label text-left">
											<!--<span style="font-style: italic;">{{ __('Password') }} *</span>-->
											Kata Sandi *
										</label>

										<div class="col-12">
											<input type="password" id="register_password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Ketik Kata Sandi..." required>

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
										<label for="password-confirm" class="col-12 col-form-label text-left">
											<!-- <span style="font-style: italic;">{{ __('Confirm Password') }} *</span> -->
											Konfirmasi Kata Sandi *
										</label>

										<div class="col-12">
											<input id="register_password_confirmation" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="Ketik Kembali Kata Sandi..." onclick="cek_confirm()" required>

											@if ($errors->has('password'))
												<span class="invalid-feedback" role="alert">
													{{-- <strong>{{ $errors->first('password') }}</strong> --}}
													<strong>Kata Sandi Tidak Sama</strong>
												</span>
											@endif
										</div>
										<div>
											<span id="error_confirm_password" style="color:red;font-size:11px;margin-left:15px"></span>
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
								<div style="margin-left:15px">
									<span id="8char" class="fa fa-times" style="color:#FF0004;"></span>&nbsp;<small style="font-size:10px">Minimal 8 Karakter</small>&nbsp;
									<input type="hidden" id = "char">
									<span id="ucase" class="fa fa-times" style="color:#FF0004;"></span>&nbsp;<small style="font-size:10px">Huruf Besar</small>&nbsp;
									<input type="hidden" id = "upper">
									<span id="lcase" class="fa fa-times" style="color:#FF0004;"></span>&nbsp;<small style="font-size:10px">Huruf Kecil</small>&nbsp;
									<input type="hidden" id = "lower">
									<span id="num" class="fa fa-times" style="color:#FF0004;"></span>&nbsp;<small style="font-size:10px">Karakter Angka</small>&nbsp;
									<input type="hidden" id = "int">
								</div>
							
								<div class="col-lg-12">
									<!--div class="form-group row">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" id="agreed_term">
											<span>Agree with term and Condition <a href="{{ url('perjanjian') }}" target="_blank">Read More...</a></span>
										</div>
									</div-->
									<div class="form-group row" id="checkterm">
										<div class="form-check">
											<a class="btn" href="#" id="checks" onclick="modalTerm()">Klik disini untuk baca syarat dan ketentuan</a>
										</div>
									</div>
									<div>
										<button type="submit" id="button_register_investor" disabled class="tn btn-md btn-block btn-danaSyariah text-white">Daftar</button>
										<!-- <a type="button"  class="btn btn-md btn-block text-success" data-toggle="modal" data-dismiss="modal" data-target="#loginModal"> <span class="text-dark">Sudah Punya Akun ? </span> Klik Disini</a> -->
									</div>
								</div>
							</div>
						</form>
						
						
						<script type="text/javascript">
							function email_filter_validation_inv()
							{
								var email = document.getElementById("email_investor").value;
								var email_instan_inv1 = email.includes("mailinator");
								var email_instan_inv2 = email.includes("urhen");
								var email_instan_inv3 = email.includes("guerrillamail");
								var email_instan_inv4 = email.includes("maildrop");
								var email_instan_inv5 = email.includes("wemel");
								var email_instan_inv6 = email.includes("mt2015");
								var email_instan_inv7 = email.includes("dispostable");
								var email_instan_inv8 = email.includes("tempr");
								var email_instan_inv9 = email.includes("discard");
								var email_instan_inv10 = email.includes("mailcatch");
								var email_instan_inv11 = email.includes("einroit");
								var email_instan_inv12 = email.includes("mailnesia");
								var email_instan_inv13 = email.includes("yopmail");
								//alert(email);
								if (email_instan_inv1 || email_instan_inv2 || email_instan_inv3 || email_instan_inv4 || email_instan_inv5 || email_instan_inv6 || email_instan_inv7 || email_instan_inv8 || email_instan_inv9 || email_instan_inv10 || email_instan_inv11 || email_instan_inv12 || email_instan_inv13) {
									$('#error_email').html('<b id="emailerror">Domain Email Anda tidak diizinkan. Silahkan gunakan domain email lain</b>');
									$('#checks').hide();
									$('#button_register_investor').attr('disabled',true);

								}else{
									$('#checks').show();
									$('#emailerror').hide();
									return true; 		
								}
							}

							function email_filter_validation_brw()
							{
								var email = document.getElementById("email_borrower").value;
								var email_instan_brw1 = email.includes("mailinator");
								var email_instan_brw2 = email.includes("urhen");
								var email_instan_brw3 = email.includes("guerrillamail");
								var email_instan_brw4 = email.includes("maildrop");
								var email_instan_brw5 = email.includes("wemel");
								var email_instan_brw6 = email.includes("mt2015");
								var email_instan_brw7 = email.includes("dispostable");
								var email_instan_brw8 = email.includes("tempr");
								var email_instan_brw9 = email.includes("discard");
								var email_instan_brw10 = email.includes("mailcatch");
								var email_instan_brw11 = email.includes("einroit");
								var email_instan_brw12 = email.includes("mailnesia");
								var email_instan_brw13 = email.includes("yopmail");
								//alert(email);
								if (email_instan_brw1 || email_instan_brw2 || email_instan_brw3 || email_instan_brw4 || email_instan_brw5 || email_instan_brw6 || email_instan_brw7 || email_instan_brw8 || email_instan_brw9 || email_instan_brw10 || email_instan_brw11 || email_instan_brw12 || email_instan_brw13) {
									//alert('Domain Email Anda tidak diizinkan. Silahkan gunakan domain email lain');
									$('#error_email_brw').html('<b id="emailbrwerror">Domain Email Anda tidak diizinkan. Silahkan gunakan domain email lain</b>');
									$('#checks_brw').hide();
									$('#button_register_borrower').attr('disabled',true);

								}else{
									$('#checks_brw').show();
									$('#emailbrwerror').hide();
									return true; 		
								}
							}
						</script>
						
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
					<script src="/js/jquery-3.3.1.min.js"></script>
					<script type="text/javascript">
						$(document).ready(function(){
							$("input[type=password]").keyup(function(){
								
								var ucase = new RegExp("[A-Z]+");
								var lcase = new RegExp("[a-z]+");
								var num = new RegExp("[0-9]+");

								var thru = false;
								
								if($("#register_password").val().length >= 8){
									$("#8char").removeClass("fa fa-times");
									$("#8char").addClass("fa fa-check");
									$("#8char").css("color","#00A41E");
									$("#char").val(1);
								}else{
									$("#8char").removeClass("fa fa-check");
									$("#8char").addClass("fa fa-times");
									$("#8char").css("color","#FF0004");
									$("#char").val(0);
								}
								
								if(ucase.test($("#register_password").val())){
									
									$("#ucase").removeClass("fa fa-times");
									$("#ucase").addClass("fa fa-check");
									$("#ucase").css("color","#00A41E");
									$("#upper").val(1);
								}else{
									$("#ucase").removeClass("fa fa-check");
									$("#ucase").addClass("fa fa-times");
									$("#ucase").css("color","#FF0004");
									$("#upper").val(0);
								}
								
								if(lcase.test($("#register_password").val())){
									$("#lcase").removeClass("fa fa-times");
									$("#lcase").addClass("fa fa-check");
									$("#lcase").css("color","#00A41E");
									$("#lower").val(1);
								}else{
									$("#lcase").removeClass("fa fa-check");
									$("#lcase").addClass("fa fa-times");
									$("#lcase").css("color","#FF0004");
									$("#lower").val(0);
								}
								
								if(num.test($("#register_password").val())){
									
									$("#num").removeClass("fa fa-times");
									$("#num").addClass("fa fa-check");
									$("#num").css("color","#00A41E");
									$("#int").val(1);
								}else{
									$("#num").removeClass("fa fa-check");
									$("#num").addClass("fa fa-times");
									$("#num").css("color","#FF0004");
									$("#int").val(0);
								}

								if (thru = true)
								{
									
									if($("#register_password").val() == $("#register_password_confirmation").val() && $("#int").val()== 1 && $("#lower").val()== 1 && $("#upper").val()== 1 && $("#char").val()== 1 && $("#setuju2").val()== 1)
									{
											
										document.getElementById("button_register_investor").disabled = false;
										
										
									}else if($("#register_password").val() == $("#register_password_confirmation").val() && $("#int").val()== 0 && $("#lower").val()== 0 && $("#upper").val()== 0 && $("#char").val()== 0 && $("#setuju2").val()== 0){
										document.getElementById("button_register_investor").disabled = true; 
									}
									
								}
								else
								{
								
									document.getElementById("button_register_investor").disabled = true;
								
								}
								
							});
						});

						function cek_confirm()
						{
							if($("#register_password_confirmation").val() != $("#register_password").val() && $("#setuju2").val()== 0)
							{
								$('#error_confirm_password').html('<b id="confirm_password_error">Konfirmasi kata sandi tidak sesuai dengan kata sandi baru.</b>');
								document.getElementById("button_register_investor").disabled = true; 
							}
							else if($("#register_password_confirmation").val() == $("#register_password").val() && $("#int").val()== 0 && $("#lower").val()== 0 && $("#upper").val()== 0 && $("#char").val()== 0 && $("#setuju2").val()== 0)
							{
								document.getElementById("button_register_investor").disabled = true; 
							}
							else{
								$('#confirm_password_error').hide();
								document.getElementById("button_register_investor").disabled = false;
							}

						}

					</script>
					<script>					
						$(document).ready(function(){
					        $('input[type="checkbox"]').click(function(){
					            if($(this).is(":checked")){
					                $('#button_register_investor').prop('disabled',false);
					            }
					            else if($(this).is(":not(:checked)")){
					                $('#button_register_investor').prop('disabled',true);
					            }
					        });
					    });
					</script>
					<script>
						function modalTerm(){
							// alert()
							$("#modal_register_investor").modal('hide');
							$("#loginModalInvestor").modal('hide');
							$("#ModalTermCondition").modal('show');  
							$("#ModalTermCondition").appendTo('body');         
						 }
					</script>
					<script>
						function readterm(){
							document.getElementById("button_register_investor").disabled = false;   
							$("#modal_register_investor").modal('show');
							$("#ModalTermCondition").modal('hide');           
						 }
					</script>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- modal Term Condition --}}
<!-- <div id="ModalTermCondition"  class="modal fade in modal_scroll" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="scrollmodalLabel">Syarat & Ketentuan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="agree">
			@csrf
				<div class="modal-body">
					<iframe src="{{ url('perjanjian') }}" scrolling="yes" height="500" id="iprem"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" name="submit" value="submit" class="btn btn-sm btn-success" onclick="readterm()" disabled>Saya Setuju</button>
					<a href="javascript:myFunc()">Check my scroll position</a>
				</div>
			</form>
		</div>
	</div>
</div> -->
<div id="ModalTermCondition" class="modal fade in " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" style="max-height:85%;  margin-top: 50px; margin-bottom:50px;" > 
        <div class="modal-content"> 
            <div class="modal-header"> 
				<h5 class="modal-title" id="scrollmodalLabel">Syarat & Ketentuan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div> 
            <div class="modal-bodyagre p-5">
				
			<?php
				$tmp = \App\TermCondition::where('typesyarat','1')->first();
			?>
				<p style="font-size: .15em; line-height: 1.5em; font-weight: 400;">{!!  $tmp->deskripsi !!}</p>
				<p style="font-size: .7em; line-height: 1.5em; font-weight: 400; color: red;"><input type="checkbox" id="setuju"> Saya Menyetujui Syarat dan Ketentuan yang Berlaku</p>
				<input type="hidden" id="setuju2">
			</div> 
		    <div class="modal-footer">
				<button type="button" name="submit" value="submit" class="btn btn-sm btn-default" id="btnStj" onclick="readterm()" disabled>Saya Setuju</button>
			</div>
        </div> 
    </div> 
</div> 
{{-- end modal Term Condition --}}

<div id="modal_login_borrower" class="modal fade in modal_scroll" role="dialog" >
  <div class="modal-dialog modal-lg modal-dialog-centered ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        
        <div class="row no-gutters">   
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="login100-more" style="background-image: url('img/bg-login.jpg');">
                <div class="d-flex ">
                  <div class="p-2 mx-auto text-white p-5 pt-2">
                    <img class="logo-render" src="/img/logo_only_white.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="content-form-box forgot-box ">

                    <div class=" container-fluid ">
                        <div>
                            <h5>Hi, Kawan Penerima Pendanaan..</h5>
                            <p>Silahkan lengkapi data untuk melanjutkan.</p>
                            <hr>
                          <button type="button" class="close ml-5 mr-5 pr-2 mt-3 text-dark" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"><i class="lni-close size-sm"></i> </span>
                          </button>
                        </div>
                    </div>

                    <div class="container-fluid">                    
						<div class="panel-heading">
						<div class="row">
							<div class="col-12">
							<ul class=" nav nav-pills nav-fill">
								<li class="nav-item">
								<a href="#" class="nav-link active" id="login-form-link">Masuk Sebagai Penerima Pendanaan</a>
								</li>
							
								<li class="nav-item">
									<a href="#" class="nav-link" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#modal_register_borrower" id="register-form-link">Daftar Sebagai Penerima Pendanaan</a>
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
						@elseif(Session::has('status_password'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('status_password') }}
						</div>
						@elseif(Session::has('brw_status_username'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('brw_status_username') }}
						</div>
						@endif
						<!-- social button hidde sementara-->
						<!-- <div class="row no-gutters mb-3">
							<div class="col-lg-12 text-center">
								<p class="text-center">Login dengan Akun:</p> 
							</div>
							<div class=" mt-2 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
								<a href="{{ url('/user/redirect/google') }}" data-toggle="tooltip" data-placement="top" title="" class="width-80 circle bg_google btn btn-link text-success">
									<i class="fab fa-google  text-white pt-1 "></input> <span class="text-white"> Google</span>
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
								<div class="col-12 ">
										<label for="username_register" class="col-form-label text-left">
											<!--<span style="font-style: italic;">{{ __('Username') }} *</span>-->
											Akun *
										</label>
										<input id="username_login" type="text" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Ketik Akun Anda..." required >

										@if ($errors->has('usernameLog'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('usernameLog') }}</strong>
											</span>
										@endif
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12">
									<label for="username_register" class="col-form-label text-left">
										<!--<span style="font-style: italic;">{{ __('Password') }} *</span>-->
										Kata Sandi *
									</label>
									<input id="password_login" type="password" class="form-control{{ $errors->has('usernameLog') ? ' is-invalid' : '' }}" name="password" placeholder="Kata Sandi..." required>

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
										<a style="font-size: .8rem; font-weight: 600;" href="{{route('password_borrower.request')}}"><!--{{ __('Forgot Your Password?') }} -->Lupa Kata Sandi</a>
									</div>
									<div class="col-lg-12 col-md-12 col-xs-12 mt-2 mb-2">
										<button type="submit" class="btn btn-md btn-block btn-danaSyariah text-white">MASUK</button>
									</div>
									<!-- <div class="col-lg-12 col-md-12 col-xs-12">
										<a class="btn btn-md btn-block text-success pt-3" data-toggle="modal" data-dismiss="modal" data-target="#registerModal"> <span class="text-dark"> Belum Registrasi ? </span> Klik Disini</a>
									</div>    -->
								</div>   
							</div>
							
						</form>
						</div>
						
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
					
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal_register_borrower" class="modal fade in modal_scroll" role="dialog" >
  <div class="modal-dialog modal-lg modal-dialog-centered ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        
        <div class="row no-gutters">   
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <div class="login100-more" style="background-image: url('img/bg-login.jpg');">
                <div class="d-flex ">
                  <div class="p-2 mx-auto text-white p-5 pt-2">
                    <img class="logo-render" src="/img/logo_only_white.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="content-form-box forgot-box ">

                    <div class=" container-fluid ">
                        <div>
                            <h5>Hi, Kawan..</h5>
                            <p>Silahkan lengkapi data untuk melanjutkan.</p>
                            <hr>
                          <button type="button" class="close ml-5 mr-5 pr-2 mt-3 text-dark" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"><i class="lni-close size-sm"></i> </span>
                          </button>
                        </div>
                    </div>

                    <div class="container-fluid">                    
						<div class="panel-heading">
						<div class="row">
							<div class="col-12">
							<ul class=" nav nav-pills nav-fill">
								<li class="nav-item">
								<a href="#" class="nav-link" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#modal_login_borrower" id="login-form-link">Masuk Sebagai Penerima Pendanaan</a>
								</li>
							
								<li class="nav-item">
									<a href="#" class="nav-link active"  data-toggle="modal" data-target="#modal_register_borrower" id="register-form-link">Daftar Sebagai Penerima Pendanaan</a>
								</li>
							</ul>
							</div>
						</div>
						<hr>
					</div>
						
						<!-- Register Tab -->
        
						<form  id="register-form" method="POST" action="{{route ('borrower.register')}}" aria-label="{{ __('Register') }}">
						@if(Session::has('status_email'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('status_email') }}
						</div>
						@elseif(Session::has('brw_status_username'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('brw_status_username') }}
						</div>
						@elseif(Session::has('brw_status_email'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('brw_status_email') }}
						</div>
						@elseif(Session::has('brw_status_length_password'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('brw_status_length_password') }}
							
						</div>
						@elseif(Session::has('brw_status_same_password'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('brw_status_same_password') }}
							
						</div>
						@elseif(Session::has('brw_status_length_confirm_password'))
						<div class="alert alert-warning alert-dismissable fade show" role="alert">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							{{ Session::get('brw_status_length_confirm_password') }}
							
						</div>
						@endif

						
						
							@csrf
							<!-- social button -->

						{{-- <div class="row no-gutters mb-3">
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
						</div> --}}
						<!-- end social media button -->
							<div class="row">
								<div class="col-lg-6">
								<div class="form-group row">
									<label for="username_register" class="col-12 col-form-label text-left">
										<!--<span style="font-style: italic;">{{ __('Username') }} *</span>-->
										Akun *
									</label>

									<div class="col-12">
										<input id="username_register" type="text" class="form-control{{ $errors->has('username_borrower') ? ' is-invalid' : '' }}" name="username_borrower" placeholder="Ketik Akun Anda..." value="{{ old('username_borrower') }}" required>
										
										
									</div>
								</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group row">
										<label for="email" class="col-12 col-form-label text-left">
											<!--<span style="font-style: italic;">{{ __('E-Mail Address') }} *</span>-->
											<span style="font-style: italic;">E-mail *</span>
										</label>

										<div class="col-12">
											<input id="email_borrower" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Ketik Alamat Email..." value="{{ old('email') }}" onkeyup="email_filter_validation_brw()" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" required>

											@if ($errors->has('email'))
												<span class="invalid-feedback" role="alert">
													{{-- <strong>{{ $errors->first('email') }}</strong> --}}
													<strong>Email Sudah Terdaftar</strong>
												</span>
											@endif
										</div>
										<div>
											<span id="error_email_brw" style="color:red;font-size:11px;margin-left:15px"></span>
										</div>
									</div>
								</div>

								<div class="col-lg-6">
								<div class="form-group row">
									<label for="password_register" class="col-12 col-form-label text-left">
										<!--<span style="font-style: italic;">{{ __('Password') }} *</span>-->
										Kata Sandi *
									</label>

									<div class="col-12" id="divPass">
										<input id="password_register_borrower" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Ketik Kata Sandi..." onKeyUp="checkPassword();"  required>
										<span id="result"></span>
										@if ($errors->has('password'))
											<span class="invalid-feedback" role="alert">
												{{-- <strong>{{ $errors->first('password') }}</strong> --}}
												<strong>Kata Sandi Min 8 Karakter</strong>
											</span>
										@endif
									</div>
									<div id="password-strength-status"></div>
								</div>
								</div>

								<div class="col-lg-6">
								<div class="form-group row">
									<label for="password-confirm" class="col-12 col-form-label text-left">
										{{--{{ __('Confirm Password') }} *--}}
										Konfirmasi Kata Sandi *
									</label>

									<div class="col-12">
										{{-- <input id="password_confirm_borrower" type="password" class="form-control" name="password_confirmation" placeholder="Ketik Kembali Kata Sandi..." required> --}}
										<input id="password_confirmation" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="Ketik Kembali Kata Sandi..." required>

				                        @if ($errors->has('password'))
				                            <span class="invalid-feedback" role="alert">
				                                {{-- <strong>{{ $errors->first('password') }}</strong> --}}
				                                <strong>Kata Sandi Tidak Sama</strong>
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
									<!--div class="form-group row">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" id="agreed_term" >
											<span>Agree with term and Condition <a href="{{ url('perjanjian') }}" target="_blank">Read More...</a></span>
										</div>
									</div-->
									<div class="form-group row" id="checkterm">
										<div class="form-check">
											<a class="btn" id="checks_brw" href="#" onclick="modalTerm2()">Klik disini untuk baca syarat dan ketentuan</a>
										</div>
									</div>

									<div>
										<button type="submit" id="button_register_borrower" disabled class="tn btn-md btn-block btn-danaSyariah text-white">Daftar</button>
										<!-- <a type="button"  class="btn btn-md btn-block text-success" data-toggle="modal" data-dismiss="modal" data-target="#loginModal"> <span class="text-dark">Sudah Punya Akun ? </span> Klik Disini</a> -->
									</div>
								</div>
							</div>
						</form>
						<script>
						
						</script>
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
					<script src="/js/jquery-3.3.1.min.js"></script>
					<script>
					
						// var toPass = false;
						// function checkPassword() {
							// var number = /([0-9])/;
							// var alphabets = /([a-zA-Z])/;
							// var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
							// if ($("#txt_no_ktp_pribadi").val().length == 8) {
                
							// if (toPass) {
								// clearTimeout(toPass);
							// }
							// toPass = setTimeout(function () {
									// if ($('#password_register_borrower').val().match(number) && $('#password_register_borrower').val().match(alphabets) && $('#password_register_borrower').val().match(special_characters)) {
										// $('#password-strength-status').removeClass();
										// $('#password-strength-status').addClass('strong-password');
										// $('#password-strength-status').html("Strong");
									// }
								// }, 100);
								
							// } else {
								// $("#divNoKTP label").remove();
								// $("#divNoKTP").addClass("has-error is-invalid");
								// $("#divNoKTP").prepend('<label style="color:red;" for="txt_no_ktp_pribadi"><i class="fa fa-times-circle-o"></i> NIK Harus 8 Digit</label>');
											 
							// }
							// // if ($('#password_register_borrower').val().length < 8) {
								
								// // $("#divPass label").remove();
								// // $("#divPass").addClass("has-error is-invalid");
								// // $("#divPass").prepend('<label style="color:red;" for="password_register_borrower"><i class="fa fa-times-circle-o"></i> NIK Harus 16 Digit</label>');
								// // // $('#password-strength-status').removeClass();
								// // // $('#password-strength-status').addClass('weak-password');
								// // // $('#password-strength-status').html("Weak (should be atleast 6 characters.)");
							// // } else {
								// // if ($('#password_register_borrower').val().match(number) && $('#password_register_borrower').val().match(alphabets) && $('#password_register_borrower').val().match(special_characters)) {
									// // $('#password-strength-status').removeClass();
									// // $('#password-strength-status').addClass('strong-password');
									// // $('#password-strength-status').html("Strong");
								// // } else {
									// // $('#password-strength-status').removeClass();
									// // $('#password-strength-status').addClass('medium-password');
									// // $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
								// // }
							// // }
						// }
						
						$(document).ready(function(){
							
							
							// function checkStrength(password) {
								
							// }
							
							
					        $('input[type="checkbox"]').click(function(){
					            if($(this).is(":checked")){
					                $('#button_register_borrower').prop('disabled',false);
					            }
					            else if($(this).is(":not(:checked)")){
					                $('#button_register_borrower').prop('disabled',true);
					            }
					        });
					    });
					</script>
					<script>
						function modalTerm2(){
							// alert()
							$("#modal_register_borrower").modal('hide');
							$("#loginModalBorrower").modal('hide');
							$("#ModalTermCondition2").modal('show');  
							$("#ModalTermCondition2").appendTo('body');         
						 }
					</script>
					<script>
						function readterm2(){
							document.getElementById("button_register_borrower").disabled = false;   
							$("#modal_register_borrower").modal('show');
							$("#ModalTermCondition2").modal('hide');           
						 }
					</script>
					<script>
						$('#setuju').bind('click', function() {
							if($(this).is(":checked")) {
								$('#btnStj').removeAttr('disabled');
								$('#btnStj').removeClass('btn-default').addClass('btn-success');
								$("#setuju2").val(1);
							} else {
								$('#btnStj').attr("disabled", true);
								$('#btnStj').removeClass('btn-success').addClass('btn-default');
							}
						});
					</script>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- modal Term Condition2 --}}
<!-- <div id="ModalTermCondition2"  class="modal fade in modal_scroll" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="scrollmodalLabel">Syarat & Ketentuan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="agree">
			@csrf
				<div class="modal-body">
					<iframe src="{{ url('perjanjian_borrower') }}" scrolling="no" height="500px"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" name="submit" value="submit" class="btn btn-sm btn-success" onclick="readterm2()">Saya Setuju</button>
				</div>
			</form>
		</div>
	</div>
</div> -->
<div id="ModalTermCondition2" class="modal fade in " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" style="max-height:200%;  margin-top: 50px; margin-bottom:50px;" > 
        <div class="modal-content"> 
            <div class="modal-header"> 
				<h5 class="modal-title" id="scrollmodalLabel">Syarat & Ketentuan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
            </div> 
            <div class="modal-bodyagre p-5">
				
			<?php
				$tmp = \App\TermCondition::where('typesyarat','2')->first();
			?>
				<p style="font-size: .15em; line-height: 1.5em; font-weight: 400;">{!!  $tmp->deskripsi !!}</p>
				<p style="font-size: .7em; line-height: 1.5em; font-weight: 400; color: red;"><input type="checkbox" id="setujuBrw"> Saya Menyetujui Syarat dan Ketentuan yang Berlaku</p>
		
			</div> 
		    <div class="modal-footer">
				<button type="button" name="submit" value="submit" class="btn btn-sm btn-default" id="btnStjBrw" onclick="readterm2()" disabled>Saya Setuju</button>
			</div>
        </div> 
    </div> 
</div> 
<script>
	$('#setujuBrw').bind('click', function() {
        if($(this).is(":checked")) {
			$('#btnStjBrw').removeAttr('disabled');
			$('#btnStjBrw').removeClass('btn-default').addClass('btn-success');
        } else {
			$('#btnStjBrw').attr("disabled", true);
			$('#btnStjBrw').removeClass('btn-success').addClass('btn-default');
        }
    });
	
</script>
{{-- end modal Term Condition --}}