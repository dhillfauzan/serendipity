<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SmartPenjualan;

class SmartPenjualanSeeder extends Seeder
{
    public function run(): void
    {
        if (SmartPenjualan::count() === 0) {
            foreach (SmartPenjualan::dataAwalSerendipity() as $i => $item) {
                $item['kode_alternatif'] = 'A' . ($i + 1);
                SmartPenjualan::create($item);
            }
        }
    }
}

