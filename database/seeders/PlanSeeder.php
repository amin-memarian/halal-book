<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create(['title' => 'ماهانه', 'price' => 100000, 'days' => 30]);
        Plan::create(['title' => 'سالانه', 'price' => 800000, 'days' => 365]);
    }
}
