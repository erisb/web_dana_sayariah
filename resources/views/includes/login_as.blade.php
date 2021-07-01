@component('component.modal_login_as')
    @slot('modal_id') loginModalAs @endslot
    @slot('modal_title') 
    
        Login
    
    @endslot

    @slot('modal_content')
    
        <div class="panel-heading">
            <div class="row">
                <div class="col-12">
                <ul class=" nav nav-pills nav-fill">
                    <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#loginModalInvestor" data-dismiss="modal" aria-label="Close" class="nav-link active" >INVESTOR</a>
                    <!--<a href="#" data-toggle="modal" data-target="#loginModalInvestor" class="nav-link active" id="login-form-link">INVESTOR</a>-->
                    </li>
                
                    <li class="nav-item">
                        <a href="#" data-toggle="modal" data-target="#loginModalBorrower" class="nav-link" id="register-form-link">BORROWER</a>
                    </li>
                </ul>
                </div>
            </div>
            <hr>
        </div>   
    @endslot
@endcomponent