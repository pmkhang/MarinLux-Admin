<meta charset="utf-8">
<link href="{{ asset('administrator/dist/images/MarinLux-Logo-Icon.png') }}" rel="shortcut icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')</title>
<!-- BEGIN: CSS Assets-->
@vite('resources/css/app.css')
<link rel="stylesheet" href="{{ asset('administrator/dist/css/app.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<style>
    .hidden {
        visibility: hidden;
    }
</style>
<!-- END: CSS Assets-->
