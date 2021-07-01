@extends('layouts.user.sidebar')

@section('title', 'Surat Berharga Negara')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12 card-new">
                <div class="my-address contact-2 widget">
                    <h3 class="header-title pb-5">Konfirmasi & Lengkapi <br> Data Surat Berharga Negara</h3>
                    <h6>Anda Melakukan Registrasi Surat Berharga Negara, Dari rekening Anda</h6>
                    <h6 class="pb-3 pt-3">
                        <span class="alert alert-success"><b>No Rekening : <span>7000112929</span></span></b>
                    </h6>
                    <form action="/user/registrasi_sukuk_konfirmasi_sukses" method="GET" enctype="multipart/form-data">
                        <div class="header-title pt-2">
                            Data Nasabah
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Nama</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Dani Akbar" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">No. KTP</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="09809809809809" disabled>
                                    </div>
                                </div> 
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col-lg-6">    
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Tempat Lahir</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Padang" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="0/10/1999" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Alamat</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Rasuna Said" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Kabupaten/Kota</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Jakarta" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Propinsi</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Jakarta Selatan" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Laki-Laki" disabled>
                                    </div>
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Status Pernikahan</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Menikah" disabled>
                                    </div>
                                </div>
                            </div>    

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Jenjang Pendidikan</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="S3" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Jenis Pekerjaan</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Financial Technology" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Pendapatan</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Rp. 1.000.000.000" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Sumber Dana</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Gaji" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">Nama Ibu Kandung</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="Dahlia" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">E-Mail</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="dani.akbarr@gmail.com" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-4 col-form-label">No. Handphone</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control text-form" id="inputPassword3" placeholder="+62 81 000 0000" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-title pt-2">
                            Bank Kustodian
                        </div>
                        <hr>
                        <div class="col-lg-12 ">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="heading">File KTP</h3>
                                    <div class="row mb-60">
                                        <div class="col-lg-12">
                                            <!-- // js nya di head.blade.php Dropzone initialization -->
                                            <div id="myDropZone" class="dropzone dropzone-design dz-clickable">
                                                <div class="dz-default dz-message"><span>Klik atau Drop files KTP di sini</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="heading">File NPWP</h3>
                                    <div class="row mb-60">
                                        <div class="col-lg-12">
                                            <!-- // js nya di head.blade.php Dropzone initialization -->
                                            <div id="myDropZone" class="dropzone dropzone-design dz-clickable">
                                                <div class="dz-default dz-message"><span>Klik atau Drop files NPWP di sini</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-5">
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="data-benar" checked>
                                <label class="form-check-label" for="data-benar">
                                    Saya telah menyampaikan data dengan benar dan lengkap
                                </label>
                            </div>
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="data-unggah-benar">
                                <label class="form-check-label" for="data-unggah-benar">
                                    Dokumen yang saya unggah adalah benar dokumen saya
                                </label>
                            </div>

                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="pembuatan-id">
                                <label class="form-check-label" for="pembuatan-id">
                                    Saya setuju untuk memberikan data saya kepada Bank Kustodian yang telah bekerja sama dengan Dana Syariah Indonesia untuk
                                    proses pembentukan nomor Single Investor Identify (SID) dan Sub Rekening Efek (SRE)
                                </label>
                            </div>
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="mengerti">
                                <label class="form-check-label" for="mengerti">
                                    Saya telah mengerti dan menyetujui ketentuandan persyaratan pembentukan nomor SID dan SRE
                                </label>
                            </div>
                            <div class="">                    
                                <label class="form-check-label pt-2" for="mengerti">
                                <!-- <p><b> Apabila Anda ingin merubah data detail, silahkan <a href="/user/manage_profile" class="text-success pl-1"><i class="fas fa-user"></i> Klik disini</a></b> <br> -->
                                 <b> Apabila Anda setuju, silahkan tekan 'Selanjutnya'</b></p>
                                </label>
                            </div>
                        </div>
                        <div class=" pt-5">
                                <a href="#" class="btn  btn-md btn-message bg-secondary text-white mr-4">Reset </a>
                                <a href="#" class="btn btn-color btn-md btn-message text-white" data-toggle="modal" data-target="#modalPin">Selanjutnya <i class="fas fa-angle-right"></i> </a>
                            
                        </div>     
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/user/registrasi_sukuk_konfirmasi_sukses">
        <div class="modal-body">
          <div class="col-lg-12 pt-4 ">
            <h4>Pastikan Data Anda Sudah Benar</h4>
              <p>Saya telah mengerti dan menyetujui ketentuandan persyaratan pembentukan nomor SID dan SRE</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit Data</button>
          <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Konfirmasi </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
