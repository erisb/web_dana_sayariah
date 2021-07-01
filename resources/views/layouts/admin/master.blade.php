<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    @include('includes.admin.head')
    <title>@yield('title')</title>
    @stack('scripts')
</head>

<body>
    @include('includes.admin.leftnavbar_new')
    @include('includes.admin.topnavbar')
    @yield('content')
    
<body>

</html>