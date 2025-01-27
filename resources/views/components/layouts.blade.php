<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('icon.png') }}" type="image/png">
    <!-- Vite CSS and JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Font for Inter -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>{{ $title }}</title>
    <style>
        nav a {
            text-decoration: none !important;
            /* Untuk memastikan semua link di navbar tidak ada underline */
        }

        nav a:hover {
            text-decoration: none !important;
            /* Untuk memastikan tidak ada underline pada hover */
        }

        /* Untuk browser berbasis WebKit (Chrome, Safari, Edge) */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Untuk Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
        }
        
    </style>

</head>

<body class="h-full bg-gray-100">

    <div class="min-h-full flex flex-col">
        <!-- Sidebar -->


        <!-- Main Content Area -->
        <div class="flex flex-1 flex-col w-full">
            <!-- Navbar (Header) -->
            <x-navbar></x-navbar>
            <!-- Content Area -->


            <!-- Header Section -->
            <x-header>
                {{ $title }}</x-header>

            <!-- Main Content -->
            <div class="mt-1">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
