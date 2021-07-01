<div id="header" class="row d-flex justify-content-end ">
  <!-- <div id="logo">Logo!</div> -->
  <div class="notification pt-3">
    <i class="far fa-bell"></i>
    <div class="notification_content">
      <div class="card text-center ">
        <div class="card-header bg-light">
          Notifikasi
        </div>
        <div class="card-body">
          
        </div>
      </div>
    </div>
  </div>
  <div class="">
      <i class="far fa-power"></i>
  </div>

</div>

@if (session('personaldata'))
    <script>
    window.alert('Please complete your personal data');
    window.location.href="/user/manage_profile"
    </script>
@endif
