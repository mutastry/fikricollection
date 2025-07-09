<?php

namespace Database\Seeders;

use App\Models\Songket;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SongketSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $songkets = [
            [
                'name' => 'Songket Lepus Emas Klasik',
                'description' => 'Songket Lepus dengan benang emas murni, menampilkan motif tradisional yang telah diwariskan turun temurun. Cocok untuk acara pernikahan dan upacara adat.',
                'base_price' => 2500000,
                'colors' => ['#FFD700', '#8B0000', '#000080'],
                'is_featured' => true,
                'stock_quantity' => 15,
            ],
            [
                'name' => 'Songket Bungo Pacik Perak',
                'description' => 'Songket dengan motif bunga pacik yang indah, ditenun dengan benang perak berkualitas tinggi. Memberikan kesan elegan dan mewah.',
                'base_price' => 1800000,
                'colors' => ['#C0C0C0', '#800080', '#006400'],
                'is_featured' => true,
                'stock_quantity' => 20,
            ],
            [
                'name' => 'Songket Limar Geometris',
                'description' => 'Songket Limar dengan pola geometris yang simetris, mencerminkan keahlian tinggi pengrajin Palembang dalam menciptakan karya seni tekstil.',
                'base_price' => 2200000,
                'colors' => ['#FFD700', '#8B4513', '#4B0082'],
                'is_featured' => false,
                'stock_quantity' => 12,
            ],
            [
                'name' => 'Songket Tawur Mewah',
                'description' => 'Songket Tawur dengan motif bertaburan yang memberikan kesan kemewahan. Ideal untuk acara formal dan perayaan khusus.',
                'base_price' => 3000000,
                'colors' => ['#FFD700', '#DC143C', '#191970'],
                'is_featured' => true,
                'stock_quantity' => 8,
            ],
            [
                'name' => 'Songket Kombinasi Modern',
                'description' => 'Perpaduan motif tradisional dengan sentuhan modern, menciptakan songket yang cocok untuk generasi muda yang tetap menghargai budaya.',
                'base_price' => 1500000,
                'colors' => ['#FF6347', '#4169E1', '#32CD32'],
                'is_featured' => false,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'Songket Lepus Premium',
                'description' => 'Songket Lepus kualitas premium dengan detail yang sangat halus. Menggunakan benang emas 24 karat untuk hasil yang berkilau sempurna.',
                'base_price' => 4500000,
                'colors' => ['#FFD700', '#8B0000'],
                'is_featured' => true,
                'stock_quantity' => 5,
            ],
            [
                'name' => 'Songket Bungo Pacik Warna Warni',
                'description' => 'Songket Bungo Pacik dengan variasi warna yang cerah dan menarik, cocok untuk acara yang lebih kasual namun tetap elegan.',
                'base_price' => 1200000,
                'colors' => ['#FF69B4', '#00CED1', '#FFD700', '#9370DB'],
                'is_featured' => false,
                'stock_quantity' => 30,
            ],
            [
                'name' => 'Songket Limar Antik',
                'description' => 'Reproduksi songket Limar dengan motif antik yang langka. Dibuat dengan teknik tradisional yang autentik.',
                'base_price' => 3500000,
                'colors' => ['#8B4513', '#2F4F4F', '#FFD700'],
                'is_featured' => true,
                'stock_quantity' => 6,
            ],
        ];

        foreach ($songkets as $index => $songketData) {
            $category = $categories->get($index % $categories->count());

            Songket::create([
                'category_id' => $category->id,
                'name' => $songketData['name'],
                'slug' => Str::slug($songketData['name']),
                'description' => $songketData['description'],
                'base_price' => $songketData['base_price'],
                'colors' => $songketData['colors'],
                'images' => [
                    '/placeholder.svg?height=600&width=600',
                    '/placeholder.svg?height=600&width=600',
                    '/placeholder.svg?height=600&width=600',
                ],
                'is_featured' => $songketData['is_featured'],
                'is_active' => true,
                'stock_quantity' => $songketData['stock_quantity'],
            ]);
        }
    }
}
