<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProyekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        DB::table('proyek')->insert([
            'nama' => 'Pendanaan 29/IX/18-PR krukut raya, cinere, depok',
            'alamat' => 'krukut raya, cinere, depok',
            'geocode' => 'https://www.google.com/maps/d/embed?mid=14ngA9qPXvgQgjX1iRwOnWAcqiFoRZeBH',
            'profit_margin' => 15,
            'total_need' => 1100000000,
            'harga_paket' => 1000000,
            'akad' => 'Murabahah',
            'tgl_mulai' => Carbon::yesterday()->toDateString(),
            'tgl_selesai' => Carbon::parse('2018-10-16'),
            'deskripsi' => '<h2>INVESTASI PENDANAAN DENGAN AGUNAN TAHAP II-1</h2><h3>NO. PR-029/9/2018</h3><p>Properti ini berupa rumah tinggal yang ada di dalam cluster yang sudah berkembang dan di penuhi penghuni. Dalam cluster ini ada 23 unit rumah dan 12 unit ruko, termasuk ada Minimarket Alfamart di pintu gerbang masuk. </p><p>Rumah yang ditawarkan ini sudah terjual dan menunggu untuk dibangun, Dana yang diperlukan untuk pembangunan unit dengan lahan 99 m dengan luas bangunan 120 m bertingka adalah sebesar 1,1 M dan sudah mendapatkan komitmen dari pembeli dengan harga Rp. 1,35M. Pertumbuhan property di wilayah sangat pesat karena akan akan proyek jalan tol Depok Antasari yang sudah di bangun lebih dari 60%.</p>',
            'terkumpul'=> 33000000,
            'status'=> true

        ]);

        DB::table('proyek')->insert([
            'nama' => 'INVESTASI 28/VIII/18-PRCO galur sari, jakarta timur',
            'alamat' => 'galur sari, jakarta timur',
            'geocode' => 'https://www.google.com/maps/d/embed?mid=14ngA9qPXvgQgjX1iRwOnWAcqiFoRZeBH',
            'profit_margin' => 15,
            'total_need' => 2000000000,
            'harga_paket' => 1000000,
            'akad' => 'Murabahah',
            'tgl_mulai' => Carbon::yesterday()->toDateString(),
            'tgl_selesai' => Carbon::parse('2018-09-16'),
            'deskripsi' => '<h2>INVESTASI KEPEMILIKAN BERSAMA PROPERTI</h2><h3>NO. KB-027/8/2018</h3><p>Properti ini berupa rumah tinggal yang ada di dalam komplek perumahan yang terletak di daerah galur sari tahap II, Jakarta timur. Lokasi yang strategis, terletak di jantung timur kota Jakarta, mudah dijangkau dengan berbagai sarana angkutan umum, akses jalan menuju lokasi bagus dan tidak mudah untuk mendapatkan lokasi yang serupa dengan proyek kami. Terdapat dua Unit Rumah yang akan dibangun dengan harga jual pada kisaran 3.2M dengan masing-masing luas tanah +-170M2 dan luas bangunan +- 120M2. Besarnya dana yang kami perlukan dari investor yang berminat adalah 2M. </p><p>Properti ini ditawarkan terbatas dan kedua unit sudah terjual (komitmen) dengan batas penyerahan Unit 18 bulan sejak kontrak pembelian di tandatangani.</p>',
            'terkumpul'=> 690000000,
            'status'=> true

        ]);

        DB::table('proyek')->insert([
            'nama' => 'INVESTASI 28/VIII/18-PRCO galur sari, jakarta timur',
            'alamat' => 'galur sari, jakarta timur',
            'geocode' => 'https://www.google.com/maps/d/embed?mid=14ngA9qPXvgQgjX1iRwOnWAcqiFoRZeBH',
            'profit_margin' => 15,
            'total_need' => 2000000000,
            'harga_paket' => 1000000,
            'akad' => 'Murabahah',
            'tgl_mulai' => Carbon::yesterday()->toDateString(),
            'tgl_selesai' => Carbon::parse('2018-09-16'),
            'deskripsi' => '<h2>INVESTASI PROPERTI DENGAN AGUNAN- II</h2><h3>NO. PR-027/8/2018</h3><p>Properti ini berupa rumah tinggal yang ada di dalam komplek perumahan yang terletak di daerah galur sari, Jakarta timur. Lokasi yang strategis, terletak di jantung timur kota Jakarta, mudah dijangkau dengan berbagai sarana angkutan umum, akses jalan menuju lokasi bagus dan tidak mudah untuk mendapatkan lokasi yang serupa dengan proyek kami. Terdapat dua Unit Rumah yang akan dibangun dengan harga jual pada kisaran 3.2M dengan luas tanah +-170M2 dan luas bangunan +- 120M2. Besarnya dana yang kami perlukan dari investor yang berminat adalah 2M. </p><p>Properti ini ditawarkan terbatas dan kedua unit sudah terjual (komitmen) dengan batas penyerahan Unit 18 bulan sejak kontrak pembelian di tandatangani.</p>',
            'terkumpul'=> 944200000,
            'status'=> true

        ]);

        DB::table('proyek')->insert([
            'nama' => 'Pendanaan 26/VIII/18-PR cirendeu, tangerang',
            'alamat' => 'cirendeu, tangerang',
            'geocode' => 'https://www.google.com/maps/d/embed?mid=14ngA9qPXvgQgjX1iRwOnWAcqiFoRZeBH',
            'profit_margin' => 15,
            'total_need' => 2000000000,
            'harga_paket' => 1000000,
            'akad' => 'Murabahah',
            'tgl_mulai' => Carbon::yesterday()->toDateString(),
            'tgl_selesai' => Carbon::parse('2018-09-17'),
            'deskripsi' => '<h3>Deskripsi Usaha</h3><p>Kluster ini dibangun di atas lahan seluas 600 m yang berada di samping Perumahan paling mewah di wilayah cirendeu raya, Tangerang Selatan. Pemilik Lahan telah melakukan akad kerjasama secara Syariah dengan Developer yang sudah berpengalaman membangun dan memasarkan cluster di wilayah tersebut. Diatas Lahan itu akan dibangun 5 unit rumah dengan arsitektur bergaya bali modern minimalis. Ukuran masing masing rumah sekitar 90 m dan bangunan bertingkat dengan luas bangunan sekitar 100 m. Setiap unit rumah di pasarkan dengan harga berkisar 1,5 M – 2 M. Pemilik Proyek sudah menandatangani akad perjanjian syariah (Join Operations) dengan Perwakilan PT Dana Syariah yang di tunjuk dan akan bertindak menjadi wakil investor pemberi dana, untuk memastikan bahwa dana yang di berikan akan digunakan sepenuhnya untuk tujuan sebagaimana yang telah di verifikasi kelayakannya oleh tim Dana Syariah.</p><hr><h3>Tujuan Penggunaan Dana Pendanaan</h3><p>Sebagian Dana yaitu sebesar 1 Milyar akan digunakan untuk melunasi  outstanding pembiayaan ke lembaga pembiayaan dan mengalihkan agunan ke Dana Syariah. Kemudian sisanya 1 Milyar akan digunakan untuk membiayai modal kerja yang dibutuhkan untuk melanjutkan pembangunan rumah yang di pesan maupun untuk rumah stock jadi.</p><hr><h3>Jaminan Dan Agunan</h3><p>Pemilik Proyek ini telah setuju untuk memberikan Agunan atas kerjasama ini berupa sertifikat kepemilikan lahan proyek ini sendiri yang di akad kuasa jualkan ke pihak PT Dana Syariah Indonesia sebagai Wakil dari investor pemberi dana.</p>',
            'terkumpul'=> 1050600000,
            'status'=> true

        ]);

        DB::table('proyek')->insert([
            'nama' => 'Pendanaan 25/VII/18-PRCO cirendeu, tangerang',
            'alamat' => 'cirendeu, tangerang',
            'geocode' => 'https://www.google.com/maps/d/embed?mid=14ngA9qPXvgQgjX1iRwOnWAcqiFoRZeBH',
            'profit_margin' => 15,
            'total_need' => 1350000000,
            'harga_paket' => 1000000,
            'akad' => 'Murabahah',
            'tgl_mulai' => Carbon::yesterday()->toDateString(),
            'tgl_selesai' => Carbon::parse('2018-09-14'),
            'deskripsi' => '<h2>INVESTASI KEPEMILIKAN BERSAMA PROPERTI TAHAP II</h2><h2>NO. KB-025/7/2018</h2><hr><h3>Kelebihan Properti ini, untuk di beli dan jual kembali</h3><p>Properti ini berupa rumah tinggal yang ada di dalam cluster yang sudah mulai di bangun dan di pasarkan. Seluruhnya ada 8 unit rumah dengan desain Eksklusif yang memang sesuai untuk potensi pasar di wilayah itu. Harga jual properti ini sesuai price list adalah sekitar Rp. 1,265 M.</p><p>Rumah ini di jual jauh di bawah harga pasar, karena pemilik membutuhkan dana syariah untuk membangun unit unit lain agar tidak perlu mengajukan pinjaman dari Bank. Unit ini di tawarkan hanya dengan harga Rp. 1,1 M dengan ukuran lahan sekitar 84 m dengan luas bangunan 110 m bertingkat. Saat ini rumah sudah dalam proses awal pembangunan, di perkirakan akan selesai dalam 8 bulan , kemudian bisa langsung di jual cepat di harga Rp. 1,265 M.</p>',
            'terkumpul'=> 472635000,
            'status'=> true

        ]);

        DB::table('proyek')->insert([
            'nama' => 'Pendanaan 24/VII/18-PRCO kirai, tangerang',
            'alamat' => 'kirai, tangerang',
            'geocode' => 'https://www.google.com/maps/d/embed?mid=14ngA9qPXvgQgjX1iRwOnWAcqiFoRZeBH',
            'profit_margin' => 15,
            'total_need' => 1100000000,
            'harga_paket' => 1000000,
            'akad' => 'Murabahah',
            'tgl_mulai' => Carbon::yesterday()->toDateString(),
            'tgl_selesai' => Carbon::parse('2018-09-08'),
            'deskripsi' => '<h2>INVESTASI KEPEMILIKAN BERSAMA PROPERTI II</h2><h2>NO. KB-024/7/2018</h2><hr><h3>Kelebihan Properti ini, untuk di beli dan jual kembali</h3><p>Properti ini berupa rumah tinggal yang ada di dalam cluster yang sudah di bangun dan di pasarkan. Seluruhnya ada 5 unit rumah dengan desain Eksklusif yang memang sesuai untuk potensi pasar di wilayah itu. Harga jual properti ini sesuai price list adalah sekitar Rp. 1,55 M. </p><p>Lokasi property ini berada di samping pintu masuk Kawasan Cluster paling Mewah di Cirendeu, Rumah ini di jual jauh di bawah harga pasar, karena pemilik membutuhkan dana syariah untuk membangun unit unit lain agar tidak perlu mengajukan pinjaman dari Bank. Unit ini di tawarkan hanya dengan harga hanya  Rp. 1,35 M dengan ukuran lahan sekitar 84 m dengan luas bangunan 100 m bertingkat. Saat ini rumah sudah dalam proses awal pembangunan, di perkirakan akan selesai dalam 8 bulan , kemudian bisa langsung di jual cepat di harga Rp. 1,52M.</p>',
            'terkumpul'=> 387200000,
            'status'=> true

        ]);


        
    }
}
