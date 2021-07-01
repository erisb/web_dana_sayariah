@extends('layouts.guest.master')
@section('meta_tag',$news_detil->title)
@section('navbar')
@include('includes.navbar2')
@endsection

@section('body')


<!-- Blog section start -->
<div class="blog-section content-area-13">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Blog grid box start -->
                <div class="blog-1">
                    <img class="blog-theme img-fluid" src="{{asset('/storage')}}/{{$news_detil->image}}" alt="Dana Syariah {{$news_detil->title}}">
                    <div class="detail mb-5">
                        <div class="date-box">
                            <h5>{{ Carbon\Carbon::parse($news_detil->created_at)->format('d') }}</h5>
                            <h5>{{ Carbon\Carbon::parse($news_detil->created_at)->format('M') }}</h5>
                        </div>
                        <h1 class="pt-3">
                            {{$news_detil->title}}
                        </h1>
                        <div class="post-meta">
                            <h6 style="font-size: .8rem"><a href="#"><i class="fa fa-user"></i> <span class="pl-2">{{$news_detil->writer}}</span> </a></h6>
                        </div>
                        <p>
                            {!! $news_detil->deskripsi !!}
                        </p>
                        <br>
                        {{-- <div class="row clearfix tags-socal-box">
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <div class="tags">
                                    <h2>Tags</h2>
                                    <ul>
                                        <li><a href="#">Syariah</a></li>
                                        <li><a href="#">Halal</a></li>
                                        <li><a href="#">Dana Syariah</a></li>
                                        <li><a href="#">News</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="social-list">
                                    <h2>Share</h2>
                                    <ul>
                                        <li>
                                            <a href="#" class="facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="twitter">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="google">
                                                <i class="fab fa-google"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="linkedin">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <!-- Blog grid box end -->

               <!-- post yang mirip -->
               
               <!-- end post yang mirip -->
             
            </div>

            
        </div>
    </div>
</div>
<!-- Blog section end -->


            <!-- new other -->
            <!-- Blog start -->
            <div class="blog content-area-2 pb-5 pt-5 mb-5">
                <div class="container pb-5 pt-5">
                    <div class="main-title pb-5 text-left">
                        <h1>Berita Lainnya</h1>
                        <p>Informasi lainnya yang sesuai dengan pencarian anda</p>
                    </div>
                    <div class="row">
                        @foreach($news_others as $dataNews)
                            @php
                              $data_url = str_slug($dataNews->title,'-');
                            @endphp
                            <div class="col-lg-4 col-md-6 wow fadeInLeft delay-04s">
                                <div class="blog-1">
                                    <img src="{{asset('/storage')}}/{{$dataNews->image}}" alt="Dana Syariah {{$dataNews->title}}" class="img-fluid">
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
                                            <a href="/news_detil/{{ $dataNews->id }}" class="text-dark">{{$dataNews->title}}</a>
                                        </h3>
                                        <div class="post-meta">
                                            <h6 style="font-size: .8rem"><i class="fa fa-user"></i> <span class="pl-2"> {{$dataNews->writer}} </span> </h6>
                                        </div>
                                        <p>{!! substr(strip_tags($dataNews->deskripsi),0,250) !!}..</p>
                                        <a href="/news_detil/{{ $dataNews->id }}" class="text-success ">@lang('language.selengkapnya')  ></a>
                                    </div>
                                    -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- end for -->
                    <!-- end for -->
                    <div class="container">
                        <div class="row">
                            <div class="col text-center pt-5">
                                <div class="main-title pb-2 pt-0 mr-4 wow fadeInUp delay-10s">
                                    <a data-animation="animated fadeInUp delay-10s" href="{{ url('news') }}" class="btn btn-md banner-btn-right-ico ">Lihat Semua Berita <i class="fas fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blog end -->
            <!-- end news other -->


@endsection