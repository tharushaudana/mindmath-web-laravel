<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free-6.4.2/css/all.min.css') }}">
    @livewireStyles
    @stack('styles')
</head>
<style>
    html {
        height: 100%;
    }
    body {
        height: 100%;
        width: 100%;
        margin: 0;
    }
</style>
<body>
    <div class="w-100 h-100" style="position: relative;">
        @yield('content')
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>