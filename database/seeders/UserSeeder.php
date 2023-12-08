<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "ტესტ ტესტ",
            "email" => "test@rda.gov.ge",
            "password" => bcrypt("1234567")
        ]);
    }
}
