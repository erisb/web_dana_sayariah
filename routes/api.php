<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API notif midtrans
// Route::post('notif', 'UserController@notificationHandler');
// end


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('digiSign/redirectAktifasi','DigiSignController@redirectDigisignAktifasi');

Route::get('digiSign/redirectSign','DigiSignController@redirectDigisignSign');

Route::post('/bni/callback','RekeningController@bankResponse');
Route::post('/bni_konven/callback','RekeningController@bankResponseKonven');
// Route::post('/bni/enkripsi','RekeningController@enkripsi');
// Route::get('/msgVerification','RekeningController@msgVerification');
// route::get('/testing', 'RekeningController@testing');
Route::get('/test',function(){
    return 'API SUCCESS';
});

// Route::prefix('auth')->group(function() {
//     Route::post('/login', 'Mobile\Auth\ApiAuthController@login');
//     Route::post('/logout', 'Mobile\Auth\ApiAuthController@logout');
//     Route::post('/refresh', 'Mobile\Auth\ApiAuthController@refresh');
//     Route::post('/check', 'Mobile\Auth\ApiAuthController@checkToken');
//     Route::post('/register', 'Mobile\Auth\ApiAuthController@register');
//     Route::post('/datafill', 'Mobile\Auth\ApiAuthController@datafill');
// });

Route::prefix('newAuth')->group(function() {
    Route::post('/login', 'Mobile\Auth\NewApiAuthController@login');
    Route::post('/logout', 'Mobile\Auth\NewApiAuthController@logout');
    Route::post('/refresh', 'Mobile\Auth\NewApiAuthController@refresh');
    Route::post('/check', 'Mobile\Auth\NewApiAuthController@checkToken');
    Route::post('/newCheck', 'Mobile\Auth\NewApiAuthController@newCheckToken');
    Route::post('/newnewCheck', 'Mobile\Auth\NewApiAuthController@newnewCheckToken');
    Route::post('/register', 'Mobile\Auth\NewApiAuthController@register');
    Route::post('/register_new', 'Mobile\Auth\NewApiAuthController@register_new');
    Route::post('/register_new_new', 'Mobile\Auth\NewApiAuthController@register_new_new');
    Route::post('/datafill', 'Mobile\Auth\NewApiAuthController@datafill');
    Route::post('/datafillNew', 'Mobile\Auth\NewApiAuthController@datafillNew');
    Route::post('/datafillNewNew', 'Mobile\Auth\NewApiAuthController@datafillNewNew');
    Route::post('/datafillNewNewNew', 'Mobile\Auth\NewApiAuthController@datafillNewNewNew');
    Route::post('/datafillNewNewNewNew', 'Mobile\Auth\NewApiAuthController@datafillNewNewNewNew');
    Route::post('/datafillNewNewNewNewNew', 'Mobile\Auth\NewApiAuthController@datafillNewNewNewNewNew');
    Route::post('/datafillNewNewNewNewNewNew', 'Mobile\Auth\NewApiAuthController@datafillNewNewNewNewNewNew');
    Route::post('/datafillbaru', 'Mobile\Auth\NewApiAuthController@datafillbaru');
    Route::post('/datafillbaruVAkonv', 'Mobile\Auth\NewApiAuthController@datafillbaru_VA_konv');
    Route::post('/upload1', 'Mobile\Auth\NewApiAuthController@actionUpload1');
    Route::post('/upload2', 'Mobile\Auth\NewApiAuthController@actionUpload2');
    Route::post('/upload3', 'Mobile\Auth\NewApiAuthController@actionUpload3');
    Route::post('/upload1new', 'Mobile\Auth\NewApiAuthController@actionUpload1new');
    Route::post('/upload2new', 'Mobile\Auth\NewApiAuthController@actionUpload2new');
    Route::post('/upload3new', 'Mobile\Auth\NewApiAuthController@actionUpload3new');
    Route::post('/upload1newnew', 'Mobile\Auth\NewApiAuthController@actionUpload1newnew');
    Route::post('/upload2newnew', 'Mobile\Auth\NewApiAuthController@actionUpload2newnew');
    Route::post('/upload3newnew', 'Mobile\Auth\NewApiAuthController@actionUpload3newnew');
    Route::post('/verificationCode', 'Mobile\Auth\NewApiAuthController@verificationCode');
    Route::get('/checkVersion', 'Mobile\Auth\NewApiAuthController@checkVersion');
    Route::post('/checkPhoneNumber', 'Mobile\Auth\NewApiAuthController@checkPhoneNumber');
    Route::post('/verificationOtp', 'Mobile\Auth\NewApiAuthController@verificationOtp');
    Route::post('/validateOTP', 'Mobile\Auth\NewApiAuthController@validateOTP');
    Route::post('/resendEmail', 'Mobile\Auth\NewApiAuthController@resendEmail');
    Route::post('/termCondition', 'Mobile\Auth\NewApiAuthController@getTermCondition');
});

