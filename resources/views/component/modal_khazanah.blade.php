

<div id="{{$modal_id}}" class="modal fade in" role="dialog" >
  <div class="modal-dialog modal-sm modal-dialog-centered {{$size ?? ''}}">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        
        <div class="row">                         
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="content-form-box forgot-box-khazanah clearfix " style="padding: 20px 50px;">
                    <div class="login-header clearfix ">
                        <div >
                            <h1>{{$modal_title}} </h1>

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    </div>
                    {{$modal_content}}
                </div>
            </div>
            
        </div>

       
      </div>

    </div>

  </div>
</div>




