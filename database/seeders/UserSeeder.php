<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
            for ($i=0; $i < 10; $i++) {
                User::create([
                    "name" => $faker->name(),
                    "email" => $faker->unique()->safeEmail(),
                    'role_id' => 1,
                    'password' => Hash::make("password"),
                ]);
            }
    }
}
