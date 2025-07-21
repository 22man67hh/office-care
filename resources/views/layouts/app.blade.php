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

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />


     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
                       

  <a href="mailto:manishacharya843@gmail.com?subject=Hello&body=I wanted to reach out." target="_blank" 
   class="fixed bottom-6 left-6 bg-red-500 hover:bg-red-600 text-white flex items-center rounded-full shadow-lg transition-all duration-300 z-50 group overflow-hidden">
   
   <div class="w-14 h-14 flex items-center justify-center">
      <i class="fab fa-envelope text-2xl"></i>
   </div>
   
   <span class="hidden group-hover:inline-block pr-4 whitespace-nowrap text-sm font-medium animate-fade-in">
      Send mail to Manish
   </span>
</a>


    <a href="https://wa.me/9779863224162" target="_blank" 
   class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white flex items-center rounded-full shadow-lg transition-all duration-300 z-50 group overflow-hidden">
   
   <div class="w-14 h-14 flex items-center justify-center">
      <i class="fab fa-whatsapp text-2xl"></i>
   </div>
   
   <span class="hidden group-hover:inline-block pr-4 whitespace-nowrap text-sm font-medium animate-fade-in">
      Chat with Manish
   </span>
</a>

                   
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @stack('scripts')
</body>
</html>
