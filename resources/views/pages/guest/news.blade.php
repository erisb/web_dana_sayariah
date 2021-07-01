@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
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
                        <p style="font-weight: 500; font-size: .9em; line-height: 1em; display: block;" > @lang('menu.berita') </p>                        
                    </h2>
                    <p style="font-size: 1.2em; line-height: 1.5em; font-weight: 400;" class="pb-3 wow fadeInLeft delay-09s pt-3">@lang('menu.berita_desc') <br></p>                                                           
                    
                </div>
            </div>
            
            
        </div>
    </div>
</div>
<div>
<!-- hero us start -->
<!-- Blog section start -->
<div class="blog-section content-area-2">
    <div class="container">
        <div class="row">
            @foreach($all_news as $dataNews)
                        @php
                          $data_url = str_slug($dataNews->title,'-');
                        @endphp
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog-1">
                        <img src="{{asset('/storage')}}/{{$dataNews->image}}" alt="blog" class="img-fluid">
                        <div class="detail mb-5" style="overflow-wrap: break-word;">
                                        <div class="date-box">
                                            <h5>{{ Carbon\Carbon::parse($dataNews->created_at)->format('d') }}</h5>
                                            <h5>{{ Carbon\Carbon::parse($dataNews->created_at)->format('M') }}</h5>
                                        </div>
                                        <h3 class="pt-3">
                                            <a href="/news_detil/{{ $dataNews->id }}/{{ $data_url }}" class="text-dark">{{$dataNews->title}}</a>
                                        </h3>
                                        <div class="post-meta">
                                            <h6 style="font-size: .8rem"><i class="fa fa-user"></i> <span class="pl-2"> {{$dataNews->writer}} </span> </h6>
                                        </div>
                                        <p>{!! substr(strip_tags($dataNews->deskripsi),0,250) !!}..</p>
                                        <a href="/news_detil/{{ $dataNews->id }}/{{ $data_url }}" class="text-success ">@lang('language.selengkapnya') ></a>
                                    </div>
                        <!--
                        <div class="detail mb-5">
                            <div class="date-box">
                                <h5>{{ Carbon\Carbon::parse($dataNews->created_at)->format('d') }}</h5>
                                <h5>{{ Carbon\Carbon::parse($dataNews->created_at)->format('M') }}</h5>
                            </div>
                            <h3 class="pt-3">
                                <a href="/news_detil/{{ $dataNews->id }}/{{ $data_url }}" class="text-dark">{{$dataNews->title}}</a>
                            </h3>
                            <div class="post-meta">
                                <h6 style="font-size: .8rem"><i class="fa fa-user"></i> <span class="pl-2"> {{$dataNews->writer}} </span> </h6>
                            </div>
                            <p>{!! substr(strip_tags($dataNews->deskripsi),0,250) !!}..</p>
                            <a href="/news_detil/{{ $dataNews->id }}/{{ $data_url }}" class="text-success ">@lang('language.selengkapnya')  ></a>
                        </div>
                    -->
                    </div>
                </div>
            @endforeach
            <div class="col-lg-12 mb-5 mt-5">
                <div class="pagination-box text-center">
                    <nav aria-label="Page navigation example">
                            {{$all_news->links()}}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog section end -->

@endsection