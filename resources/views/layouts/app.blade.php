<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <!-- <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> -->
                    <div class="max-w-7xl mx-auto pt-2 pb-2 px-4 sm:px-6 lg:px-8 flex justify-center">
                        {{ $header }}
                        <div class="flex space-x-4">
                            <a href="{{ route('products.index') }}" class="hover:bg-gray-700 text-white px-3 py-2 rounded">
                                All Products
                            </a>
                            <a href="{{ route('products.module', 'orders') }}" class="hover:bg-gray-700 text-white px-3 py-2 rounded">
                                Orders
                            </a>
                            <a href="{{ route('products.module', 'unreceived') }}" class="hover:bg-gray-700 text-white px-3 py-2 rounded">
                                Unreceived Products
                            </a>
                            <a href="{{ route('products.module', 'received') }}" class="hover:bg-gray-700 text-white px-3 py-2 rounded">
                                Received Products
                            </a>
                            <a href="{{ route('products.module', 'labeling') }}" class="hover:bg-gray-700 text-white px-3 py-2 rounded">
                                Labeling Products
                            </a>
                            <a href="{{ route('products.module', 'stockroom') }}" class="hover:bg-gray-700 text-white px-3 py-2 rounded">
                                Stockroom
                            </a>
                        </div>

                    </div>
                    <!-- </div> -->
                </header>
            @endisset
            

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
    </body>
</html>
