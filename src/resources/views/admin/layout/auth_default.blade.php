<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta property="og:title" content="{{ helper::appdata('')->meta_title }}" />

    <meta property="og:description" content="{{ helper::appdata('')->meta_description }}" />

    <meta property="og:image" content='{{ helper::image_path(helper::appdata('')->og_image) }}' />

    <title>{{ helper::appdata('')->web_title }}</title>

    <link rel="icon" type="image" sizes="16x16" href="{{ helper::image_path(helper::appdata('')->favicon) }}">

    <!-- Favicon icon -->

    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap/bootstrap.min.css') }}">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{ asset('admin-assets/css/fontawesome/all.min.css') }}">

    <!-- FontAwesome CSS -->

    <link rel="stylesheet" href="{{ asset('admin-assets/css/toastr/toastr.min.css') }}">

    <!-- FontAwesome CSS -->

    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}"><!-- Custom CSS -->

    <link rel="stylesheet" href="{{ asset('admin-assets/css/responsive.css') }}"><!-- Responsive CSS -->

</head>



<body>

    @include('admin.layout.preloader')

    <main>

        @yield('content')

    </main>

    <script src="{{ asset('admin-assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->

    <script src="{{ asset('admin-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->

    <script src="{{ asset('admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->





    <script>

        toastr.options = {

            "closeButton": true,

        }

        @if (Session::has('success'))

            toastr.success("{{ session('success') }}");

        @endif

        @if (Session::has('error'))

            toastr.error("{{ session('error') }}");

        @endif

        

    </script>

    <script src="{{ asset('admin-assets/js/auth_default.js') }}"></script>

    @yield('scripts')

</body>



</html>

