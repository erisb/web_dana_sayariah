@component('component.mail')
    
    @slot('perihal')
        Pengembalian Dana Proyek
    @endslot
    @slot('content')
        <p>
            Alhamdulillah, Proyek yang Bapak/Ibu dengan <b>Nama Pendana: {{$data->investor->detilInvestor->nama_investor}}</b> danai sudah berakhir. Kami infokan berikut adalah proyek berakhir yang Bapak/Ibu danai:
        </p>
        <p>
            <b>Pendanaan : {{$data->proyek->nama}}
        </p>
        <p>
            <b>jumlah Pendanaan : Rp. {{number_format($data->nominal_awal)}}</b>
            Tanggal Pendanaan berakhir: {{$data->tanggal_invest}}
        </p>
        <p>
            Kini saatnya pembayaran sisa imbal hasil dan pengembalian dana pokok para pendana. 
        </p>
        <p>
            <b>Danasyariah.id</b> membuka kesempatan pendanaan properti dengan minimal pendanaan 1 Juta Rupiah dan bagi hasil setara hingga 20% per tahun yang diberikan setiap bulan, <b>yakin masih gamau nikmati bagi hasilnya?</b>
        </p>
        <br>
        <p><b>Wassalamualaikum Wr Wb.</b></p>
        <br>
        <p>
            Catatan Penting:
        </p>
        <p>
            -          Sisa imbal hasil Anda akan kami langsung kirimkan ke rekening terdaftar Anda saat jatuh tempo.
        </p>
        <p>
            -          Dana akhir proyek akan dikirmkan ke dalam dashboard Anda, silahkan jika ingin mengalokasikan sendiri dana Anda ke proyek lainnya yang sedang dalam pemggalangan dana.
        </p>
    @endslot
@endcomponent