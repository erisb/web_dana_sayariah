@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection

@section('style')
<style>
    .fade_item {
        padding: 50px 0px;
        border-top: solid 2px #0faf3f;
        border-bottom: solid 2px #0faf3f;
    }
    p {
        margin: 10px 25px;
    }
    .custom_bg-color {
        background: whitesmoke;
    }
</style>
@endsection

@section('body')
<!-- hero us start -->
<div class="about-us content-area-2 bg-green-soft banner-style-one parallax" data-speed-x="30" data-speed-y="40">
<div>

    <div id="parallax-container" class="container pt-5 pb-3 banner-style-two" >
        <div class="row parallax" data-speed-x="10" data-speed-y="10">
            <div class="col-lg-12 col-xs-12 align-self-center pt-5 " >
            
                <div class="about-texts text-center" >
                    <h2 class="wow fadeIn delay-03s">
                        <p style="font-weight: 500; font-size: .9em; line-height: 1em; display: block;" >@lang('tentang_kami.satu') </p>                        
                    </h2>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-3 wow fadeIn delay-09s pt-3">@lang('tentang_kami.satu_a') <br></p>                                                           
                    
                </div>
            </div>
           
            
        </div>
    </div>
</div>
<div>
<!-- hero us start -->
<!-- end banner header -->
<!-- content start -->
<!-- selector start -->
<div class="about-us content-area-8 " >
    <div class="container wow fadeInUp delay-04s" >
        <div class="row">
            <div class="col-lg-5">
                <div class="properties-service-v">
                    <img src="/guest/khazanah/why.png" alt="admin" class="img-fluid" >
                </div>
            </div>
            <div class="col-lg-7 align-self-center">
                <div class="about-text more-info">
                    <h3>@lang('tentang_kami.dua')</h3>
                    <div id="faq" class="faq-accordion">
                        <div class="card m-b-0">
                            <div class="card-header">
                            
                                <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq" href="#collapse1">
                                    <i class="fas fa-chevron-down"></i> 
                                    @lang('tentang_kami.tiga')
                                </a>
                            </div>
                            <div id="collapse1" class="card-block collapse">
                                <p>@lang('tentang_kami.empat')</p>
                            </div>

                            <div class="card-header">
                                <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq" href="#collapse2">
                                    <i class="fas fa-chevron-down"></i>
                                    @lang('tentang_kami.lima')
                                </a>
                            </div>
                            <div id="collapse2" class="card-block collapse">
                                <p>@lang('tentang_kami.enam')</p>
                            </div>

                            <div class="card-header">
                                <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq" href="#collapse3">
                                    <i class="fas fa-chevron-down"></i>
                                    @lang('tentang_kami.tujuh')
                                </a>
                            </div>
                            <div id="collapse3" class="card-block collapse">
                                <p>@lang('tentang_kami.delapan')</p>
                                <p>@lang('tentang_kami.sembilan')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>
<!-- selector end -->
<!-- visi misi start -->
<div class="blog-section content-area-2">
    <div class="container">
        <div class="row wow fadeInUp delay-04s" >
                <div class="col-12">
                  <div class="row">
                    <div class="detail col-12">
                        <h2 class="text-center heading">
                            @lang('tentang_kami.sepuluh')
                        </h2>
                        <hr>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                        <div class="col-12 col-sm-6 text-center">
                            <br><br>
                            <p>@lang('tentang_kami.duabelas')</p>
                        </div>
                        <div class="col-12 col-sm-6 text-center">
                            
                          
                            <br><br>
                            <p>@lang('tentang_kami.empatbelas')</p>
                        </div>
                  </div>
                </div>


        </div>
    </div>
