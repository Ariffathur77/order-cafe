<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
    @vite('resources/css/app.css') <!-- Jika kamu pakai Vite -->
    @livewireStyles
</head>

<body class="bg-gray-100">

    <!-- Bagian Konten -->
    @yield('content')

    @livewireScripts

    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
    @yield('scripts')
</body>

</html>
