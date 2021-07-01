@component('component.mail')
    
    @slot('perihal')
        Newsletter
    @endslot
    @slot('content')
        <h1>{{$data['judul_email']}}</h1>
        {!!$data['deskripsi']!!}
    @endslot
@endcomponent