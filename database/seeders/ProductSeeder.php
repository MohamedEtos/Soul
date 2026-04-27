<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Existing products
            [
                'name' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-chiffon-veil',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 150,
                'append' => 1,
                'meta_title' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb-veil',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb2-veil',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb3-veil2',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-chiffon-veil3',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 150,
                'append' => 1,
                'meta_title' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb-veil4',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb2-veil5',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb3-veil7',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-chiffon-veil8',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 150,
                'append' => 1,
                'meta_title' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه شيفون فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb-veil5',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb2-veil4',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
            [
                'name' => 'ملابسه كريب فاخره مطرزه يدوي',
                'slug' => 'luxury-embroidered-kreb3-veil6',
                'cat_id' => 1,
                'fabric_id' => 1,
                'width' => 75,
                'height' => 180,
                'price' => 200,
                'append' => 1,
                'meta_title' => 'ملابسه كريب فاخره مطرزه يدوي',
                'meta_description' => 'ملابسه كريب فاخره مطرزه يدوي',
                'productDetalis' => 'ملابسه كريب فاخره مطرزه يدوي',
                'stock' => 10,
            ],
        ];





        DB::table('products')->insert($products);
     }
}
