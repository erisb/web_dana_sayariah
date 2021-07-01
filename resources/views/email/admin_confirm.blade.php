@component('component.mail')
    
    @slot('perihal')
        Pemberi Pembiayaan Pending
    @endslot
    @slot('content')
        <p>Pemberi Pembiayaan dengan detil sebagai berikut,</p>
        <br><br>
        <p>Akun : <b>{{$data->username}}</b> </p>
        <p>EMAIL : <b>{{$data->email}}</b></p>
        <p>Nama : <b>{{$data->detilInvestor->nama_investor}}</b></p>
        <p>No KTP : <b>{{$data->detilInvestor->no_ktp_investor}}</b></p>
        <br><br>
        <p>Telah melakukan pengisian data.</p>
        <br>
        <p>Dimohon admin untuk segera memverifikasi akun Pemberi Pembiayaan tersebut</p>
    @endslot
@endcomponent