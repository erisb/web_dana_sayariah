@component('component.mail')
    
    @slot('perihal')
        Verifikasi Akun
    @endslot

    @slot('content')
        <p>Akun : <b>{{$data->username}}</b> </p>
        <p>Akun anda telah sukses diverifikasi</p>
        <p>Silahkan login untuk memulai Pendanaan anda</p>

        <a href="https://www.danasyariah.id/#loginModal">
            Login Dana Syariah
        </a>
    @endslot
@endcomponent