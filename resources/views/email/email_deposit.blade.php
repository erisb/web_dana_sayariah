@component('component.mail')
    
    @slot('perihal')
        Top up saldo
    @endslot
    @slot('content')
        <h3>Terima Kasih, Saldo Pendanaan Anda bertambah.</h3>
        <p>
        	Akun Anda <b> {{$user->username}}</b> telah berhasil melakukan top up dengan jumlah <b>Rp. {{$amount}}</b>.
        </p>
        <br>
        <p>
        	Silahkan pilih proyek yang akan Anda danai dan nikmati imbal hasilnya setara 15-20% per tahun.
        </p>
    @endslot
@endcomponent