<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Office Care Nepal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                /* [Previous CSS content remains the same] */
            </style>
        @endif
    </head>
    <body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 flex p-2 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] mb-16">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4 animate-pulse">Manish Raj Acharya</h1>
            </div>
            @if (Route::has('login'))
                <nav class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span class="ml-2 text-xl font-bold text-gray-800 dark:text-white">Office Care Nepal</span>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-300 font-medium text-sm"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="px-5 py-2 text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition duration-300 font-medium text-sm"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-300 font-medium text-sm">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>

                <div class="mt-10 text-center">
                    <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">Welcome to Office Care Nepal Task </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
Task Completion for the job selection,please logged in or register to access the Task management                    </p>
                    
                    <div class="mt-8 flex justify-center gap-4">
                        <a href="mailto:manishacharya843@gmail.com?subject=Hello&body=I wanted to reach out." class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-300 font-medium">
                            Mail me
                        </a>
    <a href="https://wa.me/9779863224162" target="_blank" class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 z-50">
            <i class="fab fa-whatsapp text-2xl"></i>
        </a>
                    </div>
                </div>
            @endif
        </header>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
        
        <footer class="mt-16 text-center text-gray-500 dark:text-gray-400 text-sm">
            © {{ date('Y') }} Office Care Nepal. All rights reserved.
        </footer>
    </body>
</html>