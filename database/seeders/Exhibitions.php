<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exhibition;
use Carbon\Carbon;

class Exhibitions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exhibition::insert([
            ["title" => "გამოფენა 1", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["title" => "გამოფენა 2", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["title" => "გამოფენა 3", "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
        ]);
    }
}
