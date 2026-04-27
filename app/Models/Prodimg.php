<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodimg extends Model
{
    Protected $guarded= [];

    public function product_img()
{
    return $this->belongsTo(Product::class);
}
}
