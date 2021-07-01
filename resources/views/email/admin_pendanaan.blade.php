@component('component.mail')
    
    @slot('perihal')
        Pengalokasikan Dana Otomatis
    @endslot
    @slot('content')
        <p>Assalamualaikum Wr. Wb. Bapak/Ibu  <b>{{$user->username}}</b></p>
        <br>
        <p>Sesuai dengan Peraturan Otoritas Jasa Keuangan (POJK) No. 77/2016, 
          penyelenggara <i>Peer to Peer Financing</i> wajib menggunakan escrow account dan Virtual Account (VA) lewat perbankan, dan OJK mengatur bahwa dana hanya boleh mengendap selama 2 hari. 
          Hal tersebut dilakukan untuk meningkatkan kepercayaan dan mengantisipasi adanya ponzi atau ponzi games.
          <a href="https://www.cnbcindonesia.com/tech/20180714150423-37-23546/ojk-fintech-dilarang-himpun-dana-masyarakat">Baca di sini</a>
        </p>
        <br>
        <p>
          Sehubung dengan adanya peraturan tersebut maka dana tidak teralokasi sebesar {{number_format($pendanaan->nominal_awal)}} yang berada di akun Anda, telah Kami alokasikan ke {{$pendanaan->proyek->nama}} yang telah berlangsung sesuai dengan peraturan yang telah disebutkan.
        </p>
        <br>
        <br>
        <p>Tunggu apa lagi? #AyoHijrahFinansial melalui pendanaan halal bersama Dana Syariah Indonesia. </p>
        <p>Untuk informasi lebih lanjut dapat kunjungi dan hubungi kami di:</p>
        <p>
            <b>Website: www.danasyariah.id</b>
            <br>
            <b>Facebook: Dana Syariah</b>
            <br>
            <b>WhatsApp: 0822 5000 5050 atau 0815 1001 70704</b>
        </p>
        <br>
        <p>Atas perhatian Bapak/Ibu, Kami ucapkan terima kasih</p>
    @endslot
@endcomponent