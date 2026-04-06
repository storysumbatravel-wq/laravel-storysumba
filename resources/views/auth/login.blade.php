<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - StorySumba</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
</head>
<body class="font-body bg-luxury-100 min-h-screen flex items-center justify-center">

    <div class="relative w-full max-w-md mx-4">
        <!-- Background Decorative Elements -->
        <div class="absolute -top-20 -left-20 w-40 h-40 bg-red-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float"></div>
        <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-red-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-float" style="animation-delay: 2s;"></div>

        <!-- Login Card -->
        <div class="relative bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-luxury-900 to-luxury-800 px-8 py-10 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-6">
                    <!-- Perubahan: Logo SVG diganti dengan Image -->
                    <img src="{{ asset('images/logo.png') }}" alt="StorySumba Logo" class="h-20 w-auto rounded-xl">
                </a>
                <h1 class="font-display text-3xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-white/70">Sign in to access admin dashboard</p>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-red-600">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">{{ session('error') }}</span>
                </div>
                @endif

                @if(session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-600 text-sm">
                    {{ session('status') }}
                </div>
                @endif

                <!-- UBAH ACTION KE route('admin.login') -->
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="space-y-5">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-luxury-700 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-luxury-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus
                                       class="w-full pl-12 pr-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-luxury-400"
                                       placeholder="admin@StorySumba.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-luxury-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-luxury-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       required
                                       class="w-full pl-12 pr-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-luxury-400"
                                       placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-red-600 border-luxury-300 rounded focus:ring-red-500">
                                <span class="ml-2 text-sm text-luxury-600">Remember me</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full py-4 bg-red-500 text-white rounded-xl font-bold text-lg hover:bg-red-600 transition-all shadow-red hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                            <span>Sign In</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="my-8 flex items-center">
                    <div class="flex-1 border-t border-luxury-200"></div>
                    <span class="px-4 text-sm text-luxury-400">or</span>
                    <div class="flex-1 border-t border-luxury-200"></div>
                </div>

                <!-- Back to Site -->
                <a href="{{ route('home') }}"
                   class="w-full py-3 border-2 border-luxury-200 text-luxury-700 rounded-xl font-medium hover:border-red-400 hover:text-red-600 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Website</span>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-luxury-400 text-sm mt-8">
            &copy; {{ date('Y') }} StorySumba. All rights reserved.
        </p>
    </div>

</body>
</html>
