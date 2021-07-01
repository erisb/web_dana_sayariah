<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    @include('includes.user.head')
    <title>@yield('title')</title>
</head>

<body>
  <div class="wrapper">
    @include('includes.user.sidebar_nav')
    <div id="content">
      <div class="container-fluid" id="body_container">
        @include('includes.user.navbar')
        <div class="py-5 px-3" id="content_body">
          @yield('content')
        </div>
      </div>
      {{-- <div id="footer_container">
        @include('includes.footer')
      </div> --}}
    </div>

  </div>

  <script type="text/javascript" src="{{ asset('/js/user/controller.js') }}"></script>
  <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
  @yield('script')
</body>
</html>
