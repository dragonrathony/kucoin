<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="">
    <meta name="author"
        content="">

    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <title>Demo KuCoin</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/blog-post.css')}}"
        rel="stylesheet">

    <!-- toastr CSS -->
    <link rel="stylesheet"
        type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet"
        href="{{ asset('css/dashboard.css') }}" />


</head>

<body>

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <!-- Overlay loading -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <!-- toastr js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- @yield('script') -->

</body>

</html>