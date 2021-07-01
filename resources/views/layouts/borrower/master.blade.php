<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>@yield('title')</title>

        <!-- style -->
        @include('includes.borrower.head')
        <!-- END Stylesheets -->
    </head>
    <body>
        <div id="page-container" class="sidebar-o side-scroll page-header-modern main-content-narrow">
            @include('includes.borrower.left_top_menu')
            @yield('content')
        </div>
        <!-- END Page Container -->

        <!-- Codebase JS -->
        @include('includes.borrower.scripts')
    </body>
</html>