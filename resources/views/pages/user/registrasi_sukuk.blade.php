@extends('layouts.user.sidebar')

@section('title', 'Surat Berharga Negara')

@section('content')


<div class="fluid-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-12 card-new">
                <div class="my-address contact-2 widget">
                    <h3 class="header-title pb-5">Registrasi Sukuk</h3>
                    <form action="/user/registrasi_sukuk_konfirmasi" method="GET" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12 ">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group name">
                                            <label>Email</label>
                                            <input type="mail" name="name" class="form-control" placeholder="Silahkan ketikan alamat email anda disini...">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group name">
                                            <label>No Handphone</label>
                                            <input type="number" name="name" class="form-control" placeholder="Silahkan ketikan nomor handphone anda disini...">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
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
                            
                            <div class="col-lg-12">                                   
                                    <button type="submit"  class="btn btn-color btn-md btn-message text-white" >Selanjutnya <i class="fas fa-angle-right"></i></button>
                             
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi-->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Surat Berharga Negara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn  btn-md btn-message bg-secondary text-white mr-4" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-color btn-md btn-message">Konfirmasi</button>
      </div>
    </div>
  </div>
</div>
@endsection
