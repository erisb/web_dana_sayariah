<?php
// use Symfony\Component\Routing\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// sukuk landingpage
Route::get('/sukuk', 'ProyekController@sukuk');
Route::get('/coming_soon', 'ProyekController@redirect_sukuk');


Route::get('/convertCSV_AFPI', 'RekeningController@convertCSV_AFPI');
Route::get('/inquiry_fdc', 'RekeningController@inquiry_fdc');
Route::get('/passwordZIP', 'RekeningController@passwordZIP');
Route::get('/GeneratepasswordZIP', 'RekeningController@GeneratepasswordZIP');

// Borrower
Route::get('/welcome_borrower', 'BorrowerDashboardController@welcome');
Route::get('/borrower', 'BorrowerDashboardController@dashboard');
Route::get('/all_pendanaan_borrower', 'BorrowerDashboardController@all_pendanaan');
Route::get('/detail_pendanaan_borrower', 'BorrowerDashboardController@detail_pendanaan');
Route::get('/add_pendanaan_borrower', 'BorrowerDashboardController@add_pendanaan');
Route::get('/all_riwayat_mutasi_borrower', 'BorrowerDashboardController@all_riwayat_mutasi');
Route::get('/edit_profile_borrower', 'BorrowerDashboardController@edit_profile');
Route::get('/notifikasi_borrower', 'BorrowerDashboardController@notifikasi');
Route::get('/log_borrower', 'BorrowerDashboardController@log');
Route::get('/faq_borrower', 'BorrowerDashboardController@faq');
Route::get('/lock_borrower', 'BorrowerDashboardController@lock');
//guest route

    Route::get('/', 'ProyekController@index')->name('index');
    Route::get('proyek/{id}', 'ProyekController@detil');
    Route::get('penggalangan-berlangsung', 'ProyekController@showall');
    Route::get('penggalangan-full', 'ProyekController@showallFull');
    Route::get('penggalangan-closed', 'ProyekController@showallClosed');
    Route::get('termcondition', 'StaticPageController@termcondition');
    Route::get('privacypolicy', 'StaticPageController@privacypolicy');
    Route::prefix('tentang-kami')->group( function(){
        Route::get('khazanah','StaticPageController@khazanah');
        Route::get('tim-kami','StaticPageController@timKami');
        Route::get('kontak','StaticPageController@kontak');
    });
    Route::prefix('tata-cara')->group( function(){
        Route::get('penerima','StaticPageController@tataCaraPenerima');
        Route::get('pendana','StaticPageController@tataCaraPendana');
        Route::get('pengaduan','StaticPageController@tataCaraPengaduan');
    });
    Route::get('/faq', 'StaticPageController@faq');
    // Route::get('/forgotpassword','StaticPageController@forgotpassword');
    Route::get('modal-usaha-property', 'StaticPageController@modalusahaProperty');
    Route::get('genVA','RekeningController@generateVA');

    Route::post('/guest/message', 'StaticPageController@message')->name('guest.message');
    Route::get('/getKota/{id}','UserController@get_kota');

    Route::get('resendMail', function(){
            return view('pages.guest.resend_mail');
    });

    Route::get('resendMailborrower', function(){
            return view('pages.guest.resend_mail_borrower');
    });

    Route::post('resendMailPost', 'StaticPageController@resendMailPost')->name('resend.investor');
    Route::post('resendMailPostborrower', 'StaticPageController@resendMailPostborrower')->name('resend.borrower');
    Route::get('getPage/{locale}', 'ProyekController@multiLang');
    Route::get('perjanjian', function(){
            return response()->file( public_path() .'/Perjanjian keanggotaan danasyariah ditambahin APU PPT- Rev 3.pdf');
            });
    Route::get('privasi', function(){
            return response()->file( public_path() .'/Kebijakan Privasi.pdf');
            });
    Route::get('cookie', function(){
            return response()->file( public_path() .'/Kebijakan Cookie.pdf');
            });
    Route::get('perjanjian_borrower', function(){
                return response()->file( public_path() .'/Syarat dan Ketentuan Draft Borrower.pdf');
            });
    Route::get('kategori_resiko_borrower', function(){
                return response()->file( public_path() .'/KATEGORI_RISIKO_YANG_DAPAT_DITERIMA_DAN_ALUR_PROSES_ANALISA.pdf');
            });
    Route::get('viewSP3/{id}', function($id){
            return response()->file(storage_path('app/public/akad_borrower/'.$id.'/SP3.pdf'));
        });
    Route::get('viewWakalah/{id}', function($id){
            return response()->file(storage_path('app/public/akad_investor/'.$id.'/PERJANJIAN_PEMBIAYAAN_WAKALAH_BIL_UJRAH.pdf'));
        });
    Route::get('viewMurobahah/{id}', function($id){
            return response()->file(storage_path('app/public/akad_investor/'.$id.'/PERJANJIAN_PEMBIAYAAN_MURABAHAH_revisi.pdf'));
        });
    Route::get('news', 'StaticPageController@all_news');
    
    Route::get('news_detil/{id}/{title_slug}', 'StaticPageController@news_detil');
    Route::get('logout','Auth\LoginController@logout');
    Route::get('media','CmsController@media');

//end of guest route

Auth::routes();


//user route

