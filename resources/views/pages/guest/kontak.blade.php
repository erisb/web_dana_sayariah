
@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection

@section('style')
<style>
    .mapouter{
        text-align:right;
        /* height:500px; */
        width:100%;
        }
    .gmap_canvas {
        overflow:hidden;
        background:none!important;
        height:100%;
        width:100%;
        }
</style>

@endsection

@section('body')
<!-- hero us start -->
<div class="about-us content-area-2 bg-green-soft banner-style-one parallax" data-speed-x="30" data-speed-y="40">
    <!-- <img src="img/wave-static-02.svg" class="w-100 position-absolute ts-bottom__0"> -->
<div>

    <div id="parallax-container" class="container pt-5 pb-5 banner-style-two" >
        <div class="row parallax" data-speed-x="10" data-speed-y="10">
            <div class="col-lg-7 col-xs-12 align-self-center pt-5 " >
            
                <div class="about-texts" >
                    <h2 class="wow fadeInLeft delay-03s">
                        <p style="font-weight: 500; font-size: .9em; line-height: 1em; display: block;" > @lang('menu.tentang_3') </p>                        
                    </h2>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-3 wow fadeInLeft delay-09s pt-3">@lang('menu.tentang_3_det')  <br></p>                                                           
                    
                </div>
                <div class="row">
                    <div class="col-6">
                    <!-- <a href="#" data-toggle="modal" data-target="#registerModal" class="blog-slider__button parallax" data-speed-x="10" data-speed-y="10">Jadi Penulis</a> -->
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 pt-5 ">
            
            <!-- <canvas></canvas> -->
            <div id="parallax-container">
            <!-- <img class="start-png-home parallax" src="/img/search-man.png"  alt="" data-speed-x="60" data-speed-y="44">  -->
            <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/eiubt79exTI?start=9" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                <div class="hero-slide lazy pt-2 wow fadeInRight delay-03s">
                    <div>
                        <div class="image parallax" data-speed-x="20" data-speed-y="28">                           
                                <img src="/img/ojk-mui.png"/>                                                
                        </div>
                    </div>                                     
                </div>
            </div>
            </div>
            
        </div>
    </div>
</div>
<div>
<!-- hero us start -->


<!-- contact content start -->
<div class="contact-2 content-area-7">
    <div class="container wow fadeInUp delay-04s">
        <div class="main-title" >
            <h1>@lang('kontak.dua')</h1>
        </div>

        <div class="contact-info" >
            <div class="row">
                <div class="col-md-4 col-sm-6 contact-info">
                    <i class="fa fa-map-marker"></i>
                    <p>@lang('kontak.tiga')</p>
                    <strong>
                        District 8, Prosperity Tower Lantai 12 Unit J,<br>
                        JL. Jendral Sudirman Kav. 52-53,<br>
                        Kelurahan Senayan, Kecamatan Kebayoran Baru,<br>
                        Jakarta Selatan 12190<br>
                    </strong>
                </div>
                <div class="col-md-4 col-sm-6 contact-info">
                    <i class="fa fa-phone"></i>
                    <p>@lang('kontak.empat')</p>
                    <strong>
                        <p>Phone: +62 (21) 508-58821</p>
                        <!--
                        Phone: +62 (21) 521 0306 <br>
                        Phone: +62 (21) 521 0142 <br>
                        -->
                        WA: +62 822 5000 5050 <br>
                        WA: +62 812 201 6060 <br>
                        WA: +62 815 1001 7070
                    </strong>
                </div>
                <div class="col-md-4 col-sm-6 contact-info">
                    <i class="fa fa-envelope"></i>
                    <p>@lang('kontak.lima')</p>
                    <strong>cso@danasyariah.id</strong>
                </div>
                <!-- <div class="col-md-3 col-sm-6 contact-info">
                    <i class="fa fa-fax"></i>
                    <p>Fax</p>
                    <strong>+55 417 634 7X71</strong>
                </div> -->
            </div>
        </div>

        <form action="{{route('guest.message')}}" method="POST">
        {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group name">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>

                    <div class="form-group email">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group number">
                        <input type="text" name="phone" class="form-control" placeholder="Number" required>
                    </div>
                    <div class="form-group subject">
                        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                    </div>
                    
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group message">
                        <textarea class="form-control" name="message" placeholder="Write message" required></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <br>
                    <div class="send-btn text-center">
                        <button type="submit" class="btn btn-color btn-md">Send Message</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- contact content end -->
<!-- Google map start -->
<div class="section wow fadeInUp delay-04s" >
    <div class="mapouter">
        <div class="gmap_canvas">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1983.138927685207!2d106.8063356!3d-6.227049999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4055c155553%3A0x28d147e6cf574c9f!2sPT%20Dana%20Syariah%20Indonesia%20%3A%20Platform%20Investasi%20Syariah!5e0!3m2!1sid!2sid!4v1574920668624!5m2!1sid!2sid" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                <a href="https://www.maps-erstellen.de"></a>
        </div>
        
    </div>
</div>
<!-- Google map end -->
@endsection
@section('script')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000
    });
</script>
@endsection