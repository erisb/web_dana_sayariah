<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    @include('includes.sukuk.header')
    <title>@yield('title')</title>
</head>
  <body id="top">
  <div class="page_loader"></div>

  <!-- main header start -->

  <header class="main-header sticky-header" id="main-header-2">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="navbar navbar-expand-lg navbar-light rounded">
                      <a class="navbar-brand logo navbar-brand d-flex w-50 mr-auto" href="/">
                          <img src="/sukuk_landing_page/assets/img/logos/logo.png" alt="logo">
                      </a>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="fa fa-bars"></span>
                      </button>
                      <div class="navbar-collapse collapse w-100" id="navbar">
                          <ul class="navbar-nav ml-auto">
                              <li class="nav-item dropdown active">
                                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Buka Rekening Surat Berharga Untuk Pendanaan Sukuk!
                                  </a>
                              </li>
                              <li class="nav-item dropdown">
                                  <a class="btn btn-sm btn-white-sm-outline btn-round signup-link" href="#" data-toggle="modal" data-target="#registerModal">DAFTAR</a>
                                  <a class="btn btn-sm btn-theme btn-round signup-link" href="#" data-toggle="modal" data-target="#loginModal">MASUK</a>
                              </li>
                          </ul>
                      </div>
                  </nav>
              </div>
          </div>
      </div>
  </header>
  <!-- main header end -->

  @yield('content')
  @include('includes.login_register')
<body>

</html>
