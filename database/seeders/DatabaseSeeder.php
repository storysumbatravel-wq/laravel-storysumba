<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Package;
use App\Models\RentCar;
use App\Models\Blog;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@storysumba.com'],
            [
                'name' => 'Admin StorySumba',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        // ---------------------------------------------------------
        // DATA PACKAGE BARU (SUMBA)
        // ---------------------------------------------------------
         $packagesData = [
            [
                'name_en' => 'Sumba Esential Escape',
                'name_id' => 'Sumba Esential Escape',
                'slug' => 'sumba-esential-escape',
                'description_en' => 'Discover the essence of Sumba in this essential escape package.',
                'description_id' => 'Temukan esensi Sumba dalam paket liburan esensial ini.',
                'destination_en' => 'Sumba Island, Indonesia',
                'destination_id' => 'Pulau Sumba, Indonesia',
                'duration_days' => 3,
                'duration_nights' => 2,
                'type' => 'tour', // Pastikan ini sesuai validasi controller atau ubah validasi
                'is_active' => true,
                'is_featured' => true,
                'highlights_en' => ['Weekuri Lagoon', 'Mandorak Hill', 'Traditional Village'],
                'highlights_id' => ['Laguna Weekuri', 'Bukit Mandorak', 'Kampung Adat'],
                'pricing_data' => [ // Ganti key agar tidak tertukar dengan field model
                    ['pax' => 2, 'price' => 4200000, 'cost' => 4195000],
                    ['pax' => 3, 'price' => 3650000, 'cost' => 5470000],
                    // ... data lainnya ...
                ]
            ],
            // ... data package lainnya ...
        ];

        foreach ($packagesData as $item) {
            $pricing = $item['pricing_data']; // Ambil data pricing
            unset($item['pricing_data']); // Hapus dari array utama

            $package = Package::updateOrCreate(['slug' => $item['slug']], $item);

            // Simpan Pricing Options via Relasi
            $package->pricingOptions()->delete(); // Hapus harga lama
            foreach ($pricing as $option) {
                $package->pricingOptions()->create($option);
            }
        }

        // ---------------------------------------------------------
        // RENT CARS (Dengan asumsi cost_price = 60% dari harga jual)
        // ---------------------------------------------------------
        $cars = [
            [
                'name' => 'Toyota Alphard',
                'brand' => 'Toyota',
                'model' => 'Alphard',
                'year' => 2023,
                'transmission' => 'automatic',
                'fuel_type' => 'petrol',
                'seats' => 7,
                'price_per_day' => 2500000,
                'cost_price_per_day' => 1500000, // Ditambahkan
                'price_per_week' => 15000000,
                'plate_number' => 'B 1234 LUX',
                'status' => 'available',
                'description_en' => 'Luxury MPV perfect for family trips.',
                'description_id' => 'MPV mewah untuk perjalanan keluarga.',
                'features' => ['Leather Seats', 'Captain Seat', 'Sunroof'],
                'with_driver' => true,
                'driver_price_per_day' => 500000,
            ],
            [
                'name' => 'Toyota Innova Zenix',
                'brand' => 'Toyota',
                'model' => 'Innova Zenix',
                'year' => 2024,
                'transmission' => 'automatic',
                'fuel_type' => 'hybrid',
                'seats' => 7,
                'price_per_day' => 1200000,
                'cost_price_per_day' => 700000, // Ditambahkan
                'price_per_week' => 7200000,
                'plate_number' => 'B 3456 LUX',
                'status' => 'available',
                'description_en' => 'Modern family car.',
                'description_id' => 'Mobil keluarga modern.',
                'features' => ['Captain Seat', 'Wireless Charging'],
                'with_driver' => true,
                'driver_price_per_day' => 400000,
            ],
        ];

        foreach ($cars as $car) {
            RentCar::updateOrCreate(['plate_number' => $car['plate_number']], $car);
        }

        // Create Blogs
        $blogs = [
            [
                'user_id' => 1,
                'title_en' => 'Top 10 Luxury Destinations for 2024',
                'title_id' => '10 Destinasi Mewah Teratas untuk 2024',
                'slug' => 'top-10-luxury-destinations-2024',
                'excerpt_en' => 'Discover the most exclusive and breathtaking luxury destinations that should be on your travel list this year.',
                'excerpt_id' => 'Temukan destinasi mewah paling eksklusif dan menakjubkan yang harus ada dalam daftar perjalanan Anda tahun ini.',
                'content_en' => '<p>The world is full of extraordinary places waiting to be explored. From pristine beaches to majestic mountains, luxury travel has evolved to offer unique experiences that go beyond mere accommodation...</p>',
                'content_id' => '<p>Dunia penuh dengan tempat-tempat luar biasa yang menunggu untuk dijelajahi. Dari pantai yang masih alami hingga gunung megah, perjalanan mewah telah berkembang untuk menawarkan pengalaman unik...</p>',
                'category' => 'Destination',
                'tags' => ['luxury', 'travel', 'destinations', '2024'],
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'user_id' => 1,
                'title_en' => 'The Art of Slow Travel: Why Less is More',
                'title_id' => 'Seni Perjalanan Lambat: Mengapa Lebih Sedikit Lebih Baik',
                'slug' => 'art-of-slow-travel',
                'excerpt_en' => 'Learn how embracing slow travel can transform your vacation into a meaningful journey of discovery.',
                'excerpt_id' => 'Pelajari bagaimana menerapkan perjalanan lambat dapat mengubah liburan Anda menjadi perjalanan penemuan yang bermakna.',
                'content_en' => '<p>In a world obsessed with speed and efficiency, slow travel offers a refreshing alternative. Its about quality over quantity, depth over breadth...</p>',
                'content_id' => '<p>Dalam dunia yang terobsesi dengan kecepatan dan efisiensi, perjalanan lambat menawarkan alternatif yang menyegarkan. Ini tentang kualitas daripada kuantitas...</p>',
                'category' => 'Travel Tips',
                'tags' => ['slow travel', 'mindful', 'experience'],
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'user_id' => 1,
                'title_en' => 'Ultimate Guide to Honeymoon Planning',
                'title_id' => 'Panduan Ultimate Merencanakan Bulan Madu',
                'slug' => 'ultimate-guide-honeymoon-planning',
                'excerpt_en' => 'Everything you need to know to plan the perfect romantic getaway after your wedding.',
                'excerpt_id' => 'Semua yang perlu Anda ketahui untuk merencanakan liburan romantis yang sempurna setelah pernikahan.',
                'content_en' => '<p>Your honeymoon is more than just a vacation – its the beginning of your life together. Heres how to make it truly unforgettable...</p>',
                'content_id' => '<p>Bulan madu Anda lebih dari sekadar liburan – ini adalah awal kehidupan Anda bersama. Berikut cara membuatnya benar-benar tak terlupakan...</p>',
                'category' => 'Honeymoon',
                'tags' => ['honeymoon', 'romantic', 'wedding', 'planning'],
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }

        // Create Sample Bookings
        Booking::create([
            'booking_code' => 'LV-' . strtoupper(Str::random(8)),
            'type' => 'package',
            'package_id' => 1,
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'customer_phone' => '+6281234567890',
            'start_date' => now()->addDays(14),
            'end_date' => now()->addDays(18),
            'pax' => 2,
            'subtotal' => 25000000,
            'discount' => 0,
            'tax' => 2500000,
            'total' => 27500000,
            'paid_amount' => 27500000,
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        Booking::create([
            'booking_code' => 'LV-' . strtoupper(Str::random(8)),
            'type' => 'rentcar',
            'rent_car_id' => 1,
            'customer_name' => 'Jane Smith',
            'customer_email' => 'jane@example.com',
            'customer_phone' => '+6281234567891',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(10),
            'pax' => 1,
            'subtotal' => 7500000,
            'discount' => 0,
            'tax' => 750000,
            'total' => 8250000,
            'paid_amount' => 4125000,
            'payment_status' => 'partial',
            'status' => 'confirmed',
        ]);
    }
}
