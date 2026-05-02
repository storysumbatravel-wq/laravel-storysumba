@extends('layouts.app')

@section('title', 'Contact Us - StorySumba')
@section('meta_description', 'Get in touch with StorySumba. We are here to help you plan your dream vacation. Contact us for inquiries, bookings, and support.')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20">
    <div class="absolute inset-0">
        <img src="{{ asset('images/component-hero.jpg') }}" alt="Contact Us" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-luxury-900/90 via-luxury-900/80 to-luxury-900/60"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block px-4 py-2 bg-red-500/20 text-red-400 rounded-full text-sm font-medium mb-6">
            {{ __('messages.contact.badge') }}
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mb-6">
            {{ __('messages.contact.title') }}
        </h1>
        <p class="text-xl text-white/80 max-w-2xl mx-auto">
            {{ __('messages.contact.subtitle') }}
        </p>
    </div>
</section>

<!-- Contact Content -->
<section class="py-20 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- Contact Info Cards -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Address -->
                <div class="bg-white p-6 rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-luxury-900 mb-1">{{ __('messages.contact.address') }}</h3>
                            <p class="text-luxury-600">Jl. Rambu Duka, RT. 026 / RW. 009,<br>Kel. Prailiu, Kec. Kambera, Kab. Sumba Timur, <br>NTT, Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="bg-white p-6 rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-luxury-900 mb-1">{{ __('messages.contact.phone_label') }}</h3>
                            <p class="text-luxury-600">+62812 8776 3530</p>
                            <p class="text-luxury-600">+62812 4699 4982 (WhatsApp)</p>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="bg-white p-6 rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-luxury-900 mb-1">{{ __('messages.contact.email_label') }}</h3>
                            <p class="text-luxury-600">storysumbatravel@gmail.com</p>
                        </div>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="bg-white p-6 rounded-2xl shadow-luxury hover:shadow-xl transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-lg font-semibold text-luxury-900 mb-1">{{ __('messages.contact.operating_hours') }}</h3>
                            <p class="text-luxury-600">{{ __('messages.contact.hours_weekday') }}</p>
                            <p class="text-luxury-600">{{ __('messages.contact.hours_saturday') }}</p>
                            <p class="text-red-600 text-sm mt-1">{{ __('messages.contact.support_note') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-luxury p-8 md:p-12">
                    <h2 class="font-display text-3xl font-bold text-luxury-900 mb-2">{{ __('messages.contact.form_title') }}</h2>
                    <p class="text-luxury-500 mb-8">{{ __('messages.contact.form_desc') }}</p>

                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-700">{{ session('success') }}</span>
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-luxury-700 mb-2">{{ __('messages.contact.name') }} *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-luxury-400"
                                       placeholder="{{ __('messages.contact.placeholder_name') }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-luxury-700 mb-2">{{ __('messages.contact.email') }} *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-luxury-400"
                                       placeholder="{{ __('messages.contact.placeholder_email') }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-luxury-700 mb-2">{{ __('messages.contact.phone') }}</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-luxury-400"
                                       placeholder="{{ __('messages.contact.placeholder_phone') }}">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-luxury-700 mb-2">{{ __('messages.contact.subject') }} *</label>
                                <select name="subject" id="subject" required
                                        class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all appearance-none cursor-pointer">
                                    <option value="">{{ __('messages.contact.placeholder_subject') }}</option>
                                    <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>{{ __('messages.contact.subject_general') }}</option>
                                    <option value="Booking Question" {{ old('subject') == 'Booking Question' ? 'selected' : '' }}>{{ __('messages.contact.subject_booking') }}</option>
                                    <option value="Custom Trip Request" {{ old('subject') == 'Custom Trip Request' ? 'selected' : '' }}>{{ __('messages.contact.subject_custom') }}</option>
                                    <option value="Partnership" {{ old('subject') == 'Partnership' ? 'selected' : '' }}>{{ __('messages.contact.subject_partnership') }}</option>
                                    <option value="Feedback" {{ old('subject') == 'Feedback' ? 'selected' : '' }}>{{ __('messages.contact.subject_feedback') }}</option>
                                    <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>{{ __('messages.contact.subject_other') }}</option>
                                </select>
                                @error('subject')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-luxury-700 mb-2">{{ __('messages.contact.message') }} *</label>
                            <textarea name="message" id="message" rows="5" required
                                      class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all placeholder-luxury-400 resize-none"
                                      placeholder="{{ __('messages.contact.placeholder_message') }}">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="newsletter" id="newsletter" value="1" class="w-5 h-5 text-red-600 rounded border-luxury-300 focus:ring-red-500">
                            <label for="newsletter" class="text-sm text-luxury-600">{{ __('messages.contact.newsletter') }}</label>
                        </div>

                        <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-xl font-bold text-lg hover:bg-red-600 transition-all shadow-red hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                            <span>{{ __('messages.contact.send') }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="px-4 pb-20">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-3xl shadow-luxury overflow-hidden">
            <div class="h-96 bg-luxury-100 relative">
                <!-- Embedded Google Map -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7866.444826685595!2d120.26803550418423!3d-9.662028137958316!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4c9b294756f9cd%3A0x7fea0ee0bb898e2a!2sStorysumba!5e0!3m2!1sid!2sid!4v1777646565402!5m2!1sid!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-luxury-50 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl md:text-4xl font-bold text-luxury-900 mb-4">{{ __('messages.faq.title') }}</h2>
            <p class="text-luxury-600">{{ __('messages.faq.subtitle') }}</p>
        </div>

        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <details class="bg-white rounded-2xl shadow-luxury group">
                <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                    <span class="font-semibold text-luxury-900">{{ __('messages.faq.q1') }}</span>
                    <svg class="w-5 h-5 text-red-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="px-6 pb-6 text-luxury-600">
                    {{ __('messages.faq.a1') }}
                </div>
            </details>

            <!-- FAQ Item 2 -->
            <details class="bg-white rounded-2xl shadow-luxury group">
                <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                    <span class="font-semibold text-luxury-900">{{ __('messages.faq.q2') }}</span>
                    <svg class="w-5 h-5 text-red-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="px-6 pb-6 text-luxury-600">
                    {{ __('messages.faq.a2') }}
                </div>
            </details>

            <!-- FAQ Item 3 -->
            <details class="bg-white rounded-2xl shadow-luxury group">
                <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                    <span class="font-semibold text-luxury-900">{{ __('messages.faq.q3') }}</span>
                    <svg class="w-5 h-5 text-red-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="px-6 pb-6 text-luxury-600">
                    {{ __('messages.faq.a3') }}
                </div>
            </details>

            <!-- FAQ Item 4 -->
            <details class="bg-white rounded-2xl shadow-luxury group">
                <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                    <span class="font-semibold text-luxury-900">{{ __('messages.faq.q4') }}</span>
                    <svg class="w-5 h-5 text-red-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="px-6 pb-6 text-luxury-600">
                    {{ __('messages.faq.a4') }}
                </div>
            </details>
        </div>
    </div>
</section>
@endsection
