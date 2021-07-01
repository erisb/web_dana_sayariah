<div class="row">
@foreach($news as $dataNews)
    <div class="row wow fadeInRight delay-04s my-5 p-3 mx-3 bg-white rounded shadow-sm">
        <div class="col-12 col-sm-6 justify-content-center">
            <img class="blog-theme img-fluid col-12" src="{{asset('/storage')}}/{{$dataNews->image}}" alt="blog-3">
        </div>
        
        <div class="detail col-12 col-sm-6">
            <h2 class="text-left heading">
                <br>
                {{$dataNews->title}}
            </h2>
            <hr>
            <button class="btn btn-color float-right" data-toggle="modal" data-target="#newsModal{{$dataNews->id}}">Detil</button>
        </div>
        <hr>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="newsModal{{$dataNews->id}}">
        <div class="modal-dialog modal-xl" style="min-width:80%;">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header justify-content-center">
                <h4 class="modal-title">{{$dataNews->title}}</h4>
                {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                        <img class="img-fluid " style="max-height:250px !important; width:100%" src="{{asset('/storage')}}/{{$dataNews->image}}" alt="blog-3">
                        <hr>

                        <p style="margin:15px;" >
                            {!! $dataNews->deskripsi !!}
                        </p>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
<div class="d-flex justify-content-center">
    {{$news->links()}}
</div>