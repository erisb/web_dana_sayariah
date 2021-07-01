<aside id="side-overlay" style="width: 380px !important;">
    <!-- Side Header -->
    <div class="content-header content-header-fullrow" style="width: 340px !important;">
        <div class="content-header-section align-parent">
            <!-- Close Side Overlay -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button id="change_layout_12" type="button" class="btn btn-circle btn-dual-secondary align-v-r d-block d-lg-none" data-toggle="layout" data-action="side_overlay_close">
                <i class="fa fa-times text-muted "></i>
            </button>
            <!-- END Close Side Overlay -->

            <!-- User Info -->
            <div class="content-header-item mb-30 mt-10">
                <h4 class="align-middle text-dark font-w300 mb-0 namaproyek">Nama Proyek</h4>
            </div>
            <!-- END User Info -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side mt-20" style="width: 340px !important">

        <!-- Mini Stats -->
        <!-- <div class=" pull-r-l font-w600" style="background: transparent;">            
            <p class="text-dark">Proyek Gallery</p>
        </div>
        <div class="block pull-r-l">
            <div class="block shadow-flat">  
                <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 5px 2px 5px 2px">
                    
                    <div class="p-5">
                        <image class="img-side" src="{{url('')}}/assetsBorrower/media/photos/photo21.jpg">
                    </div>
                    <div class="p-5">
                        <image class="img-side" src="{{url('')}}/assetsBorrower/media/photos/photo11.jpg">
                    </div>
                    <div class="p-5">
                        <image class="img-side" src="{{url('')}}/assetsBorrower/media/photos/photo10.jpg">
                    </div>
                    <div class="p-5">
                        <image class="img-side" src="{{url('')}}/assetsBorrower/media/photos/photo12.jpg">
                    </div>

                </div>
            
            </div>
        </div> -->
        <div class="block pull-r-l">
            <div class="block shadow-flat">  
                <div class="block-content block-content-full justify-content-start" style="padding: 5px 5px ">
                    
                    <div class="ml-2 text-left p-10">   
                        <p class="font-w600 mb-20 text-dark">Informasi Pendanaan</p>
                        <div class="row justify-content-between">
                            <div class="col-6">
                                    <h6 class="block-title text-dark mb-10 font-w600">Dana Terkumpul</h6>
                            </div>
                            <div class="col-6 text-right">
                                <p class="text-dark font-w600 " id="persendana">0%</p>
                            </div>
                        </div>
                        <div class="row mt- mb-5">
                            <div class="col-12 col-md-12 ml-5 ">
                                <div class="progress" style="border-radius: 10px; height: 10px">
                                    <div class="progress-bar" id="progressbar" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="font-size-sm font-w600 mb-0 mt-20 text-dark">
                            Grade
                        </p> 
                                                                            
                        <p class="font-size-sm font-w600 text-muted mb-0">
                            <i class="fa fa-star mt-5 text-primary" style="font-size: 1.5em;"></i>
                            <i class="fa fa-star mt-5 text-primary" style="font-size: 1.5em;"></i>
                            <i class="fa fa-star mt-5 text-primary" style="font-size: 1.5em;"></i>
                            <i class="fa fa-star-half-full mt-5 text-primary" style="font-size: 1.5em;"></i>
                            <i class="fa fa-star-o mt-5 text-primary" style="font-size: 1.5em;"></i>
                        </p> -->

                        <div class="row mt-30 mb-30">
                            <div class="col-12 col-md-6 mt-2">
                                <h6 class="mb-0 text-dark">Dana Dibutuhkan</h6>
                                <p class="text-muted" id="danadibutuhkan">Rp. 0</p>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <h6 class="mb-0 text-dark">Durasi Proyek</h6>
                                <p class="text-muted" id="durasiproyek">0 Bulan</p>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <h6 class="mb-0 text-dark">Imbal Hasil</h6>
                                <p class="text-muted" id="imbalhasil">0 %</p>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <h6 class="mb-0 text-dark">Minimum Pendanaan</h6>
                                <p class="text-muted" id="minimuminvestasi">Rp. 0</p>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <h6 class="mb-0 text-dark">Jenis Akad</h6>
                                <p class="text-muted" id="jenisakad">Murabahah</p>
                            </div>
                            <div class="col-12 col-md-6 mt-2">
                                <h6 class="mb-0 text-dark">Terima Hasil</h6>
                                <p class="text-muted" id="terimahasil">Tiap Bulan</p>
                            </div>
                            <div class="row mt-30 pt-30 mb-30 justify-content-center mx-auto d-block">
                            <span id="btn-ajukan-pendanaan" class="col-12">
                                <a href="/borrower/detilProyek/" class="btn btn-rounded btn-big btn-noborder btn-success" id="link"><span class="p-2 text-white">Lihat Selengkapnya</span></a>
                            </span>
                            </div>
                        </div>
                        
                    </div>                   
                </div>
            </div>
        </div>
        <!-- END Mini Stats -->

    </div>
    <!-- END Side Content -->
</aside>