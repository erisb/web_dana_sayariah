@component('component.mail')
    
    @slot('perihal')
        Aktivasi Email 
    @endslot
    @slot('content')
        <h3>Assalamualaikum Pendana Danasyariah.id</h3>
        <p>
            Anda telah mendaftarkan <b>{{$data->email}}</b> sebagai email akun Anda dan dengan <i>Username</i> : <b>{{$data->username}}</b>.
        </p>
        <p>
            Silahkan klik link verifikasi di bawah, untuk menyelesaikan pendaftaran.
        </p>

        <a href="{{config('app.url')}}/{{('user/confirm-email')}}/{{$data->email_verif}}">
            Aktifasi Akun saya
        </a>
        <p>
            Jika link di atas tidak berfungsi, <b>salin dan tempel</b> alamat di bawah ini ke dalam jendela <i>browser</i> baru.
        </p>
        
        <p>{{config('app.url')}}/{{('user/confirm-email')}}/{{$data->email_verif}}</p> 
    {{-- @endif --}}
        
    @endslot
@endcomponent