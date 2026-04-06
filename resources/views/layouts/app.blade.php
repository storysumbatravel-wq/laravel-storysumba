<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'StorySumba - Premium Travel Agency')</title>
    <meta name="description" content="@yield('meta_description', 'Experience luxury travel with StorySumba. Premium travel packages, car rentals, and personalized services for discerning travelers.')">
    <meta name="keywords" content="@yield('meta_keywords', 'travel agency, sumba travel, sumba islands, honeymoon, rent car, indonesia travel')">
    <meta name="author" content="StorySumba">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'StorySumba - Premium Travel Agency')">
    <meta property="og:description" content="@yield('og_description', 'Experience luxury travel with StorySumba')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.png') }}">

    @stack('styles')
</head>
<body class="font-body text-luxury-800 antialiased bg-white">
    <!-- Navigation -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="StorySumba Logo" class="h-10 w-auto rounded-lg">
                    <span class="font-display text-2xl font-semibold text-white">Story<span class="text-red-400">Sumba</span></span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link text-white/90 hover:text-red-400 transition-colors font-medium">{{ __('messages.nav.home') }}</a>
                    <a href="{{ route('about') }}" class="nav-link text-white/90 hover:text-red-400 transition-colors font-medium">{{ __('messages.nav.about') }}</a>
                    <a href="{{ route('packages.index') }}" class="nav-link text-white/90 hover:text-red-400 transition-colors font-medium">{{ __('messages.nav.packages') }}</a>
                    <a href="{{ route('rentcar.index') }}" class="nav-link text-white/90 hover:text-red-400 transition-colors font-medium">{{ __('messages.nav.rentcar') }}</a>
                    <a href="{{ route('blog.index') }}" class="nav-link text-white/90 hover:text-red-400 transition-colors font-medium">{{ __('messages.nav.blog') }}</a>
                    <a href="{{ route('contact') }}" class="nav-link text-white/90 hover:text-red-400 transition-colors font-medium">{{ __('messages.nav.contact') }}</a>
                </div>

                <!-- Right Side -->
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- Language Switcher -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-white/90 hover:text-red-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <span class="uppercase text-sm font-medium">{{ app()->getLocale() }}</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-luxury opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 overflow-hidden">
                            <a href="{{ route('language', 'en') }}" class="block px-4 py-3 text-sm text-luxury-700 hover:bg-red-50 hover:text-red-600 transition-colors {{ app()->getLocale() === 'en' ? 'bg-red-50 text-red-600' : '' }}">English</a>
                            <a href="{{ route('language', 'id') }}" class="block px-4 py-3 text-sm text-luxury-700 hover:bg-red-50 hover:text-red-600 transition-colors {{ app()->getLocale() === 'id' ? 'bg-red-50 text-red-600' : '' }}">Indonesia</a>
                        </div>
                    </div>

                    <a href="{{ route('admin.login') }}" class="px-6 py-2.5 bg-red-500 text-white rounded-full font-medium hover:bg-red-600 transition-colors shadow-red hover:shadow-lg">
                        {{ __('messages.nav.login') }}
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="lg:hidden p-2 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-luxury-900/98 backdrop-blur-xl border-t border-white/10">
            <div class="px-4 py-6 space-y-4">
                <a href="{{ route('home') }}" class="block py-2 text-white/90 hover:text-red-400 transition-colors">{{ __('messages.nav.home') }}</a>
                <a href="{{ route('about') }}" class="block py-2 text-white/90 hover:text-red-400 transition-colors">{{ __('messages.nav.about') }}</a>
                <a href="{{ route('packages.index') }}" class="block py-2 text-white/90 hover:text-red-400 transition-colors">{{ __('messages.nav.packages') }}</a>
                <a href="{{ route('rentcar.index') }}" class="block py-2 text-white/90 hover:text-red-400 transition-colors">{{ __('messages.nav.rentcar') }}</a>
                <a href="{{ route('blog.index') }}" class="block py-2 text-white/90 hover:text-red-400 transition-colors">{{ __('messages.nav.blog') }}</a>
                <a href="{{ route('contact') }}" class="block py-2 text-white/90 hover:text-red-400 transition-colors">{{ __('messages.nav.contact') }}</a>

                <div class="flex items-center space-x-4 pt-4 border-t border-white/10">
                    <a href="{{ route('language', 'en') }}" class="px-4 py-2 text-sm {{ app()->getLocale() === 'en' ? 'text-red-400' : 'text-white/70' }}">EN</a>
                    <a href="{{ route('language', 'id') }}" class="px-4 py-2 text-sm {{ app()->getLocale() === 'id' ? 'text-red-400' : 'text-white/70' }}">ID</a>
                    <a href="{{ route('admin.login') }}" class="ml-auto px-6 py-2 bg-red-500 text-white rounded-full text-sm font-medium">
                        {{ __('messages.nav.login') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-luxury-900 text-white pt-20 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="StorySumba Logo" class="h-10 w-auto rounded-lg mb-6">
                        <span class="font-display text-2xl font-semibold text-white mb-6">Story<span class="text-red-400">Sumba</span></span>
                    </a>

                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-white/70 mb-6">Jl. Rambu Duka, RT. 026 / RW. 009, Kel. Prailiu, Kec. Kambera, Kab. Sumba Timur<br>Nusa Tenggara Timur 10220<br>Indonesia</span>
                        </li>
                    </ul>

                    <div class="flex space-x-4">
                        <!-- Facebook -->
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-blue-900 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <!-- WhatsApp -->
                        <a href="https://wa.me/6281246994982" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-green-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        <!-- Instagram -->
                        <a href="https://instagram.com/storysumba" target="_blank" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-pink-500 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-display text-lg font-semibold mb-6">{{ __('messages.footer.quick_links') }}</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-white/70 hover:text-red-400 transition-colors">{{ __('messages.nav.about') }}</a></li>
                        <li><a href="{{ route('packages.index') }}" class="text-white/70 hover:text-red-400 transition-colors">{{ __('messages.nav.packages') }}</a></li>
                        <li><a href="{{ route('rentcar.index') }}" class="text-white/70 hover:text-red-400 transition-colors">{{ __('messages.nav.rentcar') }}</a></li>
                        <li><a href="{{ route('blog.index') }}" class="text-white/70 hover:text-red-400 transition-colors">{{ __('messages.nav.blog') }}</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white/70 hover:text-red-400 transition-colors">{{ __('messages.nav.contact') }}</a></li>
                    </ul>
                </div>

                <!-- Ijin -->
                <div>
                    <h4 class="font-display text-lg font-semibold mb-6">{{ __('messages.footer.permits') }}</h4>
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/ijin.jpg') }}" alt="StorySumba Logo" class="h-40 w-auto rounded-lg">
                    </a>
                </div>

                <!-- Subsidiary Of -->
                <div>
                    <h4 class="font-display text-lg font-semibold mb-6">{{ __('messages.footer.subsidiary of') }}</h4>
                    <a href="https://www.mahakaattraction.id/" target="_blank" class="flex items-center space-x-2">
                        <img src="{{ asset('images/footer-1.jpg') }}" alt="StorySumba Logo" class="h-10 w-auto rounded-lg">
                    </a>
                </div>

            </div>

            <!-- Bottom -->
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between">
                <p class="text-white/50 text-sm">
                    © {{ date('Y') }} StorySumba. {{ __('messages.footer.rights') }}.
                </p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-white/50 text-sm hover:text-red-400 transition-colors">{{ __('messages.footer.privacy') }}</a>
                    <a href="#" class="text-white/50 text-sm hover:text-red-400 transition-colors">{{ __('messages.footer.terms') }}</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6281246994982?text=Halo%20StorySumba,%20saya%20ingin%20bertanya%20tentang%20layanan%20travel." target="_blank" class="fixed bottom-8 left-8 z-40 group">
        <div class="relative">
            <!-- Pulse Effect -->
            <span class="absolute inset-0 w-full h-full rounded-full bg-green-500 animate-ping opacity-30"></span>
            <!-- Button -->
            <div class="relative w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-all duration-300 hover:scale-110">
                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <!-- Tooltip -->
            <span class="absolute left-full ml-4 top-1/2 -translate-y-1/2 px-3 py-2 bg-white text-luxury-900 text-sm font-medium rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
                Chat with us
            </span>
        </div>
    </a>

    <!-- Back to Top -->
    <button id="back-to-top" class="fixed bottom-8 right-8 w-12 h-12 bg-red-500 text-white rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-red-600 flex items-center justify-center z-40">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        const navLinks = document.querySelectorAll('.nav-link');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-luxury-900/95', 'backdrop-blur-xl', 'shadow-lg');
            } else {
                navbar.classList.remove('bg-luxury-900/95', 'backdrop-blur-xl', 'shadow-lg');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Back to top
        const backToTop = document.getElementById('back-to-top');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                backToTop.classList.add('opacity-0', 'invisible');
                backToTop.classList.remove('opacity-100', 'visible');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    @stack('scripts')
</body>
</html>
