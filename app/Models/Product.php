<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;


class Product extends Model
{
    Protected $guarded= [];


protected static function booted()
{
    static::creating(function ($product) {

        if (empty($product->slug)) {

            // 1️⃣ توليد slug من الاسم
            $slug = Str::slug($product->name, '-');

            // 2️⃣ لو الاسم عربي
            if ($slug === '') {
                $slug = preg_replace('/\s+/u', '-', trim($product->name));
            }

            // 3️⃣ منع التكرار
            $originalSlug = $slug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $product->slug = $slug;
        }
    });
}


    public function Category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }



    public function fabricType()
    {
        return $this->belongsTo(FabricType::class, 'fabric_id');
    }



    public function product_img_p()
    {
        return $this->hasOne(Prodimg::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_approved', 1)->avg('rating') ?: 0;
    }

    public function getApprovedReviewsCountAttribute()
    {
        return $this->reviews()->where('is_approved', 1)->count();
    }

    //SEO Attributes

        public function getSeoTitleAttribute()
    {
        return $this->meta_title ?: $this->name . ' | ' . config('app.name');
    }

    public function getSeoDescriptionAttribute()
    {
        return $this->meta_description ?: str($this->description)->limit(160);
    }

    public function getSeoImageAttribute()
    {
        return $this->meta_image
            ? asset('storage/'.$this->meta_image)
            : asset('storage/'.$this->image);
    }

}
