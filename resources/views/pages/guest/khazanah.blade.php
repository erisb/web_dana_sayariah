
@extends('layouts.guest.master')

@section('style')
<style>
    .fade_item {  
        padding: 50px 0px;
        border-top: solid 2px #0faf3f;
    }
    ol {
        padding-right: 20px;   
    }
    
    .modal-content span {
        color: #0faf3f;
    }
    .green_line {
        border-top: solid 1px #0faf3f !important;
        flex: 0 !important;
    }
</style>
@endsection

@section('navbar')
@include('includes.navbar2')
@endsection

@section('body')
<!-- hero us start -->
<div class="about-us content-area-2 bg-green-soft banner-style-one parallax" data-speed-x="30" data-speed-y="40">
    <!-- <img src="img/wave-static-02.svg" class="w-100 position-absolute ts-bottom__0"> -->
<div>

    <div id="parallax-container" class="container pt-5  banner-style-two" >
        <div class="row parallax pt-3" data-speed-x="10" data-speed-y="10">
            <div class="col-lg-7 col-xs-12 align-self-center pt-5 " >
            
                <div class="about-texts" >
                    <h2 class="wow fadeInLeft delay-03s">
                        <p style="font-weight: 500; font-size: .9em; line-height: 1em; display: block;" > Khazanah </p>                        
                    </h2>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-0 wow fadeInLeft delay-09s pt-0">@lang('khazanah.satu') <br></p>                                                           
                    
                </div>
            </div>
            
            
        </div>
    </div>
</div>
<div>
<!-- hero us start -->

