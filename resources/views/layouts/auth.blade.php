<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    {{-- MAZER CSS --}}
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}">
</head>
<body class="bg-light">

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="col-lg-4 col-md-6 col-sm-10">
        @yield('content')
    </div>
</div>

<script src="{{ asset('mazer/assets/compiled/js/app.js') }}"></script>
</body>
</html>
