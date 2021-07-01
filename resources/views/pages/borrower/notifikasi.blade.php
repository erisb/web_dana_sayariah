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
                    <h1 class="no-paddingTop font-w400 text-dark" style="float: left; margin-block-end: .6em;" >Notifikasi</h1>                    
                </span>
            </div>
        </div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title text-dark"></h3>
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
                        <i class="list-timeline-icon fa fa-credit-card bg-info"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">+ 1 Pendanaan XI/90 Jatuh Tempo</p>
                            <p class="text-dark">Tanggal Jatuh Tempo : 20/10/2020</p>
                        </div>
                    </li>
                    <li>
                        <div class="list-timeline-time text-dark">2 hrs ago</div>
                        <i class="list-timeline-icon fa fa-check bg-primary"></i>
                        <div class="list-timeline-content">
                            <p class="font-w600 text-dark">+ Pendanaan XI/90 Cikeas</p>
                            <p class="text-dark">Telah di Verifikasi</p>
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
                            <p class="font-w600 text-dark">Invoice Pendanaan XI/90 created!</p>
                            <p class="text-dark">Lihat atau Download Invoice Pendanaan XI/90 <a href="javascript:void(0)">lihat pendanaan</a>.</p>
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
                            <p class="font-w600 text-dark">+ 2 Unggah Foto terbaru</p>
                            <p class="text-dark">Pendanaan XI/222 Cicayur We had a great time!</p>
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
    