@include('includes.khazanah_modal')
<!-- Blog section start -->
<div class="blog-section content-area-2">
    <div class="container " >
        <!--
        <div class="row no-gutters wow fadeInRight delay-04s my-5  bg-white rounded shadow-sm">
            <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                <img class="blog-theme img-fluid" src="/guest/khazanah/khazanah.jpg"  alt="blog-3">
            </div>
            
            <div class="detail col-lg-6 col-sm-12 p-5">
                <h2 class="text-left heading">
                <br>
                    @lang('khazanah.dua')
                </h2>
                <hr>
                <p class="text-left">@lang('khazanah.tiga')</p>
                
                <a href="#" >@lang('khazanah.enam')</a> 
                <a href="#" data-toggle="modal" data-target="#investorModal" class="text-success">@lang('language.selengkapnya')  &gt;</a>
            </div>
        </div>
        <div class="row wow fadeInLeft delay-04s my-5 p-3 bg-white rounded shadow-sm">
            <div class="detail col-lg-6 col-sm-12 p-5">
                <h2 class="text-right heading">
                <br>
                    @lang('khazanah.empat')
                </h2>
                <hr>
                <p class="text-right">@lang('khazanah.lima')</p>
                <button class="btn btn-color float-right" data-toggle="modal" data-target="#crowdFundingModal">@lang('khazanah.enam')</button>
                <a href="#" data-toggle="modal" data-target="#crowdFundingModal" class="text-success float-right">@lang('language.selengkapnya')  &gt;</a>
            </div>
            <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                <img class="blog-theme img-fluid " src="/guest/khazanah/halal.jpg" alt="blog-3">
            </div>
            <hr>
        </div>

        <div class="row wow fadeInRight delay-04s my-5 p-3 bg-white rounded shadow-sm">
                    <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                        <img class="blog-theme img-fluid" src="/guest/khazanah/land.jpg" alt="blog-3">
                    </div>
                    
                    <div class="detail col-lg-6 col-sm-12 p-5">
                        <h2 class="text-left heading">
                        @lang('khazanah.tujuh')
                        </h2>
                        <hr>
                        <p class="text-left">@lang('khazanah.delapan')</p>
                        <button class="btn btn-color float-right" data-toggle="modal" data-target="#murabahahModal">@lang('khazanah.enam')</button>
                        <a href="#" data-toggle="modal" data-target="#murabahahModal" class="text-success float-left">@lang('language.selengkapnya')  &gt;</a>
                    </div>
                    <hr>
        </div>
        
        <div class="row wow fadeInLeft delay-04s my-5 p-3 bg-white rounded shadow-sm">
                    <div class="detail col-lg-6 col-sm-12 p-5">
                        <h2 class="text-right heading">
                        @lang('khazanah.sembilan')
                        </h2>
                        <hr>
                        <p class="text-right">@lang('khazanah.sepuluh')</p>
                        <button class="btn btn-color float-right" data-toggle="modal" data-target="#sarprasModal">@lang('khazanah.enam')</button>
                        <a href="#" data-toggle="modal" data-target="#sarprasModal" class="text-success float-right">@lang('language.selengkapnya')  &gt;</a>
                    </div>
                    <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                        <img class="blog-theme img-fluid " src="/guest/khazanah/sarana.jpg" alt="blog-3">
                    </div>
                    <hr>
        </div>
        <div class="row wow fadeInRight delay-04s my-5 p-3 bg-white rounded shadow-sm">
                    <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                        <img class="blog-theme img-fluid " src="/guest/khazanah/rumah.jpg" alt="blog-3">
                    </div>
                    
                    <div class="detail col-lg-6 col-sm-12 p-5">
                        <h2 class="text-left heading">
                        @lang('khazanah.sebelas')
                        </h2>
                        <hr>
                        <p class="text-left">@lang('khazanah.duabelas')</p>
                        <button class="btn btn-color float-right" data-toggle="modal" data-target="#unitRumahModal">@lang('khazanah.enam')</button>
                         <a href="#" data-toggle="modal" data-target="#unitRumahModal" class="text-success float-left">@lang('language.selengkapnya')  &gt;</a>
                    </div>
                    <hr>
        </div>
        <div class="row wow fadeInLeft delay-04s my-5 p-3 bg-white rounded shadow-sm">
                    <div class="detail col-lg-6 col-sm-12 p-5">
                        <h2 class="text-right heading">
                        @lang('khazanah.tigabelas')
                        </h2>
                        <hr>
                        <p class="text-right">@lang('khazanah.empatbelas')</p>
                        <button href="#" class="btn btn-color float-right" data-toggle="modal" data-target="#jualBeliModal">@lang('khazanah.enam')</button>
                        <a href="#" data-toggle="modal" data-target="#jualBeliModal" class="text-success float-right">@lang('language.selengkapnya')  &gt;</a>
                    </div>
                    <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                        <img class="blog-theme img-fluid" src="/guest/khazanah/jualbeli.jpg" alt="blog-3">
                    </div>
                    <hr>
        </div>
        <div class="row wow fadeInRight delay-04s my-5 p-3 bg-white rounded shadow-sm">
                    <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                        <img class="blog-theme img-fluid" src="/guest/khazanah/proposal.jpg" alt="blog-3">
                    </div>
                    
                    <div class="detail col-lg-6 col-sm-12 p-5">
                        <h2 class="text-left heading">
                        @lang('khazanah.limabelas')
                        </h2>
                        <hr>
                        <p class="text-left">@lang('khazanah.enambelas') cso@danasyariah.id</p>
                        <button class="btn btn-color float-right" data-toggle="modal" data-target="#templateProposalModal">@lang('khazanah.enam')</button>
                        <a href="#" data-toggle="modal" data-target="#templateProposalModal" class="text-success float-left">@lang('language.selengkapnya')  &gt;</a>
                    </div>
                    <hr>
        </div>
        <div class="row wow fadeInLeft delay-04s my-5 p-3 bg-white rounded shadow-sm">
                    <div class="detail col-lg-6 col-sm-12 p-5">
                        <h2 class="text-right heading">
                        @lang('khazanah.tujuhbelas')
                        </h2>
                        <hr>
                        <p class="text-right">Apa dan Bagaimana melakukan Pendanaan secara Halal Melalui Crowd Funding</p>
                        <button class="btn btn-color float-right" data-toggle="modal" data-target="#maisirRibaModal">@lang('khazanah.enam')</button>
                        <a href="#" data-toggle="modal" data-target="#maisirRibaModal" class="text-success float-right">@lang('language.selengkapnya')  &gt;</a>
                    </div>
                    <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                        <img class="blog-theme img-fluid" src="/guest/khazanah/proyektheme.jpg" alt="blog-3">
                    </div>
                    <hr>
        </div>
        <div class="row wow fadeInRight delay-04s my-5 p-3 bg-white rounded shadow-sm">
                    <div class="col-lg-6 col-sm-12 justify-content-center p-5">
                        <img class="blog-theme img-fluid" src="/guest/khazanah/zakatt.jpg" alt="blog-3">
                    </div>
                    
                    <div class="detail col-lg-6 col-sm-12 p-5">
                        <h2 class="text-left heading">
                        @lang('khazanah.delapanbelas')
                        </h2>
                        <hr>
                        <p class="text-left">@lang('khazanah.sembilanbelas')</p>
                        <button href="#" class="btn btn-color float-right" data-toggle="modal" data-target="#zakatModal">@lang('khazanah.enam')</button>
                        <a href="#" data-toggle="modal" data-target="#zakatModal" class="text-success float-left">@lang('language.selengkapnya')  &gt;</a>-->
    <div class="container" >
            @foreach ($data as $item)
            
    <div class="row wow fadeInRight delay-04s my-3 p-3 bg-white rounded shadow-sm">
            <div class="col-12 col-sm-6 justify-content-center">
                <img class="blog-theme img-fluid col-12" src="{{asset('/storage')}}/{{$item->gambar}}" alt="blog-gbr">
            </div>
            <div class="detail col-12 col-sm-6"><br>
                <h2 class="text-left heading">
                    {{$item->title}}
                </h2>
                <hr>
                {{--<p class="text-left" style="white-space: nowrap;text-overflow: ellipsis !important">{!! $item->keterangan !!}</p>--}}
    <button class="btn btn-color float-right" data-toggle="modal" data-target="#investorModal{{$item->id}}">@lang('khazanah.enam')</button>
            </div>
            <hr>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="investorModal{{$item->id}}">
            <div class="modal-dialog modal-xl" style="min-width:80%;">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
    <h4 class="modal-title">{{$item->title}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <img class="img-fluid " style="max-height:250px !important; width:100%" src="{{asset('/storage')}}/{{$item->gambar}}" alt="blog-3">
                            <hr>

                            <p style="margin:15px;" >
                                {!!$item->keterangan!!}
                            </p>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Blog section end -->
@endsection
@section('script')
<script async>
    AOS.init({
        duration: 1000
    });
</script>
@endsection