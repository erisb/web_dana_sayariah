<nav id="sidebar">
  <div class="sidebar-header">
    <div id="profile_picture">
      <img src="/storage/user/2018-09-10pic_investor.jpg" alt="">
    </div>
    <h3 id="profile_name">Marketing</h3>
    <h4 id="profile_name">{{Auth::user()->username}}</h3>
  </div>
  <hr>

  <ul class="list-unstyled components">
    <li class="active">
      <a href="{{route('marketer.dashboard')}}"><i class="fas fa-home"></i> Dasbor</a>
    </li>
    <li>
      <a href="{{route('marketer.datainvestor')}}"><i class="fas fa-user"></i> Data Pendana</a>
    </li>
    <li>
      <a href="{{route('marketer.mutasi')}}"><i class="fas fa-history"></i> Mutasi rekening </a>
    </li>
  </ul>
  <hr>
  <a href="{{ route('marketer.logout') }}"  class="btn btn-dark btn-block mb-5">
    {{-- __('LOGOUT') --}} Keluar
  </a>
</nav>
<div id="collapse_button">
  <i class="fas fa-bars"></i>
</div>
