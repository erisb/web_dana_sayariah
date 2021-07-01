<aside id="side-overlay">
    <!-- Side Header -->
    <div class="content-header content-header-fullrow">
        <div class="content-header-section align-parent">
            <!-- Close Side Overlay -->
            <!-- Layout API, functionality initialized in Codebase() -> uiApiLayout() -->
            <button id="change_layout_12" type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                <i class="fa fa-times text-muted "></i>
            </button>
            <!-- END Close Side Overlay -->

            <!-- User Info -->
            <div class="content-header-item mb-30 mt-10">
                <h4 class="align-middle text-muted font-w300 mb-0" >Detail</h4>
                <h5><small class="font-w400 text-dark">Total Keseluruhan</small></h5>
            </div>
            <!-- END User Info -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side mt-20">

        <!-- Mini Stats -->
        @foreach ($detailKeseluruhan as $row)
        <div class="block pull-r-l">
            <div class="block shadow-flat">  
                <div class="block-content block-content-full d-flex align-items-center justify-content-start" style="padding: 2px 2px ">
                    
                    <div class="p-10">
                        <image class="img-side" height="50" src='{{url("storage/$row->gambar_utama")}}'>
                    </div>
                    
                    <div class="ml-2 text-left">   
                        <p class="font-size-sm font-w600 mb-0 text-muted">
                            {{ $row->pendanaan_nama }}
                        </p> 
                                                                            
                        <p class="font-size-sm font-w600 text-muted mb-0">
                            @if(empty($row->id))
                                <a href="#">Lihat Detail</a>
                            @else
                                <a href="/borrower/detilProyek/{{ $row->id }}">Lihat Detail</a>
                            @endif
                        </p>
                        
                    </div>
                    <small style="font-size: .7rem; margin-top:-45px;">
                        <?php 
                        if($row->status == 0){
                            echo "<i class='fa fa-circle text-pengajuan pull-right ml-4 mt-0 pt-0 mr-10'></i>"; 
                        }elseif($row->status == 1){
                            echo "<i class='fa fa-circle text-success pull-right ml-4 mt-0 pt-0 mr-10'></i>"; 
                        }elseif($row->status == 2){
                            echo "<i class='fa fa-circle text-closed pull-right ml-4 mt-0 pt-0 mr-10'></i>";
                        }elseif($row->status == 3){
                            echo "<i class='fa fa-circle text-fully pull-right ml-4 mt-0 pt-0 mr-10'></i>";
                        }else{
                            echo "<i class='fa fa-circle text-selesai pull-right ml-4 mt-0 pt-0 mr-10'></i>";
                        }?>
                    </small>  
                </div>
            </div>
        </div>
        @endforeach
        <!-- END Mini Stats -->

    </div>
    <!-- END Side Content -->
</aside>