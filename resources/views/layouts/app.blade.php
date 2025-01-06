<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content -->
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Pesan Error Global -->
        @if (session('error'))
            <div class="bg-red-500 text-white p-4 text-center">
                {{ session('error') }}
            </div>
        @endif

        <!-- Pesan Sukses Global -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Page Content -->
        <main class="py-12">
            @yield('content')
        </main>
    </div>
</body>
</html>