// Route::prefix('proyek')->group(function(){ 
//     Route::post('/list', 'Mobile\ProyekController@proyek');
//     Route::post('/detil', 'Mobile\ProyekController@detil_proyek');
//     Route::post('/checkout', 'Mobile\ProyekController@checkout');
//     Route::post('/cart', 'Mobile\ProyekController@cart');
// });

Route::prefix('newProyek')->group(function(){ 
    Route::post('/list', 'Mobile\NewProyekController@proyek');
    Route::post('/listAll', 'Mobile\NewProyekController@proyekAll');
    Route::post('/detil', 'Mobile\NewProyekController@detil_proyek');
    Route::post('/checkout', 'Mobile\NewProyekController@checkout');
    Route::post('/checkout_new', 'Mobile\NewProyekController@checkout_new');
    Route::post('/checkout_new_new', 'Mobile\NewProyekController@checkout_new_new');
    Route::post('/cart', 'Mobile\NewProyekController@cart');
    Route::post('/total-penarikan', 'Mobile\NewProyekController@totalPenarikan');
    Route::post('/selectedProject', 'Mobile\NewProyekController@selectedProject');
    Route::post('/showSelectedProject', 'Mobile\NewProyekController@showSelectedProject');
    Route::post('/deleteSelectedProject', 'Mobile\NewProyekController@deleteSelectedProject');

    Route::post('/updatePaket', 'Mobile\NewProyekController@updatePaket');

});

Route::prefix('newSimulation')->group(function(){ 
    Route::post('/listAll', 'Mobile\NewProyekController@simulationAll');
});

Route::prefix('pendanaan')->group(function(){
    Route::post('/list', 'Mobile\PendanaanController@showPendanaan');
    Route::post('/tambah-pendanaan', 'Mobile\PendanaanController@tambahPendanaan');
    Route::post('/ambil-pendanaan', 'Mobile\PendanaanController@ambilPendanaan');
    // Route::post('/subscribe', 'Mobile\PendanaanController@subscribe');
    // Route::post('/unsubscribe', 'Mobile\PendanaanController@unsubscribe');
    Route::post('/progress', 'Mobile\PendanaanController@detilProgress');
});

Route::prefix('newPendanaan')->group(function(){
    Route::post('/list', 'Mobile\NewPendanaanController@showPendanaan');
    Route::post('/listKelolaInvestasi', 'Mobile\NewPendanaanController@showPendanaanKelolaInvestasi');
    Route::post('/listKelolaInvestasiNew', 'Mobile\NewPendanaanController@showPendanaanKelolaInvestasiNew');
    Route::post('/listKelolaInvestasiNewNew', 'Mobile\NewPendanaanController@showPendanaanKelolaInvestasiNewNew');
    Route::post('/checkValidation', 'Mobile\NewPendanaanController@checkValidation');
    Route::post('/tambah-pendanaan', 'Mobile\NewPendanaanController@tambahPendanaan');
    Route::post('/ambil-pendanaan', 'Mobile\NewPendanaanController@ambilPendanaan');
    // Route::post('/subscribe', 'Mobile\PendanaanController@subscribe');
    // Route::post('/unsubscribe', 'Mobile\PendanaanController@unsubscribe');
    Route::post('/progress', 'Mobile\NewPendanaanController@detilProgress');
    Route::post('/cekAkadMurobahah','Mobile\NewPendanaanController@cek_akad_murobahah');
    Route::post('/cekRegDigisign','Mobile\NewPendanaanController@cek_reg_digisign');

});

