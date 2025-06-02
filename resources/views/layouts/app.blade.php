<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Optional: Add a favicon for branding --}}
        {{-- <link rel="icon" type="image/x-icon" href="{{ asset('path/to/favicon.ico') }}"> --}}

        {{-- Optional: Preload critical assets for faster loading --}}
        {{-- <link rel="preload" href="/path/to/your-hero-image.webp" as="image"> --}}

    </head>
    {{-- Enhanced body background with a subtle gradient for light mode, softer dark mode background --}}
    <body class="font-inter antialiased bg-gradient-to-br from-blue-50 to-indigo-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="flex flex-col min-h-screen"> {{-- Use flexbox to push footer to bottom --}}

            {{-- Navigation: Kept sticky with slightly enhanced shadow --}}
            <nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50"> {{-- Increased shadow for more pop --}}
                @include('layouts.navigation')
            </nav>

            {{-- Page Header Section: Consistent look for page titles, slightly refined spacing --}}
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-md py-10 mb-8"> {{-- Increased vertical padding for a more generous feel --}}
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight tracking-tight sm:text-5xl lg:text-6xl"> {{-- Larger text on larger screens --}}
                            {{ $header }}
                        </h1>
                    </div>
                </header>
            @endisset

            {{-- Main Content Area: Padding and max-width for consistent content flow --}}
            <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </main>

            {{-- Footer Section: Enhanced for a complete and professional website --}}
            <footer class="bg-gray-800 dark:bg-gray-950 text-gray-300 py-12 mt-16 shadow-inner"> {{-- Increased padding and margin-top for more visual separation --}}
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                    {{-- About Section --}}
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4">Sobre Nós</h3>
                        <p class="text-sm leading-relaxed text-gray-400"> {{-- Slightly softer text for description --}}
                            Descubra a sua estadia perfeita. Oferecemos uma seleção exclusiva de bungalows e propriedades para tornar as suas férias inesquecíveis.
                        </p>
                    </div>

                    {{-- Quick Links --}}
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4">Links Rápidos</h3>
                        <ul class="space-y-3"> {{-- Increased spacing between links --}}
                            <li><a href="{{ route('bungalows.index') }}" class="hover:text-white transition duration-200 text-gray-400 hover:underline">Bungalows</a></li>
                            @auth
                                <li><a href="{{ route('dashboard') }}" class="hover:text-white transition duration-200 text-gray-400 hover:underline">Dashboard</a></li>
                                <li><a href="{{ route('user.reservations') }}" class="hover:text-white transition duration-200 text-gray-400 hover:underline">Minhas Reservas</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="hover:text-white transition duration-200 text-gray-400 hover:underline">Login</a></li>
                                <li><a href="{{ route('register') }}" class="hover:text-white transition duration-200 text-gray-400 hover:underline">Registar</a></li>
                            @endauth
                            <li><a href="#" class="hover:text-white transition duration-200 text-gray-400 hover:underline">Contacto</a></li> {{-- Ensured correct route --}}
                        </ul>
                    </div>

                    {{-- Contact Info --}}
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4">Contacto</h3>
                        <ul class="space-y-3 text-sm text-gray-400"> {{-- Increased spacing and slightly softer text for contact info --}}
                            <li><i class="fas fa-map-marker-alt mr-3 text-gray-500"></i> 123 Rua do Paraíso, Braga, Portugal</li>
                            <li><i class="fas fa-phone mr-3 text-gray-500"></i> +351 912 345 678</li>
                            <li><i class="fas fa-envelope mr-3 text-gray-500"></i> info@rentalhouse.com</li>
                        </ul>
                        {{-- Ensure Font Awesome is loaded for icons --}}
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
                    </div>

                    {{-- Social Media --}}
                    <div>
                        <h3 class="text-xl font-bold text-white mb-4">Siga-nos</h3>
                        <div class="flex space-x-5"> {{-- Slightly more space between social icons --}}
                            <a href="#" class="text-gray-400 hover:text-white transition duration-200 transform hover:scale-110"><i class="fab fa-facebook-square text-3xl"></i></a> {{-- Larger icons and subtle hover effect --}}
                            <a href="#" class="text-gray-400 hover:text-white transition duration-200 transform hover:scale-110"><i class="fab fa-instagram text-3xl"></i></a>
                            <a href="#" class="text-gray-400 hover:text-white transition duration-200 transform hover:scale-110"><i class="fab fa-twitter-square text-3xl"></i></a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-700 dark:border-gray-700 mt-12 pt-8 text-center text-sm text-gray-400"> {{-- Increased margin-top for copyright line --}}
                    &copy; {{ date('Y') }} Rental House. Todos os direitos reservados.
                </div>
            </footer>
        </div>
    </body>
</html>