// Route::middleware(['checkInvestor'])->prefix('user')->group(function(){
Route::prefix('user')->group(function(){
    Route::get('dashboard', 'UserController@showDashboard');
    Route::get('get_aktif_dana/{id}','UserController@get_aktif_dana');
    Route::get('getTableDetil','UserController@getTableDetil');
    // Route::get('manage_profile','UserController@manageProfile')->name('user.manageProfile');
    Route::get('manage_profile','UserController@manageProfile')->name('user.manageProfile')->middleware('telpProfile');
    //Route::get('manage_profile_upload','UserController@manageProfile')->name('user.manageProfile')->middleware('telpProfile');
    Route::post('update', 'UserController@updateProfile')->name('updateUser');
    Route::post('updatePassword', 'UserController@updatePassword')->name('updatePassword');
    Route::post('updateReject', 'UserController@updateProfileReject')->name('updateUserReject');
    Route::post('firstUpdate', 'UserController@firstUpdateProfile')->name('firstUpdateProfile');
    Route::post('changePassword','UserController@changePassword')->name('changePassword');
    Route::get('/checkPhone/{id}','UserController@checkPhone');

    Route::get('withdraw_request', 'RekeningController@showPenarikanDana')->name('user.withdraw_request');
    ///Route::get('withdraw_request', 'RekeningController@showPenarikanDana')->middleware('telpDana');
    Route::get('verificationCode/{id}','RekeningController@verificationCode');
    Route::post('kirimOTP','UserController@otpCode');
    Route::post('cekOTP','UserController@cekOTP');
    Route::get('sendVerifikasi/{id}/{otp}/{dana}','RekeningController@sendVerifikasi');
    Route::post('withdraw_money', 'RekeningController@penarikanDana');
    // check poto
    Route::get('check_photo', 'UserController@check_photo')->name('user.check_photo');
    // upload poto
    Route::post('upload_photo_pic_investor', 'UserController@upload_photo_pic_investor')->name('user.upload_photo_pic_investor');
    Route::post('upload_photo_pic_ktp_investor', 'UserController@upload_photo_pic_ktp_investor')->name('user.upload_photo_pic_ktp_investor');
    Route::post('upload_photo_pic_user_ktp_investor', 'UserController@upload_photo_pic_user_ktp_investor')->name('user.upload_photo_pic_user_ktp_investor');
    
    Route::post('new_upload1','UserController@new_registration_upload1');
    Route::post('new_upload2','UserController@new_registration_upload2');
    Route::post('new_upload3','UserController@new_registration_upload3');

    // Route::post('subscribe_payout','PayoutController@newSubscribe');
    // Route::post('unsubscribe_payout', 'PayoutController@unSubscribe');

    Route::get('confirm-email/{code}','UserController@emailConfirm');
    Route::get('manage_investation', 'UserController@showUserInvestation');
    Route::post('addActive', 'UserController@addPendanaanAktif' )->name('addActive');
    Route::post('ambilActive', 'UserController@ambilPendanaanAktif' )->name('ambilActive');
    Route::get('package_detail/{id}', 'UserController@showDetailPackage')->name('detailProyek');
    Route::get('tambahdana', 'UserController@showTambahDana')->name('add_funds');
    Route::get('tambahdana_midtrans', 'UserController@showTambahDanaMidtrans')->name('add_funds_midtrans');
    Route::post('proses_tambah_dana', 'UserController@prosesTambahDana')->name('user.proses.tambah');
    Route::get('finish', function(){
            return redirect()->route('add_funds_midtrans');
            })->name('proses.finish');
    Route::post('notification/handler', 'UserController@notificationHandler');
    Route::get('investation_feed', 'ProyekController@userfeed')->name('investation_feed');
    Route::get('ubahPassword', 'UserController@ubahPassword')->name('ubahPassword')->middleware('telpUbahPassword');

    // REQUEST OJK
    Route::get('selected_proyek', 'ProyekController@userSelectedProyek')->name('selected_proyek');
    Route::get('cekRegDigiSign/{id_user}', 'UserController@cekRegDigiSign');
    Route::get('unduhAkad', 'UserController@unduhAkad')->name('unduhAkad');
    

    // Sukuk User
    // 1.Registrasi
    Route::get('registrasi_sukuk', 'ProyekController@registrasisukuk');
    // 1.Registrasi Konfirmasi
    Route::get('registrasi_sukuk_konfirmasi', 'ProyekController@registrasisukuk_konfirmasi');
    // 1.Registrasi Konfirmasi sukses
    Route::get('registrasi_sukuk_konfirmasi_sukses', 'ProyekController@registrasisukukkonfirmasi_sukses');
    // 2.Pilih Produk sukuk / list Sukuk
    Route::get('list_sukuk', 'ProyekController@listsukuk');

    // Early Redemption 
    Route::get('early_redemption_sukuk', 'ProyekController@search_early_redemption_sukuk');
    // Early Redemption Konfirmasi
    Route::get('early_redemption_konfirmasi', 'ProyekController@search_early_redemption_konfirmasi');
    // Early Redemption Sukses
    Route::get('early_redemption_sukses', 'ProyekController@search_early_redemption_sukses');

    // History Sukuk
    Route::get('history_sukuk', 'ProyekController@history_sukuk');
    //  Portfolio Sukuk
    Route::get('portfolio_sukuk', 'ProyekController@portfolio_sukuk');


    // 3.Masukkan Kuota / Pesan SUKUK
    Route::get('pesan_sukuk', 'ProyekController@pesansukuk');
    Route::get('verifikasi_pesan_sukuk', 'ProyekController@verifikasipesansukuk');
    Route::get('payment_sukuk', 'ProyekController@paymentsukuk');
    // 4.syarat dan ketentuan berlaku

    // 5.Notifikasi dan cara pembayaran

    Route::get('penarikan', 'RekeningController@showPenarikanDana');
    Route::get('mutation_history', 'RekeningController@mutasiInvestor');
    
    Route::get('get_list_mutasi_history','RekeningController@get_list_mutasi_history');
    Route::get('get_params_mutasi_history/{tgl_start}/{tgl_end}','RekeningController@get_params_mutasi_history');
    
    Route::get('cetakulangsertifikat/{id}', 'RekeningController@cetakulangsertifikat')->name('cetakulangsertifikat');       
    Route::get('cekSertifikat/{id}', 'RekeningController@cekSertifikat')->name('cekSertifikat');

    Route::get('tutorial', function () {
        return view('pages.user.tutorial');
    });
    Route::get('userverification', function(){
        return view('pages.user.verif_user');
    })->name('user.verif');

    Route::get('ListAkadMurobahah/{id}', 'UserController@datatables_akad_murobahah');

    //GENERATE VA INVESTOR, BORROWER
    Route::get('genVA_investor/{username}','RekeningController@generateVABNI_Investor_test');
    Route::get('genVA_borrower/{username}/{id_proyek}','RekeningController@generateVABNI_Borrower');
    Route::get('checkStatusUser/{id_proyek}/{qty}','RekeningController@checkStatusUser');
    Route::get('checkStatusUserInvest/{id_proyek}/{qty}','RekeningController@checkStatusUserInvest');
    Route::post('add_pendanaan_new','UserController@add_pendanaan_new');

    
    
    // cart routes
    Route::prefix('cart')->group(function(){
        Route::get('/', 'CartController@index')->name('cart');
        Route::post('add','CartController@add')->name('cart.add');
        Route::post('create_invoice','CartController@create_invoice')->name('cart.create_invoice');
       
       /*====== Request OJK ====== */
        Route::post('addSelected','CartController@addSelected')->name('cart.addSelected');
        
        
        Route::post('updateSelected','CartController@updateSelectedPaket')->name('cart.updateSelected');
        //should be patch method for update
        Route::patch('update/{rowId}', 'CartController@update')->name('cart.update');
        Route::post('delete','CartController@delete')->name('cart.destroy');
        Route::post('checkout', 'CartController@checkout')->name('cart.checkout');
        //reset to delete all cart items
        Route::post('reset', 'CartController@reset')->name('cart.reset');
    });
    // end of cart routes
    Route::get('chart', 'UserController@chartPendanaan');
    Route::post('konfirm_telp', 'UserController@cekKonfirmTelp')->name('user.konfirm.telp');

    Route::get('redirect/{provider}', 'SocialController@redirect');
    Route::get('callback/{provider}', 'SocialController@callback');
    
    //Get Tab Proyek
    Route::get('/getOverView_proyek/{id}', 'ProyekController@getOverView_proyek')->name('getOverview');
    Route::get('/getLegalitas_proyek/{id}', 'ProyekController@getLegalitas_proyek')->name('getlegalitas');
    Route::get('/getPemilik_proyek/{id}', 'ProyekController@getPemilik_proyek')->name('getPemilik');
    
    //get histori penarikan dana
    Route::get('/histori_penarikan_dana/', 'UserController@histori_penarikan_dana')->name('user.histori_penarikan_dana');
    //Route::get('/histori_penarikan_dana/{id}', 'UserController@histori_penarikan_dana')->name('user.histori_penarikan_dana');
    
    //get histori proyek yang pernah didanai
    Route::get('/list_history_didanai/', 'UserController@list_history_didanai')->name('user.list_history_didanai');
    
    //get data kelo paket investasi
    Route::get('/list_data_kelola_paket_investasi/', 'UserController@list_data_kelola_paket_investasi')->name('user.list_data_kelola_paket_investasi');
    Route::post('edit_upload1','UserController@upload1');
    Route::post('edit_upload2','UserController@upload2');
    Route::post('edit_upload3','UserController@upload3');

    Route::get('regDigiSign/{id}','DigiSignController@registerDigiSignInvestor');
    Route::get('actDigiSign/{email}','DigiSignController@aktivasiDigiSign');
    Route::get('sendDigiSign/{id}','DigiSignController@sendDigiSignInvestor');
    Route::get('signDigiSign/{id}','DigiSignController@signDigiSignInvestor');
    Route::get('signDigiSignMurobahah/{id}/{proyek_id}','DigiSignController@signDigiSignMurobahahInvestor');
    Route::get('createDocInvestorBorrower/{investor_id}/{proyek_id}','DigiSignController@createDocInvestorBorrower');
    Route::post('downloadDigiSign','DigiSignController@downloadDigiSignInvestor');
    Route::post('downloadBase64DigiSign','DigiSignController@downloadBase64DigiSignInvestor');
    Route::post('downloadBase64DigiSignMurobahah','DigiSignController@downloadBase64DigiSignMurobahahInvestor');
    Route::get('generateWakalah/{id}','DigiSignController@createDocInvestor');
    // Route::get('hasilAktivasi/{email}','DigiSignController@getHasilAktivasi');
    // Route::get('callbackDigiSign/{id}/{provider}/{status}/{step}/{notif}','DigiSignController@callbackRegister');
    Route::post('callbackDigiSignInvestor','DigiSignController@callbackRegisterInvestor');
    Route::post('logAkadInvestor','UserController@logAkadInvestor');

    //get list proyek yang dipilih
    Route::get('/SelectedProyek/', 'UserController@list_selected_proyek')->name('user.list_selected_proyek');
    Route::get('/getSelectedProyek/{proyek_id}/{investor_id}', 'UserController@getSelectedProyek')->name('user.getSelectedProyek');
    Route::get('delete_select_proyek/{id_proyek}', 'UserController@delete_select_proyek')->name('user.delete_select_proyek');
    Route::post('/ProyekDetail/', 'UserController@get_detail_proyek')->name('user.get_detail_proyek');
    Route::post('newAdd','CartController@newAdd')->name('cart.newAdd');
    
    
});

