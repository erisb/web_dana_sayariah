@extends('layouts.admin.master')

@section('title', 'Dashboard Penerima Dana')

@section('content')
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Kelola Jenis Pendanaan</h1>
                    </div>
                </div>
            </div>
</div>
<div class="content mt-3">
<div class="row">
  <div class="col-md-12">
    @if (session('error'))
        <div class="alert alert-danger col-sm-12">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif (session('success'))
        <div class="alert alert-success col-sm-12">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session('updated'))
        <div class="alert alert-success col-sm-12">
            {{ session('updated') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

      <div class="card">
          <div class="card-header">
              <strong class="card-title">Data Jenis Pendanaan</strong>
              <button type="button" class="btn btn-success float-right" data-toggle="modal" id="addNewJenis" data-target=".modelAddJenisPendanaan">Tambah Jenis Pendanaan</button>
          </div>
          <div class="card-body">
              <table id="tablePendanaan" class="table table-striped table-bordered table-responsive-sm">
                  <thead>
                  <tr>
                      <th>id</th>
                      <th>No</th>
                      <th>Jenis Pendanaan</th>
                      <th>Kelengkapan Data Pendanaan</th>
                      <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Large modal -->
<div class="modal fade modelAddJenisPendanaan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4>Tambah Jenis Pendanaan</h4>
      </div>
        <div class="modal-body">
            <form action="/admin/borrower/prosess/postNewJenis" method="POST">
              @csrf
              <div class="form-group">
                <label>Jenis Pendanaan</label>
                <input type="text" name="pendanaanJenis" class="form-control" id="addJenisNama" aria-describedby="" placeholder="Jenis Pendanaan">
              </div>
              <div class="form-group">
                <textarea name="pendanaanKeterangan" id="textJenisPendana"></textarea>
              </div>
        </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-primary float-right  ">Kirim</button>
        </form>        
      </div>
    </div>
  </div>
</div>


<!-- Large modal -->
<div class="modal fade modalListJenis" tabindex="-1" role="dialog" aria-labelledby="modalListJenis" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4>Tambah Jenis Pendanaan</h4>  
            <button type="button" name="add" id="add" class="btn btn-success float-right "> + </button>
        </div>
          <div class="modal-body">
              <form action="/admin/borrower/prosess/addJenisList" method="POST">
                @csrf 
                <input type="hidden" name="idListNew" id="idListNew">
                <table class="table table-bordered" id="dynamic_field"> 
                </table>  
          </div>
        <div class="modal-footer">
            <button type="submit" id="btnSubmitList" class="btn btn-primary float-right  ">Kirim</button>
          </form>        
        </div>
      </div>
    </div>
  </div>


<div class="modal fade modalDetilPendanaan" tabindex="-1" role="dialog" aria-labelledby="modalDetilPendanaan" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Edit Jenis Pendanaan</h4>
        </div>
          <div class="modal-body">
              <form action="/admin/borrower/prosess/updateJenis" method="POST">
                @csrf
                <div class="form-group">
                  <label>Jenis Pendanaan</label>
                  <input type="hidden" name="idPendanaanJenis" id="idEditPendanaan">
                  <input type="text" name="editPendanaanJenis" class="form-control" id="viewPendanaanNama" aria-describedby="" placeholder="Jenis Pendanaan">
                </div>
                <div class="form-group">
                  <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> PERORANGAN (PEGAWAI) </a>
                      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> PERUSAHAAN (BADAN HUKUM)  </a>
                      <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"> PERORANGAN (WIRAUSAHA) </a>
                    </div>
                  </nav>
                  <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                      <div class="form-group">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Wajib</th>
                              <th scope="col">Persyaratan</th>
                              <th scope="col">Hapus</th>
                            </tr>
                          </thead>
                          <tbody id="list_jenis">

                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="form-group">
                          <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Wajib</th>
                                <th scope="col">Persyaratan</th>
                                <th scope="col">Hapus</th>
                              </tr>
                            </thead>
                            <tbody id="list_jenis_2">
  
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="form-group">
                          <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Wajib</th>
                                <th scope="col">Persyaratan</th>
                                <th scope="col">Hapus</th>
                              </tr>
                            </thead>
                            <tbody id="list_jenis_3">
  
                            </tbody>
                          </table>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for=""> Keterangan</label>
                  <textarea name="editPendanaanKeterangan" id="viewPendanaanKet"></textarea>
                </div>
          </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary float-right  ">Kirim</button>
          </form>        
        </div>
      </div>
    </div>
  </div>
  


  <link rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />

  <script src="{{asset('js/sweetalert.js')}}"></script>
  <script src="/admin/assets/js/lib/data-table/datatables.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/dataTables.buttons.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/jszip.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/pdfmake.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/vfs_fonts.js"></script>
  <script src="/admin/assets/js/lib/data-table/buttons.html5.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/buttons.print.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/buttons.colVis.min.js"></script>
  <script src="/admin/assets/js/lib/data-table/datatables-init.js"></script>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

  <style>
    .custom-datatable{
      width: 250px;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
    }
  </style>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
          var side = '/admin/borrower';
          var table = $('#tablePendanaan').DataTable({
            
            processing: true,
            // serverSide: true,
            ajax : {
              url : side+'/client/getTableJenisBorrower',
              type : 'get',
            },
            "columns" : [
              {"data" : "id"},
              {"data" : "no"},
              {"data" : "jenisPendanaan"},
              {"data" : "keteranganPendanaan"},
            ],
            "columnDefs" :[
              {
                "targets": 0,
                class : 'text-left',
                "visible" : false,
              },
              {
                "targets": 3,
                class : 'text-left',
                "visible" : false,
              },
              {
                "targets": 4,
                class : 'text-left',
                style : 'width:150px;',
                //"visible" : false
                "render" : function(data, type, value, meta){
                  return '<button class="btn btn-info" data-toggle="modal" data-target=".modalDetilPendanaan" id="detilPendanaan" >Detil Jenis</button> &nbsp; &nbsp; <button class="btn btn-warning" data-toggle="modal" data-target=".modalListJenis" id="btnlListJenis" >Tambah Jenis</button> &nbsp; &nbsp; <button class="btn btn-danger"  id="deleteJenis" >Hapus Jenis</button>';
                  //return row[6];
                }
              }
            ]
          })

          $('#addNewJenis').on('click', function(){
            $('#addJenisNama').val('')
            tinymce.get('textJenisPendana').setContent('');
          })
          
          $('#tablePendanaan tbody').on('click','#detilPendanaan', function(){
            var data = table.row( $(this).parents('tr') ).data();
            $('#idEditPendanaan').val('')
            $('#viewPendanaanNama').val('')
            $('#viewPendanaan').html('')
            $('#list_jenis').html('')
            $('#list_jenis_2').html('')
            $('#list_jenis_3').html('')


            $('#idEditPendanaan').val(data.id);
            $('#viewPendanaanNama').val(data.jenisPendanaan);
            tinymce.get('viewPendanaanKet').setContent(data.keteranganPendanaan);
            $.ajax({
              url: side+'/prosess/getListJenis/'+data.id,
              type:'get',
              success:function(dt)
              {
                // console.log(dt)
                tes = JSON.parse(dt)
                // console.log(tes)
                
                $.each(tes,function(index,value){
                  // console.log(value.persyaratan_id)
                    var checkdata = value.persyaratan_mandatory == 1 ? 'checked' : '';
                  var valData = value.persyaratan_mandatory == 1 ? '1'  : '0';
                    $('#list_jenis').append('<tr>'+
                                              '<td >#</td>'+
                                              '<td><input type="hidden" name="idList[]" value="'+value.persyaratan_id+'" ><input  '+checkdata+' type="checkbox" name="valueList[]" value="'+value.persyaratan_id+'" ></td>'+
                                              '<td><input type="text" name="list[]" placeholder="Enter your Name" class="form-control " value="'+value.persyaratan_nama+'" > </td>'+
                                                '<td><input type="checkbox" name="deleteList[]" value="'+value.persyaratan_id+'" id="defaultCheck1"></td>'+
                                            '</tr>'
                                            );
                });

              }
            })


            $.ajax({
              url: side+'/prosess/getListJenis_2/'+data.id,
              type:'get',
              success:function(dt)
              {
                // console.log(dt)
                tes = JSON.parse(dt)
                // console.log(tes)
                
                $.each(tes,function(index,value){
                  // console.log(value.persyaratan_id)
                  var checkdata = value.persyaratan_mandatory == 1 ? 'checked' : '';
                  var valData = value.persyaratan_mandatory == 1 ? '1'  : '0';
                    $('#list_jenis_2').append('<tr>'+
                                                '<td >#</td>'+
                                                '<td><input type="hidden" name="idList[]" value="'+value.persyaratan_id+'" ><input  '+checkdata+' type="checkbox" name="valueList[]" value="'+value.persyaratan_id+'" ></td>'+
                                                '<td><input type="text" name="list[]" placeholder="Enter your Name" class="form-control " value="'+value.persyaratan_nama+'" > </td>'+
                                                '<td><input type="checkbox" name="deleteList[]" value="'+value.persyaratan_id+'" id="defaultCheck1"></td>'+
                                              '</tr>'
                                              );
                });

              }
            })

            
            $.ajax({
              url: side+'/prosess/getListJenis_3/'+data.id,
              type:'get',
              success:function(dt)
              {
                // console.log(dt)
                tes = JSON.parse(dt)
                // console.log(tes)
                
                $.each(tes,function(index,value){
                  // console.log(value.persyaratan_id)
                  var checkdata = value.persyaratan_mandatory == 1 ? 'checked' : '';
                  var valData = value.persyaratan_mandatory == 1 ? '1'  : '0';
                    $('#list_jenis_3').append('<tr>'+
                                                '<td >#</td>'+
                                                '<td><input type="hidden" name="idList[]" value="'+value.persyaratan_id+'" ><input  '+checkdata+' type="checkbox" name="valueList[]" value="'+value.persyaratan_id+'" ></td>'+
                                                '<td><input type="text" name="list[]" placeholder="Enter your Name" class="form-control " value="'+value.persyaratan_nama+'" > </td>'+
                                                '<td><input type="checkbox" name="deleteList[]" value="'+value.persyaratan_id+'" id="defaultCheck1"></td>'+
                                              '</tr>'
                                              );
                });

              }
            })

            

          })
          
          $('#tablePendanaan tbody').on('click','#deleteJenis', function(){
            var data = table.row( $(this).parents('tr') ).data();
            
            $.ajax({
              url : side+'/prosess/deleteJenis/'+data.id ,
              type : 'get',
              success:function(data)
              {
                // console.log(data.data)
                if(data.data == 'sukses')
                {
                  alert('Delete Jenis Pendanaan Berhasil yak..')
                  window.location.reload()
                }
              }
            })
          })


          $('#tablePendanaan tbody').on('click','#btnlListJenis', function(){
            $('#idListNew').val('')
            var data = table.row( $(this).parents('tr') ).data();
            console.log(data.id)
            $('#dynamic_field').html('');
            $('#btnSubmitList').hide()
            $('#idListNew').val(data.id)
          })
          
        })

      
        
        var i=1;  
        $('#add').click(function(){  
            i++; 
            $('#btnSubmitList').show()
            $('#dynamic_field').append('<tr id="row'+i+'">'+
              '<td><input type="text" name="addList[]" placeholder="Masukan List Lain" class="form-control name_list" /></td>'+                
              '<td>'+
                '<select name="addSelect[]" class="form-control" id="">'+
                  '<option value="">-- Pilih Role --</option>'+
                  '<option value="1">-- PERORANGAN (PEGAWAI) --</option>'+
                  '<option value="2">-- PERUSAHAAN Badan Hukum --</option>'+ 
                  '<option value="3">-- PERORANGAN (WIRAUSAHA) --</option>'+ 
               '</select>'+  
              '</td>'+
              '<td>'+
                '<select name="mandatoryList[]" class="form-control" id="">'+
                  '<option value="0">-- Tidak Wajib --</option>'+
                  '<option value="1">-- Wajib --</option>'+ 
               '</select>'+  
              '</td>'+
              '<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'+
              '</tr>');  
        });  
        $(document).on('click', '.btn_remove', function(){  
            var button_id = $(this).attr("id");   
            $('#row'+button_id+'').remove();  
        });

        
        tinymce.init({
            selector: '#viewPendanaanKet',
            height: 300,
            theme: 'modern',
            skin:'lightgray',
            plugins: 'print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            file_picker_callback: function(callback, value, meta) {
            if (meta.filetype == 'image') {
                $('#upload').trigger('click');
                $('#upload').on('change', function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    callback(e.target.result, {
                    alt: ''
                    });
                };
                reader.readAsDataURL(file);
                });
            }
            },
            imagetools_toolbar: 'rotateleft rotateright | flipv fliph | editimage imageoptions',
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
        
        tinymce.init({
          selector: '#textJenisPendana',
          height: 300,
        });

    </script>

@endsection