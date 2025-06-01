<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BungalowSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bungalows')->insert([
            [
                'name' => 'Bungalow do Sol',
                'description' => 'Um refúgio acolhedor com vista para o pôr do sol.',
                'price_per_night' => 80.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bungalow das Montanhas',
                'description' => 'Relaxe em meio às montanhas com todo o conforto.',
                'price_per_night' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bungalow Tropical',
                'description' => 'Cercado por natureza exótica e clima quente.',
                'price_per_night' => 120.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('✅ Bungalows inserted!');
    }
}
