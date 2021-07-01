<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.marketer.head')
    <title>@yield('title')</title>
</head>

<body>
  <div class="wrapper">
    @include('includes.marketer.sidebar_nav')
    <div id="content">
      <div class="container-fluid" id="body_container">
        @include('includes.marketer.navbar')
        <div class="py-5 px-3" id="content_body">
          @yield('content')
        </div>
      </div>
      <div id="footer_container">
        @include('includes.footer')
      </div>
    </div>

  </div>

  <script type="text/javascript" src="{{ asset('/js/user/controller.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/user/canvasjs.min.js') }}"></script>

</body>
</html>
