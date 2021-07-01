<script src="{{url('assetsBorrower/js/codebase.core.min.js')}}"></script>
<script src="{{url('assetsBorrower/js/codebase.app.min.js')}}"></script>
<!-- picker range -->
<script src="{{url('assetsBorrower/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{url('assetsBorrower/js/plugins/flatpickr/flatpickr.min.js')}}"></script>
<!-- dropzone image -->
<script src="{{url('assetsBorrower/js/plugins/dropzone/dropzone.js')}}"></script>
<!-- pie chart -->
<script src="{{url('assetsBorrower/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{url('assetsBorrower/js/plugins/easy-pie-chart/jquery.easypiechart.min.js')}}"></script>

<!-- Page JS Plugins Form wizard -->
<script src="{{url('assetsBorrower/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js')}}"></script>
<script src="{{url('assetsBorrower/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{url('assetsBorrower/js/plugins/jquery-validation/additional-methods.js')}}"></script>
<!-- Page JS Plugins Form wizard -->
<!-- Page JS Code form wizard-->
<script src="{{url('assetsBorrower/js/pages/be_forms_wizard.min.js')}}"></script>
<!-- IDE -->
<script src="{{url('assetsBorrower/js/plugins/simplemde/simplemde.min.js') }}"></script>
<!-- Select2 -->
<script src="{{url('assetsBorrower/js/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- CKEDITOR -->
<script src="{{url('assetsBorrower/js/plugins/ckeditor/ckeditor.js')}}"></script>
<!-- SweetAlert JS -->
<script src="{{url('assetsBorrower/js/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- slide -->
<script src="{{url('assetsBorrower/js/plugins/slick/slick.min.js')}}"></script>
<!-- DataTables -->
<script src="{{url('assetsBorrower/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('assetsBorrower/js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Page JS Code -->
<script src="{{url('assetsBorrower/js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>jQuery(function(){ Codebase.helpers('slick'); });</script>
<script>jQuery(function(){ Codebase.helpers('table-tools'); });</script>
<script>jQuery(function(){ Codebase.helpers('ckeditor'); });</script>
<script>jQuery(function(){ Codebase.helpers('datepicker'); });</script>
<script>jQuery(function(){ Codebase.helpers('flatpickr'); });</script>
<!--<script>jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker']); });</script>-->
<script>
    // pie chart            
    $(function() {
        $('.js-pie-chart-enabled').easyPieChart();
    });
    // for sidebar right
    function resize() {
        if ($(window).width() < 514) {
            $('#page-container').removeClass('side-overlay-o');
            $('#col').addClass('col-12');
            $('#col2').addClass('col-12');
            $('#status-plafon').addClass('d-none');
            $('.content-header').addClass('content-header-small');
            $('#detect-screen').removeClass('content-full-right');
            $('#detect-screen').addClass('content-full-right-small');
            $('#btn-ajukan-pendanaan').removeClass('pull-right');
            $('.simplebar-content').addClass('simplebar-content-small');
        }
        else if ($(window).width() < 641){
            $('#status-plafon').addClass('d-none');
        }
        else if ($(window).width() < 991) {
            $('#page-container').removeClass('side-overlay-o');
            $('#status-plafon').removeClass('d-none');
            $('#detect-screen').removeClass('content-full-right-small');
            $('#detect-screen').addClass('content-full-right');
            $('#btn-ajukan-pendanaan').addClass('pull-right');
            $('.simplebar-content').removeClass('simplebar-content-small');
            $('.simplebar-content').addClass('simplebar-content');
        }
        else {
            $('#page-container').addClass('side-overlay-o');
            $('#status-plafon').removeClass('d-none');
            $('#detect-screen').removeClass('content-full-right-small');
            $('#detect-screen').addClass('content-full-right')
            $('#btn-ajukan-pendanaan').addClass('pull-right');
            $('.simplebar-content').removeClass('simplebar-content-small');
            $('.simplebar-content').addClass('simplebar-content');
        }
    }

    function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    };

    $(document).ready( function() {
        $(window).resize(resize);
        resize();
        //session brw_id
        var brw_id = "<?php echo Auth::guard('borrower')->user()->brw_id;?>"
        // console.log(brw_id);
            $.ajax({
                url:"/borrower/getlastproyekapproved/"+brw_id,
                datatype:"json",
                success:function(html){
                    // console.log(html);
                    var dibutuhkan = parseInt(html.data.pendanaan_dana_dibutuhkan);
                    var danaTerkumpul = parseInt(html.data.terkumpul)+parseInt(html.danaTerkumpul.nominal_awal);
                    var persentaseTerkumpul = (danaTerkumpul/dibutuhkan)*100; 
                    var persendana = persentaseTerkumpul.toFixed(1)+"%";
                    if (persendana == "100.0%"){persendana = 100+"%"}
                    // console.log(
                    //     'dibutuhkan :'+dibutuhkan+' danaterkumpul : '+danaTerkumpul+' persentaseTerkumpul : '+persentaseTerkumpul+' persendana : '+persendana
                    // );
                    $('.namaproyek').text(html.data.nama);
                    $('#danadibutuhkan').text("Rp. "+formatNumber(parseInt(html.data.total_need)));
                    $('#imbalhasil').text(html.data.profit_margin+' %');
                    $('#durasiproyek').text(html.data.tenor_waktu+' Bulan');
                    $('#minimuminvestasi').text("Rp. "+formatNumber(parseInt(html.data.harga_paket)));
                    $('#jenisakad').text((html.data.pendanaan_akad == 1 ? 'Murabahah' : 'Mudarabah'));
                    $('#terimahasil').text((html.data.mode_pembayaran == 1 ? 'Tiap Bulan' : 'Akhir Proyek'));
                    $('#metodepembayaran').text((html.data.metode_pembayaran == 1 ? 'FULL' : 'Parsial'));
                    $('#persendana').text(persendana);
                    $('#progressbar').attr('style', "width: "+persendana+";");
                    $('#link').attr('href', "/borrower/detilProyek/"+html.data.id);
                }
            });

        $(document).on('click','#deitil',function() {
        var id = $(this).attr("class");
        var persendana = '0.0%';
        $('.namaproyek').text('');
        if(id == 0){
            alert('Menunggu Pendanaan Di Approve !!');
            $('#link').attr('href', "#");
            $('.namaproyek').text('Menunggu Pendanaan Di Approve !');
            $('#danadibutuhkan').text("Rp. -");
            $('#durasiproyek').text('0 Bulan');
            $('#imbalhasil').text('0.00 %');
            $('#minimuminvestasi').text("Rp. 0");
            $('#jenisakad').text("-");
            $('#terimahasil').text("-");
            $('#persendana').text(persendana);
            $('#progressbar').attr('style', "width: "+persendana+";");
        }else{
           $.ajax({
                url:"/borrower/getProyekbyId/"+id,
                datatype:"json",
                success:function(html){
                    console.log(html);
                    var dibutuhkan = parseInt(html.data.pendanaan_dana_dibutuhkan);
                    var danaTerkumpul = parseInt(html.data.terkumpul)+parseInt(html.danaTerkumpul.nominal_awal);
                    var persentaseTerkumpul = (danaTerkumpul/dibutuhkan)*100; 
                    var persendana = persentaseTerkumpul.toFixed(1)+"%";
                    if (persendana == "100.0%"){persendana = 100+"%"}
                    $('.namaproyek').text(html.data.nama);
                    $('#danadibutuhkan').text("Rp. "+formatNumber(parseInt(html.data.total_need)));
                    $('#imbalhasil').text(html.data.profit_margin+' %');
                    $('#durasiproyek').text(html.data.tenor_waktu+' Bulan');
                    $('#minimuminvestasi').text("Rp. "+formatNumber(parseInt(html.data.harga_paket)));
                    $('#jenisakad').text((html.data.pendanaan_akad == 1 ? 'Murabahah' : 'Mudarabah'));
                    $('#terimahasil').text((html.data.mode_pembayaran == 1 ? 'Tiap Bulan' : 'Akhir Proyek'));
                    $('#metodepembayaran').text((html.data.metode_pembayaran == 1 ? 'FULL' : 'Parsial'));
                    $('#persendana').text(persendana);
                    $('#progressbar').attr('style', "width: "+persendana+";");
                    $('#link').attr('href', "/borrower/detilProyek/"+html.data.id);
                }
            });
        }
        });
    });
    
    $( "#change_layout_12" ).click(function(e) {
        
            $('#col').removeClass('col-md-9');
            $('#col').addClass('col-md-12');
            $('#col2').removeClass('col-md-9');
            $('#col2').addClass('col-md-12');
        
    });
    $( "#change_layout_8" ).click(function(e) {
        if( $('#col').hasClass('col-md-9') ) {
            $('#col').removeClass('col-md-9');
            $('#col').addClass('col-md-12');
            $('#col2').removeClass('col-md-9');
            $('#col2').addClass('col-md-12');
        }
        else{
            $('#col').removeClass('col-md-12');
            $('#col').addClass('col-md-9');
            $('#col2').removeClass('col-md-12');
            $('#col2').addClass('col-md-9');
        }
        
    });

</script>