<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Songket Lepus',
                'description' => 'Traditional Songket Lepus with intricate gold thread patterns, perfect for formal occasions and ceremonies.',
                'is_active' => true,
            ],
            [
                'name' => 'Songket Bungo Pacik',
                'description' => 'Beautiful Songket Bungo Pacik featuring delicate floral motifs woven with gold and silver threads.',
                'is_active' => true,
            ],
            [
                'name' => 'Songket Limar',
                'description' => 'Classic Songket Limar with geometric patterns, representing the rich heritage of Palembang craftsmanship.',
                'is_active' => true,
            ],
            [
                'name' => 'Songket Tawur',
                'description' => 'Elegant Songket Tawur with scattered motifs, ideal for special events and traditional celebrations.',
                'is_active' => true,
            ],
            [
                'name' => 'Songket Kombinasi',
                'description' => 'Modern combination Songket blending traditional patterns with contemporary designs.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }
    }
}
