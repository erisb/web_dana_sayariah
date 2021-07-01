<style>
.login100-more {
    min-width: 50%;
    min-height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 1;
    border-radius: 10px 0 0 10px;
}
.login100-more::before {
    content: "";
    display: block;
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(0,0,0,.3);
    background-image: linear-gradient(45deg,rgb(49, 122, 18, 1),rgb(2, 119, 91, 0.7));
    background-image: -webkit-linear-gradient(45deg,rgb(49, 122, 18, 1),rgb(2, 119, 91, 0.7));
    transition: all .4s ease;
    
}
.logo-render{
    width: 80px;
    height: auto;
    -ms-flex: none;
    -webkit-flex: none;
    flex: none;
    opacity: 0.8;
    margin-right: 50%;
    margin-left: auto;
}
label{
  font-size: .8rem !important;
}
</style>
<div id="{{$modal_id}}" class="modal fade in modal_scroll" role="dialog" >
  <div class="modal-dialog modal-lg modal-dialog-centered ">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        
        <div class="row no-gutters">   
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
              <div class="login100-more" style="background-image: url('img/bg-register.jpg');">
                <div class="d-flex">
                  <div class="p-2 mx-auto text-white p-5 pt-2">
                    <img class="logo-render" src="/img/logo_only_white.png" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="content-form-box forgot-box ">

                    <div class=" container-fluid ">
                        <div>
                            <h5>Hi, Guest ...</h5>
                            <p>Silahkan lengkapi data untuk melanjutkan.</p>
                            <hr>
                          <button type="button" class="close ml-5 mr-5 pr-2 mt-3 text-dark" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true"><i class="lni-close size-sm"></i> </span>
                          </button>
                        </div>
                    </div>

                    <div class="container-fluid">   
               
                    {{$modal_content}}
                    </div>

                </div>
            </div>
            
        </div>

       
      </div>

    </div>

  </div>
</div>