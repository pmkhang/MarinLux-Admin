<!DOCTYPE html>
<html lang="en" class="light">

<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('administrator/dist/images/logo.svg') }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Enigma admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Enigma Admin Template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="LEFT4CODE">
    <title>Login</title>
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="{{ asset('administrator/dist/css/app.css') }}" />
</head>

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <div class="hidden xl:flex flex-col min-h-screen">
                <div class="my-auto">
                    <img alt="Midone - HTML Admin Template" class="-intro-x mt-16"
                        src="{{ asset('administrator/dist/images/logo1.png') }}" width="500px">
                    <div class="-intro-x text-white font-medium text-2xl leading-tight mt-10">
                        A few more clicks to
                        <br>
                        sign in to your account.
                    </div>
                </div>
            </div>
            <div class="h-screen xl:h-auto flex xl:py-0 my-10 xl:my-0">
                <form
                    class="my-auto mx-auto xl:ml-20 bg-white  xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto"
                    method="post">
                    @csrf
                    <h2 class="intro-x font-bold text-2xl mb-3 xl:text-3xl text-center xl:text-left">
                        Sign In
                    </h2>
                    @if ($errors->any())
                        <div class="intro-x alert alert-danger alert-dismissible show flex items-center m-2"
                            role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
                            <div class="flex flex-col">
                                @foreach ($errors->all() as $error)
                                    <p class="text-white">{{ $error }}</p>
                                @endforeach
                            </div>
                            <button type="button" class="btn-close text-white" data-tw-dismiss="alert"
                                aria-label="Close">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="intro-x alert alert-warning alert-dismissible show flex items-center m-2"
                            role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
                            <div class="flex flex-col">
                                <p>{{ Session::get('error') }}</p>
                            </div>
                            <button type="button" class="btn-close text-white" data-tw-dismiss="alert"
                                aria-label="Close">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                    @endif
                    @if (Session::has('warning'))
                        <div class="intro-x alert alert-warning  alert-dismissible show flex items-center m-2"
                            role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
                            <div class="flex flex-col">
                                <p>{{ Session::get('warning') }}</p>
                            </div>
                            <button type="button" class="btn-close text-white" data-tw-dismiss="alert"
                                aria-label="Close">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </button>
                        </div>
                    @endif
                    <div class="intro-x mt-2 text-slate-400 xl:hidden text-center">A few more clicks to sign in to your
                        account. Manage all your e-commerce accounts in one place</div>
                    <div class="intro-x mt-8">
                        <input type="text" class="intro-x login__input form-control py-3 px-4 block"
                            placeholder="Email" name="email">
                        <input type="password" class="intro-x login__input form-control py-3 px-4 block mt-4"
                            placeholder="Password" name="password">
                    </div>
                    <div class="intro-x flex text-slate-600  text-xs sm:text-sm mt-4">
                        <div class="flex items-center mr-auto">
                            <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                            <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                        </div>
                        <a href="#">Forgot Password?</a>
                    </div>

                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Login</button>
                    </div>
                </form>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
    <!-- BEGIN: JS Asset-->
    <script src="{{ asset('administrator/dist/js/app.js') }}"></script>
    <!-- END: JS Asset-->
</body>


</html>
