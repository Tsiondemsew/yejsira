<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yejsira - Handmade Treasures</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    <!-- Navigation Bar -->
    @include('layouts.navigation')

   <!-- HERO SLIDER -->
@if (request()->is('/'))
<div class="container mx-auto mt-6 px-4">
    <div class="swiper mySwiper rounded-lg  h-48 md:h-72 lg:h-96">
        <div class="swiper-wrapper">
            <div class="swiper-slide relative">
                <img src="/banner/slider1.jpg" class="w-full h-full object-cover" alt="Slide 1">
                <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                    <h2 class="text-white text-xl md:text-3xl font-bold text-center">Unique Ethiopian Handicrafts</h2>
                </div>
            </div>
            <div class="swiper-slide relative">
                <img src="/banner/slider2.jpg" class="w-full h-full object-cover" alt="Slide 2">
                <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                    <h2 class="text-white text-xl md:text-3xl font-bold text-center">Artisanal Jewelry & Textiles</h2>
                </div>
            </div>
        </div>

        <!-- Swiper Controls -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
    </div>
</div>
@endif


    <!-- MAIN CONTENT -->
    <main class="min-h-[60vh] px-4 mt-8 max-w-7xl mx-auto">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm text-gray-600">
            <!-- Product Categories -->
            <div>
                <h3 class="font-semibold text-green-700 mb-2">Categories</h3>
                <ul class="space-y-1">
                    @foreach($Categories as $cat)
                        <a href="{{ route('products.byCategory', $cat->id) }}" class="block px-4 py-2 hover:bg-green-50">
                           {{ $cat->name }}
                         </a>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="font-semibold text-green-700 mb-2">Contact</h3>
                <p>Email: info@yejsira.com</p>
                <p>Phone: +251 900 000 000</p>
                <p>Addis Ababa, Ethiopia</p>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="font-semibold text-green-700 mb-2">Follow Us</h3>
                <div class="flex space-x-4 mt-2">
                    <a href="#" class="hover:text-blue-500"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#" class="hover:text-pink-500"><i class="fab fa-instagram"></i> Instagram</a>
                </div>
            </div>
        </div>
        <div class="text-center text-xs py-4 text-gray-400">
            &copy; {{ date('Y') }} Yejsira. All rights reserved.
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            autoplay: {
                delay: 6000,
                disableOnInteraction: false
            }
        });
    </script>
</body>
</html>
