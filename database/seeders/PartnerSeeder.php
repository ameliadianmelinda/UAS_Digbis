<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;
use App\Models\User;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {

            $user = User::updateOrCreate([
                'email' => "tenant{$i}@example.test",
            ], [
                'name' => fake()->name(),
                'password' => 'password',
                'role' => User::ROLE_TENANT,
                'status' => User::STATUS_ACTIVE,
            ]);

            Partner::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'name' => fake()->company(),
                'logo_url' => 'https://placehold.co/200x200',
                'email' => $user->email,
                'status' => User::STATUS_ACTIVE,
            ]);

        }
    }
}
