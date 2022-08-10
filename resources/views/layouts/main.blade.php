<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alatan's Working Support</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Codedthemes" />
    @include('includes.assets')
    @yield('custom-asset')
</head>
<body class="">
    @if(!Auth::guest())
        @include('includes.loader')
        @include('includes.menus')
        @include('includes.header')
    @endif
    
    @yield('content')
</body>
@include('includes.scripts')
@yield('custom-script')
</html>