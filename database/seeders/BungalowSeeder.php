<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BungalowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bungalows')->insert([
            [
                'name' => 'Bungalow do Sol',
                'description' => 'Um refúgio acolhedor com vista para o pôr do sol, ideal para casais. Desfrute de noites estreladas e manhãs tranquilas.',
                'image_url' => 'https://placehold.co/600x400/FFD700/FFFFFF?text=Bungalow+Sol', // Example placeholder URL
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 80.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bungalow das Montanhas',
                'description' => 'Relaxe em meio às montanhas com todo o conforto. Perfeito para aventureiros e amantes da natureza, com trilhos próximos.',
                'image_url' => 'https://placehold.co/600x400/8B4513/FFFFFF?text=Bungalow+Montanhas', // Example placeholder URL
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bungalow Tropical',
                'description' => 'Cercado por natureza exótica e clima quente. Uma fuga perfeita para o paraíso, com piscina privada e áreas de lazer.',
                'image_url' => 'https://placehold.co/600x400/008080/FFFFFF?text=Bungalow+Tropical', // Example placeholder URL
                'bedrooms' => 3,
                'beds' => 3,
                'bathrooms' => 2,
                'accommodates' => 6,
                'price_per_night' => 120.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // --- 20 New Bungalow Insertions ---
            [
                'name' => 'Refúgio da Cascata',
                'description' => 'Um retiro tranquilo junto a uma cascata natural. Desperta com o som da água e mergulha na serenidade da floresta.',
                'image_url' => 'https://placehold.co/600x400/2F4F4F/FFFFFF?text=Cascata',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 95.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cabana Estrelada',
                'description' => 'Ideal para observadores de estrelas, com teto de vidro e telescópio. Uma experiência única de imersão no céu noturno.',
                'image_url' => 'https://placehold.co/600x400/1A2A3A/FFFFFF?text=Estrelada',
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 110.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aconchego do Rio',
                'description' => 'Localizado à beira-rio, perfeito para pesca e desportos aquáticos. Desfruta de um churrasco ao pôr do sol.',
                'image_url' => 'https://placehold.co/600x400/4682B4/FFFFFF?text=Rio',
                'bedrooms' => 3,
                'beds' => 4,
                'bathrooms' => 2,
                'accommodates' => 6,
                'price_per_night' => 130.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vista Panorâmica',
                'description' => 'Desfruta de vistas deslumbrantes do vale e da cidade a partir de cada janela. Mobiliário moderno e elegante.',
                'image_url' => 'https://placehold.co/600x400/6A5ACD/FFFFFF?text=Panoramica',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 140.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ninho do Cuco',
                'description' => 'Pequeno e pitoresco, escondido no coração da floresta. Ideal para uma escapadela romântica e tranquila.',
                'image_url' => 'https://placehold.co/600x400/A0522D/FFFFFF?text=Cuco',
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 75.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chalet da Floresta',
                'description' => 'Rodeado por árvores centenárias, este chalé oferece privacidade e paz. Lareira acolhedora para noites frias.',
                'image_url' => 'https://placehold.co/600x400/228B22/FFFFFF?text=Floresta',
                'bedrooms' => 3,
                'beds' => 3,
                'bathrooms' => 2,
                'accommodates' => 6,
                'price_per_night' => 150.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oceano Azul',
                'description' => 'A poucos passos da praia, com vistas diretas para o mar. Sente a brisa e ouve as ondas à noite.',
                'image_url' => 'https://placehold.co/600x400/1E90FF/FFFFFF?text=Oceano',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 160.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Serra Dourada',
                'description' => 'Localizado nas alturas da serra, com trilhos para caminhadas e flora exuberante. Ideal para amantes da natureza.',
                'image_url' => 'https://placehold.co/600x400/B8860B/FFFFFF?text=Serra',
                'bedrooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'accommodates' => 5,
                'price_per_night' => 115.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Varanda do Céu',
                'description' => 'Um espaço arejado com uma varanda espaçosa e vista para o horizonte. Perfeito para pequenos grupos.',
                'image_url' => 'https://placehold.co/600x400/87CEEB/FFFFFF?text=Varanda',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 105.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Esconderijo Secreto',
                'description' => 'Um bungalow isolado para máxima privacidade e fuga do mundo. Sem distrações, apenas paz.',
                'image_url' => 'https://placehold.co/600x400/36454F/FFFFFF?text=Secreto',
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 90.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vale Verde',
                'description' => 'Situado num vale luxuriante, ideal para passeios e piqueniques. A vida selvagem é abundante por perto.',
                'image_url' => 'https://placehold.co/600x400/32CD32/FFFFFF?text=Vale',
                'bedrooms' => 2,
                'beds' => 3,
                'bathrooms' => 1,
                'accommodates' => 5,
                'price_per_night' => 118.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Miradouro da Paz',
                'description' => 'Com um miradouro privado, oferece vistas espetaculares e uma sensação de calma inigualável. Perfeito para meditação.',
                'image_url' => 'https://placehold.co/600x400/663399/FFFFFF?text=Paz',
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pôr do Sol Dourado',
                'description' => 'Este bungalow é famoso pelos seus incríveis pores do sol. Desfruta de um terraço espaçoso e cozinha equipada.',
                'image_url' => 'https://placehold.co/600x400/DAA520/FFFFFF?text=Dourado',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 2,
                'accommodates' => 4,
                'price_per_night' => 125.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canto do Passarinho',
                'description' => 'Pequeno e acolhedor, onde se pode ouvir o canto dos pássaros pela manhã. Ideal para uma escapadela rápida.',
                'image_url' => 'https://placehold.co/600x400/90EE90/FFFFFF?text=Passarinho',
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 85.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alojamento do Guarda-rios',
                'description' => 'Perto de um pequeno rio, perfeito para observar a vida selvagem. Ambiente rústico e autêntico.',
                'image_url' => 'https://placehold.co/600x400/00CED1/FFFFFF?text=Guarda-rios',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 98.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Retiro na Vinha',
                'description' => 'Localizado numa pitoresca vinha, com degustações de vinho e passeios pelas paisagens. Tranquilidade e bom vinho.',
                'image_url' => 'https://placehold.co/600x400/800020/FFFFFF?text=Vinha',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 135.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Farol do Mar',
                'description' => 'Com uma decoração inspirada no mar, oferece vistas parciais para o oceano e fácil acesso à praia. Areia e sol garantidos.',
                'image_url' => 'https://placehold.co/600x400/4169E1/FFFFFF?text=Farol',
                'bedrooms' => 3,
                'beds' => 3,
                'bathrooms' => 2,
                'accommodates' => 6,
                'price_per_night' => 170.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Oasis Urbano',
                'description' => 'Um oásis de tranquilidade no centro da cidade, com um pequeno jardim privado. Combina conveniência com relaxamento.',
                'image_url' => 'https://placehold.co/600x400/696969/FFFFFF?text=Urbano',
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Terraço dos Ventos',
                'description' => 'Com um terraço elevado que proporciona vistas desimpedidas e uma brisa constante. Ideal para descontrair ao ar livre.',
                'image_url' => 'https://placehold.co/600x400/778899/FFFFFF?text=Ventos',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 112.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Encanto Rural',
                'description' => 'Um bungalow charmoso com toque rústico, rodeado por campos e natureza. Experimenta a vida no campo.',
                'image_url' => 'https://placehold.co/600x400/B0E0E6/FFFFFF?text=Rural',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 88.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ponto de Luz',
                'description' => 'Pequeno, mas cheio de luz natural e com um design moderno. Perfeito para uma escapadela minimalista e revigorante.',
                'image_url' => 'https://placehold.co/600x400/F0E68C/FFFFFF?text=Luz',
                'bedrooms' => 1,
                'beds' => 1,
                'bathrooms' => 1,
                'accommodates' => 2,
                'price_per_night' => 95.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Refúgio Silencioso',
                'description' => 'Um local calmo e isolado, ideal para quem procura paz e sossego. Sem ruídos, apenas a natureza.',
                'image_url' => 'https://placehold.co/600x400/708090/FFFFFF?text=Silencioso',
                'bedrooms' => 1,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 3,
                'price_per_night' => 92.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maravilha do Lago',
                'description' => 'Com vistas diretas para um lago sereno, ideal para atividades aquáticas não motorizadas e relaxamento.',
                'image_url' => 'https://placehold.co/600x400/ADD8E6/FFFFFF?text=Lago',
                'bedrooms' => 2,
                'beds' => 2,
                'bathrooms' => 1,
                'accommodates' => 4,
                'price_per_night' => 128.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('✅ Bungalows inserted!');
    }
}
