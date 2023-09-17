<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.header')
    <title>@yield('title')</title>
    @yield('header')
</head>
<body>

@include('includes.navbar')

<div class="container">

    @yield('content')

</div>

@include('includes.footer')
@yield('script')
</body>
</html>