// Route::prefix('profile')->group(function(){
//     Route::post('/show', 'Mobile\ProfileController@showProfile');
//     Route::post('/update', 'Mobile\ProfileController@updateProfile');
//     Route::post('/change-pass', 'Mobile\ProfileController@changePassword');
//     Route::post('/home', 'Mobile\ProfileController@home');
//     Route::post('/main', 'Mobile\ProfileController@mainProfile');
//     Route::post('/showva', 'Mobile\ProfileController@showVa');
// });

Route::prefix('newProfile')->group(function(){
    Route::post('/show', 'Mobile\NewProfileController@showProfile');
    Route::post('/showBaru', 'Mobile\NewProfileController@showProfileBaru');

    Route::post('/update', 'Mobile\NewProfileController@updateProfile');
    Route::post('/updateNew', 'Mobile\NewProfileController@updateProfileNew');
    Route::post('/updateProfileBaru', 'Mobile\NewProfileController@updateProfileBaru');
    Route::post('/change-pass', 'Mobile\NewProfileController@changePassword');
    Route::post('/home', 'Mobile\NewProfileController@home');
    Route::post('/homeLogin', 'Mobile\NewProfileController@homeLogin');
    Route::post('/showva', 'Mobile\NewProfileController@showVa');
    Route::post('/allMaster', 'Mobile\NewProfileController@allMaster');
    Route::post('/allMasterBaru', 'Mobile\NewProfileController@allMasterBaru');
    
    Route::post('/allProfile', 'Mobile\NewProfileController@allProfile');
    Route::post('/allProfileSertifikat', 'Mobile\NewProfileController@allProfileSertifikat');
    Route::post('/newallProfileSertifikat', 'Mobile\NewProfileController@newallProfileSertifikat');
    Route::post('/newnewallProfileSertifikat', 'Mobile\NewProfileController@newnewallProfileSertifikat');
    Route::post('/upload1', 'Mobile\NewProfileController@actionUpload1');
    Route::post('/upload2', 'Mobile\NewProfileController@actionUpload2');
    Route::post('/upload3', 'Mobile\NewProfileController@actionUpload3');
    Route::post('/upload1new', 'Mobile\NewProfileController@actionUpload1new');
    Route::post('/upload2new', 'Mobile\NewProfileController@actionUpload2new');
    Route::post('/upload3new', 'Mobile\NewProfileController@actionUpload3new');
    Route::post('/get_aktif_dana', 'Mobile\NewProfileController@get_aktif_dana');
    Route::post('/ListProyekFunded', 'Mobile\NewProfileController@list_proyek_funded');
    Route::post('/all_imbal', 'Mobile\NewProfileController@all_imbal');
    Route::post('/cekDanaTeralokasi', 'Mobile\NewProfileController@cek_dana_teralokasi');
    Route::post('/registerRDLInvestor', 'Mobile\NewProfileController@registerRDLInvestor');
    Route::post('/generarteVAkonv', 'Mobile\NewProfileController@generateVA_BNI_konv');

    Route::post('/registerAccountNumberInvestor', 'Mobile\NewProfileController@registerAccountNumberInvestor');
    Route::post('/newnewallProfileSertifikatBaru', 'Mobile\NewProfileController@newnewallProfileSertifikatBaru');

    //DIGISIGN MOBILE
    
    //REGISTRASI DAN AKTIVIASI AKUN DIGISIGN
    Route::post('/statusRegDigisign', 'Mobile\NewProyekController@statusRegDigisign');
    Route::post('/registerAkad', 'Mobile\NewProfileController@register_akad');
    Route::post('/callbackDigiSignInvestor','Mobile\NewProfileController@callbackRegisterInvestor');
    Route::post('/actDigiSign','Mobile\NewProfileController@actDigiSign');
    Route::post('/getIdLog','Mobile\NewProfileController@get_id_log');


    //TTD DAN DOWNLOAD AKAD INVESTOR - DSI
    Route::post('/signDigiSign','Mobile\NewProfileController@signDigiSign');
    Route::post('/signDigiSignInvestorBorrower','Mobile\NewProfileController@signDigiSignInvestorBorrower');
    Route::post('/sendDocDigiSignInvestorBorrower','Mobile\NewProfileController@sendDocDigiSignInvestorBorrower');
    Route::post('/createDocDigiSignInvestorBorrower','Mobile\NewProfileController@createDocDigiSignInvestorBorrower');
    Route::post('/sendDigiSignawal','Mobile\NewProfileController@sendDigiSignawal');
    Route::post('/downloadDigiSign','Mobile\NewProfileController@downloadDigiSignInvestor');
    Route::post('/convertBase64','Mobile\NewProfileController@convertBase64');
    Route::post('/convertBase64Murobahah','Mobile\NewProfileController@convertBase64Murobahah');
    Route::post('/signDigiSignMurobahah','Mobile\NewProfileController@signDigiSignMurobahah');
    Route::post('/downloadBase64DigiSignMurobahah','Mobile\NewProfileController@downloadBase64DigiSignMurobahah');
    Route::post('/logAkad', 'Mobile\NewProfileController@logAkad');
    Route::post('/downloadAkad', 'Mobile\NewProfileController@downloadAkad');

});

