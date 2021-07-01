@component('component.mail')
    
    @slot('perihal')
        Email Aktifasi
    @endslot
    @slot('content')
        <p>Terimakasih telah bergabung dan terus maju bersama danasyariah yang selalu terpercaya sebagai platform pendanaan yang sangat terpercaya</p>
        <p>Akun : <b>{{$data['username']}}</b> </p>
        <p>Silahkan klik link dibawah untuk aktifasi akun anda.</p>

        {{-- <a href="www.danasyariah.id/user/confirm-email/{{$data->email_verif}}/{{$data->username}}">
            Konfirmasi email saya 
        </a> --}}
        {{-- <a href="{{secure_url('user/confirm-email')}}/{{$data->email_verif}}/{{$data->username}}">
            Konfirmasi email saya 
        </a> --}}
    {{-- @if(Config::get('app.env') == 'local') --}}
        {{-- <a href="{{('https://www.danasyariah.id')}}/{{('user/confirm-email')}}/{{$data->email_verif}}/{{$data->username}}"> --}}
        {{-- <a href="{{('http://127.0.0.1:8000')}}/{{('borrower/confirm-email')}}/{{$data['email_verif']}}/{{$data['username']}}"> --}}
        {{-- <a href="{{('http://core.danasyariah.id')}}/{{('borrower/confirm-email')}}/{{$data['email_verif']}}/{{$data['username']}}">
            Konfirmasi email saya 
        </a>
        <p>(jika tidak bisa di klik silahkan copy link berikut pada browser anda) : </p> --}}
        {{-- <p>www.danasyariah.id/user/confirm-email/{{$data->email_verif}}/{{$data->username}}</p> --}}
        {{-- <p>{{secure_url('borrower/confirm-email')}}/{{$data['email_verif']}}/{{$data['username']}}</p> --}}
        {{-- <p>{{('http://core.danasyariah.id')}}/{{('borrower/confirm-email')}}/{{$data['email_verif']}}/{{$data['username']}}</p> --}}
        {{-- <a href="{{('http://core.danasyariah.id')}}/{{('borrower/confirm-email')}}/{{$data['email_verif']}}/{{$data['username']}}"> --}}
    {{-- @else --}}
        <a href="{{config('app.url')}}/{{('borrower/confirm-email')}}/{{$data['email_verif']}}">
            Aktifasi Akun saya 
        </a>
        <p>(jika tidak bisa di klik silahkan copy link berikut pada browser anda) : </p>
        {{-- <p>www.danasyariah.id/user/confirm-email/{{$data->email_verif}}/{{$data->username}}</p> --}}
        {{-- <p>{{secure_url('user/confirm-email')}}/{{$data->email_verif}}/{{$data->username}}</p> --}}
        <p>{{config('app.url')}}/{{('borrower/confirm-email')}}/{{$data['email_verif']}}</p> 
    {{-- @endif --}}
        
    @endslot
@endcomponent