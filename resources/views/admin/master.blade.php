<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="py-5 md:py-0">
    @include('admin.partials.mobile-menu')
    @include('admin.partials.header')
    <div class="flex overflow-hidden">
        @include('admin.partials.sidebar')
        <!-- BEGIN: Content -->
        <main class="intro-y content">
            @yield('content')
        </main>
        <!-- END: Content -->
    </div>
    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('administrator/dist/js/app.js') }}"></script>
    <!-- END: JS Assets-->
</body>

</html>
