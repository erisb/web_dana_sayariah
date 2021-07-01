<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Borrower;
use App\Message;
use App\Jobs\ProcessEmail;
use App\Jobs\ProcessEmailBorrower;
use App\Investor;
use App\Proyek;
use App\ManagePenghargaan;
use App\ManageKhazanah;
use App\News;
use App\Mail\EmailAktifasiPendana;
use App\Mail\EmailAktifasiPenerimaPendanaan;
use Mail;

class StaticPageController extends Controller
{
    // fungsi menampilkan halaman khazanah
    public function khazanah(){
        $data = ManageKhazanah::all();

        return view('pages.guest.khazanah',compact('data'));
    }
    // fungsi menampilkan halaman timkami
    public function timKami(){
        $proyeks = ManagePenghargaan::all();
        return view('pages.guest.tim_kami', compact('proyeks'));
    }
    //fungsi menampilkan halaman kontak
    public function kontak(){
        return view('pages.guest.kontak');
    }
    public function kalkulator(){
        return view('pages.guest.kalkulator');
    }
    public function get_data_kal($id){
        
        $proyek = Proyek::where('status',1)->get();
        // echo $proyek;die;
        $response = ['datakal' => $proyek];

        return response()->json($response);
    }
    public function tataCaraPendana(){
        return view('pages.guest.tatacara_pendana');
    }
    public function tataCaraPenerima(){
        return view('pages.guest.tatacara_penerima');
    }
    public function tataCaraPengaduan(){
        return view('pages.guest.pengaduan');
    }
    public function modalusahaProperty(){
        return view('pages.guest.modal_usaha_property');
    }
    public function faq()
    {
        return view('pages.guest.faq');
    }
    public function forgotpassword(){
        return view('pages.guest.forgotpassword');
    }
    public function message(Request $request){

        $message = new Message;
        $message->name = $request->name;
        $message->email = $request->email;
        $message->subject = $request->subject;
        $message->number = $request->phone;
        $message->message = $request->message;

        $message->save();


        return view('pages.guest.kontak')->with('status', 'Pesan sudah terkirim, silahkan tunggu balasan dari Dana Syariah Indonesia');
    }

    public function termcondition(){
        return view('pages.guest.termcondition');
    }

    public function privacypolicy() {
        return view('pages.guest.privacypolicy');
    }

    public function resendMailPost(Request $req){
        $email = $req->email;
        
        $user = Investor::where('email', $email)->first();
        $isiEmail = new EmailAktifasiPendana($user);
        Mail::to($email)->send($isiEmail);

        return redirect('/resendMail')->with('email',$email);
    }

    public function resendMailPostborrower(Request $req){
        $email = $req->email;

        $user = Borrower::where('email', $email)->first();
        $isiEmail = new EmailAktifasiPenerimaPendanaan($user->username,$user->email,$user->email_verif);
        Mail::to($email)->send($isiEmail);
        // dispatch(new ProcessEmailBorrower($user['username'], $user['email'], $user['email_verif'], 'regis'));

        return redirect('/resendMailborrower')->with('email',$email);

    }

    public function all_news(){

        $all_news = News::orderBy('id','desc')->paginate(6);

        return view('pages.guest.news',['all_news' => $all_news]);
    }

    public function news_detil($id){
        
        $news_detil = News::where('id',$id)->first();

        $news_others = News::whereNotIn('id',[$id])->orderBy('id','desc')->limit(3)->get();

        return view('pages.guest.news_detail',['news_detil' => $news_detil, 'news_others' => $news_others]);
    }
}

