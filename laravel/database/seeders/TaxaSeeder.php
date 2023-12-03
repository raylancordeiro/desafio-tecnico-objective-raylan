<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('taxas')->insert([
            ['forma_pagamento' => 'D', 'porcentagem' => 1.03],
            ['forma_pagamento' => 'C', 'porcentagem' => 1.05],
            ['forma_pagamento' => 'P', 'porcentagem' => 1],
        ]);
    }
}
