<div id="{{$modal_id}}" class="modal fade {{$modal_show ?? ''}} in" style="display:block;" role="dialog" >
  <div class="modal-dialog modal-dialog-centered {{$size ?? ''}}">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-header">
            <div class="col-12 row justify-content-center">
              <div class="col-8">
                <img class="col-12" src="/img/danasyariahlogo.png" style="margin: 5px;">
              </div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row justify-content-center" style="background: #0faf3f;">
          <h4 style="color: white; margin: 10px;">{{$modal_title}}</h4>
        </div>

        {{$modal_content}}
      </div>

    </div>

  </div>
</div>
