<nav id="sidebar">
  <div class="sidebar-header">
    <!-- <a class="align-middle"href="/" ><img src="/img/danasyariahlogo.png" alt="logo danasyariah" ></a> -->
    <a href="/">
        <img src="/img/logodsi-sidebar.png" class="rounded mx-auto d-block logo pt-3" style="height: 60px" alt="...">
    </a>
    <div id="profile_picture">
      {{-- @if(  empty(Auth::user()->detilInvestor) )
      <img alt="">
      @else --}}
      <div class="agent-photo">
        <a href="#">
          <img class="img-fluid "  src="{{ !empty(Auth::user()->detilInvestor) ? Storage::url(Auth::user()->detilInvestor->pic_investor) : asset('img/profile.png') }}" alt="" title="{{ !empty(Auth::user()->detilInvestor) ? Auth::user()->detilInvestor->nama_investor : '' }}">
        </a>
      </div>
      {{-- @endif --}}
    </div>
    <h6 class="center" id="profile_name">{{ !empty(Auth::user()->detilInvestor) ? Auth::user()->detilInvestor->nama_investor : 'Hi' }}</h6>
  </div>

  <ul class="list-unstyled components mt-4 mb-4">
    <li class="active">
      <a href="/user/dashboard"><i class="fas fa-tachometer-alt"></i> Beranda</a>
    </li>
    
  <li>
      <a href="/user/investation_feed"><i class="fas fa-file-signature"></i> Pilih Pendanaan</a>
  </li>
  
    
    <!--Request OJK -->
  {{-- <li>
    <a href="/user/selected_proyek"><i class="fas fa-file-signature"></i> Proyek Dipilih</a>
  </li> --}}
    
    <!-- {{-- <li>
      <a href="/user/registrasi_sukuk"><i class="fas fa-file-signature"></i> Sukuk</a>
    </li> --}} -->
  
    {{-- <li>
      <a href="#moreMenuSukuk" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-donate"></i> Sukuk</a>
      <ul class="collapse list-unstyled" id="moreMenuSukuk">
        <li class="dropdown-item">
          <a href="/user/registrasi_sukuk_konfirmasi"><i class="fas fa-file-signature"></i> Registrasi</a>
        </li>
        <li class="dropdown-item">
          <a href="/user/list_sukuk"><i class="fas fa-plus-square"></i> Pemesanan</a>
        </li> 
        <li class="dropdown-item">
          <a href="/user/early_redemption_sukuk"><i class="fas fa-calendar-plus"></i> Early Redemption</a>
        </li>
        <li class="dropdown-item">
          <a href="/user/history_sukuk"><i class="fas fa-history"></i> History Transaksi</a>
        </li>
        <li class="dropdown-item">
          <a href="/user/portfolio_sukuk"><i class="fas fa-folder"></i> Portfolio</a>
        </li>
      </ul>
    </li> --}}
    <!--<li>
      <a href="/user/cart"><i class="fas fa-shopping-cart"></i> Keranjang</a>
    </li>-->
    <li>
      <a href="/user/manage_investation"><i class="fas fa-money-bill-wave-alt"></i> Kelola Pendanaan</a>
    </li>
    <li>
      <a href="#moreMenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-fingerprint"></i> Menu Lain</a>
      <ul class="collapse list-unstyled" id="moreMenu">
        <li class="dropdown-item">
          <a href="#" id="kelola" {{ session('no_telp_profile') ? '' : 'data-toggle=modal data-target=#konfirm_telp_profile' }}><i class="fas fa-user"></i> Kelola Profil</a>
        </li>
        <li class="dropdown-item">
          <a href="#" {{ session('no_telp_ubah_password') ? '' : 'data-toggle=modal data-target=#konfirm_telp_ubah_password' }}><i class="fas fa-check"></i> Ubah Kata Sandi</a>
        </li>
        <li class="dropdown-item">
          <a href="/user/tambahdana"><i class="fas fa-plus"></i> Tambah Dana</a>
        </li>
        {{-- <li class="dropdown-item">
          <a href="/user/tambahdana_midtrans"><i class="fas fa-plus"></i> Tambah Dana</a>
        </li> --}}
        <li class="dropdown-item"> 
          <a href="/user/withdraw_request" ><i class="fas fa-american-sign-language-interpreting"></i>Penarikan Dana</a>
          
        </li>
        <li class="dropdown-item">
          <a href="/user/mutation_history"><i class="fas fa-history"></i> Riwayat Mutasi</a>
        </li>

        <li class="dropdown-item">
          <a href="/user/unduhAkad"><i class="fas fa-download"></i> Unduh Akad</a>
        </li>

        <li class="dropdown-item">
          <a href="/user/tutorial"><i class="fas fa-play"></i> Panduan</a>
        </li>
      </ul>
    </li>
  </ul>

  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-success btn-block mb-1" id="logout_button">
    <!--{{  __('LOGOUT') }} -->KELUAR
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>
</nav>
<div id="collapse_button">
  <i class="fas fa-bars pt-4"></i>
</div>

<!-- start modal no telp -->
<div class="modal fade" id="konfirm_telp_profile" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Konfirmasi No Telepon : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('user.konfirm.telp')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="investor_id" id="investor_id" value="{{ Auth::id() }}">
                <input type="hidden" name="tipe" value="profile">
                <input type="text" class="form-control" name="no_telp" required="required">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Konfirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal no telp -->

<!-- start modal no telp -->
<div class="modal fade" id="konfirm_telp_ubah_password" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Konfirmasi No Telepon : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('user.konfirm.telp')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="investor_id" value="{{ Auth::id() }}">
                <input type="hidden" name="tipe" value="pass">
                <input type="text" class="form-control" name="no_telp" required="required">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Konfirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal no telp -->

<!-- start modal no telp -->
{{-- <div class="modal fade" id="modal_konfirm_photo" tabindex="-1" role="dialog" data-show="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Maaf anda belum mengunggah poto anda : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('user.konfirm.telp')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
        
                
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_upload" class="btn btn-primary">Unggah Sekarang</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div> --}}
<!-- end modal no telp -->

{{-- @if(session('confirmTelpProfile') !== null)
    <script type="text/javascript">
        $(function() {
            $('#konfirm_telp_profile').modal('show');
        });
    </script>
@elseif(session('confirmTelpUbahPassword') !== null)
    <script type="text/javascript">
        $(function() {
            $('#konfirm_telp_ubah_password').modal('show');
        });
    </script>
@endif --}}
{{-- <script>

$(document).ready(function(){
  
  $('#btn_upload').click(function(){
    location.href = "../user/manage_profile"; 
    
  });
  
  $('#check_photo_user').click(function(){
    location.href = "../user/investation_feed"; 
    
  });
})
</script> --}}
