@extends('layouts.app')

@section('title', __('messages.about.page_title'))
@section('meta_description', __('messages.about.meta_description'))

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20">
    <div class="absolute inset-0">
        <img src="{{ asset('images/40.jpg') }}" alt="Travel" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-900/90 via-luxury-900/80 to-luxury-900/60"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-2 bg-red-500/20 text-red-400 rounded-full text-sm font-medium mb-6">
            {{ __('messages.about.title') }}
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-6">
            {{ __('messages.about.subtitle') }}
        </h1>
        {{-- <p class="text-xl text-white/80 max-w-2xl mx-auto">
            {{ __('messages.about.desc') }}
        </p> --}}
    </div>
</section>

<!-- Story Section -->
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <img src="{{ asset('images/component-hero.jpg') }}" alt="Our Story" class="rounded-2xl shadow-luxury w-full">
                <div class="absolute -bottom-6 -right-6 bg-red-500 text-white p-6 rounded-2xl shadow-lg hidden md:block">
                    <p class="font-display text-4xl font-bold">15+</p>
                    <p class="text-red-100 text-sm">{{ __('messages.about.stat3') }}</p>
                </div>
            </div>
            <div>
                <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                    {{ __('messages.about.our_story') }}
                </span>
                <h2 class="font-display text-4xl font-bold text-luxury-900 mb-6">
                    {{ __('messages.about.story_title') }}
                </h2>
                <div class="prose prose-lg text-luxury-600 space-y-4">
                    <p>
                        {{ __('messages.about.story_p1') }}
                    </p>
                    <p>
                        {{ __('messages.about.story_p2') }}
                    </p>
                    <p>
                        {{ __('messages.about.story_p3') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-24 bg-luxury-50 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white p-10 rounded-2xl shadow-luxury">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <h3 class="font-display text-2xl font-bold text-luxury-900 mb-4">{{ __('messages.about.mission_title') }}</h3>
                <p class="text-luxury-600 leading-relaxed">
                    {{ __('messages.about.mission_text') }}
                </p>
            </div>
            <div class="bg-white p-10 rounded-2xl shadow-luxury">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <h3 class="font-display text-2xl font-bold text-luxury-900 mb-4">{{ __('messages.about.vision_title') }}</h3>
                <p class="text-luxury-600 leading-relaxed">
                    {{ __('messages.about.vision_text') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
{{-- <section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                {{ __('messages.about.achievement_title') }}
            </span>
            <h2 class="font-display text-4xl font-bold text-luxury-900">
                {{ __('messages.about.achievement_subtitle') }}
            </h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center p-8 bg-white rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                <p class="font-display text-5xl font-bold text-red-600 mb-2">50K+</p>
                <p class="text-luxury-500">{{ __('messages.about.stat1') }}</p>
            </div>
            <div class="text-center p-8 bg-white rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                <p class="font-display text-5xl font-bold text-red-600 mb-2">100+</p>
                <p class="text-luxury-500">{{ __('messages.about.stat2') }}</p>
            </div>
            <div class="text-center p-8 bg-white rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                <p class="font-display text-5xl font-bold text-red-600 mb-2">15+</p>
                <p class="text-luxury-500">{{ __('messages.about.stat3') }}</p>
            </div>
            <div class="text-center p-8 bg-white rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                <p class="font-display text-5xl font-bold text-red-600 mb-2">25+</p>
                <p class="text-luxury-500">{{ __('messages.about.stat4') }}</p>
            </div>
        </div>
    </div>
</section> --}}

<!-- Team Section -->
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <img src="{{ asset('images/evan.jpg') }}" alt="Our Story" class="rounded-2xl shadow-luxury w-full">
                <div class="absolute -bottom-6 -right-6 bg-red-500 text-white p-6 rounded-2xl shadow-lg hidden md:block">
                    <p class="font-display text-4xl font-bold">15+</p>
                    <p class="text-red-100 text-sm">{{ __('messages.about.stat3') }}</p>
                </div>
            </div>
            <div>
                <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                    {{ __('messages.about.our_story2') }}
                </span>
                <h2 class="font-display text-4xl font-bold text-luxury-900 mb-6">
                    {{ __('messages.about.story_title2') }}
                </h2>
                <div class="prose prose-lg text-luxury-600 space-y-4">
                    <p>
                        {{ __('messages.about.story_p12') }}
                    </p>
                    {{-- <p>
                        {{ __('messages.about.story_p2') }}
                    </p> --}}
                    {{-- <p>
                        {{ __('messages.about.story_p3') }}
                    </p> --}}
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Why Choose Us -->
<section class="py-24 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-red-100 text-red-600 rounded-full text-sm font-medium mb-4">
                {{ __('messages.about.why_title') }}
            </span>
            <h2 class="font-display text-4xl font-bold text-luxury-900 mb-4">
                {{ __('messages.about.why_subtitle') }}
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8">
                <div class="w-20 h-20 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-semibold text-luxury-900 mb-3">{{ __('messages.about.feature1_title') }}</h3>
                <p class="text-luxury-600">{{ __('messages.about.feature1_desc') }}</p>
            </div>
            <div class="text-center p-8">
                <div class="w-20 h-20 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-semibold text-luxury-900 mb-3">{{ __('messages.about.feature2_title') }}</h3>
                <p class="text-luxury-600">{{ __('messages.about.feature2_desc') }}</p>
            </div>
            <div class="text-center p-8">
                <div class="w-20 h-20 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="font-display text-xl font-semibold text-luxury-900 mb-3">{{ __('messages.about.feature3_title') }}</h3>
                <p class="text-luxury-600">{{ __('messages.about.feature3_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="relative bg-gradient-to-br from-luxury-900 to-luxury-800 rounded-3xl overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <img src="{{ asset('images/component-hero.jpg') }}" alt="Background" class="w-full h-full object-cover">
            </div>
            <div class="relative p-12 md:p-16 text-center">
                <h2 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">
                    {{ __('messages.about.cta_title') }}
                </h2>
                <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
                    {{ __('messages.about.cta_desc') }}
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-red-500 text-white rounded-full font-semibold hover:bg-red-600 transition-all duration-300 shadow-red hover:shadow-lg hover:-translate-y-1">
                        {{ __('messages.about.cta_btn1') }}
                    </a>
                    <a href="{{ route('packages.index') }}" class="px-8 py-4 bg-white/10 text-white border border-white/30 rounded-full font-semibold hover:bg-white/20 transition-all duration-300 backdrop-blur-sm hover:-translate-y-1">
                        {{ __('messages.about.cta_btn2') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
