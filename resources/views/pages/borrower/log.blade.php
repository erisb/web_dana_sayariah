@extends('layouts.borrower.master')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <div class="content">
        <div class="row">
            <div id="col" class="col-12 col-md-12 mt-30">
                <span class="mb-10 pb-10 ">
                    <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: .6em;" >Timeline <small>Acitivity</small> </h1>                    
                </span>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title"></h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <ul class="list list-timeline list-timeline-modern pull-t">
                    <li>
                        <div class="list-timeline-time text-dark">50 min ago</div>
                        <i class="list-timeline-icon fa fa-users bg-info"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">+ 79 Investor</p>
                            <p class="text-dark">You’re getting more and more investor, keep it up!</p>
                        </div>
                    </li>
                    <li>
                        <div class="list-timeline-time text-dark">2 hrs ago</div>
                        <i class="list-timeline-icon fa fa-camera bg-elegance"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">+ 3 New photos</p>
                            <p class="text-dark">Untuk Pendanaan XI/90 Bojong Gede</p>
                            <div class="row items-push js-gallery img-fluid-100 ">
                                <div class="col-sm-6 col-xl-3">
                                    <img class="img-fluid" src="assetsBorrower/media/photos/photo2.jpg" alt="">
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <img class="img-fluid" src="assetsBorrower/media/photos/photo8.jpg" alt="">
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <img class="img-fluid" src="assetsBorrower/media/photos/photo9.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="list-timeline-time text-dark">5 hrs ago</div>
                        <i class="list-timeline-icon fa fa-briefcase bg-default"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">+ 160 Page View</p>
                            <p class="text-dark">Pendanaan XI/22 Cikeas, keep it up!</p>
                        </div>
                    </li>
                    <li>
                        <div class="list-timeline-time text-dark">3 days ago</div>
                        <i class="list-timeline-icon fa fa-download bg-pulse"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">Invoice Download completed!</p>
                            <p class="text-dark">Download Invoice Pendanaan XI/90 <a href="javascript:void(0)">lihat pendanaan</a>.</p>
                        </div>
                    </li>
                    <li>
                        <div class="list-timeline-time text-dark">5 days ago</div>
                        <i class="list-timeline-icon fa fa-user-plus bg-success"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">+ 4 new Investor</p>
                            <p class="text-dark">It seems that you might know these professionals.</p>                            
                        </div>
                    </li>
                    <li>
                        <div class="list-timeline-time text-dark">6 days ago</div>
                        <i class="list-timeline-icon fa fa-camera bg-elegance"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">+ 2 New photos</p>
                            <p class="text-dark">Pendanaan XI/222 Cicayur We had a great time!</p>
                            <div class="row items-push js-gallery img-fluid-100 js-gallery-enabled">
                                <div class="col-sm-6 col-xl-3">
                                    <a class="img-link img-link-zoom-in img-lightbox" href="assets/media/photos/photo4@2x.jpg">
                                        <img class="img-fluid" src="assets/media/photos/photo4.jpg" alt="">
                                    </a>
                                </div>
                                <div class="col-sm-6 col-xl-3">
                                    <a class="img-link img-link-zoom-in img-lightbox" href="assets/media/photos/photo18@2x.jpg">
                                        <img class="img-fluid" src="assets/media/photos/photo18.jpg" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="list-timeline-time text-dark">2 weeks ago</div>
                        <i class="list-timeline-icon fa fa-cog bg-gray-darker"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">System updated to v3.9</p>
                            <p class="text-dark">Please check the complete changelog at the <a href="javascript:void(0)">activity page</a>.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        </div>
        <!-- END Page Content -->

    </main>
    <!-- END Main Container -->
@endsection
    