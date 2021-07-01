@extends('layouts.user.sidebar')

@section('title', 'Ubah Kata Sandi')

@section('content')
<div class="row">
    @if (session('error'))
    <div class="alert alert-danger col-sm-12">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success col-sm-12">
        {{ session('success') }}
    </div>
    @endif
   
</div>
 
<div class="row">
    <div class="col-sm-12 col-lg-12 ">
        <form method="POST" action="{{route('updatePassword')}}" enctype="multipart/form-data">
            @csrf
            <h3><b>Ubah Kata Sandi</b></h3>
            <hr>
            <fieldset>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="username" class="font-weight-bold">Kata Sandi Baru</label>
                        <input type="password" id="NEW_PASSWORD" name="password" class="form-control"  placeholder="Kata Sandi Baru">
                    </div>
                    <div>
						<span id="SPAN_NEW_PASSWORD" style="color:red; font-size:11px"></span>
					</div>
                </div><br/>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <label for="nama" class="font-weight-bold">Konfirmasi Kata Sandi</label>
                        <input type="password" id="NEW_PASSWORD_CONFIRMATION" name="NEW_PASSWORD_CONFIRMATION" class="form-control allowCharacter" placeholder="Konfirmasi Kata Sandi" onclick="cek_confirm()" required>
                        <span id="error_confirm_password" style="color:red;font-size:11px;margin-left:15px"></span>
                    </div>
                    <div>
						<span id="SPAN_NEW_PASSWORD_CONFIRMATION" style="color:red; font-size:11px"></span>
					</div>
                </div>
            </fieldset>
            <div class="float-right">
                <button type="submit" class="btn btn-success" id="submit">Simpan</button>
            </div>
            <span id="8char" class="fa fa-times" style="color:#FF0004;"></span>&nbsp; Minimal 8 Karakter
            <input type="hidden" id = "char">
            <span id="ucase" class="fa fa-times" style="color:#FF0004;"></span>&nbsp; Huruf Besar
            <input type="hidden" id = "upper">
            <span id="lcase" class="fa fa-times" style="color:#FF0004;"></span>&nbsp; Huruf Kecil
            <input type="hidden" id = "lower">
            <span id="num" class="fa fa-times" style="color:#FF0004;"></span>&nbsp; Karakter Angka
            <input type="hidden" id = "int">
        </form>
    </div>
</div>

<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/jquery_step/jquery.steps.js"></script>
<script src="/js/jquery_step/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-show-password/1.1.2/bootstrap-show-password.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("input[type=password]").keyup(function(){
            var ucase = new RegExp("[A-Z]+");
            var lcase = new RegExp("[a-z]+");
            var num = new RegExp("[0-9]+");

            var thru = false;
            //console.log($("#NEW_PASSWORD").val());
            $('.allowCharacter').on('input', function (event) { 
                this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
            });

            if($("#NEW_PASSWORD").val().length >= 8){
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
            
            if(ucase.test($("#NEW_PASSWORD").val())){
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
            
            if(lcase.test($("#NEW_PASSWORD").val())){
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
             
            if(num.test($("#NEW_PASSWORD").val())){
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
                if($("#NEW_PASSWORD").val() == $("#NEW_PASSWORD_CONFIRMATION").val() && $("#int").val()== 1 && $("#lower").val()== 1 && $("#upper").val()== 1 && $("#char").val()== 1)
                {    
                    document.getElementById("submit").disabled = false; 
                }
                else{
                    
                    document.getElementById("submit").disabled = true; 
                }    
            }
            else
            {
                document.getElementById("submit").disabled = true;      
            }
            

        });
    });

    function cek_confirm()
    {
        if($("#NEW_PASSWORD_CONFIRMATION").val() != $("#NEW_PASSWORD").val())
        {
            $('#error_confirm_password').html('<b id="confirm_password_error">Konfirmasi kata sandi tidak sesuai dengan kata sandi baru.</b>');
        }
        else{
            $('#confirm_password_error').hide();
        }

    }
    
</script>
@endsection
