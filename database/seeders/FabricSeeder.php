<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FabricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fabrics = [
            ['name' => 'شيفون'],
            ['name' => 'كريب'],
            ['name' => 'ساتان'],
            ['name' => 'حرير'],
            ['name' => 'قطن'],

        ];

        DB::table('fabric_types')->insert($fabrics);
    }
}