</div>
<!-- visi misi end -->
<!-- Agent start -->
<div class=" pt-5 ">
    <div class="container pt-5">
        <div class="main-title">
            <h1>@lang('tentang_kami.limabelas')</h1>
            <p style="font-size: 18px" class="pb-3">@lang('tentang_kami.limabelas_a')</p>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft delay-04s">
                <div class="agent-2">
                    <div class="agent-photo">
                        <a href="#">
                            <img src="/img/timdsi/picture3.png" alt="avatar-5" class="img-fluid mx-auto d-block pt-3">
                        </a>
                    </div>
                    <div class="agent-details">
                        <h5 class="text-center">TAUFIQ ALJUFRI</h5>
                        <p class="text-center">Founder & President Director</p>
                        <p class="text-center">@lang('tentang_kami.enambelas')</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft delay-04s">
                <div class="agent-2">
                    <div class="agent-photo">
                        <a href="#">
                            <img src="/img/timdsi/picture4.png" alt="avatar-6" class="img-fluid mx-auto d-block pt-3">
                        </a>
                    </div>
                    <div class="agent-details">
                        <h5><a href="#">ARIE R. LESMANA</a></h5>
                        <p>Co-Founder and Commissioner</p>                       
                        <p>@lang('tentang_kami.tujuhbelas')</p>
                    </div>
                </div>
            </div>
            <div class="ccol-xl-6 col-lg-6 col-md-6 col-sm-12 wow fadeInRight delay-04s">
                <div class="agent-2">
                    <div class="agent-photo">
                        <a href="#">
                            <img src="/img/timdsi/picture2.png" alt="avatar-7" class="img-fluid mx-auto d-block pt-3">
                        </a>
                    </div>
                    <div class="agent-details">
                        <h5><a href="#">ATIS SUTISNA</a></h5>
                        <p>Director</p>
                        <p> @lang('tentang_kami.delapanbelas')</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 wow fadeInRight delay-04s">
                <div class="agent-2 ">
                    <div class="agent-photo ">
                        <a href="#">
                            <img src="/img/timdsi/picture1.png" alt="avatar-11" class="img-fluid mx-auto d-block pt-3">
                        </a>
                    </div>
                    <div class="agent-details">
                        <h5><a href="#">M YUSUF HELMI</a></h5>
                        <p>Dewan Pengawas Syariah</p>
                        <p>@lang('tentang_kami.sembilanbelas')</p>
          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div >
<!-- Agent end -->
<!-- team start -->
<!-- team end -->

<style>
.width-achive{
    width: 60%;
    margin-top: 0%;
    margin-bottom: 0%;
}
#custom_carousel .item {

color:#000;
background-color:#eee;
padding:20px 0;
}
#custom_carousel .controls{
overflow-x: auto;
overflow-y: hidden;
padding:0;
margin:0;
white-space: nowrap;
text-align: center;
position: relative;
background:#ddd
}
#custom_carousel .controls li {
display: table-cell;
width: 25%;
max-width:90%
}
#custom_carousel .controls li.active {
background-color:#eee;
border-top:3px solid orange;
}
#custom_carousel .controls a small {
overflow:hidden;
display:block;
font-size:10px;
margin-top:5px;
font-weight:bold
}
</style>
<!-- <div class="container-fluid width-achive">
    <div id="custom_carousel" class="carousel slide" data-ride="carousel" >
            <header class="text-left m-0 p-0">
                <h1 style="color: #0faf3f;">Penghargaan</h1>
            </header>
        
        <div class="carousel-inner">
            @foreach ($proyeks as $item)
            
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <div class="container-fluid p-3">
                    <div class="row p-3 bg-white rounded shadow-sm">
                            <div class="col-12 col-sm-6 justify-content-center">
                            <img class="blog-theme img-fluid col-12" src="{{asset('/storage')}}/{{$item->gambar}}" alt="{{$item->title}}">
                            </div>
                            
                            <div class="detail col-12 col-sm-6 p-3">
                                <h2 class="text-left heading">
                                    {{$item->title}}                             
                                <hr>
                                </h2>
                                <p class="text-left">{!!$item->keterangan!!}</p>
                            </div>
                            <hr>
                    </div>
                </div>            
            </div>     
            @endforeach
            
        
        <div class="controls carousel slide">
            <ul class="nav">
                @foreach ($proyeks as $item)
                    <li data-target="#custom_carousel" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"><a href="#"><img src="{{asset('/storage')}}/{{$item->gambar}}" style="max-width:100px; height:auto;"><small>{{$item->title}}</small></a></li>  
                @endforeach
            </ul>
        </div>
    </div>
    
</div> -->
</div>
<!-- content end -->
@endsection
@section('script')
<script>
$(document).ready(function(ev){
    $('#custom_carousel').on('slide.bs.carousel', function (evt) {
      $('#custom_carousel .controls li.active').removeClass('active');
      $('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
    })
});
</script>
@endsection
