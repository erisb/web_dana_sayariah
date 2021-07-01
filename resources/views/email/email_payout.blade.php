@component('component.mail')
    
    @slot('perihal')
        Monthly Payout
    @endslot
    @slot('content')
        <p>Akun         : {{$user->username}}</p>
        {{-- <p>PROYEK           : {{$pendanaan}}</p> --}}
        <p>AMOUNT           : {{$amount}}</p>
        <br>
        <p>Imbal hasil telah ditambahkan pada dana anda</p>
    @endslot
@endcomponent