// Route::prefix('rekening')->group(function(){
//     Route::post('/mutasi', 'Mobile\RekeningController@listMutasi');
//     Route::post('/showPenarikan', 'Mobile\RekeningController@showPenarikan');
//     Route::post('/requestPenarikan', 'Mobile\RekeningController@requestPenarikan');
// });

Route::prefix('newRekening')->group(function(){
    Route::post('/mutasi', 'Mobile\NewRekeningController@listMutasi');
    Route::post('/showPenarikan', 'Mobile\NewRekeningController@showPenarikan');
    Route::post('/requestPenarikan', 'Mobile\NewRekeningController@requestPenarikan');
    Route::post('/verificationCode', 'Mobile\NewRekeningController@verificationCode');
    Route::post('/sendVerifikasi', 'Mobile\NewRekeningController@sendVerifikasi');
    Route::post('/checkUploadFoto', 'Mobile\NewRekeningController@checkUploadFoto');
    Route::post('/historyPenarikanDana', 'Mobile\NewRekeningController@historyPenarikanDana');

    Route::post('/downloadSertifikat', 'Mobile\NewRekeningController@sertifikat');
    Route::post('/cekSertifikat', 'Mobile\NewRekeningController@cekSertifikat');
});

Route::prefix('news')->group(function() {
    Route::post('/get', 'Mobile\NewsController@getNews');
    Route::post('/detil', 'Mobile\NewsController@getDetil');
});

Route::post('/tes', 'Mobile\RekeningController@encrypt');



  // Start Group Prefix Borrower
  Route::prefix('brw_prosess')->group( function(){
    Route::get('/getDataTable','Admin\AdminProsessController@getDataTable');
  });
  // End Group Borrower Prefix

  
  // Start Group Prosess Borrower
  // Route::prefix('brw_prosess')->group( function(){
  //   Route::get('/getDataTable','Admin\AdminProsessController@getDataTable');
  // });
  // Route::prefix('borrower')->group( function(){
  //   Route::get('/result_client','Admin\AdminClientController@manageTablePendanaan');
  //   Route::get('/postJenisPendanaan','Admin\AdminDataController@postJenisPendanaan');
  // });
  // End Group Prosess Borrower


