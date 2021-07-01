@extends('layouts.guest.master')

@section('navbar')
@include('includes.navbar2')
@endsection

@section('body')
<!-- faq start -->
<div class="sub-banner-2 mt-5 pt-5">
    <div class="container pt-5">
        <div class="breadcrumb-area">
            <h1>Frequently Ask Question</h1>
        </div>
    </div>
</div>
<div class="faq content-area-2">
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabbing tabbing-box mb-50">
                    <ul class="nav nav-tabs" id="carTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="one" aria-selected="false">Dana Syariah</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="two" aria-selected="false">Pendana dan Penerima Dana</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="carTabContent">
                        <div class="tab-pane fade active show" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <div id="faq" class="faq-accordion">
                                <div class="card m-b-0">
                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq" href="#collapse1">
                                            Apakah Dana Syariah itu?
                                        </a>
                                    </div>
                                    <div id="collapse1" class="card-block collapse">
                                        <p>Layanan Pendanaan Syariah dan Pinjaman Syariah bagi Pemilik Usaha ataupun Perorangan, dengan tujuan mendapatkan manfaat dan Bagi Hasil yang Halal serta terhindar dari unsur Maisir, Gharar dan Riba yang diharamkan.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq" href="#collapse2">
                                            Visi
                                        </a>
                                    </div>
                                    <div id="collapse2" class="card-block collapse">
                                        <p>Mengajak masyarakat untuk melaksanakan kegiatan ekonomi sesuai syariat Islam, agar bisa diperoleh rezeki yang halal dan barokah demi kesejahteraan dunia akhirat.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq" href="#collapse3">
                                            Misi
                                        </a>
                                    </div>
                                    <div id="collapse3" class="card-block collapse">
                                        <p>Menjadi wadah dan pusat kegiatan ekonomi syariah yang bisa mempermudah masyarakat, untuk melaksanakan kegiatan ekonomi sesuai syariat Islam.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
                            <div id="faq2" class="faq-accordion">
                                <div class="card m-b-0">
                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq2" href="#collapse7">
                                            Siapa yang boleh melakukan Pendanaan di Dana Syariah?
                                        </a>
                                    </div>
                                    <div id="collapse7" class="card-block collapse">
                                        <p>Warga Negara Indonesia (WNI) yang memiliki Identitas yang berlaku yaitu KTP dan NPWP atau Warga Negara Asing (WNA) yang mempunyai legalitas dan ijin tinggal resmi di Indonesiadan mempunyai Passport atau KITAS yang masih berlaku.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>                                    </div>

                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq2" href="#collapse8">
                                        Pendaan apa yang ditawarkan oleh Dana Syariah?
                                        </a>
                                    </div>
                                    <div id="collapse8" class="card-block collapse">
                                        <p>a)	Pendanaan pembangunan unit properti terjual dengan harga yang sudah disepakati antara Dana Syariah dengan mitra Developer Syariah.</p>                                    
                                        <p>b)	Pendanaan kepemilikan property bersama, dengan tujuan untuk disewakan kemudian dijual setelah periode waktu tertentu. Keuntungan yang didapat adalah bagi hasil sewa dan kenaikan harga properti pada saat porsi kepemilikan dijual.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq2" href="#collapse9">
                                             Berapa besar imbal bagi hasil bulanan dan kapan dana bisa dikembalikan?
                                        </a>
                                    </div>
                                    <div id="collapse9" class="card-block collapse">
                                        <p>Imbal bagi hasil bulanan yaitu sebesar 1% dari bagi hasil yang disepakati selama periode pembiayaan, dibayarkan bulanan dan langsung di transfer ke rekening Pendana yang terdaftar. Sisa imbal hasil yang belum dibayarkan (jika ada) akan dibayarkan pada akhir periode pembiayaan.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>
                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq2" href="#collapse10">
                                        Apakah dana bisa diambil sewaktu-waktu?
                                        </a>
                                    </div>
                                    <div id="collapse10" class="card-block collapse">
                                        <p>Bisa, Pendanaan bisa diambil kapan saja setelah paling cepat 30 hari semenjak dana tersebut diserahkan kepada rekanan developer properti Syariah (atau 30 hari setelah masa penggalangan dana selesai).</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>
                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq2" href="#collapse10">
                                        Apakah ada biaya atau denda, jika Dana diambil sebelum akhir periode pembiayaan?
                                        </a>
                                    </div>
                                    <div id="collapse10" class="card-block collapse">
                                        <p>Dana dikembalikan utuh 100% tanpa dikenakan biaya administrasi ataupun denda. Jika dana diambil sebelum berakhirnya periode kontrak, maka pemberi pendanaan yang bersangkutan akan kehilangan hak terhadap imbal bagi hasil bulan berjalan dan seterusnya juga akan kehilangan hak terhadap imbal bagi hasil yang belum dibayarkan (jika ada)</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="three" role="tabpanel" aria-labelledby="three-tab">
                            <div id="faq3" class="faq-accordion">
                                <div class="card m-b-0">
                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq3" href="#collapse10">
                                            What do you mean by an End Product?
                                        </a>
                                    </div>
                                    <div id="collapse10" class="card-block collapse">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem vulputate interdum et vel eros. Maecenas eros enim, tincidunt vel turpis vel, dapibus tempus nulla. Donec vel nulla dui. Pellentesque sed ante sed ligula hendrerit condimentum. Suspendisse rhoncus fringilla ipsum quis porta. Morbi tincidunt viverra pharetra. Vestibulum vel mauris et odio lobortis laoreet eget
                                            eu magna. Proin mauris erat, luctus at nulla ut, lobortis mattis magna. Morbi a arcu lacus. Maecenas tristique velit vitae nisi consectetur, in mattis diam sodales. Mauris sagittis sem mattis justo bibendum, a eleifend dolor facilisis. Mauris nec pharetra tortor, ac aliquam felis. Nunc pretium erat sed quam consectetur fringilla.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq3" href="#collapse11">
                                            Where do I find my Purchase or License code?
                                        </a>
                                    </div>
                                    <div id="collapse11" class="card-block collapse">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem vulputate interdum et vel eros. Maecenas eros enim, tincidunt vel turpis vel, dapibus tempus nulla. Donec vel nulla dui. Pellentesque sed ante sed ligula hendrerit condimentum. Suspendisse rhoncus fringilla ipsum quis porta. Morbi tincidunt viverra pharetra. Vestibulum vel mauris et odio lobortis laoreet eget
                                            eu magna. Proin mauris erat, luctus at nulla ut, lobortis mattis magna. Morbi a arcu lacus. Maecenas tristique velit vitae nisi consectetur, in mattis diam sodales. Mauris sagittis sem mattis justo bibendum, a eleifend dolor facilisis. Mauris nec pharetra tortor, ac aliquam felis. Nunc pretium erat sed quam consectetur fringilla.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq3" href="#collapse12">
                                            Do I need to buy a licence for each site?
                                        </a>
                                    </div>
                                    <div id="collapse12" class="card-block collapse">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem vulputate interdum et vel eros. Maecenas eros enim, tincidunt vel turpis vel, dapibus tempus nulla. Donec vel nulla dui. Pellentesque sed ante sed ligula hendrerit condimentum. Suspendisse rhoncus fringilla ipsum quis porta. Morbi tincidunt viverra pharetra. Vestibulum vel mauris et odio lobortis laoreet eget
                                            eu magna. Proin mauris erat, luctus at nulla ut, lobortis mattis magna. Morbi a arcu lacus. Maecenas tristique velit vitae nisi consectetur, in mattis diam sodales. Mauris sagittis sem mattis justo bibendum, a eleifend dolor facilisis. Mauris nec pharetra tortor, ac aliquam felis. Nunc pretium erat sed quam consectetur fringilla.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                    <div class="card-header">
                                        <a class="card-title collapsed" data-toggle="collapse" data-parent="#faq3" href="#collapse13">
                                            Is my license transferable?
                                        </a>
                                    </div>
                                    <div id="collapse13" class="card-block collapse">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus tincidunt aliquam. Aliquam gravida massa at sem vulputate interdum et vel eros. Maecenas eros enim, tincidunt vel turpis vel, dapibus tempus nulla. Donec vel nulla dui. Pellentesque sed ante sed ligula hendrerit condimentum. Suspendisse rhoncus fringilla ipsum quis porta. Morbi tincidunt viverra pharetra. Vestibulum vel mauris et odio lobortis laoreet eget
                                            eu magna. Proin mauris erat, luctus at nulla ut, lobortis mattis magna. Morbi a arcu lacus. Maecenas tristique velit vitae nisi consectetur, in mattis diam sodales. Mauris sagittis sem mattis justo bibendum, a eleifend dolor facilisis. Mauris nec pharetra tortor, ac aliquam felis. Nunc pretium erat sed quam consectetur fringilla.</p>
                                        <hr>
                                        <span class="answer-helpful">Was this answer helpful?  <a href="#" class="yes"><i class="fa fa-thumbs-o-up"></i></a> <a href="#" class="no"><i class="fa fa-thumbs-o-down"></i></a></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- faq end -->

@endsection