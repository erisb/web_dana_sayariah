<style type="text/css">
.serviceBox{
    color: #303030;
    background-color: #fff;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;;
    text-align: center;
    padding: 25px 10px;
    margin: 50px 0 50px;
    border-radius: 15px;
}
.bg-dsi-gradient{
    background: rgb(231,255,238);
background: -moz-linear-gradient(176deg, rgba(231, 255, 238, 0.3) 0%, rgba(255,255,255,1) 100%);
background: -webkit-linear-gradient(176deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
background: linear-gradient(176deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e7ffee",endColorstr="#ffffff",GradientType=1);
}
.bg-dsi-gradient-flip{
    background: rgb(231,255,238);
background: -moz-linear-gradient(0deg, rgba(231, 255, 238, 0.3) 0%, rgba(255,255,255,1) 100%);
background: -webkit-linear-gradient(0deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
background: linear-gradient(0deg, rgba(231,255,238,0.3) 0%, rgba(255,255,255,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e7ffee",endColorstr="#ffffff",GradientType=1);
}
.serviceBox .service-icon{
    color: #fff;
    background: linear-gradient(to bottom,#0faf3f,#FAC93C);
    font-size: 40px;
    line-height: 100px;
    height: 100px;
    width: 100px;
    margin: -100px auto 30px;
    border-radius: 50%;
    display: block;
    transition: all 0.3s ease 0s;
}
.serviceBox:hover .service-icon{
    font-size: 60px;
    box-shadow: 0 0 20px -5px #000;
}
.serviceBox:hover{
    box-shadow: 0 0 20px -5px #000;
}
.serviceBox .title{
    color: #0faf3f;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    margin: 0 0 10px;
}
.serviceBox .description{
    font-size: 20px;
    text-align: center;
    font-weight: bold;
    /*text-transform: uppercase;*/
    margin: 0 0 20px;
}
.serviceBox .note{
    font-size: 9px;
    text-align: center;
    font-weight: 300;
    text-transform: uppercase;
}
@media only screen and (max-width:990px){
    .serviceBox{ margin: 110px 0 0; }
}

</style>

<!-- intro section start -->
<div class="intro-section " style="background-image: linear-gradient(rgba(19, 122, 105, 1), rgba(6, 66, 48, 1)); padding: 100px 0 100px 0px;">
    <div class="container">
        <div class="row ">            
            <br>
            <div class="col-12 text-center"  >               
               <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <h2 style="color: white; font-weight: 300;">@lang('footer.question') </h2>
                        <p class="left pb-3" style=" color: white ; font-weight: 300, font-size: 2rem">@lang('footer.question_desc')</p>
                        <a href="https://goo.gl/maps/jpC22XP5R2WkdtW99" rel="noreferrer" class="blog-slider__button mb-3"  ><i class="fas fa-map pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px" target="_blank"></i> PETUNJUK ARAH</a>
                        <a href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Dana%20Syariah,%20Saya%20ingin%20Berkunjung%20ke%20kantor." rel="noreferrer" class="blog-slider__button ml-lg-4"> <i class="fab fa-whatsapp pt-1 pr-1" style="font-size: 1.2rem; margin-bottom: 0px"></i> WhatsApp</a>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- intro section end -->
<!-- partner start -->
<!--
<div class="container-flui" style="background-color: #F8F9FA; color: white; padding: 60px 0 0;">
    <div class="container partner  " >
        <div class="main-title">
            <h6>Diliput Oleh </h6>
        </div>
        <div class="row">
            <div class="multi-carousel" data-items="1,3,5,6" data-slide="1" id="multiCarousel"  data-interval="1000">
                <div class="multi-carousel-inner" align="center">
                                    <!-- TV -->
<!--                
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">TVRI</p>
                            <img src="/partners/tvri.png" alt="brand">
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">TV One</p>
                            <img src="/partners/TvOne_logo_(2010).png" alt="brand">
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">TV Mu</p>
                            <img src="/partners/TVMu_logo.svg.png" alt="brand">
                        </div>
                    </div>
                                    <!-- Radio -->
<!--                    <div class="item">
                        <div class="pad15">
                            <p class="lead">Smart FM</p>
                            <img src="/partners/smartfm.png" alt="brand">
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">Dakta FM</p>
                            <img src="/partners/dakta.jpg" alt="brand">
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">Ras FM</p>
                            <img src="/partners/ras-fm.png" alt="brand">
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">Camajaya FM</p>
                            <img src="/partners/camajaya.png" alt="brand">
                        </div>
                    </div>
                    <!-- News -->
<!--                    <div class="item">
                        <div class="pad15">
                            <p class="lead">Tabloid Kontan</p>
                            <img src="/partners/kontan.png" alt="brand">
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">Republika</p>
                            <img src="/partners/republika.png" alt="brand">
                        </div>
                    </div>
                    <div class="item">
                        <div class="pad15">
                            <p class="lead">Antara News</p>
                            <img src="/partners/antaranews.png" alt="brand">
                        </div>
                    </div>
                    
                
                </div>
                <a class="multi-carousel-indicator leftLst" aria-hidden="true">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="multi-carousel-indicator rightLst" aria-hidden="true">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
        
    </div>
</div>-->

<div class="container pt-5 pb-5" align="center" style="width: 65%;">
    <div class="container-slick">
        <div class="main-title">
            <h6>Televisi</h6>
        </div>
        <div class="row delapan-keu nggulan lazy pt-2">
            <div class="col-lg-4 pb-5">            
                <div class="team-wrapper">
                    <img src="/partners/tvri.png" alt="brand" height="40">                
                </div>
            </div>

            <div class="col-lg-4 pb-5">           
                <div class="team-wrapper">
                    <img src="/partners/TvOne_logo_(2010).png" alt="brand" height="40">               
                </div>
            </div>

            <div class="col-lg-4 pb-5">           
                <div class="team-wrapper">
                    <img src="/partners/TVMu_logo.svg.png" alt="brand" height="40">               
                </div>
            </div>
        </div>
        <div class="main-title">
            <h6>Radio</h6>
        </div>
        <div class="row delapan-keu nggulan lazy pt-2">
            <div class="col-lg-3 pb-5">
                <div class="team-wrapper">
                    <img src="/partners/smartfm.png" alt="brand" height="40">
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                    <img src="/partners/dakta.jpg" alt="brand" height="40">             
                </div>
            </div>

            <div class="col-lg-3 pb-5">           
                <div class="team-wrapper">
                    <img src="/partners/ras-fm.png" alt="brand" height="40">            
                </div>
            </div>

            <div class="col-lg-3 pb-5">            
                <div class="team-wrapper">
                    <img src="/partners/camajaya.png" alt="brand" height="40">            
                </div>
            </div>
        </div>
        <div class="main-title">
            <h6>Media Online</h6>
        </div>
        <div class="row delapan-keu nggulan lazy pt-2 ">
            <!-- Start Source Code Old
            <div class="col-lg-4 pb-5">           
                <div class="team-wrapper">
                    <img src="/partners/kontan.png" alt="brand" height="40">                
                </div>
            </div>
            <div class="col-lg-4 pb-5">           
                <div class="team-wrapper">
                    <img src="/partners/republika.png" alt="brand" height="40">                
                </div>
            </div>
            <div class="col-lg-4 pb-5">           
                <div class="team-wrapper">
                    <img src="/partners/antaranews.png" alt="brand" height="40">                
                </div>
            </div>
            End Source Code Old -->
            <?php
                $media= DB::table('cms')->where('type',2)->get();
            ?>
            @foreach ($media as $media)
            <div class="col-lg-4 pb-5">           
                <div class="team-wrapper">
                    <img src="{{asset('/storage')}}/{{$media->gambar}}" alt="brand" height="40">                
                </div>
            </div>
            @endforeach
        </div>                   
    </div>
</div>
<!-- Blog start -->

<div class="blog pt-5 pb-5">
    <div class="container">
        <div class="mx-auto text-center pb-2">
            <p>@lang('footer.awasi') :</p>
        </div>
        <div class="row justify-content-center ">
           
                <img class="lozad" data-src="/img/ojkKominfo.png" alt="blog" height="40" >                                   
           
        </div>
    </div>
</div>
<!-- Blog end -->

<div class="footer disclaimer-section" >
			<div class="container">
				<div class="ojk-footer-disclaimer">
                
					<p class="title" style="font-weight: 600">@lang('footer.perhatian') :</p>
					<div class="row">
                        <!-- Start Source Code Old
						<div class="col-md-6 col-xs-12">
							<div class="disclaimer-text wow fadeInUp delay-06s">
								<ol>
									<li>@lang('footer.disclaimer_1')</li>
                	                <li>@lang('footer.disclaimer_2')</li>
                	                <li>@lang('footer.disclaimer_3')</li>
                	                <li>@lang('footer.disclaimer_4')</li>
                	                <li>@lang('footer.disclaimer_5')</li>
                	                <li>@lang('footer.disclaimer_6')</li>
									<li>@lang('footer.disclaimer_7')</li>
                                    <li>@lang('footer.disclaimer_8')</li>
								</ol>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="disclaimer-text wow fadeInUp delay-08s">
								<ol start="9">
									<li>@lang('footer.disclaimer_9')</li>
								</ol>
							</div>
							<p class="footer-disc-ojk wow fadeInUp delay-11s">@lang('footer.disclaimer_10')</p>
                            <p class="footer-disc-ojk wow fadeInUp delay-11s">@lang('footer.disclaimer_11')</p>
						</div>
                        End Source Code Old -->
                        <?php
                            $perjanjian= DB::table('cms')->where('type',4)->get();
                        ?>
                        <!-- <div class="col-md-12 col-xs-12"> -->
                            <div class="col-md-12" style="column-count:2">
                                <div class="disclaimer-text">
                                    <!-- <ol> -->
                                        @foreach ($perjanjian as $perjanjian)
                                            {!!$perjanjian->content!!}
                                        @endforeach
                                    <!-- </ol>    -->
                                </div>
                            </div>
                        <!-- </div> -->
                        <!-- <div class="col-md-12 col-xs-12">
                            <div class="disclaimer-text wow fadeInUp delay-08s">
                                <p class="footer-disc-ojk wow fadeInUp delay-11s">@lang('footer.disclaimer_10')</p>
                                <p class="footer-disc-ojk wow fadeInUp delay-11s">@lang('footer.disclaimer_11')</p>
                            </div>
                        </div> -->
					</div>
				</div>
            </div>
            
            <div class="container-fluid mt-5" style="background-color: #F8F9FA; color: white; padding: 30px 20px 0px 30px;">                
                <div class="row">
                    <div class="container" >
                        <div class="row no-gutters">
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12" style="background-color: #F8F9FA;">
                                <h6 style="color: #202225; display: block; float: left;" class="pt-1 pr-2"> @lang('footer.temukan_kami') : </h6>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12"> 
                                <a rel="noreferrer" style="color: #202225; font-size: 1rem;" href="https://www.instagram.com/danasyariah/" class="instagram pt-4"><i class="fab fa-instagram" style="font-size: 1.3rem; color: #202225; "></i> Instagram</a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12"> 
                                <a rel="noreferrer" style="color: #202225; font-size: 1rem;" href="https://www.youtube.com/channel/UCLPxmUGo-cK2ai9LLJeO--A/videos" class="google"><i class="fab fa-youtube fa-2x pr-2" style="font-size: 1.3rem; color: #202225; "></i> Youtube</a>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12 col-xs-12">    
                                <a rel="noreferrer" style="color: #202225; font-size: 1rem;" href="https://www.facebook.com/danasyariahid/" class="facebook pt-4"><i class="fab fa-facebook " style="font-size: 1.3rem; color: #202225; "></i> Facebook</a>
                            </div>
                        </div>
                        <hr class="mt-4" style="border: 2px solid #175D43; margin-top: 0; margin-bottom: 0;">
                    </div>
                </div>
            </div>
            <?php
                $address= DB::table('cms')->where('type',3)->get();
            ?> 
            @foreach ($address as $address)   
            <footer class="footer " style="background-color: #F8F9FA; color: white; padding: 60px 0 0;">
                <div class="container footer-inner">
                    <div class="row">                    
                        <div class="col-lg-3 col-sm-6 col-xs-12">
                            <div class="footer-item ">
                                <!-- <h4>Office</h4> -->
                                <ul class="contact-info">
                                    <li>
                                        <!-- <b>PT. DANA SYARIAH INDONESIA</b> -->
                                        <b>{{$address->nama}}</b>
                                    </li>
                                    <li>
                                        <!-- <span style=" font-weight: 600;"> Dana Syariah </span> adalah Website/Aplikasi untuk menggalang dana dan Pendanaan proyek properti. <br> -->
                                        <span style=" font-weight: 600;"> Dana Syariah </span> {{$address->content}} <br>
                                    </li>
                                    <li>
                                        <!-- <a href="https://www.google.com/maps/d/embed?mid=14ngA9qPXvgQgjX1iRwOnWAcqiFoRZeBH">
                                            <span style="font-weight: 600;">
                                            District 8, Prosperity Tower <br>Lantai 12 Unit J,</span><br>
                                            JL. Jendral Sudirman Kav. 52-53,<br>
                                            Kelurahan   Senayan,<br>Kecamatan Kebayoran Baru,<br>
                                            Jakarta Selatan 12190
                                        </a> <br>. -->
                                        <a href="https://goo.gl/maps/rVBQCXRzuhdq3SsZ8">
                                            <span style="font-weight: 600;">
                                            {{$address->alamat}}
                                        </a> <br>
                                    </li> 
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-xs-12">
                            <div class="footer-item">
                                <h4></h4>
                                <ul class="contact-info">
                                    <li>
                                        <!-- Email: <a href="mailto:cso@danasyariah.id">cso@danasyariah.id</a> -->
                                        Email: <a href="mailto:cso@danasyariah.id">{{$address->email}}</a>
                                    </li>   
                                    <li>
                                        <!-- <p>Phone: <a href="tel: +62 (21) 508 58821"> +62 (21) 508-58821</a></p> -->
                                        <p>Phone: <a href="tel: +62 (21) 508 58821">{{$address->phone}}</a></p>
                                        <!--
                                        Phone: <a href="tel: +62 (21) 521 0306"> +62 (21) 521 0306</a>
                                        <br>
                                        Phone: <a href="tel:+62 (21) 521 0142">+62 (21) 521 0142</a>
                                        <br>
                                        -->
                                        <!-- WA: <a rel="noreferrer" href="https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Dana%20Syariah."> +62 822 5000 5050</a>
                                        <br>
                                        WA: <a rel="noreferrer" href="https://wa.me/628122016060?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Dana%20Syariah."> +62 812 &nbsp;201 &nbsp;6060</a>
                                        <br>
                                        WA: <a rel="noreferrer" href="https://wa.me/6281510017070?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Dana%20Syariah."> +62 815 &nbsp;1001 &nbsp;7070</a> -->
                                        <?php
                                            $address= DB::table('cms')->where('type',3)->get();
                                            $whatsapp = $address[0]->handphone;
                                            $new_whatsapp = explode('|', $whatsapp );

                                            $i = count($new_whatsapp);
                                            for($n=1;$n<$i;$n++)
                                            {
                                                echo "WA: <a rel='noreferrer' href='https://wa.me/6282250005050?text=Assalamualaikum,%20Saya%20tertarik%20pada%20Dana%20Syariah.'>$new_whatsapp[$n]</a><br>";
                                            }
                                        ?> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-lg-3 col-sm-8 col-xs-12">
                            <div class="footer-item clearfix">
                                <h4></h4>
                                <ul class="links">
                                    <!--li>
                                        <a href="{{ url('perjanjian') }}" target="_blank"><i class="fa fa-angle-right"></i>Syarat & Ketentuan</a>
                                    </li>
                                    <li>
                                        {{-- <a href="/privacypolicy"><i class="fa fa-angle-right"></i>Kebijakan Privacy</a> --}}
                                        <a href="{{ url('privasi') }}" target="_blank"><i class="fa fa-angle-right"></i>Kebijakan Privacy</a> 
                                        
                                    </li>
                                    <li>
                                        {{-- <a href="/faq"><i class="fa fa-angle-right"></i>Kebijakan Cookie</a> --}}
                                        <a href="{{ url('cookie') }}" target="_blank"><i class="fa fa-angle-right"></i>Kebijakan Cookie</a>
                                    </li-->
                                    <?php
                                        $footer= DB::table('cms')->where('type',6)
                                                                 ->where('publish',1)
                                                                 ->get();
                                    ?> 
                                    @foreach ($footer as $footer)  
                                    <li><a href="{{asset('/storage').'/'.$footer->file }}" target="_blank"><i class="fa fa-angle-right"></i>{{$footer->title}}</a></li>
                                    @endforeach
                                </ul>
                                
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-8 col-xs-12 pb-5 mb-5">
                            <div class="footer-item clearfix">
                                <h4></h4>
                                <!-- <img class="col-7 pb-3" data-src="/img/iso27001.png" alt=""> -->
                                <img class="col-12 lozad" data-src="/img/logofintech.png" alt="">
                                <img class="col-12 pt-4 lozad" data-src="/img/logo-afpi.png" alt="">
                            </div>
                        </div>
                    </div>
                    <hr style="border: 1px solid #dadce0; margin-top: 0; margin-bottom: 0;">
                </div>
            </footer>
            <div class="row" style="margin: 0px;">                
                <div class="col-xl-12 text-center" style="background-color: #F8F9FA; color: #202225;">
                    <div class="container">
                        <img class="mt-3 pr-5 lozad" data-src="/img/logo-dark.png" alt="logo dana syariah" height="25" style="float:left;">
                        <p class="copy" style="color: #535353; text-align: left !important; font-weight: 500; ">&copy;  <?php echo date("Y"); ?> <a href="http://danasyariah.id/" target="_blank">PT. Dana Syariah Indonesia</a></p>
                       
                    </div>
                </div>
            </div>            
        </div>
