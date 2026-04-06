<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - StorySumba')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: #c93d27; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a7331e; }

        /* Sidebar Widths - Paksa dengan !important */
        .sidebar-expanded { width: 256px !important; } /* w-64 */
        .sidebar-collapsed { width: 80px !important; }  /* w-20 */

        /* Animasi smooth */
        #sidebar {
            transition: width 0.3s ease-in-out, transform 0.3s ease-in-out;
            overflow-x: hidden;
            will-change: transform, width;
        }

        /* Sembunyikan teks saat collapsed */
        .sidebar-collapsed .sidebar-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
            white-space: nowrap;
        }
        .sidebar-collapsed .sidebar-section-title { display: none; }
        .sidebar-collapsed .sidebar-user-details { display: none; }
        .sidebar-collapsed .sidebar-logo-text { display: none; }

        /* Center konten saat collapsed */
        .sidebar-collapsed .sidebar-item-inner {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }
        .sidebar-collapsed .sidebar-logo-container {
            justify-content: center;
        }
        .sidebar-collapsed .sidebar-user-avatar {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
@stack('scripts')
<body class="font-body bg-luxury-100 text-luxury-800 antialiased">
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-expanded bg-luxury-900 text-white flex flex-col h-screen fixed lg:static inset-y-0 left-0 z-50 -translate-x-full lg:translate-x-0">

            <!-- Logo -->
            <div class="h-20 border-b border-white/10 flex items-center px-4">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo-container flex items-center gap-3 w-full overflow-hidden">
                    <!-- BAGIAN LOGO DIUBAH DI SINI -->
                    <div class="w-10 h-10 flex-shrink-0 bg-gradient-to-br rounded-lg flex items-center justify-center overflow-hidden">
                        <!-- SVG diganti menjadi Image -->
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    </div>
                    <span class="sidebar-logo-text sidebar-text font-display text-xl font-semibold whitespace-nowrap transition-opacity duration-300">Story<span class="text-red-400">Sumba</span></span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <div class="sidebar-section-title sidebar-text px-3 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Main Menu</div>

                <!-- Menu Items -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Dashboard</span>
                    </div>
                </a>

                <a href="{{ route('admin.packages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.packages.*') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Packages</span>
                    </div>
                </a>

                <a href="{{ route('admin.rent-cars.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.rent-cars.*') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Rent Cars</span>
                    </div>
                </a>

                <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.blogs.*') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Blog</span>
                    </div>
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Bookings</span>
                    </div>
                </a>

                <div class="sidebar-section-title sidebar-text px-3 pt-4 mb-2 text-xs font-semibold text-white/40 uppercase tracking-wider">Others</div>

                <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Messages</span>
                    </div>
                </a>

                <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.reports') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Reports</span>
                    </div>
                </a>

                <a href="{{ route('admin.pengajuans.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.pengajuans.*') ? 'bg-red-500 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    <div class="sidebar-item-inner flex items-center gap-3 w-full">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="sidebar-text whitespace-nowrap transition-opacity duration-300">Pengajuan Budget</span>
                    </div>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div class="sidebar-user-avatar w-10 h-10 flex-shrink-0 bg-red-500 rounded-full flex items-center justify-center font-bold">
                        {{ Str::substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="sidebar-user-details flex-1 min-w-0 transition-opacity duration-300">
                        <p class="font-medium truncate text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/50">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Navbar -->
            <header class="bg-white shadow-sm h-20 flex items-center justify-between px-4 lg:px-8 border-b border-luxury-100">
                <div class="flex items-center gap-4">
                    <button id="sidebar-toggle" class="flex items-center gap-2 px-4 py-2 bg-luxury-800 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span class="hidden sm:inline">Menu</span>
                    </button>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 text-luxury-600 hover:text-red-600 transition-colors text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span class="hidden sm:inline">View Site</span>
                    </a>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-luxury-50 p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const overlay = document.getElementById('sidebar-overlay');

            // Cek Local Storage untuk state collapse (Desktop)
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';

            // Hanya jalankan logic collapse jika di Desktop
            if (window.innerWidth >= 1024) {
                if (isCollapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                    sidebar.classList.remove('sidebar-expanded');
                }
            }

            // Fungsi Toggle
            toggleBtn.addEventListener('click', function() {
                if (window.innerWidth >= 1024) {
                    // --- Desktop Mode: Toggle Lebar ---
                    sidebar.classList.toggle('sidebar-collapsed');
                    sidebar.classList.toggle('sidebar-expanded');

                    // Simpan state
                    const nowCollapsed = sidebar.classList.contains('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', nowCollapsed);
                } else {
                    // --- Mobile Mode: Toggle Show/Hide ---
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }
            });

            // Close sidebar saat klik overlay (mobile only)
            overlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
        });
    </script>
</body>
</html>
