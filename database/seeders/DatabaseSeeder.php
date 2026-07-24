<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama
        \App\Models\User::updateOrCreate([
            'email' => 'admin@amikom.ac.id',
        ], [
            'name' => 'Admin Amikom',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::updateOrCreate([
            'email' => 'superadmin@amikom.ac.id',
        ], [
            'name' => 'Super Admin Amikom',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        \App\Models\User::updateOrCreate([
            'email' => 'partner@amikom.ac.id',
        ], [
            'name' => 'Partner Amikom',
            'password' => bcrypt('password'),
            'role' => 'partner',
        ]);

        // 2. Insert Kategori Event
        $category = \App\Models\Category::updateOrCreate([
            'name' => 'Seminar IT',
        ], [
            'name' => 'Seminar IT',
        ]);

        $category2 = \App\Models\Category::updateOrCreate([
            'name' => 'Entertaiment',
        ], [
            'name' => 'Entertaiment',
        ]);

        // 3. Insert Sampel Events
        \App\Models\Event::updateOrCreate([
            'title' => 'Jazz Night 2025',
        ], [
            'category_id' => $category2->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        \App\Models\Event::updateOrCreate([
            'title' => 'Hackaton - Unleash Your Inner Developer',
        ], [
            'category_id' => $category->id,
            'title' => 'Hackaton - Unleash Your Inner Developer',
            'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
            'date' => '2026-05-05 10:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        \App\Models\Event::updateOrCreate([
            'title' => 'AI & FUTURE TECH SUMMIT 2026',
        ], [
            'category_id' => $category->id,
            'title' => 'AI & FUTURE TECH SUMMIT 2026',
            'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-3.png',
        ]);


    }
}
