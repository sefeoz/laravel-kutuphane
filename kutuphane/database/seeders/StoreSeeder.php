<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'name' => 'D&R',
                'address' => 'İstanbul',
                'phone' => '+90 212 000 0000',
                'email' => 'info@dr.com.tr',
                'website' => 'https://www.dr.com.tr',
            ],
            [
                'name' => 'Kitapyurdu',
                'address' => 'İstanbul',
                'phone' => '+90 212 000 0001',
                'email' => 'info@kitapyurdu.com',
                'website' => 'https://www.kitapyurdu.com',
            ],
            [
                'name' => 'Amazon',
                'address' => 'İstanbul',
                'phone' => '+90 212 000 0002',
                'email' => 'info@amazon.com',
                'website' => 'https://www.amazon.com.tr',
            ],
            [
                'name' => 'Trendyol',
                'address' => 'İstanbul',
                'phone' => '+90 212 000 0003',
                'email' => 'info@trendyol.com',
                'website' => 'https://www.trendyol.com',
            ],
            [
                'name' => 'Hepsiburada',
                'address' => 'İstanbul',
                'phone' => '+90 212 000 0004',
                'email' => 'info@hepsiburada.com',
                'website' => 'https://www.hepsiburada.com',
            ],
        ];

        foreach ($stores as $store) {
            Store::firstOrCreate(['name' => $store['name']], $store);
        }
    }
}