//end of user route


//start admin route

Route::prefix('marketer')->group(function() {
    Route::get('login','Auth\MarketerLoginController@showLoginForm')->name('marketer.login');
    Route::post('login','Auth\MarketerLoginController@login')->name('marketer.login.submit');
    Route::get('logout','Auth\MarketerLoginController@logout')->name('marketer.logout');
    Route::get('dashboard','MarketerController@dashboard')->name('marketer.dashboard');
    Route::get('data_investor', 'MarketerController@datainvestor')->name('marketer.datainvestor');
    Route::get('mutasi', 'MarketerController@mutasi')->name('marketer.mutasi');

});

/************************** ROUTES BORROWER ****************************/
Route::prefix('borrower')->group(function() {
    
    /***** LOGIN & REGISTER *****/
    
        Route::post('login','Borrower\Auth\BrwLoginController@login')->name('borrower.login');
        Route::post('register', 'Borrower\Auth\BrwRegisterController@register')->name('borrower.register');
        Route::get('confirm-email/{code}','Borrower\Auth\BrwRegisterController@emailConfirm');
        Route::get('logout', 'Borrower\Auth\BrwLoginController@logout')->name('borrower.logout');
        Route::get('forgotPassword', 'Borrower\Auth\BrwResetController@showLinkRequestResetForm')->name('password_borrower.request');
        Route::get('formResetPassword/{id}', 'Borrower\Auth\BrwResetController@showLinkFormResetForm');
        Route::post('sendRequest', 'Borrower\Auth\BrwResetController@sendEmail')->name('kirim.email');
        Route::post('kirimResetPassword', 'Borrower\Auth\BrwResetController@ubahPassword')->name('kirim.data');
        Route::get('regDigiSignBorrower/{id}','DigiSignController@registerDigiSignBorrower');
        Route::get('sendDigiSignWakalahBorrower/{id}/{id_proyek}','DigiSignController@sendDocWakalahBorrower');
        Route::get('signDigiSignWakalahBorrower/{id}/{id_proyek}','DigiSignController@signDigiSignWakalahBorrower');
        Route::get('sendDigiSignMurobahahBorrower/{id_proyek}/{id}','DigiSignController@sendDocInvestorBorrower');
        Route::get('sendDigiSignMurobahahInvestor/{id_proyek}/{id}','DigiSignController@sendDocInvestorBorrower');
        Route::get('signDigiSignMurobahahBorrower/{id_brw}/{id_investor}/{id_proyek}','DigiSignController@signDigiSignMurobahahBorrower');
        Route::post('downloadDigiSignBorrower','DigiSignController@downloadDigiSignBorrower');
        Route::post('downloadBase64DigiSignBorrower','DigiSignController@downloadBase64DigiSignBorrower');
        Route::post('downloadBase64DigiSignMurobahahBorrower','DigiSignController@downloadBase64DigiSignMurobahahBorrower');
        Route::post('callbackDigiSignBorrower','DigiSignController@callbackRegisterBorrower');
        Route::get('actDigiSignBorrower/{email}','DigiSignController@aktivasiDigiSign');
        Route::get('generateSP3/{id}/{proyek}','DigiSignController@createDocSP3');
        

    
    /***** END LOGIN & REGISTER *****/
    

    /***** VIEW PAGE *****/
        Route::get('/dashboardPendanaan', 'BrwDashPendanaanController@dashBoard');
        Route::get('/detilProyek/{id}', 'BrwDashPendanaanController@detilProyek');
        Route::get('/pendanaanPage', 'BrwDashPendanaanController@pendanaanPage');
        Route::get('/getProyekbyId/{id}', 'BrwDashPendanaanController@getProyekbyId');
        Route::get('/getlastproyekapproved/{id}','BrwDashPendanaanController@getlastproyekapproved');
        Route::get('/ajukanPendanaan', 'BrwDashPendanaanController@add_pendanaan');
        Route::get('/lengkapi_profile', 'BrwDashPendanaanController@lengkapi_profile');
        Route::get('/status_reject', 'BrwDashPendanaanController@view_status_reject');
        Route::get('/status_pending', 'BrwDashPendanaanController@view_status_pending');
        
        Route::get('welcome', 'BorrowerDashboardController@welcome')->name('borrower.welcome');
        Route::get('dashboard', 'BorrowerDashboardController@dashboard');
        Route::get('add_pendanaan_borrower', 'BorrowerDashboardController@add_pendanaan');
        Route::get('/edit_profile_borrower', 'BorrowerDashboardController@edit_profile');
        Route::get('/change_password_borrower', 'BorrowerDashboardController@change_password');
        Route::post('cek_password', 'BorrowerDashboardController@cek_password');
        Route::post('ubah_password', 'BorrowerDashboardController@ubah_password')->name('ubah.proses');
        Route::post('proses_updateprofile', 'BorrowerDashboardController@proses_updateprofile');
        Route::get('list_invoice/{brw_id}/{proyek_id}', 'BrwDashPendanaanController@ListInvoice');

        Route::post('kirimOTP', 'BrwDashPendanaanController@otpCode');
        Route::post('cekOTP', 'BrwDashPendanaanController@cekOTP');
        Route::post('updateSP3','BrwDashPendanaanController@updateSP3');
        Route::get('generateToken','RDLController@generateToken'); // generate Token
        Route::get('uuid','RDLController@uuid'); // generate UUID
        Route::get('RDLRegisterInvestor/{investor_id}/{kd_bank}','RDLController@RegisterInvestor'); // Register Investor BNI RDL
        Route::get('RegisterInvestorAccount/{investor_id}/{cif_number}/{kode_bank}','RDLController@RegisterInvestorAccount')->name('borrower.RegisterInvestorAccount'); // Register Investor BNI RDL
        Route::get('base64_oauth','RDLController@base64_oauth'); // convert base64 oauth
        Route::get('base64_usename_password','RDLController@base64_usename_password'); // convert base64 username & password
        Route::get('create_jwt','RDLController@create_jwt'); // convert base64 username & password
        Route::get('InquiryAccountInfo/{account_number}/{kode_bank}','RDLController@InquiryAccountInfo'); // convert base64 username & password
        Route::get('InquiryAccountBalance/{account_number}/{kode_bank}','RDLController@InquiryAccountBalance'); // convert base64 username & password
        Route::get('InquiryAccountHistory/{account_number}/{kode_bank}','RDLController@InquiryAccountHistory'); // convert base64 username & password
        Route::get('InquiryTransferTransaction/{kode_bank}/{trx_uuid}','RDLController@InquiryTransferTransaction'); // convert base64 username & password
        Route::get('ExecuteTransferTransactionOverbooking/{account_number}/{kode_bank}/{accno_dest}/{amount}/{berita_transfer}','RDLController@ExecuteTransferTransactionOverbooking'); // convert base64 username & password
        Route::get('ExecuteTransferTransactionKliring/{kode_bank}/{account_number}/{accno_dest}/{beneficiaryAddress1}/{bank_code_dest}/{accname_dest}/{ammount}/{berita_transfer}','RDLController@ExecuteTransferTransactionKliring'); // convert base64 username & password
        Route::get('InquiryTransferTransactionOnline/{kode_bank}/{account_number}/{bank_code_dest}/{accno_dest}','RDLController@InquiryTransferTransactionOnline'); // convert base64 username & password
        Route::get('ExecuteTransferTransactionOnline/{kode_bank}/{account_number}/{bank_code_dest}/{bank_name_dest}/{accno_dest}/{accname_dest}/{amount}','RDLController@ExecuteTransferTransactionOnline'); // convert base64 username & password
        Route::get('ExecuteTransferTransactionRTGS/{kode_bank}/{account_number}/{bank_code_dest}/{bank_name_dest}/{accno_dest}/{accname_dest}/{amount}','RDLController@ExecuteTransferTransactionRTGS'); // convert base64 username & password
        Route::get('ExecuteTransferTransactionRTGS/{kode_bank}/{account_number}/{accno_dest}/{beneficiaryAddress1}/{bank_code_dest}/{accname_dest}/{amount}/{berita_transfer}','RDLController@ExecuteTransferTransactionRTGS'); // convert base64 username & password
       
    /***** END VIEW PAGE *****/
    
    
    
    /***** API DATA *****/
        Route::get('data_pendidikan', 'Borrower\BorrowerDataController@DataPendidikan');
        Route::get('check_nik/{nik}', 'Borrower\BorrowerDataController@CheckNIK');
        Route::get('check_nik_bh/{nik}', 'Borrower\BorrowerDataController@CheckNIKBH');
        Route::get('check_no_tlp/{noTLP}', 'Borrower\BorrowerDataController@CheckNoTlp');
        Route::get('data_provinsi', 'Borrower\BorrowerDataController@DataProvinsi');
        Route::get('data_provinsi_bdn_hukum', 'Borrower\BorrowerDataController@DataProvinsi');
        Route::get('data_kota/{id}', 'Borrower\BorrowerDataController@DataKota');
        Route::get('data_kota_bdn_hukum/{id}', 'Borrower\BorrowerDataController@DataKota');
        Route::get('data_pekerjaan', 'Borrower\BorrowerDataController@DataPekerjaan');
        Route::get('data_pekerjaan_bdn_hukum', 'Borrower\BorrowerDataController@DataPekerjaan');
        Route::get('data_bidang_pekerjaan', 'Borrower\BorrowerDataController@DataBidangPekerjaan');
        Route::get('data_pengalaman_pekerjaan', 'Borrower\BorrowerDataController@DataPengalamanPekerjaan');
        Route::get('data_pendapatan', 'Borrower\BorrowerDataController@DataPendapatan');
        Route::get('data_pendapatan_bdn_hukum', 'Borrower\BorrowerDataController@DataPendapatan');
        Route::get('tipe_pendanaan', 'Borrower\BorrowerDataController@TipePendanaan');
        Route::get('jenis_jaminan', 'Borrower\BorrowerDataController@JenisJaminan');
        Route::get('persyaratan_pendanaan/{tipe_borrower}/{tipe_pendanaan}', 'Borrower\BorrowerDataController@PersyaratanPendanaan');
        Route::get('persyaratan_pendanaan_proses_pengajuan/{brw_id}/{tipe_borrower}/{tipe_pendanaan}', 'Borrower\BorrowerDataController@PersyaratanPendanaanProsesPengajuan');
        Route::get('jenis_kelamin', 'Borrower\BorrowerDataController@JenisKelamin');
        Route::get('agama', 'Borrower\BorrowerDataController@Agama');
        Route::get('status_perkawinan', 'Borrower\BorrowerDataController@StatusPerkawinan');
        Route::get('status_rumah', 'Borrower\BorrowerDataController@StatusRumah');
        Route::get('data_bank', 'Borrower\BorrowerDataController@DataBank');
        Route::get('bidang_pekerjaan_online', 'Borrower\BorrowerDataController@BidangPekerjaanOnline');
        Route::get('dokumen_borrower', 'Admin\AdminClientController@DataDokumenBorrower');
        
    /***** END API DATA *****/
    
    /***** ACTION PROSES DATA *****/
        Route::post('action_lengkapi_profile', 'Borrower\BorrowerClientController@action_lengkapi_profile')->name('borrower.action_lengkapi_profile');
        Route::post('action_pendanaan', 'Borrower\BorrowerClientController@action_pendanaan')->name('borrower.action_pendanaan');
        Route::post('upload_foto_1', 'Borrower\BorrowerProsesController@new_upload_gambar_1')->name('borrower.new_upload_gambar_1');
        Route::post('upload_foto_2', 'Borrower\BorrowerProsesController@new_upload_gambar_2')->name('borrower.new_upload_gambar_2');
        Route::post('upload_foto_3', 'Borrower\BorrowerProsesController@new_upload_gambar_3')->name('borrower.new_upload_gambar_3');
        Route::post('upload_foto_4', 'Borrower\BorrowerProsesController@new_upload_gambar_4')->name('borrower.new_upload_gambar_4');
        Route::post('webcam_1', 'Borrower\BorrowerProsesController@webcam_picture_1')->name('borrower.webcam_picture_1');
        Route::post('webcam_2', 'Borrower\BorrowerProsesController@webcam_picture_2')->name('borrower.webcam_picture_2');
        Route::post('webcam_3', 'Borrower\BorrowerProsesController@webcam_picture_3')->name('borrower.webcam_picture_3');
        Route::post('webcam_4', 'Borrower\BorrowerProsesController@webcam_picture_4')->name('borrower.webcam_picture_4');
        Route::post('update_webcam_1', 'Borrower\BorrowerProsesController@update_webcam_picture_1')->name('borrower.update_webcam_picture_1');
        Route::post('update_webcam_2', 'Borrower\BorrowerProsesController@update_webcam_picture_2')->name('borrower.update_webcam_picture_2');
        Route::post('update_webcam_3', 'Borrower\BorrowerProsesController@update_webcam_picture_3')->name('borrower.update_webcam_picture_3');
        Route::post('update_webcam_4', 'Borrower\BorrowerProsesController@update_webcam_picture_4')->name('borrower.update_webcam_picture_4');
        Route::post('webcam_hukum_1', 'Borrower\BorrowerProsesController@webcam_picture_hukum_1')->name('borrower.webcam_picture_hukum_1');
        Route::post('webcam_hukum_2', 'Borrower\BorrowerProsesController@webcam_picture_hukum_2')->name('borrower.webcam_picture_hukum_2');
        Route::post('webcam_hukum_3', 'Borrower\BorrowerProsesController@webcam_picture_hukum_3')->name('borrower.webcam_picture_hukum_3');
        Route::post('webcam_hukum_4', 'Borrower\BorrowerProsesController@webcam_picture_hukum_4')->name('borrower.webcam_picture_hukum_4');
        Route::post('update_webcam_1_bdn_hukum', 'Borrower\BorrowerProsesController@update_webcam_picture_1_bdn_hukum')->name('borrower.update_webcam_picture_1_bdn_hukum');
        Route::post('update_webcam_2_bdn_hukum', 'Borrower\BorrowerProsesController@update_webcam_picture_2_bdn_hukum')->name('borrower.update_webcam_picture_2_bdn_hukum');
        Route::post('update_webcam_3_bdn_hukum', 'Borrower\BorrowerProsesController@update_webcam_picture_3_bdn_hukum')->name('borrower.update_webcam_picture_3_bdn_hukum');
        Route::post('update_webcam_4_bdn_hukum', 'Borrower\BorrowerProsesController@update_webcam_picture_4_bdn_hukum')->name('borrower.update_webcam_picture_4_bdn_hukum');
        
    /***** End Consum API BORROWER *****/

});

