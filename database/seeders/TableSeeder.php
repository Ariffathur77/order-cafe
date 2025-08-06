<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tables')->insert([
            ['name' => 'Meja 1', 'slug' => 'meja-1'],
            ['name' => 'Meja 2', 'slug' => 'meja-2'],
        ]);
    }
}
