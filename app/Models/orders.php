<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $guarded= [];

    public function items()
    {
        return $this->hasMany(Order_items::class ,'order_id');
    }

    public function address()
    {
        return $this->hasOne(Order_addresses::class ,'order_id');
    }

}
