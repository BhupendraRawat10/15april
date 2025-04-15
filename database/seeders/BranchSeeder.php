<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('branches')->insert([
            ['branch_name' => 'Main Office', 'location' => 'New Delhi', 'created_at' => now(), 'updated_at' => now()],
            ['branch_name' => 'Regional Office', 'location' => 'Mumbai', 'created_at' => now(), 'updated_at' => now()],
            ['branch_name' => 'Support Center', 'location' => 'Bangalore', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
