<!-- Extra Large Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" id="modal-invoice" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-content">
                    <!-- Page Content -->
                    <div class="container py-20">
                        <!-- Invoice -->
                        <div class="block">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">#INV0015</h3>
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
                                <div class="col-12">
                                        <image class="float-right" height="50" src="{{url('')}}/img/logo_oldes.png">
                                        <p class="h3 text-primary font-w700">INVOICE</p>
                                    </div>
                                </div>
                                <div class="container">
                                <!-- Invoice Info -->                                
                                <div class="row my-20 pt-20">
                                    <!-- Company Info -->
                                    <div class="col-6 mt-20">
                                        <p class="h6">Dikirim ke :</p>
                                        <address>
                                            Street Address<br>
                                            State, City<br>
                                            Region, Postal Code<br>
                                            ltd@example.com
                                        </address>
                                        <div class="row mt-30">
                                            <div class="col-6">
                                                <p class="h6 mb-0 text-primary">Informasi Tanggal</p>
                                                <address class="h6 mt-5">
                                                    01 Januari 2020
                                                </address>
                                            </div>
                                            <div class="col-6">
                                                <p class="h6 mb-0 text-primary">Nomor Invoice</p>
                                                <address class="h6 mt-5">
                                                    INV0015
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Company Info -->

                                    <!-- Client Info -->
                                    <div class="col-6 text-right">
                                        <div class="pr-30 pb-20" style="background-color: #0C542A; color: white; border-radius: 20px; padding-top: 20px;">
                                            <p class="h6 text-white">Alamat</p>
                                            <address>
                                                District 8, Prosperity Tower Lantai 12 Unit J,<br>
                                                JL. Jendral Sudirman Kav. 52-53,<br>
                                                Kelurahan Senayan, Kecamatan Kebayoran Baru,<br>
                                                Jakarta Selatan 12190<br>
                                            </address>
                                            <p class="h6 text-white">Kontak</p>
                                            <address>
                                                Email :<br>
                                                cso@danasyariah.id<br>
                                                Phone :<br>
                                                +62 (21) 521 0306<br>
                                                +62 (21) 521 0142<br>
                                            </address>
                                        </div>
                                    </div>
                                    <!-- END Client Info -->
                                </div>
                                <!-- END Invoice Info -->

                                <!-- Table -->
                                <div class="table-responsive push mt-30">
                                    <p class="h3 text-muted">Pendanaan XI/00029</p>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 60px;"></th>
                                                <th>STATUS</th>
                                                <th class="text-center" style="width: 150px;">JATUH TEMPO</th>
                                                <th class="text-center" style="width: 150px;">DANA POKOK</th>
                                                <th class="text-center" style="width: 120px;">IMBAL HASIL</th>
                                                <th class="text-center" style="width: 150px;">BAYAR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td>
                                                    <p class="font-w600 mb-5">Cicilan Bulanan</p>
                                                    <div class="text-muted">Pembayaran Cicilan Bulanan pada proyek Pendanaan XI/09 Bojong Gede</div>
                                                </td>
                                                <td class="text-center">
                                                    <em> 15 Maret 2020</em>
                                                </td>
                                                <td class="text-right">Rp. 10.000.000</td>
                                                <td class="text-right">Rp. 5.000.000</td>
                                                <td class="text-right">Rp. 15.000.000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="font-w600 text-right">Subtotal</td>
                                                <td class="text-right">$25.000,00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="font-w600 text-right">Tax</td>
                                                <td class="text-right">0%</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="font-w600 text-right">Denda</td>
                                                <td class="text-right">0</td>
                                            </tr>
                                            <tr  style="background-color: #2C9F5C!important;">
                                                <td colspan="5" class="font-w700 text-uppercase text-right text-white">Sub Total</td>
                                                <td class="font-w700 text-right text-white">Rp 15.000.000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- END Table -->

                                <!-- Footer -->
                                <p class="text-primary text-center h5">Thank you for your Business</p>
                                <!-- END Footer -->

                                <!-- Invoice Info -->                                
                                <div class="row my-20">
                                    <!-- Company Info -->
                                    <div class="col-6 mt-10">
                                        <p class="h6">Term & Condition</p>
                                        <address>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting <br>
                                        industry. Lorem Ipsum has been the industry's standard dummy text <br>
                                        ever since the 1500s
                                        </address>
                                    </div>
                                    <!-- END Company Info -->

                                    <!-- Client Info -->
                                    <div class=" mt-10 col-6 text-right">
                                        <p class="h6">Hormat Kami,</p>
                                        <address class="mt-30 pt-20">
                                            Dana Syariah Indonesia
                                        </address>
                                    </div>
                                    <!-- END Client Info -->
                                </div>
                                <!-- END Invoice Info -->
                                </div>
                            </div>
                        </div>
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