<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Car;
use App\Models\Footer;
use App\Models\Logo;
use App\Models\Qris;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Admin Address'
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '081298765432',
            'address' => 'User Address'
        ]);

        // Create Sample Cars
        $cars = [
            [
                'name' => 'Honda Brio RS',
                'type' => 'Brio',
                'description' => 'Compact city car perfect for daily commute. Fuel efficient and easy to maneuver in traffic.',
                'price_per_day' => 250000,
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'available' => true,
                'image' => 'cars/brio.jpg'
            ],
            [
                'name' => 'Honda Jazz RS',
                'type' => 'Jazz',
                'description' => 'Spacious hatchback with magic seats. Versatile and comfortable for family trips.',
                'price_per_day' => 300000,
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'available' => true,
                'image' => 'cars/jazz.jpg'
            ],
            [
                'name' => 'Honda Civic Turbo',
                'type' => 'Civic',
                'description' => 'Sporty sedan with turbo engine. Perfect for those who love performance and style.',
                'price_per_day' => 450000,
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'available' => true,
                'image' => 'cars/civic.jpg'
            ],
            [
                'name' => 'Honda HR-V Turbo',
                'type' => 'HR-V',
                'description' => 'Compact SUV with premium features. Comfortable for both city and off-road driving.',
                'price_per_day' => 500000,
                'seats' => 5,
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'available' => false,
                'image' => 'cars/hrv.jpg'
            ],
            [
                'name' => 'Honda CR-V Turbo',
                'type' => 'CR-V',
                'description' => 'Premium SUV with spacious interior and advanced safety features.',
                'price_per_day' => 600000,
                'seats' => 7,
                'transmission' => 'Automatic',
                'fuel_type' => 'Petrol',
                'available' => true,
                'image' => 'cars/crv.jpg'
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }

        // Create About Page Data
        About::create([
            'name' => 'Syarifatul Azkiya Alganjari',
            'nim' => '241011701321',
            'class' => '03SIFP014',
            'major' => 'Sistem Informasi',
            'description' => 'HoppWheels is a Honda car rental website built with Laravel 10. This project demonstrates various web development technologies including authentication, CRUD operations, file uploads, QRIS payment system, and RESTful API.',
            'features' => 'Laravel 10, Laravel Breeze, Blade Template, Role & Middleware, CRUD Operations, File Upload, QRIS Payment, Notification System, REST API, UI Design',
            'avatar' => 'about/avatar.jpg'
        ]);

        // Create Logo
        Logo::create([
            'logo_path' => 'logo/hoppwheels-logo.png',
            'favicon_path' => 'logo/favicon.ico',
            'is_active' => true
        ]);

        // Create Footer
        Footer::create([
            'company_name' => 'HoppWheels',
            'address' => 'Jl. Honda No. 123, Jakarta Selatan, Indonesia',
            'phone' => '+62 21 1234 5678',
            'email' => 'info@hoppwheels.com',
            'copyright' => '© 2023 HoppWheels. All rights reserved.',
            'social_links' => json_encode([
                'facebook' => 'https://facebook.com/hoppwheels',
                'instagram' => 'https://instagram.com/hoppwheels',
                'twitter' => 'https://twitter.com/hoppwheels',
                'whatsapp' => 'https://wa.me/62812345678'
            ])
        ]);

        // Create QRIS
        Qris::create([
            'bank_name' => 'Bank Central Asia',
            'account_name' => 'PT HoppWheels Indonesia',
            'qris_image' => 'qris/default-qris.png',
            'is_active' => true
        ]);
    }
}