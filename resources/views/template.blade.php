<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
<script src="{{ asset('assets/bootstrap/js/bootstrap.js') }}"></script>

<body>
    @include('navbar')

    @yield('content')

</body>

</html>
