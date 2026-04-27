<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    protected $guarded= [];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

        public function Order()
{
    return $this->belongsTo(Orders::class);
}

}
