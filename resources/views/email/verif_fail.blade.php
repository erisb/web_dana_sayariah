@component('component.mail')
    
    @slot('perihal')
        Verifikasi Akun
    @endslot
    
    @slot('content')
        <p>Akun : <b>{{$data->username}}</b> </p>

        <p>Akun anda gagal diverifikasi</p>

        <p>Silahkan login untuk mengisi ulang data</p>

        <a href="https://www.danasyariah.id/#loginModal">
            Login Dana Syariah
        </a>
    @endslot
@endcomponent