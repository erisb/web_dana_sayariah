@extends('layouts.borrower.master')

@section('title', 'Selamat Datang Penerima Dana')

@section('content')
    <!-- select2 -->
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div id="detect-screen" class="content-full-right">
            <div class="container">
                <div class="row">
                    <div id="col" class="col-12 col-md-12 mt-30">
                        <span class="mb-10 pb-10 ">
                            <h1 class="no-paddingTop font-w400" style="float: left; margin-block-end: 0em; color: #31394D" >Lengkapi Data</h1>
                            <span class="pull-right">
                            <h6 class=" font-w700" style="float: left; margin-block-end: 0em; color: #31394D" >1 dari 2 Langkah</h6>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-md-12 mt-5 pt-5">
                        <div class="row">
                            
                            <div class="col-12 col-md-12">
                                <!-- Progress Wizard 2 -->
                                <div class="js-wizard-validation-classic block">
                                    <!-- Wizard Progress Bar -->
                                    <div class="progress rounded-0" data-wizard="progress" style="height: 8px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- END Wizard Progress Bar -->

                                    <!-- Step Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-validation-classic-step2" data-toggle="tab">1. Informasi Pendanaan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#wizard-validation-classic-step3" data-toggle="tab">2. Dokumen Pendukung</a>
                                        </li>
                                    </ul>
                                    <!-- END Step Tabs -->

                                    <!-- Form -->
                                    
									
									
									<form id="form_lengkapi_profile" method="POST" class="js-wizard-validation-classic-form" enctype="multipart/form-data">
                                        <!-- Steps Content -->
                                        @csrf
                                        <div class="block-content block-content-full tab-content" style="min-height: 274px;">
                                            <!-- Step 1 -->
                                            
                                            <!-- END Step 1 -->

                                            <!-- Step 2 -->
                                            <div class="tab-pane active" id="wizard-validation-classic-step2" role="tabpanel">
                                                <div id="layout-x">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <!-- satuBaris -->
                                                                <div id="layout-pribadi" class="layout col-md-3">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Tipe Pendanaan (Pribadi)</label>
                                                                            <select class="form-control" id="type_pendanaan_select" name="type_pendanaan_select" required></select>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div id="layout-badanhukum" class="layout col-md-3" style="display: none;">
                                                                    <div class="form-group">
                                                                        <div class="form-group">
                                                                            <label for="wizard-progress2-namapengguna">Tipe Pendanaan (Badan Hukum)</label>
                                                                            <select class="form-control" id="type_pendanaan_select_bdn_hukum" name="type_pendanaan_select_bdn_hukum" required></select>
                                                                        </div> 
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-namapendanaan">Nama Pendanaan</label>
                                                                        <input class="form-control allowCharacter" type="text" id="txt_nm_pendanaan" name="txt_nm_pendanaan" placeholder="Masukkan nama pendanaan" required>  
                                                                    </div>
                                                                </div>  
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Akad</label>
                                                                        <select class="form-control" id="txt_jenis_akad_pendanaan" name="txt_jenis_akad_pendanaan" required>
                                                                            <option value="1">Murabahah</option>
                                                                            <option value="2">Mudarabah</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <!-- satuBaris --> 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-tempatlahir">Dana Dibutuhkan</label>
                                                                        <input class="form-control" type="number" id="txt_dana_pendanaan" name="txt_dana_pendanaan" placeholder="Masukkan dana yang anda butuhkan..." required>  
                                                                    </div>
                                                                </div>
                                                                 
                                                                <!-- satuBaris -->
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="wizard-progress2-ktp">Estimasi Mulai Proyek</label>
                                                                        <input type="text" class="js-flatpickr form-control bg-white allowCharacterdate" id="txt_estimasi_proyek" data-date-format="d-m-Y" data-min-date="01.01.2020" name="txt_estimasi_proyek" placeholder="dd-mm-YYYY" data-allow-input="true" required>

                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group pb-0 mb-0">
                                                                        <label for="wizard-progress2-ktp">Durasi Proyek/Tenor *</label>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <input class="form-control " type="text" id="txt_durasi_pendanaan" name="txt_durasi_pendanaan" placeholder="Estimasi Bulan" required>  
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text input-group-text-dsi"> Bulan
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Mode Pembayaran *</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_pembayaran_pendanaan" name="txt_pembayaran_pendanaan" value="1" required>
                                                                                <span class="css-control-indicator"></span> Cicilan Bulanan
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_pembayaran_pendanaan" name="txt_pembayaran_pendanaan" value="2" required>
                                                                                <span class="css-control-indicator"></span> Pelunasan di Akhir
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-12">Metode Pembayaran *</label>
                                                                        <div class="col-12">
                                                                            <label class="css-control css-control-primary css-radio mr-10 text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_metode_pembayaran_pendanaan" name="txt_metode_pembayaran_pendanaan" value="1" required>
                                                                                <span class="css-control-indicator"></span> FULL
                                                                            </label>
                                                                            <label class="css-control css-control-primary css-radio text-dark">
                                                                                <input type="radio" class="css-control-input" id="txt_metode_pembayaran_pendanaan" name="txt_metode_pembayaran_pendanaan" value="2" required>
                                                                                <span class="css-control-indicator"></span> Parsial
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah jaminan -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Jaminan Pendanaan</h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-12 " >
                                                                            <div class="row" id="tambahJaminan">
                                                                                <!-- satuBaris -->

                                                                                <div class="col-12 ">
                                                                                    <div class="row ">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-namapengurus">Nama Jaminan</label>
                                                                                                <input class="form-control allowCharacter" type="text"  name="txt_nm_jaminan_pendanaan[]" placeholder="Nama Jaminan Pendanaan..." required>  
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Nomor Jaminan</label>
                                                                                                <input class="form-control allowCharacter" type="text" id="txt_nomor_jaminan_pendanaan" name="txt_nomor_jaminan_pendanaan[]" placeholder="Nomor Jaminan Pendanaan..." required> 
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Jenis Jaminan</label>
                                                                                                <select class="form-control jenisjaminan" id="txt_jenis_jaminan_pendanaan" name="txt_jenis_jaminan_pendanaan[]" required></select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row ">
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Nilai Jaminan (Rp)</label>
                                                                                                <input class="form-control allowCharacter" min="1" max="10000000000" type="number" id="txt_nilai_jaminan_pendanaan" name="txt_nilai_jaminan_pendanaan[]" placeholder="Nilai Jaminan Pendanaan..." required> 
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-8">
                                                                                            <div class="form-group">
                                                                                                <label for="wizard-progress2-nik">Detail Jaminan</label>
                                                                                                <textarea class="form-control detailjaminan allowCharacter" rows="4" cols="80" id="txt_detail_jaminan_pendanaan" name="txt_detail_jaminan_pendanaan[]" required></textarea>
                                                                                                <!-- <input class="form-control" type="text" id="txt_detail_jaminan_pendanaan" name="txt_detail_jaminan_pendanaan[]" placeholder="Nilai Jaminan Pendanaan...">  -->
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                 
                                                                            </div>
                                                                        </div>
                                                                        <!-- new row -->
                                                                        <div class="col-12">
                                                                            <button type="button" class="btn btn-rounded btn-primary btn-dsi min-width-200 mb-10 push-right" onclick="add_jaminan()">Tambah Jaminan</button>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- baris pemisah -->
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Detail Pendanaan</h6>        
                                                            <div class="form-group row">
                                                                <div class="col-12">
                                                                    <textarea id="txt_detail_pendanaan" rows="4" cols="50" class="form-control" name="txt_detail_pendanaan"></textarea>
                                                                </div>
                                                            </div> 
                                                            <!-- baris pemisah
                                                            <h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Media Gallery</h6>
                                                          
                                                            <div class="form-group row">
                                                                <label class="col-12">Pilih Gambar</label>
                                                                <div class="col-8">
                                                                <select class="form-control" id="txt_jenis_akad_pendanaanss" name="txt_jenis_akad_pendanaanss">
                                                                    <option value="0">Pilih Jenis Akad</option>
                                                                    <option value="1">Muarabahah - Jual Beli</option>
                                                                    <option value="2">Mura - X Beli</option>
                                                                </select>
                                                                </div>
                                                            </div> 
                                                            -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END Step 2 -->

                                            <!-- Step 3 -->
                                            <div class="tab-pane" id="wizard-validation-classic-step3" role="tabpanel">
                                            <!-- 1 -->
                                            <div class="layout-dokumen">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row"> 
                                                            <div class="col-12">
                                                                <h3 class="content-heading text-dark mt-0 pt-0 font-w600" >Kelengkapan Dokumen</h3>
                                                                <p>Dalam mengajukan pendanaan <span class="font-w700" id="txt_judul_pendanaan"> </span> berikut dokumen pendukung yang harus anda miliki, centang jika file tersedia dan
                                                                siap untuk di periksa tim Dana Syariah Indonesia.</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group row" id="checklist_persyaratan">
                                                                    
                                                                </div>
                                                            </div>         
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- ./ 1 -->
                                        </div>
                                        <!-- END Steps Content -->
                                        </div>
                                        </div>
                                        <!-- Steps Navigation -->
                                        <div class="block-content block-content-sm block-content-full bg-body-light">
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-alt-secondary" data-wizard="prev">
                                                        <i class="fa fa-angle-left mr-5"></i> Sebelumnya
                                                    </button>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                                                        Selanjutnya <i class="fa fa-angle-right ml-5"></i>
                                                    </button>
                                                    <button type="button" id="btn_lengkapi_profile" class="btn btn-alt-primary d-none" data-wizard="finish">
                                                        <i class="fa fa-check mr-5"></i> Kirim
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Steps Navigation -->
                                    </form>
                                    <!-- END Form -->
                                </div>
                                <!-- END Progress Wizard 2 -->   
                            </div>
                        </div>
                    </div>                           
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
    <!-- Pop In Modal -->
        <div class="modal fade" id="modal_action_lengkapi_profile" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
            <div class="modal-dialog modal-dialog-popin" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Proses Lengkapi Profile</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <p>Anda Yakin Ingin Memprosesnya ?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" id="btn_proses_pendanaan" class="btn btn-alt-success" data-dismiss="modal">Proses</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Pop In Modal -->
        <script src="/tinymce/js/tinymce/tinymce.min.js"></script>
        <script src="/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
    <script>
        // active layout type untuk borrower
        
        
        $(function() {
            $('#type_borrower').change(function(){
                $('.layout').hide();
                $('#' + $(this).val()).show();
                $( '#layout-x >' + 'div >' + 'div >' + 'div >' + '#' + $(this).val()).show();
            });
        });

        // active layout type dokumen
        /*
        $(function() {
            $('#type-pendanaan-select').change(function(){
                $('.layout-dokumen').show();
                //$('#' + $(this).val()).show();
            });
        });
        */
        var thn = document.getElementById('txt_tahun_pribadi');
        //var thn = $("#txt_tahun_pribadi");
        var minOffset = 17; maxOffset = 100; // Change to whatever you want
        var thisYear = new Date().getFullYear();
        
        var html_thn = '<option value="">--Pilih--</option>';
        for (i = new Date().getFullYear(); i > 1900; i--)
        {
            html_thn += '<option value='+i+'>'+i+'</option>';
        }
        // thn.innerHTML = html_thn;
        
        // data tipe pendanaan
        $.getJSON("{{config('app.clientlink')}}/borrower/tipe_pendanaan", function(data_tipe_pendanaan){
            
        
            $('#type_pendanaan_select').prepend('<option selected></option>').select2({
                placeholder: "Pilih Tipe Pendanaan",
                allowClear: true,
                data: data_tipe_pendanaan,
                //multiple: true,
                width: 250
            });

            // $('#type_pendanaan_select_bdn_hukum').select2({
            //  placeholder: "Pilih Tipe Pendanaan",
            //  allowClear: true,
            //  data: data_tipe_pendanaan,
            //  //multiple: true,
            //  width: 250
            // });

        });
        
        // data persyaratan pendanaan pribadi
        $(function() {
            $('#type_pendanaan_select').change(function(){
                var tipe_borrower_val = $("#type_borrower option:selected").val();
                var tipe_borrower_text = $("#type_borrower option:selected").text();
                var tipe_pendanaan = $('#type_pendanaan_select option:selected').val();
                var tipe_pendanaan_text = $('#type_pendanaan_select option:selected').text();
                var tipe_borrower = "{{Session::get('brw_type')}}";
                var brw_id = "{{Session::get('brw_id')}}";
                // if(tipe_borrower_text == "Pribadi - Pegawai"){
                //     tipe_borrower = 1;
                    
                // }
                // if(tipe_borrower_text == "Pribadi - Wirausaha"){
                //     tipe_borrower = 3;
                    
                // }
                // if(tipe_borrower_text == "Perusahaan / Badan Hukum"){
                //     tipe_borrower = 2;
                    
                // }

                //$("#txt_kota_bdn_hukum").empty().trigger('change'); // set null
                $.getJSON( "{{config('app.clientlink')}}/borrower/persyaratan_pendanaan_proses_pengajuan/"+brw_id+"/"+tipe_borrower+"/"+tipe_pendanaan, function(data_persyaratan){
                    $("#txt_judul_pendanaan").text(tipe_pendanaan_text);
                    
                    var html ="";
                    $('#checklist_persyaratan').html('');
                    for (var i = 0, len = data_persyaratan.length; i < len; ++i) {
                        var mandatory = "";
                        var checked   = "";
                        var disabled   = "";
                        if(data_persyaratan[i].persyaratan_mandatory == 1){
                            mandatory += '<span class="text-danger">*</span>';
                            checked   += 'checked';
                            disabled   += 'disabled';
                        }
                        
                        html += '<div class="col-6">'
                                    +'<label class="css-control css-control-primary css-radio mr-10 text-dark">'
                                        +'<input type="checkbox" '+disabled+' '+checked+' class="css-control-input" id="txt_persyaratan_pendanaan" name=id="txt_persyaratan_pendanaan" value='+data_persyaratan[i].persyaratan_id+' required>'
                                        +'<span class="css-control-indicator"></span> '+data_persyaratan[i].persyaratan_nama+' '
                                        +mandatory
                                    +'</label>'
                                +'</div>';
                    }
                   
                    $('#checklist_persyaratan').append(html);
                });
            });
            
            // data persyaratan pendanaan badan hukum
            $('#type_pendanaan_select_bdn_hukum').change(function(){
                var tipe_borrower_val = $("#type_borrower option:selected").val();
                var tipe_borrower_text = $("#type_borrower option:selected").text();
                var tipe_pendanaan = $('#type_pendanaan_select_bdn_hukum option:selected').val();
                var tipe_pendanaan_text = $('#type_pendanaan_select_bdn_hukum option:selected').text();
                
                var tipe_borrower = "{{Session::get('brw_type')}}";
                // if(tipe_borrower_text == "Pribadi - Pegawai"){
                //     tipe_borrower = 1;
                // }
                // if(tipe_borrower_text == "Pribadi - Wirausaha"){
                //     tipe_borrower = 3;
                // }
                // if(tipe_borrower_text == "Perusahaan / Badan Hukum"){
                //     tipe_borrower = 2;
                // }
                 //$("#txt_kota_bdn_hukum").empty().trigger('change'); // set null
                $.getJSON( "{{config('app.clientlink')}}/borrower/persyaratan_pendanaan/"+tipe_borrower+"/"+tipe_pendanaan, function(data_persyaratan){
                    $("#txt_judul_pendanaan").text(tipe_pendanaan_text);
                    
                    var html ="";
                    $('#checklist_persyaratan').html('');
                    for (var i = 0, len = data_persyaratan.length; i < len; ++i) {
                        var mandatory = "";
                        var checked   = "";
                        var disabled   = "";
                        if(data_persyaratan[i].persyaratan_mandatory == 1){
                            mandatory += '<span class="text-danger">*</span>';
                            checked   += 'checked';
                            disabled   += 'disabled';
                        }
                        html += '<div class="col-6">'
                                    +'<label class="css-control css-control-primary css-radio mr-10 text-dark">'
                                        +'<input type="checkbox" '+disabled+' '+checked+' class="css-control-input" id="txt_persyaratan_pendanaan" name="txt_persyaratan_pendanaan" value='+data_persyaratan[i].persyaratan_id+'>'
                                        +'<span class="css-control-indicator"></span> '+data_persyaratan[i].persyaratan_nama+' '
                                        +mandatory
                                    +'</label>'
                                +'</div>';
                    }
                   
                    $('#checklist_persyaratan').append(html);
                });
                
            });
        });
        
        
        // validasi hanya angka
        $('#txt_kd_pos_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_no_ktp_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_npwp_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_npwp_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_nik_aw_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_nik_anda_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_anda_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_aw_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_notlp_aw_pribadi').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_asset_bdn_hukum').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_dana_pendanaan').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#txt_durasi_pendanaan').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        $("#btn_lengkapi_profile").click(function(){    
            $("#modal_action_lengkapi_profile").modal('show');
        });
        
        $("#btn_proses_pendanaan").click(function(){
            
            //pendanaan;
            var type_pendanaan_select = $("#type_pendanaan_select option:selected").val();
            var type_pendanaan_select_bdn_hukum = $("#type_pendanaan_select_bdn_hukum option:selected").val();
            var txt_nm_pendanaan = $("#txt_nm_pendanaan").val();
            var txt_jenis_akad_pendanaan = $("#txt_jenis_akad_pendanaan option:selected").val();
            var txt_dana_pendanaan = $("#txt_dana_pendanaan").val();
            var estimasi_proyek = $("#txt_estimasi_proyek").val();
            var txt_estimasi_proyek = estimasi_proyek.split("-").reverse().join("-");
            var txt_durasi_pendanaan = $("#txt_durasi_pendanaan").val();
            var txt_pembayaran_pendanaan = $("input[name=txt_pembayaran_pendanaan]:checked").val();
            var txt_metode_pembayaran_pendanaan = $("input[name=txt_metode_pembayaran_pendanaan]:checked").val();
            var txt_detail_pendanaan = tinyMCE.get('txt_detail_pendanaan').getContent();
            // $("#txt_detail_pendanaan").val();
            var jaminan_nama= []; jaminan_nomor= []; jaminan_jenis= []; jaminan_nilai= []; jaminan_detail= [];jaminan_status = [];
           
            // jaminan_nama
            $('input[name="txt_nm_jaminan_pendanaan[]"]').each(function() {
                jaminan_nama.push(this.value);
            });

            // jaminan_nomor
            $('input[name="txt_nomor_jaminan_pendanaan[]"]').each(function() {
                jaminan_nomor.push(this.value);
            });

            // jaminan_jenis
            $('.jenisjaminan').each(function() {
                jaminan_jenis.push(this.value);
            });
            // alert(jaminan_jenis);
            //jaminan_nilai
            $('input[name="txt_nilai_jaminan_pendanaan[]"]').each(function() {
                jaminan_nilai.push(this.value);
            });

            // jaminan_detail
            $('.detailjaminan').each(function() {
                jaminan_detail.push(this.value);
            });
            
            var jaminan = [];
            for(var u=0;u<jaminan_nama.length;u++){
                jaminan[u] = [
                    jaminan_nama[u]+"@",
                    "@"+jaminan_nomor[u]+"@",
                    "@"+jaminan_jenis[u]+"@",
                    "@"+jaminan_nilai[u]+"@",
                    "@"+jaminan_detail[u]
                ];
            }
            var jaminan_arr = jaminan.join("^~");
            // alert(jaminan);
            
            
            // persyaratan
            var persyaratanList = [];
            var i = 0;
            
            $("#txt_persyaratan_pendanaan:checked").each(function() {

                if (this.checked) {
                    persyaratanList.push(this.value);
                    i++;
                }

            });
            var persyaratan_arr = persyaratanList.join(",");
            
            
            var typeBorrower = "";
            var type_borrower = "{{Session::get('brw_type')}}";
            // console.log(type_borrower);
            if(type_borrower == 1){
                
                typeBorrower += 1; // perorangan pegawai 
                $.ajax({
                    url: "{{route('borrower.action_pendanaan')}}",
                    type: "POST",
                    data:  {"_token": "{{ csrf_token() }}", 'type_borrower':typeBorrower,
                    // pendanaan
                    'txt_nm_pendanaan':txt_nm_pendanaan, 'txt_jenis_akad_pendanaan':txt_jenis_akad_pendanaan, 'txt_dana_pendanaan':txt_dana_pendanaan, 'txt_estimasi_proyek':txt_estimasi_proyek, 'txt_durasi_pendanaan':txt_durasi_pendanaan, 'txt_pembayaran_pendanaan':txt_pembayaran_pendanaan, 'txt_metode_pembayaran_pendanaan':txt_metode_pembayaran_pendanaan,'txt_detail_pendanaan':txt_detail_pendanaan, 'type_pendanaan_select':type_pendanaan_select, 'jaminan':jaminan_arr, 
                    //persyaratan
                    'persyaratan_arr' : persyaratan_arr
                    },
                    
                    success: function (response) {
						
                        var obj = jQuery.parseJSON( response );
                        if(obj.status == "sukses"){
                            Swal.fire({
                              position: 'center',
                              icon: 'success',
                              title: 'Proses Berhasil, Kami Akan Segera Menghubungi Anda',
                              showConfirmButton: false,
                              timer: 2500
                            })
                            
                            location.href = "/borrower/pendanaanPage";
                        }
                        console.log(response);
                        
                    }
                });
                
                
            }
            
            else if(type_borrower == 3){
                
                typeBorrower += 3; // perorangan Wirausaha
                
                $.ajax({
                    url: "{{route('borrower.action_pendanaan')}}",
                    type: "POST",
                    data:  {"_token": "{{ csrf_token() }}", 'type_borrower':typeBorrower,
                    // pendanaan
                    'txt_nm_pendanaan':txt_nm_pendanaan, 'txt_jenis_akad_pendanaan':txt_jenis_akad_pendanaan, 'txt_dana_pendanaan':txt_dana_pendanaan, 'txt_estimasi_proyek':txt_estimasi_proyek, 'txt_durasi_pendanaan':txt_durasi_pendanaan, 'txt_pembayaran_pendanaan':txt_pembayaran_pendanaan,'txt_metode_pembayaran_pendanaan':txt_metode_pembayaran_pendanaan, 'txt_detail_pendanaan':txt_detail_pendanaan, 'type_pendanaan_select':type_pendanaan_select, 'jaminan':jaminan_arr, 
                    //persyaratan
                    'persyaratan_arr' : persyaratan_arr
                    },
                    
                    success: function (response) {
                        var obj = jQuery.parseJSON( response );
                        if(obj.status == "sukses"){
                            Swal.fire({
                              position: 'center',
                              icon: 'success',
                              title: 'Proses Berhasil, Kami Akan Segera Menghubungi Anda',
                              showConfirmButton: false,
                              timer: 2500
                            })
                            
                            location.href = "/borrower/pendanaanPage";
                        }
                        
                    }
                });
                
            }
            
            else if(type_borrower == 2){
                
                typeBorrower += 2; // Perusahaan Badan Hukum
                
                $.ajax({
                    url: "{{route('borrower.action_pendanaan')}}",
                    type: "POST",
                    data:  {"_token": "{{ csrf_token() }}", 'type_borrower':typeBorrower,
                    // pendanaan
                    'type_pendanaan_select_bdn_hukum':type_pendanaan_select_bdn_hukum,'txt_nm_pendanaan':txt_nm_pendanaan, 'txt_jenis_akad_pendanaan':txt_jenis_akad_pendanaan, 'txt_dana_pendanaan':txt_dana_pendanaan, 'txt_estimasi_proyek':txt_estimasi_proyek, 'txt_durasi_pendanaan':txt_durasi_pendanaan, 'txt_pembayaran_pendanaan':txt_pembayaran_pendanaan, 'txt_metode_pembayaran_pendanaan':txt_metode_pembayaran_pendanaan,'txt_detail_pendanaan':txt_detail_pendanaan, 
                    //persyaratan
                    'persyaratan_arr' : persyaratan_arr
                    },
                    
                    success: function (response) {
                        var obj = jQuery.parseJSON( response );
                        if(obj.status == "sukses"){
                            Swal.fire({
                              position: 'center',
                              icon: 'success',
                              title: 'Proses Berhasil, Kami Akan Segera Menghubungi Anda',
                              showConfirmButton: false,
                              timer: 2500
                            })
                            
                            location.href = "/borrower/pendanaanPage";
                        }
                    }
                });
            }

            // console.log("uhuy");
        });
        
        //validasi form
        $('.checkKarakterAneh').on('input', function (event) { 
            this.value = this.value.replace(/[^a-zA-Z ]/g, '');
        });
        
        $('.allowCharacter').on('input', function (event) { 
            this.value = this.value.replace(/[^a-zA-Z0-9.,-/ ]/g, '');
        });

        $('.allowCharacterdate').on('input', function (event) { 
            this.value = this.value.replace(/[^0-9.,-/]/g, '');
        });

        // data jenis jaminan
        $.getJSON("{{config('app.clientlink')}}/borrower/jenis_jaminan", function(data_jenis_jaminan){
            $('.jenisjaminan').prepend('<option selected></option>').select2({
                placeholder: "Pilih Jenis Jaminan",
                allowClear: true,
                data: data_jenis_jaminan,
                //multiple: true,
                width: 250
            });
        });
        
        function add_jaminan() {
            $.getJSON("{{config('app.clientlink')}}/borrower/jenis_jaminan", function(data_jenis_jaminan){
                        $('.jenisjaminan').prepend('<option selected></option>').select2({
                            placeholder: "Pilih Jenis Jaminan",
                            allowClear: true,
                            data: data_jenis_jaminan,
                            //multiple: true,
                            width: 250
                        });
                    });
            var tambahJaminan = 
                 // data jenis jaminan
                '<div class="col-12 mt-3" id="containerJaminan">'
                +'<h6 class="content-heading text-muted font-w600" style="font-size: 1em;">Jaminan Pendanaan</h6>'
                +'<div class="row">'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-namapengurus">Nama Jaminan</label>'
                            +'<input class="form-control" type="text" id="txt_nm_jaminan_pendanaan" name="txt_nm_jaminan_pendanaan[]" placeholder="Nama Jaminan Pendanaan..." required>'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Nomor Jaminan</label>'
                            +'<input class="form-control" type="text" id="txt_nomor_jaminan_pendanaan" name="txt_nomor_jaminan_pendanaan[]" placeholder="Nomor Jaminan Pendanaan..." required>'
                        +'</div>'
                    +'</div>'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Jenis Jaminan</label>'
                            +'<select class="form-control jenisjaminan" id="txt_jenis_jaminan_pendanaan" name="txt_jenis_jaminan_pendanaan[]" required></select>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<div class="row">'
                    +'<div class="col-md-4">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Nilai Jaminan (Rp)</label>'
                            +'<input class="form-control" type="number" id="txt_nilai_jaminan_pendanaan" name="txt_nilai_jaminan_pendanaan[]" placeholder="Nilai Jaminan Pendanaan..." required>'
                        +'</div>'
                    +'</div>' 
                    +'<div class="col-md-8">'
                        +'<div class="form-group">'
                            +'<label for="wizard-progress2-nik">Detail Jaminan</label>'
                            +'<textarea class="form-control detailjaminan" rows="4" cols="80" id="txt_detail_jaminan_pendanaan" name="txt_detail_jaminan_pendanaan[]" required></textarea>'
                        +'</div>'
                    +'</div>'   
                +'</div>'
                +'<button type="button" class="btn btn-rounded btn-danger mb-10 push-right" id="delete_jaminan"> <i class="fa fa-times"></i>  Hapus Jaminan Ini</button><hr>'
            +'</div>';
            
           

            $('#tambahJaminan').append(tambahJaminan);
            
        }

        $(document).on("click", "#delete_jaminan", function() { 
            $(this).parent().remove();
        });
  
    </script>
    <script>
        tinymce.init({
            selector: '#txt_detail_pendanaan',
            height: 300,
            theme: 'modern',
            skin:'lightgray',
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            file_picker_callback: function(callback, value, meta) {
            if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    callback(e.target.result, {
                    alt: ''
                    });
                };
                reader.readAsDataURL(file);
                });
            }
            },
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
@endsection