/************************** END ROUTES BORROWER ****************************/

//admin
Route::prefix('admin')->group(function() {
    Route::get('test_api','Admin\AdminClientController@manageTablePendanaan');
    Route::get('login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard')->middleware('checkSingle');
    Route::get('manage', 'AdminController@manageAdmin')->name('admin.manage');
    Route::delete('deleteUser/{id}', 'AdminController@deleteAdmin');
    Route::post('create', 'AdminController@createAdmin')->name('admin.create');
    Route::post('edit', 'AdminController@editAdmins')->name('admin.edit');
    Route::post('changepass', 'AdminController@changepassAdmin')->name('admin.changepass');
    Route::get('addInvestor','AdminController@add_investor')->name('admin.addInvestor');
    Route::get('getKota/{id}','AdminController@get_kota');

    Route::get('manage_carousel', 'AdminController@manageCarousel')->name('admin.manage_carousel');
    Route::post('addCarousel','AdminController@admin_add_carousel')->name('admin.addCarousel');
    Route::post('updateCarousel','AdminController@admin_update_carousel')->name('admin.updateCarousel');
    Route::delete('deleteCarousel/{id}','AdminController@admin_delete_carousel');
    Route::get('data_carousel_datatables','AdminController@get_carousel');
    Route::get('e_coll_bni', 'AdminController@e_coll_bni')->name('admin.e_coll_bni');
    Route::get('data_ecoll_datatables','AdminController@get_ecoll');
    Route::post('import', 'AdminController@import');
    Route::get('convertCsvToJson', 'AdminController@converter')->name('admin.converter');
    Route::post('actConvert', 'AdminController@actConvert');
    Route::get('edit_menu', 'AdminController@showMenu')->name('admin.edit_menu');
    Route::post('addRole', 'AdminController@add_role')->name('admin.add_role');
    Route::get('data_role_datatables','AdminController@get_role');
    Route::post('editRole','AdminController@edit_role')->name('admin.edit_role');
    Route::delete('deleteRole/{id}','AdminController@delete_role');
    Route::get('editMenu/{id}','AdminController@edit_menu');
    Route::get('data_users_datatables','AdminController@get_users_datatables');
    Route::get('link_register', 'AdminController@showLink');
    Route::get('data_link_investor','AdminController@get_link_investor');

    Route::get('manageVersion','AdminController@manageVersion');
    Route::get('tableManageVersion','AdminController@tableManageVersion');
    Route::post('postVersionMobile','AdminController@postVersionMobile');
    Route::post('editVersionMobile','AdminController@editVersionMobile');
    Route::get('deleteVersion/{id}','AdminController@deleteVersion');

    Route::get('manage_penghargaan', 'AdminController@managePenghargaan')->name('admin.manage.penghargaan');
    Route::post('addPenghargaan','AdminController@admin_add_penghargaan')->name('admin.addPenghargaan');
    Route::post('updatePenghargaan','AdminController@admin_update_penghargaan')->name('admin.updatePenghargaan');
    Route::delete('deletePenghargaan/{id}','AdminController@admin_delete_penghargaan');
    Route::get('data_penghargaan_datatables','AdminController@get_penghargaan');

    Route::get('manage_khazanah','AdminController@manageKhazanah')->name('admin.manage.khazanah');
    Route::get('data_khazanah_datatables','AdminController@get_khazanah');
    Route::post('addKhazanah','AdminController@addKhazanah')->name('admin.addKhazanah');
    Route::post('updateKhazanah','AdminController@admin_update_khazanah')->name('admin.updateKhazanah');
    Route::delete('deleteKhazanah/{id}','AdminController@admin_delete_khazanah');
    
    Route::get('/list_mutasi', 'AdminController@list_table_mutasi')->name('admin.list_mutasi');
    Route::get('/list_detail_mutasi/{id}', 'AdminController@detail_table_mutasi')->name('admin.list_detail_mutasi');

    Route::get('menu_teks', 'AdminController@show_menu_teks');
    Route::get('list_teks', 'AdminController@datatables_teks');
    Route::post('addTeks','AdminController@admin_add_teks')->name('admin.addTeks');
    Route::post('updateTeks','AdminController@admin_update_teks')->name('admin.updateTeks');
    Route::delete('deleteTeks/{id}','AdminController@admin_delete_teks');

    Route::get('menu_threshold', 'AdminController@show_menu_threshold');
    Route::get('list_threshold', 'AdminController@datatables_threshold');
    Route::post('addThreshold','AdminController@admin_add_threshold')->name('admin.addThreshold');
    Route::post('updateThreshold','AdminController@admin_update_threshold')->name('admin.updateThreshold');
    Route::delete('deleteThreshold/{id}','AdminController@admin_delete_threshold');

    Route::get('audit_trail', 'AdminController@show_menu_audit_trail');
    Route::get('list_audit_trail', 'AdminController@datatables_audit_trail');
    Route::get('RDLBank_transaction', 'AdminController@show_menu_RDLBank_transaction');
    Route::get('list_RDLBank_transaction', 'AdminController@datatables_RDLBank_transaction');

    Route::get('manage_cms', 'AdminController@show_manage_cms');
    Route::get('ManageTestimoniPendana', 'AdminController@ManageTestimoniPendana');
    Route::post('addTestimoni','AdminController@admin_add_testimoni')->name('admin.addTestimoni');
    Route::get('list_testimoni', 'AdminController@datatables_testimoni');
    Route::post('updateTestimoni','AdminController@admin_update_testimoni')->name('admin.updateTestimoni');
    Route::delete('deleteTestimoni/{id}','AdminController@admin_delete_testimoni');
    Route::get('ManageMediaOnline', 'AdminController@ManageMediaOnline');
    Route::post('addMediaOnline','AdminController@admin_add_media_online')->name('admin.addMediaOnline');
    Route::get('list_media_online', 'AdminController@datatables_media_online');
    Route::post('updateMediaOnline','AdminController@admin_update_media_online')->name('admin.updateMediaOnline');
    Route::delete('deleteMediaOnline/{id}','AdminController@admin_delete_media_online');
    Route::get('ManageInformasiPerusahaan', 'AdminController@ManageInformasiPerusahaan');
    Route::post('addCompany','AdminController@admin_add_company')->name('admin.addCompany');
    Route::get('list_company', 'AdminController@datatables_company');
    Route::post('updateCompany','AdminController@admin_update_company')->name('admin.updateCompany');
    Route::delete('deleteCompany/{id}','AdminController@admin_delete_company');
    Route::get('ManageDisclaimerOJK', 'AdminController@ManageDisclaimerOJK');
    Route::post('addDisclaimer','AdminController@admin_add_disclaimer')->name('admin.addDisclaimer');
    Route::get('list_disclaimer', 'AdminController@datatables_disclaimer');
    Route::post('updateDisclaimer','AdminController@admin_update_disclaimer')->name('admin.updateDisclaimer');
    Route::delete('deleteDisclaimer/{id}','AdminController@admin_delete_disclaimer');
    Route::get('ManageTermCondition', 'AdminController@ManageTermCondition');
    Route::post('addTermCondition','AdminController@admin_add_term_condition')->name('admin.addTermCondition');
    Route::get('list_termcondition', 'AdminController@datatables_termcondition');
    Route::post('updateTermCondition','AdminController@admin_update_term_condition')->name('admin.updateTermCondition');
    Route::delete('deleteTermCondition/{id}','AdminController@admin_delete_term_condition');
    Route::get('ManagePrivacyPolicy', 'AdminController@ManagePrivacyPolicy');
    Route::get('ManageFAQ', 'AdminController@ManageFAQ');
    Route::get('VerifikasiPembayaran', 'AdminController@VerifikasiPembayaran');
    
    Route::post('addPrivacy','AdminController@admin_add_privacy')->name('admin.addPrivacy');
    Route::get('list_privacy', 'AdminController@datatables_privacy');
    Route::post('updatePrivacy','AdminController@admin_update_privacy')->name('admin.updatePrivacy');
    Route::delete('deletePrivacy/{id}','AdminController@admin_delete_privacy');
    Route::post('uploadDokumen','AdminController@admin_upload_dokumen')->name('admin.uploadDokumen');
    Route::get('ListDokumen/{id}', 'AdminController@datatables_list_dokumen');
    Route::get('getDokumen/{id}', 'AdminController@admin_get_dokumen')->name('admin_getDokumen');
    
    Route::get('tarik_dana_pendana', 'AdminController@tarik_dana_investor');
    Route::get('/list_tarik_dana_investor', 'AdminController@list_tarik_dana_investor')->name('admin.list_tarik_dana_investor');
    Route::get('/list_detail_investor/{id}', 'AdminController@list_detail_investor')->name('admin.list_detail_investor');
    Route::get('tarik_dana/{id}','AdminController@tarik_dana')->name('admin.tarik_dana');
    
    Route::get('transfer_dana_pendana','AdminController@transfer_dana_pendana');
    Route::get('/list_transfer_dana_investor', 'AdminController@list_transfer_dana_investor')->name('admin.list_transfer_dana_investor');
    Route::get('/list_detail_transfer_investor/{id}', 'AdminController@list_detail_transfer_investor')->name('admin.list_detail_transfer_investor');
    Route::get('transfer_dana/{id}','AdminController@transfer_dana')->name('admin.transfer_dana');
    
    Route::post('uploadDokumenScoringPendanaan','AdminController@admin_upload_dokumen_scoring_pendanaan')->name('admin.uploadDokumenScoringPendanaan');
    Route::get('getDokumenScoring/{id}', 'AdminController@admin_get_dokumen_scoring')->name('admin_getDokumenScoring');
    Route::post('uploadDokumenScoringPersonal','AdminController@admin_upload_dokumen_scoring_personal')->name('admin.uploadDokumenScoringPersonal');
    Route::get('getDokumenScoringPersonal/{id}', 'AdminController@admin_get_dokumen_scoring_personal')->name('admin_getDokumenScoringPersonal');

    //imbal hasil
    Route::prefix('imbalhasil')->group( function(){
        Route::get('data_manage_payout','Admin\ImbalHasilAdminController@dashboard_generate')->name('datamanagepayout');;
        Route::get('imbalhasil_DaftarProyekReady','Admin\ImbalHasilAdminController@imbalhasil_DaftarProyekReady');
        Route::get('rekapImbal/{id}','Admin\ImbalHasilAdminController@generateImbalHasil');
        Route::get('daftarpayout/{id}','Admin\ImbalHasilAdminController@detil_daftarpayout');
        Route::post('payoutpendana','Admin\ImbalHasilAdminController@list_payout_pendana');
        Route::post('kirimimbal','Admin\ImbalHasilAdminController@kirim_imbal_hasil');
        Route::post('updateimbal','Admin\ImbalHasilAdminController@update_imbal_hasil');
        Route::get('payout7tdk/{id}','Admin\ImbalHasilAdminController@payout7harikedepan');
        Route::get('cetak_payout_mingguan/{id}','Admin\ImbalHasilAdminController@cetak_payout_mingguan');
        Route::get('cetak_data_payout/{id}','Admin\ImbalHasilAdminController@cetak_data_payout');
        Route::get('cetak_payout/{id}','Admin\ImbalHasilAdminController@cetak_payout');
    });
    
  
  
	// AFPI 
	Route::get('convertCSV_AFPI', 'RekeningController@convertCSV_AFPI');
	Route::get('generatePasswordZIP', 'RekeningController@generatePasswordZIP');
	
	// Borrower Start Here
    Route::prefix('borrower')->group( function(){
    
        
        Route::get('/testing','DigiSignController@testing');
        Route::get('/listBorrower','AdminController@listBorrower');
        Route::get('/detail_borrower/{brw_id}','AdminController@detailBorrower');
        
        Route::get('data_pendidikan', 'Admin\AdminClientController@DataPendidikan');
        Route::get('data_jenis_kelamin', 'Admin\AdminClientController@DataJenisKelamin');
        Route::get('data_agama', 'Admin\AdminClientController@DataAgama');
        Route::get('data_nikah', 'Admin\AdminClientController@DataNikah');
        Route::get('data_provinsi', 'Admin\AdminClientController@DataProvinsi');
        Route::get('data_kota/{kota}', 'Admin\AdminClientController@DataKota');
        Route::get('ganti_kota/{kota}', 'Admin\AdminClientController@GantiDataKota');
        Route::get('data_bank', 'Admin\AdminClientController@DataBank');
        Route::get('data_pekerjaan', 'Admin\AdminClientController@DataPekerjaan');
        Route::get('data_bidang_pekerjaan', 'Admin\AdminClientController@DataBidangPekerjaan');
        Route::get('data_bidang_online', 'Admin\AdminClientController@DataBidangOnline');
        Route::get('data_pengalaman', 'Admin\AdminClientController@DataPengalaman');
        Route::get('data_pendapatan', 'Admin\AdminClientController@DataPendapatan');
        
        Route::get('show/{id}','DigiSignController@show');
        Route::get('list_pendanaan_borrower/{id}','AdminController@list_pendanaan_borrower');
        //Route::get('regDigiSignborrower/{id}','DigiSignController@registerDigiSignBorrower');
        //Route::get('regDigiSignborrower/{id}','DigiSignController@registerDigiSignBorrower');
        Route::get('sendDigiSign/{id}/{id_proyek}','DigiSignController@sendDigiSignBorrower');
        Route::get('sendDigiSignWakalah/{id}/{id_proyek}','DigiSignController@sendDocWakalahBorrower');
        Route::get('signDigiSign/{id}','DigiSignController@signDigiSignBorrower');
        //Route::get('sendDigiSignBorrower/{id}/{id_proyek}','DigiSignController@sendDigiSignBorrower');
        //Route::get('signDigiSignBorrower/{id}','DigiSignController@signDigiSignBorrower');
        //Route::post('downloadDigiSignBorrower','DigiSignController@downloadDigiSignBorrower');
        //Route::post('downloadBase64DigiSignBorrower','DigiSignController@downloadBase64DigiSignBorrower');
        Route::get('ListTableApproveDana/','AdminController@ListTableApproveDana'); // view
        Route::get('ListApproveDana/','AdminController@listApproveDana'); // data
        Route::post('prosesCairDana','AdminController@prosesCairDana'); // proses cair dana borrower
        Route::post('inquiryTransfer','AdminController@inquiryTransfer'); // inquiryTransfer
        Route::post('executeTransfer','AdminController@executeTransfer'); // executeTransfer

        //Route::post('callbackDigiSignBorrower','DigiSignController@callbackRegisterBorrower');
        Route::get('createDocDigisignBorrowerIndividu/{id}/{id_proyek}','DigiSignController@createDocBorrower_Individu');
        Route::get('createDocDigisignBorrowerPerusahaan/{id}/{id_proyek}','DigiSignController@createDocBorrower_Perusahaan');
        
        Route::post('edit_poto_1/', 'AdminController@edit_poto_1')->name('borrower.edit_poto_1');
        Route::post('edit_poto_2/{brw_id}', 'AdminController@edit_poto_2')->name('borrower.edit_poto_2');
        Route::post('edit_poto_3/{brw_id}', 'AdminController@edit_poto_3')->name('borrower.edit_poto_3');
        Route::post('edit_poto_4/{brw_id}', 'AdminController@edit_poto_4')->name('borrower.edit_poto_4');
        
        Route::post('update_borrower', 'AdminController@update_borrower')->name('borrower.update_borrower');
        Route::get('searchPefindo/{idborrower}', 'PefindoController@SmartSearch');
        
        // Client Side Borrower
        Route::prefix('client')->group( function(){
            
            // Client Side View Page Jenis Pendanaan
            Route::get('/data_borrower','Admin\AdminClientController@getDataBorrower');
            Route::get('/managePendanaanBorower','AdminController@managePendanaanBorower');
            Route::get('/scorringBorrower','AdminController@manageScorringBorower');
            // Route::get('/manageKelengkapanBorrower','AdminController@manageKelengkapanBorrower');
            
            Route::get('/getTableJenisBorrower','Admin\AdminClientController@getTableJenisBorrower');
            Route::get('/tableGetBorrower','Admin\AdminClientController@tableGetBorrower');
            Route::get('/getDetailsBorrower/{borrower_id}','Admin\AdminClientController@getDetailsBorrower');
        
      });

      // Client Prosess Borrower
      Route::prefix('prosess')->group( function(){
        // Jenis Pendanaan
        Route::post('/postNewJenis','Admin\AdminProsessController@postNewJenis');
        Route::post('/updateJenis','Admin\AdminProsessController@updateJenis'); 
        Route::get('/deleteJenis/{id}','Admin\AdminProsessController@deleteJenis');

        Route::get('/getListJenis/{id}','Admin\AdminProsessController@getListJenis');
        Route::get('/getListJenis_2/{id}','Admin\AdminProsessController@getListJenisA');
        Route::get('/getListJenis_3/{id}','Admin\AdminProsessController@getListJenisB');
        Route::post('/addJenisList','Admin\AdminProsessController@addJenisList');

        Route::post('/postScorringBorrower','Admin\AdminProsessController@postScorringBorrower');
        Route::post('/rejectScorringBorrower','Admin\AdminProsessController@rejectScorringBorrower');
      });

    });

    
    Route::prefix('investor')->group(function(){
        Route::get('verifikasi', 'InvestorController@admin_verif')->name('admin.investor.verif');
        Route::get('mutasi', 'InvestorController@admin_mutasi')->name('admin.investor.mutasi');
        Route::post('addPendanaan', 'InvestorController@admin_add_pendanaan')->name('admin.pendanaan');
        Route::post('hapusPendanaan', 'InvestorController@admin_hapus_pendanaan')->name('admin.hapusPendanaan');
        Route::get('manage', 'InvestorController@admin_manage')->name('admin.investor.manage');
        Route::get('export_pendanaan_aktif', 'InvestorController@export_pendanaan_aktif')->name('admin.investor.export_pendanaan_aktif');
        Route::get('request_withdraw', 'InvestorController@admin_requestwithdraw')->name('admin.investor.requestwithdraw');
        Route::get('paid_withdraw', 'InvestorController@admin_paidwithdraw')->name('admin.investor.paidwithdraw');
        Route::get('failed_withdraw', 'InvestorController@admin_failedwithdraw')->name('admin.investor.failedwithdraw');
        Route::post('verifikasi_ok', 'InvestorController@admin_verif_ok')->name('admin.investor.verif.ok');
        Route::post('verifikasi_fail', 'InvestorController@admin_verif_fail')->name('admin.investor.verif.fail');
        Route::post('withdraw_ok', 'InvestorController@admin_withdraw_ok')->name('admin.investor.withdraw.ok');
        Route::post('withdraw_fail', 'InvestorController@admin_withdraw_fail')->name('admin.investor.withdraw.fail');
        Route::post('create','InvestorController@admin_create_investor')->name('admin.investor.create');
        Route::post('update', 'InvestorController@admin_update_investor')->name('admin.investor.update');
        Route::post('changepass', 'InvestorController@admin_changepass_investor')->name('admin.investor.changepassword');
        Route::post('changestatus', 'InvestorController@admin_changestatus_investor')->name('admin.investor.changestatus');
        Route::post('delete', 'InvestorController@admin_delete_investor')->name('admin.investor.delete');
        Route::post('pendanaan/create', 'InvestorController@admin_pendanaan_create')->name('admin.investor.pendanaan.create');
        Route::post('addVA', 'InvestorController@admin_add_va')->name('admin.addVA');
        Route::post('minusDana', 'InvestorController@admin_minus_dana')->name('admin.minusDana');
        Route::post('nama_autocomplete','InvestorController@get_nama_autocomplete');
        Route::post('data','InvestorController@data_investor');
        Route::get('data_investor_datatables/{nama}','InvestorController@get_investor_datatables');
        Route::post('data_mutasi_datatables','InvestorController@get_mutasi_datatables');
        Route::get('data_mutasi_proyek/{id}','InvestorController@get_mutasi_proyek');
        Route::get('data_detil_mutasi_proyek/{id}','InvestorController@get_detil_mutasi_proyek');
        
        Route::get('data_verifikasi_datatables','InvestorController@get_verifikasi_datatables');
        Route::get('data_riwayat_mutasi/{id}','InvestorController@get_riwayat_mutasi');
        Route::get('data_riwayat_mutasi_date/{id}/{tgl_mulai}/{tgl_selesai}','InvestorController@get_riwayat_mutasi_date');
        Route::get('data_detil_investor/{id}','InvestorController@get_detil_investor');
        Route::get('data_detil_pendanaan/{id}','InvestorController@get_detil_pendanaan');
        Route::get('data_proyek/{id}','InvestorController@get_proyek_datatables');
        Route::get('data_req','InvestorController@get_req_penarikan_dana_datatables');
        Route::post('data_paid','InvestorController@get_paid_penarikan_dana_datatables');
        Route::post('data_fail','InvestorController@get_fail_penarikan_dana_datatables');
        Route::post('edit_pendanaan_investor','InvestorController@admin_edit_nominal_pendanaan')->name('admin.investor.edit_pendanaan_investor');
        Route::post('edit_pendanaan_selesai_investor','InvestorController@admin_edit_nominal_pendanaan_selesai')->name('admin.investor.edit_pendanaan_selesai_investor');

        Route::get('regDigiSign/{id}','DigiSignController@registerDigiSignInvestor');
        Route::get('sendDigiSign/{id}','DigiSignController@sendDigiSignInvestor');
        Route::get('signDigiSign/{id}','DigiSignController@signDigiSignInvestor');

        Route::post('callbackDigiSignInvestor','DigiSignController@callbackRegisterInvestor');
        Route::get('createDocDigisign/{id}','DigiSignController@createDocInvestor');
        Route::post('logAkadInvestor','UserController@logAkadDigiSignInvestor');
    });



    Route::prefix('proyek')->group(function(){
        Route::get('create','ProyekController@admin_create')->name('admin.proyek.create');
        Route::get('manage', 'ProyekController@admin_manage')->name('admin.proyek.manage');
        Route::get('download_all','ProyekController@download_all')->name('admin.proyek.download');
        Route::get('manage_proyek', 'ProyekController@admin_get_manage');
        Route::get('manage_detil_proyek/{id}','ProyekController@admin_detil_manage');
        Route::get('manage_progres_proyek/{id}','ProyekController@admin_progres_manage');

        // payout
        Route::get('admin_get_manage_imbal','ProyekController@admin_get_manage_imbal');
        Route::get('detil_payout/{id}','ProyekController@detil_payout');
        Route::get('manage_payout_data','ProyekController@manage_payout_data')->name('admin.proyek.manage_payout_data');
        Route::get('cetak_payout_mingguan/{id}','ProyekController@cetak_payout_mingguan')->name('admin.proyek.cetak_payout_mingguan');
        Route::get('manage_detil_payout/{id}','ProyekController@admin_detil_payout');
        Route::get('detil_payout_user/{id}','ProyekController@detil_payout_user');
        Route::post('manage_payout/{id}','ProyekController@manage_payout');
        Route::post('kirim_imbal_hasil','ProyekController@kirim_imbal_hasil');
        Route::post('update_imbal_hasil','ProyekController@update_imbal_hasil');
        Route::post('change_status_return','ProyekController@change_status_return');
        Route::post('detil_month_payout','ProyekController@detil_month_payout');
        Route::post('keterangan_libur','ProyekController@keterangan_libur');
        Route::get('payout7tdk/{id}','ProyekController@payout7harikedepan');

        
        Route::post('cetak_data_payout','ProyekController@cetak_data_payout');
        // add eksport mutasi
        Route::get('mutasi', 'ProyekController@admin_mutasi')->name('admin.proyek.mutasi');
        Route::get('mutasi_investor_proyek/{id}','ProyekController@mutasi_investor_proyek')->name('admin.proyek.mutasi_investor_proyek');
        
        // add manage filter proyek
        Route::get('proyek_eksport_manage','ProyekController@proyek_eksport_view')->name('admin.proyek.proyek_eksport_manage');
        Route::get('get_export_by_proyek','ProyekController@get_export_by_proyek')->name('admin.proyek.get_export_by_proyek');
        

        Route::post('create', 'ProyekController@admin_create_post')->name('admin.proyek.create.post');
        Route::post('update', 'ProyekController@admin_update_post')->name('admin.proyek.update.post');
        Route::post('progress', 'ProyekController@admin_progress_post')->name('admin.proyek.progress.post');
        Route::get('deletegambar/{id}', 'ProyekController@admin_delete_gambarProyek')->name('admin.proyek.delete');
        Route::get('finish_proyek', 'ProyekController@admin_proyek_finish')->name('admin.proyek.finish');
        Route::get('finish7tdk/{id}', 'ProyekController@finish7harikedepan')->name('admin.proyek.finish7tdk');
        Route::get('get_finish_proyek_datatables', 'ProyekController@get_data_finish_proyek');
        Route::get('get_data_list_investor/{id}', 'ProyekController@get_data_list_investor');
        Route::post('dana_kembali', 'ProyekController@dana_kembali');
        
        Route::post('hari_libur', 'ProyekController@hari_libur');
        Route::get('sendDocDigisignRevisi/{investor_id}/{proyek_id}','DigiSignController@sendDocInvestorBorrower');
    });

    Route::prefix('marketer')->group(function(){
        Route::get('mutasi', 'MarketerController@admin_mutasi')->name('admin.marketer.mutasi');
        Route::post('mutasi', 'MarketerController@admin_mutasi_create')->name('admin.marketer.mutasi.create');
        Route::get('manage', 'MarketerController@admin_manage')->name('admin.marketer.manage');
        Route::post('create', 'MarketerController@admin_create_post')->name('admin.marketer.create');
        Route::post('delete', 'MarketerController@admin_delete_post')->name('admin.marketer.delete');
        Route::post('changepass', 'MarketerController@admin_changepass_post')->name('admin.marketer.changepass');
        Route::post('update', 'MarketerController@admin_update_post')->name('admin.marketer.update');
        Route::get('data_marketer_datatables','MarketerController@get_marketer_datatables');
        Route::get('data_mutasi_marketer/{id}','MarketerController@get_mutasi_marketer');
        Route::get('data_investor_marketer/{id}','MarketerController@get_investor_marketer');
    });

    Route::prefix('messagging')->group(function() {
        Route::get('broadcast', 'AdminController@showBroadcastForm')->name('admin.broadcast');
        Route::get('send_mail', 'AdminController@showSingleMail')->name('admin.singleMail');
        Route::get('list_group','AdminController@CreateListGroup')->name('admin.listGroup');

        Route::post('listNew','AdminController@listNew');
        Route::post('sendBroadcast', 'AdminController@broadcastEmail')->name('sendBroadcast');
        Route::post('createList','AdminController@postList');
        Route::post('sendmail', 'AdminController@sendSingleMail')->name('sendMail');
        Route::post('data_email_datatables', 'AdminController@get_email_datatables');
    });

    Route::prefix('news')->group(function(){
        Route::get('/', 'AdminController@showNews')->name('admin.news');
        Route::post('postNews', 'AdminController@postNews')->name('admin.postNews');
        Route::get('list', 'AdminController@listNews')->name('admin.listNews');
        Route::post('delete', 'AdminController@deleteNews')->name('admin.deleteNews');
        Route::post('update', 'AdminController@updateNews')->name('admin.updateNews');
    });

    Route::prefix('SyaratKetentuan')->group(function(){
        Route::get('/', 'AdminController@showaddSyaratKetentuan')->name('admin.SyaratKetentuan');
        Route::get('list', 'AdminController@listSyaratKetentuan')->name('admin.listSyaratKetentuan');
        Route::post('postSyaratKetentuan', 'AdminController@postSyaratKetentuan')->name('admin.postSyaratKetentuan');
        Route::post('delete', 'AdminController@deleteSyaratKetentuan')->name('admin.deleteSyaratKetentuan');
        Route::post('update', 'AdminController@updateSyaratKetentuan')->name('admin.updateSyaratKetentuan');
    });
    


});


//end of admin route