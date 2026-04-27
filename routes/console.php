<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Models\Product;

Artisan::command('generate:sitemap', function () {

    $sitemap = Sitemap::create();

    // الصفحة الرئيسية
    $sitemap->add(Url::create(url('/'))->setPriority(1.0));

    // صفحة المنتجات
    $sitemap->add(Url::create(url('/product'))->setPriority(0.9));

    \Log::info('Sitemap: Starting generation...');

    // Count products first for debugging
    $count = Product::where('append', 1)->count();
    \Log::info("Sitemap: Found {$count} products with append=1.");

    // المنتجات + الصور
    Product::with('product_img_p')
        ->where('append', 1) // ✅ بدل is_active
        ->cursor()
        ->each(function ($product) use ($sitemap) {

            // ✅ Check if slug already contains full URL (from production DB)
            if (str_starts_with($product->slug, 'http://') || str_starts_with($product->slug, 'https://')) {
                $productUrl = $product->slug;
            } else {
                $productUrl = url("/product/{$product->slug}");
            }

            $urlTag = Url::create($productUrl)
                ->setPriority(0.8)
                ->setLastModificationDate($product->updated_at);

            // ✅ Fix: addImage expects string URL, not Image object
            if ($product->product_img_p) {
                // Main Image
                if (!empty($product->product_img_p->mainImage)) {
                    $imageUrl = (str_starts_with($product->product_img_p->mainImage, 'http://') || str_starts_with($product->product_img_p->mainImage, 'https://'))
                        ? $product->product_img_p->mainImage
                        : asset($product->product_img_p->mainImage);
                    
                    $urlTag->addImage(
                        $imageUrl,
                        '', // caption
                        '', // geo_location
                        $product->name // title
                    );
                }

                // Additional Images (img2, img3, img4)
                foreach (['img2', 'img3', 'img4'] as $imgField) {
                    if (!empty($product->product_img_p->$imgField)) {
                        $imageUrl = (str_starts_with($product->product_img_p->$imgField, 'http://') || str_starts_with($product->product_img_p->$imgField, 'https://'))
                            ? $product->product_img_p->$imgField
                            : asset($product->product_img_p->$imgField);
                        
                        $urlTag->addImage(
                            $imageUrl,
                            '', // caption
                            '', // geo_location
                            $product->name // title
                        );
                    }
                }
            }

            $sitemap->add($urlTag);
        });

    $sitemap->writeToFile(public_path('sitemap.xml'));

    $this->info('Sitemap generated successfully!');

})->purpose('Generate sitemap.xml for the website');


// ✅ نفس اسم الأمر بالظبط
Schedule::command('generate:sitemap')->hourly();

