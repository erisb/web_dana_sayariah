<!-- Extra Large Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" id="modal-mutasi" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-content">
                    <!-- Page Content -->
                    <div class="container py-20">
                        <!-- Invoice -->
                        <!-- Table Sections (.js-table-sections class is initialized in Helpers.tableToolsSections()) -->                                                
                        <div class="">
                            <div class="block-header block-header-default">
                                <h3 class="block-title text-dark">Riwayat Mutasi</h3>
                                <div class="block-options">
                                    <!-- Print Page functionality is initialized in Helpers.print() -->
                                    <button data-toggle="tooltip" title="Untuk Hasil Maksimal, klik print saat mode fullscreen" type="button" class="btn-block-option" onclick="Codebase.helpers('print-page');">
                                        <i class="si si-printer"></i> Print Invoice
                                    </button>
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                        <i class="si si-refresh"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">    
                                <div class="row mt-30 mb-30">
                                    <div class="col-12">
                                            <image  height="40" src="{{url('')}}/img/logo_oldes.png">
                                            <p class="h6 text-muted mt-30 mb-0  text-rightfont-w700">Riwayat Mutasi</p>
                                            <p class="h5 text-muted mt-0 font-w700">Pendanaan XI/09 Bojong Gede</p>
                                            <p class="h6 text-muted mt-0 font-w700">Range Tanggal :</p>
                                            <div class="form-group row">                                                
                                                <div class="col-lg-6">
                                                    <div class="input-daterange input-group " data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                        <input type="text" class="form-control" id="example-daterange1" name="example-daterange1" placeholder="From" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                        <div class="input-group-prepend input-group-append">
                                                            <span class="input-group-text font-w600">to</span>
                                                        </div>
                                                        <input type="text" class="form-control" id="example-daterange2" name="example-daterange2" placeholder="To" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>   
                                <div class="table-responsive">                                                
                                <table class="js-table-sections table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">KETERANGAN</th>
                                            <th style="width: 15%;">TANGGAL</th>
                                            <th class="text-center" style="width: 20%;">DEBIT</th>
                                            <th class="text-center" style="width: 20%;">KREDIT</th>
                                            <th class="text-center" style="width: 20%;">SALDO</th>
                                        </tr>
                                    </thead>
                                    <tbody class="js-table-sections-header">
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                Keterangan ini adalah keterangan untuk riwayat mutasi
                                            </td>
                                            <td class="font-w600">
                                                <em class="text-muted">October 28, 2017</em>
                                            </td>
                                            <td class="text-right">
                                                Rp. 52.000.000
                                            </td>
                                            <td class="text-right">
                                                -
                                            </td>
                                            <td class="text-right">
                                                Rp. 52.000.000
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>
                                                Keterangan ini adalah keterangan untuk riwayat mutasi
                                            </td>
                                            <td class="font-w600">
                                                <em class="text-muted">October 28, 2017</em>
                                            </td>
                                            <td class="text-right">
                                                -
                                            </td>
                                            <td class="text-right">
                                                Rp. 2.000.000
                                            </td>
                                            <td class="text-right text-white font-w700" style="background-color: #2C9F5C!important;">
                                                Rp. 50.000.000
                                            </td>
                                        </tr>
                                    </tbody>                                                            
                                    
                                </table>
                                <!-- Invoice Info -->                                
                                <div class="row my-20">
                                    <!-- Company Info -->
                                    <div class="col-6 mt-10 pl-30">
                                        <p class="mb-0 font-w600 text-dark">Tanggal Terbit</p>
                                        <address class="text-dark">
                                        {{ date('Y-m-d H:i:s') }}
                                        </address>
                                    </div>
                                    <!-- END Company Info -->

                                    <!-- Client Info -->
                                    <div class=" mt-10 col-6 text-right pr-30">
                                        <p class="mb-0 font-w600 text-dark">Hormat Kami,</p>
                                        <address class="mt-30 pt-20 text-dark">
                                            Dana Syariah Indonesia
                                        </address>
                                    </div>
                                    <!-- END Client Info -->
                                </div>
                                <!-- END Invoice Info -->
                                </div>
                            </div>
                        </div>
                        <!-- END Table Sections -->
                        <!-- END Invoice -->
                        <div class="modal-footer p-30">
                            <button type="button" class="btn btn-rounded btn-outline-secondary min-width-200 mr-30" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-rounded min-width-200 btn-dsi text-white" data-dismiss="modal">Download</button>
                        </div>
                    </div>
                    <!-- END Page Content -->
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- END Extra Large Modal -->